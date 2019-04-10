<?php

	class TheModel {
	
		function addIfnotInDB($table, $add, $parametr, $value, $action) { //Если запись не содержится в таблице, то добавляем
			
			$check = Database::getrow($table, $fields = '*', $parametr, $value, 0);
			
			if ( count($check) == 0 ) {
				Database::insert($table, $add);
				$result = Database::getrow($table, $fields = '*', $parametr, $value, 0);
				return $result;
			} elseif ( $action == 'update' ) {
				Database::update( $table, $add, $parametr, $value );
				return $check;
			} else {
				return $check;
			}
			
		}
		
		
		function DinamicCategoryAdd ($category, $parentCategoryId) {
		
			$check = Database::difQuery("SELECT `id` FROM `sp_categories` WHERE `name` = '{$category}' AND `parent_id` = {$parentCategoryId} ");
			if ( count($check) > 0 ) {
				return $check[0]['id'];
			} elseif ( count( $check ) == 0 ) {
				$add['name'] = $category;
				$add['parent_id'] = $parentCategoryId;
				Database::insert('sp_categories', $add);
				$return = Database::difQuery("SELECT `id` FROM `sp_categories` WHERE `name` = '{$category}' AND `parent_id` = {$parentCategoryId} ");
				return $return[0]['id'];
			}
		}
		
		function product($productID) {
			$result = Database::getrow($table = 'sp_products', $fields = '*', $parametr = 'id', $value = $productID, 0);
			if ( empty($result['keywords']) ) {
				$result['keywords'] = $result['name'];
			}
			
			if ( empty($result['title']) ) {
				$result['title'] = $result['name'];
			}
			return $result;
		}
		
		public function users($args, $offset, $limit) {
			$keys = array_keys($args);
			$values = array();
			for ( $i = 0; $i , $i < count( $keys ); $i++ ) {
			
				$values[$i] = "`".$keys[$i]."` = '".$args[$keys[$i]]."'";
			
			}
			
			$return = implode(' AND ', $values);
			
			if (!empty($return)) {
				$filter = 'WHERE '.$return;
			}
			
			$query = "SELECT * FROM `birzha_users` WHERE {$return} LIMIT {$limit} OFFSET {$offset}";
			return Database::difQuery($query);
			//return $query;
		}
		
		function test() {
			return 'TheModel';
		}

	
	}

?>
