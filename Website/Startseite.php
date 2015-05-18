<?php require_once 'PHP/auth.php'; ?>
<!doctype html>
<html>
  <head>	
    <meta charset="UTF-8">							
    <title>Startseite</title>	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css">
  </head>
 	<body>
	<div id="hamburgercontainer" class='hamburger'>			
			<a class='menuContent' href="Startseite.php">Startseite</a></br></br>
			<a class='menuContent' href="Spielauswahl.php">Spielauswahl</a></br></br>
			<a class='menuContent' href="Spielregeln.php">Spielregeln</a></br></br>
			<a class='menuContent' href="Statistik.php">Statistik</a></br></br>
			<a class='menuContent' href="Impressum.php">Impressum</a></br></br></br></br></br></br></br></br>
			<form action="PHP/Logout.php" method="post">
			<button id="Logoff" class="button menuContent" type='submit'>Logout</button>
			</form>
	</div>
	<div id="page-wrapper">
 		
        <div class='startseite'><h1>Startseite</h1>
		<p><strong><FONT SIZE=4>Willkommen bei Schiffe Versenken!</FONT></strong></p>
		<p>Auf dieser Seite bieten wir dir dein Lieblingsspiel Schiffe Versenken. Ob gegen den Computer oder bald auch gegen echte Mitspieler - hier bekommst du was du brauchst!
		Neben einer einmaligen Optik werden auch deine Spiele aufgezeichnet und in Statistiken festgehalten. So k&oumlnnen andere deine Erfolge sehen und du selbst dein Spiel verbessern.<br>
		
		Um alle Funktionen unserer Seite genie&szligen zu k&oumlnnen, musst du dich ledigich registriert sein - und schon kann die Schlacht beginnen...</p>
		
		
		
		
		</div>
	</div>
    </body>
</html>