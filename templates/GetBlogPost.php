<?php

require '../src/DAO/Database.php';
require '../src/DAO/BlogPost.php';
require '../src/DAO/Comment.php';

use BlogProject\src\DAO\BlogPost;
use BlogProject\src\DAO\Comment;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon blog</title>
</head>
<body>
    <?php
    $blogPost = new BlogPost();
    $blogPosts = $blogPost->getBlogPost($_GET["id"]);
    $blogPost = $blogPosts->fetch();
    ?>

    <div>
         <h2><?= htmlspecialchars($blogPost->title)?></h2>
            <p><?= htmlspecialchars($blogPost->content)?></p>
            <p>Créé le : <?= htmlspecialchars($blogPost->created_at)?></p>
            <p>Modifié le : <?= htmlspecialchars($blogPost->updated_at)?></p>
    </div>

    <?php
    $blogPosts->closeCursor();
    ?>

    <a href='home.php'>Retour à l'accueil</a>
    <div>
        <h3>Commentaires</h3>
        <?php
        $comment = new Comment();
        $comments = $comment->getComments($_GET["id"]);
        while($comment = $comments->fetch())
        {
            ?>
            <p><?= htmlspecialchars($comment->content)?></p>
            <p>Posté le <?= htmlspecialchars($comment->created_at)?></p>
            <?php
        }
        $comments->closeCursor();
        ?>
    </div>
</body>
</html>