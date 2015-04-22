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
	if(!isset($_SESSION['gameState']))
		startNewSession();
	
	processClick();
	
	function startNewSession() {
		$_SESSION['gameState'] = 0;
		//$_SESSION['gameFieldSelf'] = array();
		//$_SESSION['gameFieldEnemy'] = array();
		
		$_SESSION['gameFieldSelf'] = initializeOrFetchGame();
		$_SESSION['gameFieldEnemy'] = initializeOrFetchGame();
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
		$remainingShips = array();
		$drawnShips = checkAmountOfShips();
		global $requiredShips;
		$warning = "";
		if (isset($drawnShips['illegal'])) {
			return ILLEGAL_SHIP_ALIGNMENT_WARNING;
		}
		for ($i = 1; $i < 11; $i++) { //TODO: array dynamisch auslesen!
			$remainingShips[$i] = isset($drawnShips[$i]) ? $requiredShips[$i] - $drawnShips[$i] : $requiredShips[$i];
			if ($remainingShips[$i] < 0) {
				$warning = $warning."Anzahl an {$i}er Schiffen überschritten.<br>"; //TODO: hard coding entfernen
			}
		}
		return getDrawnShipsCode($remainingShips)."<br>".$warning;
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
		for ($i = 0; $i < 10; $i++) {
			for ($j = 0; $j < 10; $j++) {
				if ($gameField[$i][$j] == SHIP_ID) { 
					$currentShipLength = 0;
					
					$iminus = ($i <= 0) ? 0: $i - 1;
					$iplus = ($i >= 9) ? 9 : $i + 1;
					
					$jminus = ($j <= 0) ? 0: $j - 1;
					$jplus = ($j >= 9) ? 9 : $j + 1;
					
					if ($gameField[$iplus][$jplus] == SHIP_ID || 
						$gameField[$iminus][$jplus] == SHIP_ID ||
						$gameField[$iminus][$jplus] == SHIP_ID ||
						$gameField[$iminus][$jplus] == SHIP_ID) {
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
			
			$post_data = array('i' => $i,
			'j' => $j,
			'color' => 'gray',
			'field' => $idPrefix);
			
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
			$post_data = json_encode($post_data);
			echo($post_data);
		} else {
			
		}
	}
	
	function resetSession() { //temporary
		session_unset(); 
		session_destroy();
	}
		
	/*$post_data = array('item_type_id' => $item_type,
		'string_key' => $string_key,
		'string_value' => $string_value,
		'string_extra' => $string_extra,
		'is_public' => $public,
		'is_public_for_contacts' => $public_contacts);
		$post_data = json_encode(array('item' => $post_data));*/
?>