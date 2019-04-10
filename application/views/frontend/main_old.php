<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    
	<link rel="stylesheet" href=" /themes/frontend/css/style.css" />
	<script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <title><?=$data['page-title']?></title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container container-fluid">
  <a class="navbar-brand" href="/"><i class="fas fa-american-sign-language-interpreting"></i> Совместные покупки</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">


      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Каталог
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      
	<li class="nav-item">
		<a class="nav-link" href="#">Регистрация</a>
	</li>
	<li class="nav-item">
		<a class="nav-link"  data-toggle="modal" data-target="#login">Вход</a>
	</li>

    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Поиск товаров" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Найти</button>
    </form>
  </div>
  </div>
</nav>


<div class="container container-fluid main-screen-1 margin-bottom-40">
	<div class="row">
		
		
		<div class="bg-green padding-15 text-center col-lg-4 col-md-4 col-sm-6 col-xs-12">
		
			<h1 class="font-weight-normal">Сервис совместных покупок</h1>
			<p>Тысячи людей совершают совместные покупки на нашем сайте. <a href="#learn-more">Подробнее.</a></p>
		
			<form method="post" action="/frontend/getproduct/">
			<div class="form-label-group">
				<input type="text" id="url" name="url" class="form-control" placeholder="http://" required="">
				<label for="inputPassword">Введите адрес страницы товара</label>
			</div>

			<button class="btn btn-lg btn-success btn-block" type="submit">Вперед</button>
			</form>
		</div>
		
		<div class="padding-15 text-center col-lg-4 col-md-4 col-sm-6 col-xs-12 partners">
			<h2>Присоединяйтесь к совместным покупкам:</h2>
			<p><img src="https://www.sima-land.ru/img/logo.png"/></p>
			<p><img src="https://happywear.ru/image/logo.png"/></p>
			<p><img src="http://bumaga-s.ru/images/redesign/logo.png"/></p>
		</div>
		
		<div class="padding-15 text-center col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<h2>Как это работает</h2>
			<p>Достаточно вставить ссылку (url) на страницу товара на наших сайтах партнерах или найти товар в нашем каталоге.</p>
			<iframe width="100%" height="auto" src="https://www.youtube.com/embed/SF1jpbexYqU" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		</div>
		
	</div>
</div>


