<?php

namespace app\core\models;

use app\core\Database;

class Model
{
	private $connection;

	public function __construct()
	{
		$this->connection = Database::getConnection();
	}

	public function createUser($name, $email, $gender, $status)
	{
		try {
			$sql = "INSERT INTO users (name, email, gender, status) VALUES (:name, :email, :gender, :status)";
			$statm = $this->connection->prepare($sql);
			$statm->bindParam(":name", $name);
			$statm->bindParam(":email", $email);
			$statm->bindParam(":gender", $gender);
			$statm->bindParam(":status", $status);
			$isOkey = $statm->execute();
			if ($isOkey > 0) {
				$block = '<div class="alert alert-success">User successfuly created</div>';
			} else {
				$block = '<div class="alert alert-danger">Something wrong</div>';
			}
		} catch (\PDOException $e) {
			echo "DBError: " . $e->getMessage();
		}
		return $block;
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

		return $array;
	}

	public function deleteUserById($id)
	{
		try {
			$sql = "DELETE FROM `users` WHERE id = $id";
			$stmt = $this->connection->exec($sql);
			if ($stmt) {
				$res = true;
			} else {
				$res = false;
			}
		}
		catch (\PDOException $e) {
			echo "Database error: " . $e->getMessage();
		}
		return $res;
	}

	public function editUserById($id, $name, $email, $gender, $status)
	{
		try {
			$sql = "UPDATE `users` SET name = :name, email = :email, gender = :gender, status = :status  WHERE id = :id";
			$stmt = $this->connection->prepare($sql);
			$stmt->bindValue(":id", $id);
			$stmt->bindParam(":name", $name);
			$stmt->bindParam(":email", $email);
			$stmt->bindParam(":gender", $gender);
			$stmt->bindParam(":status", $status);
			$isOkey = $stmt->execute();
		}
		catch (\PDOException $e) {
			echo "Database error: " . $e->getMessage();
		}
		return $isOkey;
	}

	public function getUserById($id)
	{
		try {
			$sql = "SELECT * FROM `users` WHERE id = $id";
			$sth = $this->connection->prepare($sql);
			$sth->execute();
			$array = $sth->fetch(\PDO::FETCH_ASSOC);
		}
		catch (\PDOException $e) {
			echo "Database error: " . $e->getMessage();
		}
		return $array;
	}
}