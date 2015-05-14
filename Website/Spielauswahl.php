<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Spielauswahl</title>
		<script src="scripts/newGame.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link href='stylesheets/Anmeldebild.css' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css">
	</head>
	<body>
		<form action="newGame.php">
		<div id="hamburgercontainer" class='hamburger'>			
			<a class='menuContent' href="Startseite.html">Zurück zur Startseite</a></br></br>
			<a class='menuContent' href="Spielauswahl.php">Spielauswahl</a></br></br>
			<a class='menuContent' href="Spielregeln.html">Spielregeln</a></br></br>
			<a class='menuContent' href="Statistik.php">Statistik</a></br></br>
			<a class='menuContent' href="Impressum.html">Impressum</a></br></br></br></br></br></br></br></br>
			<button id="Logoff" class="button menuContent" type='submit'>Logoff</button>
		</div>
			<div id="page-wrapper">
			<input type="submit" name="newGame" value="Neues Spiel"></input>
			</div>
		</form>


<?php

$dbh = new PDO('mysql:host=localhost;dbname=SchiffeVersenken', 'root', '');

$query = $dbh->prepare("Select SpielID, Status_Typ, Benutzername
From
(SELECT Spiel.ID as SpielID, Status_Typ,
If(spieler_1=:SpielerID,Spieler_2,Spieler_1)  As Gegner
FROM Spiel left join SpielStatus on StatusID=SpielStatus.ID
where (Spieler_1=:SpielerID or Spieler_2=:SpielerID) and (StatusID='1' or StatusID='2')
) x
left join Benutzer on Gegner=Benutzer.ID
;");

$spielerID = 1;
$query->bindParam(':SpielerID', $spielerID);

$query->execute();
$rank =  $query->fetchAll();



?>
<form action="index.php" method="POST">
<div id="page-wrapper">
<table border="1">
	<tr>
		<td>SpielID</td>
		<td>Gegner</td>
		<td>Spieplphase</td>	
	</tr>
</div>
<?php
	foreach($rank as $row) {
		$SpielID=$row["SpielID"];
		$Gegner=$row["Benutzername"];
		$spielphase=$row["Status_Typ"];
		?>
		<tr>
			<td><?php echo $SpielID ?></td>
			<td><?php echo $Gegner ?></td>
			<td><?php echo $spielphase ?></td>
			<td><input type="radio" id="<?php echo $SpielID ?>" name="Spiel" value="<?php echo $SpielID ?>"></td>
		</tr>
		<?php
	}
?>
  
</table>
</br></br><br/>
 <input type="submit" name="StartGame" value="Spiel starten"></input>
 </div>
 </form>

	</body>
</html>


