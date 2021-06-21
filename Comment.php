<?php

class Comment extends Database
{
    public function getComments($idPost)
    {
        $sql = 'SELECT comment_id, id_user, content, created_at, updated_at, comment_state FROM comment WHERE id_blog_post';
        return $this->createQuery($sql, [$idPost]);
    }
}