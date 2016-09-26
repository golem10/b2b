<?php
$summary=0;
$summary_b=0;
foreach ($products as $id_product=>$product)
{
	$summary+=round($product['amount']*$product['price'],2);
	$summary_b+=round($product['amount']*($product['price']+($product['price']*$product['vat'])/100),2);		
}

?>
<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span> 
		<a href="<?php echo base_url($path."clients/view/".$client['id_client']);?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Karta klienta</a>
		<a href="<?php echo base_url($path."orders/");?>" class="btn btn-default pull-right btn-default" style="margin-right:10px"><span class="glyphicon glyphicon-th-list"></span>&nbsp;Lista zamówień</a>
	  </div>
	  <div class="panel-body">
			  <div class="col-md-6">
					<div class="col-md-12">
						<div class="panel panel-default">
							  <div class="panel-heading">
								Dane
							  </div>
							  <table class="table">
								
								<tbody>
									<tr>
										<td class="cell-label">Data złożenia zamówienia:</td><td class="cell-value"><?php echo $order['date'];?></td><td class="cell-label">Data dostawy: </td><td class="cell-value"><?php echo $order['delivery_date'];?></td>
									</tr>
									<tr>
										<td class="cell-label">Wartość zamówienia netto:</td><td class="cell-value"><?php echo number_format($summary, 2, ',', '');?> zł</td></td><td class="cell-label">Wartość zamówienia brutto:</td><td class="cell-value"><?php echo number_format($summary_b, 2, ',', '');?> zł</td></td>
									</tr>
									<tr>
										<td class="cell-label">Osoba akceptująca:</td><td class="cell-value"><?php  echo $order['firstname']." ".$order['lastname'];?></td><td class="cell-label">Zapłacono:<br/>Płatność:</td><td class="cell-value"><?php echo ($order['paid']==1) ? "Tak" : "Nie";?><br/><?php echo ($order['payment_type']==2) ? "Gotówka" : "Przelew";?>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								Dane klienta
							</div>
							<div class="panel-body">
								<table class="table">								
									<tbody>
										<tr>
											<td class="cell-label">Klient: </td><td class="cell-value"><?php echo $client['name'];?></td>
										</tr>
										<tr>
											<td class="cell-label">Nip: </td><td class="cell-value"><?php echo $client['nip'];?></td>
										</tr>
										<tr>
											<td class="cell-label">Adres: </td><td class="cell-value">ul. <?php echo $client['street'].",<br/>".$client['city'];?></td>
										</tr>
										<tr>
											<td class="cell-label">Adres dostawy: </td><td class="cell-value">ul. <?php echo $client['delivery_street'].",<br/>".$client['delivery_city'];?></td>
										</tr>
										<tr>
											<td class="cell-label">Nr tel.: </td><td class="cell-value"><?php echo $client['phone_number'];?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								Status
							</div>
							<div class="panel-body">
								<form action="?action=changeStatus" method="post" class="center" enctype="multipart/form-data">
									<select name="id_status" class="form-control" style="display:inline;width:auto">
										<?php
										foreach($statuses as $id_status =>$status)
										{
											echo "<option value='".$id_status."'";
											echo (isset($order['id_status']) && $order['id_status']==$id_status) ? 'selected="selected"' : '';
											echo ">".$status['name']."</option>";
										}
										?>
										
									</select>
									<br/><br/>
									<button class="btn btn-primary" ><span class="glyphicon glyphicon-refresh"></span>&nbsp;Zmień status</button>
									<br/><br/>
								</form>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								Dodatkowe informacje:
							</div>
							<div class="panel-body">
								<?php echo ($order['information'] != "") ? $order['information']  : "Brak dodatkowych informacji";?>
							</div>
						</div>
					</div>
					
			  </div>
			 
			  <div class="col-md-6">
				
				<div class="panel panel-default">
					<div class="panel-heading">
						Lista produktów
					</div>
					<div class="panel-body">
						<table class="table table-striped" id="order-products-table">
							<thead>
								<tr>
									<th>Nazwa produktu</th><th class="text-right">Cena jedn. n.</th> <th class="text-right">Cena jedn. b.</th><th class="text-right">Ilość</th><th class="text-right">Wartość n.</th><th class="text-right">Wartość b.</th>
								</tr>
							</thead>
						<?php
							foreach ($products as $id_product=>$product)
							{$total_product=0;
							$total_product_b=0;
							?>
								<tr>
									<td><?php echo $product['name'];?></td>
									<td class="text-right"><?php echo number_format($product['price'],2,',','');?> zł</td>
									<td class="text-right"><?php 
									$brutto = $product['price']+($product['price']*$product['vat'])/100;
										echo number_format($brutto,2,',','');?> zł</td>
									<td class="text-right">
										<?php echo $product['amount'];?>
									<?php $total_product=number_format($product['amount']*$product['price'],2,',','');
									 $total_product_b=number_format($brutto*$product['amount'],2,',','');
									?>
									</td>
									<td class="text-right"><?php echo $total_product;?> zł</td>
									<td class="text-right"><?php echo $total_product_b;?> zł</td>
								</tr>				
							<?php
							}
							?>
							
						</table>				
					</div>
				</div>
			   </div>
					
			   </div>	
			  </div>
		</div>
		
	  </div>
	</div>
	
</div>
<?php ///// MODALS /////////////////// ?>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalDelImg">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Usuwanie elementu 
				</div>
			</div>		
			<p class="center">Czy napewno chcesz usunąć ten element?</p>
			<form action="<?php echo base_url($path."products/deleteImage/".$product['id_product']);?>" method="post" class="center">
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
