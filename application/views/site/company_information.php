<div id="main-content">	
	<div class="w960">
		<?php echo $breadcrumbs;?>
		<div class="clear"></div>	
		
		<h2 class="header-h2">Dane firmy</h2>
		
		<div id="company-block">
			<div class="company-box">
				<div id="top-img"></div>
				<div class="header-company">
					<div class="company-info-1">
						<div class="circle">
							<img src="<?php echo base_url("images/icon_about_16x16.png");?>">
						</div>
						<h5>Dane firmy</h5>
					</div>
					<div class="company-info-2">
						<div class="circle">
							<img src="<?php echo base_url("images/icon_delivery_16x9.png");?>">
						</div>
						<h5>Adres dostawy</h5>
					</div>
					<div class="company-info-2">
						<div class="circle">
							<img src="<?php echo base_url("images/icon_contact_16x16.png");?>">
						</div>
						<h5>Dane kontaktowe</h5>
					</div>
				</div>
				<div class="clear"></div>
				<div class="underline">
				</div>
				
				<div class="company-info-1">
					<table class="table table-companyinfo">						
						<tbody>
							<tr class="no-border-top">
								<td class="cell-label">Nazwa firmy: </td><td class="cell-value"><?php echo $client['name'];?></td>
							</tr>
							<tr class="no-border-top">
								<td class="cell-label">Adres: </td><td class="cell-value"><?php echo $client['street'];?><br/><?php echo $client['city'];?></td>
							</tr>
							<tr class="no-border-top">
								<td class="cell-label">NIP: </td><td class="cell-value"><?php echo $client['nip'];?></td>
							</tr>
							

						</tbody>
					</table>
				</div>
				<div class="company-info-2">
					<table class="table table-companyinfo">						
						<tbody>
							
							<tr class="no-border-top">
								<td class="cell-label">Adres: </td><td class="cell-value"><?php echo $client['delivery_street'];?><br/><?php echo $client['delivery_city'];?></td>
							</tr>
							
							

						</tbody>
					</table>
				</div>
				<div class="company-info-3">
					<table class="table table-companyinfo">						
						<tbody>
							<tr class="no-border-top">
								<td class="cell-label person-cell">Osoba: </td><td class="cell-value"><?php echo $user['firstname']." ".$user['lastname'];?></td>
							</tr>
							<tr class="no-border-top">
								<td class="cell-label email-cell">E-mail: </td><td class="cell-value"><?php echo $user['email'];?></td>
							</tr>
							<tr class="no-border-top">
								<td class="cell-label phone-cell">Telefon: </td><td class="cell-value"><?php echo $user['phone_number'];?></td>
							</tr>						
							<tr class="no-border-top">
								<td class="cell-label mpk-cell">Numer MPK: </td><td class="cell-value"><?php echo $user['mpk'];?></td>
							</tr>

						</tbody>
					</table>
				</div>
				<div class="clear"></div>
					
			</div>
		</div>
		
	</div>
</div>
