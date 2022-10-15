<?php

namespace app\core;

class View
{
	public static function render($init, $params = [])
	{
		$main = self::getMainView();
		$need = self::getNeedView($init, $params);
		return str_replace('{{content}}', $need, $main);
	}

	private static function getMainView()
	{
		ob_start();
		include_once 'project/layouts/main.php';
		return ob_get_clean();
	}

	private static function getNeedView($view, $params)
	{
		foreach ($params as $key => $value) {
			$$key = $value;
		}
		ob_start();
		include_once "project/views/$view.php";
		return ob_get_clean();
	}

	public static function getGender($genderParam = false): string
	{
		$genderAr = [
			"male",
			"female"
		];
		$block = '';
		foreach ($genderAr as $key => $gender) {
            if (isset($genderParam) && $genderParam === $gender) {
                $block .= '<option value="' . $gender . '" selected="selected">' . $gender . '</option>';
            } else {
                $block .= '<option value="' . $gender . '">' . $gender . '</option>';
            }
		}
		return $block;
	}

	public static function getStatus($statusParam = false): string
	{
		$statusAr = [
			'active',
			'inactive'
		];
		$block = '';
		foreach ($statusAr as $key => $status) {
            if (isset($statusParam) && $statusParam === $status) {
                $block .= '<option value="' . $status . '" selected="selected">' . $status . '</option>';
            } else {
                $block .= '<option value="' . $status . '">' . $status . '</option>';
            }
		}
		return $block;
	}
}
