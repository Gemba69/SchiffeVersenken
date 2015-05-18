<?php require_once 'PHP/auth.php'; ?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Statistiken</title>
		<link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css">
	</head>
	<body>
	<div id="hamburgercontainer" class='hamburger'>			
			<a class='menuContent' href="Startseite.php">Startseite</a></br></br>
			<a class='menuContent' href="Spielauswahl.php">Spielauswahl</a></br></br>
			<a class='menuContent' href="Spielregeln.php">Spielregeln</a></br></br>
			<a class='menuContent' href="Statistik.php">Statistik</a></br></br>
			<a class='menuContent' href="Impressum.php">Impressum</a></br></br></br></br></br></br></br></br>
			<form action="PHP/Logout.php" method="post">
			<button id="Logoff" class="button menuContent" type='submit'>Logout</button>
			</form>
	</div>
<?php

$dbh = new PDO('mysql:host=localhost;dbname=SchiffeVersenken', 'root', '');

$rank = $dbh->query("Select a.Benutzername,a.gespielteSpiele as GespielteSpiele,
b.gewonneneSpiele as GewonneneSpiele
from highscore_gespielte_spiele a left outer join highscore_gewonnene_spiele b 
on a.Benutzername=b.Benutzername order by GewonneneSpiele desc;
;")->fetchAll();
?>
	<div id="page-wrapper" class="minimalisticTable">
			<h2 class="designHeader">Highscore - gewonnene Spiele</h2>
			<table class="statistikTable">
				<tr>
					<th>Benutzername</th>
					<th>Gewinnquote</th>
					<th>Gespielte Spiele</th>	
					<th>Gewonnene Spiele</th>		
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
<?php

$dbh = new PDO('mysql:host=localhost;dbname=SchiffeVersenken', 'root', '');

$rank = $dbh->query("Select a.Benutzername,a.gespielteSpiele as GespielteSpiele,
b.gewonneneSpiele as GewonneneSpiele
from highscore_gespielte_spiele a left outer join highscore_gewonnene_spiele b 
on a.Benutzername=b.Benutzername order by a.gespielteSpiele desc
;")->fetchAll();
?>
			<h2 class="designHeader">Highscore - gespielte Spiele</h2>
			<table class="statistikTable">		
				<tr>
					<th>Benutzername</th>
					<th>Gewinnquote</th>
					<th>Gespielte Spiele</th>	
					<th>Gewonnene Spiele</th>		
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
<?php

$dbh = new PDO('mysql:host=localhost;dbname=SchiffeVersenken', 'root', '');

$rank = $dbh->query("Select a.Benutzername,a.gespielteSpiele as GespielteSpiele,
b.gewonneneSpiele as GewonneneSpiele
from highscore_gespielte_spiele a left outer join highscore_gewonnene_spiele b 
on a.Benutzername=b.Benutzername
;")->fetchAll();
?>
			<h2 class="designHeader">Highscore - Gewinnquote</h2>
			<table class="statistikTable">
				<tr>
					<th>Benutzername</th>
					<th>Gewinnquote</th>
					<th>Gespielte Spiele</th>	
					<th>Gewonnene Spiele</th>		
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


