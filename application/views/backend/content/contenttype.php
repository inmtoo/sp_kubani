<h1><?=$data['page-title']?></h1>

<form action = "/manager/contenttypes/" method = "post" class="form-inline">

  <div class="form-group mb-2">
    <label for="staticEmail2" class="sr-only">Название</label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Добавить новый тип контента">
  </div>
  
  <div class="form-group mb-2">
    <label for="staticEmail2" class="sr-only">Символ</label>
    <input type="text" class="form-control" name="simbol" id="simbol" placeholder="Символ">
  </div>
  

  <input type="submit" class="btn btn-primary mb-2" name="addcontenttypes"/>
  
</form>

<table class="table table-bordered table-striped">
	<tr>
		<th>ID</th>
		<th>Название</th>
		<th>Символ</th>
		<th>Действия</th>
	</tr>
	
	<?php foreach( $data['contenttypes'] as $contenttype ) { ?>
		<tr>	
			<form action = "/manager/contenttypes/" method = "post">
				<input type="hidden" class="hidden" name="id" value="<?=$contenttype['id']?>"/>
				<td><?=$contenttype['id']?></td>
				<td>
					<input class="form-control" type="text" name="name" value = "<?=$contenttype['name']?>" />
				</td>
				<td>
					<input class="form-control" type="text" name="simbol" value = "<?=$contenttype['simbol']?>" />
				</td>
				<td><input type="submit" class="btn btn-success" name="updatecontenttypes" value="Редактировать"/></td>
			</form>
		</tr>
	<?php } ?>
	
</table>
