<?php
    
    class Vendors {
    
        public function get_vendor_stop_requests() {
            $current_date = date('Y-m-d');
            $return = Database::difQuery(
                "
                    SELECT 
                    `sp_providers_requests`.`id` as `request_id`,
                    `sp_providers_requests`.`provider_id` as `provider_id`,
                    `sp_providers_requests`.`name` as `request_name`,
                    `sp_providers_requests`.`stop_date` as `stop_date`,
                    `sp_providers_requests`.`delivery_date` as `delivery_date`,
                    `sp_providers_requests`.`status_id` as `status_id`,
                    `sp_providers_requests`.`sum` as `sum`,
                    `sp_providers`.`name` as `name`,
                    `sp_statuses`.`name` as `status_name`
                    FROM `sp_providers_requests` 
                    INNER JOIN `sp_providers` ON `sp_providers`.`id` = `sp_providers_requests`.`provider_id` 
                    INNER JOIN `sp_statuses` ON `sp_statuses`.`id` = `sp_providers_requests`.`status_id`
                    WHERE `sp_providers_requests`.`stop_date` = '{$current_date}'
                    
                "
            );
            
            for( $i = 0; $i < count($return); $i++ ) {
                if( $return[$i]['status_id'] == 1 ) {
                    $return[$i]['sums'] = Vendors::provider_current_request_sum($return[$i]['provider_id']);
                } else {
                    $return[$i]['sums'] = Vendors::provider_request_sum($return[$i]['provider_id'], $return[$i]['request_id']);
                }
            }
            
            return $return;
        }
        
        public function get_vendor_requests( $limit, $offset ) {
            $return = Database::difQuery(
                "
                    SELECT 
                    `sp_providers_requests`.`id` as `request_id`,
                    `sp_providers_requests`.`provider_id` as `provider_id`,
                    `sp_providers_requests`.`name` as `request_name`,
                    `sp_providers_requests`.`stop_date` as `stop_date`,
                    `sp_providers_requests`.`delivery_date` as `delivery_date`,
                    `sp_providers_requests`.`status_id` as `status_id`,
                    `sp_providers_requests`.`sum` as `sum`,
                    `sp_providers`.`name` as `name`,
                    `sp_statuses`.`name` as `status_name`
                    FROM `sp_providers_requests` 
                    INNER JOIN `sp_providers` ON `sp_providers`.`id` = `sp_providers_requests`.`provider_id` 
                    INNER JOIN `sp_statuses` ON `sp_statuses`.`id` = `sp_providers_requests`.`status_id`
                    LIMIT {$limit} offset {$offset}
                    
                "
            );
            
            for( $i = 0; $i < count($return); $i++ ) {
                if( $return[$i]['status_id'] == 1 ) {
                    $return[$i]['sums'] = Vendors::provider_current_request_sum($return[$i]['provider_id']);
                } else {
                    $return[$i]['sums'] = Vendors::provider_request_sum($return[$i]['provider_id'], $return[$i]['request_id']);
                }
            }
            
            return $return;
        }
        
        
        public function get_vendor_open_requests( $limit, $offset ) {
            $return = Database::difQuery(
                "
                    SELECT 
                    `sp_providers_requests`.`id` as `request_id`,
                    `sp_providers_requests`.`name` as `request_name`,
                    `sp_providers_requests`.`provider_id` as `provider_id`,
                    `sp_providers_requests`.`stop_date` as `stop_date`,
                    `sp_providers_requests`.`delivery_date` as `delivery_date`,
                    `sp_providers_requests`.`status_id` as `status_id`,
                    `sp_providers_requests`.`sum` as `sum`,
                    `sp_providers`.`name` as `name`,
                    `sp_statuses`.`name` as `status_name`
                    FROM `sp_providers_requests` 
                    INNER JOIN `sp_providers` ON `sp_providers`.`id` = `sp_providers_requests`.`provider_id` 
                    INNER JOIN `sp_statuses` ON `sp_statuses`.`id` = `sp_providers_requests`.`status_id`
                    WHERE `sp_providers_requests`.`status_id` = 1 
                    LIMIT {$limit} offset {$offset}
                    
                "
            );
            
            for( $i = 0; $i < count($return); $i++ ) {
                if( $return[$i]['status_id'] == 1 ) {
                    $return[$i]['sums'] = Vendors::provider_current_request_sum($return[$i]['provider_id']);
                } else {
                    $return[$i]['sums'] = Vendors::provider_request_sum($return[$i]['provider_id'], $return[$i]['request_id']);
                }
            }
            
            return $return;
        }
        
        public function provider_current_request_sum($provider_id) {
            $position = Database::difQuery(
                "
                    SELECT `id`, `price`, `cost_price`, `qnt` FROM `sp_order_positions` WHERE `provider_id` = {$provider_id} AND `status_id` = 1
                "
        );
            
            $return['sum_total'] = 0;
            $return['sum_cost'] = 0;
            for ($i =0; $i < count($position); $i++) {
                $return['sum_total'] = $return['sum_total'] + $position[$i]['qnt'] * $position[$i]['price'];
                $return['sum_cost'] = $return['sum_cost'] + $position[$i]['qnt'] * $position[$i]['cost_price'];
            }
            return $return;
        }
        
        public function provider_request_sum( $provider_id, $request_id ) {
            $position = Database::difQuery(
                "
                    SELECT `id`, `price`, `cost_price`, `qnt` FROM `sp_order_positions` WHERE `provider_id` = {$provider_id} AND `request_provider_id` = {$request_id}
                "
        );
            
            $return['sum_total'] = 0;
            $return['sum_cost'] = 0;
            for ($i =0; $i < count($position); $i++) {
                $return['sum_total'] = $return['sum_total'] + $position[$i]['qnt'] * $position[$i]['price'];
                $return['sum_cost'] = $return['sum_cost'] + $position[$i]['qnt'] * $position[$i]['cost_price'];
            }
            return $return;
        }
        
        
        public function request_update($request) {
            if( $request['status_id'] == 1 ) {
                $change = Database::getrow('sp_providers_requests', 'provider_id', 'id', $request_id, 0);
                $updatepositions['status_id'] = 2;
                $updatepositions['provider_id'] = $request['provider_id'];
                Database::update( 'sp_order_positions', $updatepositions, 'request_id', 1 );
                //Внести изменения статусов в историю
            }
            
            Database::update( 'sp_providers_requests', $request, 'id', $request['id'] );
        }
        
        public function request_delete($request_id) {
            $request = Database::getrow('sp_providers_requests', '*', 'id', $request_id, 0);
            if ($request['status_id'] == 1) {
                Database::deletrow_where_param( 'sp_providers_requests', 'id', $request['id'] );
            }
            
        }
        
        public function request_info($request_id) {
            
            $request = Database::difQuery(
                "
                    SELECT 
                    `sp_providers_requests`.`id` as `request_id`,
                    `sp_providers_requests`.`provider_id` as `provider_id`,
                    `sp_providers_requests`.`sum` as `stop_sum`,
                    `sp_providers_requests`.`status_id` as `status_id`,
                    `sp_providers_requests`.`delivery_cost` as `delivery_cost`,
                    `sp_providers_requests`.`stop_date` as `stop_date`,
                    `sp_providers_requests`.`delivery_cost_unit` as `delivery_cost_unit`,
                    `sp_providers_requests`.`markup` as `markup`,
                    `sp_providers_requests`.`conditions` as `conditions`,
                    `sp_providers_requests`.`name` as `purchase_name`,
                    `sp_providers_requests`.`products` as `products`,
                    `sp_providers_requests`.`categories` as `categories`,
                    `sp_providers_requests`.`title` as `title`,
                    `sp_providers_requests`.`keywords` as `keywords`,
                    `sp_providers_requests`.`description` as `description`,
                    `sp_providers_requests`.`offer` as `offer`,
                    `sp_providers_requests`.`cta` as `cta`,
                    
                    
                    `sp_providers`.`name` as `provider_name`,
                    `sp_providers`.`phone` as `provider_phone`,
                    `sp_providers`.`email` as `provider_email`,
                    `sp_providers`.`markup` as `provider_markup`,
                    `sp_statuses`.`name` as `status_name` 
                    
                    FROM `sp_providers_requests` 
                    INNER JOIN `sp_providers` ON `sp_providers`.`id` = `sp_providers_requests`.`provider_id` 
                    INNER JOIN `sp_statuses` ON `sp_statuses`.`id` = `sp_providers_requests`.`status_id`
                    WHERE `sp_providers_requests`.`id` = {$request_id}
                "
            );
            $return['info'] = $request[0];
            $current_date = date("Y-m-d");
            
            if( $return['info']['status_id'] == 1  ) {
                
                $return['positions-no-order'] = Database::difQuery("
                    SELECT 
                    `sp_order_positions`.`id` as `id`,
                    `sp_order_positions`.`name` as `name`,
                    `sp_order_positions`.`id` as `id`,
                    `sp_order_positions`.`manufacture` as `manufacture`,
                    `sp_order_positions`.`cost_price` as `cost_price`,
                    `sp_order_positions`.`price` as `price`,
                    `sp_order_positions`.`qnt` as `qnt`,
                    `sp_order_positions`.`order_id` as `order_id`,
                    `sp_order_positions`.`status_id` as `status_id`,
                    `sp_order_positions`.`request_provider_id` as `request_provider_id`,
                    `sp_statuses`.`name` as `status_name`,
                    `sp_providers`.`name` as `provider_name`,
                    
                    `sp_orders`.`user_id` as `user_id`,
                    `birzha_users`.`login` as `login`,
                    `birzha_users`.`phone` as `phone`,
                    `birzha_users`.`email` as `email`
                    
                    FROM `sp_order_positions` 
                    INNER JOIN `sp_statuses` ON `sp_statuses`.`id` = `sp_order_positions`.`status_id` 
                    INNER JOIN `sp_providers` ON `sp_providers`.`id` = {$return['info']['provider_id']} 
                    INNER JOIN `sp_orders` ON `sp_orders`.`id` = `sp_order_positions`.`order_id`
                    INNER JOIN `birzha_users` ON `birzha_users`.`id` =  `sp_orders`.`user_id`
                    WHERE `sp_order_positions`.`provider_id` = {$return['info']['provider_id']} AND `sp_order_positions`.`request_provider_id` = 0
                ");
                
                $query_in_order = " SELECT 
                    `sp_order_positions`.`id` as `id`,
                    `sp_order_positions`.`name` as `name`,
                    `sp_order_positions`.`id` as `id`,
                    `sp_order_positions`.`manufacture` as `manufacture`,
                    `sp_order_positions`.`cost_price` as `cost_price`,
                    `sp_order_positions`.`price` as `price`,
                    `sp_order_positions`.`qnt` as `qnt`,
                    `sp_order_positions`.`order_id` as `order_id`,
                    `sp_order_positions`.`status_id` as `status_id`,
                    `sp_order_positions`.`request_provider_id` as `request_provider_id`,
                    `sp_statuses`.`name` as `status_name`,
                    `sp_providers`.`name` as `provider_name`,
                    
                    `sp_orders`.`user_id` as `user_id`,
                    `birzha_users`.`login` as `login`,
                    `birzha_users`.`phone` as `phone`,
                    `birzha_users`.`email` as `email`
                    
                    FROM `sp_order_positions` 
                    INNER JOIN `sp_statuses` ON `sp_statuses`.`id` = `sp_order_positions`.`status_id` 
                    INNER JOIN `sp_providers` ON `sp_providers`.`id` = {$return['info']['provider_id']}
                    INNER JOIN `sp_orders` ON `sp_orders`.`id` = `sp_order_positions`.`order_id`
                    INNER JOIN `birzha_users` ON `birzha_users`.`id` =  `sp_orders`.`user_id`

                    WHERE `sp_order_positions`.`provider_id` = {$return['info']['provider_id']} AND `sp_order_positions`.`request_provider_id` = {$request_id} 
                ";
                
                $return['positions-in-order'] = Database::difQuery($query_in_order);
                
                
                
            }
            
            return $return;
            
        }
        
        public function get_vendors_list() {
            return Database::SelectFrom('sp_providers', 'id, name');
        }
        
        public function get_manufacturies_list() {
            return Database::SelectFrom('sp_manufacturies', 'id, manufacture');
        }
        
        
        public function positions_to_provider_request( $order_positions_id, $provider_request_id, $provider_id ) { //Пересчитываем заказ и прикрепляем позиции заказов к конкретной заявке
            $provider = Database::getrow('sp_providers', '*', 'id', $provider_id, 0);
            $request = Database::getrow('sp_providers_requests', '*', 'id', $provider_request_id, 0);
            
            
            
            /*
            Если тип стоимости за доставку не %, а конкретная сумма, которая распределяется равномерно на все позиции, то мы считаем количество этих мозиций
            */
           if ( $request['delivery_cost_unit'] == 2 && $request['deliver_distribution'] == 1 ) {
                $qnt = 0;
                for ( $j = 0; $j < count ($order_positions_id); $j++ ) {
                    
                    $qnt = $qnt + Database::getrow('sp_order_positions', 'qnt', 'id', $order_positions_id[$j], 0);
                    
                }
                $delivery_on_position = $request['delivery_cost'] / $qnt;
           }     
               
            
            $products = array();
            for ( $i = 0; $i < count ($order_positions_id); $i++ ) {
                $products[$i] = Database::getrow('sp_order_positions', 'id,price,cost_price,qnt', 'id', $order_positions_id[$i], 0);
				$add[$i]['id'] =  $order_positions_id[$i];
                $add[$i]['markup'] = $provider['markup'] + $request['markup'];
                if( $request['deliver_distribution'] == 2 ) {
                    $add[$i]['delivery_charge'] = $request['delivery_cost'];
                } elseif( $request['delivery_cost_unit'] == 1 ) {
                    $add[$i]['delivery_charge'] = $add[$i]['cost_price'] * ( 1 + $request['delivery_cost'] / 100 );
                } elseif ( $request['delivery_cost_unit'] == 2 && $request['deliver_distribution'] == 1 ) {
                    $add[$i]['delivery_charge'] = $delivery_on_position;
                }
				$add[$i]['request_provider_id'] = $provider_request_id;
                $add[$i]['price'] =  ( $add[$i]['markup']/100 + 1 ) * $products[$i]['cost_price'] + $add[$i]['delivery_charge'];
                Database::update( 'sp_order_positions', $add[$i], 'id', $order_positions_id[$i] );
                
            }
			
			$return['products'] = $products;
		//	$return['request'] = $request;
           // $retrun['provider'] = $provider;
			return $return;
        }
    
    }
    
?>