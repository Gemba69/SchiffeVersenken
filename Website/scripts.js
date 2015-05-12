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

function hasClass(element, cls) { 
    return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1; 
} 


//-------------/tile flip functions-----------

//-------------ajax functions----------------
function cellClickedAjaxRequest(i, j, idPrefix) {
	$.ajax({
		type: 'POST',
		url: nextRequestFile,
		data: { i: i, j: j, gameField: idPrefix },
		dataType: 'html',
		success: function(data) {
			processAnswer(data);
		},
		error: function(data, a, b) {
			alert(data + a + b);
		}
	});
}

function resumeSessionAjaxRequest() {
	$.ajax({
		type: 'GET',
		url: 'ajax.php',
		dataType: 'html',
		success: function(data) {
			processAnswer(data);
		},
		error: function(data, a, b) {
			alert(data + a + b);
		}
	});
}

function nextPhaseAjaxRequest() {
	$.post(nextRequestFile, { nextPhase: "true" })
	.done(function(data) {
		processAnswer(data);
	});
}

function processAnswer(answer) {
	//alert(answer);
	//window.clipboardData.setData("Text",answer);
	document.getElementById('infobox').innerHTML = answer; //debug
	
	answer = $.parseJSON(answer);
	if (answer.illegal == true)
		return;
	nextRequestFile = answer.nextRequest;
	if (answer.cells == null) 
		return;
	
	var cells = answer.cells;
	var title = answer.title;
	var instructions = answer.instructions;
	
	for (var v = 0; v < cells.length; v++) {
		var i = cells[v].i;
		var j = cells[v].j;
		var color = cells[v].color;
		var idPrefix = cells[v].gameField;
		
		if (color === "gray")
			toggleShip(i, j, idPrefix);
		else
			flipTile(i, j, idPrefix, color);
	}
	
	document.getElementById('instructions').innerHTML = instructions;
	document.getElementById('title').innerHTML = title;
	
	/*document.getElementById('remainingships').classList.remove('fadeinanim');
	document.getElementById('remainingships').innerHTML = remainingShipCode;
	document.getElementById('instructions').classList.remove('fadeinanim');
	document.getElementById('instructions').innerHTML = FIRST_INSTRUCTIONS_TEXT;
	
	if (answer.allShipsPlaced) {
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
	}*/
}

function reset() {
	//resumeSessionAjaxRequest();
	$.post( "ajax.php", {reset:"true" }); // a bit hacky, but this function will not be in production anyway
}
