<?php 
	require_once('classes/GameHelperFunctions.php');	
	require_once('classes/GameField.php');			
	require_once('classes/AI.php');		

	session_start();
	
	switch ($_POST['requestType']) {
		case 'reset':
			resetSession();
			break;
		case 'resumeSession':
			if (isset($_SESSION['gamePhase'])) 
				resumeSession();
			else
				createNewSession();
			break;
		case 'nextPhase':
				advancePhase();
			break;
		case 'cellClicked':
				processCellClicked();
			break;
	}
	
	function resumeSession() {
		//TODO: gameStatexampp
		if ($_SESSION['gamePhase'] == 0) {
			$gameFieldSelfArray = $_SESSION['gameFieldSelf']->getAsArray();
			$postData = GameHelperFunctions::generateReturnArray($gameFieldSelfArray, $_SESSION['requiredShips'], $gameFieldSelfArray, $_SESSION['gamePhase']);
			echo json_encode(GameHelperFunctions::utf8ize($postData));
		} else if ($_SESSION['gamePhase'] == 1) {
			$gameFieldSelfArray = $_SESSION['gameFieldSelf']->getAsArray();
			$postData = GameHelperFunctions::generateReturnArray($gameFieldSelfArray, $_SESSION['requiredShips'], $gameFieldSelfArray, $_SESSION['gamePhase']);
			echo json_encode(GameHelperFunctions::utf8ize($postData));
		}	
	}
	
	function createNewSession() {
		$gameFieldSelf = new GameField(GameHelperFunctions::initializeOrFetchGame(10, 10));
		$gameFieldEnemy = new GameField(GameHelperFunctions::initializeOrFetchGame(10, 10));
		$gamePhase = 0;
		$turn = SELF_ID_PREFIX;
		
		$_SESSION['gameFieldSelf'] = $gameFieldSelf;
		$_SESSION['gameFieldEnemy'] = $gameFieldEnemy;
		$_SESSION['requiredShips'] = array('10' => 0, '9' => 0, '8' => 0, '7' => 0, '6' => 0, '5' => 1, '4' => 2, '3' => 3, '2' => 4, '1' => 0); //todo: aus der datenbank auslesen
		$_SESSION['gamePhase'] = $gamePhase;
		$_SESSION['turn'] = $turn;
	}
	
	function resetSession() { //temporary
		session_unset();
		session_destroy();
	}
	
	function advancePhase() {
		$_SESSION['gamePhase'] = 1;
		$gameFieldSelfArray = $_SESSION['gameFieldSelf']->getAsArray();
		$postData = GameHelperFunctions::generateReturnArray($gameFieldSelfArray, $_SESSION['requiredShips'], null, 1);
		$_SESSION['gameFieldEnemy'] = AI::placeShips($_SESSION['requiredShips'], 10, 10); // TODO: 10x10 zentral auslesen
		echo json_encode(GameHelperFunctions::utf8ize($postData));
	}
	
	function processCellClicked() {
		if ($_SESSION['gamePhase'] == 0 && $_POST['gameField'] == SELF_ID_PREFIX) {
			processPhase1CellClick();
		} else if ($_SESSION['gamePhase'] == 1 && $_POST['gameField'] == ENEMY_ID_PREFIX && $_SESSION['turn'] === SELF_ID_PREFIX) {
			processPhase2CellClick();
		} else {
			$postData = array('illegal' => 'true');
			echo json_encode($postData);
		}
	}
	
	function processPhase1CellClick() {
		$gameFieldSelf = $_SESSION['gameFieldSelf'];
		$i = $_POST['i'];
		$j = $_POST['j'];
		
		$gameFieldSelf->toggleShip($i, $j);
		$fakeGameField = GameHelperFunctions::initializeOrFetchGame(10, 10); //TODO: Wenn Fetch Game implementiert ist, geht das nicht mehr
		$fakeGameField[$i][$j] = SHIP_ID; // Extrem hackige Art, das gewünschte zu tun...
		$postData = GameHelperFunctions::generateReturnArray($gameFieldSelf->getAsArray(), $_SESSION['requiredShips'], $fakeGameField, 0);
		echo json_encode(GameHelperFunctions::utf8ize($postData));
	}
	
	function processPhase2CellClick() {
		$gameFieldEnemy = $_SESSION['gameFieldEnemy'];
		$i = $_POST['i'];
		$j = $_POST['j'];
		
		$instructions = PHASE_2_MAJOR_INSTRUCTIONS;
		
		$postData = array('title' => PHASE_2_TITLE);
		if ($gameFieldEnemy->attack($i, $j)) {
			$postData['instructions'] = $instructions.'<ul><li class="fadeinanim">Treffer! Du darfst noch einmal schießen.</li></ul>';
			$color = 'red'; //TODO: Farbe irgendwoher beziehen.
		} else {
			$postData['instructions'] = $instructions.'<ul><li class="fadeinanim">Daneben. Der Gegner ist an der Reihe.</li></ul>';
			$_SESSION['turn'] = ENEMY_ID_PREFIX;
			$color = 'darkblue'; //TODO: Farbe irgendwoher beziehen.
			//ai spielt
		}
		$cell = array('i' => $i,
					  'j' => $j,
					  'color' => $color,
					  'gameField' => ENEMY_ID_PREFIX);
		$cellData = array(0 => $cell);
		$postData['cells'] = $cellData;
		echo json_encode(GameHelperFunctions::utf8ize($postData));
	}
	
?>