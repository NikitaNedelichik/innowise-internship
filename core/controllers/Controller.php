<?php

namespace app\core\controllers;

use app\core\models\Model;
use app\core\Request;
use app\core\Validate;
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
			$data = Request::getBody();
			$this->model->createUser($data['name'], $data['email'], $data['gender'], $data['status']);
		}
		return View::render('create');
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

	public function edit()
	{
		if (Request::isGet()) {
			$id = Request::getBody()['id'] ?? false;
			if ($id) {
				$user['user'] = $this->model->getUserById($id);
				return View::render('edit', $user);
			}
		}
		if (Request::isPost()) {
			$body = Request::getBody() ?? false;
			extract($body);
			$isValid = Validate::validateData($name, $email, $gender, $status);
			if (!$isValid) {
				return View::render('error');
			} elseif ($id) {
				$this->model->editUserById($id, $name, $email, $gender, $status);
				return View::render('reload');
			}
		}
	}
}