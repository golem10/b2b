<div id="main-content">	
	<div class="w960">
		<?php echo $breadcrumbs;?>
		<div class="clear"></div>	
		
		<h2 class="header-h2">Koszyk</h2>
		<div id="cart-block">
			<?php if(count($cart_products) > 0)
			{?>
			<form method="post" action="<?php echo base_url("orders/subtotalCart");?>">
				<table class="table table-striped cart-table">
					<thead>
						<tr>
							<th >Nazwa produktu</th><th class="text-center">Cena jedn.<br/> netto</th><th class="text-center">Cena jedn.<br/> brutto</th><th>Ilość</th><th class="text-right">Wartość<br/>netto</th><th class="text-right">Wartość<br/>brutto</th><th>Akcja</th>
						</tr>
					</thead>
					
					<?php foreach ($cart_products as $id_product=>$product)
					{ $price_brutto=$product['price']+(($product['price']*$product['vat'])/100);
					?>
						<tr>
							<td><?php echo $product['name'];?></td><td class="text-center"><?php echo number_format($product['price'],2,',','');?> zł</td><td class="text-center"><?php echo  number_format($price_brutto, 2, ',', ' ');?> zł</td>
							<td>
								<input type="text" value="<?php echo $product['amount'];?>" class="form-control input-sm product_amount" name="product_amount[<?php echo $id_product;?>]" id="product_amount_<?php echo $id_product;?>" rel2="<?php echo $product['amount_decimal'];?>" />
								<div class="plus_minus_buttons">
									<span class="plus" rel="<?php echo $id_product;?>" >+</span>
									<span class="minus" rel="<?php echo $id_product;?>">-</span>
								</div>
							</td><td class="text-right"><?php echo round($product['amount']*$product['price'],2);?> zł</td><td class="text-right"><?php echo  number_format($product['amount']*$price_brutto, 2, ',', ' ');?> zł</td>
							<td><a class="button deleteButton" data-toggle="modal" data-target="#modalDelete" rel="<?php echo $id_product;?>">Usuń</a></td>
						</tr>				
					<?php
					}
					?>
					<tfoot>
						<tr>
							<th></th><th class="text-right"></th><th></th><th></th><th class="text-right" colspan="2">Razem (netto): <span><?php echo number_format($sum_cart[1],2,',','');?> zł</span></th><th></th>
						</tr>
						<tr>
							<th></th><th class="text-right"></th><th></th><th></th><th class="text-right" colspan="2">Razem (brutto): <span><?php echo number_format($sum_cart[2],2,',','');?> zł</span></th><th></th>
						</tr>
					</tfoot>
				</table>
				<div class="button-bar">
					<a class="button  button-danger" data-toggle="modal" data-target="#modalClear">Wyczyść koszyk</a>
					<input type="submit" class="button"  value="Przelicz koszyk" />
					<?php if($client['inquiry'] == 1){?><a href="<?php echo base_url("orders/sendInquiry");?>" class="button">Wyślij zapytanie ofertowe</a><?php }?>
					<a href="<?php echo base_url("orders/acceptCart");?>" class="button">
					<?php echo ($this->session->userdata('id_profile') == 4) ? "Utwórz zamówienie" : "Prześlij do akceptacji";?>
					</a>
					
				</div>
			</form>
			<?php } 
			else
			{
			echo '
				<div class="info-block padding10">
					<div class="info-box">
						<img src="'.base_url("images/icon_promo.png").'" />Brak produktów w koszyku
					</div>
				</div>';
			}
			?>
			
		</div>
		
	</div>
</div>
<?php
if(isset($is_edited))
{
?>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalInfo">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Zamówienie
			</div>
		</div>		
		<p class="center">Zamówienie zostało przeniesione do koszyka	<br/><br/>	
		<a class="btn btn-primary closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;OK</a>
		<br/><br/></p>
	</div>
  </div>
</div>
<script>
	$(function(){
		$('#modalInfo').modal('show')
	});
</script>
<?php
}
?>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalDelete">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Usuwanie elementu 
			</div>
		</div>		
		<p class="center">Czy napewno chcesz usunąć ten element?</p>
		<form action="<?php echo base_url("orders/deleteProductCart");?>" method="post" class="center">
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

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalClear">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Czyszczenie koszyka 
			</div>
		</div>		
		<p class="center">Czy napewno chcesz usunąć wszystkie elementy?</p>
		<form action="<?php echo base_url("orders/clearCart");?>" method="post" class="center">
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