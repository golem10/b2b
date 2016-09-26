<div id="main-content">

<div class="panel panel-default">
  <div class="panel-heading">
	<span class="panel-header"><?php echo $title;?></span> 
	<a href="<?php echo base_url($path."discounts/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
  </div>
  <div class="panel-body">
	<form class="form-horizontal w500" method="post">
		<div class="control-group">
			<label class="control-label" for="discountname">Nazwa rabatu</label>
			<div class="controls">
				<input type="text" id="discountname" class="form-control"  placeholder="Nazwa rabatu" name="name" <?php echo (isset($post['name'])) ? 'value="'.$post['name'].'"' : 'value="'.$def['name'].'"' ?> >
			</div>
		</div>
		<div class="control-group" id="category-select" >
			<label class="control-label" for="category">Kategoria</label>
			<div class="controls">
				<select name="id_category" class="form-control" style="display:inline;width:auto">
					<?php
					echo "<option value='0'";
					echo ">-- Wybierz kategorię --</option>";
					foreach($categories[0] as $id_category =>$category)
					{
						echo "<option value='".$id_category."'";
						echo (isset($def['id_category']) && $def['id_category']==$id_category) ? 'selected="selected"' : '';
						echo ">".$category['name']."</option>";
						if(isset($categories[$id_category]))
						foreach($categories[$id_category] as $id_category1 =>$category1)
							{
							echo "<option value='".$id_category1."'";
							echo (isset($def['id_category']) && $def['id_category']==$id_category1) ? 'selected="selected"' : '';
							echo ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$category1['name']."</option>";
							}
					}
					?>
				</select>
			</div>
			
		</div>
		<label class="control-label" for="description">Opis</label>
				<div class="controls">
					<textarea id="description" class="form-control"  placeholder="Opis" name="description" ><?php echo (isset($post['description'])) ? $post['description'] : $def['description']; ?> </textarea>
		</div>
		<div class="control-group" id="group-checkbox" >
			<label class="control-label" for="group">Grupy</label>
			<div class="controls">
				<?php
					foreach($groups as $item){
						$item['checked'] ? $checked='checked' : $checked='';
						echo '<span class="group-checkbox-item"><input type="checkbox" name="groups['.$item['id_group'].']" value="'.$item['id_group'].'" '.$checked.' />';
						echo '<label class="control-label" for="groupname">'.$item['name'].'</label></span>';
					}
				?>
			</div>
		</div>
		<div class="control-group" id="category-select" >
			<label class="control-label" for="category">Pozycje</label>
			<div class="controls">
				<div id="discount-positions">
				Liczba sztuk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Rabat
				<?php
					foreach($positions as $p){
						echo '<div class="discount-position-div" lp="'.$p['id_position'].'">
							<input type="text" class="form-control"  placeholder="Liczba sztuk" name="positions['.$p['id_position'].'][amount]" value='.$p['amount'].' >
							<input type="text" class="form-control"  placeholder="Rabat" name="positions['.$p['id_position'].'][discount]" value='.$p['discount'].'>
							<div class="btn btn-default discount-position-del" rel="'.$p['id_position'].'"><span class="glyphicon glyphicon-trash" ></span>&nbsp;Usuń</div>
						</div>';
					}
				?>
				</div>
				<a href="#" class="btn btn-default pull-right btn-default" id="new-discount-position"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Dodaj kolejny poziom rabatu</a>
			</div>
		</div>
		<br/><br/>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary">
					<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Zapisz
				</button>
					<a href="<?php echo base_url($path."discounts/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>

			</div>
		</div>
	</form>
	
</div>
</div>


<script>
	CKEDITOR.replace( 'description' );
</script>
