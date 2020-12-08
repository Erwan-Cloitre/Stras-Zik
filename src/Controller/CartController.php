<?php

namespace App\Controller;

use App\Model\CartManager;
use App\Model\ShopManager;
use App\Service\CartService;
use App\Model\ImageManager;

use function Composer\Autoload\includeFile;

class CartController extends AbstractController
{
    public function listCart()
    {
        $cartService = new CartService();
        $cart = $cartService->getCart();
        if (empty($cart['products'])) {
            return $this->twig->render('Cart/show.html.twig', ['listProductsCart' => '']);
        }
        $productManager = new ShopManager();
        $imageManager = new ImageManager();

        $productIds = array_keys($cart['products']);
        $products = $productManager->getByIds($productIds);

        $data = [];
        $cartProducts = [];
        foreach ($products as $product) {
            $image = $imageManager->getOneByParentIdAndType($product['id'], 'shop');
            $productId = $product['id'];
            $cartProducts[$productId] = [
                'id' => $productId,
                'title' => $product['title'],
                'price' => $product['price'],
                'quantity' => $cart['products'][$productId]['quantity'],
                'total_row' => (float)$product['price'] * (float)$cart['products'][$productId]['quantity'],
                'image' => $image['img_path'],
            ];
        }

        $data['products'] = $cartProducts;
        $data['total'] = $cart['total'];
        return $this->twig->render('Cart/show.html.twig', ['productsData' => $data]);
    }

    public function addProduct($productId)
    {
        $cartService = new CartService();
        $productManager = new ShopManager();
        $product = $productManager->selectOneById((int) $productId);

        if ($product) {
            $cart = $cartService->addToCart($product);
            $_SESSION['cart'] = $cart;
            $message = $cart ? $cartService->getSuccessMessage() : $cartService->getErrorMessage();
            $_SESSION['message'] = $message;
        }

        header('Location:/Shop/list');
    }

    public function deleteProductsCart($productId)
    {
        $cartService = new CartService();
        $productManager = new ShopManager();
        $product = $productManager->selectOneById((int) $productId);
        if ($product) {
            $cart = $cartService->deleteFromCart($product);
            $_SESSION['cart'] = $cart;
        }
        header('Location:/Cart/listcart');
    }

    public function saveCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartManager = new CartManager();

            $cart = [
                'nb_items' => 0,
                'quantity_items' => 0,
                'total' => $_POST['total'],
                'subtotal' => $_POST['subtotal'],
                'shipping_fee' => $_POST['shipping_fee'],
                'id_user' => $_SESSION['user_id'],
            ];

            foreach ($_POST['cart'] as $product) {
                $cart['nb_items']++;
                $cart['quantity_items'] += $product['quantity'];
            }

            $cartId = $cartManager->insertCart($cart);

            if (!$cartId) {
                $_SESSION['message'] = "Une erreur est survenue, merci de re-confirmer votre panier";
                header('Location:/Cart/listcart');
                return;
            }
            foreach ($_POST['cart'] as $product) {
                $product['cart_id'] = $cartId;
                $cartManager->insertItemsCart($product);
            }
            $cartService = new CartService();
            $cartService->clearCart();
            $_SESSION['message'] = "";

            return $this->twig->render('Cart/success.html.twig');
        }
    }
}
