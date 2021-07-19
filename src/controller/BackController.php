<?php

namespace BlogProject\src\controller;

class BackController extends Controller
{
    public function addBlogPost($post)
    {
        if($post->get('submit')) {
            $errors = $this->validation->validate($post, 'BlogPost');
            if (!$errors) {
                $this->blogPostDAO->addBlogPost($post);
                $this->session->set('addBlogPost', 'Le nouvel article a bien été ajouté');
                header('Location:../public/index.php');
            }
            return $this->view->render('addBlogPost', [
                'post' => $post,
                'errors' => $errors
            ]);
        }
        return $this->view->render('addBlogPost');
    }

    public function editBlogPost($post, $idBlogPost)
    {
        $blogPost = $this->blogPostDAO->getBlogPost($idBlogPost);
        if($post->get('submit')) {
            $errors = $this->validation->validate($post, 'BlogPost');
            if (!$errors) {
                $this->blogPostDAO->editBlogPost($post, $idBlogPost);
                $this->session->set('editBlogPost', 'l\'article a bien été modifié');
                header('Location:../public/index.php');
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

    public function deleteBlogPost($idBlogPost)
    {
        $this->blogPostDAO->deleteBlogPost($idBlogPost);
        $this->session->set('deleteBlogPost', 'L\'article a bien été supprimé');
        header('Location:../public/index.php');
    }

    public function deleteComment($idComment)
    {
        $this->commentDAO->deleteComment($idComment);
        $this->session->set('deleteComment', 'Le commentaire a bien été supprimé');
        header('Location:../public/index.php');
    }

    public function profile()
    {
        return $this->view->render('profile');
    }

    public function updatePassword($post)
    {
        if($post->get('submit')) {
            $this->userDAO->updatePassword($post, $this->session->get('pseudo'));
            $this->session->set('updatePassword', 'Le mot de passe a été mis à jour');
            header('Location:../public/index.php?route=profile');
        }
        return $this->view->render('updatePassword');
    }

    public function logout()
    {
        $this->logoutOrDeleteAccount('logout');
    }

    public function deleteAccount()
    {
        $this->userDAO->deleteAccount($this->session->get('pseudo'));
        $this->logoutOrDeleteAccount('deleteAccount');
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
        header('Location/../public/index.php');
    }
}