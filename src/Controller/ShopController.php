<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductService;
use App\Service\OrderService;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop", name="shop")
     */
    public function index(ProductService $productService, OrderService $orderService)
    {
        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'data'  => $productService->findAll(),
            'total' => $orderService->getOrderAmount()
        ]);
    }
}
