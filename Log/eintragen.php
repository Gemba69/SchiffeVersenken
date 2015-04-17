
	  <?php
	  if ($_SERVER['REQUEST_METHOD'] === "POST") {
		 
		  
		include "verbinden.php";
		

		
		$stmt = $dbh->prepare("INSERT INTO benutzer (Benutzername, Email, Password) 
		                                     VALUES (:benutzername, :email, :passwort);");
						
		
						
		$stmt->bindParam(':benutzername', $Benutzername);
		$stmt->bindParam(':email', $Email);
		$stmt->bindParam(':passwort',$Passwort);
				
		$Benutzername = $_POST['benutzername'];
        $Email = $_POST['email'];
		$Passwort = $_POST['passwort'];
		
	
		if ($stmt->execute()){
			echo '<p> Erfolgreich registriert! <p>';
		}
		else{
			print_r($dbh->errorInfo());
		}

	  }
	  else{
		  echo 'ende';
	 }

        
		
      
      ?>
