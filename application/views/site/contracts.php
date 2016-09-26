<div id="main-content">	
	<div class="w960">
		<?php echo $breadcrumbs; ?>
		<div class="clear"></div>	
		
		<h2 class="header-h2">Kontrakty</h2>
		<div id="cart-block-accept">
			<div class="panel-group" id="accordion">
			  <?php
			  foreach($contracts as $id_contract=>$contract)
			  {
			  ?>
				  <div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $id_contract;?>">
						  <?php echo $contract['name']; ?>
						</a>
					  </h4>
					</div>
					<div id="collapse<?php echo $id_contract;?>" class="panel-collapse collapse">
					  <div class="panel-body">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Nazwa produktu</th><th class="text-right">Cena jedn. netto</th><th class="text-right">Cena jedn. brutto</th><th class="text-right">Ilość</th><th class="text-right">Pozostało</th>
									</tr>
								</thead>
							<?php 							
							foreach ($contracts_products[$id_contract] as $id_product=>$product)
								{								
								?>
									<tr>
										<td><?php echo $product['name'];?></td>
										<td class="text-right"><?php echo  number_format($product['price'],2,',','')." zł" ;?> </td>
										<td class="text-right">
											<?php echo  number_format($product['price']+($product['price']*$product['vat']/100),2,',','')." zł" ;?> 
										</td>										
										<td class="text-right"><?php echo $product['amount'];?> </td>
										<td class="text-right"><?php echo $product['amount_left'];?> </td>
									</tr>				
								<?php
								}
								?>
							</table>			
						<div class="clear"></div>
					  </div>
					</div>
				  </div>	
			  <?php
				}
			  ?>
			</div>
		</div>		
	</div>
</div>
