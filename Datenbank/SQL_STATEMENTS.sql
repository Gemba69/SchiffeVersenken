-- Alle Spiele eines Spielers abfragen
Select * from Spiel where Spieler_1='benutzer' or Spieler_2='benutzer';

--Alle gewonnenen Spiele eines Spielers abfragen
Select * from Spiel where Spieler_1='benutzer' and StatusID=3 or Spieler_2='benutzer' and StatusID=4;

--Alle offenen Spiele eines Spielers abfragen
Select SpielID, Status_Typ, Benutzername
From
(SELECT Spiel.ID as SpielID, Status_Typ,
If(spieler_1=1,Spieler_2,Spieler_1)  As Gegner
FROM Spiel left join SpielStatus on StatusID=SpielStatus.ID
where (Spieler_1=1 or Spieler_2=1) and (StatusID='1' or StatusID='2')
) x
left join Benutzer on Gegner=Benutzer.ID
;

-- Alle Benutzer auflisten
Select * from Benutzer;

-- Benutzer an Spiel joinen
Select * from Benutzer, Spiel where Benutzer.ID=Spiel.Spieler_1 or Benutzer.ID=Spiel.Spieler_2;

Select * from Benutzer left join Spiel on Benutzer.ID=Spiel.Spieler_1 or Benutzer.ID=Spiel.Spieler_2;

-- Highscore: Meistgewonnene Spiele
Select Benutzername, count(Benutzername) as GewonneneSpiele from Benutzer 
join Spiel on Benutzer.ID=Spiel.Spieler_1 and Spiel.StatusID=3 
or Benutzer.ID=Spiel.Spieler_2 and Spiel.StatusID=4 
group by Benutzername order by GewonneneSpiele desc
;

-- Highscore: Gespielte Spiele
Select Benutzername, count(Benutzername) as GespielteSpiele from Benutzer 
join Spiel on Benutzer.ID=Spiel.Spieler_1
or Benutzer.ID=Spiel.Spieler_2
group by Benutzername order by GewonneneSpiele desc
;

-- Highscore: Höchste Gewinnquote 
Select a.Benutzername,a.gespielteSpiele as GespielteSpiele,
b.gewonneneSpiele as GewonneneSpiele, 
CONCAT(b.gewonneneSpiele/a.gespielteSpiele * 100, ' %') as Gewinnquote 
from highscore_gespielte_spiele a left outer join highscore_gewonnene_spiele b 
on a.Benutzername=b.Benutzername
;


-- Highscore Trefferpunkte





-- KI aus Abfragen rauslassen? -> filtern
