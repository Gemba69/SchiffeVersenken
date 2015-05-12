<?php

/*
 * Die Klasse KI stellt eine künstliche Intelligenz zum Setzen der Schiffe und 
 * zum Angrif des gegnerischen Feldes 
 */

class KI {

    private $name;
    private $spielerID;
    private $getroffen = false;

//Konstruktor
    function __construct($name, $spielerID) {
        $this->name = $name;
        $this->spielerID = $spielerID;
    }

    /*
     * Gibt den Namen der KI
     */

    function getName() {
        return $this->name;
    }

    /*
     * Setzt den Namen der KI
     */

    function setName($name) {
        $this->name = $name;
    }

    /*
     * Gibt den Namen der KI
     */

    function getSpielerID() {
        return $this->spielerID;
    }

    /*
     * Setzt den Namen der KI
     */

    function setSpielerID($name) {
        $this->spielerID = $spielerID;
    }

    /*
     * Die Funktion schiffeSetzten setzt auf das leere Feld die vorhandenen 
     * Schiffe und gibt das mit Schiffen besetzte Feld zurück.
     */

    //function schiffeSetzten($feld, $schiffe) {
    function schiffeSetzten($schiffe) {
        $feld= $this->gameField->getAsArray();
        $outerzaehler = 0;
        do {
            $tempfeld = $feld;
            $outerwhile = false;
            for ($s = 0; $s < count(array_keys($schiffe)); $s++) {
                for ($si = 0; $si < $schiffe[array_keys($schiffe)[$s]]; $si++) {
                    $schiff = array_keys($schiffe)[$s];
                    $innerwhile = true;
                    $innerzaehler = 0;
                    while ($innerwhile) {
                        $x = rand(0, sizeof($tempfeld));
                        $y = rand(0, (sizeof($tempfeld, 1) / sizeof($tempfeld)));
                        $ausrichtung = rand(0, 1);
                        $temp = $this->schiffsetzen($x, $y, $ausrichtung, $tempfeld, $schiff);
                        if ($temp[1] == true) {
                            $tempfeld = $temp[0];
                            $innerwhile = false;
                        } else if ($innerzaehler > 1000) {
                            $innerwhile = false;
                            $outerwhile = true;
                        }
                        $innerzaehler++;
                    }
                    if ($outerwhile) {
                        break;
                    }
                }
            }
            $outerzaehler++;
        } while ($outerwhile && $outerzaehler < 1000);
        if ($outerzaehler > 998) {
            print("Schiffe können nicht gesetzt werden!! (zu viele)");
        } else {
            $feld = $tempfeld;
        }
        $this->gameField= $feld;
        return $feld();
    }

    /*
     * Die Funktion schiffeSetzten setzt auf das leere Feld die vorhandenen 
     * Schiffe und gibt das mit Schiffen besetzte Feld zurück, wenn die Schiffe 
     * passen.
     */

    private function schiffsetzen($x, $y, $ausrichtung, $feld, $schiff) {
//ausrichtung 0: waagerecht; ausrichung 1: senkrecht;
        $tempfeld = $feld;
        if ($ausrichtung == 0) {
            if (!isset($tempfeld[$x + $schiff][$y])) {
                $temp[0] = $feld;
                $temp[1] = false;
                return($temp);
            } else {
                for ($i = 0; $i < $schiff; $i++) {
                    $tempfeld[$x + $i][$y] = "SCHIFF";
                }
                if ($this->schiffePrüfung($tempfeld)) {
                    $temp[0] = $tempfeld;
                    $temp[1] = true;
                    return($temp);
                } else {
                    $temp[0] = $feld;
                    $temp[1] = false;
                    return($temp);
                }
            }
        } else if ($ausrichtung == 1) {
            if (!isset($tempfeld[$x][$y + $schiff])) {
                $temp[0] = $feld;
                $temp[1] = false;
                return($temp);
            } else {
                for ($i = 0; $i < $schiff; $i++) {
                    $tempfeld[$x][$y + $i] = "SCHIFF";
                }
                if ($this->schiffePrüfung($tempfeld)) {
                    $temp[0] = $tempfeld;
                    $temp[1] = true;
                    return($temp);
                } else {
                    $temp[0] = $feld;
                    $temp[1] = false;
                    return($temp);
                }
            }
        }
    }

    /*
     * Die Funktion schiffePrüfung prüft, ob die gesetzten Schiffe 
     * plausibel/richtig sind.
     */

