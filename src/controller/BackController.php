<?php

namespace BlogProject\src\controller;

class BackController extends Controller
{
    public function addBlogPost($post)
    {
        if($post->get('submit')) {
            $this->blogPostDAO->addBlogPost($post);
            $this->session->set('addBlogPost', 'Le nouvel article a bien été ajouté');
            header('Location:../public/index.php');
        }
        return $this->view->render('addBlogPost', [
            'post' => $post
        ]);
    }
}