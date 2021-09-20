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
        $comments = $this->commentDAO->getCommentsForBlogPostId($idBlogPost);
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
                $this->commentDAO->addComment($post, $idBlogPost, $this->session->get('id'));
                $this->session->set('addComment', 'Le commentaire a bien été ajouté et est en attente de validation');
                header('Location:../public/index.php?route=blogPost&idBlogPost='.$idBlogPost);
            }
            $blogPost = $this->blogPostDAO->getBlogPost($idBlogPost);
            $comments = $this->commentDAO->getCommentsForBlogPostId($idBlogPost);
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
            if($this->userDAO->checkUserPseudo($post)){
                $errors['pseudo'] = $this->userDAO->checkUserPseudo($post);
            }
            if($this->userDAO->checkUserEmail($post)){
                $errors['email'] = $this->userDAO->checkUserEmail($post);
            }
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
                $this->session->set('error_login', 'Le pseudo ou le mot de passe est incorrect');
                return $this->view->renderTwig('login.html.twig', [
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

    public function allBlogPosts()
    {
        $blogPosts = $this->blogPostDAO->getBlogPosts();
        $this->view->renderTwig('allBlogPosts.html.twig', ['blogPosts' => $blogPosts]);
    }
}