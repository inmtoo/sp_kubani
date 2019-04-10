<h1>Управление торговыми точками</h1>

<div class="scroll-x">
    <table class="table table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>название</th>
            <th>Адрес</th>
            <th>Контакты</th>
        </tr>
        <tr>
            <?php foreach ($data['tradepoints'] as $tradepoint) { ?>
                <td><?=$tradepoint['id']?></td>
                <td><a href="/manager/tradepoint/<?=$tradepoint['id']?>/"><?=$tradepoint['name']?></a></td>
                <td><?=$tradepoint['region']?> <?=$tradepoint['city']?> <?=$tradepoint['adress']?></td>
                <td><?=$tradepoint['phone']?> <?=$tradepoint['email']?></td>
           <?php } ?>
        </tr>
    </table>
</div>