<?php 
	define('ENEMY_ID_PREFIX', "enemy");
	define('SELF_ID_PREFIX', "self");
	define('WATER_ID', "WASSER");
	define('SHIP_ID', "SCHIFF");
	define('MISS_ID', "MISS");
	define('HIT_ID', "TREFFER");
	define('DESTROYED_ID', "VERSENKT");
	define('ILLEGAL_SHIP_ALIGNMENT_WARNING', "<li>Die aktuelle Anordnung ist ungültig.<br>Verschiedene Schiffe dürfen sich nicht berühren.</li>");
	$requiredShips =  array('10' => 0, '9' => 0, '8' => 0, '7' => 0, '6' => 0, '5' => 1, '4' => 2, '3' => 3, '2' => 4, '1' => 0); //todo: aus der datenbank auslesen
	require_once('drawFunctions.php');
		
	session_start();  
	
	if(!isset($_SESSION['gameState'])) {
		startNewSession();
		processClick();
	} else if (isset($_POST['resume'])) {
		resumeExistingSession();
	} else
		processClick();
	
	function startNewSession() {
		$_SESSION['gameState'] = 0;
		
		$_SESSION['gameFieldSelf'] = initializeOrFetchGame();
		$_SESSION['gameFieldEnemy'] = initializeOrFetchGame();
	}
	
	function resumeExistingSession() {
		//TODO: gameState
		$gameFieldSelf = $_SESSION['gameFieldSelf'];
		$cell_data = array();
		
		$counter = 0;
		for ($i = 0; $i < 10; $i++) {
			for ($j = 0; $j < 10; $j++) {
				if ($gameFieldSelf[$i][$j] === SHIP_ID) {
					$cell = array('i' => $i,
								  'j' => $j,
								  'color' => 'gray',
								  'field' => SELF_ID_PREFIX);
					$cell_data[$counter] = $cell;
					$counter++;
				}
			}
		}
			
		$post_data = array('cells' => $cell_data);
		$post_data['illegal'] = false;
		$post_data['remainingShipCode'] = drawRemainingShips();
		$post_data['allShipsPlaced'] = allShipsPlaced();
		$post_data = json_encode($post_data);
		echo($post_data);
	}
		
	function initializeOrFetchGame() {
		$field = array();
		for ($i = 0; $i < 10; $i++) { //TODO: feldgroesse dynamisch machen
            for ($j = 0; $j < 10; $j++) {
                $field[$i][$j]= WATER_ID;
            }
        }
		return $field;
		//TODO: spiel aus datenbank holen
	}
	
	function drawRemainingShips() {
		$drawnShips = checkAmountOfShips();
		global $requiredShips;
		$warning = "";
		$remainingShips = getRemainingShipsPlusWarning($drawnShips, $requiredShips, $warning);
		if (isset($drawnShips['illegal'])) {
			return ILLEGAL_SHIP_ALIGNMENT_WARNING;
		}
		
		return getDrawnShipsCode($remainingShips)."<br>".$warning;
	}
	
	function getRemainingShipsPlusWarning($drawnShips, $requiredShips, &$warning) {
		$remainingShips = array();
		$warning = "";
		for ($i = 1; $i < 11; $i++) { //TODO: array dynamisch auslesen!
			$remainingShips[$i] = isset($drawnShips[$i]) ? $requiredShips[$i] - $drawnShips[$i] : $requiredShips[$i];
			if ($remainingShips[$i] < 0) {
				$warning = $warning."Anzahl an {$i}er Schiffen überschritten.<br>"; //TODO: hard coding entfernen
			}
		}
		return $remainingShips;
	}
	
	function getRemainingShips($drawnShips, $requiredShips) {
		$throwAwayWarning = "";
		return getRemainingShipsPlusWarning($drawnShips, $requiredShips, $throwAwayWarning);
	}
	
	function allShipsPlaced() {
		$drawnShips = checkAmountOfShips();
		global $requiredShips;
		$remainingShips = getRemainingShips($drawnShips, $requiredShips);
		$noShipsLeft = true;
		for ($i = 1; $i < 11; $i++) { //todo: dynamisch auslesen!
			if ($remainingShips[$i] != 0)
				$noShipsLeft = false;
		}
		return $noShipsLeft;
	}
	
	function checkAmountOfShips() {
		$gameFieldSelf = $_SESSION['gameFieldSelf'];
		$result = array();
		if(!shipAlignmentIsValid($gameFieldSelf)) {
			$result['illegal'] = true;
			return $result;
		}
		for ($i = 0; $i < 10; $i++) {
			for ($j = 0; $j < 10; $j++) {
				if ($gameFieldSelf[$i][$j] === SHIP_ID) {
					$shipLength = checkShipLength($i, $j, $gameFieldSelf);
					$result[$shipLength] = isset($result[$shipLength]) ? $result[$shipLength] + 1 : 1;
				}
			}
		}
		return $result;
	}
	
	
	function shipAlignmentIsValid($gameField) {
		for ($i = 1; $i < 9; $i++) {
			for ($j = 1; $j < 9; $j++) {
				if ($gameField[$i][$j] == SHIP_ID) { 				
					if ($gameField[$i + 1][$j + 1] == SHIP_ID || 
						$gameField[$i - 1][$j + 1] == SHIP_ID ||
						$gameField[$i + 1][$j - 1] == SHIP_ID ||
						$gameField[$i - 1][$j - 1] == SHIP_ID) {
						return false;
					}
				}
			}
		} //TODO: dynamisch
		return true;
	}
	
	function checkShipLength($i, $j, &$gameField) {
		$length = 0;
		if ($gameField[$i][$j] == SHIP_ID) {
			$length++;
			$gameField[$i][$j] = WATER_ID;
			
			$iminus = ($i <= 0) ? 0: $i - 1;
			$iplus = ($i >= 9) ? 9 : $i + 1;
			$jminus = ($j <= 0) ? 0: $j - 1;
			$jplus = ($j >= 9) ? 9 : $j + 1;
			
			$length += checkShipLength($i, $jplus, $gameField);
			$length += checkShipLength($i, $jminus, $gameField);
			$length += checkShipLength($iplus, $j, $gameField);
			$length += checkShipLength($iminus, $j, $gameField);
		} 
		return $length;
	}

	function processClick() {
		if (isset($_POST['reset'])) {
			resetSession();
			echo ("Session destroyed.");
			return;
		}
		
		if ($_SESSION['gameState'] == 0) {		
			$i = $_POST['i'];
			$j = $_POST['j'];
			$idPrefix = $_POST['idPrefix'];
			$gameFieldSelf = $_SESSION['gameFieldSelf'];
			
			$cell = array('i' => $i,
				'j' => $j,
				'color' => 'gray',
				'field' => $idPrefix);
			
			$cell_data = array(0 => $cell);
			
			$post_data = array('cells' => $cell_data);
			
			if ($idPrefix == ENEMY_ID_PREFIX) {
				$post_data['illegal'] = true;
			} else {
				$post_data['illegal'] = false;
				if ($gameFieldSelf[$i][$j] == SHIP_ID) {
					$gameFieldSelf[$i][$j] = WATER_ID;
				} else if ($gameFieldSelf[$i][$j] == WATER_ID) {
					$gameFieldSelf[$i][$j] = SHIP_ID;
				}
				$_SESSION['gameFieldSelf'] = $gameFieldSelf; 
			}
			$post_data['remainingShipCode'] = drawRemainingShips();
			$post_data['allShipsPlaced'] = allShipsPlaced();
			$post_data = json_encode($post_data);
			echo($post_data);
		} else {
			
		}
	}
	
	function resetSession() { //temporary
		session_unset(); 
		session_destroy();
	}
?>