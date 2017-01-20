<?php
include('includes/connexion.inc.php');

if (isset($_POST['message']) && !empty($_POST['message'])) {
	if(isset($_POST['id']) && !empty($_POST['id'])){
		$query = 'UPDATE messages SET contenu = ? WHERE id = ?';
		$prep = $pdo->prepare($query);
		$prep->bindValue(1,$_POST['message']);
		$prep->bindValue(2,$_POST['id']);
	}
	else{
		$query = 'INSERT INTO messages (contenu, dateC,user_id) VALUES (?,UNIX_TIMESTAMP(),?)';
		$prep = $pdo->prepare($query);
		$prep->bindValue(1,$_POST['message']);
		$prep->bindValue(2,$user_id);
	}
	$prep->execute();

}

header("Location:index.php");
exit();
?>
