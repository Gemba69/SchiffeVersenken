<?php require_once('drawFunctions.php'); ?>
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
	<body>
		<div id="boardcontainer">
			<aside id="infoboard">
				<h1>Phase 1</h1>
				<p>
					<ul>
						<li>Platziere deine Schiffe auf dem unteren Feld.<br><br>
							<span id="remainingships"><?php drawShips(); ?></span>
						</li>
						<li>
							<span id="infobox"></span>
						</li>
						<li>
							<button id="resetbutton" onclick="reset()">Destroy Session</button>
						</li>
					</ul>
				</p>
			</aside>
			<aside id="legend">
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
		</div>
	</body>
</html>