
<form action="" method="post">

    <div class="form-group">
        <label>Наименование</label>
        <input type="text" class="form-control" name="name" value="<?=$data['position']['name']?>" />
    </div>
    
    <div class="form-group">
        <label>Артикул</label>
        <input type="text" class="form-control" name="artno" value="<?=$data['position']['artno']?>" />
    </div>
    
    <div class="form-group">
        <label>Производитель</label>
        <input type="text" class="form-control" name="manufacture" value="<?=$data['position']['manufacture']?>" />
    </div>
    
    <div class="form-group">
        <label>Цена</label>
        <input type="text" class="form-control" name="price" value="<?=$data['position']['price']?>" />
    </div>
    
    <div class="form-group">
        <label>Количество</label>
        <input type="text" class="form-control" name="qnt" value="<?=$data['position']['qnt']?>" />
    </div>
    
    <div class="form-group">
        <label>Цена закупа</label>
        <input type="text" class="form-control" name="cost_price" value="<?=$data['position']['cost_price']?>" />
    </div>
    
     <div class="form-group">
        <label>Поставщик</label>
       <select class="form-control" name="provider_id">
            <option>Не выбрано</option>
        <?php foreach( $data['providers'] as $provider ) { ?>
            <?php if($provider['id'] == $data['position']['provider_id']) { ?>
                <option value="<?=$provider['id']?>" selected="selected" ><?=$provider['name']?></option>
            <?php } else { ?>
                <option value="<?=$provider['id']?>"><?=$provider['name']?></value>
            <?php } ?>
        <?php } ?>
       </select>
    </div>
    
     <div class="form-group">
        <label>Статус</label>
       <select class="form-control" name="status_id">
        <option>Не выбрано</option>
        <?php foreach( $data['statuses'] as $status ) { ?>
            <?php if($status['id'] == $data['position']['status_id']) { ?>
                <option value="<?=$status['id']?>" selected="selected" ><?=$status['name']?></option>
            <?php } else { ?>
                <option value="<?=$status['id']?>"><?=$status['name']?></value>
            <?php } ?>
        <?php } ?>
       </select>
    </div>
    
    <input type="submit" name="update" class="btn btn-primary" value="Обновить"/>
    
</form>
