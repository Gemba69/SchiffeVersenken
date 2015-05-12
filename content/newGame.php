<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Neues Spiel</title>
		<script src="newGame.js"></script>
	</head>
	<body>
</br> </br>
<form>
<input type="radio" id="KI" name="Player" value="KI" onclick="checkEnemy()">KI</input>
<input type="radio" id="Real" name="Player" value="realer Gegner" onclick="checkEnemy()">realer Gegner</input>
</br> </br>
Gegnersuche: <input type="text" id="searchfield" disabled></Input>
<input type="submit" id="Search"name="Search" value="Suche starten" disabled></input>
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
<table id="playerTable" border="1" disabled>
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


