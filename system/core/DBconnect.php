<?php
	class DBconnect {
	
	
	public function db1() {
	
		$link = new mysqli('localhost', 'myzaprosru_sp', '123qweznoxiu', 'myzaprosru_sp') ;
		$link->set_charset("utf8");
		return $link;
	
	}
	
	
	}
?>
