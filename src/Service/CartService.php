<?php

namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;

class CartService
{
    private $entityManager;
    private $productService;
    private $orderService;
    
    public function __construct(EntityManagerInterface $entityManager, ProductService $productService, OrderService $orderService)
    {
        $this->entityManager = $entityManager;
        $this->productService = $productService;
        $this->orderService = $orderService;
    }
    
    public function addToCart($code) {
        $product = $this->productService->findOneBy(array('code'=>$code));
        
        $this->orderService->add($product);
        
        $product->setStock($product->getStock() - 1);
        $this->productService->updateStock($product);
    }
    
    public function removeFromCart($code) {
        $product = $this->productService->findOneBy(array('code'=>$code));
        
        $this->orderService->remove($product);
        
        $product->setStock($product->getStock() + 1);
        $this->productService->updateStock($product);
    }
    
}

