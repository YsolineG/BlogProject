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

//    public function render($template, $data = [])
//    {
//        $this->file = '../templates/'.$template.'.php';
//        $content  = $this->renderFile($this->file, $data);
//        $view = $this->renderFile('../templates/base.php', [
//            'title' => $this->title,
//            'content' => $content,
//            'session' => $this->session
//        ]);
//        echo $view;
//    }

//    private function renderFile($file, $data)
//    {
//        if(file_exists($file)){
//            extract($data);
//            ob_start();
//            require $file;
//            return ob_get_clean();
//        }
//        header('Location: index.php?route=notFound');
//    }

    public function renderTwig($template, $data = []): void
    {
        $data['session'] = $this->session;
        $loader = new FilesystemLoader('../templates');
        $twig = new Environment($loader, [
            'debug' => true,
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        echo $twig->render($template, $data);
    }
}