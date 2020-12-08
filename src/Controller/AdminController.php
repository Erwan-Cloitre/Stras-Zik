<?php

namespace App\Controller;

class AdminController extends AbstractAdminController
{
    public function list()
    {
        return $this->twig->render('Admin/index.html.twig', []);
    }
}
