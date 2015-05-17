<!doctype html>
<html>
  <head>
      <meta charset="UTF-8">
      <title>SchiffeVersenkenFormularEinloggen</title>
	  <script src="scripts/Script.js"></script>
	  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	  <link href='stylesheets/Anmeldebild.css' rel='stylesheet' type='text/css'>
	  <link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css">
  </head>
  <body>
<?php
  session_start();
  session_destroy();
 
  echo '<p/> Sie wurden erfolgreich ausgeloggt</p>';
  
  echo '<p/> Sie werden in wenigen Sekunden zur LoginSeite weitergeleitet</p>';
	
  echo '<meta http-equiv="refresh" content="2; URL=../LogInFormular.html">';

?>

</body>
</html>