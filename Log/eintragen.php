<?php
	if ($_SERVER['REQUEST_METHOD'] === "POST") {		

		$regExBenutzername = '/^[A-Za-z0-9]{1,32}$/';	
		$regExEmail = '/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/';	
		$emptyBoolean = false;
		$regExFehlerBoolean = false;
		$pwAbgleichFehler = false;		

		if(empty($_POST['benutzername']) || empty($_POST['email']) || empty($_POST['passwort'] || empty($_POST['passwortBestaetigen']))){
			echo 'Es müssen alle Felder ausgefüllt werden!</br>';
			$emptyBoolean = true;
		}
		
		if(!$emptyBoolean && preg_match($regExBenutzername, $_POST['benutzername'])){
			echo 'Benutzername entspricht den Vorgaben</br>'; 
		}elseif(!$emptyBoolean){
			echo 'Benutzername entspricht nicht den Vorgaben</br>';
			$regExFehlerBoolean = true;
		}
		
		if(!$emptyBoolean && (preg_match($regExEmail, $_POST['email']))){
			echo 'Email entspricht den Vorgaben</br>'; 
		}elseif(!$emptyBoolean){
			echo 'Email entspricht nicht den Vorgaben</br>';
			$regExFehlerBoolean = true;
		}
		
		$pwHash = hash('sha256', $_POST['passwort']);
		$pwConfirmHash = hash('sha256', $_POST['passwortBestaetigen']);
		
		if($_POST['passwort'] == $_POST['passwortBestaetigen']){
			echo 'Passwort stimmt überein</br>';
		}else{
			echo 'Passwort stimmt nicht überein</br>';
			$pwAbgleichFehler = true;
		}

		if(!$emptyBoolean && !$regExFehlerBoolean && !$pwAbgleichFehler){
			
			include "verbinden.php";
				
			$stmt = $dbh->prepare("INSERT INTO benutzer (Benutzername, Email, Password) 
												VALUES (:benutzername, :email, :passwort);");
												
			$stmt->bindParam(':benutzername', $Benutzername);
			$stmt->bindParam(':email', $Email);
			$stmt->bindParam(':passwort',$Passwort);
				
			$Benutzername = $_POST['benutzername'];
			$Email = $_POST['email'];
			$Passwort = $pwHash;
		
			if ($stmt->execute()){
				echo '<p> Erfolgreich registriert! <p>';
			}else{
				print_r($dbh->errorInfo());
			}
		}else{
			echo 'Eingaben nicht vollständig gefüllt oder entspricht nicht den RegEx!';
		}
	  
	}else{
		echo 'Server nicht erreichbar!';
	}      
?>
