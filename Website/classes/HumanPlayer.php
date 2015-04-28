<?php
	require_once('IPlayer.php');
	require_once('GameHelperFunctions.php');
	
	class HumanPlayer implements IPlayer {
		private $id = "";
		private $name = "";
		
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
			$postData = array('nextRequest' => 'ShipPlacement.php');
			echo json_encode($postData);
		}
		
		public function fireShot($gameField, $requiredShips) {
			//TODO: Code, der mit der Oberfläche interagiert, den Spieler Zug um Zug angreifen lässt, bis ein Schiff nicht getroffen wurde
		}
		
		public function isWon() {
			//TODO: Code, der zurückgibt, ob das Spiel für den Spieler gewonnen ist
		}
	}
?>