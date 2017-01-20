<?php
$connecte = false;
include('includes/connexion.inc.php');
include('includes/haut.inc.php');


//formulaire d'inscription qui renvoie a la connexion
?>
<form action="connexion.php" method="post">
    <div class="form-group">
        <label for="email">Nom:</label>
        <input type="text" class="form-control" name="nom" id="nom">
        <label for="prenom">Prénom:</label>
        <input type="text" class="form-control" name="prenom" id="prenom">
    </div>
    <div class="form-group">
        <label for="pseudo">Pseudo:</label>
        <input type="text" class="form-control" name="pseudo" id="pseudo">
    </div>
    <div class="form-group">
        <label for="email">Adresse e-mail:</label>
        <input type="email" class="form-control" name="email" id="email">
    </div>
    <div class="form-group">
        <label for="pwd">Mot de passe:</label>
        <input type="password" class="form-control" name="pwd" id="pwd">
    </div>
    <button type="submit" class="btn btn-default">Soumettre</button>
</form>


<?php include('includes/bas.inc.php'); ?>
