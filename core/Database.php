<?php

namespace app\core;

class Database
{
	private static $userName = 'root';
	private static $userPassword = '';
	public static $connection;

	public static function getConnection(): \PDO
	{
		try {
			$dsn = 'mysql:host=localhost;port=3306;dbname=users;charset=utf8';
			static::$connection = new \PDO($dsn, static::$userName, static::$userPassword);
			if (!static::$connection->exec('SHOW TABLES FROM `users` like `users`;')) {
				static::$connection->exec('CREATE TABLE users (
    				`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(100),
					`email` varchar(50),
					`gender` varchar(20),
					`status` varchar(20),
					PRIMARY KEY (`id`)
				)');
			}
		} catch (PDOException $exception) {
			echo $exception->getMessage();
		}
		return static::$connection;
	}
}
