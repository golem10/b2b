<div id="index-search-block">
	<h2 class="header-h2">Wyszukiwarka produktów</h2>
	<div class="index-search-box">
		<form class="form-horizontal" role="form" action="<?php echo base_url("search");?>">
			<label class="control-label" for="manufacturerInput">Producent</label>
			<select class="form-control input-sm"  id="manufacturerInput" name="producent">
				<option value="0">- wybierz producenta -</option>
				<?php
					foreach($producers as $p){
						echo '<option value="'.$p["id_producer"].'">'.$p["name"].'</option>';
					}
				?>
			</select>
			<div class="clear separator"></div>	
			<label class="control-label" for="priceInputFrom">Cena</label>
			<div class="prices">
				<input class="form-control input-sm priceInputFrom" type="text" placeholder ="od"  id="priceInputFrom" name="priceFrom">	
				<input class="form-control input-sm priceInputTo" type="text" placeholder ="do" id="priceInputTo" name="priceTo">	
			</div>
			<div class="clear separator"></div>
			<label class="control-label" for="colorInput">Kolor</label>
			<select class="form-control input-sm"  id="colorInput" name="color">
				<option value="0">- wybierz kolor -</option>
				<?php
					foreach($colors as $c){
						echo '<option value="'.$c["id_color"].'">'.$c["name"].'</option>';
					}
				?>
			</select>
			<div class="clear"></div>					
			<label class="control-label" for="orderedBeforeInput">Zamawiane wcześniej</label>					
			<input type="checkbox" id="orderedBeforeInput" value="1" name="orderedBefore">					
			<div class="clear"></div>
			<label class="control-label" for="inFavoriteInput">Ulubione produkty</label>					
			<input type="checkbox" id="inFavoriteInput" value="1" name="inFavorite">					
			<div class="clear line"></div>
			<div class="button-line">
				<input type="submit" value="Wyświetl produkty" class="button"/>
			</div>
		</form>
	</div>
</div>