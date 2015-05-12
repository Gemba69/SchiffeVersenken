
<?php
// Zugangsdaten zur Datenbank
$DB_HOST = "localhost"; // Datenbank-Host
$DB_NAME = "schiffeversenken"; // Datenbank-Name
$DB_BENUTZER = "root"; // Datenbank-Benutzer
$DB_PASSWORT = ""; // Datenbank-Passwort


try {
 // Verbindung zur Datenbank aufbauen
 $dbh = new PDO("mysql:host=" . $DB_HOST . ";dbname=" . $DB_NAME,
  $DB_BENUTZER, $DB_PASSWORT);
}
catch (PDOException $e) {
 // Bei einer fehlerhaften Verbindung eine Nachricht ausgeben
 exit("Verbindung fehlgeschlagen! " . $e->getMessage());
}
?> 
