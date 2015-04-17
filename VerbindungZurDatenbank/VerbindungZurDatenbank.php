<?php

class SpielzugDatenbankSchnittstelle {

    private $spielbrett1 = array();
    private $spielbrett2 = array();
    private $feldhoehe;
    private $feldbreite;
    private $spielId;
    private $server = 'mysql:dbname=SchiffeVersenken;host=localhost';
    private $user = 'root';
    private $password = '';
    private $pdo;

    function __construct($parFeldhoehe, $parFeldbreite, $parSpielId) {
        
        $this->feldhoehe = $parFeldhoehe;
        $this->feldbreite =$parFeldbreite;
        $this->spielId = $parSpielId;
        $this->pdo = new PDO($this->server, $this->user, $this->password);

        for ($i = 0; $i < feldhoehe; $i++) {
            for ($j = 0; $j < feldhoehe; $j++) {
                $this->spielbrett1[$i][$j]="WASSER";
            }
        }
        
        for ($i = 0; $i < feldhoehe; $i++) {
            for ($j = 0; $j < feldhoehe; $j++) {
                $this->spielbrett2[$i][$j]="WASSER";
            }
        }
    }

    public function ladeSpielbrettAusDb() {
        $i = 0;
        $spielzugArray = array();

        $query = 'SELECT Spielbrett, x-Koordinate, y-Koordinate, Spielzugtyp '
                . 'FROM Spielzug WHERE SpielID = :spielID';
        $query->bindParam(':spielId', $this->spielId);

        foreach ($this->pdo->query($query) as $spielzugArray) {
            if ($spielzugArray[i] == 0) {
                $i++;
                $xk = $spielzugArray[i];
                $yk = $spielzugArray[i+1];
                $i=$i+2;
                if ($this->spielbrett1[$xk][$yk]== "WASSER"&& $spielzugArray[$i]=="SETZEN"){
                    $this->spielbrett1[$xk][$yk]="SCHIFF";
                }
                else if ($this->spielbrett1[$xk][$yk]== "WASSER"&& $spielzugArray[$i]=="LOESCHEN"){
                    $this->spielbrett1[$xk][$yk]="WASSER";
                }
                else if ($this->spielbrett1[$xk][$yk]== "WASSER"&& $spielzugArray[$i]=="ANGRIFF"){
                    $this->spielbrett1[$xk][$yk]="MISS";
                }
                else if ($this->spielbrett1[$xk][$yk]== "MISS"&& $spielzugArray[$i]=="SETZEN"){
                    $this->spielbrett1[$xk][$yk]="MISS";
                }
                else if ($this->spielbrett1[$xk][$yk]== "MISS"&& $spielzugArray[$i]=="LOESCHEN"){
                    $this->spielbrett1[$xk][$yk]="MISS";
                }
                else if ($this->spielbrett1[$xk][$yk]== "MISS"&& $spielzugArray[$i]=="ANGRIFF"){
                    $this->spielbrett1[$xk][$yk]="MISS";
                }
                else if ($this->spielbrett1[$xk][$yk]== "SCHIFF"&& $spielzugArray[$i]=="SETZEN"){
                    $this->spielbrett1[$xk][$yk]="SCHIFF";
                }
                else if ($this->spielbrett1[$xk][$yk]== "SCHIFF"&& $spielzugArray[$i]=="LOESCHEN"){
                    $this->spielbrett1[$xk][$yk]="WASSER";
                }
                else if ($this->spielbrett1[$xk][$yk]== "SCHIFF"&& $spielzugArray[$i]=="ANGRIFF"){
                    $this->spielbrett1[$xk][$yk]="TREFFER";
                }
                else if ($this->spielbrett1[$xk][$yk]== "TREFFER"&& $spielzugArray[$i]=="SETZEN"){
                    $this->spielbrett1[$xk][$yk]="TREFFER";
                }
                else if ($this->spielbrett1[$xk][$yk]== "TREFFER"&& $spielzugArray[$i]=="LOESCHEN"){
                    $this->spielbrett1[$xk][$yk]="TREFFER";
                }
                else if ($this->spielbrett1[$xk][$yk]== "TREFFER"&& $spielzugArray[$i]=="ANGRIFF"){
                    $this->spielbrett1[$xk][$yk]="TREFFER";
                }
                else if ($this->spielbrett1[$xk][$yk]== "VERSENKT"&& $spielzugArray[$i]=="SETZEN"){
                    $this->spielbrett1[$xk][$yk]="VERSENKT";
                }
                else if ($this->spielbrett1[$xk][$yk]== "VERSENKT"&& $spielzugArray[$i]=="LOESCHEN"){
                    $this->spielbrett1[$xk][$yk]="VERSENKT";
                }
                else if ($this->spielbrett1[$xk][$yk]== "VERSENKT"&& $spielzugArray[$i]=="ANGRIFF"){
                    $this->spielbrett1[$xk][$yk]="VERSENKT";
                }
                $i++;
            } else {
                $i++;
                $xk = $spielzugArray[i];
                $yk = $spielzugArray[i+1];
                $i=$i+2;
                if ($this->spielbrett2[$xk][$yk]== "WASSER"&& $spielzugArray[$i]=="SETZEN"){
                    $this->spielbrett2[$xk][$yk]="SCHIFF";
                }
                else if ($this->spielbrett2[$xk][$yk]== "WASSER"&& $spielzugArray[$i]=="LOESCHEN"){
                    $this->spielbrett2[$xk][$yk]="WASSER";
                }
                else if ($this->spielbrett2[$xk][$yk]== "WASSER"&& $spielzugArray[$i]=="ANGRIFF"){
                    $this->spielbrett2[$xk][$yk]="MISS";
                }
                else if ($this->spielbrett2[$xk][$yk]== "MISS"&& $spielzugArray[$i]=="SETZEN"){
                    $this->spielbrett2[$xk][$yk]="MISS";
                }
                else if ($this->spielbrett2[$xk][$yk]== "MISS"&& $spielzugArray[$i]=="LOESCHEN"){
                    $this->spielbrett2[$xk][$yk]="MISS";
                }
                else if ($this->spielbrett2[$xk][$yk]== "MISS"&& $spielzugArray[$i]=="ANGRIFF"){
                    $this->spielbrett2[$xk][$yk]="MISS";
                }
                else if ($this->spielbrett2[$xk][$yk]== "SCHIFF"&& $spielzugArray[$i]=="SETZEN"){
                    $this->spielbrett2[$xk][$yk]="SCHIFF";
                }
                else if ($this->spielbrett2[$xk][$yk]== "SCHIFF"&& $spielzugArray[$i]=="LOESCHEN"){
                    $this->spielbrett2[$xk][$yk]="WASSER";
                }
                else if ($this->spielbrett2[$xk][$yk]== "SCHIFF"&& $spielzugArray[$i]=="ANGRIFF"){
                    $this->spielbrett2[$xk][$yk]="TREFFER";
                }
                else if ($this->spielbrett2[$xk][$yk]== "TREFFER"&& $spielzugArray[$i]=="SETZEN"){
                    $this->spielbrett2[$xk][$yk]="TREFFER";
                }
                else if ($this->spielbrett2[$xk][$yk]== "TREFFER"&& $spielzugArray[$i]=="LOESCHEN"){
                    $this->spielbrett2[$xk][$yk]="TREFFER";
                }
                else if ($this->spielbrett2[$xk][$yk]== "TREFFER"&& $spielzugArray[$i]=="ANGRIFF"){
                    $this->spielbrett2[$xk][$yk]="TREFFER";
                }
                else if ($this->spielbrett2[$xk][$yk]== "VERSENKT"&& $spielzugArray[$i]=="SETZEN"){
                    $this->spielbrett2[$xk][$yk]="VERSENKT";
                }
                else if ($this->spielbrett2[$xk][$yk]== "VERSENKT"&& $spielzugArray[$i]=="LOESCHEN"){
                    $this->spielbrett2[$xk][$yk]="VERSENKT";
                }
                else if ($this->spielbrett2[$xk][$yk]== "VERSENKT"&& $spielzugArray[$i]=="ANGRIFF"){
                    $this->spielbrett2[$xk][$yk]="VERSENKT";
                }
                $i++;
            }
        }
        versenktueberpruefung();
    }
    
