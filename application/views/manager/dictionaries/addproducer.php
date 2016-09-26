<div id="main-content">

<div class="panel panel-default">
  <div class="panel-heading">
	<span class="panel-header"><?php echo $title;?></span> 
	<a href="<?php echo base_url($path."dictionaries/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
  </div>
  <div class="panel-body">
	<form class="form-horizontal w500" method="post">
		<div class="control-group">
			<label class="control-label" for="firstname">Nazwa</label>
			<div class="controls">
				<input type="text" id="name" class="form-control"  placeholder="nazwa" name="name" <?php echo (isset($post['name'])) ? 'value="'.$post['name'].'"' : 'value="'.$producer['name'].'"' ?> >
			</div>
		</div>
		<br/><br/>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary">
					<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Zapisz
				</button>
					<a href="<?php echo base_url($path."dictionaries/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>

			</div>
		</div>
	</form>
	
</div>
</div>
