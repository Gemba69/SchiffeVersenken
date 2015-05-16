--
-- Testdaten Benutzer
-- Gemba: 123; Klaubautermann: password; admin: admin; test: test
--
Insert Into Benutzer (`ID`, `Benutzername`, `Password`, `Email`) Values (0, 'KI', 'eufvegfuebf', '');
UPDATE Benutzer SET ID = '0' WHERE Benutzername='KI';
Insert Into Benutzer (Benutzername, Password, Email) VALUES ('Gemba', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'bluhn@web.de');
Insert Into Benutzer (Benutzername, Password, Email) VALUES ('Klabautermann', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'klaubautermann@web.de');
Insert Into Benutzer (Benutzername, Password, Email) VALUES ('admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin@web.de');
Insert Into Benutzer (Benutzername, Password, Email) VALUES ('test', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'test@web.de');

--
-- Testdaten Spielzugtyp
--

Insert Into Spielzugtyp (Name, Beschreibung) VALUES ('SETZEN', 'Ein Schiff auf ein Feld setzen');
Insert Into Spielzugtyp (Name, Beschreibung) VALUES ('LOESCHEN', 'Ein Schiff von einem Feld loeschen');
Insert Into Spielzugtyp (Name, Beschreibung) VALUES ('ANGRIFF', 'Ein Feld Angreifen');

--
-- Testdaten Farbcode
--
Insert Into Farbcode (Feld_Typ, Farbcode) VALUES ('WASSER', '74C2E1');
Insert Into Farbcode (Feld_Typ, Farbcode) VALUES ('MISS', '3482A1');
Insert Into Farbcode (Feld_Typ, Farbcode) VALUES ('SCHIFF', '555555');
Insert Into Farbcode (Feld_Typ, Farbcode) VALUES ('TREFFER', 'FF0000');
Insert Into Farbcode (Feld_Typ, Farbcode) VALUES ('VERSENKT', '000000');

--
-- Testdaten SpielStatus
--
Insert Into SpielStatus(Status_Typ, Beschreibung) VALUES ('PHASE1', 'Schiffe werden noch gesetzt');
Insert Into SpielStatus(Status_Typ, Beschreibung) VALUES ('PHASE2', 'Das Spiel befindet sich in Phase 2');
Insert Into SpielStatus(Status_Typ, Beschreibung) VALUES ('GEWONNEN_SPIELER1', 'Spieler1 hat gewonnen');
Insert Into SpielStatus(Status_Typ, Beschreibung) VALUES ('GEWONNEN_SPIELER2', 'Spieler 2 hat das Spiel gewonnen');

--
-- Testdaten Spiel
--
Insert Into Spiel (Spieler_1, Spieler_2, StatusID) VALUES (1,2, 1);

Insert Into Spiel (Spieler_1, Spieler_2, StatusID) VALUES (3,4, 2);

Insert Into Spiel (Spieler_1, Spieler_2, StatusID) VALUES (1,3, 3);
Insert Into Spiel (Spieler_1, Spieler_2, StatusID) VALUES (1,4, 3);
Insert Into Spiel (Spieler_1, Spieler_2, StatusID) VALUES (1,3, 3);
Insert Into Spiel (Spieler_1, Spieler_2, StatusID) VALUES (2,3, 4);
Insert Into Spiel (Spieler_1, Spieler_2, StatusID) VALUES (2,1, 4);
Insert Into Spiel (Spieler_1, Spieler_2, StatusID) VALUES (2,1, 2);
Insert Into Spiel (Spieler_1, Spieler_2, StatusID) VALUES (1,3, 2);
Insert Into Spiel (Spieler_1, Spieler_2, StatusID) VALUES (4,1, 1);
--
-- Testdaten Spielzug
--

-- SPIEL1: Schiffe setzen Spieler 1
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,1,7,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,1,8,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,1,0,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,2,0,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,6,9,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,6,0,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,0,9,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,0,0,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,5,1,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,5,2,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,5,3,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,9,1,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,9,2,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,9,3,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,5,8,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,6,8,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,7,8,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,2,2,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,2,2,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,2,2,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,2,2,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,1,1,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,1,2,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,1,3,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,1,4,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,3,6,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,4,6,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,5,6,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,6,6,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,7,6,1);

-- SPIEL 1: Schiffe setzen Spieler 2
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,1,1,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,2,1,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,4,2,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,5,2,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,7,1,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,8,1,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,4,4,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,4,5,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,7,3,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,7,4,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,7,5,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,2,3,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,2,4,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,2,5,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,8,8,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,9,8,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,0,8,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,3,7,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,4,7,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,5,7,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,6,7,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,9,3,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,9,4,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,9,5,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,9,6,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,4,0,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,5,0,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,6,0,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,7,0,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,8,0,1);

-- BEGIN PHASE 2