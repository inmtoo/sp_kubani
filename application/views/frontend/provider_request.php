<div class="container container-fluid margin-bottom-40">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h1><?=$data['page-title']?></h1>
           <div class="scroll-x">
           <table class="table table-bordered table-striped">
                <tr>
                    <th>Наименование</th>
                    <th>Производитель</th>
                    <th>Артикул</th>
                    <th>Цена</th>
                    <th>Кол-во</th>
                    <th>Сумма</th>
                </tr>
                
                <?php foreach( $data['positions'] as $position ) { ?>
                <tr>
                    <td><?=$position['name']?></td>
                    <td><?=$position['manufacture']?></td>
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