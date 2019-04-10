<?php 

	class Account {
	
		public function session_info_test() {
			session_start();
			if ( $_SESSION['id'] > 0 ) {
				
				$query = "
					SELECT 
					`birzha_users`.`id` as `id`,
					`birzha_users`.`login` as `login`,
					`birzha_users`.`email` as `email`,
					`birzha_users`.`phone` as `phone`,
					`birzha_users`.`group_id` as `group_id`,
					`sp_users_balance`.`user_balance` as `balance`
					FROM `birzha_users` 
					INNER JOIN `sp_users_balance` ON `sp_users_balance`.`user_id` = `birzha_users`.`id`
					WHERE `birzha_users`.`id` = {$_SESSION['id']}
				";
				$result = Database::difQuery($query);
				$return['user'] = $result[0];
				
			} else {
				$return['user']['id'] = 0;
				$return['user']['login'] = '';
				$return['user']['email'] = '';
				$return['user']['group_id'] = 3;
			}
			
				$return['session_id'] = session_id();
				if ( empty($_COOKIE['session_id']) ) {
					setcookie('session_id',session_id(),time() + (86400 * 5));
					$return['cookies_session_id'] = $_COOKIE['session_id'];
				} else {
					$return['cookies_session_id'] = $_COOKIE['session_id'];
				}

			return $return;
		}
		
		//Если пустая корзина, то нам незачем в куки записывать сессию. Если  корзине что-то есть, то куки принимает значение session_id
		public function session_info() {
			session_start();
			if ( $_SESSION['id'] > 0 ) {
				
				$query = "
					SELECT 
					`birzha_users`.`id` as `id`,
					`birzha_users`.`login` as `login`,
					`birzha_users`.`email` as `email`,
					`birzha_users`.`phone` as `phone`,
					`birzha_users`.`group_id` as `group_id`,
					`sp_users_balance`.`user_balance` as `balance`
					FROM `birzha_users` 
					INNER JOIN `sp_users_balance` ON `sp_users_balance`.`user_id` = `birzha_users`.`id` 
					
					WHERE `birzha_users`.`id` = {$_SESSION['id']}
				";
				$result = Database::difQuery($query);
				$return['user'] = $result[0];
				$return['query'] = $query;
				
			} else {
				$return['user']['id'] = 0;
				$return['user']['login'] = '';
				$return['user']['email'] = '';
				$return['user']['group_id'] = 3;
			}
			
				$return['session_id'] = session_id();
				if ( empty($_COOKIE['session_id']) ) {
					setcookie('session_id',session_id(),time() + (86400 * 5));
					$return['cookies_session_id'] = $_COOKIE['session_id'];
				} else {
					if ( count(ShoppingCart::cartinfo(array('session_id' => $_COOKIE['session_id']	)
				)) == 0 ) {
						setcookie('session_id',session_id(),time() + (86400 * 5));
						$return['cookies_session_id'] = $_COOKIE['session_id'];
					} else {
						$return['cookies_session_id'] = $_COOKIE['session_id'];
					}
				}

			return $return;
		}
		
		public function checkrights( $user_id, $user_group_id, $class, $function, $redirect ) {
		/*
			$user_id - id ползователя
			$user_group_id - тип пользователя (группа)
			$class - класс, к которому даем доступ
			$function - функции и методы класса, к которым даем доступ
			$redirect - куда направить пользователя, если доступ запрещен
		
		*/
		
		$access_id_arr = Database::difQuery(
			"
				SELECT `id` FROM `sp_user_access` WHERE `class` = '{$class}' AND `function` = '{$function}'
			"
		);
		
		$access_id = $access_id_arr[0]['id'];
		
		$check['group'] = Database::difQuery(
			"
				SELECT * FROM `sp_user_access_rel` WHERE `user_group_id` = {$user_group_id} AND `functions` LIKE '%f{$access_id}_%' AND `access` = 1
			"
		);
		
		$check['user-decline'] = Database::difQuery(
			"
				SELECT * FROM `sp_user_access_rel` WHERE `user_id` = {$user_id} AND `functions` LIKE '%f{$access_id}_%' AND `access` = 0
			"
		);
		
		$check['user-access'] = Database::difQuery(
			"
				SELECT * FROM `sp_user_access_rel` WHERE `user_id` = {$user_id} AND `functions` LIKE '%f{$access_id}_%' AND `access` = 1
			"
		);
		
		if ( count($check['group']) > 0 && count($check['user-decline']) == 0 ) {
			return 1;
			
		} elseif ( $user_id > 0 && count($check['group']) == 0 && count($check['user-access']) > 0 ) {
			return 1;
		} else {
			Redirect::index($redirect);

		}
			
		}
		

	
	}

?>
