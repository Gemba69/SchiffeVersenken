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

function checkGame(){
	var val = getRadioVal(document.getElementById("table"), "Spiel");
	
	if (val!=null) {
		document.getElementById("StartGame").disabled=false;
	}
}

function getRadioVal(form, name) {
    var val;
    // get list of radio buttons with specified name
    //var radios = form.elements[name];
    var radios = document.getElementsByName(name);
    
    // loop through list of radio buttons
    for (var i=0, len=radios.length; i<len; i++) {
        if ( radios[i].checked ) { // radio checked?
            val = radios[i].value; // if so, hold its value in val
            break; // and break out of for loop
        }
    }
    return val; // return value of checked radio or undefined if none checked
}

function setSpielID(form, name) {

	var val = getRadioVal(form, name)
	


}