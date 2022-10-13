<?php

namespace app\core\controllers;

use app\core\models\Model;
use app\core\Request;
use app\core\View;

class Controller
{
	private $model;

	public function __construct()
	{
		$this->model = new Model();
	}

	public function create()
	{
		if (Request::isPost()) {
			$this->model->loadData(Request::getBody());
            if ($this->model->isValid() && $this->model->createUser()) {
                return View::render('create', [
                    'model' => $this->model
                ]);
            }
            return View::render('create', [
                'model' => $this->model
            ]);
		}
		return View::render('create', [
            'model' => $this->model
        ]);
	}

    public function edit()
    {
        if (Request::isGet()) {
            $id = Request::getBody()['id'] ?? false;
            if ($id) {
                $this->model->getUserById($id);
                return View::render('edit', [
                    'model' => $this->model
                ]);
            }
        }
        if (Request::isPost()) {
            $this->model->loadData(Request::getBody());
            if ($this->model->isValid() && $this->model->editUserByEmail()) {
                return View::render('edit', [
                    'model' => $this->model
                ]);
            }
            return View::render('edit', [
                'model' => $this->model
            ]);
        }
    }

	public function home()
	{
		$users['users'] = $this->model->getAllUsers();
		return View::render('home', $users);
	}

	public function delete()
	{
		$id = Request::getBody()['id'] ?? false;
		if ($id) {
			$this->model->deleteUserById($id);
		}
		return View::render('reload');
	}
}