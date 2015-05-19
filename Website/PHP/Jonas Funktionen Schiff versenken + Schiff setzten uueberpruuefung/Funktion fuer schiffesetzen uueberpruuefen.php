<?php

/*
 * Die Funktion schiffePr�fung pr�ft, ob die gesetzten Schiffe 
 * plausibel/richtig sind.
 */

function schiffePruefung($feld) {
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

?>