<?php

namespace BlogProject\src\DAO;

use BlogProject\src\model\Comment;
use BlogProject\src\model\User;
use BlogProject\src\model\BlogPost;

class CommentDAO extends Database
{

    public function buildObject($row): Comment
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

    public function buildObjectForAdmin($row): Comment
    {
        $comment = $this->buildObject($row);

        $blogPost = new BlogPost();
        $blogPost->setTitle($row['blog_post_title']);
        $comment->setBlogPost($blogPost);

        return $comment;
    }

    public function getCommentsForBlogPostId($idBlogPost): array
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

    public function getInvalidComments(): array
    {
        $sql = 'SELECT comment.comment_id, comment.content, comment.created_at, comment.updated_at, comment.comment_state, comment.comment_state, user.pseudo AS user_pseudo, blog_post.title AS blog_post_title
                FROM comment
                INNER JOIN user
                ON comment.id_user = user.user_id
                INNER JOIN blog_post
                ON comment.id_blog_post = blog_post.blog_post_id
                WHERE comment_state = "invalid"';
        $result = $this->createQuery($sql);
        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['comment_id'];
            $comments[$commentId] = $this->buildObjectForAdmin($row);
        }
        return $comments;
    }

    public function addComment($post, $idBlogPost, $idUser): void
    {
        $sql = 'INSERT INTO comment (content, created_at, id_blog_post, id_user, comment_state) VALUES (?, NOW(), ?, ?, "invalid")';
        $this->createQuery($sql, [$post->get('content'), $idBlogPost, $idUser]);
    }

    public function deleteComment($idComment): void
    {
        $sql = 'DELETE FROM comment WHERE comment_id = ?';
        $this->createQuery($sql, [$idComment]);
    }

    public function validateComment($idComment): void
    {
        $sql = 'UPDATE comment SET comment_state = "valid" WHERE comment_id = :idComment';
        $this->createQuery($sql, ['idComment' => $idComment]);
    }
}