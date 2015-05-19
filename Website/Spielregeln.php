<?php require_once 'PHP/auth.php'; ?>
<!doctype html>
<html>
  <head>	
    <meta charset="UTF-8">							
    <title>Spielregeln</title>
			<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css">
  </head>
 	<body>
	<div id="hamburgercontainer">			
			<a class='menuContent' href="Index.php">Startseite</a></br></br>
			<a class='menuContent' href="Spielauswahl.php">Spielauswahl</a></br></br>
			<a class='menuContent' href="Spielregeln.php">Spielregeln</a></br></br>
			<a class='menuContent' href="Statistik.php">Statistik</a></br></br>
			<a class='menuContent' href="Impressum.php">Impressum</a></br></br></br></br></br></br></br></br>
			<form action="PHP/Logout.php" method="post">
			<div class="buttondiv
				<button id="Logoff" class="button menuContent" type='submit'>Logoff</button>
			</div>
			</form>
	</div>
	 <div id="page-wrapper">
  
        <div class='spielregeln'><h1>Spielregeln</h1>

		<p><strong><FONT SIZE=4>Ziel des Spieles</FONT></strong></p>

		<p>Jeder Spieler muss seine Flotte im Gewässer verstecken und versuchen die
		gegnerische Flotte vollst&aumlndig zu versenken. Hierbei ist zu beachten, dass die eigene 
		Flotte nicht komplett zum Opfer des Feindfeuers werden darf.<br></p>

		<p><strong><FONT SIZE=4>Setzen der Schiffe</FONT></strong></p>

		<p>Die eigene und die gegnerische Flotte bestehen aus:<br><br>
		• 1 Schlachtschiff (5 Felder groß)<br>
		• 2 Kreuzer (4 Felder groß)<br>
		• 3 Fregatten (3 Felder groß)<br>
		• 4 Minensucher (2 Felder groß)<br></p>


		<p>Vor dem ersten Zug muss jeder seine Schiffe positionieren. Die Schiffe müssen so gestellt werden, 
		dass sie sich weder waagerecht noch senkrecht überlappen, nebeneinander stehen und nicht über Eck gestellt werden. Ebenfalls ist ein diagonales setzen nicht erlaubt.
		Die Schiffe können durch Klicken auf die einzelnen Felder gesetzt werden. Dabei bilden mehrere Zusammenhängende markierte Kacheln ein Schiff. 
		Durch Klicken auf ein bereits markiertes Feld wird dieses wieder zu Wasser. Ist eine Anordnung nicht korrekt oder sind zu viele Schiffe von einem Typ gesetzt, wird dies angezeigt.
		Sind alle Schiffe richtig aufgestellt, best&aumltige die Aufstellung und das Spiel kann gestartet werden.<br></p>

		<p><strong><FONT SIZE=4>Spielablauf</FONT></strong></p>

		<p>In dem oberen Gew&aumlsser ist das Feld des Gegners zu sehen. Hier wird pro Runde ein "Schuss" auf ein beliebiges Feld abgegeben um ein
		gegnerisches Schiff zu treffen. Das angeklickte Feld wird als bereits "beschossen" markiert. War der Schuss ein Treffer, wird dies
		angezeigt und ein neues Feld kann beschossen werden. Dies kann auch mehrmals hintereinander geschehen.<br>
		War der Schuss kein Treffer, so ist der Gegner an der Reihe.<br></p>
		
		<p><strong><FONT SIZE=4>Spielende</FONT></strong></p>
		
		<p>Gewonnen hat der Spieler, welcher zuerst alle Schiffe der gegnerischen Flotte versenkt hat.</p>
        </div>
	 </div>
    </body>
</html>