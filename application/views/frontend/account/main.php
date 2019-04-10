<div class="container container-fluid margin-bottom-40">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h1>Личный кабинет</h1>
            
            <?php 
                $message['password']['true'] = '<p>Пароль успешно изменен</p>';
                $message['password']['false'] = '<p>Не удалось изменить пароль. Старый пароль указан неверно для этого пользователя.</p>';
                $message['phone']['true'] = 'Номер телефона успешно изменен';
                
            ?>
            
            <?=$message['password'][$_GET['changepassword']]?>
            <?=$message['phone'][$_GET['returnphone']]?>
            
            <h4>Управление заказами</h4>
            <ul class="cab-menu">
                <li><a href="/frontend/orders/">Список заказов</a></li>
            </ul>
            
            <h4>Регистрационные данные</h4>
            
            <form action="" method="post">
                <input type="hidden" name="account" value="true"/>
                <div class="form-group">
                    <label>Номер телефона</label>
                    <input type="text" name="phone" class="form-control" value="<?=$data['session_info']['user']['phone']?>"/>
                </div>
                <h3>Смена пароля</h3>
                <div class="form-group">
                    <label>Старый пароль</label>
                    <input type="password" name="password" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Новый пароль</label>
                    <input type="password" name="password_new" class="form-control"/>
                </div>
                <button type="submit" class="btn btn-primary">Изменить</button>
            </form>
            
        </div>
    </div>
</div>
