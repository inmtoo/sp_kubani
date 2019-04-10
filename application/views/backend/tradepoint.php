<h1>Редактирование торговой точки</h1>
<form action="" method="post">
    <div class="form-group">
        <input type="text" name="name" class="form-control" value="<?=$data['tradepoint']['name']?>"/>
    </div>
    <div class="form-group">
        <input type="text" name="region_id" class="form-control" value="<?=$data['tradepoint']['region_id']?>"/>
    </div>
    <div class="form-group">
        <input type="text" name="city_id" class="form-control" value="<?=$data['tradepoint']['city_id']?>"/>
    </div>
    <div class="form-group">
        <input type="text" name="adress" class="form-control" value="<?=$data['tradepoint']['adress']?>"/>
    </div>
    <div class="form-group">
        <input type="text" name="phone" class="form-control" value="<?=$data['tradepoint']['phone']?>"/>
    </div>
    <div class="form-group">
        <input type="text" name="email" class="form-control" value="<?=$data['tradepoint']['email']?>"/>
    </div>
    
    <div class="form-group">
        <textarea name="commentary" class="form-control" ></textarea>
    </div>
    
    <button type="submit" name="update_tradepoint">Обновить</button>
</form>