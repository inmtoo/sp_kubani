
<p><img src="<?=$data['category']['category']['picture']?>" style="width:100px;"/></p>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Название</label>
        <input type="text" name="name" class="form-control" value="<?=$data['category']['category']['name']?>"/>
    </div>
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="<?=$data['category']['category']['title']?>"/>
    </div>
    <div class="form-group">
        <label>Keywords</label>
        <input type="text" name="keywords" class="form-control" value="<?=$data['category']['category']['keywords']?>"/>
    </div>
    <div class="form-group">
        <label>Description</label>
        <input type="text" name="description" class="form-control" value="<?=$data['category']['category']['description']?>"/>
    </div>
    <div class="form-group">
        <label>Содержание</label>
        <textarea name="content" class="form-control"><?=$data['category']['category']['content']?></textarea>
    </div>
    <div class="form-group">
    <label for="exampleFormControlFile1">Изображение</label>
    <input type="file" class="form-control-file" name="picture" id="exampleFormControlFile1">
  </div>
  <input type="submit" value="Сохранить" class="btn btn-primary"/>
</form>