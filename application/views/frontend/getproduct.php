<?php $images = explode (';', $data['object']['images'] );?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    
    <link rel="stylesheet" href=" /themes/frontend/css/style.css" />

    <title>Hello, world!</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container container-fluid">
  <a class="navbar-brand" href="/">Совместные покупки</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">Регистрация</a>
      </li>

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

    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Поиск товаров" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Найти</button>
    </form>
  </div>
  </div>
</nav>

<div class="container container-fluid main-screen-1">
	<div class="row">
	
		<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 object">
			<h1><?php echo $data['object']['name'];?></h1>
			<div class="price"><?php echo $data['object']['price'].' '.$data['object']['currency'];?></div>
			
			<div class="images">
				<ul class="image-list">
					<?php foreach ( $images as $image ) { ?>
						<li><img src="<?php echo $image;?>"/></li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 user-form-inform">
			<h2>Добавить в корзину</h2>
			<form class="" method="post">
				<div class="form-group">
				<label>Количество</label>
				<input type="number" class="form-control" value = 1 /></div>
				<input type="submit" class="btn btn-success" value="Добавить в  покупки"/>
			</form>
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
