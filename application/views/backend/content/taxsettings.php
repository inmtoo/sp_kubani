<h1><?=$data['page-title']?></h1>


<form action = "/manager/taxsettings/" method = "post" >
  <div class="form-group">
    <label class="sr-only">Название</label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Добавить новый тип таксономии">
  </div>
  <div class="form-group">
    <label class="sr-only">Символ</label>
    <input type="text" class="form-control" name="simbol" id="simbol" placeholder="Символ">
  </div>
  
  <div class="form-group">
    <label class="sr-only">Типы контента</label>
	<select class="form-control" name="contenttypes[]" multiple>
	<?php foreach($data['contenttypes'] as $contenttype ) { ?>
		<option value="<?=$contenttype['simbol']?>" /><?=$contenttype['name']?></option>
	<?php } ?>
	</select>
  </div>
  
  <div class="form-group">
    <label class="sr-only">Типы контента</label>

		<input type="checkbox" name="hierarchical"  value="1"/> Иерархический

  </div>

  <input type="submit" class="btn btn-primary mb-2" name="addtaxsettings"/>
</form>

<table class="table table-bordered table-striped">
	<tr>
		<th>ID</th>
		<th>Название</th>
		<th>Символ</th>
		<th>Типы контента</th>
		<th>Иерархия</th>
		<th>Действия</th>
	</tr>
	
	<?php foreach( $data['taxonomy_types'] as $type ) { ?>
		<tr>	
			<form action = "/manager/taxsettings/" method = "post">
				<input type="hidden" class="hidden" name="id" value="<?=$type['id']?>"/>
				<td><?=$type['id']?></td>
				<td>
					<input class="form-control" type="text" name="name" value = "<?=$type['name']?>" />
				</td>
				<td>
					<input class="form-control" type="text" name="simbol" value = "<?=$type['simbol']?>" />
				</td>
				<td>
					<input class="form-control" type="text" name="contenttypes" value = "<?=$type['contenttypes']?>" />
				</td>
				<td><input type="submit" class="btn btn-success" name="updatetaxsettings" value="Редактировать"/></td>
			</form>
		</tr>
	<?php } ?>
	
</table>
