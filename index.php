<?php
include('includes/connexion.inc.php');
include('includes/haut.inc.php');

$id=0;
$rep="";
$npp=5;

?>

<div class="row">
    <form method="post" action="index.php">
        <div class="col-sm-10">
            <div class="form-group">
                <textarea id="recherche" name="recherche" class="form-control" placeholder="Recherche"> <?php echo $rep;?></textarea>
            </div>
        </div>
        <div class="col-sm-2">
            <button type="submit" class="btn btn-success btn-lg">Rechercher</button>
        </div>
    </form>
</div>

<?php
$query = "select count(*) as total from messages ";
$prep = $pdo->query($query);
$data= $prep->fetch();
$nb_msg=$data['total'];
$nb_pages=($nb_msg) ? ceil($nb_msg/$npp) : 1;
if (isset($_GET['page']) && !empty($_GET['page'])){
    $page=$_GET['page'];
}
else{
  $page=1;
}

$index= ($page -1) * $npp;
if (isset($_POST['recherche']) && !empty($_POST['recherche'])){
  $variable=$_POST['recherche'];
  $query = 'SELECT *, messages.id as message_id FROM
          messages INNER JOIN utilisateur on messages.user_id =  utilisateur.id where messages.contenu LIKE "%'.$variable.'%" ';
}
else{
  $query = 'SELECT *, messages.id as message_id FROM
          messages INNER JOIN utilisateur on messages.user_id =  utilisateur.id  LIMIT '.$index.','.$npp.'';

}
$stmt = $pdo->query($query);

if (isset($_GET['id']) && !empty($_GET['id'])){

  $id=$_GET['id'];
  $query = "select * from messages where id='".$id."'";
  $prep = $pdo->query($query);
  if($data=$prep->fetch()){
    $rep=$data['contenu'];
  }
}


while ($data = $stmt->fetch()) {
	?>
	<blockquote>
    <p>Posté par <?= $data['pseudo'] ?></p>
		<?= $data['contenu']?>
    <?php if ($connecte==true){ ?>
      <a href="index.php?id=<?=$data['message_id']?>"><button type="button" class="btn btn-success btn-lg">Modifier</button></a>
      <a href="suppression_message.php?id=<?=$data['message_id']?>"><button type="button" class="btn btn-primary btn-lg">Supprimer</button></a>
    <?php } ?>

    <?= date("Y-a-m H:i:s",$data['dateC']) ?>


	</blockquote>

	<?php
}

?>

<?php if($connecte==true){?>
<div class="row">
    <form method="post" action="message.php">
        <div class="col-sm-10">
            <div class="form-group">
                <textarea id="message" name="message" class="form-control" placeholder="Message"> <?php echo $rep;?></textarea>
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
  <?php if($page>1){ ?>
    <li><a href="index.php?page=<?= $page-1 ?>"><</a></li>
<?php }for($i=1;$i <= $nb_pages ; $i++){
  ?>
    <li><a href="index.php?page=<?= $i ?>"><?php echo $i?></a></li> <?php
  }if($page < $nb_pages){ ?>
    <li><a href="index.php?page=<?= $page+1 ?>">></a></li>
    <?php } ?>
</ul>


<?php include('includes/bas.inc.php'); ?>
<script> alert(</script><?php  echo $page ?> <script>)</script>
