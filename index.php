<?php
include('includes/connexion.inc.php');
include('includes/haut.inc.php');


$id = 0;
$rep = "";
//Nombre de messages postes par page
$npp = 5;
//Barre de recherche
?>
<div class="row">
    <form method="post" action="index.php">
        <div class="col-sm-10">
            <div class="form-group">
                <textarea id="recherche" name="recherche" class="form-control"
                          placeholder="Recherche"> <?php echo $rep; ?></textarea>
            </div>
        </div>
        <div class="col-sm-2">
            <button type="submit" class="btn btn-success btn-lg">Rechercher</button>
        </div>
    </form>
</div>

<?php
//permet de calculer le nombre total de messages
$query = "select count(*) as total from messages ";
$prep = $pdo->query($query);
$data = $prep->fetch();
$nb_msg = $data['total'];
$nb_pages = ($nb_msg) ? ceil($nb_msg / $npp) : 1;
//si l'utilisateur se situe au dela de la premiere page
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
//taille de l'index
$index = ($page - 1) * $npp;
//s'il y a sollicitation de la fonction de recherche
if (isset($_POST['recherche']) && !empty($_POST['recherche'])) {
    $variable = $_POST['recherche'];
    //requete de recherche
    $query = 'SELECT *, messages.id as message_id FROM
          messages INNER JOIN utilisateur on messages.user_id =  utilisateur.id where messages.contenu LIKE "%' . $variable . '%" ';
} //recuperation de tous les messages suivant la limite de messages par page
else {
    $query = 'SELECT *, messages.id as message_id FROM
          messages INNER JOIN utilisateur on messages.user_id =  utilisateur.id  LIMIT ' . $index . ',' . $npp . '';

}
$stmt = $pdo->query($query);

//recuperation du message quand l'utilisateur souhaite le modifier
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = $_GET['id'];
    $query = "select * from messages where id='" . $id . "'";
    $prep = $pdo->query($query);
    if ($data = $prep->fetch()) {
        $rep = $data['contenu'];
    }
}


while ($data = $stmt->fetch()) {
    //affichage des messages
    ?>
    <blockquote>
        <p>Posté par <?= $data['pseudo'] ?></p>
        <?= $data['contenu'] ?>
        <?php if ($connecte == true) { ?>
            <a href="index.php?id=<?= $data['message_id'] ?>">
                <button type="button" class="btn btn-success btn-lg">Modifier</button>
            </a>
            <a href="suppression_message.php?id=<?= $data['message_id'] ?>">
                <button type="button" class="btn btn-primary btn-lg">Supprimer</button>
            </a>
        <?php } ?>

        <?= date("Y-a-m H:i:s", $data['dateC']) ?>


    </blockquote>

    <?php
}

?>

<?php
//si l'utilisateur est connectte alors on lui autorise le post de message
if ($connecte == true) {
    ?>
    <div class="row">
        <form method="post" action="message.php">
            <div class="col-sm-10">
                <div class="form-group">
                    <textarea id="message" name="message" class="form-control"
                              placeholder="Message"> <?php echo $rep; ?></textarea>
                    <input type="hidden" name="id" value=<?php echo $id ?>>

                </div>
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-success btn-lg">Envoyer</button>
            </div>
        </form>
    </div>
<?php } ?>

<ul class="pagination">
    <?php if ($page > 1) { ?>
        <li><a href="index.php?page=<?= $page - 1 ?>"><</a></li>
    <?php }
    for ($i = 1; $i <= $nb_pages; $i++) {
        ?>
        <li><a href="index.php?page=<?= $i ?>"><?php echo $i ?></a></li> <?php
    }
    if ($page < $nb_pages) { ?>
        <li><a href="index.php?page=<?= $page + 1 ?>">></a></li>
    <?php } ?>
</ul>


<?php include('includes/bas.inc.php'); ?>
