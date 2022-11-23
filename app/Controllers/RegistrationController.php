<?php

namespace Innowise\app\Controllers;

use Innowise\app\Models\RegisterModel;
use Innowise\system\Request;

class RegistrationController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new RegisterModel();
    }

    public function register(): string
    {
        $user = $this->model->registerUser(Request::getRequestParams());
        return $this->view->render('register', [
            'user' => $user
        ]);
    }
}
