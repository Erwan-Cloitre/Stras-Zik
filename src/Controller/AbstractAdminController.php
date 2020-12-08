<?php

namespace App\Controller;

abstract class AbstractAdminController extends AbstractController
{
    public const ADMIN_ROLE = 'admin';

    public function __construct()
    {
        parent::__construct();
        if (!$this->isAllowed()) {
            $this->redirect();
            return;
        }
    }

    private function isAllowed()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === self::ADMIN_ROLE;
    }

    private function redirect()
    {
        header('location:/');
    }
}
