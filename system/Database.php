<?php

namespace Innowise\system;

class Database
{
    private static $instance = null;
    private static $userName = 'root';
    private static $userPassword = 'root';
    private $connection;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("We are use Database class as Singleton");
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): \PDO
    {
        try {
            $dsn = 'mysql:host=db;port=3306;dbname=innowise;charset=utf8';
            $this->connection = new \PDO($dsn, static::$userName, static::$userPassword);
            $this->connection->exec('
                CREATE TABLE IF NOT EXISTS users (
                    `id` int unsigned PRIMARY KEY AUTO_INCREMENT,
                    `email` varchar(50) UNIQUE NOT NULL,
                    `first_name` varchar(100) not null,
                    `last_name` varchar(100) not null,
                    `password` char(255),
                    `created_date` timestamp
             )');
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
        }
        return $this->connection;
    }
}
