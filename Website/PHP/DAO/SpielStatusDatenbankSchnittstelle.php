<?php

/*
 * Die Klasse SpielStatusDatenbankSchnittstelle stellt eine Verbindung zur 
 * Datenbank her und regelt den Zugriff auf die Tabelle SpielStatus.
 */

class SpielStatusDatenbankSchnittstelle {

    //Variablen f�r die Datenbankverbindung
    private $pdo;

    //Konstruktor
    function __construct() {
        include "Verbindung.php";
        $this->pdo = $dbh;
    }

    /*
     * Die Funktion ladeSpielStatus gibt bei Mitgabe einer SpielStatusID 
     * den zugeh�rigen Status_Typ und die zugeh�rige Beschreibung zur�ck.
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
     * die SpielStatusId zur�ck.
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
