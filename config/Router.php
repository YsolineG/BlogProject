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
                } elseif ($route === 'addComment') {
                    $this->frontController->addComment($this->request->getPost(), $this->request->getGet()->get('idBlogPost'));
                } elseif ($route === 'deleteComment') {
                    $this->backController->deleteComment($this->request->getGet()->get('idComment'));
                } elseif ($route === 'register') {
                    $this->frontController->register($this->request->getPost());
                } elseif ($route === 'login') {
                    $this->frontController->login($this->request->getPost());
                } elseif ($route === 'profile') {
                    $this->backController->profile();
                } elseif ($route === 'updatePassword') {
                    $this->backController->updatePassword($this->request->getPost());
                } elseif ($route === 'logout') {
                    $this->backController->logout();
                } elseif ($route === 'deleteAccount') {
                    $this->backController->deleteAccount();
                } elseif ($route === 'administration') {
                    $this->backController->administration();
                } elseif ($route === 'deleteUser') {
                    $this->backController->deleteUser($this->request->getGet()->get('userId'));
                } elseif ($route === 'contactForm') {
                    $this->frontController->contactForm($this->request->getPost());
                } else {
                    $this->errorController->errorNotFound();
                }
            } else {
                $this->frontController->home();
            }
        } catch (Exception $e) {
            var_dump($e);
            $this->errorController->errorServer();
        }
    }
}