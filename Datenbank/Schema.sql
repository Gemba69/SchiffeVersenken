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
group by Benutzername 
order by GespielteSpiele desc

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
group by Benutzername 
order by GewonneneSpiele desc
;