<?php
	require_once("GameHelperFunctions.php");
	require_once("DrawFunctions.php");
	require_once("Game.php");
	require_once("HumanPlayer.php");
	require_once("AI.php");

	session_start();
	//header('content-Type:application/json;charset=UTF-8');
	
	$game = $_SESSION['game'];
	$i = $_POST['i'];
	$j = $_POST['j'];
	$gameField = $_POST['gameField'];
	$postData = array('nextRequest' => 'classes/ShipPlacement.php'); //TODO: hardcoding entfernen
	//echo ("WHAT THE SHIT IS THIS FAGGOTRY");
	
	if ($gameField == ENEMY_ID_PREFIX) {
		$postData['illegal'] = 'true';
		echo json_encode($postData);
	} else {
		$game->getPlayer1()->getGameField()->toggleShip($i, $j); //TODO: hier muss noch erkannt werden, um welchen Spieler es sich eigentlich handelt. Es wird davon ausgegangen, dass immer Spieler 1 menschlich ist.
		$cell = array('i' => $i,
					  'j' => $j,
					  'color' => 'gray',
					  'gameField' => $gameField);
		$cellData = array(0 => $cell);

		$postData['cells'] = $cellData;
		$postData['remainingShipCode'] = GameHelperFunctions::drawRemainingShips($game->getPlayer1()->getGameField()->getAsArray(), $game->getRequiredShips()); //TODO: siehe oben
		$postData['allShipsPlaced'] = GameHelperFunctions::allShipsPlaced($game->getPlayer1()->getGameField()->getAsArray(), $game->getRequiredShips()); //TODO: siehe oben
		
		$_SESSION['game'] = $game;

		echo json_encode(GameHelperFunctions::utf8ize($postData));
	}
?>