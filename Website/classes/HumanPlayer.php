<?php
	require_once('IPlayer.php');
	require_once('GameHelperFunctions.php');
		
	class HumanPlayer implements IPlayer {
		private $id = "";
		private $name = "";
		private $waiting = false;
		
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
		
		public function setWaiting($waiting) {
			$this->waiting = $waiting;
		}
		
		public function isWaiting() {
			return $this->waiting;
		}
		
		public function placeShips($requiredShips) {
			$this->waiting = true;
			$postData = array('nextRequest' => 'classes/ShipPlacement.php');
			echo json_encode($postData);
			while($this->waiting) {
				$game = $_SESSION['game'];
				$this->waiting = $game->getPlayer1()->isWaiting();
				sleep(1);
			}
			echo ("fick deine mudda");
		}
		
		public function fireShot(&$gameField, $requiredShips) {
			$this->waiting = true;
			$postData = array('nextRequest' => 'classes/ShotFiring.php');
			echo json_encode($postData);
			while($this->waiting) {
				$game = $_SESSION['game'];
				$this->waiting = $game->getPlayer1()->isWaiting();
				sleep(1);
			}
			//TODO: Code, der mit der Oberfläche interagiert, den Spieler Zug um Zug angreifen lässt, bis ein Schiff nicht getroffen wurde
			
		}
		
		public function isWon() {
			//TODO: Code, der zurückgibt, ob das Spiel für den Spieler gewonnen ist
		}
	}
?>