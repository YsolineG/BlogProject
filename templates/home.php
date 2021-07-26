<?php $this->title = 'Accueil'; ?>

<?= $this->session->show('addComment') ?>
<?= $this->session->show('deleteComment') ?>
<?= $this->session->show('register') ?>
<?= $this->session->show('login') ?>
<?= $this->session->show('logout') ?>
<?= $this->session->show('deleteAccount') ?>

<?php
if($this->session->get('pseudo')) {
    ?>
    <a href="../public/index.php?route=logout">Déconnexion</a>
    <a href="../public/index.php?route=profile">Profil</a>
    <?php if($this->session->get('role') === 'admin') { ?>
    <a href="../public/index.php?route=administration">Administration</a>
    <?php } ?>
    <?php
} else {
    ?>
    <a href="../public/index.php?route=register">Inscription</a>
    <a href="../public/index.php?route=login">Connexion</a>
    <?php
}
?>
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