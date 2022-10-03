<?php

namespace app\core;

use app\core\controllers\Controller;

class Router
{
	public static $list = [];

	public static function get($uri, $viewName)
	{
		self::$list['get'][$uri] = $viewName;
	}

	public static function post($uri, $viewName)
	{
		self::$list['post'][$uri] = $viewName;
	}

	public static function enable()
	{
		$path = Request::getPath();
		$method = Request::getMethod();
		$init = self::$list[$method][$path] ?? false;
		if ($init === false) {
			return View::render('404');
		}
		if (is_string($init)) {
			return View::render($init);
		}
		return call_user_func($init);
	}



}