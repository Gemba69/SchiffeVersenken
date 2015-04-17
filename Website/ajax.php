<?php 
	define('ENEMY_ID_PREFIX', "enemy");
	define('SELF_ID_PREFIX', "self");
	define('WATER_ID', "WASSER");
	define('SHIP_ID', "SCHIFF");
	define('MISS_ID', "MISS");
	define('HIT_ID', "TREFFER");
	define('DESTROYED_ID', "VERSENKT");
	
	session_start();  
	if(!isset($_SESSION['gameState']))
		startNewSession();
	
	processClick();
	
	function startNewSession() {
		$_SESSION['gameState'] = 0;
		$_SESSION['gameFieldSelf'] = array();
		$_SESSION['gameFieldEnemy'] = array();
		
		initializeOrFetchGame($_SESSION['gameFieldSelf'], $_SESSION['gameFieldEnemy']);
	}
		
	function initializeOrFetchGame($g1, $g2) {
		for ($i = 0; $i < 10; $i++) { //TODO: feldgroesse dynamisch machen
            for ($j = 0; $j < 100; $j++) {
                $g1[$i][$j]= WATER_ID;
            }
        }
		for ($i = 0; $i < 10; $i++) { //TODO: feldgroesse dynamisch machen
            for ($j = 0; $j < 100; $j++) {
                $g2[$i][$j]= WATER_ID;
            }
        }
		//TODO: spiel aus datenbank holen
	}
	
	function processClick() {
		if ($_SESSION['gameState'] == 0) {		
			$i = $_POST['i'];
			$j = $_POST['j'];
			$idPrefix = $_POST['idPrefix'];
			$gameFieldSelf = $_SESSION['gameFieldSelf'];
			
			$post_data = array('i' => $i,
			'j' => $j,
			'color' => 'gray',
			'field' => $idPrefix);
			if ($idPrefix == ENEMY_ID_PREFIX) {
				$post_data['illegal'] = true;
			} else {
				$post_data['illegal'] = false;
				if ($gameFieldSelf[$i][$j] == SHIP_ID)
					$gameFieldSelf[$i][$j] = WATER_ID;
				else if ($gameFieldSelf[$i][$j] == WATER_ID)
					$gameFieldSelf[$i][$j] = SHIP_ID;
			}
			$post_data = json_encode($post_data);
			echo($post_data);
		} else {
			
		}
	}
	
		
	/*$post_data = array('item_type_id' => $item_type,
		'string_key' => $string_key,
		'string_value' => $string_value,
		'string_extra' => $string_extra,
		'is_public' => $public,
		'is_public_for_contacts' => $public_contacts);
		$post_data = json_encode(array('item' => $post_data));*/
?>