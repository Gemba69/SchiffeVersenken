<?php

/*
 * Die Klasse SpielzugtypDatenbankSchnittstelle stellt eine Verbindung zur 
 * Datenbank her und regelt den Zugriff auf die Tabelle Spielzugtyp.
 */
class SpielzugtypDatenbankSchnittstelle {
    
    //Variablen f�r die Datenbankverbindung
    private $pdo;

    //Konstruktor
    function __construct() {
        include "../Verbindung.php";
        $this->pdo = $dbh;
    }

    /*
     * Die Funktion ladeSpielzugtyp gibt bei Mitgabe der SpielzugtypID den Namen
     * und die Beschreibung zur�ck.
     */
    function ladeSpielzugtyp($spielzugtypId) {
        $spielzugtyp = array();
        $query = $this->pdo->prepare("SELECT Name,Beschreibung FROM Spielzugtyp WHERE ID = :spielzugtypId");
        $query->bindParam(':spielzugtypId', $spielzugtypId);
        $query->execute();
        $spielzugtyp =$query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($spielzugtyp);
    }
    
    /*
     * Die Funktion ladeSpielzugtypId gibt bei Mitgabe des Namens den die 
     * SpielzugtypID.
     */
    function ladeSpielzugtypId($spielzug) {
        $spielzugtyp = array();
        $query = $this->pdo->prepare("SELECT ID FROM Spielzugtyp WHERE Name = :spielzug");
        $query->bindParam(':spielzug', $spielzug);
        $query->execute();
        $spielzugtyp =$query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($spielzugtyp)[0];
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