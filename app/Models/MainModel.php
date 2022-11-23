<?php

namespace Innowise\App\Models;

use Innowise\app\Services\Validate;

class MainModel
{
    public $errors = [];
    public $success;
    protected Validate $validator;

    public function __construct()
    {
        $this->validator = new Validate();
    }
}
