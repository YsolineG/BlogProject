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

    public function editBlogPost($post, $idBlogPost){
        $blogPost = $this->blogPostDAO->getBlogPost($idBlogPost);
        if($post->get('submit')) {
            $this->blogPostDAO->editBlogPost($post, $idBlogPost);
            $this->session->set('editBlogPost', 'l\'article a bien été modifié');
            header('Location:../public/index.php');
        }

        return $this->view->render('editBlogPost', [
            'blogPost' => $blogPost
        ]);
    }
}