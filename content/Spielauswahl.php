<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Statistiken</title>
	</head>
	<body>

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
		</tr>
		<?php
	}
?>
</table>

	</body>
</html>


