-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 16. Apr 2015 um 15:57
-- Server Version: 5.6.21
-- PHP-Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `SchiffeVersenken`
--
Create database SchiffeVersenken;
Use SchiffeVersenken;
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Benutzer`
--
	
CREATE TABLE IF NOT EXISTS `Benutzer` (
`ID` int(11) NOT NULL AUTO_INCREMENT,
  `Benutzername` varchar(40) NOT NULL,
  `Password` varchar(64) NOT NULL,
  `Email` varchar(40) NOT NULL,
   PRIMARY KEY (`ID`),
   UNIQUE KEY `UNIQUE_NAME` (`Benutzername`),
   UNIQUE KEY `UNIQUE_EMAIL` (`Email`)
) ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Spielzugtyp`
--
	
CREATE TABLE IF NOT EXISTS `Spielzugtyp` (
`ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(40) NOT NULL,
  `Beschreibung` varchar(100),
   PRIMARY KEY (`ID`), 
   UNIQUE KEY `UNIQUE_NAME` (`Name`)
) ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `SpielStatus`
--
	
CREATE TABLE IF NOT EXISTS `SpielStatus` (
`ID` int(11) NOT NULL AUTO_INCREMENT,
  `Status_Typ` varchar(40) NOT NULL,
  `Beschreibung` varchar(100),
  PRIMARY KEY (`ID`), 
  UNIQUE KEY `UNIQUE_NAME` (`Status_Typ`)
) ;
 
 -- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Spiel`
--
	
CREATE TABLE IF NOT EXISTS `Spiel` (
`ID` int(11) NOT NULL AUTO_INCREMENT,
  `Spieler_1` int(11) NOT NULL,
  `Spieler_2` int(11) NOT NULL,
  `StatusID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`Spieler_1`) REFERENCES Benutzer (`id`),
  FOREIGN KEY (`Spieler_2`) REFERENCES Benutzer (`id`),
  FOREIGN KEY (`StatusID`) REFERENCES SpielStatus(`id`)
) ;
 
 -- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Spielzug`
--
	
CREATE TABLE IF NOT EXISTS `Spielzug` (
`ID` int(11) NOT NULL AUTO_INCREMENT,
  `SpielID` int(11) NOT NULL,
  `Spielbrett` int(11) NOT NULL,
  `X_Koordinate` int(11) NOT NULL,
  `Y_Koordinate` int(11) NOT NULL,
  `Spielzugtyp` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`SpielID`) REFERENCES Spiel(`ID`),
  FOREIGN KEY (`Spielzugtyp`) REFERENCES Spielzugtyp(`id`)
);
 
 -- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Farbcode`
--
	
CREATE TABLE IF NOT EXISTS `Farbcode` (
`ID` int(11) NOT NULL AUTO_INCREMENT,
  `Feld_Typ` varchar(40) NOT NULL,
  `Farbcode` varchar(100),
  PRIMARY KEY (`ID`), 
  UNIQUE KEY `UNIQUE_NAME` (`Feld_Typ`)
) ;

 -- --------------------------------------------------------

--
-- View für Statistik `Gespielte_Spiele`
--
	
CREATE VIEW Highscore_Gespielte_Spiele ( Benutzername, GespielteSpiele ) 
AS 
Select Benutzername, count(Benutzername) as GespielteSpiele 
from Benutzer 
join Spiel on Benutzer.ID=Spiel.Spieler_1 
or Benutzer.ID=Spiel.Spieler_2 
where Benutzer.ID!=0
group by Benutzername 
order by GespielteSpiele desc
;

 -- --------------------------------------------------------

--
-- View für Statistik `Gewonnene_Spiele`
--
	
CREATE VIEW Highscore_Gewonnene_Spiele ( Benutzername, GewonneneSpiele ) 
AS 
Select Benutzername, count(Benutzername) as GewonneneSpiele 
from Benutzer 
join Spiel on Benutzer.ID=Spiel.Spieler_1 and Spiel.StatusID=3 
or Benutzer.ID=Spiel.Spieler_2 and Spiel.StatusID=4 
where Benutzer.ID!=0
group by Benutzername 
order by GewonneneSpiele desc
;

--
-- Necessary Data for Standard-Tables 
--

--
-- Daten Spielzugtyp
--

Insert Into Spielzugtyp (Name, Beschreibung) VALUES ('SETZEN', 'Ein Schiff auf ein Feld setzen');
Insert Into Spielzugtyp (Name, Beschreibung) VALUES ('LOESCHEN', 'Ein Schiff von einem Feld loeschen');
Insert Into Spielzugtyp (Name, Beschreibung) VALUES ('ANGRIFF', 'Ein Feld Angreifen');

--
-- Daten Farbcode
--
Insert Into Farbcode (Feld_Typ, Farbcode) VALUES ('WASSER', '74C2E1');
Insert Into Farbcode (Feld_Typ, Farbcode) VALUES ('MISS', '3482A1');
Insert Into Farbcode (Feld_Typ, Farbcode) VALUES ('SCHIFF', '555555');
Insert Into Farbcode (Feld_Typ, Farbcode) VALUES ('TREFFER', 'FF0000');
Insert Into Farbcode (Feld_Typ, Farbcode) VALUES ('VERSENKT', '000000');

--
-- Daten SpielStatus
--
Insert Into SpielStatus(Status_Typ, Beschreibung) VALUES ('PHASE1', 'Schiffe werden noch gesetzt');
Insert Into SpielStatus(Status_Typ, Beschreibung) VALUES ('PHASE2', 'Das Spiel befindet sich in Phase 2');
Insert Into SpielStatus(Status_Typ, Beschreibung) VALUES ('GEWONNEN_SPIELER1', 'Spieler1 hat gewonnen');
Insert Into SpielStatus(Status_Typ, Beschreibung) VALUES ('GEWONNEN_SPIELER2', 'Spieler 2 hat das Spiel gewonnen');


CREATE USER Raeud@localhost;
SET password for Raeud@localhost = password('admin');
GRANT Select, Insert, Update on SchiffeVersenken.* to Raeud@localhost;

