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
	
	function getDrawnShipsCode($ships) {
		$shipfragment = "<span class='example_cell graycol'></span>";
		$ret = "";
		if (empty($ships)) {
			$ships = array('5' => 1, '4' => 2, '3' => 3, '2' => 4); //todo: aus der datenbank auslesen
		} 
		$ret = $ret."<ul>";
		
		$ret = $ret."<li>";
		for ($i = 0; $i < 5; $i++) {
			$ret = $ret."$shipfragment";
		}
		$ret = $ret." x ".$ships['5']."</li>";
		
		$ret = $ret."<li>";
		for ($i = 0; $i < 4; $i++) {
			$ret = $ret."$shipfragment";
		}
		$ret = $ret." x {$ships["4"]}</li>";
		
		$ret = $ret."<li>";
		for ($i = 0; $i < 3; $i++) {
			$ret = $ret."$shipfragment";
		}
		$ret = $ret." x {$ships["3"]}</li>";
		
		$ret = $ret."<li>";
		for ($i = 0; $i < 2; $i++) {
			$ret = $ret."$shipfragment";
		}
		$ret = $ret." x {$ships["2"]}</li>";
		
		$ret = $ret."</ul>";
		
		return $ret;
	}
	
	function drawShips() {
		$output = getDrawnShipsCode("");
		echo $output;
	}
?>