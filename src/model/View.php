<?php

namespace BlogProject\src\model;

use BlogProject\config\Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    private $file;
    private $title;
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
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        exit($twig->render($template, $data));
    }
}