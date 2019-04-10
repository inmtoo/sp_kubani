<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$data['page-title']?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="/theme-admin/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="/theme-admin/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="/theme-admin/css/fontastic.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="/theme-admin/css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="/theme-admin/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="/theme-admin/img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
        <script src="https://cdn.ckeditor.com/ckeditor5/1.0.0-alpha.2/classic/ckeditor.js"></script>
  </head>
  <body>
    <div class="page">
      <!-- Main Navbar-->
      <header class="header">
        <nav class="navbar">
          <!-- Search Box-->
          <div class="search-box">
            <button class="dismiss"><i class="icon-close"></i></button>
            <form id="searchForm" action="#" role="search">
              <input type="search" placeholder="What are you looking for..." class="form-control">
            </form>
          </div>
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <!-- Navbar Header-->
              <div class="navbar-header">
                <!-- Navbar Brand --><a href="index.html" class="navbar-brand">
                  <div class="brand-text brand-big"><span>SP-КУБАНИ </span><strong>Панель задач</strong></div>
                  <div class="brand-text brand-small"><strong>BD</strong></div></a>
                <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
              </div>
              <!-- Navbar Menu -->
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
               
                <!-- Logout    -->
                <li class="nav-item"><a href="login.html" class="nav-link logout">Выход<i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <div class="page-content d-flex align-items-stretch"> 
        <!-- Side Navbar -->
        <nav class="side-navbar">
          <!-- Sidebar Header-->
          <div class="sidebar-header d-flex align-items-center">

            <div class="title">
              <h1 class="h4"><?=$data['session']['user']['login']?></h1>
              <p>Web Designer</p>
            </div>
          </div>
          <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
          <ul class="list-unstyled">
		<li class="active"><a href="/manager/"> <i class="icon-home"></i>Главная </a></li>
		<li><a href="#users" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-bar-chart"></i> Пользователи </a>
                      <ul id="users" class="collapse list-unstyled ">
                        <li><a href="/manager/users/">Список пользователей</a></li>
                        <li><a href="/manager/users_groups/">Группы пользователей</a></li>
                        <li><a href="/manager/users_groups/">Управление доступом</a></li>
                      </ul>
		</li>
		
		<li><a href="#orders" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-bar-chart"></i> Управление заказами </a>
                      <ul id="orders" class="collapse list-unstyled ">
                        <li><a href="/manager/orders/">Список заказов</a></li>
                        <li><a href="/manager/orders_positions/">Позиции заказов</a></li>
                      </ul>
		</li>
		
		<li><a href="#providers" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-bar-chart"></i> Управление поставщиками </a>
                      <ul id="providers" class="collapse list-unstyled ">
                        <li><a href="/manager/providers/">Список поставщиков</a></li>
                        <li><a href="/manager/providers_requests/">Заявки поставщикам</a></li>
                      </ul>
		</li>
		
		<li><a href="#tradepoints" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-bar-chart"></i> Торговые точки </a>
                      <ul id="tradepoints" class="collapse list-unstyled ">
                        <li><a href="/manager/tradepoints/">Список торговых точек</a></li>
                        <li><a href="/manager/tradepoints_managers/">Менеджеры торговых точек</a></li>
                      </ul>
		</li>
		
		<li><a href="#settings" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i> Настройки </a>
                      <ul id="settings" class="collapse list-unstyled ">
                        <li><a href="/manager/statuses/">Управление статусами</a></li>
                        <li><a href="/manager/functions/">Функции и группы</a></li>
                        <li> <a href="/manager/changepassowrd/"> <i class="icon-screen"></i>Сменить пароль </a></li>
                      </ul>
		</li>
		
		
		<li><a href="#structure" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Структура </a>
                      <ul id="structure" class="collapse list-unstyled ">
                        <span class="heading">Содержание</span>
                        <?php foreach ($data['content_types'] as $content_type) {?>
                            <li><a href="/manager/content/<?=$content_type['id']?>/"><?=$content_type['name']?></a></li>
                        <?php } ?>
                        <span class="heading">Таксономии</span>
                           <?php foreach ($data['taxonomy-types'] as $taxonomy_type) {?>
                            <li><a href="/manager/taxonomies/<?=$taxonomy_type['id']?>/"><?=$taxonomy_type['name']?></a></li>
                         <?php } ?>
                      </ul>
                    </li>
                    
                    <li><a href="#settingsstructure" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Настройка структуры </a>
                      <ul id="settingsstructure" class="collapse list-unstyled ">
                        <li><a href="/manager/taxsettings/">Типы таксономий</a></li>
                        <li><a href="/manager/contenttypes/">Типы контента</a></li>
                        <li><a href="/manager/contentextrafields/">Дополнительные поля контента</a></li>
                        <li><a href="/manager/taxextrafields/">Дополнительные поля таксономий</a></li>
                        <li><a href="/manager/extrafieldsinputmethods/">Способы ввода</a></li>
                      </ul>
                    </li>
		
		<li><a href="#catalogue" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i> Каталог </a>
                    <ul id="catalogue" class="collapse list-unstyled ">
                        <li><a href="/manager/priceupload/">Загрузить прайс</a></li>
			<?php for( $i = 0; $i < count( $data['categories_tree'] ); $i++ ) { ?>
				<li class="nav-item">
					<a class="nav-link" href="/manager/cat_category/<?php echo $data['categories_tree'][$i]['id'];?>/"><?php echo $data['categories_tree'][$i]['name'];?></a>
				</li>
			<?php } ?>
                    </ul>
		</li>
            
          </ul>
        </nav>
        <div class="content-inner">
          <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom"><?=$data['page-title']?></h2>
            </div>
          </header>
          <!-- Dashboard Counts Section-->
          <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
              <div class="row bg-white has-shadow">
                <!-- Item -->
                <div class="col-xl-12 col-sm-12">
			<?php include($data['template']); ?>
                </div>
               
              </div>
            </div>
          </section>
          
          <!-- Page Footer-->
          <footer class="main-footer">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-6">
                  <p>Совместные покупки Кубани &copy; 2018</p>
                </div>
                <div class="col-sm-6 text-right">
                  <p>Design by <a href="https://bootstrapious.com/admin-templates" class="external">Bootstrapious</a></p>
                  <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                </div>
              </div>
            </div>
          </footer>
        </div>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="/theme-admin/vendor/jquery/jquery.min.js"></script>
    <script src="/theme-admin/vendor/popper.js/umd/popper.min.js"> </script>
    <script src="/theme-admin/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/theme-admin/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="/theme-admin/vendor/chart.js/Chart.min.js"></script>
    <script src="/theme-admin/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/theme-admin/js/charts-home.js"></script>
    <!-- Main File-->
    <script src="/theme-admin/js/front.js"></script>
  </body>
</html>
