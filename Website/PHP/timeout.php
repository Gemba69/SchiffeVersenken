<?php
	if (isset($_SESSION['timeout']) && $_SESSION['timeout'] + 10 * 60 < time()) { // 10 Minuten
		echo("timeout");
		header("Location: Logout.php");		
	}
     
	$_SESSION['timeout'] = time();
?>