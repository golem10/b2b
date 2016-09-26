<div id="main-content">

<div class="panel panel-default">
  <div class="panel-heading">
	<span class="panel-header"><?php echo $title;?></span> 
	<a href="<?php echo base_url($path."articles/?action=traders");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
  </div>
  <div class="panel-body">
	<form class="form-horizontal w700" method="post">
		<div class="control-group">
			<label class="control-label" for="name">Nazwa</label>
			<div class="controls">
				<input type="text" id="name" class="form-control"  placeholder="Nazwa" name="name" <?php echo (isset($post['name'])) ? 'value="'.$post['name'].'"' : 'value="'.$trader['name'].'"' ?> >
			</div>
			<label class="control-label" for="phone">Numer telefonu</label>
			<div class="controls">
				<input type="text" id="phone" class="form-control"  placeholder="Numer telefonu" name="phone" <?php echo (isset($post['phone'])) ? 'value="'.$post['phone'].'"' : 'value="'.$trader['phone'].'"' ?> >
			</div>
			<label class="control-label" for="email">Adres email</label>
			<div class="controls">
				<input type="text" id="email" class="form-control"  placeholder="Adres e-mail" name="email" <?php echo (isset($post['email'])) ? 'value="'.$post['email'].'"' : 'value="'.$trader['email'].'"' ?> >
			</div>
		</div>
		<br/>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary">
					<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Zapisz
				</button>
					<a href="<?php echo base_url($path."articles/?action=traders");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>

			</div>
		</div>
	</form>
	
</div>
</div>

<script>
	CKEDITOR.replace( 'text' );
</script>