<?php

namespace App\Controller;

use App\Model\FormManager;

class FormController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->render('Form/index.html.twig');
    }

    /**
     * Display item creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formManager = new FormManager();

            $users = [
                'lastname' => $_POST['lastname'],
                'firstname' => $_POST['firstname'],
                'login' => $_POST['login'],
                'password' => md5($_POST['password']),
                'email' => $_POST['email'],
                'address' => $_POST['address'],
                'number' => $_POST['number'],
                'postal' => $_POST['postal'],
                'city' => $_POST['city'],
            ];
            $id = $formManager->insert($users);
            if ($id) {
                header('Location:/');
            }

            return $this->twig->render('Form/add.html.twig');
        }
    }
}
