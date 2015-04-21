<?php

class SpielDatenbankSchnittstelle {

    private $spieler0;
    private $spieler1;
    private $pdo;

    function __construct($parSpieler0, $parSpieler1) {
        $this->spieler1 = $parSpieler0;
        $this->spieler2 = $parSpieler1;
        $this->pdo = new PDO($this->server, $this->user, $this->password);
    }

    function ladeSpiele() {
        $spieleIds = array();
        $query = 'SELECT ID '
                . 'FROM Spiel WHERE Spieler1 = :spieler1 AND Spieler2 = :spieler2';
        $query->bindParam(':spieler1', $this->spieler0);
        $query->bindParam(':spieler2', $this->spieler1);
        $this->pdo->execute();
        $spieleIds = $this->pdo->get_result();
        return $spieleIds;
    }

    function neuesSpiel() {
        $stmt = $this->pdo->prepare("INSERT INTO Spiel(Spieler1, Spieler2)
                            VALUES(:spieler1, :spieler2)");
        $stmt->bindParam(':spieler1', $this->spieler0);
        $stmt->bindParam(':spieler2', $this->spieler1);
        $stmt->execute();
        
        $query = 'SELECT ID '
                . 'FROM Spiel WHERE Spieler1 = :spieler1 AND Spieler2 = :spieler2';
        $query->bindParam(':spieler1', $this->spieler0);
        $query->bindParam(':spieler2', $this->spieler1);
        $this->pdo->execute();
        $spieleIds = $this->pdo->get_result();
        $neueSpielId = $spieleIds[count($spieleIds)-1];
        return $neueSpielId;
    }

}

?>
