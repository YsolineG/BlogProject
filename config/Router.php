<?php

namespace BlogProject\config;

use BlogProject\src\controller\ErrorController;
use Exception;
use BlogProject\src\controller\FrontController;
use BlogProject\src\controller\BackController;

class Router
{
    private $frontController;
    private $errorController;
    private $backController;

    public function __construct()
    {
        $this->frontController = new FrontController();
        $this->errorController = new ErrorController();
        $this->backController = new BackController();
    }

    public function run()
    {
        try {
            if (isset($_GET['route'])) {
                if ($_GET['route'] === 'blogPost') {
                    $this->frontController->blogPost($_GET['idBlogPost']);
                } elseif ($_GET['route'] === 'addBlogPost'){
                    $this->backController->addBlogPost($_POST);
                } else {
                    $this->errorController->errorNotFound();
                }
            } else {
                $this->frontController->home();
            }
        } catch (Exception $e) {
            $this->errorController->errorServer();
        }
    }
}