<h1>Товар</h1>
<?php print_r($data['product']); ?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Наименование</label>
        <input type="text" name="name" class="form-control" value="<?=$data['product']['name']?>"/>
    </div>
    
    <div class="form-group">
        <label>Артикул</label>
        <input type="text" name="artno" class="form-control" value="<?=$data['product']['artno']?>"/>
    </div>
    
     <div class="form-group">
        <label>Минимальный заказ</label>
        <input type="number" name="min_order" class="form-control" value="<?=$data['product']['min_order']?>"/>
    </div>
    
    <div class="form-group">
        <label>Цена закупки</label>
        <input type="text" name="cost_price" class="form-control" value="<?=$data['product']['cost_price']?>"/>
    </div>
    
    <div class="form-group">
        <label>Цена продажи</label>
        <input type="text" name="price" class="form-control" value="<?=$data['product']['price']?>"/>
    </div>
    
    <div class="form-group">
        <label>Поставщик</label>
        <select name="provider_id" class="form-control">
            <option value="0">Не выбрано</option>
            <?php foreach ($data['vendors'] as $vendor) { ?>
                <option value="<?=$vendor['id']?>" <?php if($vendor['id'] == $data['product']['provider_id']) { echo 'selected'; } ?>
                ><?=$vendor['name']?></option>
            <?php } ?>
        </select>
    </div>
    
     <div class="form-group">
        <label>Производитель</label>
        <select name="manufacture_id" class="form-control">
            <option value="0">Не выбрано</option>
            <?php foreach ($data['manufacturies'] as $manufacture) { ?>
                <option value="<?=$manufacture['id']?>" <?php if($manufacture['id'] == $data['product']['manufacture_id']) { echo 'selected'; } ?>
                ><?=$manufacture['name']?></option>
            <?php } ?>
        </select>
    </div>
    
    <div class="form-group">
        <label>Основная категория</label>
        <select name="category_id" class="form-control">
            <option value="0">Не выбрано</option>
            <?php foreach ($data['categories'] as $category) { ?>
                <option value="<?=$category['id']?>" <?php if($category['id'] == $data['product']['category_id']) { echo 'selected'; } ?>
                ><?=$category['name']?></option>
            <?php } ?>
        </select>
    </div>
    
    <div class="form-group">
    <label for="exampleFormControlFile1">Добавить изображение</label>
    <input type="file" class="form-control-file" id="addimage"  name="newimage">
  </div>
    
    <?php $images = explode(',', $data['product']['images']); ?>
    
    <ul class="product_images">
        <?php for( $i = 0; $i < count($images); $i++ ) { ?>
            <li><div><img src="<?=$images[$i]?>" style="width:100px;"/></div>
            <div><small><a href="/manager/delete_product_image/<?=$data['product']['id']?>/<?=$i?>">Удалить</a></small></div></li>
       <?php }?>
    </ul>
    
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="<?=$data['product']['title']?>"/>
    </div>
    
    <div class="form-group">
        <label>Keywords</label>
        <input type="text" name="keywords" class="form-control" value="<?=$data['product']['keywords']?>"/>
    </div>
    
    <div class="form-group">
        <label>Description</label>
        <input type="text" name="description" class="form-control" value="<?=$data['product']['description']?>"/>
    </div>
    
    <p><input type="submit" value="Сохранить" class="btn btn-primary"/></p>
    
    
</form>