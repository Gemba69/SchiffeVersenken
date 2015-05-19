<?php require_once 'PHP/auth.php'; ?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Statistiken</title>
		<link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>

	</head>
	<body>
	 <?php
		include "PHP/Sidebar.php";
	 ?>
<?php

include "PHP/Verbindung.php";

$rank = $dbh->query("Select (GewonneneSpiele/GespielteSpiele) as Gewinnquote, a.Benutzername,a.gespielteSpiele as GespielteSpiele,
b.gewonneneSpiele as GewonneneSpiele
from highscore_gespielte_spiele a left outer join highscore_gewonnene_spiele b 
on a.Benutzername=b.Benutzername order by GewonneneSpiele desc
;")->fetchAll();
?>
	<div id="page-wrapper" class="minimalisticTable">
		<h1>Statistik</h1>
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
		$gewinnquote=$row["Gewinnquote"]*100  . ' %';
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

$rank = $dbh->query("Select (GewonneneSpiele/GespielteSpiele) as Gewinnquote, a.Benutzername,a.gespielteSpiele as GespielteSpiele,
b.gewonneneSpiele as GewonneneSpiele
from highscore_gespielte_spiele a left outer join highscore_gewonnene_spiele b 
on a.Benutzername=b.Benutzername order by GespielteSpiele desc
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
		$gewinnquote=$row["Gewinnquote"]*100  . ' %';
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

$rank = $dbh->query("Select (GewonneneSpiele/GespielteSpiele) as Gewinnquote, a.Benutzername,a.gespielteSpiele as GespielteSpiele,
b.gewonneneSpiele as GewonneneSpiele
from highscore_gespielte_spiele a left outer join highscore_gewonnene_spiele b 
on a.Benutzername=b.Benutzername order by Gewinnquote desc
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
		//$gewinnquote=$gewonneneSpiele/$gespielteSpiele*100;
		//$gewinnquote = round($gewinnquote,2). '%';
		$gewinnquote=$row["Gewinnquote"]*100  . ' %';
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


