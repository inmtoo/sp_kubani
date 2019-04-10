<div class="row provider-request-form">
    <div class="col-md-6 col-sm-12 margin-bottom-20">
        <form action="" method="post" class="margin-bottom-30">
             <div class="form-group">
                <label>Название закупки</label>
                <input type="text" name="name" class="form-control"/>
             </div>
            <div class="form-group">
                <select class="form-control" name="provider_id">
                    <label>Поставщик</label>
                    <?php foreach ($data['providers'] as $provider) { ?>
                        <option value="<?=$provider['id']?>"><?=$provider['name']?></option>
                        
                    <?php } ?>
                </select>
            </div>
            <div class="row margin-bottom-10">
                <div class="form-group col-md-6 col-sm-12">
                    <label>Стоп-дата</label>
                    <input type="date" name="stop_date" class="form-control"/>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label>Дата отгрузки</label>
                    <input type="date" name="delivery_date" class="form-control"/>
                </div>
            </div>
            
            <div class="row margin-bottom-10">
                <div class="form-group col-md-6 col-sm-12">
                    <label>Сумма</label>
                    <input type="text" name="sum" class="form-control"/>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label>Сумма доставки</label>
                    <input type="text" name="delivery_cost" class="form-control"/>
                </div>
            </div>
            
             <div class="row margin-bottom-10">
                <div class="form-group col-md-6 col-sm-12">
                    <label>Тип наценки дост.</label>
                    <select name="delivery_cost_unit" class="form-control">
                        <option value="1">Процент</option>
                        <option value="2">Рубли</option>
                    </select>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label>Тип распределения</label>
                    <select name="deliver_distribution" class="form-control">
                        <option value="1">На все позиции</option>
                        <option value="2">На каждую</option>
                    </select>
                </div>
            </div>
            
           
            <div class="from-group margin-bottom-10">
                <labael>Наценка, %</label>
                <input type="text" class="form-control" name="markup"/>
            </div>
    
            <div class="from-group margin-bottom-10">
                <labael>Условия поставки</label>
                <textarea class="form-control" name="conditions"></textarea>
            </div>
            
            <div class="row margin-bottom-10">
                <div class="form-group col-md-6 col-sm-12">
                    <label>Категории</label>
                    <input type="text" name="categories" class="form-control"/>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label>Продукты</label>
                    <input type="text" name="products" class="form-control"/>
                </div>
            </div>
            
             <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control"/>
             </div>
            
             <div class="row margin-bottom-10">
                <div class="form-group col-md-6 col-sm-12">
                    <label>Keywords</label>
                    <input type="text" name="keywords" class="form-control"/>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label>Description</label>
                    <input type="text" name="description" class="form-control"/>
                </div>
            </div>
            
             <div class="row margin-bottom-10">
                <div class="form-group col-md-6 col-sm-12">
                    <label>Offer</label>
                    <input type="text" name="offer" class="form-control"/>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label>CTA</label>
                    <input type="text" name="cta" class="form-control"/>
                </div>
            </div>
            
                
            <input type="submit" name="add-provider-request" class="btn btn-primary" value="Создать"/>
        </form>
        
        <h2>Открытые заявки поставщикам</h2>
        <ul class="providers_requests">
            <?php foreach( $data['openrequests'] as $openrequest ) { ?>
                <li>
                    <div class="request-name"><?=$openrequest['request_name']?> - <i><?=$openrequest['name']?></i></div>
                    <div class="info"><a href="/manager/provider_request/view/<?=$openrequest['request_id']?>/">ID <?=$openrequest['request_id']?>, <?=$openrequest['stop_date']?> / <?=$openrequest['delivery_date']?></a>. <?=$openrequest['name']?> 
                    
                    </div>
                    <div class="actions"><?php echo $openrequest['sums']['sum_total']; ?> / <?=$openrequest['sum']?> (<?php echo $openrequest['sums']['sum_total'] / $openrequest['sum'] *100; ?>%) <a href="/manager/provider_request/stop/<?=$openrequest['request_id']?>/">Завершить</a> <a href="/manager/provider_request/delete/<?=$openrequest['request_id']?>/">Удалить</a></div>
                </li>
            <?php } ?>
        </ul>
        
    </div>
    
    <div class="col-md-6 col-sm-12">
    
    <h2>Стоп-дата</h2>
        <ul class="providers_requests">
            <?php foreach( $data['stoprequests'] as $stoprequest ) { ?>
                <li>
                    <div class="request-name"><?=$stoprequest['request_name']?> - <i><?=$stoprequest['name']?></i></div>
                    <div class="info"><a href="/manager/provider_request/view/<?=$stoprequest['request_id']?>/">ID <?=$stoprequest['request_id']?>, <?=$stoprequest['stop_date']?> / <?=$stoprequest['delivery_date']?>. <?=$stoprequest['name']?> </a>
                    
                    </div>
                    <div class="actions"><?php echo $stoprequest['sums']['sum_total']; ?> / <?=$stoprequest['sum']?> (<?php echo $stoprequest['sums']['sum_total'] / $stoprequest['sum'] *100; ?>%) <a href="/manager/provider_request/stop/<?=$stoprequest['request_id']?>/">Завершить</a> <a href="/manager/provider_request/delete/<?=$stoprequest['request_id']?>/">Удалить</a></div>
                </li>
            <?php } ?>
        </ul>
        
        <h2>Все заявки</h2>
        <ul class="providers_requests">
            <?php foreach( $data['requests'] as $request ) { ?>
                <li>
                    <div class="request-name"><?=$request['request_name']?></div>
                    <div class="info"><a href="/manager/provider_request/view/<?=$request['request_id']?>/">ID <?=$request['request_id']?>, <?=$request['stop_date']?> / <?=$request['delivery_date']?>. <?=$request['name']?> </a>
                    
                    </div>
                    <div class="actions"><?php echo $request['sums']['sum_total']; ?> / <?=$request['sum']?> (<?php echo $request['sums']['sum_total'] / $request['sum'] *100; ?>%) <a href="/manager/provider_request/stop/<?=$request['request_id']?>/">Завершить</a>
                </li>
            <?php } ?>
        </ul>
        
    </div>
</div>