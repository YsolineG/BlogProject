<?php

use BlogProject\src\model\Comment;

$this->title = "Article";?>
    <h1>Mon blog</h1>
    <div>
         <h2><?= htmlspecialchars($blogPost->getTitle())?></h2>
            <p><?= htmlspecialchars($blogPost->getContent())?></p>
            <p>Créé le : <?= htmlspecialchars($blogPost->getCreatedAt())?></p>
            <p>Modifié le : <?= htmlspecialchars($blogPost->getUpdatedAt())?></p>
    </div>
    <a href="../public/index.php">Retour à l'accueil</a>
    <div>
        <h3>Ajouter un commentaire</h3>
        <?php include('formComment.php')?>
        <h3>Commentaires</h3>
        <?php
        /** @var Comment $comment */
        foreach ($comments as $comment)
        {
            ?>
            <p><?= htmlspecialchars($comment->getContent())?></p>
            <p>Posté le <?= htmlspecialchars($comment->getCreatedAt())?></p>
            <p>Par <?= htmlspecialchars($comment->getUser()->getPseudo())?></p>

            <p><a href="../public/index.php?route=deleteComment&idComment=<?= $comment->getId() ?>">Supprimer le commentaire</a></p>
            <?php
        }
        ?>
    </div>