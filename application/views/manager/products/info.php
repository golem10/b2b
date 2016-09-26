<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span> 		
		<a href="<?php echo base_url($path."products/index/".$product['id_category']);?>" class="btn btn-default pull-right btn-default" style="margin-left:10px"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
		<a href="<?php echo base_url($path."products/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-th-list"></span>&nbsp;Katalog główny</a>
	  </div>
	  <div class="panel-body">
	  
		<ul class="nav nav-tabs" role="tablist">
		  <li <?php echo ($tab == 1) ?  'class="active"' : "" ;?> ><a href="#info-panel" role="tab" data-toggle="tab">Informacje ogólne</a></li>		  
		  <li <?php echo ($tab == 2) ?  'class="active"' : "" ;?> ><a href="#settings-panel" role="tab" data-toggle="tab">Ustawienia</a></li>
		  <li <?php echo ($tab == 3) ?  'class="active"' : "" ;?> ><a href="#prices-panel" role="tab" data-toggle="tab">Ceny stałe</a></li>
		  <li <?php echo ($tab == 4) ?  'class="active"' : "" ;?> ><a href="#related-panel" role="tab" data-toggle="tab">Produkty powiązane</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane fade <?php echo ($tab == 4) ?  'in active' : "" ;?>" id="related-panel">
				<?php echo $block_related_products;?>
			</div>
		  <div class="tab-pane fade <?php echo ($tab == 1) ?  'in active' : "" ;?>" id="info-panel">
			<div class="row">&nbsp;</div>
			<div class="row">
			  <div class="col-md-6">
				<div class="panel panel-default">
					  <div class="panel-heading">
						Dane
					  </div>
					  <form class="form-horizontal" role="form" method="post" action="?action=updatePrice">
					  <table class="table ">
						
						<tbody>
							<tr>
								<td class="cell-label">Nazwa: </td><td class="cell-value"><?php echo $product['name'];?></td><td class="cell-label">KOD: </td><td class="cell-value"><?php echo $product['code'];?></td>
							</tr>
							<tr>
								<td class="cell-label">Producent:</td><td class="cell-value"><?php if(isset($product['id_producer'])) if($product['id_producer'] != 0) echo $producers[$product['id_producer']]['name']; else echo"Brak zdefiniowanego producenta";?></td>
								<td class="cell-label"></td><td class="cell-value"></td>
							</tr>
							<tr>
								<td class="cell-label">Cena domyślna:</td><td class="cell-value"><input type="text" class="form-control" id="price" name="price"  placeholder="0.00" value="<?php echo $product['price'];?>"></td>
								<td class="cell-label"><button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Aktualizuj cenę</button></td><td class="cell-value">&nbsp;</td>
								<!-- <td class="cell-label">Cena stała:</td><td class="cell-value"><input type="text" class="form-control" id="fixed_price" name="fixed_price"  placeholder="0.00" value="<?php echo $product['fixed_price'];?>"></td> -->
							</tr>
							<tr>
								<td class="cell-label">&nbsp;</td><td class="cell-value">&nbsp;</td>
								<td class="cell-label">&nbsp;</td><td class="cell-value">&nbsp;</td>
							</tr>
						</tbody>
					</table>
					</form>
				</div>
				
			  </div>
			  <div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						Status informacyjny
					</div>
					<div class="panel-body">
						<form action="?action=changeStatus" method="post" class="center" enctype="multipart/form-data">
							<select name="id_status" class="form-control" style="display:inline;width:auto">
								<?php
								foreach($statuses as $id_status =>$status)
								{
									echo "<option value='".$id_status."'";
									echo (isset($product['id_info_status']) && $product['id_info_status']==$id_status) ? 'selected="selected"' : '';
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
						Kategoria
					</div>
					<div class="panel-body" >
						<div class="form-group">
							<form action="?action=changeCategory" method="post" class="center">
							<select name="id_category" class="form-control" style="display:inline;width:auto">
								<?php
								echo "<option value='0'";
								echo ($product['id_category']==0) ? 'selected="selected"' : "";
								echo ">-- Wybierz kategorię --</option>";
								foreach($categories[0] as $id_category =>$category)
								{
									echo "<option value='".$id_category."'";
									echo (isset($product['id_category']) && $product['id_category']==$id_category) ? 'selected="selected"' : '';
									echo ">".$category['name']."</option>";
									if(isset($categories[$id_category]))
									foreach($categories[$id_category] as $id_category1 =>$category1)
										{
										echo "<option value='".$id_category1."'";
										echo (isset($product['id_category']) && $product['id_category']==$id_category1) ? 'selected="selected"' : '';
										echo ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$category1['name']."</option>";
										}
								}
								?>
							</select>
							<br/><br/>
							<button class="btn btn-primary" ><span class="glyphicon glyphicon-refresh"></span>&nbsp;Zmień kategorię</button>
							<br/><br/>
							</form>
						</div>
					</div>
				</div>
			  </div>
			  <div class="col-md-3">
				
				<div class="panel panel-default">
					<div class="panel-heading">
						Zdjęcia <button type="submit" class="btn btn-xs btn-primary pull-right" data-toggle="modal" data-target="#modalAddImg"><span class="glyphicon glyphicon-picture"></span>&nbsp;Dodaj zdjęcie</button>
					</div>
					<div class="panel-body">
						<div class="row">
						  <?php foreach($images as $id_image=>$value)
						  {
						  ?>
						  <div class="col-xs-6 col-md-4">
							<div class="thumbnail">
								  <img src="<?php echo base_url("uploads/images/".$value['url']);?>">
								  <div class="caption">	
									<p>
									<button class="btn btn-xs btn-default deleteButton1" data-toggle="modal" data-target="#modalDelImg" rel="<?php echo $id_image;?>"><span class="glyphicon glyphicon-trash" ></span>&nbsp;</button>
									<a href="<?php echo base_url("manager/products/setDefaultImage/".$id_image."/".$product['id_product']);?>" class="btn btn-xs <?php if($value['default'] == 1) echo" btn-primary"; else echo "btn-default"; ?>"><span class="glyphicon glyphicon-picture" ></span>&nbsp;</a></p>
								  </div>
							</div>
						  </div>
						  <?php
						  }						  
						  ?>
						</div>					
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						Grupa rabatowa
					</div>
					<div class="panel-body" >
						<div class="form-group">
							<form action="?action=changeDiscountGroup" method="post" class="center">
							<select name="id_discount_group" class="form-control" style="display:inline;width:200px">
								<?php
								echo "<option value='0'";
								echo ($product['id_discount_group']==0) ? 'selected="selected"' : "";
								echo ">Brak</option>";
								foreach($discounts_groups as $k=>$v)
								{
									echo "<option value='".$k."'";
									echo (isset($product['id_discount_group']) && $product['id_discount_group']==$k) ? 'selected="selected"' : '';
									echo ">".$v."</option>";
									
								}
								?>
							</select>
							<br/><br/>
							<button class="btn btn-primary" ><span class="glyphicon glyphicon-refresh"></span>&nbsp;Zmień grupę</button>
							<br/><br/>
							</form>
						</div>
					</div>
			   </div>
					
			   </div>	
			  </div>
			  </div>
			  <div class="tab-pane fade <?php echo ($tab == 3) ?  'in active' : "" ;?>" id="prices-panel" >
				<?php echo $block_fixed_prices; ?>
			  </div>
			<div class="tab-pane fade <?php echo ($tab == 2) ?  'in active' : "" ;?>" id="settings-panel" >
				<form class="form-horizontal" role="form" method="post" action="?action=settings">
					<div class="row">&nbsp;</div>
					<div class="row">
						<div class="col-md-4" style="text-align:center">
							<div class="panel panel-default">
								<div class="panel-heading">
									Produkt liczony w programie lojalnościowym
								</div>
								<div class="panel-body">
									<div class="btn-group" data-toggle="buttons">							
									  <label class="btn <?php echo ($product['loyalty']==1) ? 'btn-primary active' : 'btn-default';?>">
										<input type="radio" name="loyalty" id="loyalty1" value="1" <?php echo ($product['loyalty']==1) ? 'checked' : '';?>>&nbsp;&nbsp;Tak&nbsp;&nbsp;
									  </label>
									  <label class="btn <?php echo ($product['loyalty']==0) ? 'btn-primary active' : 'btn-default';?>">
										<input type="radio" name="loyalty" id="loyalty2" value="0" <?php echo ($product['loyalty']==0) ? 'checked' : '';?>>&nbsp;&nbsp;Nie&nbsp;&nbsp;
									  </label>
									</div><br/>
									
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									Produkt wycofany
								</div>
								<div class="panel-body">
									<div class="btn-group" data-toggle="buttons">							
									  <label class="btn <?php echo ($product['id_status']==2) ? 'btn-primary active' : 'btn-default';?>">
										<input type="radio" name="id_status" id="status1" value="2" <?php echo ($product['id_status']==2) ? 'checked' : '';?>>&nbsp;&nbsp;Tak&nbsp;&nbsp;
									  </label>
									  <label class="btn <?php echo ($product['id_status']==1) ? 'btn-primary active' : 'btn-default';?>">
										<input type="radio" name="id_status" id="status2" value="1" <?php echo ($product['id_status']==1) ? 'checked' : '';?>>&nbsp;&nbsp;Nie&nbsp;&nbsp;
									  </label>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									Cena podlegająca rabatom
								</div>
								<div class="panel-body">
									<div class="btn-group" data-toggle="buttons">							
									  <label class="btn <?php echo ($product['discount']==1) ? 'btn-primary active' : 'btn-default';?>">
										<input type="radio" name="discount" id="discount1" value="1" <?php echo ($product['discount']==1) ? 'checked' : '';?>>&nbsp;&nbsp;Tak&nbsp;&nbsp;
									  </label>
									  <label class="btn <?php echo ($product['discount']==0) ? 'btn-primary active' : 'btn-default';?>">
										<input type="radio" name="discount" id="discount2" value="0" <?php echo ($product['discount']==0) ? 'checked' : '';?>>&nbsp;&nbsp;Nie&nbsp;&nbsp;
									  </label>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									Wartości ułamkowe dla ilości
								</div>
								<div class="panel-body">
									<div class="btn-group" data-toggle="buttons">							
									  <label class="btn <?php echo ($product['amount_decimal']==1) ? 'btn-primary active' : 'btn-default';?>">
										<input type="radio" name="amount_decimal" id="amount_decimal1" value="1" <?php echo ($product['amount_decimal']==1) ? 'checked' : '';?>>&nbsp;&nbsp;Tak&nbsp;&nbsp;
									  </label>
									  <label class="btn <?php echo ($product['amount_decimal']==0) ? 'btn-primary active' : 'btn-default';?>">
										<input type="radio" name="amount_decimal" id="amount_decimal2" value="0" <?php echo ($product['amount_decimal']==0) ? 'checked' : '';?>>&nbsp;&nbsp;Nie&nbsp;&nbsp;
									  </label>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									Kolor
								</div>
								<div class="panel-body">
									
										<select name="id_color" class="form-control" style="display:inline;width:auto">
											<option value="0">Brak</option>
											<?php
											foreach($colors as $k =>$color)
											{
												echo "<option value='".$color['id_color']."'";
												echo (isset($product['id_color']) && $product['id_color']==$color['id_color']) ? 'selected="selected"' : '';
												echo ">".$color['name']."</option>";
											}
											?>
											
										</select>
										<br/><br/>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									Producent
								</div>
								<div class="panel-body">
									
										<select name="id_producer" class="form-control" style="display:inline;width:auto">
											<option value="0">Brak</option>
											<?php
											foreach($producers as $k1 =>$producer)
											{
												echo "<option value='".$producer['id_producer']."'";
												echo (isset($product['id_producer']) && $product['id_producer']==$producer['id_producer']) ? 'selected="selected"' : '';
												echo ">".$producer['name']."</option>";
											}
											?>
											
										</select>
										<br/><br/>
								</div>
							</div>
						</div>
						<div class="col-md-4" style="text-align:center">
							
							<div class="panel panel-default">
								<div class="panel-heading">
									Opis produktu
								</div>
								<div class="panel-body" >
									<div class="form-group">
										<textarea class="form-control" id="text" name="description" placeholder="Tutaj wpisz opis produktu..." ><?php echo $product['description'];?></textarea>
									</div>
								</div>
							</div>
							
						</div>
						<div class="col-md-1">
						</div>
						<div class="col-md-2">
							<button type="submit" class="btn btn-primary btn-block">
								<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Zapisz
							</button>
						</div>
					</div>
				</form>
			</div>	
			<?php /*
			<div class="tab-pane fade" id="availability-panel" >
					<div class="row">&nbsp;</div>
					<div class="row">
						<div class="col-md-5">
							<div class="panel panel-default">
								<div class="panel-heading">
									Kienci
								</div>
								<div class="panel-body">
									<table class="table table-striped" id="availability-users-table">
										<thead class="table-header">
										<tr>
											<th>Nazwa użytkownika</th>
											<th>Klient</th>								
										</tr>
										</thead>
										<tbody>
										<?php
										if($clients_available === 0)	
											echo
												'<tr>
													<td>Dostępny dla wszystkich klienów</td>
													<td></td>
												</tr>';
										else
											foreach($clients_available as $id_client =>$client)
											{
												echo
												'<tr>
													<td>'.$client['name'].'</td>
													<td>'.$client['street'].', '.$client['city'].'</td>
												</tr>';
										
											}																		
										?>
										</tbody>
									</table>
										
								</div>
							</div>
						</div>
						<div class="col-md-5" >
							<div class="panel panel-default">
								<div class="panel-heading">
									Użytkownicy
								</div>
								<div class="panel-body">
									<table class="table table-striped" id="availability-users-table">
										<thead class="table-header">
										<tr>
											<th>Klient</th>								
											<th>Adres</th>	
										</tr>
										</thead>
										<tbody>
										<?php
										if($users_available === 0)	
											echo
												'<tr>
													<td>Dostępny dla wszystkich użytkowników</td>
													<td></td>
												</tr>';
										else
											foreach($users_available as $id_user =>$user)
											{
												echo
												'<tr>
													<td>'.$user['firstname'].' '.$user['lastname'].'</td>
													<td>';
													echo (isset($clients[$user['id_client']]['name'])) ? $clients[$user['id_client']]['name'] : "-- brak zdefiniowanego klienta --";
													echo '</td>
												</tr>';
										
											}																		
										?>
										</tbody>
									</table>			
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<button type="submit" class="btn btn-primary btn-block"  data-toggle="modal" data-target="#modalProductAccess">
								<span class="glyphicon glyphicon-lock"></span>&nbsp;Ustaw uprawnenia do produktu
							</button>
						</div>
					</div>
			</div> */ ?>
		</div>
		
	  </div>
	</div>
	
</div>
<?php ///// MODALS /////////////////// 
/*
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalProductAccess">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Dostęp dla wybranego produktu
				</div>
				<form class="form-horizontal" role="form" method="post" action="?action=productsAvailability">
				<div class="panel-body">
					<ul class="nav nav-tabs" role="tablist">
					  <li class="active"><a href="#availability-client-panel" role="tab" data-toggle="tab">Klienci</a></li>
					  <li><a href="#availability-user-panel" role="tab" data-toggle="tab">Użytkownicy</a></li>
					</ul>
					<br/><br/>
					<div class="tab-content">
						<div class="tab-pane fade-in active" id="availability-client-panel" >
							
							<table class="table table-striped" id="availability-clients-table">
								<thead class="table-header">
								<tr>
									<th>Id</th>
									<th>Nazwa</th>
									<th>Adres</th>								
								</tr>
								</thead>
								<tbody>
								<?php
								foreach($clients as $id_client =>$client)
								{
									echo
									'<tr>
										<td><input type="checkbox" name="id_clients_availability[]" value="'.$id_client.'"';
										echo (isset($productAvailabilityClients[$id_client])) ? "checked" : "";
										echo '/></td>
										<td>'.$client['name'].'</td>
										<td>'.$client['street'].', '.$client['city'].'</td>
									</tr>';
							
								}
								?>
								</tbody>
							</table>							
						</div>
						
						<div class="tab-pane fade" id="availability-user-panel" >
							<table class="table table-striped" id="availability-users-table">
								<thead class="table-header">
								<tr>
									<th>Id</th>
									<th>Nazwa użytkownika</th>
									<th>Klient</th>								
								</tr>
								</thead>
								<tbody>
								<?php
								foreach($users_by_role as $id_user =>$user)
								{
									echo
									'<tr>
										<td><input type="checkbox" name="id_users_availability[]" value="'.$id_user.'"';
										echo (isset($productAvailabilityUsers[$id_user])) ? "checked" : "";
										echo '/></td>
										<td>'.$user['firstname'].' '.$user['lastname'].'</td>
										<td>';
										echo (isset($clients[$user['id_client']]['name'])) ? $clients[$user['id_client']]['name'] : "-- brak zdefiniowanego klienta --";
										echo '</td>
									</tr>';
							
								}
								?>
								</tbody>
							</table>	
						</div>
						<button type="submit" class="btn btn-primary">
								<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Zapisz
						</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	  </div>
</div>
*/ ?>
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
				<input type="hidden" id="idToDel1" name="idToDel" />
				<br/>
				<button class="btn btn-danger" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Tak</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Nie</a>
				<br/><br/>
			</form>
		</div>
	  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalAddImg">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Dodaj zdjęcie
				</div>
			</div>		
			<p class="center">Wybierz zdjęcie dla produktu</p>
			<form action="?action=addImage" method="post" class="center" enctype="multipart/form-data" style="padding:0px 20px">
				<input type="file" name="userfile" style="width:96px;margin:0 auto" />
				<br/>
				<label for="description-img">Opis</label>
				<textarea class="form-control" id="description-img" name="description" placeholder="Opis zdjęcia" maxlength="255" ></textarea>
				<br/>
				<button class="btn btn-primary" ><span class="glyphicon glyphicon-picture"></span>&nbsp;Dodaj zdjęcie</button>
				<br/><br/>
			</form>
		</div>
	  </div>
</div>
<script>
	CKEDITOR.replace( 'text',{
  "filebrowserImageUploadUrl": "<?php echo base_url("/js/ckeditor/plugins/imgupload/imgupload.php");?>",
  'extraPlugins': 'imgbrowse',
  'filebrowserImageBrowseUrl': '<?php echo base_url("/js/ckeditor/plugins/imgbrowse/imgbrowse.html");?>'
} );
</script>