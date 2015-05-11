<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Neues Spiel</title>
	</head>
	<body>
</br> </br>
<form>
<input type="radio" id="KI" name="Player" value="KI">KI</input>
<input type="radio" id="Real" name="Player" value="REAK>realer Gegner">realer Gegner</input>
</br> </br>
Gegnersuche: <input type="text" id="searchfield"></Input>
<input type="submit" name="Search" value="Suche starten"></input>
</form>

</br> </br>

<?php

$dbh = new PDO('mysql:host=localhost;dbname=SchiffeVersenken', 'root', '');

$query = $dbh->prepare("Select * from Benutzer where Benutzername LIKE :Search;");

$searchTerm = '';
$like = '%'.$searchTerm.'%';
$query->bindParam(':Search', $like);

$query->execute();
$rank = $query->fetchAll();

?>
<form action="test.php" method="POST">
<table border="1">
	<tr>
		<td>Spieler</td>	
	</tr>

<?php
	foreach($rank as $row) {
		$Spieler=$row["Benutzername"];
		?>
		<tr>
			<td><?php echo $Spieler ?></td>
			<td><input type="radio" id="<?php echo $Spieler ?>" name="Spiel" value="<?php echo $Spieler ?>"></td>
		</tr>
		<?php
	}
?>
  
</table>
</br></br><br/>
 <input type="submit" name="StartNewGame" value="Neues Spiel starten"></input>
 </form>

	</body>
</html>


