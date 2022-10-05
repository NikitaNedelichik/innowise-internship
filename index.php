<?php

require_once 'vendor/autoload.php';

use app\core\Application;
use app\core\controllers\Controller;
use app\core\Router;

$app = new Application();

Router::get('/', [new Controller(), 'home']);
Router::get('/create', 'create');
Router::post('/create', [new Controller(), 'create']);
Router::get('/delete', [new Controller(), 'delete']);
Router::get('/edit', [new Controller(), 'edit']);
Router::post('/edit', [new Controller(), 'edit']);

$app->run();
?>