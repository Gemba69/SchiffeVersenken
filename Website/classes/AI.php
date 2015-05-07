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
			$this->gameField->toggleShip(0, 0);
			$this->gameField->toggleShip(0, 1);
			$this->gameField->toggleShip(0, 2);
			$this->gameField->toggleShip(0, 3);
			$this->gameField->toggleShip(0, 4);
			
			$this->gameField->toggleShip(0, 6);
			$this->gameField->toggleShip(0, 7);
			$this->gameField->toggleShip(0, 8);
			$this->gameField->toggleShip(0, 9);
			
			$this->gameField->toggleShip(2, 0);
			$this->gameField->toggleShip(2, 1);
			$this->gameField->toggleShip(2, 2);
			$this->gameField->toggleShip(2, 3);
			
			$this->gameField->toggleShip(2, 5);
			$this->gameField->toggleShip(2, 6);
			$this->gameField->toggleShip(2, 7);
			
			$this->gameField->toggleShip(4, 0);
			$this->gameField->toggleShip(4, 1);
			$this->gameField->toggleShip(4, 2);
			
			$this->gameField->toggleShip(4, 4);
			$this->gameField->toggleShip(4, 5);
			$this->gameField->toggleShip(4, 6);
			
			$this->gameField->toggleShip(4, 8);
			$this->gameField->toggleShip(4, 9);
			
			$this->gameField->toggleShip(6, 0);
			$this->gameField->toggleShip(6, 1);
			
			$this->gameField->toggleShip(6, 3);
			$this->gameField->toggleShip(6, 4);
			
			$this->gameField->toggleShip(6, 6);
			$this->gameField->toggleShip(6, 7);
		}
		
		public function fireShot($gameField, $requiredShips) {
			//TODO: Code, der mit der Oberfläche interagiert, den Spieler Zug um Zug angreifen lässt, bis ein Schiff nicht getroffen wurde
		}
		
		public function isWon() {
			//TODO: Code, der zurückgibt, ob das Spiel für den Spieler gewonnen ist
		}
	}
?>