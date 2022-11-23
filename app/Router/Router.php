<?php

namespace Innowise\app\Router;

use Innowise\app\Controllers\AuthController;
use Innowise\app\Controllers\FrontController;
use Innowise\app\Controllers\RegistrationController;
use Innowise\system\Request;
use Innowise\app\Views\View;

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
        Router::page('/', [new FrontController(), 'index']);
        Router::page('/register', [new RegistrationController(), 'register']);
        Router::page('/auth', [new AuthController(), 'auth']);
        Router::page('/logout', [new AuthController(), 'logout']);
        Router::page('/upload', [new FrontController(), 'upload']);
    }
}
