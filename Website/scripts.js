function addMouseDownClassToCell(i, j, idPrefix) {
	document.getElementById(idPrefix + "_cell_" + i + "_" + j).classList.add("mouse_down");
}

function removeMouseDownClassFromCell(i, j, idPrefix) {
	document.getElementById(idPrefix + "_cell_" + i + "_" + j).classList.remove('mouse_down');
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
