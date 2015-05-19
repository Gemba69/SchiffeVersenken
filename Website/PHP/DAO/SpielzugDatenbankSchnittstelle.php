<?php

require_once('SpielzugtypDatenbankSchnittstelle.php');		

/*
 * Die Klasse SpielzugDatenbankSchnittstelle stellt eine Verbindung zur 
 * Datenbank her und regelt den Zugriff auf die Tabelle Spielzug indem sie
 * Spielz?e in der Datenbank speichern kann und das geladene Spielbrett in 
 * Arrays zu verf?gung stellt.
 */

class SpielzugDatenbankSchnittstelle {

    private $spielbrett0 = array();
    private $spielbrett1 = array();
    private $feldhoehe;
    private $feldbreite;
    private $spielId;
    private $spielzugtypDb;
    
    //Variablen f?r die Datenbankverbindung
    private $pdo;

    const CONST_WASSER = "WASSER";
    const CONST_MISS = "MISS";
    const CONST_SCHIFF = "SCHIFF";
    const CONST_TREFFER = "TREFFER";
    const CONST_VERSENKT = "VERSENKT";

    //Konstruktor
    function __construct($parFeldhoehe, $parFeldbreite, $parSpielId) {

        $this->feldhoehe = $parFeldhoehe;
        $this->feldbreite = $parFeldbreite;
        $this->spielId = $parSpielId;
        include "Verbindung.php";
        $this->pdo = $dbh;

        $this->spielzugtypDb = new SpielzugtypDatenbankSchnittstelle();
    }

    /*
     * Die Funktion getSpielbrett0 gibt das erste Spielbrett zur?ck. 
     */
    public function getSpielbrett0() {
        return $this->spielbrett0;
    }

    /*
     * Die Funktion getSpielbrett1 gibt das zweite Spielbrett zur?ck. 
     */
    public function getSpielbrett1() {
        return $this->spielbrett1;
    }

