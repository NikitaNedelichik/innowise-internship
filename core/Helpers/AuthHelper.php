<?php

namespace app\core\Helpers;

use app\core\Request;

class AuthHelper
{
    private string $message = '';
    public function authUser(): string
    {
        if (Request::isPost()) {
            $users = include $_SERVER['DOCUMENT_ROOT'] . '/src/auth.php';
            $authUser = Request::getRequestParams();
            if (isset($users[$authUser['email']])) {
                $hash = $users[$authUser['email']]['password'];
                if (password_verify($authUser['password'], $hash)) {
                    $this->message = 'Welcome back, ' . $users[$authUser['email']]['name'];
                } else {
                    $this->message = "Login is incorrect.";
                }
            } else {
                $this->message = "Login is incorrect.";
            }
        }

        return $this->message;
    }
}
