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
		case 'aiCombo':
			aiPlays();
			break;
	}
	
	function resumeSession() {
			$gameFieldSelfArray = $_SESSION['gameFieldSelf']->getAsArray();
			$gameFieldEnemyArray = $_SESSION['gameFieldSelf']->getAsArray();

			$postData = GameHelperFunctions::generateResumeSessionArray($gameFieldSelfArray, $gameFieldEnemyArray, $_SESSION['requiredShips'], $_SESSION['gamePhase']);
			echo json_encode(GameHelperFunctions::utf8ize($postData));
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
		$postData = GameHelperFunctions::generateClickResponseArray($gameFieldSelfArray, $_SESSION['requiredShips'], 1, null, null, null, null);
		$_SESSION['gameFieldEnemy'] = new GameField(AI::schiffeSetzen(GameHelperFunctions::initializeOrFetchGame(10, 10), $_SESSION['requiredShips'])); // TODO: 10x10 zentral auslesen
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
		$_SESSION['gameFieldSelf'] = $gameFieldSelf;
		$postData = GameHelperFunctions::generateClickResponseArray($gameFieldSelf->getAsArray(), $_SESSION['requiredShips'], 0, $i, $j, SELF_ID_PREFIX, SHIP_ID);
		echo json_encode(GameHelperFunctions::utf8ize($postData));
	}
	
	function processPhase2CellClick() {
		$gameFieldEnemy = $_SESSION['gameFieldEnemy'];
		$i = $_POST['i'];
		$j = $_POST['j'];
		
		$instructions = PHASE_2_MAJOR_INSTRUCTIONS;
		$aiTurn = false;
		
		$result = $gameFieldEnemy->attack($i, $j);
		if ($result == HIT_ID) {
			$postData['instructions'] = $instructions.'<ul><li class="fadeinanim">Treffer! Noch einmal!</li></ul>';
			$ship = HIT_ID; //TODO: Farbe irgendwoher beziehen.
		} else if ($result == MISS_ID) {
			$postData['instructions'] = $instructions.'<ul><li class="fadeinanim">Daneben. Der Gegner ist an der Reihe.</li></ul>';
			$_SESSION['turn'] = ENEMY_ID_PREFIX;
			$ship = MISS_ID; //TODO: Farbe irgendwoher beziehen.
			$aiTurn = true;
		} else if ($result == DESTROYED_ID) {
			$postData['instructions'] = $instructions.'<ul><li class="fadeinanim">Versenkt! Und weiter geht\'s!</li></ul>';
			$ship = DESTROYED_ID;
		} else {
			$postData['instructions'] = $instructions.'<ul><li class="fadeinanim">Dort wurde schon hingeschossen. </li></ul>';
			echo json_encode(GameHelperFunctions::utf8ize($postData));
			return;
		}
		$cellData = GameHelperFunctions::generateCellDataArrayForSingleClick($i, $j, $ship, ENEMY_ID_PREFIX);
		$postData['cells'] = $cellData;
		if (GameHelperFunctions::checkWin($gameFieldEnemy->getAsArray())) {
			$postData['instructions'] = "Gewonnen!";
			$postData['title'] = "Sieg";
			$_SESSION['turn'] = "lolnope, nobody";
		}
		if ($aiTurn) 
			$postData['sendAnotherRequest'] = true;
		echo json_encode(GameHelperFunctions::utf8ize($postData));
	}
	
	function aiPlays() {
		$gameFieldSelf = $_SESSION['gameFieldSelf'];
		$gameFieldEnemy = $_SESSION['gameFieldEnemy'];
		
		
		$koords = AI::angriff($gameFieldSelf->getAsArray(), $_SESSION['requiredShips']);
		$i = $koords[0];
		$j = $koords[1];
		$ship = $gameFieldSelf->attack($i, $j);
		if ($ship == MISS_ID) {
			$postData['instructions'] = PHASE_2_MAJOR_INSTRUCTIONS;
		}
		$cellData = GameHelperFunctions::generateCellDataArrayForSingleClick($i, $j, $ship, SELF_ID_PREFIX);

		$postData['cells'] = $cellData;
		$_SESSION['gameFieldSelf'] = $gameFieldSelf;
		
		if ($ship == HIT_ID || $ship == DESTROYED_ID) 
			$postData['sendAnotherRequest'] = true;
		else 
			$_SESSION['turn'] = SELF_ID_PREFIX;
		
		if (GameHelperFunctions::checkWin($gameFieldEnemy->getAsArray())) {
			$postData['instructions'] = "Du hast verloren.";
			$postData['title'] = "Niederlage";
			$_SESSION['turn'] = "lolnope, nobody";
		}
		echo json_encode(GameHelperFunctions::utf8ize($postData));
	}
	
?>