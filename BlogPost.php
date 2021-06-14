<?php

class BlogPost extends Database
{
    public function getBlogPosts()
    {
        $sql = 'SELECT blog_post_id, title, content, created_at, updated_at, url_picture FROM blog_post';
        return $this->createQuery($sql);
    }

    public function getBlogPost($id)
    {
        $sql = 'SELECT blog_post_id, title, content, created_at, updated_at, url_picture FROM blog_post WHERE blog_post_id = ?';
        return $this->createQuery($sql, [$id]);
    }
}