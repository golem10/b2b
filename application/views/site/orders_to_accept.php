<div id="main-content">	
	<div class="w960">
		<?php echo $breadcrumbs;?>
		<div class="clear"></div>	
		
		<h2 class="header-h2">Zamówienia</h2>
		<div id="cart-block-accept">
			 <ul class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#to-accept" role="tab" data-toggle="tab">Do akceptacji</a></li>
				<li><a href="#suspended" role="tab" data-toggle="tab">Zawieszone</a></li>
				<li><a href="#to-realize" role="tab" data-toggle="tab">Do realizacji</a></li>
				<li><a href="#canceled" role="tab" data-toggle="tab">Anulowane</a></li>
				<li><a href="#realized" role="tab" data-toggle="tab">Zrealizowane</a></li>
			 </ul>	
				
			 <div class="tab-content">
			 
				<div class="tab-pane active" id="to-accept">
					<table class="own-table">
					<thead>
						<tr>
							<th class="padding-left">Lp.</th>
							<th class="center">Osoba zamawiająca</th>
							<th class="center">Data złożenia zamówienia</th>
							<th class="center"  style="display:none">Wartość<br/>[netto]</th>
							<th class="center">Wartość<br/>[brutto]</th>
							<th class="center">Akcje</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=0;
						$summary_value=0;
						$b_summary_value=0;
						  foreach($carts as $id_cart=>$cart)
						  {
							$total_value=0;
							$b_total_value = 0;
							$sum_prod = 0;
							$b_sum_prod=0;
							$i++;	
							if(isset($cart_products[$cart['id_cart']]))
								foreach ($cart_products[$cart['id_cart']] as $id_product=>$product)
									{
												$brutto = $product['price'] + ($product['price']*$product['vat'])/100;
												$sum_prod=round($product['amount']*$product['price'],2); 
												$total_value+=$sum_prod;
												$b_sum_prod=round($product['amount']*$brutto,2); 
												$b_total_value+=$b_sum_prod;													
									}					
													
							if($i%2 == 0)
								$evenOdd = 'even';
							else
								$evenOdd = 'odd';
						?>
						<tr class="<?php echo $evenOdd;?>">
							<td class="padding-left"><?php echo $i;?></td>
							<td class="center"><?php echo $cart['user'];?></td>
							<td class="center"><?php echo $cart['date_accepted'];?></td>
							<td class="center" id="total_cart_list_<?php echo $id_cart;?>" style="display:none"><?php echo number_format($total_value,2,',','');?> zł</td> 
							<td class="center" id="brutto_total_cart_list_<?php echo $id_cart;?>"><?php echo number_format($b_total_value,2,',','');?> zł</td>
							<td class="center"><a  class="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $cart['id_cart'];?>">Rozwiń</a></td>
						</tr>
						<tr>
								<td style="padding:0" colspan="6">
									<div id="collapse<?php echo $cart['id_cart'];?>" class="panel-collapse collapse">
									  <div class="panel-body">
											<table class="table table-striped cart-table">
												<thead>
													<tr>
														<th>Nazwa produktu</th><th class="text-right">Cena jedn.<br/>[netto]</th><th class="text-right">Cena jedn.<br/>[brutto]</th><th class="center" style="width:110px">Ilość</th><th class="text-right">Wartość<br/>[netto]</th><th class="text-right">Wartość<br/>[brutto]</th><th class="center">Akcja</th>
													</tr>
												</thead>
											<?php
												$total_value=0;
												$b_total_value = 0;
												$sum_prod = 0;
												$b_sum_prod=0;
												if(isset($cart_products[$cart['id_cart']]))
												foreach ($cart_products[$cart['id_cart']] as $id_product=>$product)
												{
												?>
													<tr>
														<td><?php echo $product['name'];?></td><td class="text-right"><?php echo number_format($product['price'],2,',','');?> zł</td>
														<td class="text-right">
															<?php 
															$brutto = $product['price'] + ($product['price']*$product['vat'])/100;
															echo number_format($brutto,2,',','');?> zł
														</td>
														<td >
															<input type="text" value="<?php echo $product['amount'];?>" class="form-control input-sm product_amount amount_product_cart_<?php echo $id_cart;?>" name="product_amount[<?php echo $id_product;?>]" id="product_amount_<?php echo $id_product;?>" rel="<?php echo $id_product;?>" rel2="<?php echo $product['amount_decimal'];?>"/>
															<div class="plus_minus_buttons">
																<span class="plus cart-plus" rel="<?php echo $id_product;?>" >+</span>
																<span class="minus cart-minus" rel="<?php echo $id_product;?>">-</span>
															</div>
															<?php 
															$sum_prod=round($product['amount']*$product['price'],2); $total_value+=$sum_prod;
															$b_sum_prod=round($product['amount']*$brutto,2); $b_total_value+=$b_sum_prod;
															?>
														</td>
														<td class="text-right"><span id="total_product_<?php echo $id_product;?>"><?php echo number_format($sum_prod,2,',','');?></span> zł</td>
														<td class="text-right"><span id="brutto_total_product_<?php echo $id_product;?>"><?php echo number_format($b_sum_prod,2,',','');?></span> zł</td>
														<td class="center"><a class="button deleteButton button-danger" data-toggle="modal" data-target="#modalDelete" rel="<?php echo $id_product;?>">Usuń</a></td>
														<input type="hidden" id="product_price_<?php echo $id_product;?>"  value="<?php echo $product['price'];?>"/>
														<input type="hidden" id="brutto_product_price_<?php echo $id_product;?>"  value="<?php echo $brutto;?>"/>
														<input type="hidden" id="id_cart_<?php echo $id_product;?>"  value="<?php echo $id_cart;?>"/>
													</tr>				
												<?php
												}
												?>
												<tfoot>
													<tr>
														<th></th><th class="text-right"></th><th></th><th></th><th class="text-right" colspan="2">Wartość zamówienia <span class="gray">(netto):</span> <span id="total_cart_<?php echo $id_cart;?>" class="total_cart"><?php echo number_format($total_value,2,',','');?></span> zł</th><th></th>
													</tr>
													<tr>
														<th></th><th class="text-right"></th><th></th><th></th><th class="text-right" colspan="2">Wartość zamówienia <span class="gray">(brutto):</span> <span id="b_total_cart_<?php echo $id_cart;?>" class="b_total_cart"><?php echo number_format($b_total_value,2,',','');?></span> zł</div></th><th></th>
													</tr>
												</tfoot>
											</table>
											<div class="button-bar">
											<?php if($this->session->userdata('id_profile') == 4)
											{?>
												<a class="button deleteButton button-danger button-decide" rel="<?php echo $id_cart;?>" data-toggle="modal" data-target="#modalCancel">Anuluj zamówienie</a>
											<?php }	
											if($this->session->userdata('id_user') == $cart['id_user'])
												{?>
												<a class="button  button-decide" href="<?php echo base_url("orders/cart/?id_cart=".$id_cart);?>">Edytuj zamówienie</a>
												<?php
												}
											if($this->session->userdata('id_profile') == 4)
											{
												if(count($contracts) > 0) 
												{?><a class="button button-ok button-decide"  data-toggle="modal" data-target="#modalContract"  rel="<?php echo $id_cart;?>">Złóż zamówienie</a>												
												<?php 
												}
												else
												{?>
												<a class="button button-ok button-decide acceptOrderNoContract" rel="<?php echo $id_cart;?>">Złóż zamówienie</a>	
												<?php
												}
											} 
											
											?>
											</div>
									  </div>
									</div>
								</td>
						</tr>
						<?php
						} 
						?>
					</tbody>
					</table>
				</div>
				<?php /******************************************************************************************************************************************************************************************************/ ?>
				<div class="tab-pane" id="suspended">
				<table class="own-table">
					<thead>
						<tr>
							<th class="padding-left">ID</th>
							<th class="center">Nr zamówienia</th>
							<th class="center">Osoba zamawiająca</th>
							<th class="center">Data złożenia zamówienia</th>
							<!-- <th class="center">Wartość<br/>[netto]</th> -->
							<th class="center">Wartość<br/>[brutto]</th>
							<th class="center">Akcje</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=0;
						$summary_value=0;
						$b_summary_value=0;
						  foreach($orders99 as $id_order=>$order)
						  {
							$total_value=0;
							$b_total_value = 0;
							$sum_prod = 0;
							$b_sum_prod=0;
							$i++;	
							if(isset($orders99_products[$order['id_order']]))
								foreach ($orders99_products[$order['id_order']] as $id_product=>$product)
									{
												$brutto = $product['price'] + ($product['price']*$product['vat'])/100;
												$sum_prod=round($product['amount']*$product['price'],2); 
												$total_value+=$sum_prod;
												$b_sum_prod=round($product['amount']*$brutto,2); 
												$b_total_value+=$b_sum_prod;													
									}				
													
							if($i%2 == 0)
								$evenOdd = 'even';
							else
								$evenOdd = 'odd';
						?>
						<tr class="<?php echo $evenOdd;?>">
							<td class="padding-left"><?php echo $id_order;?></td>
							<td class="center"><?php echo $order['number_subiekt'];?></td>
							<td class="center"><?php echo $order['user'];?></td>
							<td class="center"><?php echo $order['date'];?></td>
							<!-- <td class="center" id="total_cart_list_<?php echo $id_order;?>"><?php echo number_format($total_value,2,',','');?> zł</td> -->
							<td class="center" id="brutto_total_cart_list_<?php echo $id_order;?>"><?php echo number_format($b_total_value,2,',','');?> zł</td>
							<td class="center"><a  class="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $order['id_order'];?>">Rozwiń</a></td>
						</tr>
						 <tr>
								<td style="padding:0" colspan="6">
									<div id="collapse<?php echo $order['id_order'];?>" class="panel-collapse collapse">
									  <div class="panel-body">
											<table class="table table-striped cart-table">
												<thead>
													<tr>
														<th>Nazwa produktu</th><th class="text-right">Cena jedn.<br/>[netto]</th><th class="text-right">Cena jedn.<br/>[brutto]</th><th class="center">Ilość</th><th class="text-right">Wartość<br/>[netto]</th><th class="text-right">Wartość<br/>[brutto]</th>
													</tr>
												</thead>
											<?php
												$total_value=0;
												$b_total_value = 0;
												$sum_prod = 0;
												$b_sum_prod=0;
												if(isset($orders99_products[$order['id_order']]))
												foreach ($orders99_products[$order['id_order']] as $id_product=>$product)
												{
												?>
													<tr>
														<td><?php echo $product['name'];?></td><td class="text-right"><?php echo number_format($product['price'],2,',','');?> zł</td>
														<td class="text-right">
															<?php 
															$brutto = $product['price'] + ($product['price']*$product['vat'])/100;
															echo number_format($brutto,2,',','');?> zł
														</td>
														<td class="center">
														<?php echo $product['amount'];?>
															
															<?php 
															$sum_prod=round($product['amount']*$product['price'],2); $total_value+=$sum_prod;
															$b_sum_prod=round($product['amount']*$brutto,2); $b_total_value+=$b_sum_prod;
															?>
														</td>
														<td class="text-right"><span id="total_product_<?php echo $id_product;?>"><?php echo number_format($sum_prod,2,',','');?></span> zł</td>
														<td class="text-right"><span id="brutto_total_product_<?php echo $id_product;?>"><?php echo number_format($b_sum_prod,2,',','');?></span> zł</td>
														<input type="hidden" id="product_price_<?php echo $id_product;?>"  value="<?php echo $product['price'];?>"/>
														<input type="hidden" id="brutto_product_price_<?php echo $id_product;?>"  value="<?php echo $brutto;?>"/>
														<input type="hidden" id="id_cart_<?php echo $id_product;?>"  value="<?php echo $id_order;?>"/>
													</tr>				
												<?php
												}
												?>
												<tfoot>
													<tr>
														<th></th><th class="text-right"></th><th></th><th></th><th class="text-right" colspan="2">Wartość zamówienia <span class="gray">(netto):</span> <span id="total_cart_<?php echo $id_order;?>" class="total_cart"><?php echo number_format($total_value,2,',','');?></span> zł</th><th></th>
													</tr>
													<tr>
														<th></th><th class="text-right"></th><th></th><th></th><th class="text-right" colspan="2">Wartość zamówienia <span class="gray">(brutto):</span> <span id="b_total_cart_<?php echo $id_order;?>" class="b_total_cart"><?php echo number_format($b_total_value,2,',','');?></span> zł</div></th><th></th>
													</tr>
												</tfoot>
											</table>
											<div class="button-bar">
												<?php  /*
												<a class="button deleteButton button-danger button-decide" rel="<?php echo $id_cart;?>" data-toggle="modal" data-target="#modalCancel">Anuluj zamówienie</a>
												<a class="button button button-decide"  data-toggle="modal" data-target="#modalContract"  rel="<?php echo $id_cart;?>">Złóż zamówienie</a>
												*/ ?>
											</div>
									  </div>
									</div>
								</td>
						</tr> 
						<?php
						} 
						?>
					</tbody>
					</table>
				</div>
				<?php /**************************************************************************************************************************************/?>
				<div class="tab-pane" id="to-realize">
					<table class="own-table">
					<thead>
						<tr>
							<th class="padding-left">ID</th>
							<th class="center">Nr zamówienia</th>
							<th class="center">Osoba zamawiająca</th>
							<th class="center">Data złożenia zamówienia</th>
							<!-- <th class="center">Wartość<br/>[netto]</th> -->
							<th class="center">Wartość<br/>[brutto]</th>
							<th class="center">Akcje</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=0;
						$summary_value=0;
						$b_summary_value=0;
						  foreach($orders2 as $id_order=>$order)
						  {
							$total_value=0;
							$b_total_value = 0;
							$sum_prod = 0;
							$b_sum_prod=0;
							$i++;	
							if(isset($orders2_products[$order['id_order']]))
								foreach ($orders2_products[$order['id_order']] as $id_product=>$product)
									{
												$brutto = $product['price'] + ($product['price']*$product['vat'])/100;
												$sum_prod=round($product['amount']*$product['price'],2); 
												$total_value+=$sum_prod;
												$b_sum_prod=round($product['amount']*$brutto,2); 
												$b_total_value+=$b_sum_prod;													
									}				
													
							if($i%2 == 0)
								$evenOdd = 'even';
							else
								$evenOdd = 'odd';
						?>
						<tr class="<?php echo $evenOdd;?>">
							<td class="padding-left"><?php echo $id_order;?></td>
							<td class="center"><?php echo $order['number_subiekt'];?></td>
							<td class="center"><?php echo $order['user'];?></td>
							<td class="center"><?php echo $order['date'];?></td>
							<!-- <td class="center" id="total_cart_list_<?php echo $id_order;?>"><?php echo number_format($total_value,2,',','');?> zł</td> -->
							<td class="center" id="brutto_total_cart_list_<?php echo $id_order;?>"><?php echo number_format($b_total_value,2,',','');?> zł</td>
							<td class="center"><a  class="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $order['id_order'];?>">Rozwiń</a></td>
						</tr>
						 <tr>
								<td style="padding:0" colspan="6">
									<div id="collapse<?php echo $order['id_order'];?>" class="panel-collapse collapse">
									  <div class="panel-body">
											<table class="table table-striped cart-table">
												<thead>
													<tr>
														<th>Nazwa produktu</th><th class="text-right">Cena jedn.<br/>[netto]</th><th class="text-right">Cena jedn.<br/>[brutto]</th><th class="center">Ilość</th><th class="text-right">Wartość<br/>[netto]</th><th class="text-right">Wartość<br/>[brutto]</th>
													</tr>
												</thead>
											<?php
												$total_value=0;
												$b_total_value = 0;
												$sum_prod = 0;
												$b_sum_prod=0;
												if(isset($orders2_products[$order['id_order']]))
												foreach ($orders2_products[$order['id_order']] as $id_product=>$product)
												{
												?>
													<tr>
														<td><?php echo $product['name'];?></td><td class="text-right"><?php echo number_format($product['price'],2,',','');?> zł</td>
														<td class="text-right">
															<?php 
															$brutto = $product['price'] + ($product['price']*$product['vat'])/100;
															echo number_format($brutto,2,',','');?> zł
														</td>
														<td class="center">
														<?php echo $product['amount'];?>
															
															<?php 
															$sum_prod=round($product['amount']*$product['price'],2); $total_value+=$sum_prod;
															$b_sum_prod=round($product['amount']*$brutto,2); $b_total_value+=$b_sum_prod;
															?>
														</td>
														<td class="text-right"><span id="total_product_<?php echo $id_product;?>"><?php echo number_format($sum_prod,2,',','');?></span> zł</td>
														<td class="text-right"><span id="brutto_total_product_<?php echo $id_product;?>"><?php echo number_format($b_sum_prod,2,',','');?></span> zł</td>
														<input type="hidden" id="product_price_<?php echo $id_product;?>"  value="<?php echo $product['price'];?>"/>
														<input type="hidden" id="brutto_product_price_<?php echo $id_product;?>"  value="<?php echo $brutto;?>"/>
														<input type="hidden" id="id_cart_<?php echo $id_product;?>"  value="<?php echo $id_order;?>"/>
													</tr>				
												<?php
												}
												?>
												<tfoot>
													<tr>
														<th></th><th class="text-right"></th><th></th><th></th><th class="text-right" colspan="2">Wartość zamówienia <span class="gray">(netto):</span> <span id="total_cart_<?php echo $id_order;?>" class="total_cart"><?php echo number_format($total_value,2,',','');?></span> zł</th><th></th>
													</tr>
													<tr>
														<th></th><th class="text-right"></th><th></th><th></th><th class="text-right" colspan="2">Wartość zamówienia <span class="gray">(brutto):</span> <span id="b_total_cart_<?php echo $id_order;?>" class="b_total_cart"><?php echo number_format($b_total_value,2,',','');?></span> zł</div></th><th></th>
													</tr>
												</tfoot>
											</table>
											<div class="button-bar">
												<?php  /*
												<a class="button deleteButton button-danger button-decide" rel="<?php echo $id_cart;?>" data-toggle="modal" data-target="#modalCancel">Anuluj zamówienie</a>
												<a class="button button button-decide"  data-toggle="modal" data-target="#modalContract"  rel="<?php echo $id_cart;?>">Złóż zamówienie</a>
												*/ ?>
											</div>
									  </div>
									</div>
								</td>
						</tr> 
						<?php
						} 
						?>
					</tbody>
					</table>
				</div>
				<?php /**************************************************************************************************************************************/?>
				<div class="tab-pane" id="canceled">
					<table class="own-table">
					<thead>
						<tr>
							<th class="padding-left">Lp.</th>
							<th class="center">Osoba zamawiająca</th>
							<th class="center">Data złożenia zamówienia</th>
							<!-- <th class="center">Wartość<br/>[netto]</th> -->
							<th class="center">Wartość<br/>[brutto]</th>
							<th class="center">Akcje</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=0;
						$summary_value=0;
						$b_summary_value=0;
						  foreach($carts_canceled as $id_cart=>$cart)
						  {
							$total_value=0;
							$b_total_value = 0;
							$sum_prod = 0;
							$b_sum_prod=0;
							$i++;	
							if(isset($cart_products_canceled[$cart['id_cart']]))
								foreach ($cart_products_canceled[$cart['id_cart']] as $id_product=>$product)
									{
												$brutto = $product['price'] + ($product['price']*$product['vat'])/100;
												$sum_prod=round($product['amount']*$product['price'],2); 
												$total_value+=$sum_prod;
												$b_sum_prod=round($product['amount']*$brutto,2); 
												$b_total_value+=$b_sum_prod;													
									}					
													
							if($i%2 == 0)
								$evenOdd = 'even';
							else
								$evenOdd = 'odd';
						?>
						<tr class="<?php echo $evenOdd;?>">
							<td class="padding-left"><?php echo $i;?></td>
							<td class="center"><?php echo $cart['user'];?></td>
							<td class="center"><?php echo $cart['date_accepted'];?></td>
							<!-- <td class="center" id="total_cart_list_<?php echo $id_cart;?>"><?php echo number_format($total_value,2,',','');?> zł</td> -->
							<td class="center" id="brutto_total_cart_list_<?php echo $id_cart;?>"><?php echo number_format($b_total_value,2,',','');?> zł</td>
							<td class="center"><a  class="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $cart['id_cart'];?>">Rozwiń</a></td>
						</tr>
						<tr>
								<td style="padding:0" colspan="6">
									<div id="collapse<?php echo $cart['id_cart'];?>" class="panel-collapse collapse">
									  <div class="panel-body">
											<table class="table table-striped cart-table">
												<thead>
													<tr>
														<th>Nazwa produktu</th><th class="text-right">Cena jedn.<br/>[netto]</th><th class="text-right">Cena jedn.<br/>[brutto]</th><th class="center">Ilość</th><th class="text-right">Wartość<br/>[netto]</th><th class="text-right">Wartość<br/>[brutto]</th>
													</tr>
												</thead>
											<?php
												$total_value=0;
												$b_total_value = 0;
												$sum_prod = 0;
												$b_sum_prod=0;		
												if(isset($cart_products_canceled[$cart['id_cart']]))
												foreach ($cart_products_canceled[$cart['id_cart']] as $id_product=>$product)
												{
												?>
													<tr>
														<td><?php echo $product['name'];?></td><td class="text-right"><?php echo number_format($product['price'],2,',','');?> zł</td>
														<td class="text-right">
															<?php 
															$brutto = $product['price'] + ($product['price']*$product['vat'])/100;
															echo number_format($brutto,2,',','');?> zł
														</td>
														<td class="center">
														<?php echo $product['amount'];?>
															
															<?php 
															$sum_prod=round($product['amount']*$product['price'],2); $total_value+=$sum_prod;
															$b_sum_prod=round($product['amount']*$brutto,2); $b_total_value+=$b_sum_prod;
															?>
														</td>
														<td class="text-right"><span id="total_product_<?php echo $id_product;?>"><?php echo number_format($sum_prod,2,',','');?></span> zł</td>
														<td class="text-right"><span id="brutto_total_product_<?php echo $id_product;?>"><?php echo number_format($b_sum_prod,2,',','');?></span> zł</td>
														<input type="hidden" id="product_price_<?php echo $id_product;?>"  value="<?php echo $product['price'];?>"/>
														<input type="hidden" id="brutto_product_price_<?php echo $id_product;?>"  value="<?php echo $brutto;?>"/>
														<input type="hidden" id="id_cart_<?php echo $id_product;?>"  value="<?php echo $id_cart;?>"/>
													</tr>				
												<?php
												}
												?>
												<tfoot>
													<tr>
														<th></th><th class="text-right"></th><th></th><th></th><th class="text-right" colspan="2">Wartość zamówienia <span class="gray">(netto):</span> <span id="total_cart_<?php echo $id_cart;?>" class="total_cart"><?php echo number_format($total_value,2,',','');?></span> zł</th><th></th>
													</tr>
													<tr>
														<th></th><th class="text-right"></th><th></th><th></th><th class="text-right" colspan="2">Wartość zamówienia <span class="gray">(brutto):</span> <span id="b_total_cart_<?php echo $id_cart;?>" class="b_total_cart"><?php echo number_format($b_total_value,2,',','');?></span> zł</div></th><th></th>
													</tr>
												</tfoot>
											</table>
											<div class="button-bar">
												<?php  /*
												<a class="button deleteButton button-danger button-decide" rel="<?php echo $id_cart;?>" data-toggle="modal" data-target="#modalCancel">Anuluj zamówienie</a>
												<a class="button button button-decide"  data-toggle="modal" data-target="#modalContract"  rel="<?php echo $id_cart;?>">Złóż zamówienie</a>
												*/ ?>
											</div>
									  </div>
									</div>
								</td>
						</tr>
						<?php
						} 
						?>
					</tbody>
					</table>
				</div>
				<?php /**************************************************************************************************************************************/?>
				<div class="tab-pane" id="realized">
					<table class="own-table">
					<thead>
						<tr>
							<th class="padding-left">ID</th>
							<th class="center">Nr zamówienia</th>
							<th class="center">Osoba zamawiająca</th>
							<th class="center">Data złożenia zamówienia</th>
							<!-- <th class="center">Wartość<br/>[netto]</th>-->
							<th class="center">Wartość<br/>[brutto]</th> 
							<th class="center">Akcje</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=0;
						$summary_value=0;
						$b_summary_value=0;
						  foreach($orders3 as $id_order=>$order)
						  {
							$total_value=0;
							$b_total_value = 0;
							$sum_prod = 0;
							$b_sum_prod=0;
							$i++;	
							if(isset($orders3_products[$order['id_order']]))
								foreach ($orders3_products[$order['id_order']] as $id_product=>$product)
									{
												$brutto = $product['price'] + ($product['price']*$product['vat'])/100;
												$sum_prod=round($product['amount']*$product['price'],2); 
												$total_value+=$sum_prod;
												$b_sum_prod=round($product['amount']*$brutto,2); 
												$b_total_value+=$b_sum_prod;													
									}				
													
							if($i%2 == 0)
								$evenOdd = 'even';
							else
								$evenOdd = 'odd';
						?>
						<tr class="<?php echo $evenOdd;?>">
							<td class="padding-left"><?php echo $id_order;?></td>
							<td class="center"><?php echo $order['number_subiekt'];?></td>
							<td class="center"><?php echo $order['user'];?></td>
							<td class="center"><?php echo $order['date'];?></td>
							<!-- <td class="center" id="total_cart_list_<?php echo $id_order;?>"><?php echo number_format($total_value,2,',','');?> zł</td> -->
							<td class="center" id="brutto_total_cart_list_<?php echo $id_order;?>"><?php echo number_format($b_total_value,2,',','');?> zł</td>
							<td class="center"><a  class="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $order['id_order'];?>">Rozwiń</a></td>
						</tr>
						 <tr>
								<td style="padding:0" colspan="6">
									<div id="collapse<?php echo $order['id_order'];?>" class="panel-collapse collapse">
									  <div class="panel-body">
											<table class="table table-striped cart-table">
												<thead>
													<tr>
														<th>Nazwa produktu</th><th class="text-right">Cena jedn.<br/>[netto]</th><th class="text-right">Cena jedn.<br/>[brutto]</th><th class="center">Ilość</th><th class="text-right">Wartość<br/>[netto]</th><th class="text-right">Wartość<br/>[brutto]</th>
													</tr>
												</thead>
											<?php
												$total_value=0;
												$b_total_value = 0;
												$sum_prod = 0;
												$b_sum_prod=0;
												if(isset($orders3_products[$order['id_order']]))
												foreach ($orders3_products[$order['id_order']] as $id_product=>$product)
												{
												?>
													<tr>
														<td><?php echo $product['name'];?></td><td class="text-right"><?php echo number_format($product['price'],2,',','');?> zł</td>
														<td class="text-right">
															<?php 
															$brutto = $product['price'] + ($product['price']*$product['vat'])/100;
															echo number_format($brutto,2,',','');?> zł
														</td>
														<td class="center">
														<?php echo $product['amount'];?>
															
															<?php 
															$sum_prod=round($product['amount']*$product['price'],2); $total_value+=$sum_prod;
															$b_sum_prod=round($product['amount']*$brutto,2); $b_total_value+=$b_sum_prod;
															?>
														</td>
														<td class="text-right"><span id="total_product_<?php echo $id_product;?>"><?php echo number_format($sum_prod,2,',','');?></span> zł</td>
														<td class="text-right"><span id="brutto_total_product_<?php echo $id_product;?>"><?php echo number_format($b_sum_prod,2,',','');?></span> zł</td>
														<input type="hidden" id="product_price_<?php echo $id_product;?>"  value="<?php echo $product['price'];?>"/>
														<input type="hidden" id="brutto_product_price_<?php echo $id_product;?>"  value="<?php echo $brutto;?>"/>
														<input type="hidden" id="id_cart_<?php echo $id_product;?>"  value="<?php echo $id_order;?>"/>
													</tr>				
												<?php
												}
												?>
												<tfoot>
													<tr>
														<th></th><th class="text-right"></th><th></th><th></th><th class="text-right" colspan="2">Wartość zamówienia <span class="gray">(netto):</span> <span id="total_cart_<?php echo $id_order;?>" class="total_cart"><?php echo number_format($total_value,2,',','');?></span> zł</th><th></th>
													</tr>
													<tr>
														<th></th><th class="text-right"></th><th></th><th></th><th class="text-right" colspan="2">Wartość zamówienia <span class="gray">(brutto):</span> <span id="b_total_cart_<?php echo $id_order;?>" class="b_total_cart"><?php echo number_format($b_total_value,2,',','');?></span> zł</div></th><th></th>
													</tr>
												</tfoot>
											</table>
											<div class="button-bar">
												<?php if($client['inquiry'] == 1){?><a class="button button"  href="<?php echo base_url("inquiries/createFromOrder/".$id_order);?>">Złóż zapytanie ofertowe</a><?php } ?>
												<a class="button button" href="<?php echo base_url("orders/createCartFromOrder/".$id_order);?>">Utwórz koszyk</a>
												
											</div>
									  </div>
									</div>
								</td>
						</tr> 
						<?php
						} 
						?>
					</tbody>
					</table>
				</div>
				<?php /**************************************************************************************************************************************/?>
				
			
			</div>
		</div>
		<?php echo "";// $pagination_links;?>
		
	
		
	</div>
