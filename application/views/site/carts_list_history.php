<div id="main-content">	
	<div class="w960">
		<?php echo $breadcrumbs;?>
		<div class="clear"></div>	
		
		<h2 class="header-h2">Historia zamówień</h2>
		<div id="cart-block-accept">
			<div class="panel-group" id="accordion">
			  <?php
			  foreach($carts as $id_cart=>$cart)
			  {$total_value=0;
			  ?>
				  <div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $cart['id_cart'];?>">
						  Zamówienie z dnia: <?php echo $cart['date_accepted'];?>
						</a>
					  </h4>
					</div>
					<div id="collapse<?php echo $cart['id_cart'];?>" class="panel-collapse collapse">
					  <div class="panel-body">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Nazwa produktu</th><th class="text-right">Cena jedn.</th><th class="text-right">Ilość</th><th class="text-right">Wartość</th>
									</tr>
								</thead>
							<?php foreach ($cart_products[$cart['id_cart']] as $id_product=>$product)
								{
								?>
									<tr>
										<td><?php echo $product['name'];?></td>
										<td class="text-right"><?php echo $product['price'];?> zł</td>
										<td class="text-right">
											<?php echo $product['amount'];?>
										</td>										
										<?php $sum_prod=round($product['amount']*$product['price'],2); $total_value+=$sum_prod;?>
										<td class="text-right"><span id="total_product_<?php echo $id_product;?>"><?php echo number_format($sum_prod,2,',',' ');?></span> zł</td>
										<input type="hidden" id="product_price_<?php echo $id_product;?>"  value="<?php echo $product['price'];?>"/>
										<input type="hidden" id="id_cart_<?php echo $id_product;?>"  value="<?php echo $id_cart;?>"/>
									</tr>				
								<?php
								}
								?>
								<tfoot>
									<tr>
										<th></th><th class="text-right"></th><th></th><th class="text-right">Razem: <span id="total_cart_<?php echo $id_cart;?>" class="total_cart"><?php echo number_format($total_value,2,',',' ');?></span> zł</th>
									</tr>
								</tfoot>
							</table>
						<a href="<?php echo base_url("orders/createCartFromHistory/".$id_cart);?>" class="button pull-right">Utwórz zamówienie</a>
						<div class="clear"></div>
					  </div>
					</div>
				  </div>	
			  <?php
			 
			  }
			  ?>
			</div>
		</div>
		<?php echo $pagination_links;?>
		
	</div>
</div>
