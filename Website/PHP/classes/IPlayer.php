<?php 
	interface IPlayer {
		
		public function __construct($fId, $fName);
		
		public function placeShips($requiredShips);
		
		public function fireShot(&$gameField, $requiredShips);
		
		public function isWon();
	}
?>