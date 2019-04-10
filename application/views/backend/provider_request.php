<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h1>Информация о заявке <?=$data['request-info']['info']['request_id']?></h1>
        <p>Наценка за доставку: <?=$data['request-info']['info']['delivery_cost']?></p>
        <p>Наценка на закупку: <?=$data['request-info']['info']['markup']?></p>
        <p>Наценка поставщика: <?=$data['request-info']['info']['provider_markup']?></p>
        <h2>Выслать уведомления</h2>
        <p>Если заявка сформирована, Вы завершили ее сбор, то можете выслать уведомления пользователям.</p>
        <p><a class="btn btn-primary" href="/manager/provider_request_sendconfirm/<?=$data['request-info']['info']['request_id']?>">Уведомить пользователей</a></p>
        <h2>Позиции вне заявки</h2>
        <p>Позиции данного поставщика, которые не вошли еще ни в одну заявку</p>
        <form action="/manager/positions_to_provider_request/<?=$data['request-info']['info']['request_id']?>/<?=$data['request-info']['info']['provider_id']?>" method="post">
            <table class="table table-striped">
                <tr>
                    <th></th>
                    <th>Позиция заказа</th>
                    <th>Цена и кол-во</th>
                    <th>Сумма</th>
                     <th>Сумма закупки</th>
                    <th>Логин</th>
                    <th>Телефон</th>
                    <th>Почта</th>
                </tr>
                <?php foreach ( $data['request-info']['positions-no-order'] as $position ) { ?>
                    <tr>
                        <td><input type="checkbox" name="order_positions_id[]" value="<?=$position['id']?>"></td>
                        <td><?=$position['name']?> <?=$position['artno']?> <?=$position['manufacture']?></td>
                        <td><?=$position['price']?> Х <?=$position['qnt']?></td>
                        <td><?php echo $position['price'] * $position['qnt']?></td>
                        <td><?php echo $position['cost_price'] * $position['qnt'];?></td>
                        <td><?=$position['login']?></td>
                        <td><?=$position['phone']?></td>
                        <td><?=$position['email']?></td>
                    </tr>
                <?php } ?>
                <p><input type="submit" name="btn btn-primary" value="Оформить заказ"/></p>
            </table>
        
        </form>
        
        
         <h2>Позиции в заявке</h2>
        <p>Позиции данного поставщика, которые уже в этой заявке</p>
        <form action="/manager/position_action/" method="post">
        <input type="hidden" name="redirect" value="manager/provider_request/view/<?=$data['request-info']['info']['request_id']?>/"/>
        <div class="row margin-bottom-20">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <select class="form-control" name="action">
                <option value="1">Сменить состояние</option>
                <option value="2">Провести оплаты</option>
                <option value="3">Снять оплаты</option>
                <option value="4">Сохранить изменения</option>
            </select>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
             <select class="form-control" name="status_id">
            <?php foreach( $data['statuses'] as $status ) { ?>
                <option value="<?=$status['id']?>"><?=$status['name']?></option>
             <?php } ?>
            </select>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <button type="submit" class="btn btn-primary">Выполнить</button>
        </div>
    </div>
    

        <div class="scroll-x">
                <table class="table table-striped">
                    <tr>
                        <th></th>
                        <th>Позиция заказа</th>
                        <th>Цена и кол-во</th>
                        <th>Сумма</th>
                        <th>Сумма закупки</th>
                        <th>Логин</th>
                        <th>Телефон</th>
                        <th>Почта</th>
                    </tr>
                    <?php foreach ( $data['request-info']['positions-in-order'] as $position ) { ?>
                        <tr>
                            <td><input type="checkbox" name="position_id[]" value="<?=$position['id']?>"><br/> 
                            ID: <?=$position['id']?><br/><small><?=$position['status_name']?></small>
                            
                            </td>
                            <td><?=$position['name']?> <?=$position['artno']?> <?=$position['manufacture']?></td>
                            <td><?=$position['price']?> Х <?=$position['qnt']?></td>
                            <td><?php echo $position['price'] * $position['qnt']?></td>
                            <td><?php echo $position['cost_price'] * $position['qnt'];?></td>
                            <td><?=$position['login']?></td>
                            <td><?=$position['phone']?></td>
                            <td><?=$position['email']?></td>
                        </tr>
                    <?php } ?>

                </table>
            </div>
        </form>
        
    </div>
</div>