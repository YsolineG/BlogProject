<?php

namespace BlogProject\src\DAO;

use BlogProject\config\Parameter;
use BlogProject\src\model\BlogPost;

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
        return $blogPost;
    }

    public function getBlogPosts()
    {
        $sql = 'SELECT blog_post_id, title, content, created_at, updated_at, url_picture FROM blog_post';
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
        $sql = 'SELECT blog_post_id, title, content, created_at, updated_at, url_picture FROM blog_post WHERE blog_post_id = ?';
        $result =  $this->createQuery($sql, [$idBlogPost]);
        $blogPost = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($blogPost);
    }

    public function addBlogPost($post, $userId)
    {
        $sql = 'INSERT INTO blog_post(title, content, created_at, id_user) VALUES (?,?,NOW(),?)';
        $this->createQuery($sql,[$post->get('title'), $post->get('content'), $userId]);
    }

    public function editBlogPost($post, $idBlogPost)
    {
        $sql = 'UPDATE blog_post SET title = :title, content = :content, updated_at = NOW() WHERE blog_post_id=:idBlogPost';
        $this->createQuery($sql, [
            'title' => $post->get('title'),
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