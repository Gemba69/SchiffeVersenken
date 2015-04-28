<?php
	if ($_SERVER['REQUEST_METHOD'] === "POST") {		

		$regExBenutzername = '/^[A-Za-z0-9]{1,32}$/';	
		$regExEmail = '/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/';	
		$emptyBoolean = false;
		$regExFehlerBoolean = false;
		$pwAbgleichFehler = false;
	

		if(empty($_POST['benutzername']) || empty($_POST['email']) || empty($_POST['passwort']) || empty($_POST['passwortBestaetigen'])){
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
			
			$stmt1 = $dbh->prepare("SELECT Benutzername FROM benutzer WHERE Benutzername = :benutzername");
																		
			$stmt1->bindParam(':benutzername', $Benutzername);
			$Benutzername = $_POST['benutzername'];
			$stmt1->execute();			
			$test = $stmt1->fetchAll(PDO::FETCH_NUM);
			
			if ($test != NULL){
				echo '<p> Der Benutzername existiert bereits! <p>';
			    $template = file_get_contents("eintragen.html"); 
			    echo $template;
			}else{
				
				$stmt2 = $dbh->prepare("INSERT INTO benutzer (Benutzername, Email, Password) 
													VALUES (:benutzername, :email, :passwort);");
												
				$stmt2->bindParam(':benutzername', $Benutzername);
				$stmt2->bindParam(':email', $Email);
				$stmt2->bindParam(':passwort',$Passwort);
				
				$Benutzername = $_POST['benutzername'];
				$Email = $_POST['email'];
				$Passwort = $pwHash;
		
				if ($stmt2->execute()){
					echo '<p> Erfolgreich registriert! <p>';
				}else{
					print_r($dbh->errorInfo());
				}
			}
		}else{
			echo 'Eingaben nicht vollständig gefüllt oder entspricht nicht den RegEx!';
			$template = file_get_contents("eintragen.html"); 
			echo $template;
			}	  
	}else{
		echo 'Server nicht erreichbar!';
		}	      
?>
