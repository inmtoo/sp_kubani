<div class="container container-fluid margin-bottom-50">
<div class="row justify-content-center">

<div class="registration-form col-lg-6 col-md-6 col-sm-12 col-xs-12">
<h1>Регистрация на сайте SP-KUBANI.RU</h1>
	<form action = "/frontend/registration/" method="post">
		<div class="req-block">
			<div class="form-group">
				<input type="text" placeholder="Придумайте логин" name="login" class="form-control"/>
			</div>
			<div class="form-group">
				<input type="text"  placeholder="Электронная почта" name="email" class="form-control"/>
			</div>
			<div class="form-group">
				<input type="password"  placeholder="Пароль" name="password" class="form-control"/>
			</div>
			<div class="form-group">
				<input type="password2"  placeholder="Пароль еще раз" name="password2" class="form-control"/>
			</div>
		</div>
		<div class="no-req-block">
			<div class="form-group">
				<input type="text" placeholder="Имя пользователя" name="spl" class="form-control"/>
			</div>
			
			<div class="form-group">
				<input type="text" name="spe"  placeholder="E-mail" class="form-control"/>
			</div>
			<div class="form-group">
				<input type="password"  placeholder="Пароль" name="spp" class="form-control"/>
			</div>
			<div class="form-group">
				<input type="password"  placeholder="Повторите" name="sppp" class="form-control"/>
			</div>
		</div>
		<input type = "submit" name="registration" value="Регистрация" class="btn btn-success"/>
	</form>
</div>
</div>
</div>
