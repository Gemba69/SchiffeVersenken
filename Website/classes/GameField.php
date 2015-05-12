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
		* The function returns what it did as a string. If the attacked piece was a ship,
		* the function returns HIT_ID as an indicator that the attack hit a ship. Invalid
		* moves (such as attacking a piece that is out of bounds or a piece that was 
		* attacked already) return "INVALID".
		*/
		public function attack($i, $j) {
			if ($gameField[$i][$j] === WATER_ID) {
				$gameField[$i][$j] = MISS_ID;
				return false;
			} else if ($gameField[$i][$j] === SHIP_ID) {
				$gameField[$i][$j] = HIT_ID;
				//TODO: check if destroyed
				return true;
			} else 
				return "INVALID";
		}
	}
?>