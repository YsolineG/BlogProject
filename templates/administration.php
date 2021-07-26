<?php $this->title = 'Administration'; ?>

<h1>Mon blog</h1>
<p>En construction</p>
<?= $this->session->show('addBlogPost') ?>
<?= $this->session->show('editBlogPost') ?>
<?= $this->session->show('deleteBlogPost') ?>
<?= $this->session->show('deleteUser') ?>

<h2>Articles</h2>
<a href="../public/index.php?route=addBlogPost">Nouvel article</a>
<table>
    <tr>
        <td>Id</td>
        <td>Titre</td>
        <td>Contenu</td>
        <td>Date</td>
        <td>Actions</td>
    </tr>
    <?php
    foreach ($blogPosts as $blogPost)
    {
        ?>
        <tr>
            <td><?= htmlspecialchars($blogPost->getId())?></td>
            <td><a href="../public/index.php?route=blogPost&idBlogPost=<?= htmlspecialchars($blogPost->getId())?>"><?= htmlspecialchars($blogPost->getTitle())?></a></td>
            <td><?= substr(htmlspecialchars($blogPost->getContent()), 0, 150)?></td>
            <td>Créé le : <?= htmlspecialchars($blogPost->getCreatedAt())?></td>
            <td>
                <a href="../public/index.php?route=editBlogPost&idBlogPost=<?= $blogPost->getId() ?>">Modifier</a>
                <a href="../public/index.php?route=deleteBlogPost&idBlogPost=<?= $blogPost->getId() ?>">Supprimer</a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>

<h2>Utilisateurs</h2>
<table>
    <tr>
        <td>Id</td>
        <td>Pseudo</td>
        <td>Rôle</td>
        <td>Actions</td>
    </tr>
    <?php
    foreach ($users as $user)
    {
        ?>
        <tr>
            <td><?= htmlspecialchars($user->getId())?></td>
            <td><?= htmlspecialchars($user->getPseudo())?></td>
            <td><?= htmlspecialchars($user->getRole())?></td>
            <td>
                <?php
                if($user->getRole() != 'admin') {
                ?>
                <a href="../public/index.php?route=deleteUser&userId=<?= $user->getId() ?>">Supprimer</a>
                <?php } else {
                    ?>
                Suppression impossible
                <?php
                }
                ?>
            </td>
        </tr>
        <?php
    }
    ?>
</table>