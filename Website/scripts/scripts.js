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
		url: 'PHP/ajax.php',
		data: { requestType: 'cellClicked', i: i, j: j, gameField: idPrefix },
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
		type: 'POST',
		url: 'PHP/ajax.php',
		dataType: 'html',
		data: { requestType: 'resumeSession' },
		success: function(data) {
			processAnswer(data);
		},
		error: function(data, a, b) {
			alert(data + a + b);
		}
	});
}

function nextPhaseAjaxRequest() {
	$.ajax({
		type: 'POST',
		url: 'PHP/ajax.php',
		dataType: 'html',
		data: { requestType: 'nextPhase' },
		success: function(data) {
			processAnswer(data);
		},
		error: function(data, a, b) {
			alert(data + a + b);
		}
	});
}

function resetAjaxRequest() {
	$.ajax({
		type: 'POST',
		url: 'PHP/ajax.php',
		dataType: 'html',
		data: { requestType: 'reset' },
		success: function(data) {
			//processAnswer(data);
		},
		error: function(data, a, b) {
			alert(data + a + b);
		}
	});
}

function sendAiComboAjaxRequest() {
	$.ajax({
		type: 'POST',
		url: 'PHP/ajax.php',
		dataType: 'html',
		data: { requestType: 'aiCombo' },
		success: function(data) {
			processAnswer(data);
		},
		error: function(data, a, b) {
			alert(data + a + b);
		}
	});
}

function processAnswer(answer) {
	//document.getElementById('infobox').innerHTML = answer; //debug
	alert("asdf");
	answer = $.parseJSON(answer);
	if (answer.illegal)
		return;
	if (answer.instructions != null)
		document.getElementById('instructions').innerHTML = answer.instructions;
	if (answer.title != null) 
		document.getElementById('title').innerHTML = answer.title;
	var cells = answer.cells;
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
	if (answer.sendAnotherRequest) 
		setTimeout(function() { sendAiComboAjaxRequest(); }, 500);

}

