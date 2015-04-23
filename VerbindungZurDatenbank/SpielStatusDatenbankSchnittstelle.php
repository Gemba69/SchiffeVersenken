<?php

class SpielStatusDatenbankSchnittstelle {

    private $server = 'mysql:dbname=SchiffeVersenken;host=localhost';
    private $user = 'root';
    private $password = '';
    private $pdo;

    function __construct() {
        $this->pdo = new PDO($this->server, $this->user, $this->password);
    }

    function ladeSpielStatus($spielStatusId) {
        $spielStatus = array();
        $query = $this->pdo->prepare("SELECT Status_Typ,Beschreibung FROM SpielStatus WHERE ID = :spielStatusId");
        $query->bindParam(':spielStatusId', $spielStatusId);
        $query->execute();
        $spielStatus = $query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($spielStatus);
    }

    function ladeSpielStatusId($status_Typ) {
        $spielStatus = array();
        $query = $this->pdo->prepare("SELECT ID FROM SpielStatus WHERE Status_Typ = :status_Typ");
        $query->bindParam(':status_Typ', $status_Typ);
        $query->execute();
        $spielStatus = $query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($spielStatus)[0];
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
