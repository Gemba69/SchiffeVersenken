<?php
	session_start();
	session_regenerate_id();
 
	if (empty($_SESSION['login'])) {
		header('Location: LogInFormular.html');
		exit;
	} else {
		$login_status = '
			<div style="border: 1px solid black">
				Sie sind als <strong>' . htmlspecialchars($_SESSION['Benutzer']) . '</strong> angemeldet.<br />
				<a href="./logout.php">Sitzung beenden</a>
			</div>
		';
	}
?>