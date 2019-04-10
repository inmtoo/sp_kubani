<!--MAIN-->
<div class="parscreen">		
<div class="container container-fluid main-screen-1 text-center margin-bottom-50">
	<div class="row">
		
		<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
			<h1>Сервис совместных покупок</h1>
			<p class="lead">Введите адрес страницы товара с сайтов <a href="http://sima-land.ru">sima-land.ru</a>, <a href="http://happywear.ru">happywear.ru</a></p>
			<form method="post" action="/frontend/getproduct/">
				<div class="input-group mb-3">
					<input type="text" class="form-control" name="url" placeholder="HTTP://" aria-label="URL страницы товара" aria-describedby="basic-addon2">
					<div class="input-group-append">
						<button class="btn btn-primary" type="submit">Вперед</button>
					</div>
				</div>
			</form>
		</div>
		
	</div>
</div>
</div>

<!--CATALOG-->
	
	<div class="container container-fluid margin-bottom-50">
		<div class="row">
			<?php require_once('template-parts/sidebar.php');?>
			<div class="col-lg-9 content">
				<div class="product-list-block">
					<div class="headline">
						<h2>Новое на нашем сайте</h2>
					</div>
					<div class="row row-list">
					
					<?php foreach( $data['lastproducts'] as $product ) { ?>
						<div class="col-sm-3 col-xs-6 item">
							<div class="img"><a href="/frontend/product/<?=$product['id']?>/"><img src="<?=$product['preview']?>" class="img-fluid"></a></div>
							<div class="caption">
								<div class="title"><a href="/frontend/product/<?=$product['id']?>/"><?=$product['name']?></a></div>
								<div class="addinfo">
									<form action="" method="post">
									<input type="hidden" name="product_id" value="<?=$product['id']?>" />
									<input type="hidden" name="addtocart" value="add">
									<span class="price"><?php echo $product['cost_price'] + ( $product['cost_price']/100*$product['markup'] ); ?></span>   <span class="currency"><?=$product['currency']?>.</span>									
									<div class="input-group mb-3">
									<input type="number" name="count" class="form-control" value=1 aria-label="Recipient's username" aria-describedby="basic-addon2">
									<div class="input-group-append">
									<button class="btn btn-outline-secondary" type="submit"><i class="fa fa-cart-plus"></i></button>
									</div>
									</div>
									</form>
								</div>
							</div>
						</div>
					<?php } ?>	
						
					</div>
				</div>
			</div>
		</div>
	</div>
	
<!--/CATALOG-->
		
	<!--/MAIN-->
