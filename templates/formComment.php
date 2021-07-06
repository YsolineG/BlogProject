<?php
$route = isset($post) && $post->get('comment_id') ? 'editComment' : 'addComment';
$submit = $route === 'addComment' ? 'Ajouter' : 'Mettre à jour';
?>

<form method="post" action="../public/index.php?route=<?= $route; ?>&idBlogPost=<?= htmlspecialchars($blogPost->getId()) ?>">
    <label for="content">Message</label><br>
    <textarea id="content" name="content"><?= isset($post) ? htmlspecialchars($post->get('content')): '' ?></textarea><br>
    <?= isset($errors['content']) ? $errors['content'] : ''; ?>
    <input type="submit" value="<?= $submit ?>" id="submit" name="submit">
</form>