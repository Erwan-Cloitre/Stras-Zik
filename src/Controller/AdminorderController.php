<?php

namespace App\Controller;

use App\Model\CartManager;
use App\Model\UserManager;

class AdminorderController extends AbstractAdminController
{
    public function list()
    {
        $orderManager = new CartManager();
        $orders = $orderManager->selectCart();

        return $this->twig->render('Admin/Order/index.html.twig', ['orders' => $orders]);
    }

    public function orderDetails($id)
    {
        $orderManager = new CartManager();
        $orderData = $orderManager->selectOneById($id);
        $items = $orderManager->selectCartItems($id);
        $userManager = new UserManager();
        $user = $userManager->selectOneById($orderData['id_user']);

        return $this->twig->render('Admin/Order/order.html.twig', [
            'items' => $items,
            'order' => $orderData,
            'user' => $user
        ]);
    }
}
