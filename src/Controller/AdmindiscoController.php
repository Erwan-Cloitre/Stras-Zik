<?php

namespace App\Controller;

use App\Model\DiscoManager;
use App\Model\ImageManager;
use App\Service\ValidationService;
use App\Service\UploadService;

class AdmindiscoController extends AbstractAdminController
{
    public function listDisco()
    {
        $discoManager = new DiscoManager();
        $imageManager = new ImageManager();

        $disks = $discoManager->selectAll();

        foreach ($disks as $key => $disk) {
            $image = $imageManager->getOneByParentIdAndType($disk['id'], 'album');
            if (isset($image['id'])) {
                $disks[$key]['img_path'] = $image['img_path'];
            }
        }

        return $this->twig->render('Admin/Disco/index.html.twig', ['disks' => $disks]);
    }

    public function deleteDisco($id)
    {
        $discoManager = new DiscoManager();
        $discoManager->delete($id);
        header('Location:/admindisco/listdisco');
    }

    public function createDisco()
    {
        return $this->twig->render('Admin/Disco/form.html.twig');
    }

    public function processDiscoCreation()
    {
        $validator = new ValidationService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploader = new UploadService();
            $discoManager = new DiscoManager();

            if (
                !$validator->validateString($_POST['name'])
                || !$validator->validateUrl($_POST['url'])
            ) {
                header('Location:/admindisco/createdisco/');
                return;
            }

            $disk = [
            'name' => $_POST['name'],
            'url' => $_POST['url'],
            ];
            $id = $discoManager->insert($disk);
            if ($id) {
                $imagePath = $uploader->upload($_FILES['image']);

                if (is_array($imagePath)) {
                    header('location:/admindisco/listdisco');
                    return;
                }
                $imageManager = new ImageManager();
                $data = [
                'parent_id' => $id,
                'parent_type' => $discoManager::TABLE,
                'img_path' => $imagePath
                ];
                $imageManager->insert($data);
                header('Location:/admindisco/listdisco');
            }
        }

        return $this->twig->render('Admin/Disco/form.html.twig');
    }

    public function updateDisco($id)
    {
        $discoManager = new DiscoManager();
        $disk = $discoManager->selectOneById($id);
        if ($disk['id']) {
            $image = $this->getImage($disk['id']);
            $disk['img_path'] = $image['img_path'];
        }
        return $this->twig->render('Admin/Disco/updateform.html.twig', ['disk' => $disk]);
    }

    private function getImage($diskId)
    {
        $imageManager = new ImageManager();
        $image = $imageManager->getOneByParentIdAndType($diskId, 'album');
        if (isset($image['id'])) {
            return $image;
        }
        return null;
    }


    public function processDiscoUpdate()
    {
        $validator = new ValidationService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $discoManager = new DiscoManager();


            if (
                !$validator->validateString($_POST['name'])
                || !$validator->validateUrl($_POST['url'])
            ) {
                header('Location:/admindisco/updatedisco/' . $_POST['disk-id']);
                return;
            }
            $disk = [
                'name' => $_POST['name'],
                'url' => $_POST['url'],
                'image_path' => $_POST['image_path'],
                'id' => $_POST['disk-id']
            ];
            $discoManager->update($disk);
            header('Location:/admindisco/listdisco');
        }
    }
}
