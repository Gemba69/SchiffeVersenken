var bolCheckUser = false;
var bolCheckEmail = false;
var bolCheckPassword = false;
var bolCheckAgb = false;

function checkPasswords(){
	var p1 = document.getElementById("pw1").value;
	var p2 = document.getElementById("pw2").value;
	
	if (p1 !== p2){
		document.getElementById("submit").disabled = true;
		document.getElementById("submit").classList.remove("blueBorder");
		document.getElementById("pw1").classList.add("redErrorBorder")
		document.getElementById("pw2").classList.add("redErrorBorder");		
		bolCheckPassword = false;
	} else {
		document.getElementById("pw1").classList.remove("redErrorBorder")
		document.getElementById("pw2").classList.remove("redErrorBorder");
		bolCheckPassword = true;
		checkNecessaryInput();
	}
}

function checkEmail(){
	var p1 = document.getElementById("email").value;
	var schema = /^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/;
	var matches = p1.match(schema);
	
	if (!matches){
		document.getElementById("submit").disabled = true;
		document.getElementById("submit").classList.remove("blueBorder");
		document.getElementById("email").classList.add("redErrorBorder");
		bolCheckEmail = false;
	} else {
		document.getElementById("email").classList.remove("redErrorBorder");
		bolCheckEmail = true;
		checkNecessaryInput();
	}
}

function checkUser(){
	var p1 = document.getElementById("user").value;
	var schema = /^[A-Za-z0-9]{1,32}$/;
	var matches = p1.match(schema);
	
	if (!matches){
		document.getElementById("submit").disabled = true;
		document.getElementById("submit").classList.remove("blueBorder");
		document.getElementById("user").classList.add("redErrorBorder");
		bolCheckUser = false;
	} else {
		document.getElementById("user").classList.remove("redErrorBorder");
		bolCheckUser = true;
		checkNecessaryInput();
	}
}

function checkAccept(){
	
	if (document.getElementById("agb").checked){
		bolCheckAgb = true;
		checkNecessaryInput();
		
	}else{
		document.getElementById("submit").disabled = true;
		document.getElementById("submit").classList.remove("blueBorder");
		bolCheckAgb = false;
	}
}

function checkNecessaryInput(){
	
	if (bolCheckUser && bolCheckEmail && bolCheckPassword && bolCheckAgb){
		document.getElementById("submit").disabled = false;
		document.getElementById("submit").classList.add("blueBorder");
	} else {
		document.getElementById("submit").disabled = true;
		document.getElementById("submit").classList.remove("blueBorder");
	}
}

function soundSetter(){
	
	if (document.getElementById("c1").checked){
		audio.muted = true;
		document.getElementById("c1").classList.add("label.unmute");
	}else{
		audio.muted = false;
		document.getElementById("c1").classList.add("label.mute");
	}
}







