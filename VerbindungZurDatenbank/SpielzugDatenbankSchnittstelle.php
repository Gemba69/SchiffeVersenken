<?php

class SpielzugDatenbankSchnittstelle {

    private $spielbrett0 = array();
    private $spielbrett1 = array();
    private $feldhoehe;
    private $feldbreite;
    private $spielId;
    private $server = 'mysql:dbname=SchiffeVersenken;host=localhost';
    private $user = 'root';
    private $password = '';
    private $pdo;

    const CONST_WASSER = "WASSER";
    const CONST_MISS = "MISS";
    const CONST_SCHIFF = "SCHIFF";
    const CONST_TREFFER = "TREFFER";
    const CONST_VERSENKT = "VERSENKT";

    function __construct($parFeldhoehe, $parFeldbreite, $parSpielId) {

        $this->feldhoehe = $parFeldhoehe;
        $this->feldbreite = $parFeldbreite;
        $this->spielId = $parSpielId;
        $this->pdo = new PDO($this->server, $this->user, $this->password);

        for ($i = 0; $i < $this->feldhoehe; $i++) {
            for ($j = 0; $j < $this->feldbreite; $j++) {
                $this->spielbrett0[$i][$j] = "CONST_WASSER";
            }
        }

        for ($i = 0; $i < $this->feldhoehe; $i++) {
            for ($j = 0; $j < $this->feldbreite; $j++) {
                $this->spielbrett1[$i][$j] = "CONST_WASSER";
            }
        }
    }

