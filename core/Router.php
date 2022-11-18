<?php

namespace app\core;

use app\core\Controllers\AuthController;
use app\core\Controllers\UserController;

class Router
{
    private static array $list = [];
    private static View $view;

    public static function page($uri, $viewName)
    {
        self::$list[$uri] = $viewName;
    }

    public static function enable()
    {
        self::setRoutes();
        $path = Request::getPath();
        $init = self::$list[$path] ?? false;
        if ($init === false) {
            self::$view = new View();
            return self::$view->render('404');
        }
        if (is_string($init)) {
            self::$view = new View();
            return self::$view->render($init);
        }
        return call_user_func($init);
    }

    private static function setRoutes()
    {
        Router::page('/', [new UserController(), 'home']);
        Router::page('/create', [new UserController(), 'create']);
    }
}
