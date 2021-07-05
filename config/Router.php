<?php

namespace BlogProject\config;

use BlogProject\src\controller\ErrorController;
use BlogProject\src\controller\FrontController;
use BlogProject\src\controller\BackController;
use Exception;

class Router
{
    private $frontController;
    private $errorController;
    private $backController;
    private $request;

    public function __construct()
    {
        $this->request = new Request();
        $this->frontController = new FrontController();
        $this->errorController = new ErrorController();
        $this->backController = new BackController();
    }

    public function run()
    {
        $route = $this->request->getGet()->get('route');
        try {
            if (isset($route)) {
                if ($route === 'blogPost') {
                    $this->frontController->blogPost($this->request->getGet()->get('idBlogPost'));
                } elseif ($route === 'addBlogPost'){
                    $this->backController->addBlogPost($this->request->getPost());
                } elseif ($route === 'editBlogPost'){
                    $this->backController->editBlogPost($this->request->getPost(), $this->request->getGet()->get('idBlogPost'));
                } elseif ($route === 'deleteBlogPost'){
                    $this->backController->deleteBlogPost($this->request->getGet()->get('idBlogPost'));
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