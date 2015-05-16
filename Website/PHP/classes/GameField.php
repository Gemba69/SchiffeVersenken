<?php
	require_once("GameHelperFunctions.php");
	
	class GameField {
		private $gameField;
		
		public function __construct($array) {
			$this->gameField = $array;
		}
		
		public function getAsArray() {
			return $this->gameField;
		}
		
		public function get($i, $j) {
			return $this->gameField[$i][$j];
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
		*/
		public function attack($i, $j) {
			if ($this->gameField[$i][$j] === WATER_ID) {
				$this->gameField[$i][$j] = MISS_ID;
				return MISS_ID;
			} else if ($this->gameField[$i][$j] === SHIP_ID) {
				$this->gameField[$i][$j] = HIT_ID;
				if ($this->checkIfDestroyed($i, $j, $this->gameField)) {
					$this->destroyShip($i, $j, $this->gameField);
					return DESTROYED_ID;
				}
				else
					return HIT_ID;
			} else 
				return "INVALID";
		}
		
		
		/**
		*
		*
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
		
		private function destroyShip($i, $j, &$gameField) {
			if ($gameField[$i][$j] == HIT_ID) {				
				$iminus = ($i <= 0) ? 0: $i - 1;
				$iplus = ($i >= 9) ? 9 : $i + 1;
				$jminus = ($j <= 0) ? 0: $j - 1;
				$jplus = ($j >= 9) ? 9 : $j + 1;
					
				$gameField[$i][$j] = DESTROYED_ID;
			
				$this->destroyShip($i, $jplus, $gameField);
				$this->destroyShip($i, $jminus, $gameField);
				$this->destroyShip($iplus, $j, $gameField);
				$this->destroyShip($iminus, $j, $gameField);
			} 
		}
	}
?>