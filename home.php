<?php

require 'Database.php';
require 'BlogPost.php';

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
$blogPosts = $blogPost->getBlogPosts();
while ($blogPost = $blogPosts->fetch()) {
    ?>
    <div>
        <h2>
            <a href="GetBlogPost.php?id=<?= htmlspecialchars($blogPost['blog_post_id']); ?>">
                <?= htmlspecialchars($blogPost['title']); ?>
            </a>
        </h2>
        <p><?= htmlspecialchars($blogPost['content']); ?></p>
        <p>Créé le : <?= htmlspecialchars($blogPost['created_at']); ?></p>
        <p>Modifié le : <?= htmlspecialchars($blogPost['updated_at']); ?></p>
    </div>
    <?php
}
$blogPosts->closeCursor();
?>

</body>
</html>