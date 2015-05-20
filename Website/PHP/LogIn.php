<?php
	if ($_SERVER['REQUEST_METHOD'] === "POST") {		
//initialisierung wichtiger Parameter zur Eingabeüberprüfung
		$regExBenutzername = '/^[A-Za-z0-9]{1,32}$/';		
		$regExEmail = '/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/';			
		$emptyBoolean = false;
		$regExFehlerBoolean = false;
		$pwAbgleichFehler = false;
		$logIn = false;
	// Überprufüng ob Felder noch keine Input haben. Wenn ein/mehrere/alle Felder nicht gefüllt sind werden Parameter auf True gesetzt
	// um eine falsche/leer Eingabe abzufangen
		if(empty($_POST['benutzername']) || empty($_POST['passwort'])){
			echo 'Es muessen alle Felder ausgefuellt werden!</br>';
			$emptyBoolean = true;
		}
		
		if(!$emptyBoolean && preg_match($regExBenutzername, $_POST['benutzername'])){
			//echo 'Benutzername entspricht den Vorgaben</br>'; 
		}elseif(!$emptyBoolean){
			//echo 'Benutzername entspricht nicht den Vorgaben</br>';
			$regExFehlerBoolean = true;
		}
		// Passwortverschlüsselung durch sha256
		$pwHash = hash('sha256', $_POST['passwort']);
		  
		if(!$emptyBoolean && !$regExFehlerBoolean){
			//Erst wenn alle Bedingungen erfüllt sind, wird eine Verbindung zur Datenbank hergesetllt
			//Es folgen Prüfungen, um die Existenz des Account und die Korrektheit der Logindaten zu prüfen
			include "Verbindung.php";
				
			$stmt = $dbh->prepare("SELECT Password FROM benutzer WHERE Benutzername = :benutzername");
																		
			$stmt->bindParam(':benutzername', $Benutzername);
			$Benutzername = $_POST['benutzername'];	
			$stmt->execute();
			$jifjif = $stmt->fetchAll(PDO::FETCH_NUM);
			
			if($jifjif != NULL && $jifjif[0][0] == $pwHash){
				echo '<p> Benutzerdaten gefunden! Login! <p>';
				$pwAbgleichFehler = true;
				$logInAttempt = true;
				session_start();
				$_SESSION['login'] = true;
				$_SESSION['Benutzer'] = $Benutzername;
				$stmt = $dbh->prepare("SELECT ID FROM benutzer WHERE Benutzername = :benutzername");
				$stmt->bindParam(':benutzername', $Benutzername);
				$stmt->execute();
				$BenutzerID = $stmt->fetchAll(PDO::FETCH_NUM);
				$_SESSION['BenutzerID'] = $BenutzerID[0][0];
				header("Location: ../Index.php");
			}else{
				//$loginFehlermeldung = "<span class='Fehler'> Konto- oder Passworteingabe ist falsch! </span>";
				//$repString = "<form action=\"PHP/LogIn.php\" method=\"POST\">";
				//$loginFehlermeldung = $repString.$loginFehlermeldung;
			    //$template = file_get_contents("../LogInFormular.html"); 
				//$count = 1;
				//$retVal = str_replace($repString, $loginFehlermeldung, $template, $count);
				//echo $retVal;
				header("Location: WrongLogin.php");
			}
			
		}else{
			//echo 'Eingaben nicht vollstaendig gefuellt oder entspricht nicht den RegEx!';
			//$template = file_get_contents("../LogInFormular.html"); // Im Template eine Fehlermeldung schreiben
			//echo $template;
			header("Location: MissingData.php");
		}
	  
	}else{
		echo 'Server nicht erreichbar!';
	} 	
?>
