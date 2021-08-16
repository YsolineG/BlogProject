<?php

namespace BlogProject\src\controller;

use BlogProject\config\Parameter;

class FrontController extends Controller
{
    public function home()
    {
        $blogPosts = $this->blogPostDAO->getBlogPosts();
        $this->view->renderTwig('home.html.twig', ['blogPosts' => $blogPosts]);
    }

    public function blogPost($idBlogPost)
    {
        $blogPost = $this->blogPostDAO->getBlogPost($idBlogPost);
        $comments = $this->commentDAO->getComments($idBlogPost);
        return $this->view->renderTwig('GetBlogPost.html.twig', [
            'blogPost' => $blogPost,
            'comments' => $comments
        ]);
    }

    public function addComment($post, $idBlogPost)
    {
        if($post->get('submit')) {
            $errors = $this->validation->validate($post, 'Comment');
            if(!$errors) {
                $comment = $this->commentDAO->addComment($post, $idBlogPost, $this->session->get('id'));
                $this->session->set('addComment', 'Le nouveau commentaire a bien été ajouté');
                header('Location:../public/index.php?route=blogPost&idBlogPost='.$idBlogPost);
            }
            $blogPost = $this->blogPostDAO->getBlogPost($idBlogPost);
            $comments = $this->commentDAO->getComments($idBlogPost);
            return $this->view->renderTwig('GetBlogPost.html.twig', [
                'blogPost' => $blogPost,
                'comments' => $comments,
                'post' => $post,
                'errors' => $errors
            ]);
        }
    }

    public function register($post)
    {
        if($post->get('submit')) {
            $errors = $this->validation->validate($post, 'User');
            if(!$errors) {
                $this->userDAO->register($post);
                $this->session->set('register', 'Votre inscription a bien été effectuée');
                header('Location:../public/index.php');
            }
            return $this->view->renderTwig('register.html.twig', [
                'post' => $post,
                'errors' => $errors
            ]);
        }
        return $this->view->renderTwig('register.html.twig');
    }

    public function login($post)
    {
        if($post->get('submit')) {
            $result = $this->userDAO->login($post);
            if($result && $result['isPasswordValid']) {
                $this->session->set('login', 'Content de vous revoir');
                $this->session->set('id', $result['result']['user_id']);
                $this->session->set('role', $result['result']['name']);
                $this->session->set('pseudo', $post->get('pseudo'));
                header('Location:../public/index.php');
            } else {
                $this->session->set('error_login', 'Le pseudo ou le mot de passe sont incorrects');
                return $this->view->renderTwig('loginL.html.twig', [
                    'post' => $post
                ]);
            }
        }
        return $this->view->renderTwig('login.html.twig');
    }

    public function contactForm(Parameter $post)
    {
        var_dump($post);
        if($post->get('submit')) {
            $headers = array(
                'From' => $post->get('lastname').' '.$post->get('firstname').' <'.$post->get('email').'>',
                'Reply-To' => $post->get('email'),
                'X-Mailer' => 'PHP/' . PHP_VERSION
            );

            mail(
                'ysoline.ganster@gmail.com',
                $post->get('object'),
                $post->get('message'),
                $headers
            );
        }

        return $this->view->renderTwig('contactForm.html.twig');
    }
}