<?php
$route = isset($blogPost) && $blogPost->getId() ? 'editBlogPost&idBlogPost='.$blogPost->getId() : 'addBlogPost';
$title = isset($blogPost) && $blogPost->getTitle() ? htmlspecialchars($blogPost->getTitle()) : '';
$content = isset($blogPost) && $blogPost->getContent() ? htmlspecialchars($blogPost->getContent()) : '';
?>

<form method="post" action="../public/index.php?route=<?= $route ?>">
    <label for="title">Titre</label><br>
    <input type="text" id="title" name="title" value="<?= $title ?>"><br>
    <label for="content">Contenu</label><br>
    <textarea id="content" name="content"><?= $content ?></textarea><br>
    <input type="submit" value="Envoyer" id="submit" name="submit">
</form>