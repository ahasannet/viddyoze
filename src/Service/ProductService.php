<?php

namespace App\Service;


use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductService 
{
    private $entityManager;
    
    private $repository;
    
    public function __construct(EntityManagerInterface $entityManager, ProductRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }
    
    public function findAll() {
        return $this->repository->findAll();
    }
    
    public function findOneBy($criteria) {
        return $this->repository->findOneBy($criteria);
    }
    
    public function updateStock($product) {
        $product->setUpdated(new \DateTime());
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
    
}

