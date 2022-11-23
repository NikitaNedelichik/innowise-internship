<?php

namespace Innowise\App\Views;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    private Environment $view;
    private FilesystemLoader $loader;

    public function __construct()
    {
        $this->loader = new FilesystemLoader('../templates');
        $this->view = new Environment($this->loader);
    }

    public function render(string $page, array $params = []): string
    {
        return $this->view->render($page . ".twig", $params);
    }
}
