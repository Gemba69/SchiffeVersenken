
/*
* Eine Seite zum Testen der Funktionen.
*/

<form action="test.php" methode="post">
    <input type="submit"></input>
</form>
<span style="font-family:Courier; font-size:20px">
    <?php

    function __autoload($class_name) {
        include $class_name . '.php';
    }

    $feld = array();

    for ($i = 0; $i < 10; $i++) {
        for ($j = 0; $j < 10; $j++) {
            $feld[$i][$j] = "WASSER";
        }
    }
    
    $feld[2][2] = "VERSENKT";
    $feld[2][3] = "VERSENKT";
    $feld[2][4] = "VERSENKT";
    $feld[2][5] = "VERSENKT";
    

    $schiffe = array('10' => 0, '9' => 0, '8' => 0, '7' => 0, '6' => 0, '5' => 1, '4' => 2, '3' => 3, '2' => 4, '1' => 0); //todo: aus der datenbank auslesen

    $ki = new KI("Dieter", 1);
    $ki->schiffePrüfung($feld);
    echo "Schiffe setzen: <br><br>";
    //$feld = $ki->schiffeSetzten($feld, $schiffe);
    ausgabe($feld);
    for ($i = 0; $i < 100; $i++) {
        $punkt = $ki->angriff($feld, $schiffe);
        if ($feld[$punkt[0]][$punkt[1]] == "WASSER") {
            print("W getroffen <br>");
            $feld[$punkt[0]][$punkt[1]] = "MISS";
        } elseif ($feld[$punkt[0]][$punkt[1]] == "SCHIFF") {
            print("S getroffen <br>");
            $feld[$punkt[0]][$punkt[1]] = "TREFFER";
        } elseif ($feld[$punkt[0]][$punkt[1]] == "TREFFER") {
            print("T getroffen <br>");
            $feld[$punkt[0]][$punkt[1]] = "TREFFER";
        } elseif ($feld[$punkt[0]][$punkt[1]] == "VERSENKT") {
            print("V getroffen <br>");
            $feld[$punkt[0]][$punkt[1]] = "VERSENKT";
        } elseif ($feld[$punkt[0]][$punkt[1]] == "MISS") {
            print("M getroffen <br>");
            $feld[$punkt[0]][$punkt[1]] = "MISS";
        }
        ausgabe($feld);
    }

    function ausgabe($feld) {
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 10; $j++) {
                if ($feld[$i][$j] == "WASSER") {
                    print("W ");
                } elseif ($feld[$i][$j] == "SCHIFF") {
                    print("S ");
                } elseif ($feld[$i][$j] == "TREFFER") {
                    print("T ");
                } elseif ($feld[$i][$j] == "VERSENKT") {
                    print("V ");
                } elseif ($feld[$i][$j] == "MISS") {
                    print("M ");
                }
            }
            echo "<br>";
        }
    }
    ?>
</span>