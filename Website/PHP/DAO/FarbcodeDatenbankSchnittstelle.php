<?php

/*
 * Die Klasse FarbcodeDatenbankSchnittstelle stellt eine Verbindung zur 
 * Datenbank her mit der man den Farbcode oder die FarbcodeId aus der Tabelle
 * Farbcode auslesen kann.
 */

class FarbcodeDatenbankSchnittstelle {

    //Variablen f�r die Datenbankverbindung
    private $pdo;

    //Konstruktor
    function __construct() {
        include "../Verbindung.php";
        $this->pdo = $dbh;
    }

    /*
     * Die Funktion ladeSpielFarbcode gibt bei Mitgabe der FarbcodeID den Namen
     * und den Hex-Farbcode zur�ck.
     */
    function ladeSpielFarbcode($farbcodeId) {
        $farbcode = array();
        $query = $this->pdo->prepare("SELECT Name, Farbcode FROM Farbcode WHERE ID = :farbcodeId");
        $query->bindParam(':farbcodeId', $farbcodeId);
        $query->execute();
        $farbcode = $query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($farbcode);
    }

    /*
     * Die Funktion ladeFarbcodeId gibt bei Mitgabe des Namen die zugeh�rige 
     * FarbcodeID zur�ck.
     */
    function ladeFarbcodeId($name) {
        $farbcodeId = array();
        $query = $this->pdo->prepare("SELECT ID FROM Farbcode WHERE Name = :name");
        $query->bindParam(':name', $name);
        $query->execute();
        $farbcodeId = $query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($farbcodeId)[0];
    }

    /*
     * Die Funktion array_2d_to_1d gibt bei Mitgabe eines zweidimensionalen
     * Arrays ein eindimensionales Array zur�ck, in dem die Zeilen/Datens�tze 
     * aus dem zweidimensionalen Array hintereiandergeh�ngt wurden.
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