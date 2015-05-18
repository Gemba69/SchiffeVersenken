
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
print("1");
print("<br>");
$spielDb = new SpielDatenbankSchnittstelle(1,2);
print("2");
print("<br>");
$spielDb->neuesSpiel();
print("3");
print("<br>");
$spielIDs = $spielDb->ladeSpiele();
print("4");
print("<br>");
print($spielIDs);
$spielzugDb = new SpielzugDatenbankSchnittstelle(10,10,$spielIDs[0]);
$spielzugDb->speicherSpielzugInDb(0,5,5,"ANGRIFF");
ausgabe($spielzugDb->ladeSpielbrettAusDb());
$spielst = new SpielStatusDatenbankSchnittstelle();
$spielst->ladeSpielStatusId("PHASE1");

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