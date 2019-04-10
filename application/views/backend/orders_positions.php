

<form action="/manager/position_action/" method="post">
<input type="hidden" name="redirect" value="manager/orders_positions"/>
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

<div class="scroll-x margin-bottom-30">
    <table class="table table-bordered">
        <tr>
            <th></th>
            <th>Наименование</th>
            <th>Артикул</th>
            <th>Производитель</th>
            <th>Цена</th>
            <th>Кол-во</th>
            <th>Сумма</th>
            <th>Поставщик</th>
            <th>Сумма закупа</th>
            <th>Клиент</th>
            <th>Номер телефона</th>
            <th>Email</th>
            <th>Оплачено</th>
        </tr>
        
        <?php foreach ($data['orders_positions'] as $position) {?>
        <tr>
            <td><input type="checkbox" name="position_id[]" class="checkbox" value="<?=$position['position_id']?>"> <small><?=$position['status_name']?></small></td>
            <td><a href="/manager/position/<?=$position['position_id']?>/"><?=$position['position_name']?></a></td>
            <td><?=$position['artno']?></th>
            <td><?=$position['manufacture']?></td>
            <td><input type="text" size=5 value="<?=$position['price']?>" name="price[]"/></td>
            <td><input type="text" size=5 value="<?=$position['qnt']?>" name="qnt[]"/></td>
            <td><?php echo $position['price'] * $position['qnt']; ?></td>
            <td>Поставщик</td>
            <td><?php echo $position['cost_price'] * $position['qnt']; ?></td>
            <td><?=$position['last_name']?> <?=$position['first_name']?> <?=$position['login']?></td>
            <td><?=$position['phone']?></td>
            <td><?=$position['email']?></td>
            <td><?=$position['balance']?></td>
        </tr>
        <?php } ?>
        
    </table>
</div>
</form>


<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="/manager/orders_positions/?page=<?php echo $data['page'] - 1;?>">Пред.</a></li>
    <li class="page-item"><a class="page-link" href="/manager/orders_positions/?page=<?php echo $data['page'] + 1;?>"">След.</a></li>
  </ul>
</nav>