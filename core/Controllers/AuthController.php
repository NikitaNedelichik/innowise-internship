<?php

namespace app\core\Controllers;

use app\core\App\MainController;
use app\core\Helpers\AuthHelper;
use app\core\Request;

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
        if (Request::isPost()) {
            $isAuth = $this->helper->authUser(Request::getRequestParams());
        }

        return $this->view->render('auth', [
            'message' => $isAuth ?? ''
        ]);
    }
}
