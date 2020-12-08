<?php

namespace App\Controller;

class FooterController extends AbstractController
{
    public function conditions()
    {

        return $this->twig->render('Footer/index.html.twig');
    }
}
