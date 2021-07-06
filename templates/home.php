<?php $this->title = 'Accueil'; ?>

<?= $this->session->show('addBlogPost') ?>
<?= $this->session->show('editBlogPost') ?>
<?= $this->session->show('deleteBlogPost') ?>
<?= $this->session->show('addComment') ?>
<?= $this->session->show('deleteComment') ?>
<?= $this->session->show('register') ?>

<a href="../public/index.php?route=register">Inscription</a>
<a href="../public/index.php?route=login">Connexion</a>
<a href="../public/index.php?route=addBlogPost">Nouvel article</a>
<?php
foreach ($blogPosts as $blogPost) {
    ?>
    <div>
        <h2>
            <a href="../public/index.php?route=blogPost&idBlogPost=<?= htmlspecialchars($blogPost->getId()) ?>">
                <?= htmlspecialchars($blogPost->getTitle()) ?>
            </a>
        </h2>
        <p><?= htmlspecialchars($blogPost->getContent()) ?></p>
        <p>Créé le : <?= htmlspecialchars($blogPost->getCreatedAt()) ?></p>
        <p>Modifié le : <?= htmlspecialchars($blogPost->getUpdatedAt()) ?></p>
    </div>
    <?php
}
?>