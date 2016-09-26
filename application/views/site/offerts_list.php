<div id="main-content">	
	<div class="w960">
		<?php echo $breadcrumbs;?>
		<div class="clear"></div>	
		
		<h2 class="header-h2">Aktywne oferty</h2>
		<div id="cart-block-accept">
			<ul class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#list" role="tab" data-toggle="tab">Lista</a></li>
			 </ul>	
			 <div class="tab-content">			 
				<div class="tab-pane active" id="list">
					<?php if(count($offerts) >0)
					{?>
					<table class="own-table">
						<thead>
					
							<tr>
								<th class="padding-left">Oferta</th>
								<th class="center padding-left">Data ważności</th>
								<th class="center" style="width:100px">Akcje</th>
							</tr>
							
						</thead>
						<tbody>
						<?php
						$i=0;
						foreach($offerts as $id_offer=>$offert)
						{$total_value=0;
							$i++;
							
							if($i%2 == 0)
								$evenOdd = 'even';
							else
								$evenOdd = 'odd';								
							  ?>
								<tr class="<?php echo $evenOdd;?>">
									<td class="padding-left"><?php echo $offert['name'];?> </td>
									<td class="center"><?php echo $offert['date_from']." - ".$offert['date_to'];?> </td>
									<td class="center"><a  class="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $id_offer?>">Rozwiń</a></td>
								</tr>
								<?php
								if(isset($offerts_products[$id_offer]))
								{
								?>
								<tr>
									<td style="padding:0" colspan="6">
										<div id="collapse<?php echo $id_offer;?>" class="panel-collapse collapse">
										  <div class="panel-body">
												<table class="table table-striped">
													<thead>
														<tr>
															<th>Nazwa produktu</th><th class="text-right">Cena jedn.</th><th class="text-right">Ilość</th><th class="text-right">Wartość</th>
														</tr>
													</thead>
												<?php 							
												foreach ($offerts_products[$id_offer] as $id_product=>$product)
													{								
													?>
														<tr>
															<td><?php echo $product['name'];?></td>
															<td class="text-right"><?php echo $product['price']." zł";?> </td>
															<td class="text-right">
																<?php echo $product['amount'];?>
															</td>										
															<?php 
															$sum_prod=round($product['amount']*$product['price'],2); $total_value+=$sum_prod;?>
															<td class="text-right"><span id="total_product_<?php echo $id_product;?>"><?php echo number_format($sum_prod,2,',',' ');?></span> zł</td>
															<input type="hidden" id="product_price_<?php echo $id_product;?>"  value="<?php echo $product['price'];?>"/>
															<input type="hidden" id="id_cart_<?php echo $id_product;?>"  value="<?php echo $id_offer;?>"/>
																							
														</tr>				
													<?php										
													}
													?>
													<tfoot>
														<tr>
															<th></th><th class="text-right"></th><th></th><th class="text-right">Razem: <span id="total_cart_<?php echo $id_offer;?>" class="total_cart"><?php echo number_format($total_value,2,',',' ');?></span> zł</th>
														</tr>
													</tfoot>
												</table>
											
											<a href="<?php echo base_url("inquiries/createCartFromOffer/".$id_offer);?>" class="button pull-right" style="margin:10px">Utwórz zamówienie</a>
											
											<div class="clear"></div>
										  </div>
										</div>
									</td>
								</tr>
								<?php
								}
						}?>
							
						</tbody>
					</table>
					<?php
					}
					else
					{
					echo '
						<div class="info-block padding10">
							<div class="info-box">
								<img src="'.base_url("images/icon_promo.png").'" />Brak aktywnych ofert
							</div>
						</div>';
					}
					?>
				</div>
			</div>
		</div>
		<?php echo $pagination_links;?>
		
	</div>
</div>

<?php
if(isset($_GET['created']))
{
?>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalInfo">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Zapytaie ofertowe
			</div>
		</div>		
		<p class="center">Zapytanie ofertowe zostało wysłane<br/><br/>	
		<a class="btn btn-primary closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;OK</a>
		<br/><br/></p>
	</div>
  </div>
</div>
<script>
	$(function(){
		$('#modalInfo').modal('show')
	});
</script>
<?php
}
?>
