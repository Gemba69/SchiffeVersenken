<?php
	require_once('IPlayer.php');
	require_once('GameHelperFunctions.php');
	
	class AI implements IPlayer {
		private $id;
		private $name;
		
		private $gameField;
		
		public function __construct($fId, $fName) {
			$this->id = $fId;
			$this->name = $fName;
		}
		
		public function setGameField($fGameField) {
			$this->gameField = $fGameField;
		}
		
		public function getGameField() {
			return $this->gameField;
		}
		
		public function placeShips($requiredShips) {
			//todo: placeholder - ships are fixed
			$gameField.toggleShip(0, 0);
			$gameField.toggleShip(0, 1);
			$gameField.toggleShip(0, 2);
			$gameField.toggleShip(0, 3);
			$gameField.toggleShip(0, 4);
			
			$gameField.toggleShip(0, 6);
			$gameField.toggleShip(0, 7);
			$gameField.toggleShip(0, 8);
			$gameField.toggleShip(0, 9);
			
			$gameField.toggleShip(2, 0);
			$gameField.toggleShip(2, 1);
			$gameField.toggleShip(2, 2);
			$gameField.toggleShip(2, 3);
			
			$gameField.toggleShip(2, 5);
			$gameField.toggleShip(2, 6);
			$gameField.toggleShip(2, 7);
			
			$gameField.toggleShip(4, 0);
			$gameField.toggleShip(4, 1);
			$gameField.toggleShip(4, 2);
			
			$gameField.toggleShip(4, 4);
			$gameField.toggleShip(4, 5);
			$gameField.toggleShip(4, 6);
			
			$gameField.toggleShip(4, 8);
			$gameField.toggleShip(4, 9);
			
			$gameField.toggleShip(6, 0);
			$gameField.toggleShip(6, 1);
			
			$gameField.toggleShip(6, 3);
			$gameField.toggleShip(6, 4);
			
			$gameField.toggleShip(6, 6);
			$gameField.toggleShip(6, 7);
		}
		
		public function fireShot($gameField, $requiredShips) {
			//TODO: Code, der mit der Oberfläche interagiert, den Spieler Zug um Zug angreifen lässt, bis ein Schiff nicht getroffen wurde
		}
		
		public function isWon() {
			//TODO: Code, der zurückgibt, ob das Spiel für den Spieler gewonnen ist
		}
	}
?>