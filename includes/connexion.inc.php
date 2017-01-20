<?php
$pdo = new PDO('mysql:host=localhost;dbname=micro_blog', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$connecte=false;
//si le cookie est existant
if(isset($_COOKIE['sid'])){

  $cookie=$_COOKIE['sid'];
//requete pour verifier la presence du sid dans la base de donnees
  $query = "SELECT * FROM utilisateur WHERE sid=?";
  $prep = $pdo->prepare($query);
  $prep->bindValue(1, $cookie);
  $prep->execute();
//si le sid est present, connexion
  if($data=$prep->fetch()){
    $connecte=true;
    $user_id=$data['id'];

  }
}
?>
