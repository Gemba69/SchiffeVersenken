--
-- Testdaten Benutzer
--

Insert Into Benutzer (Benutzername, Password, Email) VALUES ('Gemba', 123, ('bluhn@web.de');
Insert Into Benutzer (Benutzername, Password, Email) VALUES ('Klabautermann', password, ('klaubautermann@web.de');
Insert Into Benutzer (Benutzername, Password, Email) VALUES ('admin', admin, ('admin@web.de');
Insert Into Benutzer (Benutzername, Password, Email) VALUES ('test', test, ('test@web.de');

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
-- Testdaten Spiel
--
Insert Into Spiel (Spieler_1, Spieler_2) VALUES (1,2);
Insert Into Spiel (Spieler_1, Spieler_2) VALUES (3,4);

--
-- Testdaten Spielzug
--
Insert Into Spielzug (SpielID, Spielbrett, X_Koordinate, Y_Koordinate, Spielzugtyp) VALUES (1,1,2,2,1);