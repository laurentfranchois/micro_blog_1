<?php
include('includes/connexion.inc.php');

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$query = 'DELETE FROM messages WHERE id = ?';
		$prep = $pdo->prepare($query);
		$prep->bindValue(1,$_GET['id']);
    $prep->execute();
	}


header("Location:index.php");
exit();
?>
