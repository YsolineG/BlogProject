<?php

namespace BlogProject\src\controller;

use BlogProject\src\DAO\BlogPostDAO;
use BlogProject\src\DAO\CommentDAO;
use BlogProject\src\model\View;

class FrontController
{
    private $blogPostDAO;
    private $commentDAO;
    private $view;

    public function __construct()
    {
        $this->blogPostDAO = new BlogPostDAO();
        $this->commentDAO = new CommentDAO();
        $this->view = new View();
    }

    public function home()
    {
        $blogPosts = $this->blogPostDAO->getBlogPosts();
        return $this->view->render('home', [
            'blogPosts' => $blogPosts
        ]);
    }

    public function blogPost($idBlogPost)
    {
        $blogPost = $this->blogPostDAO->getBlogPost($idBlogPost);
        $comments = $this->commentDAO->getComments($idBlogPost);
        return $this->view->render('GetBlogPost', [
            'blogPost' => $blogPost,
            'comments' => $comments
        ]);
    }
}