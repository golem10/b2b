<div id="products-block">
	<?php if(isset($vars_products['title']))
		{?>
	<h2 class="header-h2"><?php echo $vars_products['title'];?> <span><?php echo (isset($total_rows)) ? "(".$total_rows.")" : "";?></span></h2>
	<?php
		}
		?>
	
	<?php if(isset($sort))
		{
		?>
		<div class="control-group" id="sort">Sortuj wg
			<select name="sort_select" id="sort_select" class="form-control" style="display:inline;width:auto;" rel="<?php echo base_url("categories/setSort/");?>">
			
				<option value="1" <?php if(1 == $sort) echo "selected";?>>nazwy rosnąco</option>
				<option value="2" <?php if(2 == $sort) echo "selected";?>>nazwy malejąco</option>
				<option value="3" <?php if(3 == $sort) echo "selected";?>>ceny rosnąco</option>
				<option value="4" <?php if(4 == $sort) echo "selected";?>>ceny malejąco</option>
				<option value="5" <?php if(5 == $sort) echo "selected";?>>kodu produktu</option>
				
			</select>	
		</div>
		<?php
		}
		?>
		<div class="clear"></div>
	<div class="products-box">	
		<?php 
		if(isset($products))
		if(count($products) > 0 && $products != 0 )
		{
			foreach($products as $id_product=>$product)
			{$tab_url=explode(".",$product['url']);
			if($product['url'] != "")
				$img_url=$tab_url[0]."_thumb.".$tab_url[1];
			else
				$img_url= "default.jpg"
			?>
			<div class="item">
					<div class="info_bar">
						<a class="add_favourit <?php echo (isset($favorite_list[$id_product])) ? "add_favourit-active" : "";?>"  rel="<?php echo $id_product;?>" data-toggle="tooltip" data-placement="top" title="Dodaj do ulubionych"></a><?php echo (isset($products_in_promotions[$id_product])) ? '<span class="badges promo-badges">promocja</span>' :"";?>
						<div class="clear"></div>
					</div>
					<div class="image"><a href="<?php echo base_url("products/view/".$id_product);?>"><img src="<?php echo base_url("uploads/images/".$img_url);?>" class="list-image"/></a></div>
					<p class="product_name"><a href="<?php echo base_url("products/view/".$id_product);?>"><?php echo $product['name'];?></a></p>
					<p class="product_price">Cena netto: <span class="price"><?php echo number_format($product['price'],2,","," ");?></span><br/>
						<span class="old_price"><?php if(isset($product['old_price'])) echo ($product['price'] != $product['old_price']) ? number_format($product['old_price'],2,',',' ')." zł" : "" ;?></span><?php echo (!isset($product['old_price'])) ? "&nbsp;" : "" ;?>
					</p>
					<div class="buttons-bar">
						<input type="submit" value="Do zamówienia" class="button addProductToOrder" rel="<?php echo $product['id_product'];?>"/>
						<div class="plus_minus_buttons">
							<span class="plus" rel="<?php echo $id_product;?>" >+</span>
							<span class="minus" rel="<?php echo $id_product;?>">-</span>
						</div>
						<input class="form-control input-sm product_amount" type="text" id="product_amount_<?php echo $id_product;?>" placeholder ="" maxlength="5" value="1" rel2="<?php echo $product['amount_decimal'];?>">
					</div>
					<input type="hidden" id="priceToUse_<?PHP echo $product['id_product'];?>" value="<?php echo $product['price'];?>"/>
					<input type="hidden" id="bruttoToUse_<?PHP echo $product['id_product'];?>" value="<?php echo $product['price']+(($product['price']*$product['vat'])/100);?>"/>

			</div>
			<?php
			}
		}
		else
		{
		echo '
				<div class="info-block padding10">
					<div class="info-box">
						<img src="'.base_url("images/icon_promo.png").'" />Brak produktów w kategorii
					</div>
				</div>
		';
		}
		
		?>
		<div class="clear"></div>
	</div>
	<br/><br/>
	<div class="center">
		<?php if(isset($pagination_links)){
		?>
		<div class="control-group" style="float:left">
			<form method="post">
				<input type="text" class="form-control"  id="site_submit_text" name="site_submit_text" value="<?php echo round(($page/$per_page)+1);?>" /> z <?php echo ($total_rows==0) ? "1" :$total_rows ;?>
			</form>
		</div>
		<?php }?>
		<?php if(isset($pagination_links)){ ?> <?php echo $pagination_links;?>
		<div class="control-group" id="per_page_box">Ilość produktów na stronie
			<select name="per_site" id="per_site" class="form-control" style="display:inline;width:auto;" rel="<?php echo base_url("categories/setPerPage/");?>">
				<?php for($i=1; $i<5; $i++)
				{ $v = $i*12; ?>
				<option value="<?php echo $v;?>" <?php if($v == $per_page) echo "selected";?>><?php echo $v;?></option>
				<?php
				}
				?>
			</select>	
		</div>
		<?php } ?>
		
		<a href="" style="display:none" class="button big-button">Wyświetl więcej</a>
	</div>
</div>

<input type="hidden" id="baseUrlToUse" value="<?php echo base_url();?>"/>

