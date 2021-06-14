<?php

require_once 'Database.php';

class BlogPost
{
    public function getBlogPosts()
    {
        $db = new Database();
        $connection = $db->getConnection();
        $result = $connection->query(
            'SELECT blog_post_id, title, content, created_at, updated_at, url_picture 
            FROM blog_post'
        );
        return $result;
    }
}