    public function ladeSpielbrettAusDb() {
        $i = 0;
        $spielzugArray = array();

        $query = 'SELECT Spielbrett, x-Koordinate, y-Koordinate, Spielzugtyp '
                . 'FROM Spielzug WHERE SpielID = :spielID';
        $query->bindParam(':spielId', $this->spielId);

        foreach ($this->pdo->query($query) as $spielzugArray) {
            if ($spielzugArray[i] == 0) {
                $i++;
                $xk = $spielzugArray[i];
                $yk = $spielzugArray[i + 1];
                $i = $i + 2;
                if ($this->spielbrett0[$xk][$yk] == "CONST_WASSER" && $spielzugArray[$i] == "SETZEN") {
                    $this->spielbrett0[$xk][$yk] = "CONST_SCHIFF";
                } else if ($this->spielbrett0[$xk][$yk] == "CONST_WASSER" && $spielzugArray[$i] == "LOESCHEN") {
                    $this->spielbrett0[$xk][$yk] = "CONST_WASSER";
                } else if ($this->spielbrett0[$xk][$yk] == "CONST_WASSER" && $spielzugArray[$i] == "ANGRIFF") {
                    $this->spielbrett0[$xk][$yk] = "CONST_MISS";
                } else if ($this->spielbrett0[$xk][$yk] == "CONST_MISS" && $spielzugArray[$i] == "SETZEN") {
                    $this->spielbrett0[$xk][$yk] = "CONST_MISS";
                } else if ($this->spielbrett0[$xk][$yk] == "CONST_MISS" && $spielzugArray[$i] == "LOESCHEN") {
                    $this->spielbrett0[$xk][$yk] = "CONST_MISS";
                } else if ($this->spielbrett0[$xk][$yk] == "CONST_MISS" && $spielzugArray[$i] == "ANGRIFF") {
                    $this->spielbrett0[$xk][$yk] = "CONST_MISS";
                } else if ($this->spielbrett0[$xk][$yk] == "CONST_SCHIFF" && $spielzugArray[$i] == "SETZEN") {
                    $this->spielbrett0[$xk][$yk] = "CONST_SCHIFF";
                } else if ($this->spielbrett0[$xk][$yk] == "CONST_SCHIFF" && $spielzugArray[$i] == "LOESCHEN") {
                    $this->spielbrett0[$xk][$yk] = "CONST_WASSER";
                } else if ($this->spielbrett0[$xk][$yk] == "CONST_SCHIFF" && $spielzugArray[$i] == "ANGRIFF") {
                    $this->spielbrett0[$xk][$yk] = "CONST_TREFFER";
                } else if ($this->spielbrett0[$xk][$yk] == "CONST_TREFFER" && $spielzugArray[$i] == "SETZEN") {
                    $this->spielbrett0[$xk][$yk] = "CONST_TREFFER";
                } else if ($this->spielbrett0[$xk][$yk] == "CONST_TREFFER" && $spielzugArray[$i] == "LOESCHEN") {
                    $this->spielbrett0[$xk][$yk] = "CONST_TREFFER";
                } else if ($this->spielbrett0[$xk][$yk] == "CONST_TREFFER" && $spielzugArray[$i] == "ANGRIFF") {
                    $this->spielbrett0[$xk][$yk] = "CONST_TREFFER";
                } else if ($this->spielbrett0[$xk][$yk] == "CONST_VERSENKT" && $spielzugArray[$i] == "SETZEN") {
                    $this->spielbrett0[$xk][$yk] = "CONST_VERSENKT";
                } else if ($this->spielbrett0[$xk][$yk] == "CONST_VERSENKT" && $spielzugArray[$i] == "LOESCHEN") {
                    $this->spielbrett0[$xk][$yk] = "CONST_VERSENKT";
                } else if ($this->spielbrett0[$xk][$yk] == "CONST_VERSENKT" && $spielzugArray[$i] == "ANGRIFF") {
                    $this->spielbrett0[$xk][$yk] = "CONST_VERSENKT";
                }
                $i++;
            } else {
                $i++;
                $xk = $spielzugArray[i];
                $yk = $spielzugArray[i + 1];
                $i = $i + 2;
                if ($this->spielbrett1[$xk][$yk] == "CONST_WASSER" && $spielzugArray[$i] == "SETZEN") {
                    $this->spielbrett1[$xk][$yk] = "CONST_SCHIFF";
                } else if ($this->spielbrett1[$xk][$yk] == "CONST_WASSER" && $spielzugArray[$i] == "LOESCHEN") {
                    $this->spielbrett1[$xk][$yk] = "CONST_WASSER";
                } else if ($this->spielbrett1[$xk][$yk] == "CONST_WASSER" && $spielzugArray[$i] == "ANGRIFF") {
                    $this->spielbrett1[$xk][$yk] = "CONST_MISS";
                } else if ($this->spielbrett1[$xk][$yk] == "CONST_MISS" && $spielzugArray[$i] == "SETZEN") {
                    $this->spielbrett1[$xk][$yk] = "CONST_MISS";
                } else if ($this->spielbrett1[$xk][$yk] == "CONST_MISS" && $spielzugArray[$i] == "LOESCHEN") {
                    $this->spielbrett1[$xk][$yk] = "CONST_MISS";
                } else if ($this->spielbrett1[$xk][$yk] == "CONST_MISS" && $spielzugArray[$i] == "ANGRIFF") {
                    $this->spielbrett1[$xk][$yk] = "CONST_MISS";
                } else if ($this->spielbrett1[$xk][$yk] == "CONST_SCHIFF" && $spielzugArray[$i] == "SETZEN") {
                    $this->spielbrett1[$xk][$yk] = "CONST_SCHIFF";
                } else if ($this->spielbrett1[$xk][$yk] == "CONST_SCHIFF" && $spielzugArray[$i] == "LOESCHEN") {
                    $this->spielbrett1[$xk][$yk] = "CONST_WASSER";
                } else if ($this->spielbrett1[$xk][$yk] == "CONST_SCHIFF" && $spielzugArray[$i] == "ANGRIFF") {
                    $this->spielbrett1[$xk][$yk] = "CONST_TREFFER";
                } else if ($this->spielbrett1[$xk][$yk] == "CONST_TREFFER" && $spielzugArray[$i] == "SETZEN") {
                    $this->spielbrett1[$xk][$yk] = "CONST_TREFFER";
                } else if ($this->spielbrett1[$xk][$yk] == "CONST_TREFFER" && $spielzugArray[$i] == "LOESCHEN") {
                    $this->spielbrett1[$xk][$yk] = "CONST_TREFFER";
                } else if ($this->spielbrett1[$xk][$yk] == "CONST_TREFFER" && $spielzugArray[$i] == "ANGRIFF") {
                    $this->spielbrett1[$xk][$yk] = "CONST_TREFFER";
                } else if ($this->spielbrett1[$xk][$yk] == "CONST_VERSENKT" && $spielzugArray[$i] == "SETZEN") {
                    $this->spielbrett1[$xk][$yk] = "CONST_VERSENKT";
                } else if ($this->spielbrett1[$xk][$yk] == "CONST_VERSENKT" && $spielzugArray[$i] == "LOESCHEN") {
                    $this->spielbrett1[$xk][$yk] = "CONST_VERSENKT";
                } else if ($this->spielbrett1[$xk][$yk] == "CONST_VERSENKT" && $spielzugArray[$i] == "ANGRIFF") {
                    $this->spielbrett1[$xk][$yk] = "CONST_VERSENKT";
                }
                $i++;
            }
        }
        versenktueberpruefung(0);
        versenktueberpruefung(1);
    }

