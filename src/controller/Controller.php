<?php

namespace BlogProject\src\controller;

use BlogProject\config\Request;
use BlogProject\src\DAO\BlogPostDAO;
use BlogProject\src\DAO\CommentDAO;
use BlogProject\src\model\View;
use BlogProject\src\constraint\Validation;
use BlogProject\src\DAO\UserDAO;

abstract class Controller
{
    protected $blogPostDAO;
    protected $commentDAO;
    protected $view;
    private $request;
    protected $get;
    protected $post;
    protected $session;
    protected $validation;
    protected $userDAO;

    public function __construct()
    {
        $this->blogPostDAO = new BlogPostDAO();
        $this->commentDAO = new CommentDAO();
        $this->view = new View();
        $this->request = new Request();
        $this->get = $this->request->getGet();
        $this->post = $this->request->getPost();
        $this->session = $this->request->getSession();
        $this->validation = new Validation();
        $this->userDAO = new UserDAO();
    }
}