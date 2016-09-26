 
<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span> 
	  </div>
	  <div class="panel-body">
		  <form method="post" id="form">
			<div class="col-md-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						Cena
					</div>
					<div class="panel-body">
						<input class="form-control" id="price" name="price" placeholder="0.00" value="<?php echo $fixed_price['price'];?>" />
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						System lojalnościowy
					</div>
					<div class="panel-body">
						<div class="btn-group" data-toggle="buttons">							
						  <label class="btn <?php echo ($fixed_price['loyalty']==1) ? 'btn-primary active' : 'btn-default';?>">
							<input type="radio" name="loyalty" value="1" <?php echo ($fixed_price['loyalty']==1) ? 'checked' : '';?>>&nbsp;&nbsp;Tak&nbsp;&nbsp;
						  </label>
						  <label class="btn <?php echo ($fixed_price['loyalty']==2) ? 'btn-primary active' : 'btn-default';?>">
							<input type="radio" name="loyalty" value="2" <?php echo ($fixed_price['loyalty']==2) ? 'checked' : '';?>>&nbsp;&nbsp;Nie&nbsp;&nbsp;
						  </label>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						Klienci
					</div>
					<div class="panel-body">
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
									<td><input type="checkbox" class="to_set_checkbox" name="id_clients_temp[]" value="'.$id_client.'"';
									echo (isset($fixed_price['clients'][$id_client])) ? "checked" : "";
									echo '/></td>
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
			
			<div class="col-md-2">
				<button type="submit" id="submit_form" class="btn btn-primary btn-block">
					<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Zapisz
				</button>
				<div id="checkboxex-box" style="display:none">
				<?php
							foreach($clients as $id_client =>$client)
							{
								echo (isset($fixed_price['clients'][$id_client])) ? '<input type="checkbox" name="id_clients[]" id="checkbox_table'.$id_client.'" value="'.$id_client.'" checked/>' : "";								
												
							}
							?>
				</div>
			</div>
		  </form>
	  </div>  
	</div>
	
</div>
