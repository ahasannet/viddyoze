<?php

namespace App\Service;


use App\Repository\ShipmentRepository;

class ShipmentService
{

    private $repository;
    
    public function __construct(ShipmentRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function findAll() {
        return $this->repository->findAll();
    }
    
}

