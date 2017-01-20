<?php
include('includes/connexion.inc.php');
include('includes/haut.inc.php');

if(isset($_POST['email']) && isset($_POST['pwd'])){
  $pwd=$_POST['pwd'];
  $email=$_POST['email'];

  $query="SELECT * FROM utilisateur WHERE mail=? and mdp=?";
  $prep = $pdo->prepare($query);
  $prep->bindValue(1,$email);
  $prep->bindValue(2,$pwd);
  $prep->execute();



  if($prep->fetch()){
    ?>
    <script>alert("Connecté sous l'adresse mail : <?php echo $email ?> ");</script>
    <?php
    $sid=$email.time();
    $sid=md5($sid);
    setcookie("sid",$sid,time()+300,null,null,false,true);
    $query="UPDATE utilisateur SET sid=? where mail=?";
    $prep = $pdo->prepare($query);
    $prep->bindValue(1,$sid);
    $prep->bindValue(2,$email);
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
<?php include('includes/bas.inc.php'); ?>
