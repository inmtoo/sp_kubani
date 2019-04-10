<?php 

	class Users { 
	
		public function simplefilter($args, $offset, $limit) {
			$keys = array_keys($args);
			$values = array();
			for ( $i = 0; $i , $i < count( $keys ); $i++ ) {
			
				$values[$i] = "`".$keys[$i]."` LIKE '%".$args[$keys[$i]]."%'";
			
			}
			
			$return = implode(' OR ', $values);
			
			if (!empty($return)) {
				$filter = 'WHERE '.$return;
			}
			
			$query = "SELECT * FROM `birzha_users` {$filter} ORDER BY `id` DESC LIMIT {$limit} OFFSET {$offset} ";
			return Database::difQuery($query);
			//return $query;
		}
		
		public function delete_user($user_id) {
                    $orders  = Database::getrows('sp_orders', 'id', 'id', $user_id);
                    if (count($orders) == 0) {
                        Database::deletrow_where_param( 'birzha_users', 'id', $user_id );
                        return '
                            <p>Пользователь успешно удален. <a href="/manager/users/">Вернуться</a></p>
                        ';
                    }  else {
                        return '
                            <p>Вы не можете удалить этого пользователя, т.к. с ним связаны заказы. Если пользователь попросил удалить его данные, Вы можете отредактировать их таким образом, чтобы не было возможным определить лицо, совершавшее покупки в Вашем магазине. <a href="/manager/users/">Вернуться</a></p>
                        ';
                    }
		}
	
	}
	
?>
