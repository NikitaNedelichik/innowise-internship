<?php

namespace app\core\App;

use app\core\View;

abstract class MainController
{
    protected View $view;
    protected MainModel $model;

    public function __construct()
    {
        $this->view = new View();
    }
}
