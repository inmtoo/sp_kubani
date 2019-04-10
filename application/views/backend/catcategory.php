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
		<h2><?=$data['category']['category']['name']?></h2>
		<p><a class="btn btn-primary" href="/manager/category_edit/<?=$data['category']['category']['id']?>/">Редактировать</a> <a class="btn btn-primary" href="/manager/category_add/<?=$data['category']['category']['id']?>/">Добавить категорию</a> <a class="btn btn-primary" href="/manager/product_add/<?=$data['category']['category']['id']?>/">Добавить товар</a></p>

		<?=$data['category']['category']['content']?>
	</div>
	
	<div class="dauther margin-bottom-40">
                                            <ul class="dauther-list">
                                                <?php foreach ( $data['category']['dauther'] as $dauther ) { ?>
                                                    <li><a href="/manager/cat_category/<?=$dauther['id']?>"><?=$dauther['name']?></a></li>
                                                <?php } ?>
                                            </ul>
					</div>
	
	<div class="row row-list">
					
	<?php foreach( $data['category']['products'] as $product ) { ?>
		<div class="col-sm-3 col-xs-6 item">
			<div class="img"><a href="/frontend/product/<?=$product['id']?>/"><img src="<?=$product['preview']?>" class="img-fluid"></a></div>
				<div class="caption">
					<div class="product_name"><a href="/manager/product/<?=$product['id']?>/"><?=$product['name']?></a></div>
					<div class="addinfo">
					<span class="price"><?=$product['cost_price']?></span>   <span class="currency"><?=$product['currency']?>.</span></div>
                                </div>
			</div>
                <?php } ?>	
						
                </div>
</div>