<?php 
require_once 'auth.php'; 
require_once('DAO/SpielDatenbankSchnittstelle.php');

$dao = new SpielDatenbankSchnittstelle(htmlspecialchars($_SESSION['BenutzerID']), 0);
$_SESSION['Spiel'] = $dao->neuesSpiel();

header("Location: ../Spiel.php");		




?>


