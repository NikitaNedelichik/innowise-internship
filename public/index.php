<?php

session_start();

ini_set('error_log', 'errors');

require_once '../vendor/autoload.php';

use Innowise\system\App;

$app = new App();

$app->run();