    public function versenktueberpruefung(){
        
    }
    
    public function findeAdjazenteTreffer($x, $y){
        
    }

    public function speicherSpielzugInDb($spielbrett, $x, $y, $spielzugTyp) {
        if ($spielbrett > -1 && $spielbrett < -1) {
            if ($x > 0 && $x < $this->feldbreite) {
                if ($y > 0 && $y < $this->feldhoehe) {
                    if ($spielzugTyp == "SETZEN" || $spielzugTyp == "LOESCHEN" || $spielzugTyp == "ANGRIFF") {
                        $stmt = $this->pdo->prepare("INSERT INTO Spielzug(SpielID, Spielbrett, x-Koordinate, y-Koordinate, Spielzugtyp)
                            VALUES(:spielId, :spielbrett, :x, :y, :spielzugTyp)");
                        $stmt->bindParam(':spielId', $this->spielId);
                        $stmt->bindParam(':spielbrett', $spielbrett);
                        $stmt->bindParam(':x', $x);
                        $stmt->bindParam(':y', $y);
                        $stmt->bindParam(':spielzugTyp', $spielzugTyp);
                        $stmt->execute();
                    } else {
                        print("SpielzugTyp: " . $spielzugTyp . " ist nicht vorhanden! (moeglich ist: SETZEN,LOESCHEN,ANGRIFF)");
                    }
                } else {
                    print("y: " . $y . " ist nicht vorhanden! ( 0-" . $this->feldhoehe . ")");
                }
            } else {
                print("x: " . $x . " ist nicht vorhanden! ( 0-" . $this->feldbreite . ")");
            }
        } else {
            print("Spielbrett: " . $spielbrett . " ist nicht vorhanden! (Spielbrett muss 0 oder 1 sein)");
        }
    }

}

?>