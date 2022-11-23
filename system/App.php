<?php

namespace Innowise\system;

use Innowise\app\Router\Router;

class App
{
    public function run()
    {
       echo Router::enable();
    }
}