    /*
     * Die Funktion ladeSpielbrettAusDb erstellt die beiden 
     * Spielbretter aus der Spielzug-Tabelle. 
     */
    public function ladeSpielbrettAusDb() {
		 for ($i = 0; $i < $this->feldhoehe; $i++) {
            for ($j = 0; $j < $this->feldbreite; $j++) {
                $this->spielbrett0[$i][$j] = self::CONST_WASSER;
            }
        }

        for ($i = 0; $i < $this->feldhoehe; $i++) {
            for ($j = 0; $j < $this->feldbreite; $j++) {
                $this->spielbrett1[$i][$j] = self::CONST_WASSER;
            }
        }
        $i = 0;
        $query = $this->pdo->prepare("SELECT Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp FROM Spielzug WHERE SpielID = :spielId");
        $query->bindParam(':spielId', $this->spielId);
        $query->execute();
        $spielzugArray0 = $query->fetchAll(PDO::FETCH_NUM);
        $spielzugArray = $this->array_2d_to_1d($spielzugArray0);
        //print_r($spielzugArray);
        //print("SpielzugArraycount: " . count($spielzugArray) . " Spielid: " . $this->spielId);
        for ($j = 0; $j < (count($spielzugArray) / 4); $j++) {
            if ($spielzugArray[$i] == 0) {
                $i++;
                $xk = $spielzugArray[$i];
                $yk = $spielzugArray[$i + 1];
                $i = $i + 2;
                ////print($this->spielzugtypDb->ladeSpielzugtypId("SETZEN") . " ; ");
                if ($this->spielbrett0[$xk][$yk] == self::CONST_WASSER && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("SETZEN")) {
                    $this->spielbrett0[$xk][$yk] = self::CONST_SCHIFF;
                } else if ($this->spielbrett0[$xk][$yk] == self::CONST_WASSER && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("LOESCHEN")) {
                    $this->spielbrett0[$xk][$yk] = self::CONST_WASSER;
                } else if ($this->spielbrett0[$xk][$yk] == self::CONST_WASSER && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("ANGRIFF")) {
                    $this->spielbrett0[$xk][$yk] = self::CONST_MISS;
                } else if ($this->spielbrett0[$xk][$yk] == self::CONST_MISS && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("SETZEN")) {
                    $this->spielbrett0[$xk][$yk] = self::CONST_MISS;
                } else if ($this->spielbrett0[$xk][$yk] == self::CONST_MISS && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("LOESCHEN")) {
                    $this->spielbrett0[$xk][$yk] = self::CONST_MISS;
                } else if ($this->spielbrett0[$xk][$yk] == self::CONST_MISS && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("ANGRIFF")) {
                    $this->spielbrett0[$xk][$yk] = self::CONST_MISS;
                } else if ($this->spielbrett0[$xk][$yk] == self::CONST_SCHIFF && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("SETZEN")) {
                    $this->spielbrett0[$xk][$yk] = self::CONST_SCHIFF;
                } else if ($this->spielbrett0[$xk][$yk] == self::CONST_SCHIFF && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("LOESCHEN")) {
                    $this->spielbrett0[$xk][$yk] = self::CONST_WASSER;
                } else if ($this->spielbrett0[$xk][$yk] == self::CONST_SCHIFF && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("ANGRIFF")) {
                    $this->spielbrett0[$xk][$yk] = self::CONST_TREFFER;
                } else if ($this->spielbrett0[$xk][$yk] == self::CONST_TREFFER && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("SETZEN")) {
                    $this->spielbrett0[$xk][$yk] = self::CONST_TREFFER;
                } else if ($this->spielbrett0[$xk][$yk] == self::CONST_TREFFER && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("LOESCHEN")) {
                    $this->spielbrett0[$xk][$yk] = self::CONST_TREFFER;
                } else if ($this->spielbrett0[$xk][$yk] == self::CONST_TREFFER && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("ANGRIFF")) {
                    $this->spielbrett0[$xk][$yk] = self::CONST_TREFFER;
                } else if ($this->spielbrett0[$xk][$yk] == self::CONST_VERSENKT && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("SETZEN")) {
                    $this->spielbrett0[$xk][$yk] = self::CONST_VERSENKT;
                } else if ($this->spielbrett0[$xk][$yk] == self::CONST_VERSENKT && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("LOESCHEN")) {
                    $this->spielbrett0[$xk][$yk] = self::CONST_VERSENKT;
                } else if ($this->spielbrett0[$xk][$yk] == self::CONST_VERSENKT && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("ANGRIFF")) {
                    $this->spielbrett0[$xk][$yk] = self::CONST_VERSENKT;
                }
                $i++;
            } else {
                $i++;
                $xk = $spielzugArray[$i];
                $yk = $spielzugArray[$i + 1];
                $i = $i + 2;
                if ($this->spielbrett1[$xk][$yk] == self::CONST_WASSER && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("SETZEN")) {
                    $this->spielbrett1[$xk][$yk] = self::CONST_SCHIFF;
                } else if ($this->spielbrett1[$xk][$yk] == self::CONST_WASSER && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("LOESCHEN")) {
                    $this->spielbrett1[$xk][$yk] = self::CONST_WASSER;
                } else if ($this->spielbrett1[$xk][$yk] == self::CONST_WASSER && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("ANGRIFF")) {
                    $this->spielbrett1[$xk][$yk] = self::CONST_MISS;
                } else if ($this->spielbrett1[$xk][$yk] == self::CONST_MISS && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("SETZEN")) {
                    $this->spielbrett1[$xk][$yk] = self::CONST_MISS;
                } else if ($this->spielbrett1[$xk][$yk] == self::CONST_MISS && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("LOESCHEN")) {
                    $this->spielbrett1[$xk][$yk] = self::CONST_MISS;
                } else if ($this->spielbrett1[$xk][$yk] == self::CONST_MISS && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("ANGRIFF")) {
                    $this->spielbrett1[$xk][$yk] = self::CONST_MISS;
                } else if ($this->spielbrett1[$xk][$yk] == self::CONST_SCHIFF && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("SETZEN")) {
                    $this->spielbrett1[$xk][$yk] = self::CONST_SCHIFF;
                } else if ($this->spielbrett1[$xk][$yk] == self::CONST_SCHIFF && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("LOESCHEN")) {
                    $this->spielbrett1[$xk][$yk] = self::CONST_WASSER;
                } else if ($this->spielbrett1[$xk][$yk] == self::CONST_SCHIFF && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("ANGRIFF")) {
                    $this->spielbrett1[$xk][$yk] = self::CONST_TREFFER;
                } else if ($this->spielbrett1[$xk][$yk] == self::CONST_TREFFER && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("SETZEN")) {
                    $this->spielbrett1[$xk][$yk] = self::CONST_TREFFER;
                } else if ($this->spielbrett1[$xk][$yk] == self::CONST_TREFFER && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("LOESCHEN")) {
                    $this->spielbrett1[$xk][$yk] = self::CONST_TREFFER;
                } else if ($this->spielbrett1[$xk][$yk] == self::CONST_TREFFER && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("ANGRIFF")) {
                    $this->spielbrett1[$xk][$yk] = self::CONST_TREFFER;
                } else if ($this->spielbrett1[$xk][$yk] == self::CONST_VERSENKT && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("SETZEN")) {
                    $this->spielbrett1[$xk][$yk] = self::CONST_VERSENKT;
                } else if ($this->spielbrett1[$xk][$yk] == self::CONST_VERSENKT && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("LOESCHEN")) {
                    $this->spielbrett1[$xk][$yk] = self::CONST_VERSENKT;
                } else if ($this->spielbrett1[$xk][$yk] == self::CONST_VERSENKT && $spielzugArray[$i] == $this->spielzugtypDb->ladeSpielzugtypId("ANGRIFF")) {
                    $this->spielbrett1[$xk][$yk] = self::CONST_VERSENKT;
                }
                $i++;
            }
        }
       // $this->versenktueberpr(0);
       // $this->versenktueberpr(1);
    }

