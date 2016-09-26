<div id="product-block">
	 <h2 class="product-name"><?php echo $product['name'];?><?php echo (isset($product_in_promotions[$product['id_product']])) ? '<span class="badges promo-badges pull-right">promocja</span>' :"";?></h2>
	 <div class="image-box">
		
		<div class="image">
			
			  <a href="<?php echo base_url("uploads/images/".$imageDefault['url']);?>" rel='prettyPhoto[]' title="<?php echo $imageDefault['description'];?>" ><img src="<?php echo base_url("uploads/images/".$imageDefault['url']);?>"  class="list-image" /></a>
		</div>
		<?php 
		$i=0;
		foreach($images as $id_image=>$value)
		  {$i++;
		  $tab_url=explode(".",$value['url']);
		  if($imageDefault['id_image']==$id_image)
			continue;		  
		  ?>
		  <div class="small-img <?php echo ($i==2) ? "pull-right" :"";?>">
			<a href="<?php echo base_url("uploads/images/".$value['url']);?>" rel='prettyPhoto[]' title="<?php echo $value['description'];?>" ><img class="small" src="<?php echo base_url("uploads/images/".$tab_url[0].".".$tab_url[1]);?>" /></a>
		  </div>
		  <?php
		
		  }
		  ?>
		  <div class="clear"></div>
	 </div>
	 <div class="info-box">
		<table>
			<tr><td class="tlabel">Kod produktu</td><td><?php echo $product['code'];?></td></tr>
			<?php if(isset($producer['name'])){?><tr><td class="tlabel">Producent</td><td><?php  echo $producer['name'];?></td></tr><?php }?>
			<?php if($product['loyalty']==1){?>
				<tr><td class="tlabel"></td><td><img src="<?php echo base_url("images/loyalty_icon.png");?>" style="width:130px"/></td></tr>
			<?php }?>
		</table>
		<table class="table-price">
			<tr><td class="tlabel">Cena netto</td><td class="netto"><?php echo number_format($product['price'],2, ',',' ');?> zł</td></tr>
			
			<?php if(isset($product['old_price'])) if($product['price'] != $product['old_price'])
				{echo "<tr><td></td><td>";
				echo '<span class="old_price-product">'.number_format($product['old_price'],2,',',' ')." zł</span>" ;
				echo "</td></tr>";
				echo "<tr><td>&nbsp;</td><td></td></tr>";
				}
				?>
			<tr><td class="tlabel">Cena brutto</td ><td class="brutto"><?php echo number_format($product['price'] + ($product['price'] *  $product['vat']/100),2, ',',' ');?> zł</td></tr>
			<tr><td class="tlabel"></td><td class="status status<?php echo $product['id_info_status'];?>">Produkt <?php echo $statuses[$product['id_info_status']]['name'];?></td></tr>
		</table>
		<div class="buttons-bar">
			<input type="submit" value="Dodaj do zamówienia" class="button addProductToOrder" rel="<?php echo $product['id_product'];?>" />
			<div class="plus_minus_buttons">
				<span class="plus" rel="<?php echo $product['id_product'];?>" >+</span>
				<span class="minus" rel="<?php echo $product['id_product'];?>">-</span>
			</div>
			<input class="form-control input-sm product_amount" type="text" id="product_amount_<?php echo $product['id_product'];?>" maxlength="5" placeholder ="" value="1" rel2="<?php echo $product['amount_decimal'];?>">
			<div class="clear"></div>		
		</div>
		<?php if(isset($favorite_list[$product['id_product']]))
		{	?>
		<a class="add_favourit add_favourit-active favorit_product" rel="<?php echo $product['id_product'];?>"><span></span>Dodano do ulubionych</a>
		<?php }
		else {?>
		<a class="add_favourit favorit_product" rel="<?php echo $product['id_product'];?>"><span></span>Dodaj do ulubionych</a>
		<?php
		}
		?>
	 </div>
	 <div class="clear"></div>
	 
	 <ul class="nav nav-tabs" role="tablist">
		<li class="active" id="desc-tab"><a href="#desc-box" role="tab" data-toggle="tab">Opis</a></li>
	 </ul>
	 <div class="tab-content">
		<div class="tab-pane active" id="desc-box">
			<?php echo $product['description'];?>
		</div>
	 </div>
	 
</div>

<?php if(count($related_products))
{
?>
	

	<div id="related_products_box">
		<h2 class="header-h2">Produkty powiązane (<?php echo count($related_products);?>)</h2>
		<div class="related-box">
			<div id="related_products_scroller" class="amazon_scroller ">
				<div class="amazon_scroller_mask">
					<ul>
						<?php foreach($related_products as $k=>$v)
						{
						?>
						
						<li>
							<a class="img" href="<?php echo base_url("products/view/".$v['id_product']);?>">							
									<img src="<?php echo base_url("uploads/images/".$v['url']);?>"  alt=""/>
							</a>
							<p class="product_name">
								<a href="<?php echo base_url("products/view/".$v['id_product']);?>">
									<?php echo $v['name'];?>
								</a>			
							</p>
							<p class="product_price">Cena netto: <span class="price"><?php echo number_format($v['price'],2,","," ");?></span><br/><br/>
							<a href="<?php echo base_url("products/view/".$v['id_product']);?>" class="button">Zobacz</a>						
						</li>
						<?php 
						}
						?>				
						</ul>
				</div>
				<ul class="amazon_scroller_nav">
					<li></li>
					<li></li>
				</ul>
				<div style="clear: both"></div>
			</div>
		</div>
	</div>
<?php
}
?>


<input type="hidden" id="priceToUse_<?PHP echo $product['id_product'];?>" value="<?php echo $product['price'];?>"/>
<input type="hidden" id="baseUrlToUse" value="<?php echo base_url();?>"/>
<input type="hidden" id="bruttoToUse_<?PHP echo $product['id_product'];?>" value="<?php echo $product['price']+(($product['price']*$product['vat'])/100);?>"/>
<?php
if(count($related_products) <3)
{
echo "<style>
.amazon_scroller_nav{display:none}
</style>";

}?>
<script>
  $(document).ready(function(){		
	$("a[rel^='prettyPhoto']").prettyPhoto({
	social_tools: false
	});

	$("#related_products_scroller").amazon_scroller({
		scroller_title_show: 'disable',
		scroller_time_interval: '4000',
		scroller_window_padding: '10',
		scroller_images_width: '200',
		scroller_images_height: 'auto',                
		scroller_show_count: '3',
		scroller_border_size: '0',
		directory: 'images'
		
	});
  });
</script>
