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
			echo("<td><span onclick='cellClicked($i, $j, \"$idPrefix\")' onmouseup='removeMouseDownClassFromCell($i, $j, \"$idPrefix\")' onmousedown='addMouseDownClassToCell($i, $j, \"$idPrefix\")' onmouseleave='removeMouseDownClassFromCell($i, $j, \"$idPrefix\")' class='board_cell' id='{$idPrefix}_cell_{$i}_{$j}'></span></td>");
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