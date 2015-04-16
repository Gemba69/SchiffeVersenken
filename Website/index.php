<?php
	function createBoard($rows, $columns, $idPrefix) {
		echo("<table class='board'>");
		for ($i = 0; $i < $rows; $i++) {
			echo("<tr>");
			for ($j = 0; $j < $columns; $j++) {
			echo("<td><span onclick='flipTile($i, $j, \"$idPrefix\")' onmouseup='removeMouseDownClassFromCell($i, $j, \"$idPrefix\")' onmousedown='addMouseDownClassToCell($i, $j, \"$idPrefix\")' onmouseleave='removeMouseDownClassFromCell($i, $j, \"$idPrefix\")' class='board_cell' id='{$idPrefix}_cell_{$i}_{$j}'></span></td>");
			}
			echo("</tr>");
		}
		echo("</table>");
	}
?>

<!doctype html>
<html>
	<head>
		<script src="scripts.js"></script>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="stylesheet.css">
		<title>
			Schiffe versenken
		</title>
	</head>
	<body>
		<div id="boardcontainer">
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