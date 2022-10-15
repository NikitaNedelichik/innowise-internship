<?php

namespace app\core;

class Validate
{
	public static $errors = [];

	public static function isGenderValid($gender): bool
	{
		if ($gender === 'male' || $gender === 'female') {
			$valid = true;
		} else {
			self::$errors[] = 'invalid gender';
			$valid = false;
		}
		return $valid;
	}

	public static function isStatusValid($status): bool
	{
		if ($status === 'active' || $status === 'inactive') {
			$valid = true;
		} else {
			self::$errors[] = 'invalid status';
			$valid = false;
		}
		return $valid;
	}

	public static function isNameValid($name): bool
	{
		if (preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u', $name)) {
			$valid = true;
		} else {
			self::$errors[] = 'invalid name';
			$valid = false;
		}

		return $valid;
	}

	public static function isEmailValid($email): bool
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$valid = true;
		} else {
			self::$errors[] = 'invalid email';
			$valid = false;
		}
		return $valid;
	}

	public static function validateData($name, $email, $gender, $status)
	{
		if (self::isNameValid($name) && self::isEmailValid($email) && self::isStatusValid($status) && self::isGenderValid($gender)) {
			$valid = true;
		} else {
			$valid = false;
		}
		return $valid;
	}
}
