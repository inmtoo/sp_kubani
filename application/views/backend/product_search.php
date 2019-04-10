<form action="/manager/productsearch/">
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <button class="btn btn-outline-secondary" type="submit">Поиск</button>
  </div>
  <input type="text" name="productname" class="form-control" placeholder="Поиск по названию"  aria-describedby="basic-addon1">
</div>
</form>


<div class="product-list-block">
	<div class="headline margin-bottom-40">
		<h2>Результат поиска товара</h2>
	</div>
	<div class="row row-list">
					
	<?php foreach( $data['products'] as $product ) { ?>
		<div class="col-sm-3 col-xs-6 item">
			<div class="img"><a href="/frontend/product/<?=$product['id']?>/"><img src="<?=$product['preview']?>" class="img-fluid"></a></div>
				<div class="caption">
					<div class="product_name"><a href="/manager/product/<?=$product['id']?>/"><?=$product['name']?></a></div>
					<div class="addinfo">
					<span class="price"><?=$product['price']?></span>   <span class="currency"><?=$product['currency']?>.</span></div>
                                </div>
			</div>
                <?php } ?>	
						
         </div>
</div>