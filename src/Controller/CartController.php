<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CartService;
use Symfony\Component\HttpFoundation\Request;
use App\Service\OrderService;
use App\Service\ProductService;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(ProductService $productService, OrderService $orderService)
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'products'  => $productService->findAll(),
            'order' => $orderService->getActiveOrder(),
            'orderItems' => $orderService->getActiveOrderItems()
        ]);
    }
    
    /**
     * @Route("/cart/add", name="cart.add")
     */
    public function addToCart(Request $request, CartService $service)
    {
        $service->addToCart($request->query->get('code'));
        return $this->redirect('/shop');
    }
    
    /**
     * @Route("/cart/update", name="cart.update")
     */
    public function updateCart(Request $request, CartService $service)
    {
        $service->addToCart($request->query->get('code'));
        return $this->redirect('/cart');
    }
    
    /**
     * @Route("/cart/remove", name="cart.remove")
     */
    public function removeFromCart(Request $request, CartService $service)
    {
        $service->removeFromCart($request->query->get('code'));
        return $this->redirect('/cart');
    }
    
}
