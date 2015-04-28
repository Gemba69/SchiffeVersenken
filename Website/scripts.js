var ENEMY_ID_PREFIX = "enemy";
var SELF_ID_PREFIX = "self";
var PHASE_1 = "Phase 1";
var PHASE_2 = "Phase 2";
var INSTRUCTIONS_PHASE_2_TEXT = "Feuere die Schiffe deines Gegners ab!";
var NO_VALID_SHIPS_WARNING = "Auf dem Server wurde keine gültige Schiffsanordnung erkannt. Bitte Seite neuladen und entsprechend korrigieren.";
var CONTINUE_BUTTON_CODE = "<button id='continuebutton' onclick='nextPhaseAjaxRequest()'>Angriff beginnen</button>";
var CONTINUE_INSTRUCTIONS_TEXT = "Sehr gut. Wenn du sicher bist, dass alle Schiffe richtig platziert sind, gehe nun zum Angriff über.";
var FIRST_INSTRUCTIONS_TEXT = "Platziere deine Schiffe auf dem unteren Feld."; //TODO: texte nicht hardcoden

var nextRequestFile = "ajax.php";

function addMouseDownClassToCell(i, j, idPrefix) {
	document.getElementById(idPrefix + "_cell_" + i + "_" + j).classList.add("mouse_down");
}

function removeMouseDownClassFromCell(i, j, idPrefix) {
	document.getElementById(idPrefix + "_cell_" + i + "_" + j).classList.remove('mouse_down');
}

//-------------tile flip functions------------

function toggleShip(i, j, idPrefix) {
	var tile = document.getElementById(idPrefix + "_cell_" + i + "_" + j);
	if (hasClass(tile, "graycol")) {
		tile.classList.remove("graycol");
		tile.classList.add("flipToBlue");
		setTimeout(function(){
			tile.classList.remove("flipToBlue");
		}, 300);
	} else {
		flipTile(i, j, idPrefix, "gray");
	}
}

function flipTile(i, j, idPrefix, newColor) {
	var tile = document.getElementById(idPrefix + "_cell_" + i + "_" + j);
	var animName;
	var colName;
	//ugly as sin
	if (newColor == "gray") {
		animName = "flipToGray";
		colName = "graycol";
	} else if (newColor == "darkblue") {
		animName = "flipToDarkBlue";
		colName = "darkbluecol";
	} else if (newColor == "red") {
		animName = "flipToRed";
		colName = "redcol";
	} else if (newColor == "black") {
		animName = "flipToBlack";
		colName = "blackcol";
	}
	tile.classList.add(animName);
	tile.classList.add(colName);
	setTimeout(function(){
		tile.classList.remove(animName);
	}, 300);
}

//-------------/tile flip functions-----------

//-------------ajax functions----------------
function cellClickedAjaxRequest(i, j, idPrefix) {
	$.post(nextRequestFile, { i: i, j: j, gameField: idPrefix })
	.done(function(data) {
		processAnswer(data);
	});
}

function resumeSessionAjaxRequest() {
	$.post("ajax.php", { })
	.done(function(data) {
		processAnswer(data);
	});
}

function nextPhaseAjaxRequest() {
	$.post("ajax.php", { nextPhase: "true" })
	.done(function(data) {
		processNextPhaseAnswer(data);
	});
}

function processAnswer(answer) {
	document.getElementById('infobox').innerHTML = answer; //debug
	
	var ans = jQuery.parseJSON(answer);
	if (ans.illegal == true)
		return;
	
	nextRequestFile = ans.nextRequest;
	
	var cells = ans.cells;
	for (var v = 0; v < cells.length; v++) {
		var i = cells[v].i;
		var j = cells[v].j;
		var color = cells[v].color;
		var idPrefix = cells[v].field;
		
		if (color === "gray")
			toggleShip(i, j, idPrefix);
		else
			flipTile(i, j, idPrefix, color);
	}
	var remainingShipCode = ans.remainingShipCode;
	
	document.getElementById('remainingships').classList.remove('fadeinanim');
	document.getElementById('remainingships').innerHTML = remainingShipCode;
	document.getElementById('instructions').classList.remove('fadeinanim');
	document.getElementById('instructions').innerHTML = FIRST_INSTRUCTIONS_TEXT;
	
	if (ans.allShipsPlaced) {
		document.getElementById('remainingships').firstChild.classList.add('fadeoutanim');
		document.getElementById('instructions').classList.add('fadeoutanim');
		setTimeout(function() {
				document.getElementById('remainingships').innerHTML = CONTINUE_BUTTON_CODE;
				document.getElementById('remainingships').classList.remove('fadeoutanim');
				document.getElementById('remainingships').classList.add('fadeinanim');
				
				document.getElementById('instructions').innerHTML = CONTINUE_INSTRUCTIONS_TEXT;
				document.getElementById('instructions').classList.remove('fadeoutanim');
				document.getElementById('instructions').classList.add('fadeinanim');
			}, 200);
	}
}

function processNextPhaseAnswer(data) {
	if (data) {
		document.getElementById('phase').innerHTML = PHASE_2;
		document.getElementById('instructions').innerHTML = INSTRUCTIONS_PHASE_2_TEXT;
		document.getElementById('remainingships').innerHTML = "";
	} else {
		document.getElementById('infobox').innerHTML = NO_VALID_SHIPS_WARNING;
	}
}

function reset() {
	resumeSessionAjaxRequest();
	$.post( "ajax.php", {reset:"true" }); // a bit hacky, but this function will not be in production anyway
}
