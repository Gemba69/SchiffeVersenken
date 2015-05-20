<?php
	require_once("GameHelperFunctions.php");
	
	class GameField {
		private $gameField;
		
		public function __construct($array) {
			$this->gameField = $array;
		}
		
		/**
		* @return Das Spielfeld als Array
		*/
		public function getAsArray() {
			return $this->gameField;
		}
		
		public function toggleShip($i, $j) {
			if ($this->gameField[$i][$j] === WATER_ID) {
				$this->gameField[$i][$j] = SHIP_ID;
				return SHIP_ID;
			} elseif ($this->gameField[$i][$j] === SHIP_ID) {
				$this->gameField[$i][$j] = WATER_ID;
				return WATER_ID;
			}
		}
		
		/**
		* Attacks the specified piece and turns it either red or dark blue. A piece 
		* already attacked cannot be attacked again. If a whole ship is destroyed, all 
		* of its pieces are turned black instead. 
		*
		* The function returns what it did as a boolean. If the attacked piece was a ship,
		* the function returns true as an indicator that the attack hit a ship. Invalid
		* moves (such as attacking a piece that is out of bounds or a piece that was 
		* attacked already) return "INVALID".
		* @param $i the X coordinate
		* @param $j the Y coordinate
		* @return MISS_ID if missed, HIT_ID if hit, DESTROYED_ID if destroyed, 'INVALID' if a piece already hit, missed or destroyed was attacked
		*/
		public function attack($i, $j) {
			if ($this->gameField[$i][$j] === WATER_ID) {
				$this->gameField[$i][$j] = MISS_ID;
				return MISS_ID;
			} else if ($this->gameField[$i][$j] === SHIP_ID) {
				$this->gameField[$i][$j] = HIT_ID;
				if ($this->checkIfDestroyed($i, $j, $this->gameField)) {
					$this->destroyShipCore($i, $j, $this->gameField);
					return DESTROYED_ID;
				}
				else
					return HIT_ID;
			} else 
				return "INVALID";
		}
		
		
		/**
		* Überprüft, ob die übergebene Zelle zu einem zerstörten Schiff gehört.
		* @param $i X-Koordinate
		* @param $j Y-Koordinate
		* @param $gameField Spielfeld als Array
		* @return true wenn zerstört, false wenn nicht
		*/
		private function checkIfDestroyed($i, $j, $gameField) {
			$destroyed = true;
			if ($gameField[$i][$j] == HIT_ID) {				
				$iminus = ($i <= 0) ? 0: $i - 1;
				$iplus = ($i >= 9) ? 9 : $i + 1;
				$jminus = ($j <= 0) ? 0: $j - 1;
				$jplus = ($j >= 9) ? 9 : $j + 1;
					
				$gameField[$i][$j] = WATER_ID;
			
				$destroyed = $this->checkIfDestroyed($i, $jplus, $gameField) &&
							 $this->checkIfDestroyed($i, $jminus, $gameField) &&
							 $this->checkIfDestroyed($iplus, $j, $gameField) &&
							 $this->checkIfDestroyed($iminus, $j, $gameField);
			} else if ($gameField[$i][$j] == SHIP_ID) {
				$destroyed = false;
				$gameField[$i][$j] = WATER_ID;
			}
			return $destroyed;
		}
		
		/**
		* Zerstört das gesamte Schiff der angegebenen Zelle
		* @param $i X-Koordinate
		* @param $j Y-Koordinate
		*/
		public function destroyShip($i, $j) {
			if ($this->checkIfDestroyed($i, $j, $this->gameField))
				$this->destroyShipCore($i, $j, $this->gameField);
		}
		
		/**
		* Logik der destroyShip-Methode. Hier ist noch &$gameField als Parameter nötig, weil die Methode rekursiv arbeitet.
		*/
		private function destroyShipCore($i, $j, &$gameField) {
			if ($gameField[$i][$j] == HIT_ID) {				
				$iminus = ($i <= 0) ? 0: $i - 1;
				$iplus = ($i >= 9) ? 9 : $i + 1;
				$jminus = ($j <= 0) ? 0: $j - 1;
				$jplus = ($j >= 9) ? 9 : $j + 1;
					
				$gameField[$i][$j] = DESTROYED_ID;
			
				$this->destroyShipCore($i, $jplus, $gameField);
				$this->destroyShipCore($i, $jminus, $gameField);
				$this->destroyShipCore($iplus, $j, $gameField);
				$this->destroyShipCore($iminus, $j, $gameField);
			} 
		}
		
		/**
		* Gibt alle Zellen eines zerstörten Schiffs zurück
		* @param $i X-Koordinate 
		* @param $j Y-Koordinate
		* @return Die zerstörten Zellen als Array
		*/
		public function getAllDestroyedTiles($i, $j) {
			return $this->getAllDestroyedTilesCore($i, $j, $this->gameField);
		}
		
		/**
		* Logik der getAllDestroyedTiles-Methode. Hier ist noch $gameField als Parameter nötig, weil die Methode rekursiv arbeitet.
		*/
		private function getAllDestroyedTilesCore($i, $j, $gameField) {
			if ($gameField[$i][$j] == DESTROYED_ID) {				
				$iminus = ($i <= 0) ? 0: $i - 1;
				$iplus = ($i >= 9) ? 9 : $i + 1;
				$jminus = ($j <= 0) ? 0: $j - 1;
				$jplus = ($j >= 9) ? 9 : $j + 1;
				
				$gameField[$i][$j] = WATER_ID;

				$ret = isset($ret) ? array_merge($ret, array('i' => $i, 'j' => $j)) : array(0 => array('i' => $i, 'j' => $j));
			
				$ret = array_merge($ret, $this->getAllDestroyedTilesCore($i, $jplus, $gameField));
				$ret = array_merge($ret, $this->getAllDestroyedTilesCore($i, $jminus, $gameField));
				$ret = array_merge($ret, $this->getAllDestroyedTilesCore($iplus, $j, $gameField));
				$ret = array_merge($ret, $this->getAllDestroyedTilesCore($iminus, $j, $gameField));
			} 
			return isset($ret) ? $ret : array();
		}
	}
?>