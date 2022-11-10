<?php

namespace app\core\Models;

use app\core\App\MainModel;
use app\core\Request;
use app\core\Validate;

class UserModel extends MainModel
{
    private function isSetEmail(): bool
    {
        $isSet = false;
        $sql = "SELECT email FROM `users`";
        $sth = $this->connection->prepare($sql);
        $sth->execute();
        $array = $sth->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($array as $email) {
            if ($email['email'] === $this->email) {
                $this->errors['email'] = 'User with this email is already exist!';
                $isSet = true;
            }
        }
        return $isSet;
    }

    public function createUser() : array
    {
        $params = Request::getRequestParams();
        if ($params['create'] === 'go') {
            $this->name = $params['name'];
            $this->email = $params['email'];
            $this->status = $params['status'];
            $this->gender = $params['gender'];
            if ($this->isValid()) {
                try {
                    // проверка на существование пользователя с такой почтой
                    if ($this->isSetEmail()) {
                        return (array)$this;
                    }
                    $sql = "INSERT INTO users (name, email, gender, status) VALUES (:name, :email, :gender, :status)";
                    $statm = $this->connection->prepare($sql);
                    $statm->bindParam(":name", $this->name);
                    $statm->bindParam(":email", $this->email);
                    $statm->bindParam(":gender", $this->gender);
                    $statm->bindParam(":status", $this->status);
                    $isOkey = $statm->execute();
                    if ($isOkey > 0) {
                        $this->success = 'User was created';
                    }
                } catch (\PDOException $e) {
                    echo "DBError: " . $e->getMessage();
                }
            }
        }

        return (array)$this;
    }

    public function getAllUsers()
    {
        try {
            $sql = "SELECT * FROM `users`";
            $sth = $this->connection->prepare($sql);
            $sth->execute();
            $array = $sth->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $exception) {
            echo '<div class="alert alert-danger">Something wrong</div>';
        }
        return $this->users = $array;
    }

    public function deleteUserById(): array
    {
        $id = Request::getRequestParams()['id'];
        if ($id > 0) {
            try {
                $sql = "DELETE FROM `users` WHERE id = $id";
                $stmt = $this->connection->exec($sql);
                if ($stmt) {
                    $res = true;
                } else {
                    $res = false;
                }
            } catch (\PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
        }

        return (array)$this;
    }

    public function editUserByEmail(): array
    {
        $params = Request::getRequestParams();
        if (Request::isGet()) {
            $this->getUserById($params['id']);
        } elseif (Request::isPost()) {
            $this->name = $params['name'];
            $this->email = $params['email'];
            $this->gender = $params['gender'];
            $this->status = $params['status'];

            if ($this->isValid()) {
                try {
                    $sql = "UPDATE `users` SET name = :name, email = :email, gender = :gender, status = :status  WHERE email = :email";
                    $stmt = $this->connection->prepare($sql);
                    $stmt->bindParam(":name", $this->name);
                    $stmt->bindParam(":email", $this->email);
                    $stmt->bindParam(":gender", $this->gender);
                    $stmt->bindParam(":status", $this->status);
                    $isOkey = $stmt->execute();
                    if ($isOkey) {
                        $this->success = 'User was edited';
                    }
                } catch (\PDOException $e) {
                    echo "Database error: " . $e->getMessage();
                }
            }
        }

        return (array)$this;
    }

    public function getUserById($id): array
    {
        try {
            $sql = "SELECT * FROM `users` WHERE id = $id";
            $sth = $this->connection->prepare($sql);
            $isOkey = $sth->execute();
            $array = $sth->fetch(\PDO::FETCH_ASSOC);
            if ($isOkey) {
                $this->name = $array['name'];
                $this->email = $array['email'];
                $this->gender = $array['gender'];
                $this->status = $array['status'];
            }
        } catch (\PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
        return (array)$this;
    }

    public function isValid(): bool
    {
        return empty($this->isEmptyFields()) && $this->validate();
    }

    private function isEmptyFields(): array
    {
        $this->name ?: $this->errors['name'] = "Field name is required";
        $this->email ?: $this->errors['email'] = "Field email is required";
        $this->status ?: $this->errors['status'] = "Field status is required";
        $this->gender ?: $this->errors['gender'] = "Field gender is required";

        return $this->errors;
    }

    private function validate(): bool
    {
        $valid = true;
        if (!Validate::isNameValid($this->name)) {
            $this->errors['name'] = "The field name is invalid";
            $valid = false;
        }
        if (!Validate::isEmailValid($this->email)) {
            $this->errors['email'] = "The field email is invalid";
            $valid = false;
        }

        return $valid;
    }
}
