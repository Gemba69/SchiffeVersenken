function addMouseDownClassToCell(i, j) {
	document.getElementById("cell_" + i + "_" + j).classList.add("mouse_down");
}

function removeMouseDownClassFromCell(i, j) {
	document.getElementById("cell_" + i + "_" + j).classList.remove('mouse_down');
}

function flipTile(i, j) {
	var tile = document.getElementById("cell_" + i + "_" + j);
	tile.classList.add("flipToRed");
}

function flipTileAndWait(i, j) {
	flipTile(i, j);
}

function writeFuckYou() {
	//F
	flipTileAndWait(0, 0);
	flipTileAndWait(1, 0);
	flipTileAndWait(2, 0);
	flipTileAndWait(3, 0);
	flipTileAndWait(4, 0);
	flipTileAndWait(0, 1);
	flipTileAndWait(0, 2);
	flipTileAndWait(2, 1);
	
	//U
	flipTileAndWait(0, 4);
	flipTileAndWait(1, 4);
	flipTileAndWait(2, 4);
	flipTileAndWait(3, 4);
	flipTileAndWait(4, 4);
	flipTileAndWait(4, 5);
	flipTileAndWait(4, 6);
	flipTileAndWait(3, 6);
	flipTileAndWait(2, 6);
	flipTileAndWait(1, 6);
	flipTileAndWait(0, 6);
	
	//C
	flipTileAndWait(0, 10);
	flipTileAndWait(0, 9);
	flipTileAndWait(0, 8);
	flipTileAndWait(1, 8);
	flipTileAndWait(2, 8);
	flipTileAndWait(3, 8);
	flipTileAndWait(4, 8);
	flipTileAndWait(4, 9);
	flipTileAndWait(4, 10);
	
	//K
	flipTileAndWait(0, 12);
	flipTileAndWait(1, 12);
	flipTileAndWait(2, 12);
	flipTileAndWait(3, 12);
	flipTileAndWait(4, 12);
	flipTileAndWait(2, 13);
	flipTileAndWait(0, 14);
	flipTileAndWait(1, 14);
	flipTileAndWait(3, 14);
	flipTileAndWait(4, 14);
	
	//Y
	flipTileAndWait(0, 18);
	flipTileAndWait(1, 18);
	flipTileAndWait(2, 18);
	flipTileAndWait(2, 19);
	flipTileAndWait(3, 19);
	flipTileAndWait(4, 19);
	flipTileAndWait(0, 20);
	flipTileAndWait(1, 20);
	flipTileAndWait(2, 20);
	
	//O
	flipTileAndWait(0, 22);
	flipTileAndWait(1, 22);
	flipTileAndWait(2, 22);
	flipTileAndWait(3, 22);
	flipTileAndWait(4, 22);
	flipTileAndWait(4, 23);
	flipTileAndWait(4, 24);
	flipTileAndWait(3, 24);
	flipTileAndWait(2, 24);
	flipTileAndWait(1, 24);
	flipTileAndWait(0, 24);
	flipTileAndWait(0, 23);
	
	//U
	flipTileAndWait(0, 26);
	flipTileAndWait(1, 26);
	flipTileAndWait(2, 26);
	flipTileAndWait(3, 26);
	flipTileAndWait(4, 26);
	flipTileAndWait(4, 27);
	flipTileAndWait(4, 28);
	flipTileAndWait(3, 28);
	flipTileAndWait(2, 28);
	flipTileAndWait(1, 28);
	flipTileAndWait(0, 28);
	
}