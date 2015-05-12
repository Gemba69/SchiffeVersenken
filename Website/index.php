<?php require_once('classes/DrawFunctions.php'); ?>
<!doctype html>
<html>
	<head>
		<script src="scripts.js"></script>
		<script src="jquery.js"></script>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="stylesheet.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<title>
			Schiffe versenken
		</title>
	</head>
	<body onload="resumeSessionAjaxRequest()">
		<div id="hamburgercontainer" class="hamburger">
			
			<button class="hamburgerButton" ><span>toggle menu</span></button>
			<a class='menuContent' href="Startseite.html">Zurück zur Startseite</a></br></br>
			<a class='menuContent' href="Spielauswahl.html">Spielauswahl</a></br></br>
			<a class='menuContent' href="Spielregeln.html">Spielregeln</a></br></br>
			<a class='menuContent' href="Statistik.html">Statistik</a></br></br>
			<a class='menuContent' href="Impressum.html">Impressum</a></br></br></br></br></br></br></br></br>
			<button id="Logoff" class="button menuContent" type='submit'>Logoff</button>
		</div>
		<div id="boardcontainer">
			<aside id="infoboard">
				<h1 id="title">Phase 1</h1><br>
				<ul id="instructions">
					<li>
						Platziere deine Schiffe auf dem unteren Feld.<br><br>
						<?php drawShips(); ?>
					</li>
				</ul>
			</aside>
			<aside id="legend">
				<div class="buttondiv">
					<img class="buttonimg" src="images/arrow.png" alt="arrow">
					<button id="resetbutton" onclick="reset()">Destroy Session</button><br>
				</div>
				<span class="example_cell"></span> Wasser
				<span class="example_cell graycol"></span> Schiff
				<span class="example_cell darkbluecol"></span> daneben
				<span class="example_cell redcol"></span> Treffer
				<span class="example_cell blackcol"></span> versenkt
			</aside>
			<div id="enemyboard">
				<?php createBoard(10, 10, 'enemy'); ?>
			</div>
			<br>
			<div id="ownboard">
				<?php createBoard(10, 10, 'self'); ?>
			</div>
			<aside>
				<span id="infobox"></span>
			</aside>
		</div>
	
	</body>
</html>