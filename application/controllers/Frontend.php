	<?php 
	
	class Frontend extends Inm_Controller {
		
		
			function NormalizeStringToBD( $string ) 
{
	static $lang2tr = array(
		// russian
		'й'=>'j','ц'=>'c','у'=>'u','к'=>'k','е'=>'e','н'=>'n','г'=>'g','ш'=>'sh',
		'щ'=>'sh','з'=>'z','х'=>'h','ъ'=>'','ф'=>'f','ы'=>'y','в'=>'v','а'=>'a',
		'п'=>'p','р'=>'r','о'=>'o','л'=>'l','д'=>'d','ж'=>'zh','э'=>'e','я'=>'ja',
		'ч'=>'ch','с'=>'s','м'=>'m','и'=>'i','т'=>'t','ь'=>'','б'=>'b','ю'=>'ju','ё'=>'e','и'=>'i',

		'Й'=>'J','Ц'=>'C','У'=>'U','К'=>'K','Е'=>'E','Н'=>'N','Г'=>'G','Ш'=>'SH',
		'Щ'=>'SH','З'=>'Z','Х'=>'H','Ъ'=>'','Ф'=>'F','Ы'=>'Y','В'=>'V','А'=>'A',
		'П'=>'P','Р'=>'R','О'=>'O','Л'=>'L','Д'=>'D','Ж'=>'ZH','Э'=>'E','Я'=>'JA',
		'Ч'=>'CH','С'=>'S','М'=>'M','И'=>'I','Т'=>'T','Ь'=>'','Б'=>'B','Ю'=>'JU','Ё'=>'E','И'=>'I',
		// special
		' '=>'_', '-'=>'_', '\''=>'', '"'=>'', '\t'=>'', '«'=>'', '»'=>'', '?'=>'', '!'=>'', '*'=>''
	);
	$url = preg_replace( '/[\-]+/', '-', preg_replace( '/[^\w\-\*]/', '', strtolower( strtr( $string, $lang2tr ) ) ) );
	//echo $url."<br>";
	return  $url;
	}
		

		
		public function container( $data ) {
                        
			session_start();
			
			Frontend::authorize();
			
			$data['session_info'] = Account::session_info();
			
                        /**ADD TO CART****/
			if ($_POST['addtocart']) {
				$add['product_id'] = Form::post('product_id');
				$add['count'] = Form::post('count');
				$add['comment'] = Form::post('comment');
				$add['user_id'] = $data['session_info']['user']['id'];
				$add['characteristics'] = implode(',', $_POST['characteristic_id']);
				if (!empty($data['session_info']['cookies_session_id'])) {
					$add['session_id'] = $data['session_info']['cookies_session_id'];
				} else {
					$add['session_id'] = $data['session_info']['session_id'];
				}
				
				ShoppingCart::addToCart ($add);
				//print_r($add);

			}
			
			
			
			/*** END OF ADD TO CART***/
			$data['openrequests']  = Vendors::get_vendor_open_requests( 5, 0 );
			$data['cart-info'] = ShoppingCart::info($data['session_info']);
			
			
			parent::loadview('frontend/container', $data);
			//print_r($data);
			
		}

		//Написать защиту от СПАМА
		//Редирект на страницу товара
		
		public function index() {
                        
			session_start();
			$data['page-title'] = 'Совместные покупку';
			$data['keywords'] = 'Сайт совместных покупок';
			$data['description'] = 'Покупайте выгодно с сайтов SIMA-LAND.RU';
			$data['template'] = 'main.php';
			$data['categories_tree'] = Catalogue::categoriesTree( array( 'level' => 0 ) );
			//$data['lastproducts'] = Catalogue::lastproducts();
			$data['lastproducts'] = Catalogue::products_list( array('limit'=>20, 'offset'=>0) );
			//print_r($data['lastproducts-test']);
                      //  echo 'fdgfd';
			Frontend::container($data);
		}
		
		
		public function category($var) {
                        
			session_start();
			
			if(empty($_GET['page'])) {
                            $page = 1;
			} else {
                            $page= $_GET['page'];
			}
			
			$args['limit'] = 50;
			$args['offset'] = $args['limit'] * $page - $args['limit'];
			
			$data['template'] = 'category.php';
			$data['categories_tree'] = Catalogue::categoriesTree( );
			$data['category'] = Catalogue::category($var[0], $args);
			$data['page-title'] = $data['category']['category']['name'];
			$data['keywords'] = $data['category']['category']['keywords'];
			$data['description'] = $data['category']['category']['description'];
			Frontend::container($data);
    
		}
		
		public function test_copy() {
		
                    $destination = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
                    echo Files::copy_from_site_to ('https://cdn.sky.sima-land.ru/items/1689029/0/1600.jpg?v=0', $destination, 1);
                    echo $destination;
		}
		
		
		
		//Парсим продукт с сайта
		public function getproduct() {
			session_start();
			$data['page-title'] = 'Оформите заявку на совместную покупку';
			$data['keywords'] = 'Выполните простое действие';
			$data['description'] = 'Покупайте выгодно с сайтов SIMA-LAND.RU';
			$url = Form::post('url');
			$data['object'] = Catalogue::addFromUrl($url);
			Redirect::index('frontend/product/'.$data['object']['id']);
			//print_r($data['object']);
		}
		
		public function product($var) { //Страницы товара
			session_start();
			$data['object'] = Catalogue::product($var[0]);
			$data['characteristics'] = Catalogue::get_chatacteristics($var[0]);
			$data['page-title'] = $data['object']['name'];
			$data['keywords'] = $data['object']['keywords'];
			$data['description'] = $data['object']['description'];
			$data['categories_tree'] = Catalogue::categoriesTree( );
			$data['template'] = 'product.php';
			Frontend::container($data);
		}
                
                
		
		public function cart() { // корзина
			session_start();
			$data['session_info'] = Account::session_info();
			$data['page-title'] = 'Корзина';
			$data['template'] = 'cart-info.php';
			$data['categories_tree'] = Catalogue::categoriesTree( array( 'level' => 0 ) );
			$data['lastproducts'] = Catalogue::lastproducts();
			$data['regions'] = Database::getrows('region', 'id_region, name', 'id_country', 1 );
			$data['cities'] = Database::getrows('city', 'id_city, name', 'id_region', 30 );
			$data['tradepoints'] = Database::getrows('sp_tradepoints', 'id, name', 'id_city', 1042 );
			
			//Проверяем, есть ли у зарегистрированного пользователя на компьютере еще позиции в корзине и предлагаем объединить корзины или очистить
			if ( $data['session_info']['user']['id'] > 0 ) {
                            $secondcart['user_id'] = 0;
                            $secondcart['session_id'] = $data['session_info']['cookies_session_id'];
                            $data['second-cart'] = ShoppingCart::cartinfo( $secondcart );
			}
			
			
			Frontend::container($data);
		}
		
		public function redocart() {
                    session_start();
                    $data['session_info'] = Account::session_info();
                    if($_POST['redo_cart']) {
                        $add['id'] = Form::post('id');
                        $add['count'] = Form::post('count');
                        Database::update( 'sp_shopping_carts', $add, 'id', Form::post('id') );
                        Redirect::index('frontend/cart/');
                        //print_r($add);
                    }
		}
		
		

		
		public function deletefromcart($var) {
                    session_start();
                    $data['session_info'] = Account::session_info();
                    //Осуществить проверку на принадлежность позиции пользователю
                    $check = 1;
                    if ($check == 1) {
                        Database::deletrow_where_param( 'sp_shopping_carts', 'id', $var[0] );
                         Redirect::index('frontend/cart/');
                    }
		}
		
		
		public function clear_sec_cart() {
                        session_start();
			$data['session_info'] = Account::session_info();
			Database::difQuery("
                            DELETE FROM `sp_shopping_carts` WHERE `user_id` = 0 AND `session_id` = '{$data['session_info']['cookies_session_id']}'
			");
			Redirect::index('frontend/cart/');
		}
		
		public function unite_carts() {
                        session_start();
			$data['session_info'] = Account::session_info();
			Database::difQuery(
                            "
                                UPDATE `sp_shopping_carts` set `user_id` = {$data['session_info']['user']['id']} WHERE `session_id` = '{$data['session_info']['cookies_session_id']}' AND `user_id` = 0
                            "
			);
			Redirect::index('frontend/cart/');
                           /* echo "
                                UPDATE `sp_shopping_carts` set `user_id` = {$data['session_info']['user']['id']} WHERE `session_id` = '{$data['session_info']['cookies_session_id']}' AND `user_id` = 0
                            ";*/
		}
		
		
		
		public function expressorder() {
			session_start();
			$data['session_info'] = Account::session_info();
			$data['cart-info'] = ShoppingCart::info($data['session_info']);
			$data['template'] = 'express-order-start.php';
			$data['regions'] = Database::getrows( $table = 'region', $fields = 'name, id_region', $parametr = 'id_country', $value = 1 );
			$data['cities'] = Database::getrows('city', 'id_city, name', 'id_region', 30 );
			$data['tradepoints'] = Database::getrows('sp_tradepoints', 'id, name', 'id_city', 1042 );
			if( Form::post('expressorder') ) {
				$expressorder['first_name'] = Form::post('first_name');
				$expressorder['last_name'] = Form::post('last_name');
				$expressorder['phone'] = Form::post('phone');
				$expressorder['group_id'] = 3;
				$expressorder['email'] = Form::post('email');
				$expressorder['id_region'] = Form::post('id_region');
				$expressorder['id_city'] = Form::post('id_city');
				$expressorder['tradepoint_id'] = Form::post('tradepoint_id');
				$expressorder['cart-info'] = $data['cart-info'];
				$order_info = ShoppingCart::expressorder( $expressorder );
				Redirect::index('frontend/payorder/'.$order_info['id'].'/?token='.$order_info['token']);
				//print_r($expressorder);
			}
		
			Frontend::container($data);
		}
		
		
		
		public function order() {
			session_start();
			$data['session_info'] = Account::session_info();
			$data['cart-info'] = ShoppingCart::info($data['session_info']);
			$data['template'] = 'express-order-start.php';
			$data['regions'] = Database::getrows( $table = 'region', $fields = 'name, id_region', $parametr = 'id_country', $value = 1 );
			$data['cities'] = Database::getrows('city', 'id_city, name', 'id_region', 30 );
			$data['tradepoints'] = Database::getrows('sp_tradepoints', 'id, name', 'id_city', 1042 );
			if( Form::post('order') ) {
				$expressorder['first_name'] = $data['session_info']['user']['first_name'];
				$expressorder['last_name'] = $data['session_info']['user']['last_name'];
				$expressorder['phone'] = Form::post('phone');
				$expressorder['email'] = $data['session_info']['user']['email'];
				$expressorder['id_region'] = Form::post('id_region');
				$expressorder['id_city'] = Form::post('id_city');
				$expressorder['tradepoint_id'] = Form::post('tradepoint_id');
				$expressorder['cart-info'] = $data['cart-info'];
				$order_info = ShoppingCart::expressorder( $expressorder );
				Redirect::index('frontend/payorder/'.$order_info['id']);
				//print_r($expressorder);
			}
			$data['session_info']['user']['email']; 
			Frontend::container($data);
		}
		
		
		
		public function payorder($var) {
                    session_start();
                    $data['session_info'] = Account::session_info();
                    
                    $data['order-info'] = Store::order_info_to_pay( $var[0] );
                    //print_r ($data['order-info']['order']['user_id']);
                    if ( $data['session_info']['user']['id'] == $data['order-info']['order']['user_id'] ) {
                        echo '1';
                        $data['template'] = 'payorder.php';
                    } elseif ( $data['order-info']['order']['token'] == Form::get('token') && !empty(Form::get('token')) ) {
                        echo '1';
                        $data['template'] = 'payorder_noauth.php';
                       
                    } else {
                        $data['template'] = 'have-not-rights.php';
                    }
                    Frontend::container($data);
		}
		
		
		//Вывод закупки
		
		
		
		
		//ACCOUNT
		
		public function account() {
                    session_start();
                    $data['session_info'] = Account::session_info();
                    
                    //Смена пароля в личном кабинете
                    if($_POST) {
                        echo 'ttt';
                    
                        $add['id'] = $data['session_info']['user']['id'];
                        $add['phone'] = Form::post('phone');
                        $add['password'] = Form::post('password');
                        $add['password_new'] = Form::post('password_new');
                        if( !empty($add['password']) && !empty($add['password_new']) ) {
                            $data['change-result'] = Authorization::change_password($add);
                            
                            if( $data['change-result']!='false' ) {
                                $returnpass = '&changepassword=true';
                            } else {
                                $returnpass = '&changepassword=false';
                            }
                            
                        }
                        if(!empty(Form::post('phone'))) {
                            $phone_change['phone'] = Form::post('phone');
                            Database::update( 'birzha_users', $phone_change, 'id', $add['id'] );
                            $returnphone = '&returnphone=true';
                        }
                        $redirect = '?changedata=true'.$returnpass.$returnphone;
                        Redirect::index('frontend/account/'.$redirect);
                        
                    }
                    
                    
                    
                    $data['page-title'] = 'Данные об аккаунте';
                    $data['template'] = 'account/main.php';
                    Frontend::container($data);
                   
		
		}
		
		public function orders() {
                    
                        session_start();
			$data['session_info'] = Account::session_info();
			if( $data['session_info']['user']['id'] > 0 ) {
                            if( empty($_GET['page']) ) {
                                $page = 1;
                            } else {
                                $page = $_GET['page'];
                            }
                            if( empty($_GET['limit']) ) {
                                $limit = 20;
                            } else {
                                $limit = $_GET['limit'];
                            }
                            $offset = $page * $limit - $limit;
                            $args['user_id'] = $data['session_info']['user']['id'];
                            $args['offset'] = $offset;
                            $args['limit'] = $limit;
                            $data['orders'] = Store::userorders( $args );
                            $data['template'] = 'orders.php';
                            $data['page-title'] = 'История заказов';
                            $data['ordersum'] = Store::ordersum(2);
                            //$data['ordersum'] = 455;
			} else {
                            $data['page-title'] = 'У Вас нет прав на просмотр этого раздела';
                            $data['template'] = 'have-not-rights.php';
			}
			Frontend::container($data);
                    
		}
		
		
		public function orderinfo($var) {
                    session_start();
                    $data['session_info'] = Account::session_info();
                    $order_id = $var[0];
                    $data['order'] = Database::getrow('sp_orders', '*', 'id', $order_id, 0);
                    if ( $data['order']['user_id'] == $data['session_info']['user']['id'] ) {
                        $data['template'] = 'order.php';
                        $data['page-title'] = 'Информация о заказе №'.$order_id;
                        $args['order_id'] = $order_id;
                        $data['positions'] = Store::orderinfo($args);
                    } else {
                            $data['page-title'] = 'У Вас нет прав на просмотр этого раздела';
                            $data['template'] = 'have-not-rights.php';
                    }
                    
                    Frontend::container($data);
                    
		}
		
		// ***КОРЗИНА И ОФОРМЛЕНИЕ ЗАКАЗА *** КОРЗИНА ***
		
		public function purchase($var) {
                    session_start();
                    $data['user'] = Account::session_info();
                    $data['request-info'] = Vendors::request_info($var[0]);
                    $data['categories_list'] = Catalogue::get_categories($data['request-info']['info']['categories']);
                    $data['products_list'] = Catalogue::get_products($data['request-info']['info']['products']);
                    $data['page-title'] = $data['request-info']['info']['title'];
                    $data['template'] = 'purchase.php';
                    Frontend::container($data);
		}
		
		
		//
		
		public function page($var) {
                    session_start();
                    $data['user'] = Account::session_info();
                    $content_id = Database::getrow('sp_content', 'id', 'uri', $var[0], 0);
                    $data['page'] = Content::get_content($content_id['id']);
                    $data['page-title'] = $data['page']['content']['title'];
                    $data['keywords'] = $data['page']['content']['keywords'];
                    $data['description'] = $data['page']['content']['description'];
                    $data['template'] = 'page.php';
                    Frontend::container($data);
		}
		
		
		// ***РЕГИСТРАЦИЯ И АВТОРИЗАЦИЯ***
		
		public function registration() {
			
			session_start();
			$data['user'] = Account::session_info();
			
			
			if ($_POST['registration']) {
			
			
				if ( empty(Form::post('login')) && empty(Form::post('password')) && empty(Form::post('email')) ) {
				
				
					if( Form::post('spp') == Form::post('sppp') ) { //если совпадают пароли
						$add['login'] = Form::post('spl');
						$add['password'] = Form::post('spp');
						$add['email'] = Form::post('spe');
						$add['ip'] = $_SERVER['REMOTE_ADDR'];
						$add['type'] = 3;
						$add['date'] = Date('Y-m-d');
						$add['time'] = Date('H:i:s');
						$data['msg'] = Authorization::registration( $add );
						$data['template'] = 'registration/success.php';
						
					
					} else {
						$data['msg'] = 'Пароли не совпадают';
						$data['template'] = 'registration/form.php';
					}
					
				}
			
			} else {
				if ( $data['user']['user']['id'] > 0 ) {
					$data['page-title'] = 'Вы уже авторизованы';
					$data['template'] = 'registration/authorized.php';
				} else {
					$data['page-title'] = 'Регистрация пользователя';
					$data['template'] = 'registration/form.php';
				}
			}
			
			Frontend::container($data);
		
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
		
		public function logout() {
			session_start();
			$_SESSION = array();
			session_destroy();
			Redirect::index('/');

		}
		
		
		public function authorize() {
			if(!empty(Form::post('logreg')) and !empty(Form::post('pswrdreg'))) {
				$add['login'] = Form::post('logreg');
				$add['password'] = Form::post('pswrdreg');
				Authorization::auth($add);
			}
		}
		
		
		
		// ***РЕГИСТРАЦИЯ И АВТОРИЗАЦИЯ ** КОНЕЦ ***
		
		public function test_happy() {
		
                    print_r(Parser::happywear('https://happywear.ru/teenagers/teenagers-underwear/pajamas-for-teenagers/6511194'));
		
		}
		
		/*public function csplast() {
                    
           
                    
                    $products = Database::difQuery("SELECT `id`, `url` FROM `plastic` ");
                    
                    //for ($i = 0; $i < count($products); $i++ ) {
                    for ($i = 600; $i < count($products); $i++ ) {
                //    for ($i = 0; $i < count($products); $i++ ) {

                        $product = Frontend::csplast1($products[$i]['url']);

                        $add['images'] = implode(';', $product['images']);
                        Database::update('plastic', $add, 'id',$products[$i]['id']);
                    
                    }
                    echo 'END';
		
		}
		
		function csplast1($url) {
		
			$out = array();
			$out .= file_get_contents($url);
			
    
                
			$return['images-tmp'] =array();
			if(preg_match_all('/<a href="(.*?)" class="more_photo_item">/', $out, $images))
			{
				$return['images-tmp'] = $images[1];
			}
			
			//print_r ($return['images-tmp'] );

			
			
			for( $i=0; $i < count($return['images-tmp']); $i++ ) {
			
                           $return['images'][$i] = Files::copy_from_site_to (strtok('http://www.csplast.ru'.$return['images-tmp'][$i], '?'),  $_SERVER['DOCUMENT_ROOT'].'/uploads/csplast/', 1);
                            //print_r(strtok($return['images-tmp'][$i], '?'));
			}
			
			return $return;

			
		
		}*/
		
		
		public function plastsvar() {
                    
                    $products = Database::difQuery("SELECT * FROM `plastsvar`");
                    
                    foreach ( $products as $p ) {
                        $images = explode(';', $p['images']);
                        $add['image'] = $images[0];
                        $add['uri'] = Frontend::NormalizeStringToBD($p['name'].'_'.$p['artno'].'_'.$p['id']);
                        Database::update('plastsvar', $add, 'id', $p['id'] );
                        //print_r($add);
                        //echo '<br><br>';
                    }
                    
		}
		
		
	}
	
	?>
