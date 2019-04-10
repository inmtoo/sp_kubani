<div class="container container-fluid margin-bottom-40">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1>Вы можете оплатить заказ <?=$data['order-info']['order']['id']?></h1>
            <p><strong>Сумма заказа:</strong> <?=$data['order-info']['sum']?></p>

                <p><strong>Пополните баланс:</strong> на <?=$data['order-info']['sum']?></p>

            
            <div class="scroll-x">
                <table class="table table-striped">
                    <tr>
                        <th>Наименование</th>
                         <th>Цена</th>
                          <th>Кол-во</th>
                          <th>Сумма</th>
                    </tr>
                    <?php foreach($different = $data['order-info']['positions'] as $position) { ?>
                         <tr>
                        <td><?=$position['name']?></td>
                         <td><?=$position['price']?></td>
                          <td><?=$position['qnt']?></td>
                          <td><?php echo $position['price']* $position['qnt'];?></td>
                    </tr>
                    <?php }  ?>
                </table>
            </div>
        </div>
    </div>
</div>

