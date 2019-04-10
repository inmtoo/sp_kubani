<!--CATALOG-->
	
	<div class="container container-fluid margin-bottom-50">
		<div class="row">
			<?php require_once('template-parts/sidebar.php');?>
			<div class="col-lg-9 content">
				<div class="product-list-block">
					<div class="headline margin-bottom-40">
						<h1><?=$data['category']['category']['name']?></h1>
						<?=$data['category']['category']['content']?>
					</div>
					
					<div class="dauther margin-bottom-40">
                                            <ul class="dauther-list">
                                                <?php foreach ( $data['category']['dauther'] as $dauther ) { ?>
                                                    <li><a href="/frontend/category/<?=$dauther['id']?>"><?=$dauther['name']?></a></li>
                                                <?php } ?>
                                            </ul>
					</div>
					
					<div class="row row-list">
					
					<?php foreach( $data['category']['products'] as $product ) { ?>
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