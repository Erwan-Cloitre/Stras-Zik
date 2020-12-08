<?php

namespace App\Controller;

use App\Model\DiscoManager;

class DiscoController extends AbstractController
{
    public function list()
    {
        $discoManager = new DiscoManager();
        $disks = $discoManager->selectAll();

        return $this->twig->render('Disco/show.html.twig', ['disks' => $disks]);
    }
}
