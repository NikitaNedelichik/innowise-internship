<?php

namespace app\core\App;

use app\core\Database;

abstract class MainModel
{
    protected \PDO $connection;
    public $errors = [];
    public $success;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    public function successMessage()
    {
        return $this->success;
    }

    public function getMessage($param)
    {
        return $this->errors[$param];
    }

    public function hasError($param): bool
    {
        return isset($this->errors[$param]);
    }
}
