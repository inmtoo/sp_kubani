<?php
	class Repass extends Inm_Controller {
	
		function getemail() {
			
			if(Form::post('send')) {
				//echo 'it works';
				
				$add['email'] = Form::post('logemail');
				
				$data['template'] = 'lettersent';
				$data['page_title'] = 'Ссылка для восстановления пароля пароля выслана на Ваш почтовый адрес';
				$data['sys_msg'] = Authorization::remember($add);
				//print_r($data['sys_msg']);
				parent::loadview('repass/repass', $data);
				
			} else {
				$data['template'] = 'emailform';
				$data['page_title'] = 'Восстановление доступа';
				parent::loadview('repass/repass', $data);
			}
			
		}
		
		function tokenverification() {
			$token = Form::get('tokenkey'); //получаем токен из письма
			
			
			$result = Authorization::tokenver($token);
			//print_r($result);
			
			switch ($result['status']) {
				case 'success': $data['template'] = 'changepassword';
				break;
				case 'error': $data['template'] = 'tokenerror';
				break;
			}
			$data['verfication'] = $result;
			$data['page_title'] = 'Смена пароля';
			$data['token'] = Form::get('tokenkey');
			//print_r($data);
			
			parent::loadview('repass/repass', $data);
		
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
				$data['template'] = 'changepassword-success';
				print_r($data['msg_sys']);
				
			} else {
				//подгрузить снова форму смены логина и пароля
				echo 'Пароли не совпадают';
			}
		
		}
	
	}

?>