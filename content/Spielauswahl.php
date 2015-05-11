<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Spielauswahl</title>
	</head>
	<body>


</br> </br>
<form action="newGame.php">

<input type="submit" name="newGame" value="Neues Spiel"></input>

</form>

</br> </br>

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
<form action="test.php" method="POST">
<table border="1">
	<tr>
		<td>SpielID</td>
		<td>Gegner</td>
		<td>Spieplphase</td>	
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
			<td><input type="radio" id="<?php echo $SpielID ?>" name="Spiel" value="<?php echo $SpielID ?>"></td>
		</tr>
		<?php
	}
?>
  
</table>
</br></br><br/>
 <input type="submit" name="StartGame" value="Spiel starten"></input>
 </form>

	</body>
</html>


