<?php
	echo "<script src=scripts/newGame.js></script>";

	$_SESSION['Spiel'] = $_POST['Spiel'];
	
	header("Location: ../index.php");
?>