    /*
     * Die Funktion versenktueberpr ?berpr?ft, ob irgendein Schiff auf einem 
     * bestimmten Spielfeld versenkt ist und ?ndert die Felder eines 
     * versenkten Schiffes auf VERSENKT.
     */
    function versenktueberpr($spielbrettnr) {
        for ($i = 0; $i < $this->feldhoehe; $i++) {
            for ($j = 0; $j < $this->feldbreite; $j++) {
                if ($spielbrettnr == 0) {
                    if ($this->spielbrett0[$i][$j] == self::CONST_TREFFER) {
                        if ($this->versenkt($spielbrettnr, $i, $j)) {
                            $this->setzeVersenkt($spielbrettnr, $i, $j);
                        }
                    }
                } else if ($spielbrettnr == 1) {
                    if ($this->spielbrett1[$i][$j] == self::CONST_TREFFER) {
                        if ($this->versenkt($spielbrettnr, $i, $j)) {
                            $this->setzeVersenkt($spielbrettnr, $i, $j);
                        }
                    }
                }
            }
        }
    }

    /*
     * Die Funktion setzeVersenkt setzt setzt ein feld x/y und alle anderen des 
     * Schiffes auf einem bestimmten Spielbrett auf VERSENKT.
     * (Versekt ein Schiff)
     */
    public function setzeVersenkt($spielbrettnr, $x, $y) {
        $this->versenke($spielbrettnr, $x, $y);
        $adjazenzen = $this->findeAdjazenteTreffer($spielbrettnr, $x, $y);
        for ($i = 0; i < (count($adjazenzen)); $i++) {
            $this->setzeVersenkt($spielbrettnr, $adjazenzen[$i][1], $adjazenzen[$i][2]);
            $this->versenke($feld, $adjazenzen[$i][1], $adjazenzen[$i][2]);    
        }
    }

    /*
     * Die Funktion versenke setzt setzt ein feld x/y auf einem bestimmten 
     * Spielbrett auf VERSENKT.
     * (Versekt ein Feld des Schiffes)
     */
    public function versenke($spielbrettnr, $x, $y) {
        if ($spielbrettnr == 0) {
            if ($this->spielbrett0[$x][$y] == self::CONST_TREFFER) {
                $this->spielbrett0[$x][$y] = self::CONST_VERSENKT;
            } else {
                print("An der Stelle " . $x . "/" . $y . " gibt es keinen Treffer");
            }
        } else if ($spielbrettnr == 1) {
            if ($this->spielbrett1[$x][$y] == self::CONST_TREFFER) {
                $this->spielbrett1[$x][$y] = self::CONST_VERSENKT;
            } else {
                print("An der Stelle " . $x . "/" . $y . " gibt es keinen Treffer");
            }
        } else {
            print("Spielbrett: " . $spielbrettnr . " ist nicht vorhanden! (Spielbrett muss 0 oder 1 sein) versenke");
        }
    }

