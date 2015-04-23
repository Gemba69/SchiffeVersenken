<?php

class SpielzugtypDatenbankSchnittstelle {
    
    private $server = 'mysql:dbname=SchiffeVersenken;host=localhost';
    private $user = 'root';
    private $password = '';
    private $pdo;

    function __construct() {
        $this->pdo = new PDO($this->server, $this->user, $this->password);
    }

    function ladeSpielzugtyp($spielzugtypId) {
        $spielzugtyp = array();
        $query = $this->pdo->prepare("SELECT Name,Beschreibung FROM Spielzugtyp WHERE ID = :spielzugtypId");
        $query->bindParam(':spielzugtypId', $spielzugtypId);
        $query->execute();
        $spielzugtyp =$query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($spielzugtyp);
    }
    
    function ladeSpielzugtypId($spielzug) {
        $spielzugtyp = array();
        $query = $this->pdo->prepare("SELECT ID FROM Spielzugtyp WHERE Name = :spielzug");
        $query->bindParam(':spielzug', $spielzug);
        $query->execute();
        $spielzugtyp =$query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($spielzugtyp)[0];
    }
    
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