<div class="form margin-bottom-40">
    <form action="" method="post">
        <div class="form-group">
            <input type="text" placeholder="Название группы" name="status-name" class="form-control"/>
        </div>
        <input type="submit" class="btn btn-primary" value="Добавить"/>
    </form>
</div>

<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Название</th>
    </tr>
    <?php foreach( $data['statuses'] as $status  ) { ?>
        <tr>
            <td><?=$status['id']?></td>
            <td><a href="/manager/status/<?=$status['id']?>"><?=$status['name']?></a> <a href="/manager/status_delete/<?=$status['id']?>"><i class="fa fa-minus-circle"></i></a></td>
        </tr>
    <?php } ?>
</table>