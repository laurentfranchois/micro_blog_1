<?php
include('includes/connexion.inc.php');
include('includes/haut.inc.php');

//verification du remplissage de tous les champs
if (isset($_POST['email']) && isset($_POST['pwd']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['pseudo'])) {
    ?>
    <script> alert(</script><?php echo $_POST['pwd'] ?>
    <script>)</script> <?php
    //insertion dans la base de donnees du nouvel utilisateur
    $query = 'INSERT INTO utilisateur(nom,prenom,mdp,mail,pseudo) values(?,?,?,?,?)';
    $prep = $pdo->prepare($query);
    $prep->bindValue(1, $_POST['nom']);
    $prep->bindValue(2, $_POST['prenom']);
    $prep->bindValue(3, $_POST['pwd']);
    $prep->bindValue(4, $_POST['email']);
    $prep->bindValue(5, $_POST['pseudo']);
    $prep->execute();
}


if (isset($_POST['email']) && isset($_POST['pwd'])) {
    //requete afin de se connecter
    $pwd = $_POST['pwd'];
    $email = $_POST['email'];

    $query = "SELECT * FROM utilisateur WHERE mail=? and mdp=?";
    $prep = $pdo->prepare($query);
    $prep->bindValue(1, $email);
    $prep->bindValue(2, $pwd);
    $prep->execute();


    if ($prep->fetch()) {
        //generation du sid a l'aide d'une fonction md5
        $sid = $email . time();
        $sid = md5($sid);
        setcookie("sid", $sid, time() + 300, null, null, false, true);
        $query = "UPDATE utilisateur SET sid=? where mail=?";
        $prep = $pdo->prepare($query);
        $prep->bindValue(1, $sid);
        $prep->bindValue(2, $email);
        $prep->execute();
        header("Location:index.php");
    }
}

?>

<form action="connexion.php" method="post">
    <div class="form-group">
        <label for="email">Email address:</label>
        <input type="email" class="form-control" name="email" id="email">
    </div>
    <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" name="pwd" id="pwd">
    </div>
    <div class="checkbox">
        <label><input type="checkbox"> Remember me</label>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>
<!--
Script non execute

<script>
  alert("erreur");
  $(function()){

    $('#form').submit(function()){
      var email=$("#email").val();
      var pwd=$("#pwd").val();

      if((id=="") || (pwd=="")){


      }
    });
  });
</script>
 –-/>
<?php include('includes/bas.inc.php'); ?>
