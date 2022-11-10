<?php

namespace app\core\Helpers;

class AuthHelper
{
    private string $message = '';

    public function authUser($newUser): string
    {
        $users = include $_SERVER['DOCUMENT_ROOT'] . '/src/auth.php';
        $authUser = $newUser;
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

        return $this->message;
    }
}
