
<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span> 
	  </div>
	  <div class="panel-body">
			  <div class="col-md-6">
					
					<div class="col-md-12">
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
			  </div>
			 
			  <div class="col-md-6">
				<form action="" method="post">
					<input type="hidden" value="<?php echo $id_inquiry;?>" name="id_inquiry" />
					<div class="panel panel-default">
						<div class="panel-heading">
							Lista produktów
						</div>
						<div class="panel-body">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Nazwa produktu</th><th class="text-right" style="width:200px">Cena jedn.</th><th class="text-right">Ilość</th>
									</tr>
								</thead>
							<?php
								foreach ($products as $id_product=>$product)
								{
								?>
									<tr>
										<td><?php echo $product['name'];?></td>
										<td class="text-right">
											<div class="input-group">
											  <input type="text" name="amount[<?php echo $id_product;?>]" class="form-control" value="<?php echo number_format($productsPrices[$product['id_product']]['price'],2,".",'');?>">
											  <span class="input-group-addon"> zł</span>
											</div>
										</td>
										<td class="text-right">
											<?php echo $product['amount'];?>
										<?php
										?>
										</td>
									</tr>				
								<?php
								}
								?>
								
							</table>				
						</div>
					</div>
					 <button class="btn btn-primary pull-right" type="submit" name>Odpowiedz</button>
					 <div class="clear"></div>
				</form>
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
