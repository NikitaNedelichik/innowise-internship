<?php

namespace Innowise\app\Models;

use Innowise\app\Services\Validate;
use Innowise\system\Database;

class RegisterModel extends MainModel
{
    public $email;
    public $emailConfirm;
    public $firstName;
    public $lastName;
    public $password;
    public $passwordConfirm;
    public string $createdDate;
    private \PDO $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = (Database::getInstance())->getConnection();
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    private function loadData($data): RegisterModel
    {
        $this->email = $data['email'] ?? '';
        $this->emailConfirm = $data['email_confirm'] ?? '';
        $this->firstName = $data['first-name'] ?? '';
        $this->lastName = $data['last-name'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->passwordConfirm = $data['password_confirm'] ?? '';
        $this->createdDate = date('Y-m-d H:i:s');

        return $this;
    }

    public function registerUser($data): array
    {
        if ($data['register'] === 'go') {
            if ($this->loadData($data)->isValid()) {
                try {
                    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users (email, first_name, last_name, password, created_date) VALUES (:email, :first_name, :last_name, :password, :created_date)";
                    $statm = $this->connection->prepare($sql);
                    $statm->bindParam(":email", $this->email);
                    $statm->bindParam(":first_name", $this->firstName);
                    $statm->bindParam(":last_name", $this->lastName);
                    $statm->bindParam(":password", $this->password);
                    $statm->bindParam(":created_date", $this->createdDate);
                    $this->connection->beginTransaction();
                    $isOkey = $statm->execute();
                    $this->connection->commit();
                    if ($isOkey > 0) {
                        $this->success = "User was registered";
                        $_SESSION['auth'] = 'yes';
                        header('Location: /upload');
                    }
                } catch (\PDOException $e) {
                    $this->connection->rollBack();
                    if ($e->getCode() === "23000") {
                        $this->errors['db_error'] = 'User with this email is already exists';
                    } else {
                        $this->errors['db_error'] = "DB Error, sorry, try again";
                    }
                }
            }
        }

        return (array)$this;
    }

    public function isValid(): bool
    {
        return $this->checkFields() && $this->validate();
    }

    private function checkFields(): bool
    {
        $this->email ?: $this->errors['email'] = "Field email is required";
        $this->emailConfirm ?: $this->errors['emailConfirm'] = "Field email is required";
        $this->firstName ?: $this->errors['firstName'] = "Field first name is required";
        $this->lastName ?: $this->errors['lastName'] = "Field last name is required";
        $this->password ?: $this->errors['password'] = "Field password is required";
        $this->passwordConfirm ?: $this->errors['passwordConfirm'] = "Field password is required";

        return empty($this->errors);
    }

    private function validate(): bool
    {
        $valid = true;
        if (!$this->validator->isNameValid($this->firstName)) {
            $this->errors['firstName'] = $this->validator->getError('name');
            $this->firstName = '';
            $valid = false;
        }
        if (!$this->validator->isNameValid($this->lastName)) {
            $this->errors['lastName'] = $this->validator->getError('name');
            $this->lastName = '';
            $valid = false;
        }
        if (!$this->validator->isEmailValid($this->email)) {
            $this->errors['email'] = $this->validator->getError('email');
            $valid = false;
        }
        if ($this->validator->isPasswordValid($this->password) !== true) {
            $this->errors['password'] = $this->validator->getError('password');
            $valid = false;
        }
        if ($this->validator->isPasswordValid($this->passwordConfirm) !== true) {
            $this->errors['passwordConfirm'] = $this->validator->getError('passwordConfirm');
            $valid = false;
        }
        if ($valid === true && $this->passwordConfirm !== $this->password) {
            $this->errors['passwordConfirm'] = "Fields do not match";
            $valid = false;
        }

        return $valid;
    }
}