<div class="container container-fluid margin-bottom-40">
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<nav class="navbar bg-light">

				<!-- Links -->
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="#">Автомобили</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Одежда</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Упаковка</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Хобби</a>
					</li>
				</ul>

			</nav>
		</div>
		
		<div class="col-lg-9 col-md-9 col-xs-12 col-sm12">
			<h2>Сейчас покупают</h2>
			<div class="row product-list">
				<div class="col-sm-2 col-xs-3 margin-bottom-20 text-center">
					<div class="thumbnail">
						<div class="img"><a href=""><img src="/images/item.jpg"></a></div>
						<div class="title"><a href="">Джинсы мужские</a></div>
						<div class="price">1488.00 RUB</div>
					</div>
				</div>
				<div class="col-sm-2 col-xs-3 margin-bottom-20 text-center">
					<div class="thumbnail">
						<div class="img"><a href=""><img src="/images/item.jpg"></a></div>
						<div class="title"><a href="">Джинсы мужские</a></div>
						<div class="price">1488.00 RUB</div>
					</div>
				</div>
				<div class="col-sm-2 col-xs-3 margin-bottom-20 text-center">
					<div class="thumbnail">
						<div class="img"><a href=""><img src="/images/item.jpg"></a></div>
						<div class="title"><a href="">Джинсы мужские</a></div>
						<div class="price">1488.00 RUB</div>
					</div>
				</div>
				<div class="col-sm-2 col-xs-3 margin-bottom-20 text-center">
					<div class="thumbnail">
						<div class="img"><a href=""><img src="/images/item.jpg"></a></div>
						<div class="title"><a href="">Джинсы мужские</a></div>
						<div class="price">1488.00 RUB</div>
					</div>
				</div>
				<div class="col-sm-2 col-xs-3 margin-bottom-20 text-center">
					<div class="thumbnail">
						<div class="img"><a href=""><img src="/images/item.jpg"></a></div>
						<div class="title"><a href="">Джинсы мужские</a></div>
						<div class="price">1488.00 RUB</div>
					</div>
				</div>
				<div class="col-sm-2 col-xs-3 margin-bottom-20 text-center">
					<div class="thumbnail">
						<div class="img"><a href=""><img src="/images/item.jpg"></a></div>
						<div class="title"><a href="">Джинсы мужские</a></div>
						<div class="price">1488.00 RUB</div>
					</div>
				</div>
				<div class="col-sm-2 col-xs-3 margin-bottom-20 text-center">
					<div class="thumbnail">
						<div class="img"><a href=""><img src="/images/item.jpg"></a></div>
						<div class="title"><a href="">Джинсы мужские</a></div>
						<div class="price">1488.00 RUB</div>
					</div>
				</div>
				<div class="col-sm-2 col-xs-3 margin-bottom-20 text-center">
					<div class="thumbnail">
						<div class="img"><a href=""><img src="/images/item.jpg"></a></div>
						<div class="title"><a href="">Джинсы мужские</a></div>
						<div class="price">1488.00 RUB</div>
					</div>
				</div>
				<div class="col-sm-2 col-xs-3 margin-bottom-20 text-center">
					<div class="thumbnail">
						<div class="img"><a href=""><img src="/images/item.jpg"></a></div>
						<div class="title"><a href="">Джинсы мужские</a></div>
						<div class="price">1488.00 RUB</div>
					</div>
				</div>
				<div class="col-sm-2 col-xs-3 margin-bottom-20 text-center">
					<div class="thumbnail">
						<div class="img"><a href=""><img src="/images/item.jpg"></a></div>
						<div class="title"><a href="">Джинсы мужские</a></div>
						<div class="price">1488.00 RUB</div>
					</div>
				</div>
				<div class="col-sm-2 col-xs-3 margin-bottom-20 text-center">
					<div class="thumbnail margin-bottom-20 text-center">
						<div class="img"><a href=""><img src="/images/item.jpg"></a></div>
						<div class="title"><a href="">Джинсы мужские</a></div>
						<div class="price">1488.00 RUB</div>
					</div>
				</div>
				<div class="col-sm-2 col-xs-3 margin-bottom-20 text-center">
					<div class="thumbnail">
						<div class="img"><a href=""><img src="/images/item.jpg"></a></div>
						<div class="title"><a href="">Джинсы мужские</a></div>
						<div class="price">1488.00 RUB</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>

<div class="jumbotron bg-dark text-center margin-bottom-40">
	<div class="container container-fluid">
		<div class="row">
			<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
				<h2 class="text-white">Более 40 точек выдачи</h2>
				<p><a href="">Анапа</a> <a href="">Армавир</a> <a href="">Краснодар</a> <a href="">Новороссийск</a> <a href="">Сочи</a> <a href="">Геленджик</a> <a href="">Крымск</a> <a href="">Темрюк</a> <a href="">Кропоткин</a> <a href="">Гулькевичи</a></p>
			</div>
		</div>
	</div>
</div>

<div class="container container-fluid margin-bottom-40">
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
				<li><a href="" rel="nofollow">Гид покупателям</a></li>
				<li><a href="" rel="nofollow">Зарегистрироваться</a></li>
				<li><a href="" rel="nofollow">Как оплатить заказ</a></li>
				<li><a href="" rel="nofollow">Выбор доставки</a></li>
				<li><a href="" rel="nofollow">Защита Покупателя</a></li>
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
        <form action = "/index.php/login/" method="post">
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Логин" name = "logreg" />
		</div>
		<div class="form-group">
			<input type="password" class="form-control" placeholder="Пароль" name = "pswrdreg" />
		</div>
		<input type="submit" class="btn btn-success" value="Вход"/>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
