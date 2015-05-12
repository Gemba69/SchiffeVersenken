<?php

/*
 * Die Klasse FarbcodeDatenbankSchnittstelle stellt eine Verbindung zur 
 * Datenbank her mit der man den Farbcode oder die FarbcodeId aus der Tabelle
 * Farbcode auslesen kann.
 */

class FarbcodeDatenbankSchnittstelle {

    //Variablen für die Datenbankverbindung
    private $server = 'mysql:dbname=SchiffeVersenken;host=localhost';
    private $user = 'root';
    private $password = '';
    private $pdo;

    //Konstruktor
    function __construct() {
        $this->pdo = new PDO($this->server, $this->user, $this->password);
    }

    /*
     * Die Funktion ladeSpielFarbcode gibt bei Mitgabe der FarbcodeID den Namen
     * und den Hex-Farbcode zurück.
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
     * Die Funktion ladeFarbcodeId gibt bei Mitgabe des Namen die zugehörige 
     * FarbcodeID zurück.
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
     * Arrays ein eindimensionales Array zurück, in dem die Zeilen/Datensätze 
     * aus dem zweidimensionalen Array hintereiandergehängt wurden.
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