<?php

namespace App\Controller;

use App\Model\VideoManager;
use App\Service\ValidationService;

class AdminvideoController extends AbstractAdminController
{
    public function listVideo()
    {
        $videoManager = new VideoManager();
        $videos = $videoManager->selectAll();

        return $this->twig->render('Admin/Video/index.html.twig', ['videos' => $videos]);
    }

    public function deleteVideo($id)
    {
        $videoManager = new VideoManager();
        $videoManager->delete($id);
        header('Location:/adminvideo/listvideo');
    }

    public function createVideo()
    {
        return $this->twig->render('Admin/Video/form.html.twig');
    }

    public function processVideoCreation()
    {
        $validator = new ValidationService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $videoManager = new VideoManager();

            if (
                !$validator->validateString($_POST['title'])
            ) {
                header('Location:/adminvideo/createvideo/');
                return;
            }

            $video = [
                'title' => $_POST['title'],
                'url' => $_POST['url'],
            ];
            $id = $videoManager->insert($video);
            if ($id) {
                header('Location:/adminvideo/listvideo');
            }
        }

        return $this->twig->render('Admin/Video/form.html.twig');
    }

    public function updateVideo($id)
    {
        $videoManager = new VideoManager();
        $video = $videoManager->selectOneById($id);
        return $this->twig->render('Admin/Video/updateform.html.twig', ['video' => $video]);
    }


    public function processVideoUpdate()
    {
        $validator = new ValidationService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $videoManager = new VideoManager();

            if (
                !$validator->validateString($_POST['title'])
                || !$validator->validateString($_POST['url'])
            ) {
                header('Location:/adminvideo/updatevideo/' . $_POST['video-id']);
                return;
            }
            $video = [
                'title' => $_POST['title'],
                'url' => $_POST['url'],
                'id' => $_POST['event-id']
            ];
            $videoManager->update($video);
            header('Location:/adminvideo/listvideo');
        }
    }
}
