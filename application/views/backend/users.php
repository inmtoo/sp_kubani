<div class="filter">
<form class="form-inline" method="post" action="">
 <label class="sr-only" for="inlineFormInputGroupUsername1">Username</label>
  <div class="input-group mb-2 mr-sm-2">
    <div class="input-group-prepend">
      <div class="input-group-text">Значение</div>
    </div>
    <input type="text" class="form-control" id="inlineFormInputGroupUsername1" name="value" placeholder="Например, Иванов">
  </div>

  <label class="sr-only" for="inlineFormInputGroupUsername2">Поле</label>
  <div class="input-group mb-2 mr-sm-2">
    <div class="input-group-prepend">
      <div class="input-group-text">Поле</div>
    </div>
    <select class="form-control" id="inlineFormInputGroupUsername2" name="field">
        <option value="last_name">Фамилия</option>
        <option value="first_name">Имя</option>
        <option value="phone">Номер телефона</option>
        <option value="email">email</option>
    </select>
  </div>

  

  <button type="submit" class="btn btn-primary mb-2">Поиск</button>
</form>
</div>


<div class="scroll-x">
	<table class="table table-bordered table-striped">
		<tr>
			<th>ID</th>
			<th>Логин</th>
			<th>Имя</th>
			<th>Фамилия</th>
			<th>Телефон</th>
			<th>Email</th>
			<th>Дата</th>
			<th>Время</th>
			<th></th>
		</tr>
		<?php foreach( $data['users'] as $user ) { ?>
		<tr>
			<td><?=$user['id']?></td>
			<td><?=$user['login']?></td>
			<td><?=$user['first_name']?></td>
			<td><?=$user['last_name']?></td>
			<td><?=$user['phone']?></td>
			<td><?=$user['email']?></td>
			<td><?=$user['date']?></td>
			<td><?=$user['time']?></td>
			<td><a href="/manager/delete_user/<?=$user['id']?>">X</a></td>
		</tr>
		<?php } ?>
	</table>
</div>

<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="/manager/users/?page=<?php echo $data['page'] - 1;?>">Пред.</a></li>
    <li class="page-item"><a class="page-link" href="/manager/users/?page=<?php echo $data['page'] + 1;?>"">След.</a></li>
  </ul>
</nav>