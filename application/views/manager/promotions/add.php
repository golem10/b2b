<div class="alert alert-danger fade in status-info-box" role="alert" style="display:none">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
       Uzupełnij poprawnie wszystkie pola
</div>
<div id="main-content">

<div class="panel panel-default">
  <div class="panel-heading">
	<span class="panel-header"><?php echo $title;?></span> 
	<a href="<?php echo base_url($path."promotions/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
  </div>
  <div class="panel-body">
	<form class="form-horizontal" method="post">
		<div class="row">	
			<div class="col-md-4">
				<div class="control-group">
					<label class="control-label" for="name">Nazwa promocji</label>
					<div class="controls">
						<input type="text" id="name" class="form-control"  placeholder="Nazwa promocji" name="name" <?php echo (isset($post['name'])) ? 'value="'.$post['name'].'"' : 'value="'.$def['name'].'"' ?> >
					</div>
				</div>
				
				
				<br/><br/>
				<?php
				if(count($gratises) == 0 && count($positions) == 0 && count($dates) == 0)
				{
				?>
				<label>Wybierz typ promocji</label>
				<br/><br/>
				<input type="hidden" name="id_type" id="id_type" value="1"/>
				<ul class="nav nav-tabs" role="tablist">
				  <li class="active"><a href="#time-promo-panel" role="tab" data-toggle="tab" class="tab-input" rel="1">Czasowa</a></li>
				  <li><a href="#amount-promo-panel" role="tab" data-toggle="tab" class="tab-input" rel="2">Ilościowa</a></li>
				  <li><a href="#gratis-promo-panel" role="tab" data-toggle="tab" class="tab-input" rel="3">Gratisowa</a></li>
				</ul>
				
				<div class="tab-content">
				
					  <div class="tab-pane fade  in active" id="time-promo-panel">
								<label for="date_from" class="control-label">Od:</label>
								<div class="">
								  <input type="text" class="form-control" id="date_from" name="date_from" >
								</div>
								<label for="date_to" class="control-label">Do:</label>
								<div class="">
								  <input type="text" class="form-control" id="date_to" name="date_to" >
								</div>
								<label for="price" class="control-label">Cena:</label>
								<div class="">
								  <input type="text" class="form-control" id="price" name="price" >
								</div>
					  </div>
					  
					  <div class="tab-pane fade" id="amount-promo-panel">
						<br/>
						<div id="discount-positions">
						
						</div>
						<a href="#" class="btn btn-default pull-right btn-default" id="new-discount-position"><span class="glyphicon glyphicon-plus"></span>&nbsp;Dodaj pozycję</a>
					  </div>
					  
					  <div class="tab-pane fade" id="gratis-promo-panel">
						<br/>
						<div id="promotion-gratis-positions">
						
						</div>
						<a href="#" class="btn btn-default pull-right btn-default" id="new-promotion-gratis-position"><span class="glyphicon glyphicon-plus"></span>&nbsp;Dodaj pozycję</a>
					  </div>
					  
				</div>
				<?php
				}
				else
				{
					if(count($dates)>0)
					{?>
					<input type="hidden" name="id_type" id="id_type" value="1"/>
					<label for="date_from" class="control-label">Od:</label>
					<div class="">
					  <input type="text" class="form-control" id="date_from" name="date_from" >
					</div>
					<label for="date_to" class="control-label">Do:</label>
					<div class="">
					  <input type="text" class="form-control" id="date_to" name="date_to" >
					</div>
					<label for="price" class="control-label">Cena:</label>
					<div class="">
					  <input type="text" class="form-control" id="price" name="price" value="<?php echo $dates['price'];?>">
					</div>
					<script>
						$(function(){
							$( "#date_from" ).datepicker( "setDate", "<?php echo $dates['date_from'];?>" ); 
							$( "#date_to" ).datepicker( "setDate", "<?php echo $dates['date_to'];?>" ); 
						});
					</script>
					<?php
					
						
					}	
					else if(count($gratises)>0)
					{
						foreach ($gratises as $id=>$val)
							{echo'<input type="hidden" name="id_type" id="id_type" value="3"/>';
							
							echo '<div class="promotion-gratis-positions-div" lp="'.$id.'">
							<div class="input-group"><span class="input-group-addon">Liczba sztuk</span><input type="text" class="form-control"  placeholder="Liczba sztuk" name="positions['.$id.'][amount]" value="'.$val['amount'].'"></div>
							<div class="input-group"><span class="input-group-addon">Gratis</span><input type="text" class="form-control"  placeholder="Gratis" name="positions['.$id.'][gratis]" value="'.$val['gratis'].'"></div>
							
						</div><br/>';
						
							}
					}	
					else if(count($positions)>0)
					{ echo '<input type="hidden" name="id_type" id="id_type" value="2"/>';
						echo '<div class="discount-position-div" ><input readonly type="text" class="form-control"  placeholder="Liczba sztuk" value="Liczba sztuk"><input readonly type="text" class="form-control"  placeholder="Cena" value="Cena"></div>';

						foreach ($positions as $id=>$val)
							{
							echo '<div class="discount-position-div" lp="'.$id.'"><input type="text" class="form-control"  placeholder="Liczba sztuk" name="positions['.$id.'][amount]" value="'.$val['amount'].'"><input type="text" class="form-control"  placeholder="Cena" name="positions['.$id.'][discount]" value="'.$val['discount'].'"></div>';
						
							}
					}						
				}
				?>
				<br/><br/>
				<label class="control-label" for="description">Opis</label>
				<div class="controls">
					<textarea id="description" class="form-control"  placeholder="Opis" name="description" ><?php echo (isset($post['description'])) ? $post['description'] : $def['description']; ?> </textarea>
				</div>
			</div>
			<div class="col-md-1">
			</div>
			<div class="col-md-4">
				<div class="control-group" id="group-checkbox"  style="width:auto">
					<strong>Informacje o produkcie</strong>
					<div class="panel panel-default">
						<table class="table ">
						
						<tbody>
							<tr>
								<td class="cell-label">Nazwa: </td><td class="cell-value"><?php echo $product['name'];?></td><td class="cell-label">KOD: </td><td class="cell-value"><?php echo $product['code'];?></td>
							</tr>
							<tr>
								<td class="cell-label">Cena domyślna: </td><td class="cell-value"><?php echo $product['price'];?></td><td class="cell-label"><?php echo ($product['fixed_price']>0) ? "Cena stała" : "";?></td><td class="cell-value"><?php echo ($product['fixed_price']>0) ? $product['fixed_price'] : "";?></td>
							</tr>
							
						</tbody>
						</table>
					</div>
					<label class="control-label" for="group">Grupy</label>
					<div class="controls">
						<?php
							foreach($groups as $item){
								$item['checked'] ? $checked='checked' : $checked='';
								echo '<span class="group-checkbox-item"><input class="checkbox-promo" type="checkbox" name="groups['.$item['id_group'].']" value="'.$item['id_group'].'" '.$checked.' />';
								echo '<label class="control-label" for="groupname">'.$item['name'].'</label></span>';
							}
						?>
					</div>
					
					
				</div>
			</div>
			<div class="col-md-1">
			</div>
			
			<div class="col-md-2">
				<div class="control-group">
					<div class="controls">
						<br/>
						<button type="button" class="btn btn-primary btn-block" id="save-promotion-button">
							<span class="glyphicon glyphicon-floppy-saved "></span>&nbsp;Zapisz
						</button>
						
					</div>
				</div>
			</div>
		</div>
			
	</form>
	
</div>
</div>

<script>
	CKEDITOR.replace( 'description' );
	
$(function(){
	$("#save-promotion-button").click(function(){
		if($("#name").val() != "" && $(".checkbox-promo:checked").length > 0)
			$(".form-horizontal").submit();
		else
			$(".status-info-box").css("display","block");
	});
});
</script>

