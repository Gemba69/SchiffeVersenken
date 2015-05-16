<?php

//Aufruf
$this->versenktueberpr($feld);


/*
 * Die Funktion versenktueberpr überprüft, ob irgendein Schiff auf einem 
 * bestimmten Spielfeld versenkt ist und ändert die Felder eines 
 * versenkten Schiffes auf VERSENKT.
 */

function versenktueberpr($feld) {
    for ($i = 0; $i < sizeof($feld); $i++) {
        for ($j = 0; $j < max(array_map('count', $feld)); $j++) {
            if ($feld[$i][$j] == "TREFFER") {
                if (versenkt($i, $j, $feld)) {
                    setzeVersenkt($feld, $i, $j);
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

function setzeVersenkt($feld, $x, $y) {
    versenke($feld, $x, $y);
    $adjazenzen=findeAdjazenteTreffer($feld, $x, $y);
    for ($i = 0; i < (count($adjazenzen)); $i++) {
        $this->setzeVersenkt($feld, $adjazenzen[$i][1], $adjazenzen[$i][2]);
        $this->versenke($feld, $adjazenzen[$i][1], $adjazenzen[$i][2]);
    }
}

/*
 * Die Funktion versenke setzt setzt ein feld x/y auf einem bestimmten 
 * Spielbrett auf VERSENKT.
 * (Versekt ein Feld des Schiffes)
 */

function versenke($feld, $x, $y) {
    if ($feld[$x][$y] == "TREFFER") {
        $feld[$x][$y] = "VERSENKT";
    } else {
        print("An der Stelle " . $x . "/" . $y . " gibt es keinen Treffer");
    }
}

/*
 * Die Funktion versenke setzt setzt ein feld x/y auf einem bestimmten 
 * Spielbrett auf VERSENKT.
 * (Versekt ein Feld des Schiffes)
 */

function versenkt($feld, $x, $y) {
    if (count(($adjazenzen = $this->findeAdjazenteTreffer($i, $j, $feld))) > 0) {
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
 * die auch Schiffe sind in einem Array zurück.
 */

function findeAdjazenteSchiffe($feld, $x, $y) {
    $adjazenzen = array();
    $i = 0;
    if (isset($feld[$x + 1][$y]) && $feld[$x + 1][$y] == "SCHIFF") {
        $adjazenzen[$i][1] = $x + 1;
        $adjazenzen[$i][2] = $y;
        $i++;
    }
    if (isset($feld[$x - 1][$y]) && $feld[$x - 1][$y] == "SCHIFF") {
        $adjazenzen[$i][1] = $x - 1;
        $adjazenzen[$i][2] = $y;
        $i++;
    }
    if (isset($feld[$x][$y + 1]) && $feld[$x][$y + 1] == "SCHIFF") {
        $adjazenzen[$i][1] = $x;
        $adjazenzen[$i][2] = $y + 1;
        $i++;
    }
    if (isset($feld[$x][$y - 1]) && $feld[$x][$y - 1] == "SCHIFF") {
        $adjazenzen[$i][1] = $x;
        $adjazenzen[$i][2] = $y - 1;
        $i++;
    }
    return $adjazenzen;
}

/*
 * Die Funktion findeAdjazenteTreffer gibt alle adjazenten Felder, 
 * die auch Treffer sind in einem Array zurück.
 */

function findeAdjazenteTreffer($feld, $x, $y) {
    $adjazenzen = array();
    $i = 0;
    if (isset($feld[$x + 1][$y]) && $feld[$x + 1][$y] == "TREFFER") {
        $adjazenzen[$i][1] = $x + 1;
        $adjazenzen[$i][2] = $y;
        $i++;
    }
    if (isset($feld[$x - 1][$y]) && $feld[$x - 1][$y] == "TREFFER") {
        $adjazenzen[$i][1] = $x - 1;
        $adjazenzen[$i][2] = $y;
        $i++;
    }
    if (isset($feld[$x][$y + 1]) && $feld[$x][$y + 1] == "TREFFER") {
        $adjazenzen[$i][1] = $x;
        $adjazenzen[$i][2] = $y + 1;
        $i++;
    }
    if (isset($feld[$x][$y - 1]) && $feld[$x][$y - 1] == "TREFFER") {
        $adjazenzen[$i][1] = $x;
        $adjazenzen[$i][2] = $y - 1;
        $i++;
    }
    return $adjazenzen;
}
?>