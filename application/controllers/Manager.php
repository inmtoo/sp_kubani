<?php 
	
	class Manager extends Inm_Controller {
	
		
		public function container ($data) {
                        $data['categories_tree'] = Catalogue::categoriesTree( array( 'level' => 0 ) );
                        $data['taxonomy-types'] = Content::get_taxonomies_types();
			$data['content_types'] = Content::get_content_types();
			parent::loadview('backend/container', $data);
		}
		
		
		public function index() {
			session_start();
			$data['session'] = Account::session_info();
			$data['page-title'] = 'Основные показатели';
			$data['template'] = 'main.php';
			
			Manager::container($data);
		}
		
		
		public function customers() {
			session_start();
			$data['session'] = Account::session_info();
			
			
			if( empty($_GET['page']) ) {
				$page = 1;
			} else {
				$page = $_GET['page'];
			}
			
			$data['customers'] = Users::simplefilter( array(
				'group_id' => 3
			), $offset = (($page*20)-20), $limit = 20);
			$data['page-title'] = 'Покупатели';
			$data['template'] = 'customers.php';
			Manager::container($data);
		}
		
		public function users() {
			session_start();
			$data['session'] = Account::session_info();
			
			
			if( empty($_GET['page']) ) {
				$page = 1;
			} else {
				$page = $_GET['page'];
			}
                            if ($_POST) {
                                $args[Form::post('field')] = Form::post('value');
                            }
			
                            $data['users'] = Users::simplefilter( $args, $offset = (($page*20)-20), $limit = 20);
                            $data['page-title'] = 'Пользователи';
                            $data['template'] = 'users.php';
                            $data['page'] = $page;
                     
			
			Manager::container($data);
		}
		
		public function delete_user($var) {
                    $data['page-title'] = 'Удаление пользователя';
                    $data['template'] = 'users_delete.php';
                    $data['content'] = Users::delete_user($var[0]);
                    Manager::container($data);
		}
		
	
		
		//НАСТРОЙКИ
		public function users_groups() { //Добавялем статусы
                    session_start();
                    $data['session'] = Account::session_info();
                    
                    if(  Form::post('group-name')  ) {
                        $add['name'] = Form::post('group-name');
                        Database::insert('birzha_users_groups', $add);
                        Redirect::index('manager/user_groups');
                    }
                    
                    $data['template'] = 'users/users-groups.php';
                    $data['page-title'] = 'Управление группами пользователей';
                    $data['user-groups'] = Database::SelectFrom($table = 'birzha_users_groups', $fields = '*');
                    Manager::container($data);
		}
		
		public function user_group($var) { //Добавялем статусы
                    session_start();
                    $data['session'] = Account::session_info();
                    
                    if(  From::post('group-name')  ) {
                        $add['name'] = Form::post('group-name');
                        Database::update( $table = 'birzha_users_groups', $add, $parametr = 'id', $value = $var[0] );
                        Redirect::index('manager/user_groups');
                    }
                    $data['template'] = 'users/statuse_edit.php';
                    $data['page-title'] = 'Редактирование группы';
                    $data['user-groups'] = Database::getrow( $table = 'birzha_users_groups', $fields = '*', $parametr = 'id', $value = $var[0], $rownum = 0 );
                    Manager::container($data);
		}
		
		public function user_group_delete($var) {
                    session_start();
                    $data['session'] = Account::session_info();
                    Database::deletrow_where_param( $table = 'birzha_users_groups', $parametr = 'id', $value=$var[0] );
                    Redirect::index('manager/user_groups');
		}
		
		
		public function cat_category($var) {
                        
			session_start();
			$data['categories_tree'] = Catalogue::categoriesTree( array( 'level' => 0 ) );
			$data['category'] = Catalogue::category($var[0]);
			$data['page-title'] = $data['category']['category']['name'];
                      //  echo 'fdgfd';
			$data['template'] = 'catcategory.php';
			Manager::container($data);
    
		}
		
		public function category_edit($var) {
                    session_start();
                    
                    if($_POST) {
                        
                        if($_FILES) {
                            $fullfolder  = $_SERVER['DOCUMENT_ROOT'].'/images/category/upload/';
                            $shortfolder = '/images/category/upload/';
                            $file_ext =  strtolower(strrchr($_FILES['newimage']['name'],'.'));
                            $newfilename = md5(date("Y-m-d").uniqid(rand(10000,99999)));
                            
                            
                            if( $file_ext = 'jpg' OR $file_ext='png' OR $file_ext='gif' OR $file_ext = 'jpeg' ) {
                                if (move_uploaded_file ( $_FILES["picture"]["tmp_name"] ,  $fullfolder.$newfilename.'.'.$file_ext )) {
                                    $add['picture'] = $shortfolder.$newfilename.'.'.$file_ext;
                                }
                            }
                           
                            
                        }
                        
                        $add['name'] = Form::post('name');
                        $add['title'] = Form::post('title');
                        $add['keywords'] = Form::post('keywords');
                        $add['description'] = Form::post('description');
                        $add['content'] = Form::post('content');
                        Database::update( 'sp_categories', $add, 'id', $var[0] );
                        Redirect::index('manager/category_edit/'.$var[0]);
                        
                        
                    } else {
                        $data['categories_tree'] = Catalogue::categoriesTree( array( 'level' => 0 ) );
                        $data['category'] = Catalogue::category($var[0]);
                        $data['page-title'] = 'Редактирование категории '.$data['category']['category']['name'];
                        $data['template'] = 'category_edit.php';
                        Manager::container($data);
                    }
		}
		
		
		public function category_add($var) {
                    session_start();
                    
                    if($_POST) {
                        
                        if($_FILES) {
                            $fullfolder  = $_SERVER['DOCUMENT_ROOT'].'/images/category/upload/';
                            $shortfolder = '/images/category/upload/';
                            $file_ext =  strtolower(strrchr($_FILES['newimage']['name'],'.'));
                            $newfilename = md5(date("Y-m-d").uniqid(rand(10000,99999)));
                            
                            
                            if( $file_ext = 'jpg' OR $file_ext='png' OR $file_ext='gif' OR $file_ext = 'jpeg' ) {
                                if (move_uploaded_file ( $_FILES["picture"]["tmp_name"] ,  $fullfolder.$newfilename.'.'.$file_ext )) {
                                    $add['picture'] = $shortfolder.$newfilename.'.'.$file_ext;
                                }
                            }
                           
                            
                        }
                        
                        $add['name'] = Form::post('name');
                        $add['title'] = Form::post('title');
                        $add['keywords'] = Form::post('keywords');
                        $add['description'] = Form::post('description');
                        $add['content'] = Form::post('content');
                        $add['parent_id'] = $var[0];
                        Database::insert( 'sp_categories', $add );
                        Redirect::index('manager/cat_category/'.$var[0]);
                        
                        
                    } else {
                        $data['categories_tree'] = Catalogue::categoriesTree( array( 'level' => 0 ) );
                        $data['page-title'] = 'Редактирование категории '.$data['category']['category']['name'];
                        $data['template'] = 'category_add.php';
                        Manager::container($data);
                    }
		}
		
		public function productsearch() {
                        
			session_start();
			$data['search-phrase'] = Form::get('productname');
			$data['categories_tree'] = Catalogue::categoriesTree( array( 'level' => 0 ) );
			$data['products'] = Catalogue::searchproduct(Form::get('productname'));
			$data['page-title'] = 'Результаты поиска по <i>'.Form::get('productname').'</i>';

                      //  echo 'fdgfd';
			$data['template'] = 'product_search.php';
			Manager::container($data);
    
		}
		
		
        //РАБОТА С ПОСТАВЩИКАМИ
        
        public function providers() {
            session_start();
            $data['session'] = Account::session_info();
            
            if (Form::post('add-provider')) {
                $add['name'] = Form::post('name');
                $add['country'] = Form::post('country');
                $add['region'] = Form::post('region');
                $add['city'] = Form::post('city');
                $add['adress'] = Form::post('adress');
                $add['phone'] = Form::post('phone');
                $add['email'] = Form::post('email');
                $add['site'] = Form::post('site');
                $add['markup'] = Form::post('markup');
                $add['group_id'] = Form::post('group_id');
                $add['sum_min_ws'] = Form::post('sum_min_ws');
                Database::insert('sp_providers', $add);
                Redirect::index('manager/providers');
            }
            
            if(empty($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            
            $data['page-title'] = 'Управление поставщиками';
            $data['providers'] = Store::providers_list($page, 50);
            $data['template'] = 'providers/providers.php';
            Manager::container($data);
            
        }
		
	//************* РАБОТА СО СТРУКТУРОЙ
		
            	//************* РАБОТА СО СТРУКТУРОЙ
		
                public function content($var) { //Получаем содержание по типу
			//echo 'fgdfg';

			$data['page-title'] = 'Управление содержанием';
			$data['taxonomy-types'] = Content::get_taxonomies_types();
			$data['content_types'] = Content::get_content_types();
			$data['content'] = Content::get_content_by_content_type_id($var[0]); //Допилить LIMIT, OFFSET
			$data['content_type'] = Database::getrow($table = 'sp_content_types', $fields = 'id, name, uri', $parametr = 'id', $value = $var[0], $rownum =0);
			$data['template'] = 'content_list.php';
			Manager::container($data);
		

		}
		
		public function add_content($var) {

                    $content_type_id = $var[0];
                    $data['page-title'] = 'Добавить содержание';
                    $data['taxonomy-types'] = Content::get_taxonomies_types();
                    $data['content_types'] = Content::get_content_types();
                    $data['content_type'] = Database::getrow($table = 'sp_content_types', $fields = 'id, name, uri', $parametr = 'id', $value = $var[0], $rownum =0);
                    $data['tax-block'] = Content::get_taxonomies_by_content_type($content_type_id);
                    $data['extra-block'] = Content::get_extrafields_by_content_type($content_type_id);
                    $data['pricelist'] = Content::getpricelist_full();
                     if( Form::post('add-content') ) {
                       
                        $content['name'] = Form::post('name');
                        $content['title'] = Form::post('title');
                        $content['keywords'] = Form::post('keywords');
                        $content['description'] = Form::post('description');
                        $content['short_text'] = Form::post('short_text');
                        $content['h1'] = Form::post('h1');
                        $content['content'] = Form::post('content');
                        $content['published'] = Form::post('published');
                        $content['svg'] = Form::post('svg');
                        $content['content_type_id'] = $content_type_id;
                        $content['date'] = date("Y-m-d");
                        $content['time'] = date("H:i:s");
                        $content['uri'] = Form::post('uri');
                        
                        
                        $taxonomies = $_POST['taxonomies'];
                         
                        $extra = $_POST['extra'];
                        
                        $price = $_POST['pricelist'];
                        
                       // print_r($extra);
                        print_r (Content::content_add($content, $taxonomies, $extra, $price));
                       // print_r(Database::insert('sp_content', $content));
                    
                    } else {
                        $data['template'] = 'content_add.php';
			Manager::container($data);
                    }
                    
		}
		
		public function contentedit($var) {

                    $content_id = $var[0];
                    $data['content'] = Content::get_content($content_id);
                    $data['page-title'] = 'Добавить содержание';
                    $data['taxonomy-types'] = Content::get_taxonomies_types();
                    $data['content_types'] = Content::get_content_types();
                    $data['content_type'] = Database::getrow($table = 'sp_content_types', $fields = 'id, name, uri', $parametr = 'id', $value = $var[0], $rownum =0);
                    $data['tax-block'] = Content::get_taxonomies_by_content_type_content_id($data['content']['content']['content_type_id'], $content_id);
                    $data['extra-block'] = Content::get_extrafields_by_content_type_content_id($data['content']['content']['content_type_id'], $content_id);
                    //$data['pricelist'] = Content::getpricelist_full();
                    $data['pricelist'] = Content::get_pricelist_rel('content_id', $content_id);
                    
                     if( Form::post('content-edit') ) {
                       
                        $content['name'] = Form::post('name');
                        $content['title'] = Form::post('title');
                        $content['keywords'] = Form::post('keywords');
                        $content['description'] = Form::post('description');
                        $content['short_text'] = Form::post('short_text');
                        $content['h1'] = Form::post('h1');
                        $content['content'] = Form::post('content');
                        $content['published'] = Form::post('published');
                        $content['svg'] = Form::post('svg');
                        $content['content_type_id'] = $data['content']['content']['content_type_id'];
                        $content['date'] = date("Y-m-d");
                        $content['time'] = date("H:i:s");
                        $content['uri'] = Form::post('uri');
                        
                        
                        $taxonomies = $_POST['taxonomies'];
                        $price = $_POST['pricelist'];
                        $extra = $_POST['extra'];
                        
      
                        Content::content_update($content, $taxonomies, $extra, $content_id, $price);
                        Redirect::index('manager/contentedit/'.$content_id);
             
                    
                    } else {
                        //print_r($data['content']);
                        $data['template'] = 'content_edit.php';
			Manager::container($data);
                    }
		}
		
		public function taxonomy($var) {

                    $taxonomy_id = $var[0];
                    $data['taxonomy'] = Content::get_taxonomy($taxonomy_id);
                    if(Form::post('taxedit')) {
                        
                            $taxonomy['name'] = Form::post('name');
                            $taxonomy['title'] = Form::post('title');
                            $taxonomy['keywords'] = Form::post('keywords');
                            $taxonomy['description'] = Form::post('description');
                            $taxonomy['short_text'] = Form::post('short_text');
                            $taxonomy['h1'] = Form::post('h1');
                            $taxonomy['content'] = Form::post('content');
                            $taxonomy['published'] = Form::post('published');
                            $taxonomy['tax_type_id'] = $data['taxonomy']['taxonomy']['tax_type_id'];
                            $taxonomy['date'] = date("Y-m-d");
                            $taxonomy['time'] = date("H:i:s");
                            $taxonomy['svg'] = Form::post('svg');
                            $taxonomy['uri'] = Form::post('uri');
                            $extra = $_POST['extra'];
                            $price = $_POST['pricelist'];
                            Content::taxonomy_update($taxonomy, $extra, $taxonomy_id, $price);
                            Redirect::index('manager/taxonomy/'.$taxonomy_id);
                            
			} else {
                            $data['tax_list'] = Content::get_taxonomies_by_type($var[0]);
                            $data['taxonomy-types'] = Content::get_taxonomies_types();
                            $data['content_types'] = Content::get_content_types();
                            $data['extra-block'] = Content::get_extrafields_by_tax_type_tax_id($data['taxonomy']['taxonomy']['tax_type_id'], $taxonomy_id);
                            $data['pricelist'] = Content::get_pricelist_rel('taxonomy_id', $taxonomy_id);
                            
                            $data['template'] = 'taxonomy_edit.php';
                            Manager::container($data);
    
                        }
		}
		
		
		public function taxonomies($var) { //Список таксономий конкретного типа

			$data['page-title'] = 'Управление содержанием';
			
			if(Form::post('taxadd')) {
                        
                            $taxonomy['name'] = Form::post('name');
                            $taxonomy['title'] = Form::post('title');
                            $taxonomy['keywords'] = Form::post('keywords');
                            $taxonomy['description'] = Form::post('description');
                            $taxonomy['short_text'] = Form::post('short_text');
                            $taxonomy['h1'] = Form::post('h1');
                            $taxonomy['content'] = Form::post('content');
                            $taxonomy['published'] = Form::post('published');
                            $taxonomy['tax_type_id'] = $var[0];
                            $taxonomy['svg'] = Form::post('svg');
                            $taxonomy['date'] = date("Y-m-d");
                            $taxonomy['time'] = date("H:i:s");
                            $taxonomy['uri'] = Form::post('uri');
                            $price = $_POST['pricelist'];
                            $extra = $_POST['extra'];
                            print_r (Content::taxonomy_add($taxonomy, $extra, $price));
                            //print_r($extra);
                            
			} else {
                            $data['tax_list'] = Content::get_taxonomies_by_type($var[0]);
                            $data['taxonomy-types'] = Content::get_taxonomies_types();
                            $data['content_types'] = Content::get_content_types();
                            $data['extra-block'] = Content::get_extrafields_by_taxonomy_type($var[0]);
                            $data['pricelist'] = Content::getpricelist_full();
                            
                            $data['template'] = 'taxonomies.php';
                            Manager::container($data);
                        }

		}
		
		
		//************* РАБОТА С УПРАВЛЕНИЕМ ТИПОМ СОДЕРЖАНИЕМ САЙТА
		
		
		public function taxsettings() {

			if ($_POST['add_tax_type']) {
                            $add['name']  = Form::post('type');
                            $add['uri']  = Form::post('uri');
                            $add['extra_id_s']  = $_POST['extra_id_s'];
                            Content::insert_taxonomy_type($add);
                            Redirect::index('manager/taxsettings');
			}
			$data['page-title'] = 'Типы таксономий';
			$data['extra-fields'] = Content::get_extra_fields('taxonomy');
			$data['taxonomy-types'] = Content::get_taxonomies_types();
			$data['content_types'] = Content::get_content_types();
			
			$data['template'] = 'taxonomy_types.php';
			Manager::container($data);

		}
		
		
		public function contenttypes() {
           
			
			if ($_POST['add_content_type']) {
                            $add['name']  = Form::post('type');
                            $add['uri']  = Form::post('uri');
                            $add['extra_id_s']  = $_POST['extra_id_s'];
                            $add['taxonomies_ids']  = $_POST['taxonomies_ids'];
                            Content::insert_content_type($add);
                            Redirect::index('manager/contenttypes');
			}
			$data['page-title'] = 'Типы контента';
			$data['extra-fields'] = Content::get_extra_fields('content');
			$data['taxonomies_ids'] = Content::get_taxonomies_types();
			$data['taxonomy-types'] = Content::get_taxonomies_types();
			$data['content_types'] = Content::get_content_types();
			$data['template'] = 'content_types_list.php';
			Manager::container($data);

		}
		
		// ***УПРАВЛЕНИЕ КОНТЕНТОМ *** КОНЕЦ ***
		
		public function authorize() {
			session_start();
			$data['session'] = Account::session_info();
			if(!empty(Form::post('logreg')) and !empty(Form::post('pswrdreg'))) {
				$add['login'] = Form::post('logreg');
				$add['password'] = Form::post('pswrdreg');
				if (Authorization::auth($add) == 1) {
					Redirect::index('manager/index');
				} else {
					Redirect::index('manager/authorize');
				}
				
			} else {
				$data['page-title'] = 'Вход в админпанель';
				
				
				parent::loadview('backend/login', $data);
			}
		}
		
		public function orders() {
                    session_start();
                    $data['session'] = Account::session_info();
                    if( empty(Form::get('page')) ) {
                            $pagenum = 1;
                    } else {
                            $pagenum = Form::get('page');
                    }
                    $args['limit'] = 50;
                    $args['offset'] = 50 * $pagenum - 50;
                    if ($_POST) {
                        $args['filter'][Form::post('field')] = Form::post('value');
                    }
                    $data['orders'] = Store::get_orders( $args );
                    $data['page-title'] = 'Список заказов';
                    $data['template'] = 'orders.php';
                    Manager::container($data);
		}
		
		public function order( $var ) {
                    session_start();
                    $data['session'] = Account::session_info();
                    $data['order_id'] = $var[0];
                    $data['statuses'] = Store::statuses();
                    $data['order'] = Store::OrderFullInfo($data['order_id']);
                    $data['page-title'] = 'Информация о заказе № '.$data['order_id'];
                    $data['template'] = 'order.php';
                    Manager::container($data);
		}
		
		public function orders_positions() {
                    session_start();
                    $data['session'] = Account::session_info();
                    if( empty(Form::get('page')) ) {
                            $pagenum = 1;
                    } else {
                            $pagenum = Form::get('page');
                    }
                    $args['limit'] = 100;
                    $args['offset'] = 100 * $pagenum - 100;
                    $data['orders_positions'] = Store::orders_positions($args);
                    $data['page-title'] = 'Позиции заказа';
                    $data['template'] = 'orders_positions.php';
                    $data['statuses'] = Store::statuses();
                    Manager::container($data);
		}
		
		public function position( $var ) {
                    session_start();
                    $data['session'] = Account::session_info();
                    $data['position'] = Store::get_position($var[0]);
                    $data['page-title'] = 'Информация о позиции';
                    $data['template'] = 'position.php';
                    $data['providers'] = Database::difQuery("SELECT `name`, `id` FROM `sp_providers`");
                    $data['statuses'] = Database::difQuery("SELECT `name`, `id` FROM `sp_statuses`");
                    
                    if( Form::post('update') ) {
                        $add['name'] = Form::post('name');
                        $add['artno'] = Form::post('artno');
                        $add['manufacture'] = Form::post('manufacture');
                        $add['price'] = Form::post('price');
                        $add['cost_price'] = Form::post('cost_price');
                        $add['qnt'] = Form::post('qnt');
                        $add['provider_id'] = Form::post('provider_id');
                        $add['status_id'] = Form::post('status_id');
                        Database::update( 'sp_order_positions', $add, 'id', $var[0] );
                        Redirect::index('manager/order/'.$var[0]);
                    }
                    
                    Manager::container($data);
		}
		
		public function position_action ($var) {
                    session_start();
                    $data['session'] = Account::session_info();
                    $positions_arr = $_POST['position_id'];
                    $prices_arr  = $_POST['price'];
                    $qnt_arr  = $_POST['qnt'];
                    $status_id = Form::post('status_id');
                  /*  if(empty($var[0])) {
                        $redirect = 'manager/orders_positions/';
                    } elseif ( !empty(Form::post('redirect')) ) {
                        $redirect = Form::post('status_id');
                    } else {
                        $redirect = 'manager/order/'.$var[0];
                    }*/
                    
                    $redirect = Form::post('redirect');
                    
                    if( Form::post('action') == 1 ) { //Смена состояния
                    $add['status_id'] = $status_id;
                       
                        Store::changeStatus($table = 'sp_order_positions', $positions_arr, $status_id);
                        Redirect::index($redirect);
                        
                    } elseif ( Form::post('action') == 2 ) { //Проводим оплаты
                        for( $i = 0; $i < count($positions_arr);$i++ ) {
                            Store::payments_on($positions_arr[$i], $status_id);
                        }
                        Redirect::index($redirect);
                        
                    } elseif ( Form::post('action') == 3 ) { //Снимаем оплаты
                        for( $i = 0; $i < count($positions_arr);$i++ ) {
                            Store::payments_off($positions_arr[$i], $status_id);
                        }
                        Redirect::index($redirect);
                        
                    } elseif(Form::post('action') == 4) {
                        //Сохраняем изменения
                        for($i=0; $i < count($positions_arr); $i++ ) {
                            $positions[$i]['id'] = $positions_arr[$i];
                            $positions[$i]['price'] = $prices_arr[$i];
                            $positions[$i]['qnt'] = $qnt_arr[$i];
                            
                        }
                        Store::save_positions($positions);
                        Redirect::index($redirect);
                    }
                    
                   // END IF;
		}
		
		
		//НАСТРОЙКИ
		public function statuses() { //Добавялем статусы
                    session_start();
                    $data['session'] = Account::session_info();
                    if(  Form::post('status-name')  ) {
                        $add['name'] = Form::post('status-name');
                        Database::insert('sp_statuses', $add);
                        Redirect::index('manager/statuses');
                    }
                    $data['template'] = 'statuses/statuses.php';
                    $data['page-title'] = 'Управление статусами';
                    $data['statuses'] = Database::SelectFrom($table = 'sp_statuses', $fields = '*');
                    Manager::container($data);
		}
		
		public function status($var) { //Добавялем статусы
                    session_start();
                    $data['session'] = Account::session_info();
                    
                    if(  Form::post('status-name')  ) {
                        $add['name'] = Form::post('status-name');
                        Database::update( $table = 'sp_statuses', $add, $parametr = 'id', $value = $var[0] );
                        Redirect::index('manager/statuses');
                    }
                    $data['template'] = 'statuses/status_edit.php';
                    $data['page-title'] = 'Редактирование статуса';
                    $data['statuses'] = Database::getrow( $table = 'sp_statuses', $fields = '*', $parametr = 'id', $value = $var[0], $rownum = 0 );
                    Manager::container($data);
		}
		
		public function status_delete($var) {
                    session_start();
                    $data['session'] = Account::session_info();
                    //Не забыть перед удалением проверить наличие записей
                    $checkOrders = Database::difQuery("SELECT `id` FROM `sp_order_positions` WHERE `status_id` = {$var[0]}");
                    $checkRequests = Database::difQuery("SELECT `id` FROM `sp_providers_requests` WHERE `status_id` = {$var[0]}");
                    if ( count($checkOrders) == 0 && count($checkRequests) ) {
                        Database::deletrow_where_param( $table = 'sp_statuses', $parametr = 'id', $value=$var[0] );
                        Redirect::index('manager/statuses');
                    } else {
                        $data['page-title'] = 'Вы не можете удалить статус';
                        $data['template'] = 'statuses/error.php';
                        Manager::container($data);
                    }
                    
		}
		
		public function providers_requests(){
                    
                    if( Form::post('add-provider-request') ) {
                        $add['provider_id'] = Form::post('provider_id');
                        $add['sum'] = Form::post('sum');
                        $add['title'] = Form::post('title');
                        $add['name'] = Form::post('name');
                        $add['stop_date'] = Form::post('stop_date');
                        $add['delivery_date'] = Form::post('delivery_date');
                        $add['delivery_cost'] = Form::post('delivery_cost');
                        $add['delivery_cost_unit'] = Form::post('delivery_cost_unit');
                        $add['deliver_distribution'] = Form::post('deliver_distribution');
                        $add['markup'] = Form::post('markup');
                        $add['conditions'] = Form::post('conditions');
                        $add['categories'] = Form::post('categories');
                        $add['products'] = Form::post('products');
                        $add['keywords'] = Form::post('keywords');
                        $add['description'] = Form::post('description');
                        $add['offer'] = Form::post('offer');
                        $add['cta'] = Form::post('cta');
                        $add['status_id'] = 1;
                        $data['statuses'] = Store::statuses();
                        Database::insert('sp_providers_requests', $add);
                        Redirect::index('manager/providers_requests');
                    }
                    
                    if (empty($_GET['page'])) {
                        $page = 1;
                    } else {
                        $page = $_GET['page'];
                    }
                    
                    $limit = 20;
                    $offset = $page * $limit - $limit;
                    
                    $data['providers'] = Vendors::get_vendors_list();
                    $data['stoprequests'] = Vendors::get_vendor_stop_requests();
                    $data['openrequests']  = Vendors::get_vendor_open_requests( $limit, $offset );
                    $data['requests']  = Vendors::get_vendor_requests( $limit, $offset );
                    $data['page-title'] = 'Заказы поставщикам';
                    $data['template'] = 'provider_requests.php';
                    Manager::container($data);
                    
		}
		
		public function provider_request($var) {
                    $request['id'] = $var[1];
                    if($var[0] == 'stop') {
                        $request['status_id'] = 2;
                        Vendors::request_update($request);
                        Store::sendconfirmation($var[0]);
                        Redirect::index('manager/providers_requests');
                    } elseif ($var[0] == 'delete') {
                        Vendors::request_delete($request['id']);
                        Redirect::index('manager/providers_requests');
                    } elseif($var[0] == 'view') {
                        $data['request-info'] = Vendors::request_info($request['id']);
                        //print_r($data['request-info']);
                        $data['page-title'] = 'Заказы поставщикам';
                        $data['template'] = 'provider_request.php';
                        $data['statuses'] = Store::statuses();
                        Manager::container($data);
                    }
                    
		}
		
		public function provider_request_sendconfirm($var) {
                    Store::sendconfirmation($var[0]);
                    Redirect::index('manager/provider_request/'.$var[0]);
		}
		
		public function positions_to_provider_request($var) {
                    Vendors::positions_to_provider_request( $_POST['order_positions_id'], $var[0], $var[1] );
                    Redirect::index('manager/provider_request/view/'.$var[0]);
					
		}
		
		
		
		
		
		public function product($var) {
		
                    $data['product'] = Database::getrow('sp_products', '*', 'id', $var[0], 0);
                    if ($_POST) {
                        
                        if($_FILES) {
                            $fullfolder  = $_SERVER['DOCUMENT_ROOT'].'/images/products/upload/';
                            $shortfolder = '/images/products/upload/';
                            $file_ext =  strtolower(strrchr($_FILES['newimage']['name'],'.'));
                            $newfilename = md5(date("Y-m-d").uniqid(rand(10000,99999)));
                            
                            if( $file_ext = 'jpg' OR $file_ext='png' OR $file_ext='gif' OR $file_ext = 'jpeg' ) {
                                if (move_uploaded_file ( $_FILES["newimage"]["tmp_name"] ,  $fullfolder.$newfilename.'.'.$file_ext )) {
                                    $add['images'] = $data['product']['images'].','.$shortfolder.$newfilename.'.'.$file_ext;
                                }
                            }
                        }
                        
                        $add['artno'] = Form::post('artno');
                        $add['keywords'] = Form::post('keywords');
                        $add['description'] = Form::post('description');
                        $add['title'] = Form::post('title');
                        $add['min_order'] = Form::post('min_order');
                        $add['name'] = Form::post('name');
                        $add['cost_price'] = Form::post('cost_price');
                        $add['price'] = Form::post('price');
                        $add['manufacture_id'] = Form::post('manufacture_id');
                        $add['provider_id'] = Form::post('provider_id');
                        $add['category_id'] = Form::post('category_id');
                        Database::update( 'sp_products', $add, 'id', $var[0] );
                        Redirect::index('manager/product/'.$var[0]);
                    
                    } else {
                    
                    $data['page-title'] = 'Редактировать информацию о товаре';
                    $data['template'] = 'product.php';
                    $data['vendors'] = Vendors::get_vendors_list();
                    $data['manufacturies'] = Vendors::get_manufacturies_list();
                    $data['categories'] = Catalogue::category_list ();
                    Manager::container($data);
                    }
		}
		
		public function product_add($var) {
		
 
                    if ($_POST) {
                        
                        if($_FILES) {
                            $fullfolder  = $_SERVER['DOCUMENT_ROOT'].'/images/products/upload/';
                            $shortfolder = '/images/products/upload/';
                            $file_ext =  strtolower(strrchr($_FILES['newimage']['name'],'.'));
                            $newfilename = md5(date("Y-m-d").uniqid(rand(10000,99999)));
                            
                            if( $file_ext = 'jpg' OR $file_ext='png' OR $file_ext='gif' OR $file_ext = 'jpeg' ) {
                                if (move_uploaded_file ( $_FILES["newimage"]["tmp_name"] ,  $fullfolder.$newfilename.'.'.$file_ext )) {
                                    $add['images'] = $data['product']['images'].','.$shortfolder.$newfilename.'.'.$file_ext;
                                }
                            }
                        }
                        
                        $add['artno'] = Form::post('artno');
                        $add['keywords'] = Form::post('keywords');
                        $add['description'] = Form::post('description');
                        $add['title'] = Form::post('title');
                        $add['min_order'] = Form::post('min_order');
                        $add['name'] = Form::post('name');
                        $add['cost_price'] = Form::post('cost_price');
                        $add['old_price'] = Form::post('old_price');
                        $add['price'] = Form::post('price');
                        $add['manufacture_id'] = Form::post('manufacture_id');
                        $add['provider_id'] = Form::post('provider_id');
                        $add['category_id'] = $Form::post('category_id');
                        Database::insert( 'sp_products', $add );
                        Redirect::index('manager/cat_category/'.$var[0]);
                    
                    } else {
                    
                    $data['page-title'] = 'Добавить товар в категорию';
                    $data['template'] = 'product_add.php';
                    $data['vendors'] = Vendors::get_vendors_list();
                    $data['manufacturies'] = Vendors::get_manufacturies_list();
                    $data['categories'] = Catalogue::category_list ();
                    $data['current_category'] = $var[0];
                    Manager::container($data);
                    }
		}
		
		public function delete_product_image($var) {
                    //$var[0] = id товара, $var[1] - изображение
                    $data['product'] = Database::getrow('sp_products', '*', 'id', $var[0], 0);
                    $images = explode(',', $data['product']['images']);
                    //еще надо удалить сам файл
                    unlink($_SERVER['DOCUMENT_ROOT'].$images[$var[1]]);
                    unset($images[$var[1]]);
                    print_r($images);
                    $add['images'] = implode(',', $images);
                    Database::update( 'sp_products', $add, 'id', $var[0] );
                    Redirect::index('manager/product/'.$var[0]);
		}
		
		/*public function tradepoints() {
                    echo 'It works';
		
                    if($empty($var[0])) {
                        $page = 1;
                    } else {
                        $page = $var[0];
                    }
                    $limit = 50;
                    $offset = $limit * $page - $limit;
                   
                   /* $data['tradepoints'] = Database::difQuery("SELECT 
                    `sp_tradepoints`.`name` as `name`,
                    `sp_tradepoints`.`adress` as `adress`,
                    `sp_tradepoints`.`phone` as `phone`,
                    `sp_tradepoints`.`email` as `email`,
                    `region`.`name` as `region`,
                    `city`.`name` as `city`
                    FROM `sp_tradepoints` 
                    INNER JOIN `city` ON `city`.`id_city` = `sp_tradepoints`.`email`.`city_id` 
                    INNER JOIN `city` ON `region`.`id_region` = `sp_tradepoints`.`email`.`region_id` 
                    LIMIT {$limit} OFFSET {$offset}");
                     $data['page-title'] = 'Управление торговыми точками (точки выдачи)';
                    $data['template'] = 'tradepoints.php';
                    Manager::container($data);
                    
		}*/
		
		public function tradepoints() {
                     
                    
                    if (empty($_GET['page'])) {
                        $page = 1;
                    } else {
                        $page = $_GET['page'];
                    }
                    
                    $limit = 50;
                    $offset = $page * $limit - $limit;
                    $data['tradepoints'] = Database::difQuery("SELECT 
                    `sp_tradepoints`.`id` as `id`,
                    `sp_tradepoints`.`name` as `name`,
                    `sp_tradepoints`.`adress` as `adress`,
                    `sp_tradepoints`.`phone` as `phone`,
                    `sp_tradepoints`.`email` as `email`,
                    `region`.`name` as `region`,
                    `city`.`name` as `city`
                    FROM `sp_tradepoints` 
                    INNER JOIN `city` ON `city`.`id_city` = `sp_tradepoints`.`city_id` 
                    INNER JOIN `region` ON `region`.`id_region` = `sp_tradepoints`.`region_id` 
                    LIMIT {$limit} OFFSET {$offset}");
                    $data['page-title'] = 'Управление торговыми точками (точки выдачи)';
                    $data['template'] = 'tradepoints.php';
                    Manager::container($data);
		}
		
		public function tradepoint($var) {
                    
                    //echo 'III';
                    
                   if($_POST['update_tradepoint']) {
                        $add['name'] = Form::post('name');
                        $add['adress'] = Form::post('adress');
                        $add['phone'] = Form::post('phone');
                        $add['email'] = Form::post('email');
                        $add['region_id'] = Form::post('region_id');
                        $add['city_id'] = Form::post('city_id');
                        $add['commentary'] = Form::post('commentary');
                        Database::update( 'sp_tradepoints', $add, 'id', $var[0] );
                        Redirect::index('/manager/tradepoint/'.$var[0]);
                    } else {
                        $data['tradepoint'] = Database::getrow('sp_tradepoints', '*', 'id', $var[0], 0);
                        $data['page-title'] = 'Редактирование информации о торговой точке';
                        $data['template'] = 'tradepoint.php';
                        Manager::container($data);
                    }
                    
		}
		
		public function tradepoints_managers() {
                    
                    if (empty($_GET['page'])) {
                        $page = 1;
                    } else {
                        $page = $_GET['page'];
                    }
                    
                    $limit = 50;
                    $offset = $page * $limit - $limit;
                    $data['managers'] = Database::difQuery("
                        SELECT 
                        `sp_managers`.`id` as `id`,
                        `sp_managers`.`name` as `name`,
                        `sp_managers`.`sirname` as `sirname`,
                        `sp_managers`.`fathername` as `fathername`,
                        `sp_managers`.`email` as `email`,
                        `sp_managers`.`phone` as `phone`,
                        `sp_tradepoints`.`name` as `tradepoint`,
                        `sp_tradepoints`.`id` as `tradepoint_id`,
                        `birzha_users`.`login` as `login`
                        FROM `sp_managers` 
                        INNER JOIN `sp_tradepoints` ON `sp_tradepoints`.`id` = `sp_managers`.`tradepoint_id` 
                        INNER JOIN `birzha_users` ON `birzha_users`.`id` = `sp_managers`.`user_id`
                        LIMIT {$limit} OFFSET {$offset} 
                    ");
                    $data['page-title'] = 'Менеджеры торговых точек';
                    $data['template'] = 'tradepoints_managers.php';
                    Manager::container($data);
                    
                    
                    
		}
		
		public function priceupload() {
                    
                    if($_POST) {
                        echo 'fsdf';
                       // print_r($_FILES);
                    
                    } else {
                        
                        if (empty($_GET['page'])) {
                            $page = 1;
                        } else {
                            $page = $_GET['page'];
                        }
                        
                        $limit = 50;
                        $offset = $page * $limit - $limit;
                        
                        $data['page-title'] = 'Загрузка прайс-листа';
                        $data['products-tmp'] = Database::difQuery("SELECT * FROM `price_temp` LIMIT {$limit} OFFSET {$offset}");
                        $data['template'] = 'priceupload.php';
                        Manager::container($data);
                    }
                    
		}
		
		public function pricerenew() {
                    
                    $oldprice = Database::getrows('sp_products', '*', 'provider_id', 3);
                    $pricetmp = Database::getrows('price_temp', '*', 'supplier_id', 3);
                    //print_r($pricetmp);
                    
                    foreach( $pricetmp as $row ) {
                        //Проверяем, есть ли такая позиция из временного прайс-листа в sp_products
                        $check = Database::difQuery("
                            SELECT `id` FROM `sp_products` WHERE `name` = '{$row['name']}' AND `artno` = '{$row['artno']}' AND `provider_id` = 3;
                        ");
                        
                        if(!empty($row['name'])) { $add['name'] = $row['name']; }
                        if(!empty($row['artno'])) { $add['artno'] = $row['artno']; }
                        if(!empty($row['manufacture'])) { $add['manufacture'] = $row['manufacture']; }
                        if(!empty($row['cost_price'])) { $add['cost_price'] = $row['cost_price']; }
                        if(!empty($row['price'])) { $add['price'] = $row['price']; }
                        if(!empty($row['old_price'])) { $add['old_price'] = $row['old_price']; }
                        if(!empty($row['qnt'])) { $add['qnt'] = $row['qnt']; }
                        if(!empty($row['min_order'])) { $add['min_order'] = $row['min_order']; }
                        if(!empty($row['category_id'])) { $add['category_id'] = $row['category_id']; }
                        if(!empty($row['title'])) { $add['title'] = $row['title']; }
                        if(!empty($row['keywords'])) { $add['keywords'] = $row['keywords']; }
                        if(!empty($row['description'])) { $add['description'] = $row['description']; }
                        $add['provider_id'] = 3;
                        
                        if(count($check) > 0) {
                            Database::update_several_parameters( 'sp_products', $add, array( 'name'=>$row['name'], 'artno'=>$row['artno'], 'provider_id'=>3 ) );
                        } else {
                           Database::insert('sp_products', $add);
                        }
        
                    }
                    
                    foreach($oldprice as $old) {
                        $checkold = Database::difQuery("
                            SELECT `id` FROM `price_temp` WHERE `name` = '{$old['name']}' AND `artno` = '{$old['artno']}' AND `supplier_id` = 3;
                        ");
                        
                        echo count($checkold)."SELECT `id` FROM `price_temp` WHERE `name` = '{$old['name']}' AND `artno` = '{$old['artno']}' AND `supplier_id` = 3; <br/>";
                        
                        if ( count($checkold) == 0 ) {
                            Database::deletrow_where_param( 'sp_products', 'id', $old['id'] );
                        }
                    }
                    Redirect::index('manager/priceupload');
                    
		}
		
		public function pricetmptruncate() {
                    Database::difQuery("TRUNCATE TABLE `price_temp`");
                    Redirect::index('manager/priceupload');
		}
		
		public function testform() {
                    if($_FILES) {
                    
                            //загружаем файл
                            $fullfolder  = $_SERVER['DOCUMENT_ROOT'].'/uploads/pricelists/';
                            $shortfolder = '/uploads/pricelists/';
                            $file_ext =  strtolower(strrchr($_FILES['upload']['name'],'.'));
                            $newfilename = md5(date("Y-m-d").uniqid(rand(10000,99999)));
                            
                            if( $file_ext = 'csv' OR $file_ext='txt' ) {
                                if (move_uploaded_file ( $_FILES["upload"]["tmp_name"] ,  $fullfolder.$_FILES['upload']['name'] )) {
                                    $file = $fullfolder.$_FILES['upload']['name'];
                                    
                                }
                            }
                            
                            $row = 0;
                            $handle = fopen($file, "r");
                            
                            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                                $num = count($data);
                                echo "<p> $num полей в строке $row: <br /></p>\n";
                                $row++;
                                
                                
                                $add['name'] = $data[0];
                                $add['artno'] = $data[1];
                                $add['manufacture'] = $data[2];
                                $add['price'] = $data[3];
                                $add['cost_price'] = $data[4];
                                $add['old_price'] = $data[5];
                                $add['qnt'] = $data[6];
                                $add['min_order'] = $data[7];
                                $add['currency'] = $data[8];
                                $add['images'] = $data[9];
                                $add['description'] = $data[10];
                                $add['supplier_id'] = $data[111];
                                $add['category_id'] = $data[12];
                                $add['title'] = $data[13];
                                $add['keywords'] = $data[14];
                                echo Database::insert('price_temp', $add);
                                echo '<br/><br/>';
                                
                            }
                            
                            fclose($handle);
                            
                        }
		}
		
	
		
	}
	
?>
