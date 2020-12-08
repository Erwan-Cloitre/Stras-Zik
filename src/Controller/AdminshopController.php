<?php

namespace App\Controller;

use App\Model\ShopManager;
use App\Model\ImageManager;
use App\Service\ValidationService;
use App\Service\UploadService;

class AdminshopController extends AbstractAdminController
{
    public function listShop()
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

        return $this->twig->render('Admin/Shop/show.html.twig', ['products' => $products]);
    }

    public function deleteProduct($id)
    {
        $shopManager = new ShopManager();
        $shopManager->delete($id);
        header('Location:/adminshop/listshop');
    }

    public function createProduct()
    {
        return $this->twig->render('Admin/Shop/create.html.twig');
    }

    public function processProductCreation()
    {
        $validator = new ValidationService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploader = new UploadService();
            $shopManager = new ShopManager();

            if (
                !$validator->validateString($_POST['title'])
                || !$validator->validateString($_POST['description'])
            ) {
                header('Location:/adminshop/createproduct/');
                return;
            }

            $product = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            ];
            $id = $shopManager->insert($product);
            if ($id) {
                $imagePath = $uploader->upload($_FILES['image']);

                if (is_array($imagePath)) {
                    header('location:/adminshop/listshop');
                    return;
                }
                // no errors, save the image
                $imageManager = new ImageManager();
                $data = [
                'parent_id' => $id,
                'parent_type' => $shopManager::TABLE,
                'img_path' => $imagePath
                ];
                $imageManager->insert($data);
                header('Location:/adminshop/listshop');
            }
        }

        return $this->twig->render('Admin/Shop/create.html.twig');
    }

    public function updateShop($id)
    {
        $shopManager = new ShopManager();
        $product = $shopManager->selectOneById($id);
        if ($product['id']) {
            $image = $this->getImage($product['id']);
            $product['img_path'] = $image['img_path'];
        }
        return $this->twig->render('Admin/Shop/updateform.html.twig', ['product' => $product]);
    }

    private function getImage($productId)
    {
        $imageManager = new ImageManager();
        $image = $imageManager->getOneByParentIdAndType($productId, 'shop');
        if (isset($image['id'])) {
            return $image;
        }
        return null;
    }


    public function processProductUpdate()
    {
        $validator = new ValidationService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $shopManager = new ShopManager();


            if (
                !$validator->validateString($_POST['title'])
                || !$validator->validateString($_POST['description'])
            ) {
                header('Location:/adminshop/updateshop/' . $_POST['product-id']);
                return;
            }
            $product = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'image_path' => $_POST['image_path'],
                'id' => $_POST['product-id']
            ];
            $shopManager->update($product);
            header('Location:/adminshop/listshop');
        }
    }
}
