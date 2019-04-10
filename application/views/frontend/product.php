
<?php $images = explode (';', $data['object']['images'] );?>
<!--CATALOG-->
	
	<div class="container container-fluid margin-bottom-50">
		<div class="row">
			<?php require_once('template-parts/sidebar.php');?>
			<div class="col-lg-9 content">
				<div class="row">
	
		<div class="col-md-7 col-sm-12 col-xs-12 object">
			<h1><?php echo $data['object']['name'];?></h1>
			<div class="price"><span><?php echo round( $data['object']['cost_price']*(1 + $data['object']['markup']/100), 2 ) ?> руб.</span></div>
			<div class="full_price"><small>Организаторский сбор <?=$data['object']['markup']?>%, + цена поставщика <?=$data['object']['cost_price']?> руб.</small></div>
			<div class="min_order">От <?=$data['object']['min_order']?> шт. Собрано <?=$data['object']['row']?></div>
			
			<div class="images">
				<ul class="image-list">
					<?php foreach ( $images as $image ) { ?>
						<li><img src="<?php echo $image;?>"/></li>
					<?php } ?>
				</ul>
			</div>
	
		</div>
		<div class="col-md-5 col-sm-12 col-xs-12 user-form-inform">
			<h2>Добавить в корзину</h2>
			<form class="" method="post">
                                <input type="hidden" name="product_id" value="<?=$data['object']['id']?>" />
                                <input type="hidden" name="addtocart" value="add">
                                
                                <?php foreach ($data['characteristics'] as $characteristic) {
                                
                                    if( $characteristic['optional'] == 1 ) { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="characteristic_id[]" id="exampleRadios1" value="<?=$characteristic['characteristic_id']?>" >
                                            <label class="form-check-label" for="exampleRadios1">
                                               <?=$characteristic['characteristic_name']?>: <?=$characteristic['value']?>
                                            </label>
                                        </div>
                                  <?php  } else {
                                  
                                        echo '<p>'.$characteristic['characteristic_name'].': '.$characteristic['value'].'</p>';
                                  }
                                
                                } ?>
                                
				<div class="form-group">
				<label>Количество</label>
				<input type="number" name="count"  class="form-control" value = 1 /></div>
				<input type="submit" class="btn btn-primary" value="Добавить в  покупки"/>
			</form>
		</div>
		
	</div>
			</div>
		</div>
	</div>
	
<!--/CATALOG-->
