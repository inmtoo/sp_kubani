<h1>Товар</h1>
<?php print_r($data['product']); ?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Наименование</label>
        <input type="text" name="name" class="form-control" value=""/>
    </div>
    
    <div class="form-group">
        <label>Артикул</label>
        <input type="text" name="artno" class="form-control" value=""/>
    </div>
    
     <div class="form-group">
        <label>Минимальный заказ</label>
        <input type="number" name="min_order" class="form-control" value=""/>
    </div>
    
    <div class="form-group">
        <label>Цена закупки (в качестве разделителя используйте точку)</label>
        <input type="text" name="cost_price" class="form-control" value=""/>
    </div>
    
    <div class="form-group">
        <label>Цена продажи (в качестве разделителя используйте точку)</label>
        <input type="text" name="price" class="form-control" value=""/>
    </div>
    
    <div class="form-group">
        <label>Старая цена (в качестве разделителя используйте точку)</label>
        <input type="text" name="old_price" class="form-control" value=""/>
    </div>
    
    <div class="form-group">
        <label>Поставщик</label>
        <select name="provider_id" class="form-control">
            <option value="0">Не выбрано</option>
            <?php foreach ($data['vendors'] as $vendor) { ?>
                <option>не выбрано</option>
                <option value="<?=$vendor['id']?>"><?=$vendor['name']?></option>
            <?php } ?>
        </select>
    </div>
    
     <div class="form-group">
        <label>Производитель</label>
        <select name="manufacture_id" class="form-control">
            <option value="0">Не выбрано</option>
            <?php foreach ($data['manufacturies'] as $manufacture) { ?>
                <option value="<?=$manufacture['id']?>"><?=$manufacture['name']?></option>
            <?php } ?>
        </select>
    </div>
    
    <div class="form-group">
        <label>Основная категория</label>
        <select name="category_id" class="form-control">
            <option value="0">Не выбрано</option>
            <?php foreach ($data['categories'] as $category) { ?>
                <option value="<?=$category['id']?>" <?php if($category['id'] == $data['current_category']) { echo 'selected'; } ?>
                ><?=$category['name']?></option>
            <?php } ?>
        </select>
    </div>
    
    <div class="form-group">
    <label for="exampleFormControlFile1">Добавить изображение</label>
    <input type="file" class="form-control-file" id="addimage"  name="newimage">
  </div>
    
    
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value=""/>
    </div>
    
    <div class="form-group">
        <label>Keywords</label>
        <input type="text" name="keywords" class="form-control" value=""/>
    </div>
    
    <div class="form-group">
        <label>Description</label>
        <input type="text" name="description" class="form-control" value=""/>
    </div>
    
    <p><input type="submit" value="Сохранить" class="btn btn-primary"/></p>
    
    
</form>