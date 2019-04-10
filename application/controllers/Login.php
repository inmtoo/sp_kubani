<?php
	
	class Login extends Inm_Controller {
	
		public function userinfo() {
			session_start();
			$user_id = $_SESSION['id'];
			//$user_id = 1;
			$user_group = Database::getrow( $table='birzha_users_groups_rel', $fields='*', $parametr='user_id', $value = $user_id, $rownum = 0 );
			$user_info['reginfo'] = Database::getrows( $table = 'birzha_users', $fields = 'login, email, published', $parametr = 'id', $value = $user_id );
			$user_info['id'] = $user_id;
			$user_info['sess_id'] = $user_id; // для теста. Удалить потом
			$user_info['group_id'] = $user_info['reginfo'][0]['type'];
			$user_info['published'] = $user_info['reginfo'][0]['published'];
			return $user_info;
		}
		
		
		public function authorize() {
		
			if(!empty(Form::post('logreg')) and !empty(Form::post('pswrdreg'))) {
				$add['login'] = Form::post('logreg');
				$add['password'] = Form::post('pswrdreg');
				Authorization::auth($add);
			}
		
		}
		
		
		public function fz154() {
		
			$data['title'] = 'Пользовательское соглашение';
			$data['page'] = 'fz154';
					
					
			parent::loadview('frontend/page-container', $data);
		}
		
		
		public function index() {
			session_start();
			$data['title'] = 'Авторизация';
			
			if(!empty(Form::post('logreg')) and !empty(Form::post('pswrdreg'))) {
				$add['login'] = Form::post('logreg');
				$add['password'] = Form::post('pswrdreg');
				Authorization::auth($add);
			}
			$userINFO = Login::userinfo();
			
			
			if( empty($userINFO['id']) ) {
				$data['title'] = 'Авторизация';
				parent::loadview('uxcab/login', $data);
			} elseif ( $userINFO['group_id'] == 3 ) {
				//Кидаем в ЛК покупателя
				Redirect::index('frontend/index');
				
			} elseif ( $userINFO['group_id'] == 2 ) {
				//Кидаем в ЛК поставщика
				Redirect::index('seller/index');
				
			} elseif ( $userINFO['group_id'] == 1 ) {
				//Кидаем в админку
				Redirect::index('admin/');
			} else {
				Redirect::index('login/');
			}
		}
		
		
		public function register() {
			$data['page_title'] = 'Регистрация';
			
			if(Form::post('auth')) {
				$add['login'] = Form::post('logreg');
				$add['password'] = Form::post('pswrdreg');
				$add['email'] = Form::post('emailreg');
				$add['phone'] = Form::post('phreg');
				$add['date'] = Date('Y-m-d');
				$add['time'] = Date('H:i:s');
				$add['type'] = Form::post('type');
				
				if( Form::post('type') == 3 ) {
					$add['published'] = 1;
				} else {
					$add['published'] = 0;
				}
				
				$add['ip'] = $_SERVER['REMOTE_ADDR'];
				
				
				//Authorization::registration($add);
				
				if( Form::post('pswrdreg') == Form::post('pswrdregconfirm') ) {
				
					$pagedata['sysMsg'] = Authorization::registration($add);
					
					MyZapros::GiveAccess( $add['login'], $group_id = $add['type'] );
					FModel::UserGroupAddNote( $email = $add['email'], $groupID = $add['type'] );
					
					$data['title'] = 'Регистрация прошла успешно';
					$data['page'] = 'login/page_success';
					parent::loadview('uxcab/registration', $data);
					
				} else {
				
					$data['title'] = 'Пароли не совпадают, имя пользователя или email заняты';
					$data['page'] = 'login/page_denied';
					parent::loadview('uxcab/registration', $data);
					
				}
				
				
				
			} else {
				
				$data['title'] = 'Регистрация';
				$data['page'] = 'login/page_registration';
				parent::loadview('uxcab/registration', $data);
			}

		}
		
		
		
		function forgotpass() {
			
			if(Form::post('send')) {
				//echo 'it works';
				
				$add['email'] = Form::post('logemail');
				
				$data['template'] = 'lettersent';
				$data['page_title'] = 'Ссылка для восстановления пароля пароля выслана на Ваш почтовый адрес';
				$data['sys_msg'] = Authorization::remember($add);
				//print_r($data['sys_msg']);
				$data['page'] = 'login/lettersent';
				parent::loadview('uxcab/registration', $data);
				
			} else {
				$data['page'] = 'login/emailform';
				$data['title'] = 'Восстановление доступа';
				parent::loadview('uxcab/registration', $data);
			}
			
		}
		
		function tokenverification() {
			$token = Form::get('tokenkey'); //получаем токен из письма
			
			
			$result = Authorization::tokenver($token);
			//print_r($result);
			
			switch ($result['status']) {
				case 'success': $data['page'] = 'login/changepassword';
				break;
				case 'error': $data['page'] = 'login/tokenerror';
				break;
			}
			$data['verfication'] = $result;
			$data['page_title'] = 'Смена пароля';
			$data['token'] = Form::get('tokenkey');

			parent::loadview('uxcab/registration', $data);
		
		}
		
		
		function changepassword($postdata) {
			$postdata['user_id'] = Form::post('user_id');
			$postdata['login'] = Form::post('login');
			$postdata['token'] = Form::post('token');
			$postdata['password'] = Form::post('password');
			$postdata['password-confirm'] = Form::post('password-confirm');
			
			if($postdata['password'] == $postdata['password-confirm']) {
				
				$data['msg_sys'] = Authorization::changepassowrdtoken($postdata);
				$data['page_title'] = 'Смена пароля';
				$data['page'] = 'login/changepassword-success';
				parent::loadview('uxcab/registration', $data);
				
			} else {
				//подгрузить снова форму смены логина и пароля
				echo 'Пароли не совпадают';
				$data['page_title'] = 'Пароли не совпадают';
				$data['page'] = 'login/changepassword-fall';
				parent::loadview('uxcab/registration', $data);
			}
		
		}
	
	
	}

?>
