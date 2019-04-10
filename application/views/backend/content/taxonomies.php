<h1><?=$data['page-title']?></h1>
<p>Таксономии - это те же самые категории (разделы). Вы можете <a href="/manager/taxsettings/" target="blank">создать несколько типов таксономий</a>. Добавляя новые разделы, указывайте тип таксономии.</p>
<h2>Добавить новую таксономию</h2>
<div class="row">
	<div class="col-lg-6 col-md-12 col-sm-12">
		<form action="/manager/taxonomies/">
			<div class="form-group">
				<input  type="text" class="form-control" name="name" placeholder = "Название таксономии"/>
			</div>
			<div class="form-group">
				<label>Тип таксономии</label>
				<select class="form-control" name="sp_taxonomies_type_id">
					<?php foreach ( $data['taxonomy_types'] as $taxonomy_type ) { ?>
						<option value="<?=$taxonomy_type['id']?>"><?=$taxonomy_type['name']?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<input  type="text" class="form-control" name="uri" placeholder = "uri"/>
			</div>
			<div class="form-group">
				<input  type="text" class="form-control" name="h1" placeholder = "H1"/>
			</div>
			<div class="form-group">
				<input  type="text" class="form-control" name="title" placeholder = "TITLE"/>
			</div>
			<div class="form-group">
				<input  type="text" class="form-control" name="keywords" placeholder = "keywords"/>
			</div>
			<div class="form-group">
				<input  type="text" class="form-control" name="description" placeholder = "description"/>
			</div>
			<div class="form-group">
				<textarea class="form-control" name="content" id="editor" placeholder = "Содержание"></textarea>
			</div>
			<div class="form-group">
				<input  type="text" class="form-control" name="template" placeholder = "Шаблон"/>
			</div>
			<input type="submit" name="add_taxonomy" value="Добавить" class="btn btn-primary"/>
		</form>
		
		<script>
			ClassicEditor
			.create( document.querySelector( '#editor' ) )
			.catch( error => {
				console.error( error );
			} );
		</script>
	</div>
	<div class="col-lg-6 col-md-12 col-sm-12">
		<table class="table table-striped table-bordered">
			<tr>
				<th>ID</th>
				<th>Название</th>
				<th>Действие</th>
			</tr>
		</table>
	</div>
</div>
