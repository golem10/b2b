<div id="main-content">

<div class="panel panel-default">
  <div class="panel-heading">
	<span class="panel-header"><?php echo $title;?></span> 
	<a href="<?php echo base_url($path."dictionaries/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
  </div>
  <div class="panel-body">
	<form class="form-horizontal w500" method="post" style="float:left; margin-right: 15px;">
		<div class="control-group">
			<label class="control-label" for="firstname">Nazwa</label>
			<div class="controls">
				<input type="text" id="name" class="form-control"  placeholder="nazwa" name="name" <?php echo (isset($post['name'])) ? 'value="'.$post['name'].'"' : 'value="'.$category['name'].'"' ?> >
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
	<div class="control-group pull-left">
		<label class="control-label" for="img">Zdjęcie</label>
		<?php
			$file_path = './images/categories/'.$category['img'];
			if($category['img'] != "" && file_exists($file_path)){
				echo '<div class="controls"><img src="'.base_url($file_path).'" style="max-width: 100px;max-height: 100px; margin: 10px 0;" alt="Brak zdjęcia"></div>';
			}
		?>
		<div class="controls">
			<button type="submit" class="btn btn-xs btn-primary pull-left" data-toggle="modal" data-target="#modalAddImg"><span class="glyphicon glyphicon-picture"></span>&nbsp;Dodaj zdjęcie</button><br/><br/>
			<button class="btn btn-xs btn-default deleteButton1 pull-left" data-toggle="modal" data-target="#modalDelImg" rel="<?php echo $category['id_category'];?>"><span class="glyphicon glyphicon-trash" ></span>Usuń zdjęcie</button>
		</div>
	</div>
	
</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalAddImg">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Dodaj zdjęcie
				</div>
			</div>		
			<p class="center">Wybierz zdjęcie dla kategorii</p>
			<form action="?action=addImage" method="post" class="center" enctype="multipart/form-data">
				<input type="file" name="userfile" style="width:96px;margin:0 auto" />
				<br/>
				<button class="btn btn-primary" ><span class="glyphicon glyphicon-picture"></span>&nbsp;Dodaj zdjęcie</button>
				<br/><br/>
			</form>
		</div>
	  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalDelImg">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Usuwanie  
				</div>
			</div>		
			<p class="center">Czy napewno chcesz usunąć zdjęcie?</p>
			<form action="<?php echo base_url($path."dictionaries/deleteCatImage/".$id_parent."/".$id_category);?>" method="post" class="center">
				<input type="hidden" id="idToDel1" name="idToDel" value="<?php echo $id_category;?>"/>
				<br/>
				<button class="btn btn-danger" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Tak</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Nie</a>
				<br/><br/>
			</form>
		</div>
	  </div>
</div>
