<?php

namespace App\Controller;

use App\Model\AdminManager;

class AdminloginController extends AbstractController
{
    public function connection()
    {
        $error = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminManager = new AdminManager();
            $admin =
                [
                    'username' => $_POST['username'],
                    'password' => md5($_POST['password']),
                ];
            $login = $adminManager->login($admin);
            if (is_array($login)) {
                $_SESSION['role'] = $login['role'];
                $_SESSION['user_id'] = $login['id'];
                header('location:/admin/list');
                return;
            }
            header('location:/adminlogin/forbidden');
            return;
        }
        return $this->twig->render('Admin/Login/login.html.twig', ["error" => $error]);
    }

    public function logout()
    {
        if ($_SESSION) {
            $_SESSION['username'] = '';
            $_SESSION['password'] = '';
            $_SESSION['id'] = '';
            $_SESSION['role'] = '';
            $_SESSION['user_id'] = '';
        }
        header('location:/');
    }

    public function forbidden()
    {
        return $this->twig->render('Admin/Login/forbidden.html.twig');
    }
}
