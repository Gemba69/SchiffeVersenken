<?php 
	require_once('classes/GameHelperFunctions.php');		
	require_once('classes/HumanPlayer.php');
	require_once('classes/Game.php');		
	require_once('classes/AI.php');		
	
	session_start(); 
		
	if (isset($_POST['reset']))
		resetSession();
	elseif (isset($_SESSION['game'])) {
		resumeSession();
	} else {
		createNewSession();
	}
	
	function resumeSession() {
		//TODO: gameState
		$game = $_SESSION['game'];
		$gameFieldArray = $game->getPlayer1()->getGameField()->getAsArray();
		echo "asdf";
		$postData = GameHelperFunctions::buildCellDataStructure($gameFieldArray);
		echo "asdf2";
		if ($game->getPhase() == 0)
			$postData['nextRequest'] = "ShipPlacement.php";
		else
			$postData['nextRequest'] = "ShotFiring.php";
		echo json_encode($postData);
	}
	
	function createNewSession() {
		$player1 = new HumanPlayer("1", "Name"); //TODO: Name und id irgendwie aus der DB holen oder so
		$player2 = new AI("2", "CPU"); //TODO: s.o.
		$requiredShips =  array('10' => 0, '9' => 0, '8' => 0, '7' => 0, '6' => 0, '5' => 1, '4' => 2, '3' => 3, '2' => 4, '1' => 0); //todo: aus der datenbank auslesen
		
		$game = new Game($requiredShips, 10, 10, $player1, $player2); //TODO: Spielfeldgröße irgendwo herholen
		$_SESSION['game'] = $game;
		
		$game.playPhase1();
	}
	
	function resetSession() { //temporary
		session_unset(); 
		session_destroy();
	}
?>