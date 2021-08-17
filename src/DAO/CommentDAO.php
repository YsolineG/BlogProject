<?php

namespace BlogProject\src\DAO;

use BlogProject\src\model\Comment;
use BlogProject\src\model\User;

class CommentDAO extends Database
{

    public function buildObject($row)
    {
        $comment = new Comment();
        $comment->setId($row['comment_id']);
        $comment->setContent($row['content']);
        $comment->setCreatedAt($row['created_at']);
        $comment->setUpdatedAt($row['updated_at']);
        $comment->setCommentState($row['comment_state']);

        $user = new User();
        $user->setPseudo($row['user_pseudo']);
        $comment->setUser($user);

        return $comment;
    }

    public function getCommentsForBlogPostId($idBlogPost)
    {
        $sql = 'SELECT comment.comment_id, comment.content, comment.created_at, comment.updated_at, comment.comment_state, comment.comment_state, user.pseudo AS user_pseudo
                FROM comment
                INNER JOIN user
                ON comment.id_user = user.user_id
                WHERE id_blog_post = ? AND comment_state = "valid"';
        $result = $this->createQuery($sql, [$idBlogPost]);
        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['comment_id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $comments;
    }

    public function getInvalidComments()
    {
        $sql = 'SELECT comment.comment_id, comment.content, comment.created_at, comment.updated_at, comment.comment_state, comment.comment_state, user.pseudo AS user_pseudo
                FROM comment
                INNER JOIN user
                ON comment.id_user = user.user_id
                WHERE comment_state = "invalid"';
        $result = $this->createQuery($sql);
        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['comment_id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        return $comments;
    }

    public function addComment($post, $idBlogPost, $idUser)
    {
        $sql = 'INSERT INTO comment (content, created_at, id_blog_post, id_user, comment_state) VALUES (?, NOW(), ?, ?, "invalid")';
        $this->createQuery($sql, [$post->get('content'), $idBlogPost, $idUser]);
    }

    public function deleteComment($idComment)
    {
        $sql = 'DELETE FROM comment WHERE comment_id = ?';
        $this->createQuery($sql, [$idComment]);
    }

    public function validateComment($idComment)
    {
        $sql = 'UPDATE comment SET comment_state = "valid" WHERE comment_id = :idComment';
        $this->createQuery($sql, ['idComment' => $idComment]);
    }
}