    /*
     * Die Funktion versenke setzt setzt ein feld x/y auf einem bestimmten 
     * Spielbrett auf VERSENKT.
     * (Versekt ein Feld des Schiffes)
     */
    public function versenkt($spielbrettnr, $i, $j) {
        if($spielbrettnr==0){
            $feld=$this->spielbrett0;
        } else if ($spielbrettnr == 1) {
            $feld=$this->spielbrett1;
        } else {
            print("Spielbrett: " . $spielbrettnr . " ist nicht vorhanden! (Spielbrett muss 0 oder 1 sein) versenkt");
        }
        if (count(($adjazenzen = $this->findeAdjazenteTreffer($spielbrettnr, $i, $j))) > 0) {
        if ($adjazenzen[0][1] < $i || $adjazenzen[0][1] > $i) {
            $x = 1;
            while (isset($feld[$i + $x][$j]) && $feld[$i + $x][$j] == "TREFFER") {
                $x++;
            }
            if (isset($feld[$i + $x][$j]) && ($feld[$i + $x][$j] == "SCHIFF")) {
                return false;
            } else {
                $x = -1;
                while (isset($feld[$i + $x][$j]) && $feld[$i + $x][$j] == "TREFFER") {
                    $x--;
                }
                if (isset($feld[$i + $x][$j]) && ($feld[$i + $x][$j] == "SCHIFF")) {
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            $y = 1;
            while (isset($feld[$i][$j + $y]) && $feld[$i][$j + $y] == "TREFFER") {
                $y++;
            }
            if (isset($feld[$i][$j + $y]) && ($feld[$i][$j + $y] == "SCHIFF")) {
                return false;
            } else {
                $y = -1;
                while (isset($feld[$i][$j + $y]) && $feld[$i][$j + $y] == "TREFFER") {
                    $y--;
                }
                if (isset($feld[$i][$j + $y]) && ($feld[$i][$j + $y] == "SCHIFF")) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }
    }
    
    /*
     * Die Funktion findeAdjazenteSchiffe gibt alle adjazenten Felder, 
     * die auch Schiffe sind in einem Array zur?ck.
     */
    public function findeAdjazenteSchiffe($spielbrettnr, $x, $y) {
        $adjazenzen = array();
        if ($spielbrettnr == 0) {
            $i = 0;
            if (isset($this->spielbrett0[$x + 1][$y])&&$this->spielbrett0[$x + 1][$y] == self::CONST_SCHIFF) {
                $adjazenzen[$i][1] = $x + 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if (isset($this->spielbrett0[$x - 1][$y])&&$this->spielbrett0[$x - 1][$y] == self::CONST_SCHIFF) {
                $adjazenzen[$i][1] = $x - 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if (isset($this->spielbrett0[$x][$y+1])&&$this->spielbrett0[$x][$y + 1] == self::CONST_SCHIFF) {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y + 1;
                $i++;
            }
            if (isset($this->spielbrett0[$x][$y-1])&&$this->spielbrett0[$x][$y - 1] == self::CONST_SCHIFF) {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y - 1;
                $i++;
            }
        } elseif ($spielbrettnr == 1) {
            $i = 0;
            if (isset($this->spielbrett1[$x + 1][$y])&&$this->spielbrett1[$x + 1][$y] == self::CONST_SCHIFF) {
                $adjazenzen[$i][1] = $x + 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if (isset($this->spielbrett1[$x - 1][$y])&&$this->spielbrett1[$x - 1][$y] == self::CONST_SCHIFF) {
                $adjazenzen[$i][1] = $x - 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if (isset($this->spielbrett1[$x][$y+1])&&$this->spielbrett1[$x][$y + 1] == self::CONST_SCHIFF) {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y + 1;
                $i++;
            }
            if (isset($this->spielbrett1[$x][$y-1])&&$this->spielbrett1[$x][$y - 1] == self::CONST_SCHIFF) {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y - 1;
                $i++;
            }
        } else {
            print("Spielbrett: " . $spielbrettnr . " ist nicht vorhanden! (Spielbrett muss 0 oder 1 sein) findeAdjazenteSchiffe");
        }
        return $adjazenzen;
    }

    /*
     * Die Funktion findeAdjazenteTreffer gibt alle adjazenten Felder, 
     * die auch Treffer sind in einem Array zur?ck.
     */
    public function findeAdjazenteTreffer($spielbrettnr, $x, $y) {
        $adjazenzen = array();
        if ($spielbrettnr == 0) {
            $i = 0;
            if (isset($this->spielbrett0[$x + 1][$y])&&$this->spielbrett0[$x + 1][$y] == self::CONST_TREFFER) {
                $adjazenzen[$i][1] = $x + 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if (isset($this->spielbrett0[$x - 1][$y])&&$this->spielbrett0[$x - 1][$y] == self::CONST_TREFFER) {
                $adjazenzen[$i][1] = $x - 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if (isset($this->spielbrett0[$x][$y+1])&&$this->spielbrett0[$x][$y + 1] == self::CONST_TREFFER) {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y + 1;
                $i++;
            }
            if (isset($this->spielbrett0[$x][$y-1])&&$this->spielbrett0[$x][$y - 1] == self::CONST_TREFFER) {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y - 1;
                $i++;
            }
        } elseif ($spielbrettnr == 1) {
            $i = 0;
            if (isset($this->spielbrett1[$x + 1][$y])&&$this->spielbrett1[$x + 1][$y] == self::CONST_TREFFER) {
                $adjazenzen[$i][1] = $x + 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if (isset($this->spielbrett1[$x - 1][$y])&&$this->spielbrett1[$x - 1][$y] == self::CONST_TREFFER) {
                $adjazenzen[$i][1] = $x - 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if (isset($this->spielbrett1[$x][$y+1])&&$this->spielbrett1[$x][$y + 1] == self::CONST_TREFFER) {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y + 1;
                $i++;
            }
            if (isset($this->spielbrett1[$x][$y-1])&&$this->spielbrett1[$x][$y - 1] == self::CONST_TREFFER) {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y - 1;
                $i++;
            }
        } else {
            print("Spielbrett: " . $spielbrettnr . " ist nicht vorhanden! (Spielbrett muss 0 oder 1 sein) findeAdjazenteTreffer");
        }
        return $adjazenzen;
    }

    /*
     * Die Funktion speicherSpielzugInDb speichert den ?bergebenen 
     * Spielzug in der Datenbank
     */
    public function speicherSpielzugInDb($spielbrett, $x, $y, $spielzugTyp) {
        if ($spielbrett > -1 && $spielbrett < 2) {
            if ($x > -1 && $x < $this->feldbreite) {
                if ($y > -1 && $y < $this->feldhoehe) {
                    if ($spielzugTyp == "SETZEN" || $spielzugTyp == "LOESCHEN" || $spielzugTyp == "ANGRIFF") {
                        $stmt = $this->pdo->prepare("INSERT INTO Spielzug(SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp)
                            VALUES(:spielId, :spielbrett, :x, :y, :spielzugTyp)");
                        $stmt->bindParam(':spielId', $this->spielId);
                        $stmt->bindParam(':spielbrett', $spielbrett);
                        $stmt->bindParam(':x', $x);
                        $stmt->bindParam(':y', $y);
                        $stmt->bindParam(':spielzugTyp', $this->spielzugtypDb->ladeSpielzugtypId($spielzugTyp));
                        $stmt->execute();
                    } else {
                        print("SpielzugTyp: " . $spielzugTyp . " ist nicht vorhanden! (moeglich ist: SETZEN,LOESCHEN,ANGRIFF)");
                    }
                } else {
                    print("y: " . $y . " ist nicht vorhanden! ( 0-" . $this->feldhoehe . ")");
                }
            } else {
                print("x: " . $x . " ist nicht vorhanden! ( 0-" . $this->feldbreite . ")");
            }
        } else {
            print("Spielbrett: " . $spielbrett . " ist nicht vorhanden! (Spielbrett muss 0 oder 1 sein) speicherSpielzugInDb");
        }
    }

    //Automatisches Laden der includes
    function __autoload($class_name) {
        include $class_name . '.php';
    }

    /*
     * Die Funktion array_2d_to_1d gibt bei Mitgabe eines zweidimensionalen
     * Arrays ein eindimensionales Array zur?ck, in dem die Zeilen/Datens?tze 
     * aus dem zweidimensionalen Array hintereiandergeh?ngt wurden.
     */
    function array_2d_to_1d($input_array) {
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