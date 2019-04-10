
<div class="container container-fluid margin-bottom-50">
	<div class="row">
		<div class="col-lg-8 col-md-12 col-sm-12">
			<h1><?=$data['page-title']?></h1>
			
			<?php //print_r($data['regions']);?>
			
			<?php if ( count($data['cart-info']) == 0 ) { ?>
				<p>Ваша корзина пуста</p>
			<?php } else { ?>
			<div class="scroll-x">
				<table class="table table-bordered table-striped cart-info">
					<tr>
						<th>№ п.п.</th>
						<th>Наименование</th>
						<th>Количество</th>
						<th>Цена</th>
						<th>Действие</th>
					</tr>
					<?php foreach ( $data['cart-info'] as $cart ) { ?>
						<form action="/frontend/redocart/" method="post">
							<input type="hidden" name="id" value=<?=$cart['cart_id']?> />
							<input type="hidden" name="redo_cart" value="1"/>
						<tr>
							<td><?php echo $i + 1; ?></td>
							<td>
								<div class="artno"><?=$cart['artno']?></div>
								<div class="name">
                                                                    <?=$cart['name']?> 
                                                                    <?php 
                                                                    
                                                                        foreach ($cart['charlistfull'] as $char) {

                                                                            echo $char[0]['characteristic_name'].': '.$char[0]['value'].'<br/>';
                                                                        }
                                                                    
                                                                    ?>
								</div>
								<div class="manufacture"><?=$cart['manufacture']?></div>
							</td>
							<td><input type="number" value="<?=$cart['count']?>" style = "max-width:60px !important;" name="count"/></td>
							<td>
							<div><small>Цена поставщика:</small></div>
							<div><?=$cart['cost_price']?></div>
							<div><small>Цена с оргсбором:</small></div>
							<div><?php echo round( $cart['cost_price'] * ( 1 + $cart['markup']/100), 2 );?></div>
							
							</td>
							<td><button type="submit" class="btn btn-transparent"><i class="fa fa-redo"></i></button> <a href="/frontend/deletefromcart/<?=$cart['cart_id']?>" class="btn btn-transparent"><i class="fas fa-ban"></i></a></td>
						</tr>
						</form>
					<?php } ?>
				</table>
			</div>
			<?php } ?>
			
			<?php if ( count($data['second-cart']) > 0 ) { ?>
                            
                            <h2>На вашем компьютере есть еще товары, добавленные в корзину</h2>
                            <p><a class="" href="/frontend/unite_carts/">Объединить корзины</a> <a class="" href="/frontend/clear_sec_cart/">Очистить эту корзину</a></p>
                            
                            <div class="scroll-x">
				<table class="table table-bordered table-striped cart-info">
					<tr>
						<th>№ п.п.</th>
						<th>Наименование</th>
						<th>Производитель</th>
						<th>Количество</th>
						<th>Цена</th>
						<th>Действие</th>
					</tr>
					<?php foreach ( $data['second-cart'] as $cart ) { ?>
						<form action="" method="post">
							<input type="hidden" name="id" value=<?=$cart['cart_id']?> />
							<input type="hidden" name="redo_cart" value="1"/>
						<tr>
							<td><?php echo $i + 1; ?></td>
							<td>
								<div class="artno"><?=$cart['artno']?></div>
								<div class="name"><?=$cart['name']?></div>
							</td>
							<td><?=$cart['manufacture']?></td>
							<td><input type="number" value="<?=$cart['count']?>" name="count"/></td>
							<td>
                                                            <div><small>Цена поставщика:</small></div>
                                                            <div><?=$cart['cost_price']?></div>
                                                            <div><small>Цена с оргсбором:</small></div>
                                                            <div><?php echo round( $cart['cost_price'] * ( 1 + $cart['markup']/100), 2 );?></div>
							</td>
							<td><button type="submit" class="btn btn-transparent"><i class="fa fa-redo"></i></button> <a href="/frontend/deletefromcart/<?=$cart['cart_id']?>" class="btn btn-transparent"><i class="fas fa-ban"></i></a></td>
						</tr>
						</form>
					<?php } ?>
				</table>
			</div>
                            
			<?php } ?>
			

		</div>
		
		<div class="col-lg-4 col-md-12 col-sm-12">
			<?php if ( $data['session_info']['user']['id'] < 1 ) { ?>
				<h4>Вы не авторизовны</h4>
				<p>Авторизайтесь или оформите экспресс-заказ. Если Вы уже зарегистрированы, то выбрав "экспресс-заказ" без авторизации, Вам придет на почту письмо с подтверждением заказа (или наш сотрудник свяжется с Вами). Если Вы не зарегистрированы, то регистрация произойдет автоматически.</p>
				
				<p class="lead"><a class="pointer" data-toggle="modal" data-target="#login">Авторизоваться</a></p>
				<p class="lead"><a href="/frontend/expressorder/">Экспресс-заказ</a></p>
				
			<?php } else { ?>
                            <h1>Экспресс-оформление заказа</h1>
                            
			<form action="/frontend/order/" method="post">
				<div class="form-group">
					<input class="form-control" type="text" name="phone" placeholder="Номер телефона" value="<?=$data['session_info']['user']['phone']?>"/>
				</div>
				<div class="form-group">
					<input class="form-control" type="text" name="email" value="<?=$data['session_info']['user']['email']?>"/>
				</div>
				<formgroup>
				<div class="form-group">
					<select name="region_id" id="id_region" class="form-control sensitive" data-sensitive="getcities" data-sensitive-target="#id_city" data-tarval='id_city' data-tartext="name">
						<option value="30">Краснодарский край</option>
						<hr/>
						<?php foreach( $data['regions'] as $region ) { ?>
                                                    <option value="<?=$region['id_region']?>"><?=$region['name']?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<select class="form-control sensitive" name="id_city" id="id_city" data-sensitive="getpoints" data-sensitive-target="#tradepoint_id" data-tarval='id' data-tartext="name">
                                            <?php foreach ($data['cities'] as $city) {?>
                                                <?php if ($city['name']== 'Краснодар') { ?>
                                                    <option value="<?=$city['id_city']?>" selected><?=$city['name']?></option>
                                                <?php } else { ?>
                                                    <option value="<?=$city['id_city']?>"><?=$city['name']?></option>
                                                <?php } ?>
                                            <?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Пункт самовывоза</label>
					<select name="tradepoint_id" id="tradepoint_id" class="form-control">
                                            <?php foreach ($data['tradepoints'] as $tradepoint) {?>
						<option value="<?=$tradepoint['id']?>"><?=$tradepoint['name']?></option>
                                            <?php } ?>
					</select>
				</div>
				
				</formgroup>
				<input type="submit" name="order" class="btn btn-primary" value="Оформить"/>
			</form>
			<?php } ?>
		</div>
		
	</div>
</div>

