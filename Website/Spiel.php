﻿<?php require_once('PHP/classes/DrawFunctions.php');
	  require_once('PHP/classes/GameHelperFunctions.php');
	  //require_once ('PHP/auth.php‘);
      //require_once ('PHP/Auth_Spiel.php');
	  ?>
<!doctype html>
<html>
	<head>
		<script src="scripts/scripts.js"></script>
		<script src="scripts/jquery.js"></script>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
		<title>
			Schiffe versenken
		</title>
	</head>
	<body onload="resumeSessionAjaxRequest()">
		<div id="hamburgercontainer" class='hamburger'>			
			<a class='menuContent' href="Index.php">Startseite</a>
			<a class='menuContent' href="Spielauswahl.php">Spielauswahl</a>
			<a class='menuContent' href="Spielregeln.php">Spielregeln</a>
			<a class='menuContent' href="Statistik.php">Statistik</a>
			<a class='menuContent' href="Impressum.php">Impressum</a></br></br></br>
		<form action="PHP/Logout.php" method="post">
		<div class="buttondiv">
				<button id="Logoff" class="button menuContent" type='submit'>Logoff</button>
			</div>
		</form>
		</div>
		<div id="boardcontainer">
			<aside id="infoboard">
				<h1 id="title"><?php echo PHASE_1_TITLE; ?></h1><br>
				<ul id="instructions">
					<li>
						Platziere deine Schiffe auf dem unteren Feld.<br><br>
						<?php drawShips(); ?>
					</li>
				</ul>
			</aside>
			<aside id="legend">
				<div class="buttondiv rightalign">
					<img class="buttonimg" src="resources/surrenderflag.png" alt="flag icon missing">
					<button id="resetbutton" onclick="resetAjaxRequest()">Aufgeben</button><br>
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