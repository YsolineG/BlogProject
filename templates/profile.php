<?php $this->title = 'Mon profil'; ?>
<h1>Mon blog</h1>
<p>En construction</p>
<?= $this->session->show('updatePassword') ?>
<div>
    <h2><?= $this->session->get('pseudo') ?></h2>
    <p><?= $this->session->get('id') ?></p>
    <a href="../public/index.php?route=updatePassword">Modifier son mot de passe</a><br>
    <a href="../public/index.php?route=deleteAccount">Supprimer mon profil</a>
</div>
<br>
<a href="../public/index.php">Retour à l'accueil</a>