</div>
<input type="hidden" id="baseUrlToUse" value="<?php echo base_url();?>"/>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalContract">
  <div class="modal-dialog ">
	<div class="modal-content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Kontrakty
			</div>
		</div>		
		<p class="center">Wybierz kontrakt, w ramach którego ma zostać zrealizowane zamówienie.</p>
			<br/>
			<input type="hidden" id="id_cart_input">
			<table class="table table-striped">
			<?php
				foreach($contracts as $id_contract=>$contract)
				{
				?>
				<tr>						
					<td><?php echo $contract['name'];?></td><td><?php echo $contract['date_availability'];?></td><td class="text-right"><a class="button acceptOrder" rel="<?php echo base_url("orders/summary/".$id_contract);?>" >Wybierz</a></th>
						</tr>
				<?php
				}
			?>
			</table>
			<div class="center">
				<a class="btn btn-primary acceptOrder" rel="<?php echo base_url("orders/summary/");?>"><span class="glyphicon glyphicon-ok"></span>&nbsp;Bez kontraktu</a>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Anuluj</a>
				<br/><br/>
			</div>
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
		<form action="<?php echo base_url("orders/deleteProductCart/?orders=1");?>" method="post" class="center">
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

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalCancel">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Anulowanie zamówienia
			</div>
		</div>		
		<p class="center">Czy napewno chcesz anulować zamówienie?</p>
		<form action="<?php echo base_url("orders/cancelCart");?>" method="post" class="center">
			<input type="hidden" id="idToCancel" name="idToCancel" />
			<br/>
			<button class="btn btn-danger" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Tak</button>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Nie</a>
			<br/><br/>
		</form>
	</div>
  </div>
</div>

<script>
$(function(){
	$(".button-decide").click(function(){
		$("#id_cart_input").val($(this).attr("rel"));	
		$("#idToCancel").val($(this).attr("rel"));			
	});
	
	$(".acceptOrder").click(function(){
		window.location = $(this).attr("rel")+"?id_cart="+$("#id_cart_input").val();			
	});
	$(".acceptOrderNoContract").click(function(){
		window.location = "<?php echo base_url("orders/summary/");?>?id_cart="+$(this).attr("rel");			
	});

});
</script>