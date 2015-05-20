<?php
	if ($_SERVER['REQUEST_METHOD'] === "POST") {		
	//initialisierung wichtiger Parameter zur Eingabeüberprüfung
		$regExBenutzername = '/^[A-Za-z0-9]{1,32}$/';	
		$regExEmail = '/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/';	
		$emptyBoolean = false;
		$regExFehlerBoolean = false;
		$pwAbgleichFehler = false;
	// Überprufüng ob Felder noch keine Input haben. Wenn ein/mehrere/alle Felder nicht gefüllt sind werden Parameter auf True gesetzt
	// um eine falsche/leer Eingabe abzufangen
		if(empty($_POST['benutzername']) || empty($_POST['email']) || empty($_POST['passwort']) || empty($_POST['passwortBestaetigen'])) {
			echo 'Es müssen alle Felder ausgefüllt werden!</br>';
			$emptyBoolean = true;
		} elseif(!preg_match($regExBenutzername, $_POST['benutzername'])) {
			echo 'Benutzername entspricht nicht den Vorgaben</br>'; 
			$regExFehlerBoolean = true;
		} elseif(!preg_match($regExEmail, $_POST['email'])){
			echo 'Email entspricht nicht den Vorgaben</br>';
			$regExFehlerBoolean = true;
		} else {
			$pwHash = hash('sha256', $_POST['passwort']);
			$pwConfirmHash = hash('sha256', $_POST['passwortBestaetigen']);		
			if($_POST['passwort'] != $_POST['passwortBestaetigen']) {
				echo 'Passwort stimmt nicht überein</br>';
				$pwAbgleichFehler = true;
			}
		}
	//Erst wenn alle Bedingungen erfüllt sind, wird eine Verbindung zur Datenbank hergesetllt
	//Es folgen Prüfungen bei den Eingaben, um doppelte Nutzernamen und Multiaccounting zu verhindern
		if(!$emptyBoolean && !$regExFehlerBoolean && !$pwAbgleichFehler) {
					
			include "Verbindung.php";
			
			$stmt1 = $dbh->prepare("SELECT Benutzername FROM benutzer WHERE Benutzername = :benutzername");
																		
			$stmt1->bindParam(':benutzername', $Benutzername);
			$Benutzername = $_POST['benutzername'];
			$stmt1->execute();			
			$temp = $stmt1->fetchAll(PDO::FETCH_NUM);
			
			$stmt3 = $dbh->prepare("SELECT Email FROM benutzer WHERE Email = :email");
																		
			$stmt3->bindParam(':email', $Email);
			$Email = $_POST['email'];
			$stmt3->execute();			
			$temp2 = $stmt3->fetchAll(PDO::FETCH_NUM);
			var_dump($temp);
			echo 'wechsel';
			var_dump($temp2);
			if ($temp != NULL || $temp2 != NULL){
				$fehlermeldung = "<span class='Fehler'> Der Benutzername existiert bereits! </span>";
				header("Location: Wrong_Registrierung.php");
			}else{
				
				$stmt2 = $dbh->prepare("INSERT INTO benutzer (Benutzername, Email, Password) 
													VALUES (:benutzername, :email, :passwort);");
												
				$stmt2->bindParam(':benutzername', $Benutzername);
				$stmt2->bindParam(':email', $Email);
				$stmt2->bindParam(':passwort',$Passwort);
				
				$Benutzername = $_POST['benutzername'];
				$Email = $_POST['email'];
				$Passwort = $pwHash;
		//bei erfolgreichem Ablauf folgt die Weiterleitung zum Login
				if ($stmt2->execute()){
					echo '<p> Erfolgreich registriert! <p>';
					header("Location: Registrierung_successfully.php");
				}else{
					echo 'Bei der Registrierung ist ein unerwarteter Fehler aufgetreten!';
					$template = file_get_contents("../Registrierungsformular.html"); 
					echo $template;
				}
			}
		}else{
			echo 'Versuche es erneut!';
			$template = file_get_contents("../Registrierungsformular.html"); 
			echo $template;
			}	  
	}else{
		echo 'Server nicht erreichbar!';
		}	      
?>
