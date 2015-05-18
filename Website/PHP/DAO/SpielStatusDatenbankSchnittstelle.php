<?php

/*
 * Die Klasse SpielStatusDatenbankSchnittstelle stellt eine Verbindung zur 
 * Datenbank her und regelt den Zugriff auf die Tabelle SpielStatus.
 */

class SpielStatusDatenbankSchnittstelle {

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
     * Die Funktion ladeSpielStatus gibt bei Mitgabe einer SpielStatusID 
     * den zugehörigen Status_Typ und die zugehörige Beschreibung zurück.
     */
    function ladeSpielStatus($spielStatusId) {
        $spielStatus = array();
        $query = $this->pdo->prepare("SELECT Status_Typ,Beschreibung FROM SpielStatus WHERE ID = :spielStatusId");
        $query->bindParam(':spielStatusId', $spielStatusId);
        $query->execute();
        $spielStatus = $query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($spielStatus);
    }

    /*
     * Die Funktion ladeSpielStatusId gibt bei Mitgabe des Status_Typs 
     * die SpielStatusId zurück.
     */
    function ladeSpielStatusId($status_Typ) {
        $spielStatus = array();
        $query = $this->pdo->prepare("SELECT ID FROM SpielStatus WHERE Status_Typ = :status_Typ");
        $query->bindParam(':status_Typ', $status_Typ);
        $query->execute();
        $spielStatus = $query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($spielStatus)[0];
    }

    /*
     * Die Funktion array_2d_to_1d gibt bei mitgabe eines zweidimensionalen
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
