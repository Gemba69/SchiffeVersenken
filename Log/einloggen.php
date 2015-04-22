<?php
	if ($_SERVER['REQUEST_METHOD'] === "POST") {		

		$regExBenutzername = '/^[A-Za-z0-9]{1,32}$/';		
		$regExEmail = '/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/';	
		
		$emptyBoolean = false;
		$regExFehlerBoolean = false;
		$pwAbgleichFehler = false;
		$logIn = false;

		if(empty($_POST['benutzername']) || empty($_POST['passwort'])){
			echo 'Es müssen alle Felder ausgefüllt werden!</br>';
			$emptyBoolean = true;
		}
		
		if(!$emptyBoolean && preg_match($regExBenutzername, $_POST['benutzername'])){
			echo 'Benutzername entspricht den Vorgaben</br>'; 
		}elseif(!$emptyBoolean){
			echo 'Benutzername entspricht nicht den Vorgaben</br>';
			$regExFehlerBoolean = true;
		}
		
//		if(!$emptyBoolean && (preg_match($regExEmail, $_POST['email']))){
//			echo 'Email entspricht den Vorgaben</br>'; 
//		}elseif(!$emptyBoolean){
//			echo 'Email entspricht nicht den Vorgaben</br>';
//			$regExFehlerBoolean = true;
//		}
		
		$pwHash = hash('sha256', $_POST['passwort']);
		  
		if(!$emptyBoolean && !$regExFehlerBoolean){
			
			include "verbinden.php";
				
			$stmt = $dbh->prepare("SELECT Password FROM benutzer WHERE Benutzername = :benutzername");
																		
			$stmt->bindParam(':benutzername', $Benutzername);
			$Benutzername = $_POST['benutzername'];	
			$jifjif = $stmt->execute();
			if($jifjif[0] == $pwHash){
				echo '<p> Benutzerdaten gefunden! Login!! <p>';
				$pwAbgleichFehler = true;
			}else{
				print_r($dbh->errorInfo());
				echo 'penis';
			}
		}else{
			echo 'KEIN ERFOLG';
		}
	  
	}else{
		echo 'ende';
	}      
?>
