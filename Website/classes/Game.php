<?php 
	require_once('GameField.php');

	class Game {
		private $phase;
		private $requiredShips;
		private $player1;
		private $player2;
		
		public function __construct($fRequiredShips, $fieldWidth, $fieldHeight, $fPlayer1, $fPlayer2) {
			$this->requiredShips = $fRequiredShips;
			$gameField1 = new GameField(GameHelperFunctions::initializeOrFetchGame($fieldWidth, $fieldHeight));
			$gameField2 = new GameField(GameHelperFunctions::initializeOrFetchGame($fieldWidth, $fieldHeight));
			
			$fPlayer1->setGameField($gameField1);
			$fPlayer2->setGameField($gameField2);

			$this->player1 = $fPlayer1;
			$this->player2 = $fPlayer2;
			$this->phase = 0;
		}
		
		public function getPlayer1() {
			return $this->player1;
		}
		
		public function setPlayer1($player) {
			$this->player1 = $player;
		}
		
		public function getPlayer2() {
			return $this->player2;
		}
		
		public function setPlayer2($player) {
			$this->player2 = $player;
		}
		
		public function getPhase() {
			return $this->phase;
		}
		
		public function setPhase($fPhase) {
			$this->phase = $fPhase;
		}
		
		public function getRequiredShips() {
			return $this->requiredShips;
		}
		
		public function playPhase1() {
			$this->player1 -> placeShips($this->requiredShips);
			$this->player2 -> placeShips($this->requiredShips);
		}
		
		public function playPhase2() {
			while (!$player1.isWon() && !$player2.isWon()) {
				while ($player1.fireShot($player2.getGameFieldSelf(), $requiredShips)) {}
				while ($player2.fireShot($player1.getGameFieldSelf(), $requiredShips)) {}
			}
			//TODO: Etwas mit dem Gewinner machen
		}
	}	
?>