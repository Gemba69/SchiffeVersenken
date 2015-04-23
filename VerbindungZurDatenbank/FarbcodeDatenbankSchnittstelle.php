<?php

class FarbcodeDatenbankSchnittstelle {
    
    private $server = 'mysql:dbname=SchiffeVersenken;host=localhost';
    private $user = 'root';
    private $password = '';
    private $pdo;

    function __construct() {
        $this->pdo = new PDO($this->server, $this->user, $this->password);
    }

    function ladeSpielFarbcode($farbcodeId) {
        $farbcode = array();
        $query = $this->pdo->prepare("SELECT Name, Farbcode FROM Farbcode WHERE ID = :farbcodeId");
        $query->bindParam(':farbcodeId', $farbcodeId);
        $query->execute();
        $farbcode =$query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($farbcode);
    }
    
    function ladeFarbcodeId($name) {
        $farbcodeId = array();
        $query = $this->pdo->prepare("SELECT ID FROM Farbcode WHERE Name = :name");
        $query->bindParam(':name', $name);
        $query->execute();
        $farbcodeId =$query->fetchAll(PDO::FETCH_NUM);
        return $this->array_2d_to_1d($farbcodeId)[0];
    }
}

?>