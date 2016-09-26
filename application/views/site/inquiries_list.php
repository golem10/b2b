<div id="main-content">	
	<div class="w960">
		<?php echo $breadcrumbs;?>
		<div class="clear"></div>	
		
		<h2 class="header-h2">Zapytania ofertowe</h2>
		<div id="cart-block-accept">
			<ul class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#list" role="tab" data-toggle="tab">Lista</a></li>
			 </ul>	
			 <div class="tab-content">			 
				<div class="tab-pane active" id="list">
					<table class="own-table">
						<thead>
					
							<tr>
								<th class="padding-left">Zapytanie</th>
								<th class="center">Status</th>
								<th class="center" style="width:100px">Akcje</th>
							</tr>
							
						</thead>
						<tbody>
						<?php
						$i=0;
						foreach($inquiries as $id_inquiry=>$inquiry)
						{$total_value=0;
							$i++;
							
							if($i%2 == 0)
								$evenOdd = 'even';
							else
								$evenOdd = 'odd';								
							  ?>
								<tr class="<?php echo $evenOdd;?>">
									<td class="padding-left">Zapytanie z dnia: <?php echo $inquiry['date'];?> </td>
									<td class="center"><?php  if($inquiry['id_status'] == 1) echo "<span class='yellow-badgage badgage'>Oczekiwanie na odpowiedź</span>";
									else if($inquiry['id_status'] == 2) echo "<span class='green-badgage badgage'>Gotowe do realizacji</span>";?></td>
									<td class="center"><a  class="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $id_inquiry?>">Rozwiń</a></td>
								</tr>
								<?php
								if(isset($inquiries_products[$id_inquiry]))
								{
								?>
								<tr>
									<td style="padding:0" colspan="6">
										<div id="collapse<?php echo $id_inquiry;?>" class="panel-collapse collapse">
										  <div class="panel-body">
												<table class="table table-striped">
													<thead>
														<tr>
															<th>Nazwa produktu</th><th class="text-right">Cena jedn.</th><th class="text-right">Ilość</th><th class="text-right">Wartość</th>
														</tr>
													</thead>
												<?php 							
												foreach ($inquiries_products[$id_inquiry] as $id_product=>$product)
													{								
													?>
														<tr>
															<td><?php echo $product['name'];?></td>
															<td class="text-right"><?php echo ($inquiry['id_status']>1) ? $product['price']." zł" : "Brak danych";?> </td>
															<td class="text-right">
																<?php echo $product['amount'];?>
															</td>										
															<?php if($inquiry['id_status']>1){ 
															$sum_prod=round($product['amount']*$product['price'],2); $total_value+=$sum_prod;?>
															<td class="text-right"><span id="total_product_<?php echo $id_product;?>"><?php echo number_format($sum_prod,2,',',' ');?></span> zł</td>
															<input type="hidden" id="product_price_<?php echo $id_product;?>"  value="<?php echo $product['price'];?>"/>
															<input type="hidden" id="id_cart_<?php echo $id_product;?>"  value="<?php echo $id_inquiry;?>"/>
															<?php
															}
															else
															echo "<td class='text-right'>Brak danych</td>";
															?>									
														</tr>				
													<?php										
													}
													if($inquiry['id_status']>1)
													{ 
													?>
													<tfoot>
														<tr>
															<th></th><th class="text-right"></th><th></th><th class="text-right">Razem: <span id="total_cart_<?php echo $id_inquiry;?>" class="total_cart"><?php echo number_format($total_value,2,',',' ');?></span> zł</th>
														</tr>
													</tfoot>
													<?php
													}
													?>
													
												</table>
											<?php																
											if($inquiry['id_status']==2)
											{ 
											?>
											<a href="<?php echo base_url("inquiries/createCartFromInquiry/".$id_inquiry);?>" class="button pull-right" style="margin:10px">Utwórz zamówienie</a>
											<?php
											}
											?>	
											<a href="<?php echo base_url("inquiries/cancelInquiry/".$id_inquiry);?>" class="button button-danger pull-right" style="margin:10px">Anuluj zapytanie</a>																		
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
		<a class="btn btn-primary closeModal" ><span class="glyphicon glyphicon-ok"></span>&nbsp;OK</a>
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
