<?php 
	require_once('DrawFunctions.php');

	//Konstanten
	define('ENEMY_ID_PREFIX', "enemy");
	define('SELF_ID_PREFIX', "self");
	define('WATER_ID', "WASSER");
	define('SHIP_ID', "SCHIFF");
	define('MISS_ID', "MISS");
	define('HIT_ID', "TREFFER");
	define('AI_ID', 0);
	define('DESTROYED_ID', "VERSENKT");
	define('ILLEGAL_SHIP_ALIGNMENT_WARNING', "<li>Die aktuelle Anordnung ist ungültig.<br>Verschiedene Schiffe dürfen sich nicht berühren.</li>");
	define("PHASE_1_TITLE", "Planung");
	define("PHASE_2_TITLE", "Angriff");
	define("PHASE_1_MAJOR_INSTRUCTIONS", "Platziere deine Schiffe auf dem unteren Feld."); //TODO: nicht hardcoden
	define("PHASE_2_MAJOR_INSTRUCTIONS", "Feuere die Schiffe deines Gegners auf dem oberen Feld ab."); //TODO: nicht hardcoden
	define("CONTINUE_BUTTON_CODE", "<div class='buttondiv fadeinanim'><img class='buttonimg' src='./resources/attack.png'><button id='continuebutton' onclick='nextPhaseAjaxRequest()'>Angriff beginnen</button></div>");
	define("BACK_BUTTON_CODE", "<div class='buttondiv' fadeinanim'><img class='buttonimg' src='./resources/arrow.png'><a id='backbutton' href='Spielauswahl.php'>Zurück zur Spielauswahl</a></div>");
	define("CONTINUE_INSTRUCTIONS", "Sehr gut. Wenn du sicher bist, dass alle Schiffe richtig platziert sind, gehe nun zum Angriff über.");
	define("SHIP_PLACEMENT_FILE", "PHP/classes/ShipPlacement.php");
	define("SHOT_FIRING_FILE", "PHP/classes/ShotFiring.php");
	
	/**
	* Klasse, die verschiedene Funktionen bereitstellt, die das Leben vereinfachen.
	*/
	class GameHelperFunctions {
		
		/**
		* Kodiert einen String oder ein Array mit UTF-8. Das ist nötig, um Arrays korrekt in JSON zu parsen
		* @return Das UTF-8-kodierte Array 
		*/
		public function utf8ize($d) {
			if (is_array($d)) {
				foreach ($d as $k => $v) {
					$d[$k] = self::utf8ize($v);
				}
			} else if (is_string ($d)) {
				return utf8_encode($d);
			}
			return $d;
		}
	
		/**
		* Erstellt eine neues, zweidimensionales Array der angegebenen Größe und füllt es komplett mit Wasser (WATER_ID)
		* @param $width Die Breite des Felds
		* @param $height Die Höhe des Felds
		* @return Das erstellte Array
		*/
		public static function initializeNewField($width, $height) {
			$field = array();
			for ($i = 0; $i < $width; $i++) { 
				for ($j = 0; $j < $height; $j++) {
					$field[$i][$j]= WATER_ID;
				}
			}
			return $field;
		}
		
		/**
		* Erstellt HTML-Code, der die noch zu setztenden Schiffe darstellt. 
		* Der Unterschied zu getDrawnShipsCode ist, dass die erforderlichen Parameter anders sind.
		* @param $gameField Das GameField als zweidimensionales Array
		* @param $requiredShips Die Schiffe, die zu platzieren sind
		* @return HTML-Code, der die noch zu zeichnenden Schiffe abbildet
		*/
		public static function drawRemainingShips($gameField, $requiredShips) {
			$drawnShips = self::checkAmountOfShips($gameField);
			$warning = "";
			$remainingShips = self::getRemainingShipsPlusWarning($drawnShips, $requiredShips, $warning);
			if (isset($drawnShips['illegal'])) {
				return ILLEGAL_SHIP_ALIGNMENT_WARNING;
			}
			
			return getDrawnShipsCode($remainingShips)."</li><li>".$warning."</li>";
		}
		
		/**
		* Überprüft, ob alle erforderlichen Schiffe gesetzt wurden.
		* @param $gameField Das GameField als zweidimensionales Array
		* @param $requiredShips Die Schiffe, die zu platzieren sind
		* @return true, wenn alle Schiffe gesetzt wurden, false wenn zu viele oder zu wenige Schiffe gesetzt wurden
		*/
		public static function allShipsPlaced($gameField, $requiredShips) {
			$drawnShips = self::checkAmountOfShips($gameField);
			$remainingShips = self::getRemainingShips($drawnShips, $requiredShips);
			$noShipsLeft = true;
			for ($i = 1; $i < 11; $i++) { //todo: dynamisch auslesen!
				if ($remainingShips[$i] != 0)
					$noShipsLeft = false;
			}
			return $noShipsLeft;
		}
		
		/**
		* Erstellt ein Response-Array, das von JavaScript ausgewertet wird. Diese Funktion sollte nur verwendet werden,
		* wenn im Frontend noch kein Feld umgedreht wurde, es im Backend aber schon viele umgedrehte Felder gibt (also wenn ein
		* bestehendes Spiel wieder aufgenommen wurde)
		* @param $gameFieldSelf Das Spielfeld des Spielers als Array
		* @param $gameFieldEnemy Das Spielfeld des Gegners als Array
		* @param $requiredShips Die zu platzierenden Schiffe
		* @param $Die aktuelle Spielphase
		* @return Das Array, welches zurück an den Client gesendet wird. Es muss vorher mit JSON kodiert werden
		*/
		public static function generateResumeSessionArray($gameFieldSelf, $gameFieldEnemy, $requiredShips, $phase) {
			for ($i = 0; $i < count($gameFieldEnemy); $i++) {
				for ($j = 0; $j < count($gameFieldEnemy[$i]); $j++) {
					if ($gameFieldEnemy[$i][$j] == SHIP_ID)
						$gameFieldEnemy[$i][$j] = WATER_ID;
				}
			}
			$cellData = self::generateCellDataArray($gameFieldSelf, SELF_ID_PREFIX);
			$cellData = array_merge($cellData, self::generateCellDataArray($gameFieldEnemy, ENEMY_ID_PREFIX));
			$postData = array('cells' => $cellData);
			if ($phase == 1) {
				if (self::allShipsPlaced($gameFieldSelf, $requiredShips)) {
					$postData['instructions'] = CONTINUE_INSTRUCTIONS."<br><br>".CONTINUE_BUTTON_CODE;
					$postData['title'] = PHASE_1_TITLE;
				} else {
					$remainingShips = self::drawRemainingShips($gameFieldSelf, $requiredShips); //TODO: siehe oben
					$instructions = "<li>".PHASE_1_MAJOR_INSTRUCTIONS."</li>".$remainingShips;
					$postData['instructions'] = $instructions;
					$postData['title'] = PHASE_1_TITLE;
				}
			} else if ($phase == 2) {
				$postData['title'] = PHASE_2_TITLE;
				$postData['instructions'] = PHASE_2_MAJOR_INSTRUCTIONS;
			} else if ($phase == 3) {
				$postData['title'] = "Sieg";
				$postData['instructions'] = BACK_BUTTON_CODE;
			} else if ($phase == 4) {
				$postData['title'] = "Niederlage";
				$postData['instructions'] = BACK_BUTTON_CODE;
			}

			return $postData;
		}
		
		/**
		* Erstellt ein Response-Array, das von JavaScript ausgewertet wird. Diese Funktion ist ähnlich wie generateResumeSessionArray,
		* aber wird im laufenden Spiel verwendet. Der Unterschied ist, dass dem Client hier gesagt wird, dass nur ein Feld umzudrehen ist,
		* nicht alle.
		* @param $gameFieldSelf Das Spielfeld des Spielers als Array
		* @param $gameFieldEnemy Das Spielfeld des Gegners als Array
		* @param $iJustClicked Die X-Koordinate des Feldes, das zurückgesendet werden soll
		* @param $jJustClicked Die Y-Koordinate des Feldes, das zurückgesendet werden soll
		* @param $fieldJustClicked Das idPrefix (SELF_ID_PREFIX, ENEMY_ID_PREFIX) des Feldes, das zurückgesendet werden soll 
		* @param $colorJustClicked Die Farbe, die das zurückgesendete Feld annehmen soll
		* @param $Die aktuelle Spielphase
		* @return Das Array, welches zurück an den Client gesendet wird. Es muss vorher mit JSON kodiert werden
		*/
		public static function generateClickResponseArray($gameFieldSelf, $requiredShips, $phase, $iJustClicked, $jJustClicked, $fieldJustClicked, $colorJustClicked) {
			$cellData = self::generateCellDataArrayForSingleClick($iJustClicked, $jJustClicked, $colorJustClicked, $fieldJustClicked);
			$postData = array('cells' => $cellData);
			if ($phase == 0) {
				if (self::allShipsPlaced($gameFieldSelf, $requiredShips)) {
					$postData['instructions'] = CONTINUE_INSTRUCTIONS."<br><br>".CONTINUE_BUTTON_CODE;
					$postData['title'] = PHASE_1_TITLE;
				} else {
					$remainingShips = self::drawRemainingShips($gameFieldSelf, $requiredShips); //TODO: siehe oben
					$instructions = "<li>".PHASE_1_MAJOR_INSTRUCTIONS."</li>".$remainingShips;
					$postData['instructions'] = $instructions;
					$postData['title'] = PHASE_1_TITLE;
				}
			} else if ($phase == 1) {
				$postData['title'] = PHASE_2_TITLE;
				$postData['instructions'] = PHASE_2_MAJOR_INSTRUCTIONS;
			}
			return $postData;
		}
		
		/**
		* Erstellt ein Teilarray der Funktion generateResumeSessionArray. Hier werden nur die zu färbenden Zellen zurückgegeben, 
		* nicht aber die anderen Informationen wie Titel und Instructions.
		* @param $gameFieldArray Das Spielfeld als Array
		* @param $selfEnemy Das idPrefix (SELF_ID_PREFIX, ENEMY_ID_PREFIX) des Feldes, das zurückgesendet werden soll 
		*/ 
		public static function generateCellDataArray($gameFieldArray, $selfEnemy) {
			$cellData = array();
			$counter = 0;
			for ($i = 0; $i < count($gameFieldArray); $i++) {
				for ($j = 0; $j < count($gameFieldArray[$i]); $j++) {
					$color = self::convertColor($gameFieldArray[$i][$j]);
					if ($gameFieldArray[$i][$j] != WATER_ID) {
						$cell = array('i' => $i,
									  'j' => $j,
									  'color' => $color,
									  'gameField' => $selfEnemy);
						$cellData[$counter] = $cell;
						$counter++;
					}
				}
			}
			return $cellData;
		}
		
		/**
		* Erstellt ein Teilarray der Funktion generateClickResponseArray. Hier wird nur eine zu färbenden Zellen zurückgegeben, 
		* nicht aber die anderen Informationen wie Titel und Instructions.
		* @param $i X-Koordinate der zurückzusendenen Zelle
		* @param $j Y-Koordinate der zurückzusendenen Zelle
		* @param $color  Die Feldtypkonstante (Name ist etwas irreführend)
		* @param $gameField Das idPrefix (SELF_ID_PREFIX, ENEMY_ID_PREFIX) des Feldes, das zurückgesendet werden soll (Name ist etwas irreführend)
		*/ 
		public static function generateCellDataArrayForSingleClick($i, $j, $color, $gameField) {
			$jsColor = self::convertColor($color);

			$cell = array('i' => $i,
					  'j' => $j,
					  'color' => $jsColor,
					  'gameField' => $gameField);
			$cellData = array(0 => $cell);
			return $cellData;
		}
		
		/**
		* Konvertiert die Konstante des Feldtyps in eine Farbe, die JavaScript akzeptiert.
		* @param $colorConstant Die Feldtypkonstante
		* $return Die Farbe, die JavaScript benutzt
		*/
		public static function convertColor($colorConstant) {
			//var_dump ($colorConstant);
			$color = "";
			switch($colorConstant) { ///TODO: farben nicht hardcoden
				case SHIP_ID:
					$color = "gray";
					break;
				case MISS_ID:
					$color = "darkblue";
					break;
				case HIT_ID:
					$color = "red";
					break;
				case DESTROYED_ID:
					$color = "black";
					break;
			}
			return $color;
		}
		
		/**
		* Überprüft, ob das Spiel gewonnen wurde
		* @param $gameField Das Spielfeld als Array
		* @return true, wenn das Spiel gewonnen wurde, false wenn nicht
		*/
		public static function checkWin($gameField) {
			for ($i = 0; $i < count($gameField); $i++) {
				for ($j = 0; $j < count($gameField); $j++) {
					if ($gameField[$i][$j] == SHIP_ID)
						return false;
				}
			}
			return true;
		}
		
		/**
		* Gibt die noch zu setztenden Schiffe zurück und hängt eine Warnung an, wenn gegen Regeln verstoßen wurde.
		* @param $drawnShips Die bereits gesetzten Schiffe
		* @param $requiredShips Die zu setzenden Schiffe
		* @param &$warning Die auszugebene Warnung
		* $return Die noch zu setzenden Schiffe und die Warnung
		*/
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
		
		/**
		* Gibt die noch zu setzenden Schiffe zurück
		* @param $drawnShips Die Schiffe, die bereits gesetzt wurden
		* @param $requiredShips Die zu setztenden Schiffe
		* @return Die noch zu setzenden Schiffe
		*/
		private static function getRemainingShips($drawnShips, $requiredShips) {
			$throwAwayWarning = "";
			return self::getRemainingShipsPlusWarning($drawnShips, $requiredShips, $throwAwayWarning);
		}
		
		/**
		* Gibt zurück, wie viele Schiffe welcher Art auf einem Feld gesetzt wurden.
		* @param $gameField Das zu überprüfende GameField als Array
		* @return Array, in dem steht wie viele Schiffe welcher Art gesetzt wurden.
		*/
		private static function checkAmountOfShips($gameField) {
			$result = array();
			if(!self::shipAlignmentIsValid($gameField)) {
				$result['illegal'] = true;
				return $result;
			}
			for ($i = 0; $i < 10; $i++) {
				for ($j = 0; $j < 10; $j++) {
					if ($gameField[$i][$j] === SHIP_ID) {
						$shipLength = self::checkShipLength($i, $j, $gameField);
						$result[$shipLength] = isset($result[$shipLength]) ? $result[$shipLength] + 1 : 1;
					}
				}
			}
			return $result;
		}
			
		/**
		* Überprüft, ob die Schiffsanordnung auf dem übergebenen GameField gültig ist.
		* @param $gameField Das GameField als Array
		* @return true, wenn die Schiffe gültig angeordnet sind, false wenn nicht
		*/
		private static function shipAlignmentIsValid($gameField) {
		 for ($i = 0; $i < (sizeof($gameField)); $i++) {
            for ($j = 0; $j < (max(array_map('count', $gameField))); $j++) {
                if ($gameField[$i][$j] == "SCHIFF") {
                    if ((isset($gameField[$i + 1][$j + 1]) && $gameField[$i + 1][$j + 1] == "SCHIFF") ||
                            (isset($gameField[$i - 1][$j + 1]) && $gameField[$i - 1][$j + 1] == "SCHIFF") ||
                            (isset($gameField[$i + 1][$j - 1]) && $gameField[$i + 1][$j - 1] == "SCHIFF") ||
                            (isset($gameField[$i - 1][$j - 1]) && $gameField[$i - 1][$j - 1] == "SCHIFF")) {
                        return false;
                    }
                }
            }
        }
        return true;
		}
		
		/**
		* Gibt die Länge des angegebenen Schiffteils zurück
		* @param $i X-Koordinate der zu überprüfenden Zelle
		* @param $j Y-Koordinate der zu überprüfenden Zelle
		* @param &$gameField das GameField als Array
		* @return Die berechnete Länge
		*/
		private static function checkShipLength($i, $j, &$gameField) {
			$length = 0;
			if ($gameField[$i][$j] == SHIP_ID) {
				$length++;
				$gameField[$i][$j] = WATER_ID;
				
				$iminus = ($i <= 0) ? 0: $i - 1;
				$iplus = ($i >= 9) ? 9 : $i + 1;
				$jminus = ($j <= 0) ? 0: $j - 1;
				$jplus = ($j >= 9) ? 9 : $j + 1;
				
				$length += self::checkShipLength($i, $jplus, $gameField);
				$length += self::checkShipLength($i, $jminus, $gameField);
				$length += self::checkShipLength($iplus, $j, $gameField);
				$length += self::checkShipLength($iminus, $j, $gameField);
			} 
			return $length;
		}

	}
?>