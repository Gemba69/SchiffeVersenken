<?php
	if ($_SERVER['REQUEST_METHOD'] === "POST") {		

		$regExBenutzername = '/^[A-Za-z0-9]{1,32}$/';	
		$regExEmail = '/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/';	
		$emptyBoolean = false;
		$regExFehlerBoolean = false;
		$pwAbgleichFehler = false;
	
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
	
		if(!$emptyBoolean && !$regExFehlerBoolean && !$pwAbgleichFehler) {
					
			include "Verbindung.php";
			
			$stmt1 = $dbh->prepare("SELECT Benutzername FROM benutzer WHERE Benutzername = :benutzername");
																		
			$stmt1->bindParam(':benutzername', $Benutzername);
			$Benutzername = $_POST['benutzername'];
			$stmt1->execute();			
			$temp = $stmt1->fetchAll(PDO::FETCH_NUM);
			
			if ($temp != NULL){
				$fehlermeldung = "<span class='Fehler'> Der Benutzername existiert bereits! </span>";
				$repString = "<form action=\"Registrierung.php\" method=\"POST\">";
				$fehlermeldung = $repString.$fehlermeldung;
			    $template = file_get_contents("../Registrierungsformular.html"); 
				$count = 1;
				$retVal = str_replace($repString, $fehlermeldung, $template, $count);
			    echo $retVal;
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
