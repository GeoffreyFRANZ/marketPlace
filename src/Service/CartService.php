<?php

namespace App\Service;


use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private RequestStack $request;
    private ProductRepository $productRepository;

    public function __construct(RequestStack $request, ProductRepository $productRepository)
    {
        $this->request = $request;
        $this->productRepository = $productRepository;
    }

    public function  listProduct(array $cart) :?array
    {
        $productRepository = $this->productRepository;
        $list = [];
        if (empty($cart) === false) {
            foreach ($cart as $k => $v) {
                $list[] = ['product' => $productRepository->findOneBy(['id' => $k]), 'quantity' => $v];
            }
        }
        return $list;
    }

    public function add(int $id) :void
    {

        $session = $this->request->getSession();
        $cart = $session->get('cart', []);

        if (empty($cart[$id]) === false) {
            $cart[$id]++;
        }
        elseif (empty($cart[$id]) === true) {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);

    }

    public  function remove(int $id) :void
    {
        $session = $this->request->getSession();
        $cart = $session->get('cart', []);

        if (empty($cart[$id]) === false && $cart[$id] > 1) {
            $cart[$id]--;
        }
        elseif (empty($cart[$id]) === false && $cart[$id] === 1) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);
    }

    public function removeAll(int$id) :void
    {
        $session = $this->request->getSession();
        $cart = $session->get('cart', []);

        unset($cart[$id]);

        $session->set('cart', $cart);
    }

    public function getTotal(array $list) :?float
    {
        $total = null;
        foreach ($list as $k => $v) {
            $total += $v['product']->getPrice() * $v['quantity'];
        }

        return $total;
    }

}