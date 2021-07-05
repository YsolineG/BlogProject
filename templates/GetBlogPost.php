<?php $this->title = "Article";?>
    <h1>Mon blog</h1>
    <div>
         <h2><?= htmlspecialchars($blogPost->getTitle())?></h2>
            <p><?= htmlspecialchars($blogPost->getContent())?></p>
            <p>Créé le : <?= htmlspecialchars($blogPost->getCreatedAt())?></p>
            <p>Modifié le : <?= htmlspecialchars($blogPost->getUpdatedAt())?></p>
    </div>
    <div class="actions">
        <a href="../public/index.php?route=editBlogPost&idBlogPost=<?=$blogPost->getId()?>">Modifier</a>
        <a href="../public/index.php?route=deleteBlogPost&idBlogPost=<?=$blogPost->getId()?>">Supprimer</a>
    </div>
    <a href="../public/index.php">Retour à l'accueil</a>
    <div>
        <h3>Commentaires</h3>
        <?php
        foreach ($comments as $comment)
        {
            ?>
            <p><?= htmlspecialchars($comment->getContent())?></p>
            <p>Posté le <?= htmlspecialchars($comment->getCreatedAt())?></p>
            <?php
        }
        ?>
    </div>