<div id="main-content">

<div class="panel panel-default">
  <div class="panel-heading">
	<span class="panel-header"><?php echo $title;?></span> 
	<a href="<?php echo base_url($path."discounts/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
  </div>
  <div class="panel-body">
	<form class="form-horizontal w500" method="post">
		<div class="control-group">
			<label class="control-label" for="groupname">Nazwa grupy</label>
			<div class="controls">
				<input type="text" id="groupname" class="form-control"  placeholder="Nazwa grupy" name="name" <?php echo (isset($post['name'])) ? 'value="'.$post['name'].'"' : 'value="'.$def['name'].'"' ?> >
			</div>
		</div>
		<div class="control-group" id="client-checkbox" >
			<label class="control-label" for="client">Klienci</label>
			<div class="controls">
				<?php
					foreach($clients as $item){
						$item['checked'] ? $checked='checked' : $checked='';
						echo '<span class="client-checkbox-item"><input type="checkbox" name="clients['.$item['id_client'].']" value="'.$item['id_client'].'" '.$checked.' />';
						echo '<label class="control-label" for="groupname">'.$item['name'].'</label></span>';
					}
				?>
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
