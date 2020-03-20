<?php

namespace App\Service;


use App\Repository\OrderItemRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderItemService
{

    private $entityManager;
    private $repository;
    
    public function __construct(EntityManagerInterface $entityManager, OrderItemRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }
    
    public function findByOrderIdAndProductId($orderId, $productId) {
        return $this->repository->findOneBy(array('order_id'=>$orderId,'product_id'=>$productId));
    }
    
    public function findByOrderId($orderId) {
        return $this->repository->findBy(array('order_id'=>$orderId));
    }
    
    public function save($orderItem) {
        if($orderItem->getId() == null) {
            $orderItem->setCreated(new \DateTime());
        }
        $orderItem->setUpdated(new \DateTime());
        $this->entityManager->persist($orderItem);
        $this->entityManager->flush();
    }
    
    public function remove($orderItem) {
        $this->entityManager->remove($orderItem);
        $this->entityManager->flush();
    }
    
}

