<!doctype html>
<html>
  <head>
      <meta charset="UTF-8">
      <title>Log In/-Out</title>
  </head>
  <body>
      <?php
       
        $benutzer = $_REQUEST['Benutzer'];
        $passwort = $_REQUEST['Passwort'];
        echo  'Hallo ' . $benutzer;
      
      ?>

    <form action="HalloWelt.php" method="post">
      Vorname: <input name="Vorname" type="text"> </br>
      Nachname: <input name="Nachname" type="text"> </br>
       <input type="submit"> </input>
    </form>
     
	

  </body>
</html>