<?php $this->title = "Modifier l'article"; ?>
<h1>Mon blog</h1>
<p>En construction</p>
<div>
    <form method="post" action="../public/index.php?route=editBlogPost&idBlogPost=<?= htmlspecialchars($blogPost->getId()) ?>">
        <label for="title">Titre</label><br>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($blogPost->getTitle()) ?>"><br>
        <label for="content">Contenu</label><br>
        <textarea id="content" name="content"><?= htmlspecialchars($blogPost->getContent()) ?></textarea><br>
        <input type="submit" value="Mettre à jour" id="submit" name="submit">
    </form>
    <a href="../public/index.php">Retour à l'accueil</a>
</div>