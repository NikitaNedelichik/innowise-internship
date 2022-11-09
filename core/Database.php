<?php

namespace app\core;

abstract class Database
{
    private static $userName = 'root';
    private static $userPassword = 'root';
    public static $connection;

    public static function getConnection(): \PDO
    {
        try {
            $dsn = 'mysql:host=db;port=3306;dbname=innowise;charset=utf8';
            static::$connection = new \PDO($dsn, static::$userName, static::$userPassword);
            static::$connection->exec('
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
        return static::$connection;
    }

    public static function getUsersList()
    {
        self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM `users`";
        $sth = self::$connection->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function createUser(string $email, string $firstName, string $lastName, string $password, string $createDate): string
    {
        $message = '';
        self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO `users` (email, first_name, last_name, password, created_date) VALUES (:email, :first_name, :last_name, :password, :create_date)";
        $statm = self::$connection->prepare($sql);
        $statm->bindParam(":email", $email);
        $statm->bindParam(":first_name", $firstName);
        $statm->bindParam(":last_name", $lastName);
        $statm->bindParam(":password", $password);
        $statm->bindParam(":create_date", $createDate);
        $isOkey = $statm->execute();
        if ($isOkey > 0) {
            $message = 'User was created';
        }
        return $message;
    }
}
