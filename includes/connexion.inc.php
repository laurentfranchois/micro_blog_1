<?php
$pdo = new PDO('mysql:host=localhost;dbname=micro_blog', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$connecte=false;
if(isset($_COOKIE['sid'])){

  $cookie=$_COOKIE['sid'];

  $query = "SELECT * FROM utilisateur WHERE sid=?";
  $prep = $pdo->prepare($query);
  $prep->bindValue(1, $cookie);
  $prep->execute();

  if($data=$prep->fetch()){
    $connecte=true;
    $user_id=$data['id'];
    
  }
}
?>
