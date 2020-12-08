<?php

namespace App\Controller;

use App\Model\ShopManager;
use App\Model\ImageManager;

class ShopController extends AbstractController
{
    public function list()
    {
        $shopManager = new ShopManager();
        $imageManager = new ImageManager();

        $products = $shopManager->selectAll();
        foreach ($products as $key => $product) {
            $image = $imageManager->getOneByParentIdAndType($product['id'], 'shop');
            if (isset($image['id'])) {
                $products[$key]['img_path'] = $image['img_path'];
            }
        }

        $message = $_SESSION['message'] ?? null;

        if ($message) {
            $_SESSION['message'] = '';
        }
        return $this->twig->render('Shop/show.html.twig', ['products' => $products, 'message' => $message]);
    }
}
