<h1>Менеджеры торговых точек</h1>

<div class="scroll-x">
    <table class="table table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>ФИО</th>
            <th>Логин</th>
            <th>Торговая точка</th>
            <th>Конакты</th>
        </tr>
        <?php foreach ($data['managers'] as $manager) {?>
        <tr>
            <td><?=$manager['id']?></td>
            <td><a href="/manager/tradepoint_manager/<?=$manager['id']?>/"><?=$manager['sirname']?> <?=$manager['name']?> <?=$manager['fathername']?></a></td>
            <td><?=$manager['login']?></td>
            <td><?=$manager['tradepoint']?></td>
            <td><?=$manager['phone']?> <?=$manager['email']?></td>
        </tr>
        <?php } ?>
    </table>
</div>