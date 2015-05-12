function checkEnemy(){
	
	if (document.getElementById('Real').checked){
		document.getElementById("Search").disabled = false;
		document.getElementById("searchfield").disabled=false;
		document.getElementById("playerTable").disabled=false;
	} else if (document.getElementById('KI').checked){
		document.getElementById("Search").disabled = true;
		document.getElementById("searchfield").disabled=false;
		document.getElementById("playerTable").disabled=false;
	}
}