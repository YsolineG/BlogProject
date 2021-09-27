<?php

namespace BlogProject\src\controller;

use BlogProject\config\Parameter;

class FrontController extends Controller
{
    public function home(): void
    {
        $blogPosts = $this->blogPostDAO->getBlogPosts();
        $this->view->renderTwig('home.html.twig', ['blogPosts' => $blogPosts]);
    }

    public function blogPost($idBlogPost): void
    {
        $blogPost = $this->blogPostDAO->getBlogPost($idBlogPost);
        $comments = $this->commentDAO->getCommentsForBlogPostId($idBlogPost);
        $this->view->renderTwig('GetBlogPost.html.twig', [
            'blogPost' => $blogPost,
            'comments' => $comments
        ]);
    }

    public function addComment($post, $idBlogPost): void
    {
        if($this->checkLoggedIn() && $post->get('submit')) {
            $errors = $this->validation->validate($post, 'Comment');
            if($errors) {
                $blogPost = $this->blogPostDAO->getBlogPost($idBlogPost);
                $comments = $this->commentDAO->getCommentsForBlogPostId($idBlogPost);
                $this->view->renderTwig('GetBlogPost.html.twig', [
                    'blogPost' => $blogPost,
                    'comments' => $comments,
                    'post' => $post,
                    'errors' => $errors
                ]);
            }
            $this->commentDAO->addComment($post, $idBlogPost, $this->session->get('id'));
            $this->session->set('addComment', 'Le commentaire a bien été ajouté et est en attente de validation');
            header('Location:../public/index.php?route=blogPost&idBlogPost=' . $idBlogPost);
        }
    }

    public function register($post): void
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
                // récupérer notre utilisateur nouvellement créé
                // connecter cet utilisateur
                $result = $this->userDAO->login($post);
                $this->session->set('id', $result['result']['user_id']);
                $this->session->set('role', $result['result']['name']);
                $this->session->set('pseudo', $post->get('pseudo'));

                header('Location:../public/index.php');
            }
            $this->view->renderTwig('register.html.twig', [
                'post' => $post,
                'errors' => $errors
            ]);
        }
        $this->view->renderTwig('register.html.twig');
    }

    public function login($post): void
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
                $this->view->renderTwig('login.html.twig', [
                    'post' => $post
                ]);
            }
        }
        $this->view->renderTwig('login.html.twig');
    }

    public function contactForm(Parameter $post): void
    {
        if($post->get('submit')) {
            $errors = $this->validation->validate($post, 'ContactForm');
            if($errors) {
                $this->view->renderTwig('home.html.twig', [
                    'errors' => $errors
                ]);
            }
            $this->session->set('contactForm', 'Le message a bien été envoyé');
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

        $this->view->renderTwig('home.html.twig');
    }

    public function allBlogPosts(): void
    {
        $blogPosts = $this->blogPostDAO->getBlogPosts();
        $this->view->renderTwig('allBlogPosts.html.twig', ['blogPosts' => $blogPosts]);
    }
}