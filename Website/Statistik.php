<?php require_once 'PHP/auth.php'; ?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Statistiken</title>
		<link href='stylesheets/Anmeldebild.css' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css">
	</head>
	<body>
	<div id="hamburgercontainer" class='hamburger'>			
			<a class='menuContent' href="Startseite.html">Startseite</a></br></br>
			<a class='menuContent' href="Spielauswahl.php">Spielauswahl</a></br></br>
			<a class='menuContent' href="Spielregeln.html">Spielregeln</a></br></br>
			<a class='menuContent' href="Statistik.php">Statistik</a></br></br>
			<a class='menuContent' href="Impressum.html">Impressum</a></br></br></br></br></br></br></br></br>
			<form action="PHP/Logout.php" method="post">
			<button id="Logoff" class="button menuContent" type='submit'>Logout</button>
			</form>
	</div>

<?php

$dbh = new PDO('mysql:host=localhost;dbname=SchiffeVersenken', 'root', '');

$rank = $dbh->query("Select * from highscore_gewonnene_Spiele;")->fetchAll();
?>
<div id="page-wrapper">
<table border="1">
	<tr>
		<td>Benutzername</td>
		<td>Gewonnene Spiele</td>		
	</tr>
<?php
	foreach($rank as $row) {
		//var_dump($adresse);
		$benutzer=$row["Benutzername"];
		$gewonneneSpiele=$row["GewonneneSpiele"];
		?>
		<tr>
			<td><?php echo $benutzer ?></td>
			<td><?php echo $gewonneneSpiele ?></td>
		</tr>
		<?php
	}
?>
</table>
</br> </br> </br>

<?php

$dbh = new PDO('mysql:host=localhost;dbname=SchiffeVersenken', 'root', '');

$rank = $dbh->query("Select * from highscore_gespielte_Spiele;")->fetchAll();
?>
<table border="1">
	<tr>
		<td>Benutzername</td>
		<td>Gespielte Spiele</td>		
	</tr>
<?php
	foreach($rank as $row) {
		//var_dump($adresse);
		$benutzer=$row["Benutzername"];
		$gespielteSpiele=$row["GespielteSpiele"];
		?>
		<tr>
			<td><?php echo $benutzer ?></td>
			<td><?php echo $gespielteSpiele ?></td>
		</tr>
		<?php
	}
?>
</table>
</br> </br> </br>
<?php

$dbh = new PDO('mysql:host=localhost;dbname=SchiffeVersenken', 'root', '');

$rank = $dbh->query("Select a.Benutzername,a.gespielteSpiele as GespielteSpiele,
b.gewonneneSpiele as GewonneneSpiele
from highscore_gespielte_spiele a left outer join highscore_gewonnene_spiele b 
on a.Benutzername=b.Benutzername
;")->fetchAll();
?>
<table border="1">
	<tr>
		<td>Benutzername</td>
		<td>Gewinnquote</td>
		<td>Gespielte Spiele</td>	
		<td>Gewonnene Spiele</td>		
	</tr>
<?php
	foreach($rank as $row) {
		//var_dump($adresse);
		$benutzer=$row["Benutzername"];
		$gespielteSpiele=$row["GespielteSpiele"];
		$gewonneneSpiele=$row["GewonneneSpiele"];
		$gewinnquote=$gewonneneSpiele/$gespielteSpiele*100 . '%'
		?>
		<tr>
			<td><?php echo $benutzer ?></td>
			<td><?php echo $gewinnquote ?></td>
			<td><?php echo $gespielteSpiele ?></td>
			<td><?php echo $gewonneneSpiele ?></td>
		</tr>
		<?php
	}
?>
</table>
</div>



	</body>
</html>


