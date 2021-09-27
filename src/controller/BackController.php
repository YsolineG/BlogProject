<?php

namespace BlogProject\src\controller;

class BackController extends Controller
{
    public function addBlogPost($post): void
    {
        if($this->checkAdmin()){
            if($post->get('submit')) {
                $errors = $this->validation->validate($post, 'BlogPost');
                if (!$errors) {
                    $this->blogPostDAO->addBlogPost($post, $this->session->get('id'));
                    $this->session->set('successMessage', 'Le nouvel article a bien été ajouté');
                    header('Location:../public/index.php?route=administration');
                }
                $this->view->renderTwig('AddBlogPost.html.twig', [
                    'post' => $post,
                    'errors' => $errors
                ]);
            }
            $this->view->renderTwig('AddBlogPost.html.twig');
        }
    }

    public function editBlogPost($post, $idBlogPost): void
    {
        if($this->checkAdmin()){
            $blogPost = $this->blogPostDAO->getBlogPost($idBlogPost);
            if($post->get('submit')) {
                $errors = $this->validation->validate($post, 'BlogPost');
                if (!$errors) {
                    $this->blogPostDAO->editBlogPost($post, $idBlogPost, $this->session->get('blog_post_id'));
                    $this->session->set('successMessage', 'l\'article a bien été modifié');
                    header('Location:../public/index.php?route=administration');
                }
                $this->view->renderTwig('EditBlogPost.html.twig', [
                    'post' => $post,
                    'errors' => $errors
                ]);
            }
            $post->set('blog_post_id', $blogPost->getId());
            $post->set('title', $blogPost->getTitle());
            $post->set('chapeau', $blogPost->getChapeau());
            $post->set('content', $blogPost->getContent());

            $this->view->renderTwig('EditBlogPost.html.twig', [
                'post' => $post
            ]);
        }
    }

    public function deleteBlogPost($idBlogPost): void
    {
        if($this->checkAdmin()){
            $this->blogPostDAO->deleteBlogPost($idBlogPost);
            $this->session->set('successMessage', 'L\'article a bien été supprimé');
            header('Location:../public/index.php?route=administration');
        }
    }

    public function deleteComment($idComment): void
    {
        if($this->checkAdmin()){
            $this->commentDAO->deleteComment($idComment);
            $this->session->set('successMessage', 'Le commentaire a bien été supprimé');
            header('Location:../public/index.php?route=administration');
        }
    }

    public function profile(): void
    {
        if($this->checkLoggedIn()) {
            $this->view->renderTwig('profile.html.twig');
        }
    }

    public function updatePassword($post): void
    {
        if($this->checkLoggedIn()) {
            if($post->get('submit')) {
                $this->userDAO->updatePassword($post, $this->session->get('pseudo'));
                $this->session->set('successMessage', 'Le mot de passe a été mis à jour');
                header('Location:../public/index.php?route=profile');
            }
            $this->view->renderTwig('updatePassword.html.twig');
        }
    }

    public function logout(): void
    {
        if($this->checkLoggedIn()){
            $this->logoutOrDeleteAccount('logout');
            header('Location:../public/index.php');
        }
    }

    public function deleteAccount(): void
    {
        if($this->checkLoggedIn()){
            $this->userDAO->deleteAccount($this->session->get('pseudo'));
            $this->logoutOrDeleteAccount('deleteAccount');
        }
    }

    private function logoutOrDeleteAccount($param): void
    {
        $this->session->stop();
        $this->session->start();
        if($param === 'logout') {
            $this->session->set($param, 'A bientôt');
        } else {
            $this->session->set($param, 'Votre compte a bien été supprimé');
        }
        header('Location:../public/index.php');
    }

    public function administration(): void
    {
        if($this->checkAdmin()) {
            $blogPosts = $this->blogPostDAO->getBlogPosts();
            $users = $this->userDAO->getUsers();
            $comments = $this->commentDAO->getInvalidComments();
            $this->view->renderTwig('administration.html.twig', [
                'blogPosts' => $blogPosts,
                'users' => $users,
                'comments' => $comments
            ]);
        }
    }

    public function deleteUser($userId): void
    {
        if($this->checkAdmin()) {
            $this->userDAO->deleteUser($userId);
            $this->session->set('successMessage', 'L\'utilisateur a bien été supprimé');
            header('Location:../public/index.php?route=administration');
        }
    }

    public function checkAdmin(): bool
    {
        $this->checkLoggedIn();
        if($this->session->get('role') !== 'admin') {
            $this->session->set('notAdmin', 'Vous n\'avez pas le droit d\'accéder à cette page');
            header('Location:../public/index.php?route=profile');
        } else {
            return true;
        }
    }

    public function validateComment($idComment): void
    {
        if($this->checkAdmin()){
            $this->commentDAO->validateComment($idComment);
            $this->session->set('successMessage', 'Le commentaire a été validé');
            header('Location:../public/index.php?route=administration');
        }
    }
}