<?php $this->title = "Formulaire de contact"; ?>

<h1>Mon blog</h1>
<p>En construction</p>

<div>
    <form method="post" action="../public/index.php?route=contactForm">
        <label for="name">Nom</label><br>
        <input type="text" id="name" name="lastname" required placeholder="Nom"><br>
        <label for="firstName">Prénom</label><br>
        <input type="text" id="firstName" name="firstname" required placeholder="Prénom"><br>
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" required placeholder="Email"><br>
        <label for="object">Objet du message</label><br>
        <input type="text" id="object" name="object" required placeholder="Objet du message"><br>
        <label for="message">Message</label><br>
        <input type="text" id="message" name="message" required placeholder="Message"><br>
        <input type="submit" value="Envoyer" id="submit" name="submit">
    </form>
    <a href="../public/index.php">Retour à l'accueil</a>
</div>


