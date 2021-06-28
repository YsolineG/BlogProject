<?php

namespace BlogProject\src\controller;

use BlogProject\src\DAO\BlogPostDAO;
use BlogProject\src\DAO\CommentDAO;
use BlogProject\src\model\View;

abstract class Controller
{
    protected $blogPostDAO;
    protected $commentDAO;
    protected $view;

    public function __construct()
    {
        $this->blogPostDAO = new BlogPostDAO();
        $this->commentDAO = new CommentDAO();
        $this->view = new View();
    }
}