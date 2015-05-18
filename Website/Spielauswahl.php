<?php require_once 'PHP/auth.php'; ?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Spielauswahl</title>
		<script src="scripts/newGame.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css">
	</head>
	<body>

		<div id="hamburgercontainer" class='hamburger'>			
			<a class='menuContent' href="Index.php">Startseite</a></br></br>
			<a class='menuContent' href="Spielauswahl.php">Spielauswahl</a></br></br>
			<a class='menuContent' href="Spielregeln.php">Spielregeln</a></br></br>
			<a class='menuContent' href="Statistik.php">Statistik</a></br></br>
			<a class='menuContent' href="Impressum.php">Impressum</a></br></br></br></br></br></br></br></br>
			<form action="PHP/Logout.php" method="post">
			<button id="Logoff" class="button menuContent" type='submit'>Logout</button>
			</form>
		</div>
			<div id="page-wrapper" class="minimalisticTable">
			<form action="PHP/newGameKI.php">
			<input type="submit" name="newGame" class="submit" value="Neues Spiel"></input>
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

$spielerID = htmlspecialchars($_SESSION['BenutzerID']);
$query->bindParam(':SpielerID', $spielerID);

$query->execute();
$rank =  $query->fetchAll();



?>
<form action="PHP/LoadGame.php" method="POST" id="table">
<table id="spielstandPositioning" class="statistikTable">
	<tr>
		<th>SpielID</th>
		<th>Gegner</th>
		<th>Spieplphase</th>
		<th></th>
	</tr>
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
			<td><input type="radio" id="<?php echo $SpielID ?>" name="Spiel" value="<?php echo $SpielID ?>" onclick="checkGame()"></td>
		</tr>
		<?php
	}

?>
</table>
 <input type="submit" id="StartGame" class="submit" name="StartGame" value="Spielstand laden" disabled ></input>
 </form>
</div>
	</body>
</html>


