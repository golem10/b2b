<div id="main-content">	
	<div class="w960">
		<?php echo $breadcrumbs;?>
		<div class="clear"></div>	
		
		<h2 class="header-h2">Podsumowanie zamówienia</h2>
		<div id="cart-block-accept">
			<div id="cart-block">
			<form method="post" action="<?php echo base_url("orders/subtotalCart");?>">
				<table class="table table-striped cart-table">
					<thead>
						<tr>
							<th>Nazwa produktu</th><th>Dostępność</th><th class="text-right">Cena jedn.<br/>netto</th><th class="text-right">Cena jedn.<br/>brutto</th><th class="text-right">Ilość</th><th class="text-right">Wartość<br/>netto</th><th class="text-right">Wartość<br/>brutto</th>
						</tr>
					</thead>
				<?php
					$summary=0;	
					$b_summary=0;	
					$max_info_status=0;
					$loyalty_points=0;
					$gratis="";
					foreach ($cart_products as $id_product=>$product)
					{$total_product=0;$b_total_product=0;
					if($product['id_info_status']>$max_info_status)
						$max_info_status=$product['id_info_status'];
					?>
						<tr>
							<td><?php echo $product['name'];?></td>
							<td><?php echo $statuses[$product['id_info_status']]['name'];?></td>
							<td class="text-right"><?php echo  number_format($product['price'],2,',','');?> zł</td>
							<td class="text-right">
								<?php 
								$brutto = $product['price'] + ($product['price']*$product['vat'])/100;
								echo number_format($brutto,2,',','');?> zł
							</td>
							<td class="text-right">
								<?php echo $product['amount'];?>
							<?php $total_product=round($product['amount']*$product['price'],2);
							$b_total_product=round($product['amount']*$brutto,2); 
							$summary+=$total_product;
							$b_summary+=$b_total_product;
							?>
							</td><td class="text-right"><?php echo number_format($total_product,2,',',' ');?> zł</td>
							<td class="text-right"><?php echo number_format($b_total_product,2,',',' ');?> zł</td>
						</tr>				
					<?php
					$loyalty_points += $product['loyalty'];
					// if($product['loyalty'] == 1)
						// $loyalty_points += ($total_product/$settigs_loyalty[2]['value'])*$settigs_loyalty[1]['value'];
					 
					if(isset($product['gratis']))
					{
						$gratis.= $product['gratis']."<br/>";
					}
					}
					?>
					<tfoot>
						<tr>
							<th><?php if($client['loyalty'] == 1 && $summary >= 100) {?>Ilość punktów lojalnościowych:&nbsp; <span class="highlight">+ <?php echo round($loyalty_points,-1);?> pkt.</span><?php }?></th><th></th><th class="text-right"></th><th></th><th class="text-right" colspan="3">Razem: <span><?php echo number_format($summary,2,',',' ');?> zł</span></th>
						</tr>
						<tr>
							<th></th><th></th><th class="text-right"></th><th></th><th class="text-right" colspan="3"><div style="font-size:12px">Razem: <span><?php echo number_format($b_summary,2,',',' ');?> zł</div></span></th>
						</tr>
						<?php if($gratis != "")
						{
						?>
						<tr>						
							<th>Gratisy:&nbsp; <span class="highlight"><?php echo $gratis;?></span></th><th></th><th class="text-right"></th><th></th><th class="text-right"><span></span></th>
						</tr>
						<?php 
						}
						?>
					</tfoot>
				</table>
				
			</form>
		</div>
			<div class="order-info-box">
				<form role="form" method="post">
				  <div class="form-group">
					<label for="delivery_date">Data dostawy</label>
					<input type="text" class="form-control" id="delivery_date" name="delivery_date" placeholder="Data dostawy">
				  </div>
				  Jeżeli zamówienie zostanie wysłane do godz. 14 – realizacja następnego dnia, jeżeli powyżej tej godziny dopiero pojutrze.
				  <div class="underline"></div>
				   <div class="form-group">
					<label for="">Rodzaj płatności</label>
					<div class="btn-group payments" data-toggle="buttons">							
					  <label class="btn active">
						<input type="radio" name="payment_type" value="1" checked>&nbsp;&nbsp;Przelew&nbsp;&nbsp;
					  </label>
					  <label class="btn">
						<input type="radio" name="payment_type" value="2">&nbsp;&nbsp;Gotówka&nbsp;&nbsp;
					  </label>
					</div>
				  </div>
				  <div class="underline"></div>
				   <div class="form-group">
					<label for="information">Dodatkowe informacje</label>
					<textarea class="form-control" id="information" name="information" placeholder="Dodatkowe informacje"></textarea>
				  </div>
				  <div class="underline"></div>
				  <a class="button pull-left" href="<?php echo base_url("orders");?>">Cofnij</a>
			      <button class="button pull-right" id="accept_order_button">Akceptuj zamówienie</button>
				  <div class="clear"></div>
				</form>
			</div>
		</div>
		
	</div>
</div>
<input type="hidden" id="baseUrlToUse" value="<?php echo base_url();?>"/>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="loadingModal">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">	
			<div class="panel panel-default">
				<div class="panel-heading">
					Akceptacja zamówienia. Proszę czekać...
				</div>
			</div>
		
			<p class="center">
				<br/>
				<img src="<?php echo base_url("images/preloader.gif");?>"/></p><br/><br/>
			<br/>
		</div>
	  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalDelete">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Usuwanie elementu 
			</div>
		</div>		
		<p class="center">Czy napewno chcesz usunąć ten element?</p>
		<form action="<?php echo base_url("orders/deleteProductCart");?>" method="post" class="center">
			<input type="hidden" id="idToDel" name="idToDel" />
			<br/>
			<button class="btn btn-danger" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Tak</button>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Nie</a>
			<br/><br/>
		</form>
	</div>
  </div>
</div>
 <?php
// $minDate="+1d";
// if(date("H")>=14)
	// $minDate = "+2d";
// if($max_info_status == 3)
	// $minDate= "+3d";
// else if($max_info_status == 4)
	// $minDate= "+4d";

$minDate=strtotime(date("Y-m-d"))+(3600*24);
if(date("H")>=14)
	$minDate += 3600*24;
if($max_info_status == 3)
	$minDate += 3600*48;
else if($max_info_status == 4)
	$minDate += 3600*72;


if(date("w",$minDate) == 0)
	 $minDate=$minDate+(3600*24);
$minDate=date("Y-m-d",$minDate);
?>
<script>
  $(function() {
	$("#accept_order_button").click(function(){
		$("#loadingModal").modal("show");
	});
    $( "#delivery_date" ).datepicker("option", "minDate", "<?php echo $minDate;?>");
	$( "#delivery_date" ).datepicker("option", "maxDate", "+1m");
	$( "#delivery_date" ).datepicker( "setDate", "<?php echo $minDate;?>" );
  });
</script>