<?php

/*
 * Die Klasse SpielDatenbankSchnittstelle stellt eine Verbindung zur 
 * Datenbank her und regelt den Zugriff auf die Tabelle Spiel.
 */
class SpielDatenbankSchnittstelle {

    private $spieler0;
    private $spieler1;
    
    //Variablen f?r die Datenbankverbindung
    private $pdo;

    //Konstruktor
    function __construct($parSpieler0, $parSpieler1) {
        $this->spieler0 = $parSpieler0;
        $this->spieler1 = $parSpieler1;
        include "Verbindung.php";
        $this->pdo = $dbh;
    }

    /*
     * Die Funktion ladeSpiele gibt alle SpielIDs in einem Array zur?ck, 
     * die zu den beiden SpilerIds passen, die dem Konstruktor ?bergeben wurden.
     */
    function ladeSpiele() {
        $spieleIds = array();
        $query = $this->pdo->prepare("SELECT ID FROM Spiel WHERE Spieler_1 = :spieler1 AND Spieler_2 = :spieler2");
        $query->bindParam(':spieler1', $this->spieler0);
        $query->bindParam(':spieler2', $this->spieler1);
        $query->execute();
        $spieleIds = $query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($spieleIds);
    }

    /*
     * Die Funktion getSpielStatusId gibt bei Mitgabe der SpielID die StatusID 
     * des Spiels zur?ck.
     */
    function getSpielStatusId($spielId) {
        $spielStatusId = array();
        $query = $this->pdo->prepare("SELECT StatusID FROM Spiel WHERE ID = :id");
        $query->bindParam(':id', $spielId);
        $query->execute();
        $spielStatusId = $query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($spielStatusId)[0];
    }

    /*
     * Die Funktion setSpielStatusId ordnet durch Mitgabe der SpielID und einer 
     * SpielStatusID die SpielStatusID dem Spiel zu. 
     * Dadurch wird der alte SpielStatus ?berschrieben. 
     * Au?erdem gibt die Funktion die ge?nderte SpielStatusId zur?ck.
     */
    function setSpielStatusId($spielStatusId, $spielId) {
        $stmt = $this->pdo->prepare("UPDATE Spiel SET StatusID = :spielStatusId WHERE ID = :id");
        $stmt->bindParam(':id', $spielId);
        $stmt->bindParam(':spielStatusId', $spielStatusId);
        $stmt->execute();
        return $spielStatusId;
    }

    /*
     * Die Funktion neuesSpiel legt ein neues Spiel mit den beiden im 
     * Konstruktor mitgegebenen SpielerIds an 
     * und gibt die SpielID des neuen Spiels zur?ck.
     */
    function neuesSpiel() {
        include 'SpielStatusDatenbankSchnittstelle.php';
        $spielStatusDb = new SpielStatusDatenbankSchnittstelle();
        $spielStatusId = $spielStatusDb->ladeSpielStatusId("PHASE1");
        $stmt = $this->pdo->prepare("INSERT INTO Spiel(Spieler_1, Spieler_2, StatusID)
                            VALUES(:spieler1, :spieler2, :spielStatusId)");
        $stmt->bindParam(':spieler1', $this->spieler0);
        $stmt->bindParam(':spieler2', $this->spieler1);
        $stmt->bindParam(':spielStatusId', $spielStatusId);
        $stmt->execute();

        $spieleIds = $this->ladeSpiele();
        $neueSpielId = $spieleIds[count($spieleIds) - 1];
        return $neueSpielId;
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
