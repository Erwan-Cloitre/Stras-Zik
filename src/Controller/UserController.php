<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Service\ValidationService;

class UserController extends AbstractController
{

    public function account()
    {
        $userManager = new UserManager();
        $id = $_SESSION['user_id'];
        $user = $userManager->selectOneById($id);

        return $this->twig->render('User/show.html.twig', ['user' => $user]);
    }

    public function edit($id)
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);
        return $this->twig->render('User/edit.html.twig', ['user' => $user]);
    }

    public function processEdit()
    {
        $validator = new ValidationService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();

            if (
                !$validator->validateString($_POST['lastname'])
                || !$validator->validateString($_POST['firstname'])
                || !$validator->validateString($_POST['login'])
                || !$validator->validateMail($_POST['email'])
                || !$validator->validateString($_POST['address'])
                || !$validator->validateString($_POST['town'])
                || !$validator->validateInt($_POST['number'])
            ) {
                header('Location:/user/edit/' . $_POST['user-id']);
                return;
            }
            $user = [
                'lastname' => $_POST['lastname'],
                'firstname' => $_POST['firstname'],
                'login' => $_POST['login'],
                'password' => md5($_POST['password']),
                'email' => $_POST['email'],
                'address' => $_POST['address'],
                'number' => $_POST['number'],
                'postal' => $_POST['postal'],
                'town' => $_POST['town'],
                'id' => $_POST['user-id'],
            ];
            $userManager->update($user);
            header('Location:/user/account');
        }
    }

    public function delete(int $id)
    {
        $userManager = new UserManager();
        $userManager->delete($id);
        header('Location:/user/index');
    }
}
