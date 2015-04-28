

<form action="test.php" methode="post">
    <input type="submit"></input>
</form>

<?php

function __autoload($class_name) {
    include $class_name . '.php';
}

$spielDb = new SpielDatenbankSchnittstelle(1,2);
$spielDb->neuesSpiel();
$spielIDs = $spielDb->ladeSpiele();
$spielzugDb = new SpielzugDatenbankSchnittstelle(10,10,$spielIDs[0]);
$spielzugDb->speicherSpielzugInDb(0,5,5,"ANGRIFF");
$spielzugDb->ladeSpielbrettAusDb();
?>