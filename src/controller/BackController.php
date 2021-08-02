<?php

namespace BlogProject\src\controller;

class BackController extends Controller
{
    public function addBlogPost($post)
    {
        if($this->checkAdmin()){
            if($post->get('submit')) {
                $errors = $this->validation->validate($post, 'BlogPost');
                if (!$errors) {
                    $this->blogPostDAO->addBlogPost($post);
                    $this->session->set('addBlogPost', 'Le nouvel article a bien été ajouté');
                    header('Location:../public/index.php?route=administration');
                }
                return $this->view->render('addBlogPost', [
                    'post' => $post,
                    'errors' => $errors
                ]);
            }
            return $this->view->render('addBlogPost');
        }
    }

    public function editBlogPost($post, $idBlogPost)
    {
        if($this->checkAdmin()){
            $blogPost = $this->blogPostDAO->getBlogPost($idBlogPost);
            if($post->get('submit')) {
                $errors = $this->validation->validate($post, 'BlogPost');
                if (!$errors) {
                    $this->blogPostDAO->editBlogPost($post, $idBlogPost, $this->session->get('blog_post_id'));
                    $this->session->set('editBlogPost', 'l\'article a bien été modifié');
                    header('Location:../public/index.php?route=administration');
                }
                return $this->view->render('editBlogPost', [
                    'post' => $post,
                    'errors' => $errors
                ]);
            }
            $post->set('blog_post_id', $blogPost->getId());
            $post->set('title', $blogPost->getTitle());
            $post->set('content', $blogPost->getContent());

            return $this->view->render('editBlogPost', [
                'post' => $post
            ]);
        }
    }

    public function deleteBlogPost($idBlogPost)
    {
        if($this->checkAdmin()){
            $this->blogPostDAO->deleteBlogPost($idBlogPost);
            $this->session->set('deleteBlogPost', 'L\'article a bien été supprimé');
            header('Location:../public/index.php?route=administration');
        }
    }

    public function deleteComment($idComment)
    {
        if($this->checkAdmin()){
            $this->commentDAO->deleteComment($idComment);
            $this->session->set('deleteComment', 'Le commentaire a bien été supprimé');
            header('Location:../public/index.php');
        }
    }

    public function profile()
    {
        if($this->checkLoggedIn()) {
            return $this->view->render('profile');
        }
    }

    public function updatePassword($post)
    {
        if($this->checkLoggedIn()) {
            if($post->get('submit')) {
                $this->userDAO->updatePassword($post, $this->session->get('pseudo'));
                $this->session->set('updatePassword', 'Le mot de passe a été mis à jour');
                header('Location:../public/index.php?route=profile');
            }
            return $this->view->render('updatePassword');
        }
    }

    public function logout()
    {
        if($this->checkLoggedIn()){
            $this->logoutOrDeleteAccount('logout');
            header('Location:../public/index.php');
        }
    }

    public function deleteAccount()
    {
        if($this->checkLoggedIn()){
            $this->userDAO->deleteAccount($this->session->get('pseudo'));
            $this->logoutOrDeleteAccount('deleteAccount');
        }
    }

    private function logoutOrDeleteAccount($param)
    {
        $this->session->stop();
        $this->session->start();
        if($param === 'logout') {
            $this->session->set($param, 'A bientôt');
        } else {
            $this->session->set($param, 'Votre compte a bien été supprimé');
        }
        header('Location:/../public/index.php');
    }

    public function administration()
    {
        if($this->checkAdmin()) {
            $blogPosts = $this->blogPostDAO->getBlogPosts();
            $users = $this->userDAO->getUsers();

            return $this->view->render('administration', [
                'blogPosts' => $blogPosts,
                'users' => $users
            ]);
        }
    }

    public function deleteUser($userId)
    {
        if($this->checkAdmin()) {
            $this->userDAO->deleteUser($userId);
            $this->session->set('deleteUser', 'L\'utilisateur a bien été supprimé');
            header('Location:../public/index.php?route=administration');
        }
    }

    public function checkLoggedIn()
    {
        if(!$this->session->get('pseudo')) {
            $this->session->set('neddLogin', 'Vous devez vous connecter pour accéder à cette page');
            header('Location:../public/index.php?route=login');
        } else {
            return true;
        }
    }

    public function checkAdmin()
    {
        $this->checkLoggedIn();
        if(!$this->session->get('role') === 'admin') {
            $this->session->set('notAdmain', 'Vous n\'ave pas le droit d\'accéder à cette page');
            header('Location:../public/index.php?route=profile');
        } else {
            return true;
        }
    }
}