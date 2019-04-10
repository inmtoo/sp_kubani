<?php

	class Store {
		

		public function userorders( $args ) {
		
                    if( empty($args['limit']) ) {
                        $phrase_lim = 'LIMIT 20';
                    } else {
                        $phrase_lim = 'LIMIT '.$args['limit'];
                    }
                    
                    if( empty($args['offset']) ) {
                        $phrase_ofs = 'OFFSET 0';
                    } else {
                        $phrase_ofs = 'OFFSET '.$args['offset'];
                    }
		//История заказов
                    if ( $args['user_id'] > 0 ) {
                        $query = "SELECT * FROM `sp_orders` WHERE `user_id` = {$args['user_id']} ".$phrase_lim." ".$phrase_ofs;
                        $orders = Database::difQuery($query);
                        for($i = 0; $i < count($orders); $i++) {
                            $orders[$i]['sum'] = Store::ordersum($orders[$i]['id']);
                        }
                        return $orders;
                        //return $query;
                    }
                   
		}
		
		
		public function orderinfo( $array ) {
		
                   $keys = array_keys($array);
			$values = array();
			for ( $i = 0; $i , $i < count( $keys ); $i++ ) {
			
				$values[$i] = "`".$keys[$i]."` = '".$array[$keys[$i]]."'";
			
			}
			
                    $parametrs = implode(' AND ', $values);
                    
                    if ( !empty($array) ) {
                        $conditions = 'WHERE '.$parametrs;
                    }
                    
                    //$query = "SELECT * FROM `sp_order_positions` ".$conditions;
                    $query = "
                        SELECT
                        `sp_order_positions`.`name` as `name`,
                        `sp_order_positions`.`artno` as `artno`,
                        `sp_order_positions`.`manufacture` as `manufacture`,
                        `sp_order_positions`.`cost_price` as `cost_price`,
                        `sp_order_positions`.`price` as `price`,
                        `sp_order_positions`.`markup` as `markup`,
                        `sp_order_positions`.`delivery_charge` as `delivery_charge`,
                        `sp_order_positions`.`qnt` as `qnt`,
                        `sp_order_positions`.`order_id` as `order_id`,
                        `sp_order_positions`.`request_provider_id`,
                        `sp_order_positions`.`balance` as `balance`,
                        `sp_order_positions`.`status_id` as `status_id`,
                        `sp_statuses`.`name` as `status`
                        FROM `sp_order_positions` 
                        INNER JOIN `sp_statuses` ON `sp_statuses`.`id`= `sp_order_positions`.`status_id`
                    ".$conditions;;
                    return Database::difQuery($query);
                    //return $query;
                   
		}
		
		public function ordersum($order_id) {
                    $positions = Database::difQuery(
                        "SELECT `price`, `qnt` FROM `sp_order_positions` WHERE `order_id` = {$order_id}"
                    );
                    $sum = 0;
                    for ($i = 0; $i < count($positions); $i++) {
                        $sum = $sum + $positions[$i]['price'] * $positions[$i]['qnt'];
                    }
                    
                    return $sum;
                    //return 'sdfdsf';
                    
		}
		
		
		public function order_info_to_pay( $order_id ) {
                    $order = Database::difQuery("
                        SELECT `id`, `date`, `time`, `user_id` FROM `sp_orders` WHERE `id` = {$order_id}
                    ");
                    $return['order'] = $order[0];
                    $return['positions'] = Database::difQuery(
                    "
                        SELECT
                        `sp_order_positions`.`artno` as `artno`,
                        `sp_order_positions`.`name` as `name`,
                        `sp_order_positions`.`manufacture` as `manufacture`,
                        `sp_order_positions`.`price` as `price`,
                        `sp_order_positions`.`qnt` as `qnt`
                        FROM `sp_order_positions` WHERE `order_id` = {$order_id}
                    "
                    );
                    $return['sum'] = Store::ordersum($order_id);
                    return $return;
		}
		
		
		public function get_orders( $args ) {
                    if( empty($args['limit']) ) {
                        $phrase_lim = 'LIMIT 50';
                    } else {
                        $phrase_lim = 'LIMIT '.$args['limit'];
                    }
                    
                    if( empty($args['offset']) ) {
                        $phrase_ofs = 'OFFSET 0';
                    } else {
                        $phrase_ofs = 'OFFSET '.$args['offset'];
                    }
                    
                        $keys = array_keys($args['filter']);
			$values = array();
			for ( $i = 0; $i , $i < count( $keys ); $i++ ) {
			
				$values[$i] = "`sp_orders`.`".$keys[$i]."` LIKE '%".$args['filter'][$keys[$i]]."%'";
			
			}
			
			$return = implode(' OR ', $values);
			
			if (!empty($return)) {
				$filter = 'WHERE '.$return;
			}
                    
                   // $query = "SELECT * FROM `sp_orders` {$filter} ORDER BY `id` DESC ".$phrase_lim." ".$phrase_ofs;
                    $query = "
                        SELECT 
                        `sp_orders`.`id` as `id`,
                        `sp_orders`.`date` as `date`,
                        `sp_orders`.`time` as `time`,
                        `sp_orders`.`user_id` as `user_id`,
                        `sp_orders`.`first_name` as `first_name`,
                        `sp_orders`.`last_name` as `last_name`,
                        `sp_orders`.`phone` as `phone`,
                        `birzha_users`.`login` as `login`,
                        `city`.`name` as `city_name`,
                        `sp_tradepoints`.`name` as `tradepoint_name`
                        FROM `sp_orders` 
                        INNER JOIN `birzha_users` ON `birzha_users`.`id` = `sp_orders`.`user_id` 
                        INNER JOIN `city` ON `city`.`id_city` = `sp_orders`.`id_city`
                        INNER JOIN `sp_tradepoints` ON `sp_tradepoints`.`id` = `sp_orders`.`tradepoint_id`
                        
                        
                        {$filter} ORDER BY `id` DESC ".$phrase_lim." ".$phrase_ofs;
                    
                    return Database::difQuery($query);
                    
                    //return $query;
                    
		}
		
		
		public function OrderFullInfo($order_id) {
                    
                    $order_arr = Database::difQuery(
                        "
                            SELECT
                            `sp_orders`.`tradepoint_id` as `tradepoint_id`,
                            `sp_orders`.`user_id` as `user_id`,
                            `sp_orders`.`last_name` as `last_name`,
                            `sp_orders`.`first_name` as `first_name`,
                            `sp_orders`.`phone` as `phone`,
                            `sp_orders`.`email` as `email`,
                            `sp_orders`.`date` as `date`,
                            `sp_orders`.`time` as `time`,
                            `sp_orders`.`id_region` as `id_region`,
                            `sp_orders`.`id_city` as `id_city`,
                            `region`.`name` as `region`,
                            `city`.`name` as `city`,
                            `sp_managers`.`sirname` as `manager_sirname`,
                            `sp_managers`.`name` as `manager_sirname`,
                            `sp_managers`.`fathername` as `manager_fathername`,
                            `sp_tradepoints`.`name` as `tradepoint_name`
                            FROM `sp_orders` 
                            INNER JOIN `region` ON `region`.`id_region` = `sp_orders`.`id_region` 
                            INNER JOIN `city` ON `city`.`id_city` = `sp_orders`.`id_city`
                            INNER JOIN `sp_managers` ON `sp_managers`.`id` = `sp_orders`.`manager_id`
                            INNER JOIN `sp_tradepoints` ON `sp_tradepoints`.`id` = `sp_orders`.`tradepoint_id`
                            WHERE `sp_orders`.`id` = {$order_id}
                        "
                    );
                    $return['order'] = $order_arr[0];
                    
                    $return['positions'] = Database::difQuery(
                        "
                            SELECT 
                            `sp_order_positions`.`id` as `id`,
                            `sp_order_positions`.`name` as `name`,
                            `sp_order_positions`.`artno` as `artno`,
                            `sp_order_positions`.`manufacture` as `manufacture`,
                            `sp_order_positions`.`price` as `price`,
                            `sp_order_positions`.`cost_price` as `cost_price`,
                            `sp_order_positions`.`balance` as `balance`,
                            `sp_order_positions`.`comment` as `comment`,
                            `sp_order_positions`.`provider_id` as `provider_id`,
                            `sp_order_positions`.`qnt` as `qnt`,
                            `sp_order_positions`.`position_cat_id` as `position_cat_id`,
                            `sp_order_positions`.`position_price_id` as `position_price_id`,
                            `sp_order_positions`.`status_id` as `status_id`,
                            `sp_providers`.`name` as `provider_name`,
                            `sp_statuses`.`name` as `status_name`
                            FROM `sp_order_positions` 
                            INNER JOIN `sp_providers` ON `sp_providers`.`id` = `sp_order_positions`.`provider_id`
                            INNER JOIN `sp_statuses` ON `sp_statuses`.`id` = `sp_order_positions`.`status_id`
                            WHERE `sp_order_positions`.`order_id` = {$order_id}
                        "
                    );
                    return $return;
                    
		}
		
		public function orders_positions($args) {
                    //Разбить $args['filter'] на группы и прикрепить к каждому INNER JOIN ON
                    $query  = "
                        SELECT
                        `sp_order_positions`.`id` as `position_id`,
                        `sp_order_positions`.`name` as `position_name`,
                        `sp_order_positions`.`artno` as `artno`,
                        `sp_order_positions`.`price` as `price`,
                        `sp_order_positions`.`cost_price` as `cost_price`,
                        `sp_order_positions`.`qnt` as `qnt`,
                        `sp_order_positions`.`provider_id` as `provider_id`,
                        `sp_order_positions`.`order_id` as `order_id`,
                        `sp_order_positions`.`manufacture_id` as `manufacture_id`,
                        `sp_order_positions`.`balance` as `balance`,
                        `sp_order_positions`.`status_id` as `status_id`,
                        `sp_statuses`.`name` as `status_name`,
                        `sp_orders`.`user_id` as `user_id`,
                        `birzha_users`.`login` as `login`,
                        `birzha_users`.`first_name` as `first_name`,
                        `birzha_users`.`last_name` as `last_name`,
                        `birzha_users`.`phone` as `phone`,
                        `birzha_users`.`email` as `email`,
                        `birzha_users`.`login` as `login`,
                        `sp_providers`.`name` as `provider_name`
                                                
                        FROM `sp_order_positions`
                        INNER JOIN `sp_orders` ON `sp_orders`.`id` = `sp_order_positions`.`order_id` 
                        INNER JOIN `birzha_users` ON `birzha_users`.`id` = `sp_orders`.`user_id`
                        INNER JOIN `sp_providers` ON `sp_providers`.`id` = `sp_order_positions`.`provider_id`
                        INNER JOIN `sp_statuses` ON `sp_statuses`.`id` = `sp_order_positions`.`status_id`
                                                
                        ORDER BY  `sp_order_positions`.`id` DESC LIMIT {$args['limit']} OFFSET {$args['offset']}
                    ";
                    return Database::difQuery($query);
                    
		}
		
		public function save_positions($positions) {
                    for ($i = 0; $i < count($positions); $i++) {
                        $add = $positions[$i];
                        Database::update( 'sp_order_positions', $add, 'id', $add['id'] );
                    }
		}
		
		
		public function get_position($position_id) {
                    $position_arr = Database::difQuery(
                        "SELECT * FROM `sp_order_positions` WHERE `id` = {$position_id} "
                    );
                    return $position_arr[0];
		}
		
		public function changeStatus($table, $positions_arr, $status_id) { //меняем статус в таблицах //Сделать функцию для одной позиции и смену нескольких позиций отдельной функцией, использующую эту
                    $add['status_id'] = $status_id;
                    for ( $i = 0; $i < count( $positions_arr); $i++ ) {
                       Database::update($table, $add, 'id', $positions_arr[$i]);
                       //Сделать запись в историю смены статусов
                    }
		}
		
		
		public function get_balance_by_position_id($position_id) {
                    $array_info = Database::difQuery(
                        "SELECT 
                        `sp_order_positions`.`id` as `position_id`,
                        `sp_order_positions`.`balance` as `position_balance`,
                        `sp_order_positions`.`price` as `position_price`,
                        `sp_order_positions`.`qnt` as `position_qnt`,
                        `sp_order_positions`.`order_id` as `order_id`,
                        `sp_orders`.`user_id` as `user_id`,
                        `sp_users_balance`.`user_balance` as `user_balance`
                        FROM `sp_order_positions` 
                        INNER JOIN `sp_orders` ON `sp_orders`.`id` = `sp_order_positions`.`order_id` 
                        INNER JOIN `sp_users_balance` ON `sp_users_balance`.`user_id` = `sp_orders`.`user_id`
                        WHERE `sp_order_positions`.`id` = {$position_id}
                        "
                    );
                    return $array_info[0];
		}
		
		public function payments_off($position_id, $status_id) { //снимаем оплаты в таблицах
                    //Алгоритм: 1) выяснить по ID позиции ID пользователя и его баланс
                    //Выявить баланс на позиции
                    
                    $balance_by_position_id = Store::get_balance_by_position_id($position_id);
                    $update_balance['user_id'] = $balance_by_position_id['user_id'];
                    $update_balance['user_balance'] = $balance_by_position_id['position_balance'] + $balance_by_position_id['user_balance'];
                    Database::update('sp_users_balance', $update_balance, 'user_id', $balance_by_position_id['user_id']);
                    
                    $update_pos_balance['id'] = $position_id;
                    $update_pos_balance['balance'] = 0;
                    Database::update('sp_order_positions', $update_pos_balance, 'id', $position_id );
                    
                    //Сумму баланса позиции зачислить на баланс пользователя
                    //Вычесть из текущего баланса позиции эту сумму
                    //Записать в историю операций как зачисление на счет за счет снятия с позиции
		}
		
		public function payments_on($position_id, $status_id) { //Проводим оплаты в таблицах
                    //Алгоритм: 1) выяснить по ID позиции ID пользователя и его баланс
                    //Выявить баланс на позиции
                    $balance_by_position_id = Store::get_balance_by_position_id($position_id);
                    $different = $balance_by_position_id['price']*$balance_by_position_id['user_qnt'] - $balance_by_position_id['position_balance']; //недостающая сумма на позиции
                    
                    if( ($balance_by_position_id['user_balance'] * $balance_by_position_id['user_qnt']) >=  $different ) {
                        $update_balance['user_balance'] = $balance_by_position_id['user_balance'] - $different;
                        $update_pos_balance['balance'] = $balance_by_position_id['position_balance'] + $different;
                        $update_pos_balance['id'] = $position_id;
                        $update_balance['user_id'] = $balance_by_position_id['user_id'];
                        Database::update('sp_users_balance', $update_balance, 'user_id', $balance_by_position_id['user_id']);
                        Database::update('sp_order_positions', $update_pos_balance, 'id', $position_id );
                    } elseif ( $balance_by_position_id['user_balance'] <  $different ) {
                        $update_pos_balance['balance'] = $balance_by_position_id['position_balance'] + $balance_by_position_id['user_balance'];
                        $update_balance['user_balance'] = 0;
                        $update_pos_balance['id'] = $position_id;
                        $update_balance['user_id'] = $balance_by_position_id['user_id'];
                        Database::update('sp_users_balance', $update_balance, 'user_id', $balance_by_position_id['user_id']);
                        Database::update('sp_order_positions', $update_pos_balance, 'id', $position_id );
                    }
                    
                    //Выявить недостающю сумму на балансе позиции
                    //Если сумма на балансе пользователя меньше, чем недостающая сумма. то проводим всю сумму пользователя
                    //Если сумма на балансе пользователя больше, чем недостяющая сумма, то проводим всю недостающую сумму
                    //Результат операции записисываем в историю
                    

		}
		
		public function providers_list($page, $limit) {
		
                    $offset = $page * $limit - $limit;
                    $query = "
                        SELECT 
                        `sp_providers`.`id` as `id`,
                        `sp_providers`.`phone` as `phone`,
                        `sp_providers`.`name` as `name`,
                        `sp_providers`.`email` as `email`,
                        `sp_providers_groups`.`name` as `group`
                        FROM `sp_providers` INNER JOIN `sp_providers_groups` ON `sp_providers_groups`.`id` = `sp_providers`.`group_id` 
                        LIMIT {$limit} OFFSET {$offset}
                       
                    ";
                    return Database::difQuery($query);
                   //return $page;
		
		}
		
		public function statuses() {
                    return Database::SelectFrom('sp_statuses', '*');
		}
		
		public function sendconfirmation($provider_request_id) {
		
                    $query = "
                        SELECT 
                        `birzha_users`.`email` as `email`,
                        `birzha_users`.`first_name` as `first_name`,
                        `birzha_users`.`last_name` as `last_name`
                        FROM `birzha_users` 
                        INNER JOIN `sp_order_positions` ON `sp_order_positions`.`request_provider_id` = {$provider_request_id} 
                        INNER JOIN `sp_orders` ON `sp_orders`.`id` = `sp_order_positions`.`order_id` 
                        WHERE `birzha_users`.`id` = `sp_orders`.`user_id`
                    ";
                    $users = Database::difQuery($query);
                    
                    foreach ( $users as $user ) {
                        
                                $to = $user['email'];
                               // $subject = 'Тестируем отправку';
                       
				// содержание письма
				$subject = "Совместная закупка {$provider_request_id} сформирована";
				$message = '
				<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>Закупка № '.$provider_request_id.' успешно софрмирована </title>
				</head>
				<body>
					<p>Мы перессчитали заказ с учетом стоимости доставки и количества участников. Вы можете оплатить закупку в личном кабинете по следующей ссылке: <a href="http://sp-kubani.inmtoo.com/frontend/provider_requests/'.$provider_request_id.'/">http://sp-kubani.inmtoo.com/frontend/provider_requests/'.$provider_request_id.'/</a>.</p>
				</body>
				</html>';
                                $headers = 'MIME-Version: 1.0' . "\r\n".
                                    'Content-type: text/html; charset=utf-8'. "\r\n".
                                    'From: info@inmtoo.com' . "\r\n" .
                                    'Reply-To: info@inmtoo.com' . "\r\n" .
                                    'X-Mailer: PHP/' . phpversion();

                                mail($to, $subject, $message, $headers);
                    
                    }
		}
		
	
	}

	
 ?>