    function schiffePrüfung($feld) {
        for ($i = 0; $i < (sizeof($feld)); $i++) {
            for ($j = 0; $j < (max(array_map('count', $feld))); $j++) {
                if ($feld[$i][$j] == "SCHIFF") {
                    if ((isset($feld[$i + 1][$j + 1]) && $feld[$i + 1][$j + 1] == "SCHIFF") ||
                            (isset($feld[$i - 1][$j + 1]) && $feld[$i - 1][$j + 1] == "SCHIFF") ||
                            (isset($feld[$i + 1][$j - 1]) && $feld[$i + 1][$j - 1] == "SCHIFF") ||
                            (isset($feld[$i - 1][$j - 1]) && $feld[$i - 1][$j - 1] == "SCHIFF")) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /*
     * Die Funktion angriff gibt eine Koordinate zurück, die als nächster 
     * Angriff sinnvoll ist.
     */

    public function angriff($feld, $schiffe) {
        $wasser = 0;
        $miss = 0;
        $treffer = 0;
        $versenkt = 0;
        $schiff = 0;
        for ($i = 0; $i < (sizeof($feld)); $i++) {
            for ($j = 0; $j < (max(array_map('count', $feld))); $j++) {
                if ($feld[$i][$j] == "WASSEER") {
                    $wasser++;
                } else if ($feld[$i][$j] == "MISS") {
                    $miss++;
                } else if ($feld[$i][$j] == "TREFFER") {
                    $treffer++;
                } else if ($feld[$i][$j] == "VERSENKT") {
                    $versenkt++;
                } else if ($feld[$i][$j] == "SCHIFF") {
                    $schiff++;
                    print("Fehler!! Ein Feld SCHIFF würde dem Gegner übergeben");
                }
            }
        }
        if ($treffer == 0 && $versenkt == 0) {
            do {
                $stelle[0] = rand(0, sizeof($feld) - 1); //x-koordinate
                $stelle[1] = rand(0, (max(array_map('count', $feld))) - 1); //y-koordinate
            } while (!($this->plausibel($feld, $stelle[0], $stelle[1])));
            return $stelle;
        } else if ($treffer > 0) {
            for ($i = 0; $i < (sizeof($feld)); $i++) {
                for ($j = 0; $j < (max(array_map('count', $feld))); $j++) {
                    if ($feld[$i][$j] == "TREFFER") {
                        if (sizeof(($adjazenzen = $this->findeAdjazenteTreffer($i, $j, $feld)), 1) / 2 > 1) {
                            if ($adjazenzen[0][1] < $i || $adjazenzen[0][1] > $i) {
                                $stelle[1] = $j; //y-koordinate
                                $x = 1;
                                while ($feld[$i + $x][$j] == "TREFFER") {
                                    $x++;
                                }
                                if ($feld[$i + $x][$j] == "WASSER") {
                                    $stelle[0] = $i + $x;
                                    return $stelle;
                                } else {
                                    $x = -1;
                                    while ($feld[$i + $x][$j] == "TREFFER") {
                                        $x--;
                                    }
                                    if ($feld[$i + $x][$j] == "WASSER") {
                                        $stelle[0] = $i + $x;
                                        return $stelle;
                                    } else {
                                        print("Fehler! Schiff ist schon versenkt!");
                                    }
                                }
                            } else {
                                $stelle[0] = $i; //x-koordinate
                                $y = 1;
                                while ($feld[$i][$j + $y] == "TREFFER") {
                                    $y++;
                                }
                                if ($feld[$i][$j + $y] == "WASSER") {
                                    $stelle[1] = $j + $y;
                                    return $stelle;
                                } else {
                                    $y = -1;
                                    while ($feld[$i][$j + $y] == "TREFFER") {
                                        $y--;
                                    }
                                    if ($feld[$i][$j + $y] == "WASSER") {
                                        $stelle[1] = $j + $y;
                                        return $stelle;
                                    } else {
                                        print("Fehler! Schiff ist schon versenkt!");
                                    }
                                }
                            }
                        } else if (sizeof(($adjazenzen = $this->findeAdjazenteTreffer($i, $j, $feld)), 1) / 2 > 0) {
                            if ($adjazenzen[0][1] < $i) {
                                $stelle[0] = $i + 1; //x-koordinate
                                $stelle[1] = $j; //y-koordinate
                                return $stelle;
                            } else if ($adjazenzen[0][1] > $i) {
                                $stelle[0] = $i - 1; //x-koordinate
                                $stelle[1] = $j; //y-koordinate
                                return $stelle;
                            } else if ($adjazenzen[0][2] < $j) {
                                $stelle[0] = $i; //x-koordinate
                                $stelle[1] = $j + 1; //y-koordinate
                                return $stelle;
                            } else if ($adjazenzen[0][2] > $j) {
                                $stelle[0] = $i; //x-koordinate
                                $stelle[1] = $j - 1; //y-koordinate
                                return $stelle;
                            }
                        } else {
                            $richtung = rand(0, 3);
                            if ($richtung == 0) {
                                $stelle[0] = $i + 1; //x-koordinate
                                $stelle[1] = $j; //y-koordinate
                                return $stelle;
                            }
                            if ($richtung == 1) {
                                $stelle[0] = $i - 1; //x-koordinate
                                $stelle[1] = $j; //y-koordinate
                                return $stelle;
                            }
                            if ($richtung == 2) {
                                $stelle[0] = $i; //x-koordinate
                                $stelle[1] = $j + 1; //y-koordinate
                                return $stelle;
                            }
                            if ($richtung == 3) {
                                $stelle[0] = $i; //x-koordinate
                                $stelle[1] = $j - 1; //y-koordinate
                                return $stelle;
                            }
                        }
                    }
                }
            }
        } else {
            $felderanzahl = 0;
            $felder = array();
            for ($i = 0; $i < (sizeof($feld)); $i++) {
                for ($j = 0; $j < (max(array_map('count', $feld))); $j++) {
                    if ($feld[$i][$j] == "WASSER" && count($this->findeAdjazenteTreffer($i, $j, $feld)) == 0) {
                        $felder[$felderanzahl][0] = $i;
                        $felder[$felderanzahl][1] = $j;
                        $felderanzahl++;
                    }
                }
            }
            $feldnummer = rand(0, sizeof($felder) - 1);
            $stelle[0] = $felder[$feldnummer][0]; //x-koordinate
            $stelle[1] = $felder[$feldnummer][1]; //y-koordinate
            return $stelle;
        }
    }

    /*
     * Die Funktion plausibel gibt zurück, ob die angegebene stelle noch nicht 
     * belegt ist mit "MISS", "VERSENKT" oder "TREFFER"
     */

    private function plausibel($feld, $x, $y) {
        if ($feld[$x][$y] == "WASSER") {
            return true;
        }
        return false;
    }

    /*
     * Die Funktion fireShot gibt zurück, ob der letzte angriff ein Teffer war
     * oder nicht und führt den angriff aus.
     */

    public function fireShot(&$gameField, $requiredShips) {
        $koordinaten = angriff(gameField, $requiredShips);
        return $gameField->attack(koordinaten[0], koordinaten[1]);
    }

    /*
     * Die Funktion findeAdjazenteTreffer gibt alle adjazenten Felder, 
     * die auch Treffer sind in einem Array zurück.
     */

    private function findeAdjazenteTreffer($x, $y, $feld) {
        $adjazenzen = array();
        $i = 0;
        if ($feld[$x + 1][$y] == "TREFFER") {
            $adjazenzen[$i][1] = $x + 1;
            $adjazenzen[$i][2] = $y;
            $i++;
        }
        if ($feld[$x - 1][$y] == "TREFFER") {
            $adjazenzen[$i][1] = $x - 1;
            $adjazenzen[$i][2] = $y;
            $i++;
        }
        if ($feld[$x][$y + 1] == "TREFFER") {
            $adjazenzen[$i][1] = $x;
            $adjazenzen[$i][2] = $y + 1;
            $i++;
        }
        if ($feld[$x][$y - 1] == "TREFFER") {
            $adjazenzen[$i][1] = $x;
            $adjazenzen[$i][2] = $y - 1;
            $i++;
        }
        return $adjazenzen;
    }

    /*
     * Die Funktion array_2d_to_1d gibt bei Mitgabe eines zweidimensionalen
     * Arrays ein eindimensionales Array zurück, in dem die Zeilen/Datensätze 
     * aus dem zweidimensionalen Array hintereiandergehängt wurden.
     */

    private function array_2d_to_1d($input_array) {
        $output_array = array();
        for ($i = 0; $i < count($input_array); $i++) {
            for ($j = 0; $j < count($input_array[$i]); $j++) {
                $output_array[] = $input_array[$i][$j];
            }
        }
        return $output_array;
    }

}

?>