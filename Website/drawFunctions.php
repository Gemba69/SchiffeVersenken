<?php
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
	
	function drawRemainingShips($ships) {
		$shipfragment = "<span class='example_cell graycol'></span>";
		if (empty($ships)) {
			$ships = array('5' => 1, '4' => 2, '3' => 3, '2' => 4);
		}
		echo("<ul>");
		
		echo("<li>");
		for ($i = 0; $i < 5; $i++) {
			echo($shipfragment);
		}
		echo(" x ".$ships['5']."</li>");
		
		echo("<li>");
		for ($i = 0; $i < 4; $i++) {
			echo($shipfragment);
		}
		echo(" x {$ships["4"]}</li>");
		
		echo("<li>");
		for ($i = 0; $i < 3; $i++) {
			echo($shipfragment);
		}
		echo(" x {$ships["3"]}</li>");
		
		echo("<li>");
		for ($i = 0; $i < 2; $i++) {
			echo($shipfragment);
		}
		echo(" x {$ships["2"]}</li>");
		
		echo("</ul>");
	}
?>