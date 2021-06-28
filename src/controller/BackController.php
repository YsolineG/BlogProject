<?php

namespace BlogProject\src\controller;

class BackController extends Controller
{
    public function addBlogPost($post)
    {
        if($post->get('submit')) {
            $this->blogPostDAO->addBlogPost($post);
            header('Location:../public/index.php');
        }
        return $this->view->render('addBlogPost', [
            'post' => $post
        ]);
    }
}