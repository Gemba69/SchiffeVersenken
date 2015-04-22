var ENEMY_ID_PREFIX = "enemy";
var SELF_ID_PREFIX = "self";
var gamePhase = 0;

function addMouseDownClassToCell(i, j, idPrefix) {
	document.getElementById(idPrefix + "_cell_" + i + "_" + j).classList.add("mouse_down");
}

function removeMouseDownClassFromCell(i, j, idPrefix) {
	document.getElementById(idPrefix + "_cell_" + i + "_" + j).classList.remove('mouse_down');
}

function cellClicked(i, j, idPrefix) {
	/*if (gamePhase == 0 && idPrefix === SELF_ID_PREFIX) {
		toggleShip(i, j, idPrefix);
	} else if (gamePhase == 1 && idPrefix == ENEMY_ID_PREFIX) {
		
	} else {
		return;
	}*/

	cellClickedAjaxRequest(i, j, idPrefix);
}

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

function cellClickedAjaxRequest(i, j, idPrefix) {
	$.post( "ajax.php", { i: i, j: j, idPrefix: idPrefix })
	.done(function(data) {
		processCellClickedAnswer(data);
	});
}

function processCellClickedAnswer(answer) {
	//document.getElementById('infobox').innerHTML = answer;

	var ans = jQuery.parseJSON(answer);
	if (ans.illegal == true)
		return;
	var i = ans.i;
	var j = ans.j;
	var color = ans.color;
	var idPrefix = ans.field;
	var remainingShipCode = ans.remainingShipCode;
	
	if (color === "gray")
		toggleShip(i, j, idPrefix);
	else
		flipTile(i, j, idPrefix, color);
	
	document.getElementById('remainingships').innerHTML = remainingShipCode;
}

function reset() {
	$.post( "ajax.php", {reset:"true"})
	.done(function(data) {
		document.getElementById('infobox').innerHTML = data;
	});
}
