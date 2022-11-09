<?php

namespace app\core\Models;

use app\core\App\MainModel;
use app\core\Database;
use app\core\Validate;

class UserModel extends MainModel
{
    public $email;
    public $emailConfirm;
    public $firstName;
    public $lastName;
    public $password;
    public $passwordConfirm;
    public string $createdDate;

    public function __construct()
    {
        parent::__construct();
    }

    private function loadData($data): UserModel
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

    public function createUser($data): array
    {
        if ($data['create'] === 'go') {
            if ($this->loadData($data)->isValid()) {
                try {
                    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
                    $this->connection->beginTransaction();
                    $this->success = Database::createUser($this->email, $this->firstName, $this->lastName, $this->password, $this->createdDate);
                    $this->connection->commit();
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

    public function getAllUsers(): array
    {
        try {
            $this->connection->beginTransaction();
            $array = Database::getUsersList();
            $this->connection->commit();
        } catch (\PDOException $exception) {
            $this->connection->rollBack();
            echo '<div class="alert alert-danger">' . $exception . '</div>';
        }
        return $this->users = $array;
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
        if (!Validate::isNameValid($this->firstName)) {
            $this->errors['firstName'] = "The field name is invalid";
            $this->firstName = '';
            $valid = false;
        }
        if (!Validate::isNameValid($this->lastName)) {
            $this->errors['lastName'] = "The field name is invalid";
            $this->lastName = '';
            $valid = false;
        }
        if (!Validate::isEmailValid($this->email)) {
            $this->errors['email'] = "The field email is invalid";
            $valid = false;
        }
        if (Validate::isPasswordValid($this->password) !== true) {
            $this->errors['password'] = Validate::isPasswordValid($this->password);
            $valid = false;
        }
        if (Validate::isPasswordValid($this->passwordConfirm) !== true) {
            $this->errors['passwordConfirm'] = Validate::isPasswordValid($this->password);
            $valid = false;
        }
        if ($valid === true && $this->passwordConfirm !== $this->password) {
            $this->errors['passwordConfirm'] = "Fields do not match";
            $valid = false;
        }

        return $valid;
    }
}
