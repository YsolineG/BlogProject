<?php

namespace BlogProject\config;

use BlogProject\src\controller\ErrorController;
use Exception;
use BlogProject\src\controller\FrontController;

class Router
{
    private $frontController;
    private $errorController;

    public function __construct()
    {
        $this->frontController = new FrontController();
        $this->errorController = new ErrorController();
    }

    public function run()
    {
        try {
            if (isset($_GET['route'])) {
                if ($_GET['route'] === 'blogPost') {
                    $this->frontController->blogPost($_GET['idBlogPost']);
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