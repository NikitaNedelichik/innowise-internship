<?php

namespace Innowise\app\Services;

class Validate
{
    private const PATTERN_PASSWORD = "/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\^\$\*\+\?\#])[a-zA-Z\d\^\$\*\+\?\#]{6,}/u";

    private array $errors = [];

    private static array $types = [
        'image/jpg',
        'image/jpeg',
        'image/gif',
        'image/webp',
        'text/plain'
    ];

    public function isValidSize($size): bool
    {
        if ($size === 0) {
            $this->errors['size'] = 'File size is big';
            return false;
        } else {
            return true;
        }
    }

    public function isValidType($type): bool
    {
        if (!in_array($type, self::$types)) {
            $this->errors['type'] = 'File format is not available. File must be image or txt';
            return false;
        } else {
            return true;
        }
    }

    public function isNameValid($name): bool
    {
        if (preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u', $name)) {
            return true;
        } else {
            $this->errors['name'] = 'The field is invalid';
            return false;
        }
    }

    public function isEmailValid($email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            $this->errors['email'] = 'The field email is invalid';
            return false;
        }
    }

    public function isPasswordValid($password): bool
    {
        if (preg_match(self::PATTERN_PASSWORD, $password)) {
            return true;
        } else {
            $this->errors['password'] = 'Password should contain at least 1 small character, at least 1 capital character, at least 1 digit, at least 1 special character and be not less than 6 characters long.';
            return false;
        }
    }

    public function getError(string $error): string
    {
        return $this->errors[$error];
    }
}
