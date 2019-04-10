

<form action="/manager/position_action/<?=$data['order_id']?>/" method="post">
<div class="panel panel-actions">
    <h4>Действия с отмеченными позициями:</h4>
    <div class="row">
        <div class = "col-lg-4 col-md-4 col-sm-12">
            <select class="form-control" name="action">
                <option value="1">Сменить состояние</option>
                <option value="2">Провести оплаты</option>
                <option value="3">Снять оплаты</option>
                <option value="4">Сохранить изменения</option>
            </select>
        </div>
        <div class = "col-lg-4 col-md-4 col-sm-12">
             <select class="form-control" name="status_id">
             <?php foreach( $data['statuses'] as $status ) { ?>
                <option value="<?=$status['id']?>"><?=$status['name']?></option>
             <?php } ?>
            </select>
        </div>
        <div class = "col-lg-4 col-md-4 col-sm-12">
            <button type="submit" class= "btn btn-primary">Выполнить</button>
        </div>
    </div>
    
</div>

<div class="scroll-x">
    <table class="table table-bordered table-striped">
        <tr>
            <th></th>
            <th>Наименование</th>
            <th>Артикул</th>
            <th>Производитель</th>
            <th>Кол-во</th>
            <th>Поставщик</th>
            <th>Цена</th>
            <th>Цена закупки</th>
            <th>Сумма</th>
            <th>Сумма закупки</th>
            <th>Баланс позиции</th>
            <th>Комментарий</th>
        </tr>
        
        <?php 
            $sum = 0;
            $cost_sum = 0;
        ?>
        
        <?php foreach( $data['order']['positions'] as $position ) { ?>
            <tr class="status_<?=$position['status_1']?>">
                <td><input type="checkbox" name="position_id[]" class="checkbox" value="<?=$position['id']?>"> <small><?=$position['status_name']?></small></td>
                <td><a href="/manager/position/<?=$position['id']?>/"><?=$position['name']?></a></td>
                <td><?=$position['artno']?></td>
                <td><?=$position['manufacture']?></td>
                <td><?=$position['qnt']?></td>
                <td><?=$position['provider_name']?></td>
                <td><input type="text" size=5 value="<?=$position['price']?>" name="price[]"/></td>
                <td><?=$position['cost_price']?></td>
                <td><?php echo $position['price'] * $position['qnt']; ?></td>
                <td><?php echo $position['cost_price'] * $position['qnt']; ?></td>
                <td><?=$position['balance']?></td>
                <td><?=$position['comment']?></td>
            </tr>
            
            <?php
                $sum = $sum + $position['price'] * $position['qnt'];
                $cost_sum = $cost_sum + $position['cost_price'] * $position['qnt'];
            ?>
        <?php } ?>
        
        <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th><?=$sum?></th>
                <th><?=$cost_sum?></th>
                <th></th>
        </tr>
        
    </table>
</div>

</form>