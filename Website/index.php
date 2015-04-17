<?php
	$placeShipsPhase = true;
	$twoLengthShips = 4;
	$threeLengthShips = 3;
	$fourLengthShips = 2;
	$fiveLengthShips = 1;
	
	function createBoard($rows, $columns, $idPrefix) {
		echo("<table class='board'>");
		for ($i = 0; $i < $rows; $i++) {
			echo("<tr>");
			for ($j = 0; $j < $columns; $j++) {
			echo("<td><span onclick='toggleShip($i, $j, \"$idPrefix\")' onmouseup='removeMouseDownClassFromCell($i, $j, \"$idPrefix\")' onmousedown='addMouseDownClassToCell($i, $j, \"$idPrefix\")' onmouseleave='removeMouseDownClassFromCell($i, $j, \"$idPrefix\")' class='board_cell' id='{$idPrefix}_cell_{$i}_{$j}'></span></td>");
			}
			echo("</tr>");
		}
		echo("</table>");
	}
	
	function drawRemainingShips($board) {
		//todo: schon platzierte Schiffe erkennen und vom counter abziehen
		global $fiveLengthShips;
		global $fourLengthShips;
		global $threeLengthShips;
		global $twoLengthShips;
		$shipfragment = "<span class='example_cell graycol'></span>";
		echo("<ul>");
		
		echo("<li>");
		for ($i = 0; $i < 5; $i++) {
			echo($shipfragment);
		}
		echo(" x $fiveLengthShips</li>");
		
		echo("<li>");
		for ($i = 0; $i < 4; $i++) {
			echo($shipfragment);
		}
		echo(" x $fourLengthShips</li>");
		
		echo("<li>");
		for ($i = 0; $i < 3; $i++) {
			echo($shipfragment);
		}
		echo(" x $threeLengthShips</li>");
		
		echo("<li>");
		for ($i = 0; $i < 2; $i++) {
			echo($shipfragment);
		}
		echo(" x $twoLengthShips</li>");
		
		echo("</ul>");
	}
?>

<!doctype html>
<html>
	<head>
		<script src="scripts.js"></script>
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
							<?php drawRemainingShips(""); ?>
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