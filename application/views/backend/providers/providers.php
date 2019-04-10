<div class="margin-bottom-40">
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addprovider">
  Добавить поставщика
</button>
</div>


<table class="table table-bordered table-striped">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Контакты</th>
    </tr>
    
    <?php foreach( $data['providers'] as $provider ) { ?>
        <tr>
            <td><?=$provider['id']?></td>
            <td><a href="/manager/provider/<?=$provider['id']?>/"><?=$provider['name']?></a></td>
            <td><?=$provider['email']?> <?=$provider['phone']?></td>
        </tr>
    <?php } ?>
    
</table>



<!-- Modal -->
<div class="modal fade" id="addprovider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>