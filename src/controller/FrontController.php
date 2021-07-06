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

    public function addComment($post, $idBlogPost)
    {
        if($post->get('submit')) {
            $errors = $this->validation->validate($post, 'Comment');
            if(!$errors) {
                $comment = $this->commentDAO->addComment($post, $idBlogPost);
                $this->session->set('addComment', 'Le nouveau commentaire a bien été ajouté');
                header('Location:../public/index.php?route=blogPost&idBlogPost='.$idBlogPost);
            }
            $blogPost = $this->blogPostDAO->getBlogPost($idBlogPost);
            $comments = $this->commentDAO->getComments($idBlogPost);
            return $this->view->render('getBlogPost', [
                'blogPost' => $blogPost,
                'comments' => $comments,
                'post' => $post,
                'errors' => $errors
            ]);
        }
    }
}