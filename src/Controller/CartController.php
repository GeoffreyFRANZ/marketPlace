<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, CartService $cartService): Response
    {
        $cart = $session->get('cart');
        $list = $cartService->listProduct($cart);
        $total =  $cartService->getTotal($list);

        return $this->render('cart/index.html.twig', [
            'list' => $list,
            'total' => $total
        ]);
    }

    #[Route('/cart/new/{id}', name: 'app_cart_new' )]
    public  function new(int $id, CartService $cartService) :response
    {
        $cartService->add($id);
        return $this->redirectToRoute('app_cart');

    }
    #[Route('/cart/delete/{id}', name: 'app_cart_delete')]
    public function delete(int $id, CartService $cartService) :response
    {
        $cartService->remove($id);
        return  $this->redirectToRoute('app_cart');
    }
    #[Route('cart/deleteAll/{id}', name: 'app_cart_delete_all')]
    public function deleteAll(int $id, CartService $cartService) :response
    {
        $cartService->removeAll($id);
        return $this->redirectToRoute('app_cart');
    }
}
