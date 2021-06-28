<?php

namespace BlogProject\src\controller;

class FrontController extends Controller
{
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