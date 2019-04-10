<div class="container container-fluid margin-bottom-50">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12">
			<h1>Экспресс-оформление заказа</h1>
			<form action="/frontend/expressorder/" method="post">
				<div class="form-group">
					<input class="form-control" type="text" name="first_name" placeholder="Ваше имя"/>
				</div>
				<div class="form-group">
					<input class="form-control" type="text" name="last_name" placeholder="Ваша фамилия"/>
				</div>
				<div class="form-group">
					<input class="form-control" type="text" name="phone" placeholder="Номер телефона"/>
				</div>
				<div class="form-group">
					<input class="form-control" type="text" name="email" placeholder="email"/>
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
				<input type="submit" name="expressorder" class="btn btn-primary" value="Оформить"/>
			</form>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12"></div>
	</div>
</div>
