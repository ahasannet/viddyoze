<?php

namespace App\Service;


use App\Repository\DiscountRepository;

class DiscountService
{

    private $repository;
    
    public function __construct(DiscountRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function findOneByProductId($productId) {
        return $this->repository->findOneBy(array('product_id'=>$productId));
    }
    
}

