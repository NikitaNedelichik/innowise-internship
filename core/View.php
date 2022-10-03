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
			"choose",
			"male",
			"female"
		];
		$block = '';
		foreach ($genderAr as $key => $gender) {
			if ($key > 0) {
				if (isset($genderParam) && $genderParam === $gender) {
					$block .= '<option value="' . $gender . '" selected="selected">' . $gender . '</option>';
				} else {
					$block .= '<option value="' . $gender . '">' . $gender . '</option>';
				}
			} else {
				$block .= '<option>' . $gender . '</option>';
			}
		}
		return $block;
	}
	public static function getStatus($statusParam): string
	{
		$statusAr = [
			'choose',
			'active',
			'inactive'
		];
		$block = '';
		foreach ($statusAr as $key => $status) {
			if ($key > 0) {
				if (isset($statusParam) && $statusParam === $status) {
					$block .= '<option value="' . $status . '" selected="selected">' . $status . '</option>';
				} else {
					$block .= '<option value="'. $status .'">' . $status . '</option>';
				}
			} else {
				$block .= '<option>' . $status . '</option>';
			}
		}
		return $block;
	}
}