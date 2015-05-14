<?php
	if ($_SERVER['REQUEST_METHOD'] === "POST") {		

		$regExBenutzername = '/^[A-Za-z0-9]{1,32}$/';		
		$regExEmail = '/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/';			
		$emptyBoolean = false;
		$regExFehlerBoolean = false;
		$pwAbgleichFehler = false;
		$logIn = false;

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
		
		$pwHash = hash('sha256', $_POST['passwort']);
		  
		if(!$emptyBoolean && !$regExFehlerBoolean){
			
			include "Verbindung.php";
				
			$stmt = $dbh->prepare("SELECT Password FROM benutzer WHERE Benutzername = :benutzername");
																		
			$stmt->bindParam(':benutzername', $Benutzername);
			$Benutzername = $_POST['benutzername'];	
			$stmt->execute();
			$jifjif = $stmt->fetchAll(PDO::FETCH_NUM);
			
			if($jifjif != NULL && $jifjif[0][0] == $pwHash){
				echo '<p> Benutzerdaten gefunden! Login!! <p>';
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
				header("Location: ../Startseite.html");
			}else{
				$loginFehlermeldung = "<span class='Fehler'> Konto- oder Passworteingabe ist falsch! </span>";
				$repString = "<form action=\"LogIn.php\" method=\"POST\">";
				$loginFehlermeldung = $repString.$loginFehlermeldung;
			    $template = file_get_contents("../LogInFormular.html"); 
				$count = 1;
				$retVal = str_replace($repString, $loginFehlermeldung, $template, $count);
			    //header("Location: ../LoginFormular.html"); -> Test von Benni
			}
			
		}else{
			echo 'Eingaben nicht vollstaendig gefuellt oder entspricht nicht den RegEx!';
			$template = file_get_contents("../LogInFormular.html"); // Im Template eine Fehlermeldung schreiben
			echo $template;
		}
	  
	}else{
		echo 'Server nicht erreichbar!';
	} 	
?>
