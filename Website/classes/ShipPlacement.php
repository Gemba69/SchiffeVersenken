<?php
	require_once(GameHelperFunctions.php);
	require_once(DrawFunctions.php);

	$game = $_SESSION['game'];
	$i = $_POST['i'];
	$j = $_POST['j'];
	$gameField = $_POST['gameField'];
	$postData = array('nextRequest' => 'ShipPlacement.php');
	
	if ($gameField == ENEMY_ID_PREFIX) {
		$postData['illegal'] = 'true';
		echo json_encode($answer);
	} else {
		$game.getPlayer1().getGameFieldSelf().toggleShip($i, $j); //TODO: hier muss noch erkannt werden, um welchen Spieler es sich eigentlich handelt. Es wird davon ausgegangen, dass immer Spieler 1 menschlich ist.
		$cell = array('i' => $i,
					  'j' => $j,
					  'color' => 'gray',
					  'gameField' => $gameField);
		$cellData = array(0 => $cell);
		$postData = array('cells' => $cellData);
		$postData['remainingShipCode'] = GameHelperFunctions.drawRemainingShips($game.getPlayer1().getGameFieldSelf()); //TODO: siehe oben
		$postData['allShipsPlaced'] = GameHelperFunctions.allShipsPlaced($game.getPlayer1().getGameFieldSelf()); //TODO: siehe oben
		
		echo json_encode($postData);
	}
?>