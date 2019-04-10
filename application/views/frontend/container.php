

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"/>
    
    <link rel="stylesheet" href="/themes/frontend/css/style.css"/>
	<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
	<script src="/themes/frontend/js/sensitive-lists.js"></script>
	<link rel="shortcut icon" href="/themes/frontend/images/logo.png" />
    <title><?=$data['page-title']?></title>
    <meta name="keywords" content="<?=$data['keywords']?>"/>
    <meta name="description" content="<?=$data['description']?>"/>
  </head>
  <body>
  
  <div class="monitor" style="display:none;">
	<?php print_r($data['session_info']); ?><br/>
	<?php print_r($data['cart-info']); ?>
  </div>
   
   <div class="topbar container container-fluid">
	<div class="row">
		<div class="logo col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<a href="/"><img src="/themes/frontend/images/logo.png"/> Совместные покупки</a>
		</div>
		<div class="toolbar col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
			<ul class="navbar-inline">
			<?php if ( $data['session_info']['user']['id'] == 0 ) { ?>
			
				<li><a class="pointer" data-toggle="modal" data-target="#login"><i class="fas fa-sign-in-alt"></i> Вход</a></li>
				<li><a href="/frontend/registration/"><i class="fa fa-user-plus"></i> Регистрация</a></li>
			<?php } else { ?>
				<li><a href="/frontend/account/"><i class="fa fa-user-circle"></i> Аккаунт</a></li>
				<li><a href="/frontend/logout/"><i class="fas fa-sign-out-alt"></i> Выход</a></li>
			<?php } ?>
			
				<li><a href="/frontend/cart/"><i class="fa fa-shopping-cart"></i> Корзина 
				<?php if ( count($data['cart-info']) > 0 ) { 
					echo '<span class="cart-informer">('.count($data['cart-info']).')</span>';
				}  ?>
				</a></li>
			</ul>
		</div>
	</div>
   </div>
   
   




	<?php require_once($data['template']); ?>
	
	
<div class="footer">	
<div class="container container-fluid">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 margin-bottom-20">
			<h3>Новости от SP</h3>
			<form class="subscribe margin-bottom-20">
				<input type="email"><input type="submit" value="Подписаться"/>
			</form>
			<div class="social margin-bottom-20">
				<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
					<script src="//yastatic.net/share2/share.js"></script>
					<div class="ya-share2" data-services="collections,vkontakte,facebook,odnoklassniki,moimir,viber,whatsapp"></div>
			</div>
			
			<p>© sp-kubani.ru 2017, Все права защищены</p>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 margin-bottom-20">
			<h3>Как покупать</h3>
			<ul class="menu-no-mark">
				<li><a href="/frontend/page/guide/" rel="nofollow">Гид покупателям</a></li>
				<li><a href="/frontend/registration/" rel="nofollow">Зарегистрироваться</a></li>
				<li><a href="/frontend/page/how-to-pay/" rel="nofollow">Как оплатить заказ</a></li>
				<li><a href="/frontend/page/delivery/" rel="nofollow">Выбор доставки</a></li>
			</ul>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 margin-bottom-20">
			<script type="text/javascript" src="//vk.com/js/api/openapi.js?150"></script>

				<!-- VK Widget -->
				<div id="vk_groups"></div>
				<script type="text/javascript">
				VK.Widgets.Group("vk_groups", {mode: 3}, 124938690);
			</script>
		</div>
	</div>
</div>
</div>
	
	<!-- Modal -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Авторизация</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action = "" method="post">
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Логин" name = "logreg" />
		</div>
		<div class="form-group">
			<input type="password" class="form-control" placeholder="Пароль" name = "pswrdreg" />
		</div>
		<input type="submit" class="btn btn-success" name="enter" value="Вход"/>
        </form>
        <p><a href="/repass/getemail/">Восстановление доступа</a></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
	


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
