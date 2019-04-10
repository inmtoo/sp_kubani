			<div class="col-lg-3 sidebar">
				<nav class="navbar bg-light">

				<!-- Links -->
					<ul class="navbar-nav margin-bottom-30">
					<?php for( $i = 0; $i < count( $data['categories_tree'] ); $i++ ) { ?>
						<li class="nav-item">
							<a class="nav-link" href="/frontend/category/<?php echo $data['categories_tree'][$i]['id'];?>/"><?php echo $data['categories_tree'][$i]['name'];?></a>
						</li>
					<?php } ?>
					</ul>
					
					<h4>Текущие закупки</h4>
					 <ul class="providers_requests">
                                            <?php foreach( $data['openrequests'] as $openrequest ) { ?>
                                                <li>
                                                    <div class="info">
                                                    <div class="status"><a href="/frontend/purchase/<?=$openrequest['request_id']?>/"><?=$openrequest['stop_date']?> / <?=$openrequest['delivery_date']?></a>.</div> 
                                                    <div class="provider"><?=$openrequest['name']?></div> 
                                                    
                                                    </div>
                                                    <div class="actions"><?php echo $openrequest['sums']['sum_total']; ?> / <?=$openrequest['sum']?> (<?php echo $openrequest['sums']['sum_total'] / $openrequest['sum'] *100; ?>%)</div>
                                                </li>
                                            <?php } ?>
                                        </ul>

				</nav>
			</div>
