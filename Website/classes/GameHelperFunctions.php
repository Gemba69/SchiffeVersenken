<?php 
	require_once('DrawFunctions.php');

	define('ENEMY_ID_PREFIX', "enemy");
	define('SELF_ID_PREFIX', "self");
	define('WATER_ID', "WASSER");
	define('SHIP_ID', "SCHIFF");
	define('MISS_ID', "MISS");
	define('HIT_ID', "TREFFER");
	define('DESTROYED_ID', "VERSENKT");
	define('ILLEGAL_SHIP_ALIGNMENT_WARNING', "<li>Die aktuelle Anordnung ist ungültig.<br>Verschiedene Schiffe dürfen sich nicht berühren.</li>");
	
	class GameHelperFunctions {
		public static function initializeOrFetchGame($width, $height) {
			$field = array();
			for ($i = 0; $i < $width; $i++) { //TODO: feldgroesse dynamisch machen
				for ($j = 0; $j < $heigth; $j++) {
					$field[$i][$j]= WATER_ID;
				}
			}
			return $field;
			//TODO: spiel aus datenbank holen
		}
		
		public static function drawRemainingShips($gameField, $requiredShips) {
			$drawnShips = checkAmountOfShips($gameField);
			$warning = "";
			$remainingShips = getRemainingShipsPlusWarning($drawnShips, $requiredShips, $warning);
			if (isset($drawnShips['illegal'])) {
				return ILLEGAL_SHIP_ALIGNMENT_WARNING;
			}
			
			return getDrawnShipsCode($remainingShips)."<br>".$warning;
		}
		
		public static function allShipsPlaced($gameField) {
			$drawnShips = checkAmountOfShips($gameField);
			global $requiredShips;
			$remainingShips = getRemainingShips($drawnShips, $requiredShips);
			$noShipsLeft = true;
			for ($i = 1; $i < 11; $i++) { //todo: dynamisch auslesen!
				if ($remainingShips[$i] != 0)
					$noShipsLeft = false;
			}
			return $noShipsLeft;
		}
		
		public static function buildCellDataStructure($gameField) {
			//TODO: verschiedene phasen
			$cellData = array();
			
			$counter = 0;
			for ($i = 0; $i < 10; $i++) {
				for ($j = 0; $j < 10; $j++) {
					if ($gameField[$i][$j] === SHIP_ID) {
						$cell = array('i' => $i,
									  'j' => $j,
									  'color' => 'gray', //TODO: farbe aus gameField auslesen
									  'field' => SELF_ID_PREFIX);
						$cellData[$counter] = $cell;
						$counter++;
					}
				}
			}
				
			$postData = array('cells' => $cell_data);
			$postData['remainingShipCode'] = drawRemainingShips($gameField);
			$postData['allShipsPlaced'] = allShipsPlaced($gameField);
			return $postData;
		}
		
		
		private static function getRemainingShipsPlusWarning($drawnShips, $requiredShips, &$warning) {
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
		
		private static function getRemainingShips($drawnShips, $requiredShips) {
			$throwAwayWarning = "";
			return getRemainingShipsPlusWarning($drawnShips, $requiredShips, $throwAwayWarning);
		}
		
		private static function checkAmountOfShips($gameField) {
			$result = array();
			if(!shipAlignmentIsValid($gameField)) {
				$result['illegal'] = true;
				return $result;
			}
			for ($i = 0; $i < 10; $i++) {
				for ($j = 0; $j < 10; $j++) {
					if ($gameField[$i][$j] === SHIP_ID) {
						$shipLength = checkShipLength($i, $j, $gameField);
						$result[$shipLength] = isset($result[$shipLength]) ? $result[$shipLength] + 1 : 1;
					}
				}
			}
			return $result;
		}
			
		private static function shipAlignmentIsValid($gameField) {
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
		
		private static function checkShipLength($i, $j, &$gameField) {
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

	}
?>