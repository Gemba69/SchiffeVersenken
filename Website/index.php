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
		<div id="boardcontainer">
			<aside id="infoboard">
				<h1 id="phase">Phase 1</h1><br>
				<ul>
					<li>
						<div id="instructions">Platziere deine Schiffe auf dem unteren Feld.</div><br><br>
						<div id="remainingships"><?php drawShips(); ?></div>
					</li>
					<li>
						
					</li>
				</ul>
			</aside>
			<aside id="legend">
				<button id="resetbutton" onclick="reset()">Destroy Session</button><br>
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