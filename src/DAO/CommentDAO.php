<?php

namespace BlogProject\src\DAO;

use BlogProject\src\model\Comment;

class CommentDAO extends Database
{

    public function buildObject($row)
    {
        $comment = new Comment();
        $comment->setId($row['comment_id']);
        $comment->setContent($row['content']);
        $comment->setCreatedAt($row['created_at']);
        $comment->setUpdatedAt($row['updated_at']);
        return $comment;
    }

    public function getComments($idBlogPost)
    {
        $sql = 'SELECT comment_id, id_user, content, created_at, updated_at, comment_state FROM comment WHERE id_blog_post';
        $result =  $this->createQuery($sql, [$idBlogPost]);
        $comments = [];
        foreach ($result as $row){
            $commentId = $row['comment_id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $comments;
    }
}