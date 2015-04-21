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
				
			$stmt = $dbh->query("SELECT Password FROM benutzer WHERE Benutzername = :benutzername");
																		
			$stmt->bindParam(':benutzername', $Benutzername);
			$Benutzername = $_POST['benutzername'];	
	
			if ($stmt->execute()){
				echo '<p> Benutzerdaten gefunden! <p>';
			}else{
				print_r($dbh->errorInfo());
			}
		}else{
			echo 'KEIN ERFOLG';
		}
		
		if($pwHash == $stmt){
			echo 'Passwort stimmt überein! Login!!</br>';
			$logIn = true;
		}else{
			echo 'Fehlerhafte Logindaten!</br>';
			$pwAbgleichFehler = true;
		}
	  
	}else{
		echo 'ende';
	}      
?>
