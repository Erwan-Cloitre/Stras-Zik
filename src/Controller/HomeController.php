<?php

namespace App\Controller;

use App\Model\DiscoManager;
use App\Model\ImageManager;
use App\Model\VideoManager;

class HomeController extends AbstractController
{

    public function index()
    {
        $discoManager = new DiscoManager();
        $imageManager = new ImageManager();
        $videoManager = new VideoManager();

        $videos = $videoManager->SelectAll();
        $disks = $discoManager->selectAll();
        foreach ($disks as $key => $disk) {
            $image = $imageManager->getOneByParentIdAndType($disk['id'], 'album');
            if (isset($image['id'])) {
                $disks[$key]['img_path'] = $image['img_path'];
            }
        }

        return $this->twig->render('Home/index.html.twig', ['disks' => $disks, 'videos' => $videos ]);
    }
}
