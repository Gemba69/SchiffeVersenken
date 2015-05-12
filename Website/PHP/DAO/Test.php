
/*
 * Eine Seite zum Testen der Funktionen.
 */
 
<form action="test.php" methode="post">
    <input type="submit"></input>
</form>

<?php

function __autoload($class_name) {
    include $class_name . '.php';
}


$feld=array();
$feld[0][0]="WASSER";
$feld[0][1]="WASSER";
$feld[0][2]="WASSER";
$feld[1][0]="WASSER";
$feld[1][1]="WASSER";
$feld[1][2]="WASSER";
$feld[2][0]="WASSER";
$feld[2][1]="WASSER";
$feld[2][2]="WASSER";

$schiffe =  array('10' => 0, '9' => 0, '8' => 0, '7' => 0, '6' => 0, '5' => 1, '4' => 2, '3' => 3, '2' => 4, '1' => 0); //todo: aus der datenbank auslesen

$ki = new KI("Dieter",1);
$ki->schiffeSetzten($feld,$schiffe);
$ki->angriff($feld,$schiffe);
$spielDb = new SpielDatenbankSchnittstelle(1,2);
$spielDb->neuesSpiel();
$spielIDs = $spielDb->ladeSpiele();
$spielzugDb = new SpielzugDatenbankSchnittstelle(10,10,$spielIDs[0]);
$spielzugDb->speicherSpielzugInDb(0,5,5,"ANGRIFF");
$spielzugDb->ladeSpielbrettAusDb();
?>