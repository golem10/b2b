<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span> 
		<a href="<?php echo base_url($path."clients/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
	  </div>
	  <div class="panel-body">
	  
		<ul class="nav nav-tabs" role="tablist">
		  <li <?php echo ($tab == 1) ?  'class="active"' : "" ;?> ><a href="#info-panel" role="tab" data-toggle="tab">Informacje ogólne</a></li>
		  <li><a href="#orders-panel" role="tab" data-toggle="tab">Zamówienia</a></li>
		  <li ><a href="#payments-panel" role="tab" data-toggle="tab">Płatności</a></li>
		  <li <?php echo ($tab == 4) ?  'class="active"' : "" ;?>><a href="#settings-panel" role="tab" data-toggle="tab">Ustawienia</a></li>
		  <li <?php echo ($tab == 5) ?  'class="active"' : "" ;?>><a href="#contracts-panel" role="tab" data-toggle="tab">Kontrakty</a></li>
		  <li <?php echo ($tab == 6) ?  'class="active"' : "" ;?>><a href="#products-panel" role="tab" data-toggle="tab">Produkty</a></li>
		   <li <?php echo ($tab == 7) ?  'class="active"' : "" ;?>><a href="#loyalty-points-panel" role="tab" data-toggle="tab">Punkty lojalnościowe</a></li>
		   <li <?php echo ($tab == 8) ?  'class="active"' : "" ;?>><a href="#discounts-panel" role="tab" data-toggle="tab">Rabaty</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			 <div class="tab-pane fade <?php echo ($tab == 7) ?  'in active' : "" ;?>" id="loyalty-points-panel">
				<div class="row">&nbsp;</div>
				<div class="row">
				<div class="col-md-3">
					<div class="panel panel-default">
						 <div class="panel-heading">
							Ilość zebranych punktów:
						  </div>
						  <div class="panel-body">
							<?php echo $loyalty_points;?>
						  </div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="panel panel-default">
						 <div class="panel-heading">
							Ilość wykorzystanych punktów
						  </div>
						  <div class="panel-body">
							<form class="form-horizontal" role="form" method="post" action="?action=setLoyaltyPoints">
								<input type="text" class="form-control" id="used_loyalty_points" name="used_loyalty_points"  placeholder="0" value="<?php echo $client['used_loyalty_points'];?>"><br/>
								<button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Ustaw punkty</button>
							</form>
						  </div>
					</div>
					<div class="panel panel-default">
						 <div class="panel-heading">
							Ilość punktów początkowych
						  </div>
						  <div class="panel-body">
							<form class="form-horizontal" role="form" method="post" action="?action=setStartLoyaltyPoints">
								<input type="text" class="form-control" id="used_start_loyalty_points" name="used_start_loyalty_points"  placeholder="0" value="<?php echo $client['used_start_loyalty_points'];?>"><br/>
								<button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Ustaw punkty</button>
							</form>
						  </div>
					</div>
				</div>
				</div>
				
			</div>
		   <div class="tab-pane fade <?php echo ($tab == 6) ?  'in active' : "" ;?>" id="products-panel">
				<?php echo $block_products;?>
		   </div>
		    <div class="tab-pane fade <?php echo ($tab == 8) ?  'in active' : "" ;?>" id="discounts-panel">
				<?php echo $block_discounts;?>
		   </div>
		  <div class="tab-pane fade  <?php echo ($tab == 1) ?  'in active' : "" ;?>" id="info-panel">
			<div class="row">&nbsp;</div>
			<div class="row">
			  <div class="col-md-6">
				<div class="panel panel-default">
					  <div class="panel-heading">
						Dane
					  </div>
					  <table class="table ">
						
						<tbody>
							<tr>
								<td class="cell-label">Nazwa: </td><td class="cell-value"><?php echo $client['name'];?></td><td class="cell-label">NIP: </td><td class="cell-value"><?php echo $client['nip'];?></td>
							</tr>
							<tr>
								<td class="cell-label">Adres: </td><td class="cell-value"><?php echo $client['street'];?><br/><?php echo $client['city'];?></td><td class="cell-label">Adres dostawy: </td><td class="cell-value"><?php echo $client['delivery_street'];?><br/><?php echo $client['delivery_city'];?></td>
							</tr>
							<tr>
								<td class="cell-label">Kontakt: </td><td class="cell-value">&nbsp;</td><td class="cell-label">Imię i nazwisko:</td><td class="cell-value"><?php echo $client['name_person'];?></td>
							</tr>
							<tr class="no-border">
								<td class="cell-label ">&nbsp;</td><td class="cell-value">&nbsp;</td><td class="cell-label">Adres e-mail:</td><td class="cell-value"><?php echo $client['email'];?></td>
							</tr>
							<tr class="no-border">
								<td class="cell-label">&nbsp;</td><td class="cell-value">&nbsp;</td><td class="cell-label">Nr telefonu:</td><td class="cell-value"><?php echo $client['phone_number'];?></td>
							</tr>

						</tbody>
					</table>
				</div>	
				<div class="panel panel-default">
					  <div class="panel-heading">
						Zamówienia oczekujące na realizację
					  </div>
					  <div class="panel-body">
						<?php echo $block_orders_to_realization;?>
					  </div>
				</div>	
			  </div>
			  <div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						Użytkownicy wprowadzający 
					</div>
					
					<table class="table table-bordered table-hover table-striped ">
						<thead class="table-header">
						<tr>
							<th>Id</th>
							<th>Imie i Nazwisko</th>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach($users_introductory as $id_user =>$user)
						{
							echo
							'<tr>
								<td>'.$id_user.'</td>
								<td>'.$user['firstname'].' '.$user['lastname'].'</td>
							</tr>';
						}?>
						</tbody>
					</table>
				</div>	
				<div class="panel panel-default">
					<div class="panel-heading">
						Użytkownicy akceptujący
					</div>
					
					<table class="table table-bordered table-hover table-striped ">
						<thead class="table-header">
						<tr>
							<th>Id</th>
							<th>Imie i Nazwisko</th>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach($users_accept as $id_user =>$user)
						{
							echo
							'<tr>
								<td>'.$id_user.'</td>
								<td>'.$user['firstname'].' '.$user['lastname'].'</td>
							</tr>';
						}?>
						</tbody>
					</table>
				</div>	
				<div class="panel panel-default">
					<div class="panel-heading">
						Opiekun
					</div>
					
					<table class="table table-bordered table-hover table-striped ">
						<thead class="table-header">
						<tr>
							<th>Id</th>
							<th>Imie i Nazwisko</th>
						</tr>
						</thead>
						<tbody>
							<?php
							echo
							'<tr>
								<td>'.$user_system['id_user'].'</td>
								<td>'.$user_system['firstname'].' '.$user_system['lastname'].'</td>
							</tr>';
							?>
						</tbody>
					</table>
				</div>	
			  </div>
			</div>
		    </div>
			<div class="tab-pane fade" id="orders-panel">
				<?php echo $block_orders;?>
			</div>
			<div class="tab-pane fade" id="payments-panel">
				<?php echo $block_payments;?>
			</div>
			<div class="tab-pane fade <?php echo ($tab == 4) ?  'in active' : "" ;?>" id="settings-panel" >
				<form class="form-horizontal" role="form" method="post" action="?action=settings">
					<div class="row">&nbsp;</div>
					<div class="row">
						<div class="col-md-4" style="text-align:center">
							<div class="panel panel-default">
								<div class="panel-heading">
									Możliwość składania zapytania ofertowego
								</div>
								<div class="panel-body">
									<div class="btn-group" data-toggle="buttons">
									  <label class="btn <?php echo ($client['inquiry']==1) ? 'btn-primary active' : 'btn-default';?>">
										<input type="radio" name="inquiry" id="inquiry1" value="1" <?php echo ($client['inquiry']==1) ? 'checked' : '';?>>&nbsp;&nbsp;Tak&nbsp;&nbsp;
									  </label>
									  <label class="btn <?php echo ($client['inquiry']==0) ? 'btn-primary active' : 'btn-default';?>">
										<input type="radio" name="inquiry" id="inquiry2" value="0" <?php echo ($client['inquiry']==0) ? 'checked' : ''; ?>>&nbsp;&nbsp;Nie&nbsp;&nbsp;
									  </label>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									Udział w programie lojalnosciowym
								</div>
								<div class="panel-body">
									<div class="btn-group" data-toggle="buttons">							
									  <label class="btn <?php echo ($client['loyalty']==1) ? 'btn-primary active' : 'btn-default';?>">
										<input type="radio" name="loyalty" id="loyalty1" value="1" <?php echo ($client['loyalty']==1) ? 'checked' : '';?>>&nbsp;&nbsp;Tak&nbsp;&nbsp;
									  </label>
									  <label class="btn <?php echo ($client['loyalty']==0) ? 'btn-primary active' : 'btn-default';?>">
										<input type="radio" name="loyalty" id="loyalty2" value="0" <?php echo ($client['loyalty']==0) ? 'checked' : '';?>>&nbsp;&nbsp;Nie&nbsp;&nbsp;
									  </label>
									</div>
								</div>
							</div>
							<div class="panel panel-default" >
								<div class="panel-heading">
									Opiekun klienta
								</div>
								<div class="panel-body">
									<select name="id_user_system" class="form-control" style="width:300px;margin:0 auto">
										<option value="0">-- Wybierz opiekuna --</option>
										<?php foreach($users_system as $id_user=>$user)
										{
										?>
											<option value="<?php echo $id_user;?>" <?php echo ($client['id_user_system'] == $id_user) ? "selected" : "";?> ><?php echo mb_substr($user['firstname'], 0,1).' '.$user['lastname'];?></option>
										<?php
										}
										?>
										
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="panel panel-default">
								<div class="panel-heading">
									Limity kupieckie
								</div>
								<div class="panel-body">
								  <div class="form-group">
									<label for="amount" class="col-sm-3 control-label">Kwotowy</label>
									<div class="col-sm-8">
									  <input type="text" class="form-control" id="amount" name="amount"  placeholder="0.00" value="<?php echo $client['limit_amount'];?>">
									</div>
								  </div>
								  <div class="form-group">
									<label for="amount-facture" class="col-sm-3 control-label">Maksymalna liczba dni spóźnienia</label>
									<div class="col-sm-8">
									  <input type="text" class="form-control" id="amount_facture" name="amount_facture" placeholder="0" value="<?php echo $client['limit_facture'];?>">
									</div>
								  </div>									  
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									Adresy email
								</div>
								<div class="panel-body">
								  <div class="form-group">
									<label for="accpeted_orders_emails" class="col-sm-12">Adresy, na które ma przyjść zatwierdzone zamówienie (oddzielone przecinkami)</label>
									<div class="col-sm-12">
									  <input type="text" class="form-control" id="accpeted_orders_emails" name="accpeted_orders_emails"  placeholder="adres1@email.pl, adres2@email.pl" value="<?php echo $client['accpeted_orders_emails'];?>">
									</div>
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
				</form>
			</div>	
		</div>
		<div class="tab-pane fade <?php echo ($tab == 5) ?  'in active' : "" ;?>" id="contracts-panel" >
			<?php echo $block_contracts;?>
		</div>
		
	  </div>
	</div>
	
</div>