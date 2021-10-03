<?php

namespace BlogProject\src\model;

use BlogProject\config\Request;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class View
{
    private $request;
    private $session;

    public function __construct()
    {
        $this->request = new Request();
        $this->session = $this->request->getSession();
    }

    public function renderTwig($template, $data = []): void
    {
        $data['session'] = $this->session;
        $loader = new FilesystemLoader('../templates');
        $twig = new Environment($loader, [
            'debug' => true,
        ]);
        $twig->addExtension(new DebugExtension());
        exit($twig->render($template, $data));
    }
}