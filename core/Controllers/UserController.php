<?php

namespace app\core\Controllers;

use app\core\App\MainController;
use app\core\Models\UserModel;
use app\core\Request;

class UserController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new UserModel();
    }

    public function create(): string
    {
        $user = $this->model->createUser(Request::getRequestParams());
        return $this->view->render('create', [
            'user' => $user
        ]);
    }

    public function edit(): string
    {
        $user = $this->model->editUserByEmail();
        return $this->view->render('edit', [
            'user' => $user
        ]);
    }

    public function home(): string
    {
        $users = $this->model->getAllUsers();
        return $this->view->render('home', [
            'users' => $users
        ]);
    }

    public function delete(): string
    {
        $this->model->deleteUserById();
        return $this->home();
    }
}
