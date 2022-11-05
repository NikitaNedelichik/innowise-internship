<?php

namespace app\core\Controllers;

use app\core\App\MainController;
use app\core\Helpers\AuthHelper;

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
        $isAuth = $this->helper->authUser();
        return $this->view->render('auth', [
            'message' => $isAuth
        ]);
    }
}
