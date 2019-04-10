<div class="container container-fluid margin-bottom-50">
	<div class="row justify-content-center">

		<div class="registration-form col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h1><?=$data['msg']['message']?></h1>
			<?php if ( $data['msg']['status'] == 1 ) { ?>
				<p>Вы можете войти в аккаунт, используя логин и пароль</p>
				<form action = "/index.php/login/" method="post">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Логин" name = "logreg" />
				</div>
				<div class="form-group">
					<input type="password" class="form-control" placeholder="Пароль" name = "pswrdreg" />
				</div>
				<input type="submit" class="btn btn-success" value="Вход"/>
				</form>
			<?php } else { ?>
				<p>Такой логин или email уже заняты. Воспользуйтесь функцией напомнинаия пароля:</p>
				<form action = "/frontend/rememberpassword/" method="post">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="E-mail" name = "eml" />
				</div>
				<input type="submit" class="btn btn-success" value="Напомнить"/>
				</form>
			<?php } ?>
		</div>
	</div>
</div>
