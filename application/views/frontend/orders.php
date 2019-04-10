<div class="container container-fluid margin-bottom-40">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h1>Мои заказы</h1>
            <table class="table table-bordered table-stripped">
                <tr>
                    <th>№ заказа</th>
                    <th>Дата и время</th>
                    <th>Сумма</th>
                </tr>
               <?php foreach( $data['orders'] as $order ) { ?>
                    <tr>
                    <td><a href="/frontend/orderinfo/<?=$order['id']?>/"><?=$order['id']?> <small>Открыть</small></a></td>
                    <td><?=$order['date']?> <?=$order['time']?></td>
                    <td><?=$order['sum']?></td>
                </tr>
               <?php } ?>
            </table>
        </div>
    </div>
</div>



