<?php

namespace App\Controller;

use App\Model\NewsManager;
use App\Model\SubscriberManager;
use App\Model\ImageManager;
use App\Service\ValidationService;
use App\Service\UploadService;

class NewsController extends AbstractController
{
    public function list()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subscriberManager = new SubscriberManager();
            $subscriber = [
                'lastname' => $_POST['lastname'],
                'firstname' => $_POST['firstname'],
                'email' => $_POST['email'],
            ];
            $subscriberManager->insert($subscriber);
            header('Location:/news/list');
        }
        $newsManager = new NewsManager();
        $imageManager = new ImageManager();
        $news = $newsManager->selectAll();

        foreach ($news as $key => $new) {
            $image = $imageManager->getOneByParentIdAndType($new['id'], 'news');
            $news[$key]['img_path'] = $image['img_path'];
        }
        return $this->twig->render('News/show.html.twig', ['news' => $news]);
    }

    public function listNews()
    {
        $newsManager = new NewsManager();
        $imageManager = new ImageManager();

        $news = $newsManager->selectAll();

        foreach ($news as $key => $new) {
            $image = $imageManager->getOneByParentIdAndType($new['id'], 'news');
            if (isset($image['id'])) {
                $news[$key]['img_path'] = $image['img_path'];
            }
        }

        return $this->twig->render('Admin/News/index.html.twig', ['news' => $news]);
    }

    public function deleteNews($id)
    {
        $newsManager = new NewsManager();
        $newsManager->delete($id);
        header('Location:/news/listnews');
    }

    public function createNews()
    {
        return $this->twig->render('Admin/News/form.html.twig');
    }

    public function processNewsCreation()
    {
        $validator = new ValidationService();
        $uploader = new UploadService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newsManager = new NewsManager();

            if (
                !$validator->validateString($_POST['title'])
                || !$validator->validateString($_POST['description'])
            ) {
                header('Location:/news/listnews');
                return;
            }

            $new = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
            ];
            $id = $newsManager->insert($new);
            if ($id) {
                $imagePath = $uploader->upload($_FILES['image']);

                if (is_array($imagePath)) {
                    header('location:/news/listnews');
                    return;
                }
                // no errors, save the image
                $imageManager = new ImageManager();
                $data = [
                    'parent_id' => $id,
                    'parent_type' => $newsManager::TABLE,
                    'img_path' => $imagePath
                ];
                $imageManager->insert($data);
                header('Location:/news/listnews');
            }
        }

        return $this->twig->render('Admin/News/form.html.twig');
    }

    public function updateNews($id)
    {
        $newsManager = new NewsManager();
        $news = $newsManager->selectOneById($id);
        return $this->twig->render('Admin/News/updateform.html.twig', ['news' => $news]);
    }

    public function processNewsUpdate()
    {
        $validator = new ValidationService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newsManager = new NewsManager();

            if (
                !$validator->validateString($_POST['title'])
                || !$validator->validateString($_POST['description'])
            ) {
                header('Location:/news/updatenews/' . $_POST['event-id']);
                return;
            }
            $new = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'image_path' => $_POST['image_path'],
                'id' => $_POST['event-id']
            ];
            $newsManager->update($new);
            header('Location:/news/listnews');
        }
    }

    public function newsletter()
    {
        $subscriberManager = new SubscriberManager();
        $subscribers = $subscriberManager->selectAll();

        return $this->twig->render('Admin/News/newsletter.html.twig', ['subscribers' => $subscribers]);
    }
}
