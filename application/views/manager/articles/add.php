<div id="main-content">

<div class="panel panel-default">
  <div class="panel-heading">
	<span class="panel-header"><?php echo $title;?></span> 
	<a href="<?php echo base_url($path."articles/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
  </div>
  <div class="panel-body">
	<form class="form-horizontal w700" method="post">
		<div class="control-group">
			<label class="control-label" for="title">Tytuł</label>
			<div class="controls">
				<input type="text" id="title" class="form-control"  placeholder="Tytuł" name="title" <?php echo (isset($post['title'])) ? 'value="'.$post['title'].'"' : '' ?> >
			</div>
			<label class="control-label" for="text">Treść</label>
			<div class="controls">
				<textarea id="title" class="form-control"  placeholder="Treść" name="text" ><?php echo (isset($post['title'])) ? $post['title'] : ''; ?> </textarea>
			</div>
		</div>
		<br/>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary">
					<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Zapisz
				</button>
					<a href="<?php echo base_url($path."articles/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>

			</div>
		</div>
	</form>
	
</div>
</div>

<script>
		CKEDITOR.replace( 'text',{
  "filebrowserImageUploadUrl": "<?php echo base_url("/js/ckeditor/plugins/imgupload/imgupload.php");?>",
  'extraPlugins': 'imgbrowse',
  'filebrowserImageBrowseUrl': '<?php echo base_url("/js/ckeditor/plugins/imgbrowse/imgbrowse.html");?>'
} );
</script>