    public function versenktueberpruefung($spielbrettnr) {
        for ($i = 0; $i < $this->feldhoehe; $i++) {
            for ($j = 0; $j < $this->feldbreite; $j++) {
                if ($spielbrettnr == 0) {
                    if ($this->spielbrett0[$i][$j] == "CONST_TREFFER") {
                        if (versenkt($i, $j, $spielbrettnr)) {
                            setzeVersenkt($spielbrettnr, $i, $j);
                        }
                    }
                } else if ($spielbrettnr == 1) {
                    if ($this->spielbrett1[$i][$j] == "CONST_TREFFER") {
                        if (versenkt($i, $j, $spielbrettnr)) {
                            setzeVersenkt($spielbrettnr, $i, $j);
                        }
                    }
                }
            }
        }
    }

    public function setzeVersenkt($spielbrettnr, $x, $y) {
        versenke($spielbrettnr, $x, $y);
        for ($i = 0; i < (count(findeAdjazenteTreffer($spielbrettnr, $x, $y))); $i++) {
            setzeVersenkt($spielbrettnr, findeAdjazenteTreffer($spielbrettnr, $x, $y)[$i][1], findeAdjazenteTreffer($spielbrettnr, $x, $y)[$i][2]);
        }
    }

    public function versenke($spielbrettnr, $x, $y) {
        if ($spielbrettnr == 0) {
            if ($this->spielbrett0[$x][$y] == "CONST_TREFFER") {
                $this->spielbrett0[$x][$y] = "CONST_VERSENKT";
            } else {
                print("An der Stelle " . $x . "/" . $y . " gibt es keinen Treffer");
            }
        } else if ($spielbrettnr == 1) {
            if ($this->spielbrett1[$x][$y] == "CONST_TREFFER") {
                $this->spielbrett1[$x][$y] = "CONST_VERSENKT";
            } else {
                print("An der Stelle " . $x . "/" . $y . " gibt es keinen Treffer");
            }
        } else {
            print("Spielbrett: " . $spielbrettnr . " ist nicht vorhanden! (Spielbrett muss 0 oder 1 sein)");
        }
    }

    public function versenkt($spielbrettnr, $x, $y) {
        $versenkt = true;
        for ($i = 0; i < (count(findeAdjazenteTreffer($spielbrettnr, $x, $y))); $i++) {
            $versenkt = versenkt($spielbrettnr, findeAdjazenteTreffer($spielbrettnr, $x, $y)[$i][1], findeAdjazenteTreffer($spielbrettnr, $x, $y)[$i][2]);
        }
        if (count(findeAdjazenteSchiffe($spielbrettnr, $x, $y)) == 0) {
            return (true && $versenkt);
        } else {
            return false;
        }
    }

