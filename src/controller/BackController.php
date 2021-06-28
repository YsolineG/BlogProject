<?php

namespace BlogProject\src\controller;

use BlogProject\src\DAO\BlogPostDAO;
use BlogProject\src\model\View;

class BackController
{
    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function addBlogPost($post)
    {
        if(isset($post['submit'])) {
            $blogPostDAO = new BlogPostDAO();
            $blogPostDAO->addBlogPost($post);
            header('Location:../public/index.php');
        }
        return $this->view->render('addBlogPost', [
            'post' => $post
        ]);
    }
}