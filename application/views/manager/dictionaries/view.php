<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span> 
		<a href="<?php echo base_url($path.'dictionaries/category/'.$id_cat.'/0'); ?>" class="btn btn-default pull-right btn-primary" style="margin:0 3px;"><span class="glyphicon glyphicon-plus"></span>&nbsp;Dodaj kategorię</a>
		<a href="<?php echo base_url($path.'dictionaries/index/'.$category['id_parent']);?>" class="btn btn-default pull-right " style="margin:0 3px;"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
	  </div>
	  <div class="panel-body">
		 <table class="table table-striped" id="categories-table">
			<thead class="table-header">
			<tr>
				<th style="width:100px">Id</th>
				<th>Nazwa</th>
				<th style="width:250px">Akcje</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach($categories as $id_category =>$category)
			{
				echo
				'<tr>
					<td>'.$id_category.'</td>
					<td>'.$category['name'].'</td>
					<td>';
						if(!$category['id_parent']) echo '<a href="'.base_url($path.'dictionaries/index/'.$id_category).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Podkategorie</a>&nbsp;&nbsp;';
						echo '<a href="'.base_url($path.'dictionaries/category/'.$id_cat.'/'.$id_category).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edytuj</a>
							 <button class="btn btn-default btn-sm deleteButton" data-toggle="modal" data-target="#modalDeleteCategory" rel-type="Category" rel="'.$id_category.'"><span class="glyphicon glyphicon-trash"></span>&nbsp;Usuń</button>
					</td>
				</tr>';
		
			}
			?>
			</tbody>
		</table>
	  </div>
	</div>
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header">Producenci</span>
		<a href="<?php echo base_url($path.'dictionaries/producer/'); ?>" class="btn btn-default pull-right btn-primary" style="margin:0 3px;"><span class="glyphicon glyphicon-plus"></span>&nbsp;Dodaj producenta</a>
	  </div>
	  <div class="panel-body">
		 <table class="table table-striped" id="producers-table">
			<thead class="table-header">
			<tr>
				<th style="width:100px">Id</th>
				<th>Nazwa</th>
				<th style="width:160px">Akcje</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach($producers as $id_producer =>$producer)
			{
				echo
				'<tr>
					<td>'.$id_producer.'</td>
					<td>'.$producer['name'].'</td>
					<td>
						<a href="'.base_url($path.'dictionaries/producer/'.$id_producer).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edytuj</a>
						<button class="btn btn-default btn-sm deleteButton" data-toggle="modal" data-target="#modalDeleteProducer" rel-type="Producer" rel="'.$id_producer.'"><span class="glyphicon glyphicon-trash"></span>&nbsp;Usuń</button>
					</td>
				</tr>';
		
			}
			?>
			</tbody>
		</table>
	  </div>
	</div>
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header">Kolory</span>
		<a href="<?php echo base_url($path.'dictionaries/color/'); ?>" class="btn btn-default pull-right btn-primary" style="margin:0 3px;"><span class="glyphicon glyphicon-plus"></span>&nbsp;Dodaj kolor</a>
	  </div>
	  <div class="panel-body">
		 <table class="table table-striped" id="colors-table">
			<thead class="table-header">
			<tr>
				<th style="width:100px">Id</th>
				<th>Nazwa</th>
				<th style="width:160px">Akcje</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach($colors as $id_color =>$color)
			{
				echo
				'<tr>
					<td>'.$id_color.'</td>
					<td>'.$color['name'].'</td>
					<td>
						<a href="'.base_url($path.'dictionaries/color/'.$id_color).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edytuj</a>
						<button class="btn btn-default btn-sm deleteButton" data-toggle="modal" data-target="#modalDeleteColor" rel-type="Color" rel="'.$id_color.'"><span class="glyphicon glyphicon-trash"></span>&nbsp;Usuń</button>
					</td>
				</tr>';
		
			}
			?>
			</tbody>
		</table>
	  </div>
	</div>
	
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalDeleteCategory">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Usuwanie kategorii
				</div>
			</div>		
			<p class="center">Czy napewno chcesz usunąć ten element?</p>
			<form action="<?php echo base_url($path."dictionaries/delCategory");?>" method="post" class="center">
				<input type="hidden" id="idToDelCategory" name="idToDelCategory" />
				<br/>
				<button class="btn btn-danger" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Tak</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Nie</a>
				<br/><br/>
			</form>
		</div>
	  </div>
	</div>
	
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalDeleteProducer">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Usuwanie producenta
				</div>
			</div>		
			<p class="center">Czy napewno chcesz usunąć ten element?</p>
			<form action="<?php echo base_url($path."dictionaries/delProducer");?>" method="post" class="center">
				<input type="hidden" id="idToDelProducer" name="idToDelProducer" />
				<br/>
				<button class="btn btn-danger" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Tak</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Nie</a>
				<br/><br/>
			</form>
		</div>
	  </div>
	</div>
	
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalDeleteColor">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Usuwanie koloru
				</div>
			</div>		
			<p class="center">Czy napewno chcesz usunąć ten element?</p>
			<form action="<?php echo base_url($path."dictionaries/delColor");?>" method="post" class="center">
				<input type="hidden" id="idToDelColor" name="idToDelColor" />
				<br/>
				<button class="btn btn-danger" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Tak</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Nie</a>
				<br/><br/>
			</form>
		</div>
	  </div>
	</div>
	
</div>