        
        <div class="container container-fluid margin-bottom-50">
		<div class="row">
			<?php require_once('template-parts/sidebar.php');?>
			<div class="col-lg-9 content">
			<div class="margin-bottom-20">
                        <h1><?=$data['request-info']['info']['purchase_name']?></h1>
                            <p class="lead"><?=$data['request-info']['info']['offer']?></p>
                            <?=$data['request-info']['info']['conditions']?>
                        </div>
                            
                            <?php if ( !empty($data['request-info']['info']['categories']) ) { ?>
                            <div class="categories_list_purchase margin-bottom-20">
                                <h2>Список категорий для совместной закупки</h2>
                                <ul>
                                    <?php foreach( $data['categories_list'] as $category ) { ?>
                                        <li><a href="/frontend/category/<?=$category['id']?>/"><?=$category['name']?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php } ?>
                            
                            <p><?php //print_r($data['request-info']['info']['categories']);?></p>
                            
                            <?php if ( !empty($data['request-info']['info']['categories']) ) { ?>
                            <div class="product_list_purchase margin-bottom-20">
                                <h2>Список товаров для совместной закупки</h2>
                                <ul>
                                    <?php foreach( $data['products_list'] as $product ) { ?>
                                        <li>
                                            <?php $product['images'] = explode(',', $product['images']); ?>
                                            <div class="img"><a href="/frontend/product/<?=$product['id']?>/"><img src="<?=$product['images'][0]?>"></a></div>
                                            <div class="title"><a href="/frontend/product/<?=$product['id']?>/"><?=$product['name']?></div></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php } ?>
                            
                            <p><?php //print_r($data['products_list']);?></p>
			</div>
		</div>
	</div>