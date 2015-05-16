<?php require_once 'auth.php'; 

include "Verbindung.php";
			
$stmt = $dbh->prepare("Insert into Spiel (Spieler_1, Spieler_2, StatusID) values (:benutzerID, 0, 1);");

$stmt->bindParam(':benutzerID', $BenutzerID);
$BenutzerID = htmlspecialchars($_SESSION['BenutzerID']);
$stmt->execute();	


header("Location: ../index.php");		




?>


