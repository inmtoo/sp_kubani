<?php

	class ShoppingCart {
		
		//Добавляем товар в корзину
		public function addToCart ( $add ) {
		
                        $checkProduct = Database::getrows($table = 'sp_products', $fields = 'id', $parametr = 'id', $value = $add['product_id'] );
			if ( !empty( $add['session_id'] ) && $add['product_id'] > 0 && $add['count'] > 0 && count($checkProduct) > 0 )
			{
				//Сделать проверку на сущестование товара
				$add['date'] = date('Y-m-d');
				$add['time'] = date('H:i:s');
				Database::insert('sp_shopping_carts', $add);
				//return $add;
			}
		}
		
		//Получаем данные о корзине по произвольным данным
 		public function cartinfo( $array ) {
			$keys = array_keys($array);
			$values = array();
			for ( $i = 0; $i , $i < count( $keys ); $i++ ) {
			
				$values[$i] = "`".$keys[$i]."` = '".$array[$keys[$i]]."'";
			
			}
			
			$return = implode(' AND ', $values);
			
			$query = "
			SELECT 
			`sp_shopping_carts`.`id` as `cart_id`,
			`sp_shopping_carts`.`session_id` as `session_id`, 
			`sp_shopping_carts`.`product_id` as `product_id`, 
			`sp_shopping_carts`.`count` as `count`,
			`sp_shopping_carts`.`comment` as `coment`,
			`sp_shopping_carts`.`characteristics` as `characteristics`,
			`sp_products`.`id` as `position_cat_id`, 
			`sp_products`.`name` as `name`, 
			`sp_products`.`artno` as `artno`, 
			`sp_products`.`price` as `price`,
			`sp_products`.`url_id` as `url_id`,
			`sp_products`.`cost_price` as `cost_price`,
			`sp_products`.`manufacture_id` as `manufacture_id`,
			`sp_products`.`provider_id` as `provider_id`,
			`sp_manufacturies`.`manufacture` as `manufacture`,
			`sp_providers`.`markup` as `markup`,
			`sp_providers`.`name` as `provider_name`
			FROM `sp_shopping_carts` 
			INNER JOIN `sp_products` ON `sp_products`.`id` = `sp_shopping_carts`.`product_id` 
			INNER JOIN `sp_providers` ON `sp_providers`.`id` = `sp_products`.`provider_id`
			LEFT JOIN `sp_manufacturies` ON `sp_manufacturies`.`id` = `sp_products`.`manufacture_id` 
			WHERE {$return}";
			
			$shopping_cart = Database::difQuery($query);
			
			for( $i = 0; $i < count($shopping_cart); $i++ ) {
                            $shopping_cart[$i]['charlistfull'] = Catalogue::get_characterisitcs_id_list ($shopping_cart[$i]['characteristics']);
			}
			
			return $shopping_cart;
			//return $query;
		}
		
		
		
		
		
		//Получаем информацию о корзине по массиву информации о сессии и пользователе
		public function info ($user) {
			
			if( $user['user']['id'] == 0 ) {
				$return = ShoppingCart::cartinfo(
					array(
						'session_id' => $user['cookies_session_id']
					)
				);
			} else {
				if (count(ShoppingCart::cartinfo(array('user_id' => $user['user']['id']))) == 0) {
					$return = ShoppingCart::cartinfo(
					array(
						'session_id' => $user['cookies_session_id']
					)
					);
				} else {
				
					$return = ShoppingCart::cartinfo(
					array(
						'user_id' => $user['user']['id']
					)
					);
				}
				
				//return $return;
				
			
			}
			return $return;
		}
		
		public function sendconfirmation($array) {
				
				
			/*	// отправка нескольким адресатам
				$to  = $array['email']; // кому отправляем
				// не забываем запятую. Даже в последнем контакте лишней не будет
				// Для начинающих! $to .= точка в этом случае для Дописывания в переменную 
				
				
				if( !empty($array['token']) ) {
					$tokenMSG = '<p>Для подтверждения заказа пройдите по ссылке: 
					<a href="http::/sp-kubani.inmtoo.com/frontend/orderconfirmation/?token='.$array['token'].'" target="blank">http::/sp-kubani.inmtoo.com/frontend/orderconfirmation/?token='.$array['token'].'</a>
					</p>';
				}
				// содержание письма
				$subject = "Заказ № ".$array['id']." Подтверждение Заказа";
				$message = '
				<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>Заказ № '.$array['id'].'</title>
				</head>
				<body>
					<p>Благодарим Вас за оформление заказа.</p>
					'.$tokenMSG.'
				</body>
				</html>';

				// устанавливаем тип сообщения Content-type, если хотим
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= "Content-type: text/html; charset=utf-8 \r\n";

				// дополнительные данные
				$headers .= "From: SP-KUBANI <info@sp-kubani.inmtoo.com>\r\n"; // от кого
	
				mail($to, $subject, $message, $headers);*/
				
				$to      = $array['email'];
                               // $subject = 'Тестируем отправку';
                                if( !empty($array['token']) ) {
					$tokenMSG = '<p>Для подтверждения заказа пройдите по ссылке: 
					<a href="http::/sp-kubani.inmtoo.com/frontend/orderconfirmation/?token='.$array['token'].'" target="blank">http::/sp-kubani.inmtoo.com/frontend/orderconfirmation/?token='.$array['token'].'</a>
					</p>';
				}
				// содержание письма
				$subject = "Заказ № ".$array['id']." Подтверждение Заказа";
				$message = '
				<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>Заказ № '.$array['id'].'</title>
				</head>
				<body>
					<p>Благодарим Вас за оформление заказа.</p>
					'.$tokenMSG.'
				</body>
				</html>';
                                $headers = 'MIME-Version: 1.0' . "\r\n".
                                    'Content-type: text/html; charset=utf-8'. "\r\n".
                                    'From: info@inmtoo.com' . "\r\n" .
                                    'Reply-To: info@inmtoo.com' . "\r\n" .
                                    'X-Mailer: PHP/' . phpversion();

                                mail($to, $subject, $message, $headers);
			
		}
		
		
		public function expressorder( $add ) {
			
			$getuser = Database::getrow($table = 'birzha_users', $fields = '*', $parametr = 'email', $value = $add['email'], $rownum = 0 );
			
			if ( empty($getuser['login']) ) {
				$register['login'] = $add['email'];
				$register['email'] = $add['email'];
				$register['phone'] = $add['phone'];
				$register['password'] = $add['phone'];
				$register['first_name'] = $add['first_name'];
				$register['last_name'] = $add['last_name'];
				$register['group_id'] = $add['group_id'];
				$register['ip'] = $_SERVER['REMOTE_ADDR'];
				Authorization::registration( $register );
				$getuser = Database::getrow($table = 'birzha_users', $fields = '*', $parametr = 'email', $value = $add['email'], $rownum = 0 );
				$order['user_id'] = $getuser['id'];
				$order['token'] = md5(md5('RbT').md5($order['user_id'])).md5(date('Y-m-d'));
				
			} else {
				$order['user_id'] = $getuser['id'];
			}
				$order['first_name'] = $register['first_name'];
				$order['last_name'] = $register['last_name'];
				$order['phone'] = $add['phone'];
				$order['first_name'] = $add['first_name'];
				$order['last_name'] = $add['last_name'];
				$order['id_region'] = $add['id_region'];
				$order['id_city'] = $add['id_city'];
				$order['tradepoint_id'] = $add['tradepoint_id'];
				$order['email'] = $add['email'];
				$order['date'] = date('Y-m-d');
				$order['time'] = date('H:i:s');
				Database::insert('sp_orders', $order);
				
				$rquery = "
					SELECT * FROM `sp_orders` WHERE 
					`email` = '{$order['email']}' AND `date` = '{$order['date']}' AND `time` = '{$order['time']}'
				";
				$return_arr = Database::difQuery($rquery);
				$return = $return_arr[0];
				ShoppingCart::recordpositions( $add['cart-info'], $return['id'] );
				ShoppingCart::sendconfirmation($return);
				
				return $return;
				
				
		}
		
		/*public function getproviderbyurlid( $url_id ) { //Получаем ппоставщика по url_id
		
		}*/
		
		public function recordpositions ( $cart, $order_id ) {
                    
                    for ( $i = 0; $i < count($cart); $i++ ) {
                        $position['name'] = $cart[$i]['name'];
                        $position['artno'] = $cart[$i]['artno'];
                        $position['manufacture_id'] = $cart[$i]['manufacture_id'];
                        $position['price'] = round ( $cart[$i]['cost_price'] * (1 + $cart[$i]['markup'] / 100), 2 );
                        $position['cost_price'] = $cart[$i]['cost_price'];
                        $position['position_cat_id'] = $cart[$i]['position_cat_id'];
                        $position['manufacture'] = $cart[$i]['manufacture'];
                        $position['provider_id'] = $cart[$i]['provider_id'];
                        $position['comment'] = $cart[$i]['comment'];
                        $position['characteristics'] = $cart[$i]['characteristics'];
                        $position['status_id'] = 1;
                        $position['qnt'] = $cart[$i]['count'];
                        $position['order_id'] = $order_id;
                        Database::insert('sp_order_positions', $position);
                    }
                    
                    //Database::deletrow_where_param( $table = 'sp_shopping_carts', $parametr = 'session_id', $value = $cart[0]['session_id'] );
                    $query = "DELETE FROM `sp_shopping_carts` WHERE `session_id` = '{$cart[0]['session_id']}'";
                    Database::difQuery ($query);
                    //return $query;
		}
		
		
		
		public function test() {
                    echo 'Class ShoppingCart works';
		}
	
	}

?>
