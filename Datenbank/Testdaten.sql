--
-- Testdaten Benutzer
--

Insert Into Benutzer (Benutzername, Password, Email) VALUES ('Gemba', 123, 'bluhn@web.de');
Insert Into Benutzer (Benutzername, Password, Email) VALUES ('Klabautermann', 'password', 'klaubautermann@web.de');
Insert Into Benutzer (Benutzername, Password, Email) VALUES ('admin', 'admin', 'admin@web.de');
Insert Into Benutzer (Benutzername, Password, Email) VALUES ('test', 'test', 'test@web.de');

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
--
-- Testdaten Spielzug
--

-- SPIEL1: Schiffe setzen Spieler 1
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,1,7,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,1,8,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,1,10,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,2,10,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,6,9,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,6,10,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,10,9,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,10,10,1);

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
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,10,8,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,3,7,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,4,7,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,5,7,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,6,7,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,9,3,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,9,4,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,9,5,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,9,6,1);

Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,4,10,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,5,10,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,6,10,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,7,10,1);
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,2,8,10,1);

-- BEGIN PHASE 2