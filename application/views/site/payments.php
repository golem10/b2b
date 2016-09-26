<div id="main-content">	
	<div class="w960">
		<?php echo $breadcrumbs;?>
		<div class="clear"></div>	
		
		<h2 class="header-h2">Twoje faktury</h2>
		<div id="factures-block">
			 <ul class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#to-pay-box" role="tab" data-toggle="tab">Do zapłaty</a></li>
				<li><a href="#paid-box" role="tab" data-toggle="tab">Zapłacone</a></li>
			 </ul>
			 </ul>
			 <div class="tab-content">
				<div class="tab-pane active" id="to-pay-box">
					<table class="own-table">
					<thead>
						<tr>
							<th class="padding-left">Lp.</th>
							<th>Faktura</th>
							<th class="center">Data<br/>wystawienia</th>
							<th class="center">Termin<br/>płatności</th>
							<th class="center">Liczba dni</th>
							<th class="center">Kwota płatności<br/>[brutto]</th>
							<th class="center">Akcje</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=0;
						foreach($payments as $id_payment=>$payment)
						{ $i++;
									
							$file_path = 'uploads/factures/'.$payment['facture_url'];
							$exists = file_exists($file_path);
							if($payment['facture_url'] == "")
								$exists = 0;
							$days = strtotime($payment['deadline']) - strtotime(date("Y-m-d")) ;
							$days = round($days/3600/24);
							if($i%2 == 0)
								$evenOdd = 'even';
							else
								$evenOdd = 'odd';
						?>
						<tr class="<?php echo $evenOdd;?>">
							<td class="padding-left"><?php echo $i;?></td>
							<td><?php echo $payment['facture_code'];?></td>
							<td class="center"><?php echo $payment['date'];?></td>
							<td class="center"><?php echo $payment['deadline'];?></td>
							<td class="center"><?php echo $days;?></td>
							<td class="center"><?php echo $payment['amount_b'];?></td>
							<td class="center"><a href="<?php echo $exists ? base_url("uploads/factures/".$payment['facture_url']) : "#";?>" <?php echo $exists ? "" : "onclick='alert(\"Brak pliku faktury.\")'"; ?>  <?php echo $exists ? 'target="_blank"':""; ?> class="button">Pobierz PDF</a>&nbsp;
							<?php
							if(isset($corrections[$payment['id_facture']]))
							 {
							?>
							<a href="#collapse<?php echo $id_payment?>" data-toggle="collapse" data-parent="#accordion" class="button" rel="payments"><img src="images/down_arrow.png" class="arrow-accordion"/></a>
							<?Php
							}
							else
							{?>
							<a class="button button-disable"><img src="images/down_arrow_grey.png"/></a>
							<?php
							}?>
							</td>
						</tr>
						<?php
							if(isset($corrections[$payment['id_facture']]))
							 {
							?>
							<tr>
								<td style="padding:0" colspan="7">
									<div id="collapse<?php echo $id_payment;?>" class="panel-collapse collapse">
										<div class="panel-body">
												<table class="table table-striped">
													<thead>
														<tr>
															<th>Nr korekty</th><th class="text-right">Data</th><th class="text-right">Wartość</th><th class="center">Akcja</th>
														</tr>
													</thead>
												<?php 							
												foreach ($corrections[$payment['id_facture']] as $id_correction=>$correction)
													{	$file_path = 'uploads/factures/'.$correction['facture_url'];
														$exists_cor = file_exists($file_path);
														if($correction['facture_url'] == "")
															$exists_cor = 0;						
													?>
														<tr>
																<td><?php echo $correction['facture_code'];?></td>
																<td class="text-right"><?php echo $correction['date'];?></td>
																<td class="text-right"><?php echo $correction['amount_b'];?></td>
																<td  class="center"><a href="<?php echo $exists_cor ? base_url("uploads/factures/".$correction['facture_url']) : "#";?>" <?php echo $exists_cor ? "" : "onclick='alert(\"Brak pliku faktury.\")'"; ?>  <?php echo $exists_cor ? 'target="_blank"':""; ?> class="button">Pobierz PDF</a></td>

														</tr>				
													<?php										
													}
													?>
													
												
												</table>
											
											<div class="clear"></div>
										  </div>
									</div>
								</td>	
							</tr>	
							<?php
							}
							?>
						<?php
						}
						?>
					</tbody>
					</table>
				</div>
				<div class="tab-pane"  id="paid-box">
					<table class="own-table">
					<thead>
						<tr>
							<th class="padding-left">Lp.</th>
							<th>Faktura</th>
							<th class="center">Data<br/>wystawienia</th>
							<th class="center">Termin<br/>płatności</th>
							<th class="center">Kwota płatności<br/>[brutto]</th>
							<th class="center">Akcje</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=0;
						foreach($payments_old as $id_payment=>$payment)
						{ $i++;
									
							$file_path = 'uploads/factures/'.$payment['facture_url'];
							$exists = file_exists($file_path);
							if($payment['facture_url'] == "")
								$exists = 0;
							$days = strtotime(date("Y-m-d")) - strtotime($payment['deadline']);
							$days = round($days/3600/24);
							if($i%2 == 0)
								$evenOdd = 'even';
							else
								$evenOdd = 'odd';
						?>
						<tr class="<?php echo $evenOdd;?>">
							<td class="padding-left"><?php echo $i;?></td>
							<td><?php echo $payment['facture_code'];?></td>
							<td class="center"><?php echo $payment['date'];?></td>
							<td class="center"><?php echo $payment['deadline'];?></td>
							<td class="center"><?php echo $payment['amount_b'];?></td>
							<td class="center"><a href="<?php echo $exists ? base_url("uploads/factures/".$payment['facture_url']) : "#";?>" <?php echo $exists ? "" : "onclick='alert(\"Brak pliku faktury.\")'"; ?>  <?php echo $exists ? 'target="_blank"':""; ?> class="button">Pobierz PDF</a>
							<?php
							if(isset($corrections_old[$payment['id_facture']]))
							 {
							?>
							<a href="#collapse<?php echo $id_payment?>" data-toggle="collapse" data-parent="#accordion" class="button" rel="payments"><img src="images/down_arrow.png" class="arrow-accordion"/></a>
							<?Php
							}
							else
							{?>
							<a class="button button-disable"><img src="images/down_arrow_grey.png"/></a>
							<?php
							}?>
							
							</td>
						</tr>
						
						<?php
							if(isset($corrections_old[$payment['id_facture']]))
							 {
							?>
							<tr>
								<td style="padding:0" colspan="7">
									<div id="collapse<?php echo $id_payment;?>" class="panel-collapse collapse">
										<div class="panel-body">
												<table class="table table-striped">
													<thead>
														<tr>
															<th>Nr korekty</th><th class="text-right">Data</th><th class="text-right">Wartość</th><th class="center">Akcja</th>
														</tr>
													</thead>
												<?php 							
												foreach ($corrections_old[$payment['id_facture']] as $id_correction=>$correction)
													{	$file_path = 'uploads/factures/'.$correction['facture_url'];
														$exists_cor = file_exists($file_path);
														if($correction['facture_url'] == "")
															$exists_cor = 0;						
													?>
														<tr>
																<td><?php echo $correction['facture_code'];?></td>
																<td class="text-right"><?php echo $correction['date'];?></td>
																<td class="text-right"><?php echo $correction['amount_b'];?></td>
																<td  class="center"><a href="<?php echo $exists_cor ? base_url("uploads/factures/".$correction['facture_url']) : "#";?>" <?php echo $exists_cor ? "" : "onclick='alert(\"Brak pliku faktury.\")'"; ?>  <?php echo $exists_cor ? 'target="_blank"':""; ?> class="button">Pobierz PDF</a></td>

														</tr>				
													<?php										
													}
													?>
													
												
												</table>
											
											<div class="clear"></div>
										  </div>
									</div>
								</td>	
							</tr>	
							<?php
							}
							?>
						<?php
						}
						?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		<?php echo $pagination_links;?>
		
	</div>
</div>
