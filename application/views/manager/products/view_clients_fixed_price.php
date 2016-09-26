 
<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span> 
	  </div>
	  <div class="panel-body">
		  <form method="post">			
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						Klienci
					</div>
					<div class="panel-body">
						<table class="table table-striped" id="availability-clients-table">
							<thead class="table-header">
							<tr>
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
			<div class="col-md-1">
			</div>
			<div class="col-md-2">
				<a href="<?php echo base_url($path."products/view/".$id_product."?action=fixedPrice");?>" class="btn btn-primary btn-block">
					<span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót
				</a>
			</div>
		  </form>
	  </div> 
	</div>
	
</div>