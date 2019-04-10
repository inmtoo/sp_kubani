<div class="container container-fluid margin-bottom-40">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h1><?=$data['page-title']?></h1>
            
            <?php //print_r($data['positions']);?>
            
           <div class="scroll-x">
           <table class="table table-bordered table-striped">
                <tr>
                    <th>Наименование</th>
                    <th>Статус</th>
                    <th>Артикул</th>
                    <th>Цена</th>
                    <th>Кол-во</th>
                    <th>Сумма</th>
                </tr>
                
                <?php foreach( $data['positions'] as $position ) { ?>
                <tr>
                    <td><?=$position['name']?> 
                    <?php if ($position['request_provider_id'] > 0) { ?>
                        (<a href="/frontend/request_provider/<?=$position['request_provider_id']?>/">заявка <?=$position['request_provider_id']?></a>)
                    <?php } ?>
                    </td>
                    <td><?=$position['status']?></td>
                    <td><?=$position['artno']?></td>
                    <td><?=$position['price']?></td>
                    <td><?=$position['qnt']?></td>
                    <td><?php echo $position['price']*$position['qnt'] ?></td>
                </tr>
                <?php } ?>
                
           </table>
           </div>
           
        </div>
    </div>
</div>