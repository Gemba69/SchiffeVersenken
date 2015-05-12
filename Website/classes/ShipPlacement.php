<?php
	require_once("GameHelperFunctions.php");
	require_once("DrawFunctions.php");
	require_once("Game.php");
	require_once("HumanPlayer.php");
	require_once("AI.php");
	
	
	session_start();
	//header('content-Type:application/json;charset=UTF-8');

	
	$game = $_SESSION['game'];
		
	if (isset($_POST['nextPhase'])) {
		$game->setPhase(1);
		$_SESSION['game'] = $game;
		$postData = GameHelperFunctions::generateReturnArray($game->getPlayer1()->getGameField()->getAsArray(), $game->getRequiredShips(), null, 1);
		echo json_encode(GameHelperFunctions::utf8ize($postData));
	} else {
	
		$i = $_POST['i'];
		$j = $_POST['j'];
		$gameField = $_POST['gameField']; //hier steht nicht das GameField, sondern nur um welches der beiden es sich handelt (self, enemy)
		
		if ($gameField == ENEMY_ID_PREFIX) {
			$postData = array('nextRequest' => 'classes/ShipPlacement.php'); //TODO: hardcoding entfernen
			$postData['illegal'] = 'true';
			echo json_encode($postData);
		} else {
			$game->getPlayer1()->getGameField()->toggleShip($i, $j); //TODO: hier muss noch erkannt werden, um welchen Spieler es sich eigentlich handelt. Es wird davon ausgegangen, dass immer Spieler 1 menschlich ist.
			$fakeGameField = GameHelperFunctions::initializeOrFetchGame(10, 10); //TODO: Wenn Fetch Game implementiert ist, geht das nicht mehr
			$fakeGameField[$i][$j] = SHIP_ID;
			$postData = GameHelperFunctions::generateReturnArray($game->getPlayer1()->getGameField()->getAsArray(), $game->getRequiredShips(), $fakeGameField, 0);
			$_SESSION['game'] = $game;

			echo json_encode(GameHelperFunctions::utf8ize($postData));
		}
	}
?>