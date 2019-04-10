<p>Смените пароль</p>
<form action="/repass/changepassword/" method = "post">
	<input type="hidden" name="login" value="<?php echo $data['verfication']['login'];?>" />
	<input type="hidden" name="user_id" value="<?php echo $data['verfication']['user_id'];?>" />
	<input type="hidden" name="token" value="<?php echo $data['token'];?>" />
	<div class="form-group">
		<label>Новый пароль</label>
		<input type="password" class="form-control" name="password" />
	</div>
	<div class="form-group">
		<label>Повторите пароль</label>
		<input type="password" class="form-control" name="password-confirm" />
	</div>
	<input type="submit" class="btn btn-primary" name="changepass" value="Сменить пароль" />
</form>