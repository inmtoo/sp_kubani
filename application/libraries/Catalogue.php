<?php

	class Catalogue {
	
		function addFromUrl($url) {
		
			//Добавить URL в базу
			$add1['url'] = $url;
			
			$checkURL = Database::getrows('sp_urls', 'id', 'url', $url);
			
			if (count($checkURL) == 0 ) {
			$urlArr = Catalogue::addIfnotInDB($table = 'sp_urls', $add = $add1, $parametr = 'url', $value = $url);
			$object = Parser::index($url);
			
			//Добавить продукт в базу
			if ( !empty($object['manufactury']) ) {
				$add2['manufacture'] = $add['manufacture'];
				$manufactureArr = Catalogue::addIfnotInDB($table = 'sp_manufacturies', $add = $add2, $parametr = 'manufactury', $value = $object['manufacture']);
			}
			
			$categories = Catalogue::makeCategoriesFromArray( $object['categories'] );
			
			
			$add3['name'] = $object['name'];
			$add3['cost_price'] = $object['cost_price'];
			$add3['price'] = round($object['cost_price'] * (1 + $object['markup']/100), 2);
			$add3['images'] = implode(';', $object['images']);
			$add3['url_id'] = $urlArr['id'];
			$add3['currency'] = $object['currency'];
			$add3['min_order'] = $object['min_order'];
			$add3['manufacture_id'] = $manufactureArr['id'];
			$add3['date'] = date('Y-m-d');
			$add3['time'] = date('H:i:s');
			$add3['category_id'] = $categories[(count($categories)-1)];
			$add3['provider_id'] = $object['provider_id'];
			
			Catalogue::addIfnotInDB($table = 'sp_products', $add = $add3, $parametr = 'url_id', $value = $add3['url_id'], 'update');
			}
			
			$product = Database::getrow($table = 'sp_products', $fields = '*', $parametr = 'url_id', $value = $add3['url_id'], 0);
			
			$product['rels'] = $categories;
			
			Catalogue::dinamicCategoryProductRel($categories, $product['id']);
			
			if ( $object['provider_id'] == 2 ) {
                            //Костыль, добавляем характеристики, потом как-то надо оптимизировать
                            if( !empty($object['characteristic']['color']) ) { //Добавляем информацию о ццвете
                                $color['product_id'] = $product['id'];
                                $color['value'] = $object['characteristic']['color'];
                                $color['characteristic_id'] = 3;
                                Database::insert('sp_characteristics', $color);
                            }
                            
                            if( !empty($object['characteristic']['country']) ) { //Добавляем информацию о стране происхождения
                                $country['product_id'] = $product['id'];
                                $country['value'] = $object['characteristic']['country'];
                                $country['characteristic_id'] = 1;
                                Database::insert('sp_characteristics', $country); 
                            }
                            
                            if( !empty($object['characteristic']['sostav']) ) { //Добавляем информацию о стране происхождения
                                $sostav['product_id'] = $product['id'];
                                $sostav['value'] = $object['characteristic']['sostav'];
                                $sostav['characteristic_id'] = 3;
                                Database::insert('sp_characteristics', $sostav); 
                            }
                            
                            if( count($object['characteristic']['sizes']) > 0 ) { //Добавляем информацию о стране происхождения
                                for ($i = 0; $i <count($object['characteristic']['sizes']); $i++) {
                                    $sizes[$i]['product_id'] = $product['id'];
                                    $sizes[$i]['value'] = $object['characteristic']['sizes'][$i];
                                    $sizes[$i]['characteristic_id'] = 4;
                                    Database::insert('sp_characteristics', $sizes[$i]); 
                                }
                            }
                        
                        }
			
			return $product;
			//return $sostav;

		}
		
		function makeCategoriesFromArray( $array ) { // создаем категории из массива
			
			$parentID = 0;
			//$return[0] = TheModel::DinamicCategoryAdd($array[0], 0);
			
			for( $i = 0; $i < count($array); $i++ ) {
				$return[$i] = Catalogue::DinamicCategoryAdd($array[$i], $parentID);
				$parentID = $return[$i];
			}
			
			return $return;
		
		}
		
		function dinamicCategoryProductRel( $categoriesArray, $productID ) { 
		//Записываем, к каким категориям оносится товар
			for ( $i = 0; $i < count($categoriesArray); $i++ ) {
				$check[$i] = Database::difQuery("
				
				SELECT * FROM `sp_products_to_categories` 
				WHERE `category_id` = {$categoriesArray[$i]} AND 
				`product_id` = {$productID}
				");
				
				if ( count($check[$i]) == 0 ) {
					$add[$i]['category_id'] = $categoriesArray[$i];
					$add[$i]['product_id'] = $productID;
					Database::insert( $table = 'sp_products_to_categories', $add[$i] );
				}
			}
		}
		
		public function categoriesTree() {
		
			
				return Database::difQuery("
					SELECT `id`, `name` FROM `sp_categories` WHERE `parent_id` = 0;
				");
			
		}
		
		public function lastproducts() {
			$lastproducts = Database::difQuery("
				SELECT * FROM `sp_products` ORDER BY `id` DESC LIMIT 20;
			");
			for ( $i = 0; $i < count($lastproducts); $i++ ) {
				$images[$i] = explode(';', $lastproducts[$i]['images']);
				$lastproducts[$i]['preview'] = $images[$i][0];
			}
			return $lastproducts;
		}
		
		public function products_list($args) {
                    
                    if( !empty($args['filter']['categories_id']) ) {
                        $categories = explode(',', $args['filter']['categories_id']);
                        
                        for ( $i = 0; $i = count($categories); $i++ ) {
                            $conditions[$i] = "'category_id' = {$i} ";
                        }
                        
                        $conditions = implode(' OR ', $conditions);
                        $conditions = "WHERE ".$conditions;
                    }
                    
                    $query = "
                        SELECT
                        `sp_products`.`id` as `id`,
                        `sp_products`.`name` as `name`,
                        `sp_products`.`artno` as `artno`,
                        `sp_products`.`cost_price` as `cost_price`,
                        `sp_products`.`min_order` as `min_order`,
                        `sp_products`.`images` as `images`,
                        `sp_products`.`provider_id` as `provider_id`,
                        `sp_providers`.`name` as `provider`,
                        `sp_providers`.`markup` as `markup` 
                        FROM `sp_products` 
                        INNER JOIN `sp_providers` ON `sp_providers`.`id` = `sp_products`.`provider_id` 
                        LIMIT {$args['limit']} OFFSET {$args['offset']}
                    ";
                    
                    $lastproducts = Database::difQuery($query);
                    
                    for ( $i = 0; $i < count($lastproducts); $i++ ) {
				$images[$i] = explode(';', $lastproducts[$i]['images']);
				$lastproducts[$i]['preview'] = $images[$i][0];
                    }
                    
                    return $lastproducts;
                    //return $query;
		}
		
		
		public function category($category_id, $args) {
                    //Переделать эту функцию, чтобы выводились товары из дочерних документов
                    $return['category'] = Database::getrow('sp_categories', '*', 'id', $category_id, 0);
                    $return['dauther'] = Database::getrows('sp_categories', '*', 'parent_id', $category_id);
                    /*
                    $dauther[0] = Database::getrow('sp_categories', 'id, name', 'parent_id', $category_id, 0);
                    $i = 1;
                    while( count($dauther[$i]) == 0 ) {
                        $dauther[$i] = Database::getrow('sp_categories', 'id, name', 'parent_id', $dauther[$i - 1]['id'], 0);
                    }
                    $return['dauther-list'] = $dauther;
                    */
                    for($k = 0; $k < count($return['dauther']); $k++) {
                        $and .=  'OR `category_id` = '.$return['dauther'][$k]['id'].' ';
                    }
                    
                    $return['products'] = Database::difQuery("SELECT * FROM `sp_products` WHERE `category_id` = {$category_id} ".$and);
                    $args['limit'] = 50;
                    $args['offset'] = 0;
                    $query = "
                        SELECT
                        `sp_products`.`id` as `id`,
                        `sp_products`.`currency` as `currency`,
                        `sp_products`.`name` as `name`,
                        `sp_products`.`artno` as `artno`,
                        `sp_products`.`cost_price` as `cost_price`,
                        `sp_products`.`min_order` as `min_order`,
                        `sp_products`.`images` as `images`,
                        `sp_products`.`provider_id` as `provider_id`,
                        `sp_providers`.`name` as `provider`,
                        `sp_providers`.`markup` as `markup` 
                        FROM `sp_products` 
                        INNER JOIN `sp_providers` ON `sp_providers`.`id` = `sp_products`.`provider_id` 
                        WHERE `category_id` = {$category_id} ".$and." 
                        LIMIT {$args['limit']} OFFSET {$args['offset']}
                    ";
                    
                    $return['products'] = Database::difQuery($query);
                    for ( $i = 0; $i < count($return['products']); $i++ ) {
				$images[$i] = explode(';', $return['products'][$i]['images']);
				$return['products'][$i]['preview'] = $images[$i][0];
			}
                   
                    return $return;
		}
		
		public function searchproduct($productname) {
                    $return['products'] = Database::difQuery("SELECT * FROM `sp_products` WHERE `name` LIKE '%{$productname}%'");
                    for ( $i = 0; $i < count($return); $i++ ) {
				$images[$i] = explode(';', $return['products'][$i]['images']);
				$return['products'][$i]['preview'] = $images[$i][0];
                    }
                    return $return['products'];
                    //return "SELECT * FROM `sp_products` WHERE `name` LIKE '%{$productname}%'";
		}
		
		/*
		
		Функции модели. Сюда перенесены функции из модели, чтобы библиотека была самоостоточной
		
		*/
		
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
		
		
		function product($product_id) {
                    $query = "
                        SELECT 
                        `sp_products`.`id` as `id`,
                        `sp_products`.`name` as `name`,
                        `sp_products`.`artno` as `artno`,
                        `sp_products`.`manufacture_id` as `manufacture_id`,
                        `sp_products`.`cost_price` as `cost_price`,
                        `sp_products`.`price` as `price`,
                        `sp_products`.`images` as `images`,
                        `sp_products`.`min_order` as `min_order`,
                        `sp_products`.`description` as `description`,
                        `sp_products`.`provider_id` as `provider_id`,
                        `sp_products`.`title` as `title`,
                        `sp_products`.`keywords` as `keywords`,
                        `sp_providers`.`markup` as `markup`
                        FROM `sp_products` 
                        INNER JOIN `sp_providers` ON `sp_providers`.`id` = `sp_products`.`provider_id`
                        WHERE `sp_products`.`id` = {$product_id}
                        
                    ";
                    
                    $return = Database::difQuery($query);
                    $row = Database::difQuery("SELECT `id` FROM `sp_order_positions` WHERE `position_cat_id` = {$product_id} AND `status_id` = 1"); //узнаем, сколько этой позиции заказано в статусе "заказ принят"
                    $return[0]['row'] = count($row);
                    return $return[0];
		}
		
		
		public function get_chatacteristics($product_id) {
                    
                    $query = "
                        SELECT 
                        `sp_characteristics`.`id` as `id`,
                        `sp_characteristics`.`characteristic_id` as `characteristic_id`,
                        `sp_characteristics`.`value` as `value`,
                        `sp_characteristics_types`.`name` as `characteristic_name`,
                        `sp_characteristics_types`.`optional` as `optional`
                        FROM `sp_characteristics`
                        INNER JOIN `sp_characteristics_types` ON `sp_characteristics_types`.`id` = `sp_characteristics`.`characteristic_id`
                        WHERE `product_id` = {$product_id}
                    
                    ";
                    
                    return Database::difQuery($query);
                    //return($query);
		
		}
		
		
		public function get_characterisitcs_id_list ($characteristics) {
                    
                    $characteristics = explode(',', $characteristics);
                    
                    for ( $i = 0; $i < count($characteristics); $i++ ) {
                    
                        $return[$i] = Database::difQuery(
                            "
                                SELECT 
                                `sp_characteristics`.`id` as `id`,
                                `sp_characteristics`.`characteristic_id` as `characteristic_id`,
                                `sp_characteristics`.`value` as `value`,
                                `sp_characteristics_types`.`name` as `characteristic_name`,
                                `sp_characteristics_types`.`optional` as `optional`
                                FROM `sp_characteristics`
                                INNER JOIN `sp_characteristics_types` ON `sp_characteristics_types`.`id` = `sp_characteristics`.`characteristic_id`
                                WHERE `sp_characteristics`.`id` = {$characteristics[$i]}
                            "
                        );
                    
                    }
                    
                    return $return;
                    
		}
		
		
		public function get_categories($categories) {
                    $array  = explode(',', $categories);
                    $conditions = "`id` = {$array[0]} ";
                    for ($i = 1; $i < count($array); $i++ ) {
                        $conditions = $conditions."OR `id` = {$array[$i]} ";
                    }
                    $query = "SELECT * from `sp_categories` WHERE ".$conditions;
                    return Database::difQuery($query);
		}
		
		public function get_products($products) {
                    $array  = explode(',', $products);
                    $conditions = "`id` = {$array[0]} ";
                    for ($i = 1; $i < count($array); $i++ ) {
                        $conditions = $conditions."OR `id` = {$array[$i]} ";
                    }
                    $query = "SELECT * from `sp_products` WHERE ".$conditions;
                    $products = Database::difQuery($query);
                    for($k = 0; $k < count ($products); $k++) {
                        $product[$k]['images'] = implode(',', $product[$k]['images']);
                    }
                    return $products;
		}
		
		public function category_list () {
                    return Database::difQuery("SELECT * FROM `sp_categories`"); // сделать древовидную структуру
                    /*
                        РЕЦЕПТ:
                       собрать в массив категории верхнего уровня, а потом пройтись по каждому элементу. собрать нижнего уровня и т.п.
                    */
		}
	
	}
	
?>
