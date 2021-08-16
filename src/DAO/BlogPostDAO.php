<?php

namespace BlogProject\src\DAO;

use BlogProject\src\model\BlogPost;
use BlogProject\src\model\User;

class BlogPostDAO extends Database
{

    private function buildObject($row)
    {
        $blogPost = new BlogPost();
        $blogPost->setId($row['blog_post_id']);
        $blogPost->setTitle($row['title']);
        $blogPost->setContent($row['content']);
        $blogPost->setCreatedAt($row['created_at']);
        $blogPost->setUpdatedAt($row['updated_at']);
        $blogPost->setChapeau($row['chapeau']);

        $user = new User();
        $user->setPseudo($row['user_pseudo']);
        $blogPost->setUser($user);

        return $blogPost;
    }

    public function getBlogPosts()
    {
        $sql = 'SELECT blog_post.blog_post_id, blog_post.title, blog_post.chapeau, blog_post.content, blog_post.created_at, blog_post.updated_at, url_picture, user.pseudo AS user_pseudo
                FROM blog_post
                INNER JOIN user
                ON blog_post.id_user = user.user_id';
        $result = $this->createQuery($sql);
        $blogPosts = [];
        foreach ($result as $row) {
            $blogPostId = $row['blog_post_id'];
            $blogPosts[$blogPostId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $blogPosts;
    }

    public function getBlogPost($idBlogPost)
    {
        $sql = 'SELECT blog_post.blog_post_id, blog_post.title, blog_post.chapeau, blog_post.content, blog_post.created_at, blog_post.updated_at, url_picture, user.pseudo AS user_pseudo
                FROM blog_post
                INNER JOIN user
                ON blog_post.id_user = user.user_id
                WHERE blog_post_id = ?';
        $result =  $this->createQuery($sql, [$idBlogPost]);
        $blogPost = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($blogPost);
    }

    public function addBlogPost($post, $userId)
    {
        $sql = 'INSERT INTO blog_post(title, chapeau, content, created_at, id_user) VALUES (?,?,?,NOW(),?)';
        $this->createQuery($sql, [
            $post->get('title'),
            $post->get('chapeau'),
            $post->get('content'),
            $userId
        ]);
    }

    public function editBlogPost($post, $idBlogPost)
    {
        $sql = 'UPDATE blog_post SET title = :title, chapeau = :chapeau, content = :content, updated_at = NOW() WHERE blog_post_id=:idBlogPost';
        $this->createQuery($sql, [
            'title' => $post->get('title'),
            'chapeau' => $post->get('chapeau'),
            'content' => $post->get('content'),
            'idBlogPost' => $idBlogPost
        ]);
    }

    public function deleteBlogPost($idBlogPost)
    {
        $sql = 'DELETE FROM comment WHERE id_blog_post = ?';
        $this->createQuery($sql, [$idBlogPost]);
        $sql = 'DELETE FROM blog_post WHERE blog_post_id = ?';
        $this->createQuery($sql, [$idBlogPost]);
    }
}