    public function findeAdjazenteSchiffe($spielbrettnr, $x, $y) {
        $adjazenzen = array();
        if ($spielbrettnr == 0) {
            $i = 0;
            if ($this->spielbrett0[$x + 1][$y] == "CONST_SCHIFF") {
                $adjazenzen[$i][1] = $x + 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if ($this->spielbrett0[$x - 1][$y] == "CONST_SCHIFF") {
                $adjazenzen[$i][1] = $x - 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if ($this->spielbrett0[$x][$y + 1] == "CONST_SCHIFF") {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y + 1;
                $i++;
            }
            if ($this->spielbrett0[$x][$y - 1] == "CONST_SCHIFF") {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y - 1;
                $i++;
            }
        } elseif ($spielbrettnr == 1) {
            $i = 0;
            if ($this->spielbrett1[$x + 1][$y] == "CONST_SCHIFF") {
                $adjazenzen[$i][1] = $x + 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if ($this->spielbrett1[$x - 1][$y] == "CONST_SCHIFF") {
                $adjazenzen[$i][1] = $x - 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if ($this->spielbrett1[$x][$y + 1] == "CONST_SCHIFF") {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y + 1;
                $i++;
            }
            if ($this->spielbrett1[$x][$y - 1] == "CONST_SCHIFF") {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y - 1;
                $i++;
            }
        } else {
            print("Spielbrett: " . $spielbrettnr . " ist nicht vorhanden! (Spielbrett muss 0 oder 1 sein)");
        }
        return $adjazenzen;
    }

    public function findeAdjazenteTreffer($spielbrettnr, $x, $y) {
        $adjazenzen = array();
        if ($spielbrettnr == 0) {
            $i = 0;
            if ($this->spielbrett0[$x + 1][$y] == "CONST_TREFFER") {
                $adjazenzen[$i][1] = $x + 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if ($this->spielbrett0[$x - 1][$y] == "CONST_TREFFER") {
                $adjazenzen[$i][1] = $x - 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if ($this->spielbrett0[$x][$y + 1] == "CONST_TREFFER") {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y + 1;
                $i++;
            }
            if ($this->spielbrett0[$x][$y - 1] == "CONST_TREFFER") {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y - 1;
                $i++;
            }
        } elseif ($spielbrettnr == 1) {
            $i = 0;
            if ($this->spielbrett1[$x + 1][$y] == "CONST_TREFFER") {
                $adjazenzen[$i][1] = $x + 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if ($this->spielbrett1[$x - 1][$y] == "CONST_TREFFER") {
                $adjazenzen[$i][1] = $x - 1;
                $adjazenzen[$i][2] = $y;
                $i++;
            }
            if ($this->spielbrett1[$x][$y + 1] == "CONST_TREFFER") {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y + 1;
                $i++;
            }
            if ($this->spielbrett1[$x][$y - 1] == "CONST_TREFFER") {
                $adjazenzen[$i][1] = $x;
                $adjazenzen[$i][2] = $y - 1;
                $i++;
            }
        } else {
            print("Spielbrett: " . $spielbrettnr . " ist nicht vorhanden! (Spielbrett muss 0 oder 1 sein)");
        }
        return $adjazenzen;
    }

    public function speicherSpielzugInDb($spielbrett, $x, $y, $spielzugTyp) {
        if ($spielbrett > -1 && $spielbrett < 2) {
            if ($x > 0 && $x < $this->feldbreite) {
                if ($y > 0 && $y < $this->feldhoehe) {
                    if ($spielzugTyp == "SETZEN" || $spielzugTyp == "LOESCHEN" || $spielzugTyp == "ANGRIFF") {
                        $stmt = $this->pdo->prepare("INSERT INTO Spielzug(SpielID, Spielbrett, x-Koordinate, y-Koordinate, Spielzugtyp)
                            VALUES(:spielId, :spielbrett, :x, :y, :spielzugTyp)");
                        $stmt->bindParam(':spielId', $this->spielId);
                        $stmt->bindParam(':spielbrett', $spielbrett);
                        $stmt->bindParam(':x', $x);
                        $stmt->bindParam(':y', $y);
                        $stmt->bindParam(':spielzugTyp', $spielzugTyp);
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
            print("Spielbrett: " . $spielbrett . " ist nicht vorhanden! (Spielbrett muss 0 oder 1 sein)");
        }
    }

}

?>