<?php

namespace app\core;

class Validate
{
    private const PATTERN_PASSWORD = "/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\^\$\*\+\?\#])[a-zA-Z\d\^\$\*\+\?\#]{6,}/u";

    public static function isNameValid($name): bool
    {
        if (preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u', $name)) {
            $valid = true;
        } else {
            $valid = false;
        }

        return $valid;
    }

    public static function isEmailValid($email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $valid = true;
        } else {
            $valid = false;
        }
        return $valid;
    }

    public static function isPasswordValid($password)
    {
        if (preg_match(self::PATTERN_PASSWORD, $password)) {
            return true;
        } else {
            return 'Password should contain at least 1 small character, at least 1 capital character, at least 1 digit, at least 1 special character and be not less than 6 characters long.';
        }
    }
}
