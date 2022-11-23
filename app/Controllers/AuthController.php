<?php

namespace Innowise\app\Controllers;

use Innowise\app\Helpers\AuthHelper;
use Innowise\system\Request;

class AuthController extends MainController
{
    private AuthHelper $helper;
    public function __construct()
    {
        parent::__construct();
        $this->helper = new AuthHelper();
    }

    public function auth(): string
    {
        $isAuth = $this->helper->authUser(Request::getRequestParams());

        return $this->view->render('auth', [
            'message' => $isAuth['message'] ?? '',
            'user' => $isAuth['user'] ?? ''
        ]);
    }

    public function logout(): string
    {
        $this->helper->logout();
        return $this->view->render('index');
    }
}
