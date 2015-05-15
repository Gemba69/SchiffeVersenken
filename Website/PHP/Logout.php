<?php
  session_start();
  session_destroy();
 
  echo '<p/> Sie wurden erfolgreich ausgeloggt</p>';
  
  echo '<p/> Sie werden in wenigen Sekunden zur LoginSeite weitergeleitet</p>';
	
  echo '<meta http-equiv="refresh" content="2; URL=../LogInFormular.html">';

?>