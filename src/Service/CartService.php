<?php

namespace App\Service;

class CartService
{
    protected $cart;

    public function getCart()
    {
        if ($this->cart === null) {
            $this->cart = $_SESSION['cart'];
        }
        return $this->cart;
    }

    public function addToCart($product)
    {
        $cart = $this->getCart();

        if (array_key_exists($product['id'], $cart['products'])) {
            $cart['products'][$product['id']]['quantity']++;
        } else {
            $cart['products'][$product['id']] = [
                'id' => $product['id'],
                'quantity' => 1,
                'price' => $product['price'],
            ];
        }
        $cart['total'] = $this->calculTotal($cart['products']);

        return $cart;
    }

    public function deleteFromCart($product)
    {
        $cart = $this->getCart();
        unset($cart['products'][$product['id']]);

        $cart['total'] = $this->calculTotal($cart['products']);

        return $cart;
    }

    public function calculTotal($products)
    {
        $total = 0;
        foreach ($products as $product) {
            $total += $product['price'] * $product['quantity'];
        }
        return $total;
    }

    public function initCart()
    {
        return [
            'products' => [],
            'total' => 0,
        ];
    }

    public function clearCart()
    {
        $_SESSION['cart'] = $this->initCart();
    }

    public function getSuccessMessage()
    {
        $message = [];
        $message['message'] = 'Ton acticle a bien été placé dans ton panier';
        $message['class'] = 'info';
        return $message;
    }

    public function getErrorMessage()
    {
        $message = [];
        $message['message'] = 'Ton acticle n\'a pas été dans ton panier';
        $message['class'] = 'warning';
        return $message;
    }
}
