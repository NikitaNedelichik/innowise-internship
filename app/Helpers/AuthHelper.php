<?php

namespace Innowise\App\Helpers;

use Innowise\system\Database;

class AuthHelper
{
    public string $message = '';
    private \PDO $dbConnection;

    public function __construct()
    {
        $this->dbConnection = (Database::getInstance())->getConnection();
        $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function authUser($newUser): array
    {
        if ($newUser['auth'] === 'go') {
            if ($this->getAuthAttempts() <= 3 && !$this->isBlock()) {
                try {
                    $login = $newUser['email'];
                    $password = $newUser['password'];
                    $rememberMe = $newUser['rememberme'] ?? '';
                    $this->dbConnection->beginTransaction();
                    $sql = "SELECT * FROM `users` WHERE email = :email";
                    $statm = $this->dbConnection->prepare($sql);
                    $statm->bindParam(":email", $login);
                    $statm->execute();
                    $this->dbConnection->commit();
                    $user = $statm->fetch(\PDO::FETCH_ASSOC);
                    if ($user !== false) {
                        $userPassword = $user['password'];
                        if (password_verify($password, $userPassword)) {
                            $this->setSession();
                            if ($rememberMe) {
                                $this->rememberMe($login, $userPassword);
                            }
                            header('Location: /upload');
                        } else {
                            $this->message = "Password is incorrect.";
                            $this->setAuthAttempts();
                        }
                    } else {
                        $this->message = 'User with this email is not exist';
                        $this->setAuthAttempts();
                    }
                } catch (\PDOException $e) {
                    $this->dbConnection->rollBack();
                    $this->message = $e->getMessage();
                }
            } else {
                $this->blockUser();
                $this->message = 'User is block. Try again in 15 minutes';
            }
        } else {
            if ($this->isRememberMe()) {
                $this->dbConnection->beginTransaction();
                $sql = "SELECT * FROM `users` WHERE auth_token = :auth_token";
                $statm = $this->dbConnection->prepare($sql);
                $statm->bindParam(":auth_token", $_COOKIE['rememberme']);
                $statm->execute();
                $this->dbConnection->commit();
                $user = $statm->fetch(\PDO::FETCH_ASSOC);
                if ($user !== false) {
                    $this->setSession();
                    header('Location: /upload');
                }
            }
        }

        return [
            'message' => $this->message ?? ''
        ];
    }

    private function setSession(): void
    {
        $_SESSION['auth'] = 'yes';
    }

    private function setAuthAttempts()
    {
        if (!isset($_COOKIE['counter'])) {
            setcookie('counter', 1);
        } else {
            setcookie('counter', ++$_COOKIE['counter']);
        }
    }

    private function resetAuthAttempts()
    {
        setcookie('counter', 1);
    }

    private function getAuthAttempts(): int
    {
        return (int)$_COOKIE['counter'];
    }

    private function blockUser()
    {
        $this->resetAuthAttempts();
        $_COOKIE['error'] ?? setcookie('error', 'try again in 15 minutes', time() + 60 * 15);
    }

    private function isBlock(): bool
    {
        return isset($_COOKIE['error']);
    }

    public function logout()
    {
        unset($_SESSION['auth']);
    }

    private function rememberMe($email, $password)
    {
        if (!isset($_COOKIE['rememberme'])) {
            try {
                $token = md5($password);
                $this->dbConnection->beginTransaction();
                $sql = "UPDATE users SET auth_token = :token WHERE email = :email";
                $statm = $this->dbConnection->prepare($sql);
                $statm->bindParam(":email", $email);
                $statm->bindParam(":token", $token);
                $isOkey = $statm->execute();
                $this->dbConnection->commit();
                if ($isOkey > 0) {
                    setcookie('rememberme', $token, time() + 60 * 60 * 24 * 7);
                }
            } catch (\PDOException $e) {
                $this->dbConnection->rollBack();
                echo $e->getMessage();
            }
        }
    }

    private function isRememberMe(): bool
    {
        return isset($_COOKIE['rememberme']);
    }
}
