<div class="filter">
<form class="form-inline" method="post" action="">
 <label class="sr-only" for="inlineFormInputGroupUsername1">Username</label>
  <div class="input-group mb-2 mr-sm-2">
    <div class="input-group-prepend">
      <div class="input-group-text">Значение</div>
    </div>
    <input type="text" class="form-control" id="inlineFormInputGroupUsername1" name="value" placeholder="Например, Иванов">
  </div>

  <label class="sr-only" for="inlineFormInputGroupUsername2">Поле</label>
  <div class="input-group mb-2 mr-sm-2">
    <div class="input-group-prepend">
      <div class="input-group-text">Поле</div>
    </div>
    <select class="form-control" id="inlineFormInputGroupUsername2" name="field">
        <option value="last_name">Фамилия</option>
        <option value="first_name">Имя</option>
        <option value="phone">Номер телефона</option>
        <option value="email">email</option>
    </select>
  </div>
  
  
  <button type="submit" class="btn btn-primary mb-2">Поиск</button>
</form>
</div>

<h1>Список заказов</h1>


<div class="scroll-x margin-bottom-30">
<table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Сумма</th>
        <th>Покупатель</th>
        <th>Контакты</th>
        <th>Логин клиента</th>
    </tr>
    <?php foreach($data['orders'] as $order) { ?>
        <tr>
            <td><a href="/manager/order/<?=$order['id']?>/"><?=$order['id']?> открыть</a></td>
             <td></td>
              <td><?=$order['last_name']?> <?=$order['first_name']?></td>
               <td><?=$order['phone']?> <?=$order['email']?></td>
                <td><?=$order['login']?></td>
        </tr>
    <?php } ?>
</table>
</div>


<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="/manager/orders/?page=<?php echo $data['page'] - 1;?>">Пред.</a></li>
    <li class="page-item"><a class="page-link" href="/manager/orders/?page=<?php echo $data['page'] + 1;?>"">След.</a></li>
  </ul>
</nav>