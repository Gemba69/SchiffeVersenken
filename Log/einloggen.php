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
			echo 'Benutzername entspricht den Vorgaben</br>'; 
		}elseif(!$emptyBoolean){
			echo 'Benutzername entspricht nicht den Vorgaben</br>';
			$regExFehlerBoolean = true;
		}
		
		$pwHash = hash('sha256', $_POST['passwort']);
		  
		if(!$emptyBoolean && !$regExFehlerBoolean){
			
			include "verbinden.php";
				
			$stmt = $dbh->prepare("SELECT Password FROM benutzer WHERE Benutzername = :benutzername");
																		
			$stmt->bindParam(':benutzername', $Benutzername);
			$Benutzername = $_POST['benutzername'];	
			$stmt->execute();
			$jifjif = $stmt->fetchAll(PDO::FETCH_NUM);
			
			if($jifjif != NULL && $jifjif[0][0] == $pwHash){
				echo '<p> Benutzerdaten gefunden! Login!! <p>';
				$pwAbgleichFehler = true;
				$logInAttempt = true;
			}else{
				echo 'Konto- oder Passworteingabe ist falsch!';
				$template = file_get_contents("einloggen.html"); // Im Template eine Fehlermeldung schreiben
				echo $template;

			}
		}else{
			echo 'Eingaben nicht vollstaendig gefuellt oder entspricht nicht den RegEx!';
			$template = file_get_contents("einloggen.html"); // Im Template eine Fehlermeldung schreiben
			echo $template;
		}
	  
	}else{
		echo 'Server nicht erreichbar!';
	} 	
?>
