<?php

class SpielDatenbankSchnittstelle {

    private $spieler0;
    private $spieler1;
    private $server = 'mysql:dbname=SchiffeVersenken;host=localhost';
    private $user = 'root';
    private $password = '';
    private $pdo;

    function __construct($parSpieler0, $parSpieler1) {
        $this->spieler0 = $parSpieler0;
        $this->spieler1 = $parSpieler1;
        $this->pdo = new PDO($this->server, $this->user, $this->password);
    }

    function ladeSpiele() {
        $spieleIds = array();
        $query = $this->pdo->prepare("SELECT ID FROM Spiel WHERE Spieler_1 = :spieler1 AND Spieler_2 = :spieler2");
        $query->bindParam(':spieler1', $this->spieler0);
        $query->bindParam(':spieler2', $this->spieler1);
        $query->execute();
        $spieleIds = $query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($spieleIds);
    }

    function getSpielStatusId($spielId) {
        $spielStatusId = array();
        $query = $this->pdo->prepare("SELECT StatusID FROM Spiel WHERE ID = :id");
        $query->bindParam(':id', $spielId);
        $query->execute();
        $spielStatusId = $query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($spielStatusId)[0];
    }

    function setSpielStatusId($spielStatusId, $spielId) {
        $stmt = $this->pdo->prepare("UPDATE Spiel SET StatusID = :spielStatusId WHERE ID = :id");
        $stmt->bindParam(':id', $spielId);
        $stmt->bindParam(':spielStatusId', $spielStatusId);
        $stmt->execute();
        return $spielStatusId;
    }

    function neuesSpiel() {
        include 'SpielStatusDatenbankSchnittstelle.php';
        $spielStatusDb = new SpielStatusDatenbankSchnittstelle();
        $spielStatusId = $spielStatusDb->ladeSpielStatusId("PHASE1");
        $stmt = $this->pdo->prepare("INSERT INTO Spiel(Spieler1, Spieler2, StatusID)
                            VALUES(:spieler1, :spieler2, :spielStatusId)");
        $stmt->bindParam(':spieler1', $this->spieler0);
        $stmt->bindParam(':spieler2', $this->spieler1);
        $stmt->bindParam(':spielStatusId', $spielStatusId);
        $stmt->execute();

        $spieleIds = $this->ladeSpiele();
        $neueSpielId = $spieleIds[count($spieleIds) - 1];
        return $neueSpielId;
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
