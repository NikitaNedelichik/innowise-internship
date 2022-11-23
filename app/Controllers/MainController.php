<?php

namespace Innowise\App\Controllers;

use Innowise\app\Models\MainModel;
use Innowise\app\Views\View;

class MainController
{
    protected View $view;
    protected MainModel $model;

    public function __construct()
    {
        $this->view = new View();
    }
}
