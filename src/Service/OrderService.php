<?php

namespace App\Service;


use App\Entity\OrderItem;
use App\Entity\Orders;
use App\Repository\OrdersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrderService
{
    private $entityManager;
    private $orderItemService;
    private $discountService;
    private $shipmentService;
    private $repository;
    private $session;
    private $order;
    
    public function __construct(EntityManagerInterface $entityManager, OrdersRepository $repository, OrderItemService $orderItemService, DiscountService $discountService, ShipmentService $shipmentService, SessionInterface $session)
    {
        $this->entityManager = $entityManager;
        $this->orderItemService = $orderItemService;
        $this->discountService = $discountService;
        $this->shipmentService = $shipmentService;
        $this->repository = $repository;
        $this->session = $session;
        $this->session->start();
        $this->order = $this->getCurrentOrder();
    }
    
    public function add($product) {
        $orderItem = $this->getOrderItem($product);
        $quantity = 1;
        if($orderItem != null) {
            $quantity += $orderItem->getQuantity();
        } else {
            $orderItem = new OrderItem();
            $orderItem->setProductId($product->getId());
            $orderItem->setUnitPrice($product->getPrice());
        }
        $orderItem->setQuantity($quantity);
        $orderItem->setDiscount($this->calculateItemDiscount($product, $quantity));
        $orderItem->setTotal($product->getPrice() * $quantity - $orderItem->getDiscount());
        
        if($this->order->getId() == null) {
            $this->addNewOrder($product, $orderItem);
        } 
        
        $orderItem->setOrderId($this->order->getId());
        $this->orderItemService->save($orderItem);
        
        if($this->order->getId() != null) {
            $this->updateOrder();
        }
        
    }
    
    public function remove($product) {
        $orderItem = $this->getOrderItem($product);
        $quantity = $orderItem->getQuantity() - 1;
        if($quantity == 0) {
            $this->orderItemService->remove($orderItem);
        } else {
            $orderItem->setQuantity($quantity);
            $orderItem->setDiscount($this->calculateItemDiscount($product, $quantity));
            $orderItem->setTotal($product->getPrice() * $quantity - $orderItem->getDiscount());
            $this->orderItemService->save($orderItem);
        }
        $this->updateOrder();
    }
    
    public function getCurrentOrder() {
        $this->order = $this->repository->findOneBy(array('pc_id'=>$this->session->getId()));
        if($this->order == null) {
            $this->order = new Orders();
        }
    }
    
    public function getOrderAmount() {
        $amount = 0;
        $order = $this->repository->findOneBy(array('pc_id'=>$this->session->getId()));
        if($order != null) {
            $amount = $order->getTotal();
        }
        return $amount;
    }
    
    public function getOrderItem($product)
    {
        $this->getCurrentOrder();
        if($this->order->getId() != null) {
            return $this->orderItemService->findByOrderIdAndProductId($this->order->getId(), $product->getId());
        } else {
            return null;
        }
    }
    
    public function calculateItemDiscount($product, $quantity)
    {
        $discount = $this->discountService->findOneByProductId($product->getId());
        $amount = 0;
        if($discount != null) {
            if($quantity >= $discount->getQuantity()) {
                if($discount->getPercent() > 0) {
                    $amount = ($product->getPrice() * $discount->getPercent()) / 100;
                } else if($discount->getAmount() > 0) {
                    $amount = $product->getPrice() - $discount->getAmount();
                } 
            }
        }
        return $amount;
    }
    
    public function calculateShipment($amount)
    {
        $shipmentArray = $this->shipmentService->findAll();
        $shippingCost = 4.95;
        foreach ($shipmentArray as $shipment) {
            if($shippingCost > $shipment->getCost() && $amount >= $shipment->getOrderAmount()) {
                $shippingCost = $shipment->getCost();
            }
        }
        return $shippingCost;
    }
    
    public function addNewOrder($product, $orderItem) {
        $this->order->setPcId($this->session->getId());
        $this->order->setDiscount($orderItem->getDiscount());
        $this->order->setShipment($this->calculateShipment($product->getPrice()));
        $this->order->setTotal($product->getPrice() - $orderItem->getDiscount() + $this->order->getShipment());
        $this->order->setCreated(new \DateTime());
        $this->order->setUpdated(new \DateTime());
        $this->entityManager->persist($this->order);
        $this->entityManager->flush();
        $this->order = $this->repository->findOneBy(array('pc_id'=>$this->session->getId()));
    }
    
    public function updateOrder() {
        $orderItemArray = $this->orderItemService->findByOrderId($this->order->getId());
        if(count($orderItemArray) == 0) {
            $this->entityManager->remove($this->order);
        } else {
            $amount = 0;
            foreach ($orderItemArray as $orderItem) {
                $amount += $orderItem->getTotal();
            }
            $this->order->setShipment($this->calculateShipment($amount));
            $this->order->setTotal($amount + $this->order->getShipment());
            $this->order->setUpdated(new \DateTime());
            $this->entityManager->persist($this->order);
        }
        $this->entityManager->flush();
    }
    
    public function getActiveOrder() {
        return $this->repository->findOneBy(array('pc_id'=>$this->session->getId()));
    }
    
    public function getActiveOrderItems() {
        $order = $this->repository->findOneBy(array('pc_id'=>$this->session->getId()));
        $orderItemArray = array();
        if($order != null) {
            $orderItemArray = $this->orderItemService->findByOrderId($order->getId());
        }
        return $orderItemArray;
    }
    
}

