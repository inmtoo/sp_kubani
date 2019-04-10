<div class="form margin-bottom-40">
    <form action="" method="post">
        <div class="form-group">
            <input type="text" placeholder="Название группы" name="group-name" class="form-control"/>
        </div>
        <input type="submit" class="btn btn-primary" value="Добавить"/>
    </form>
</div>

<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Описание</th>
    </tr>
    <?php foreach( $data['user-groups'] as $group  ) { ?>
        <tr>
            <td><?=$group['id']?></td>
            <td><?=$group['user_group']?></td>
            <td><?=$group['description']?></td>
        </tr>
    <?php } ?>
</table>