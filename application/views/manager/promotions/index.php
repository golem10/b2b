 
<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span> 
		<a href="<?php echo base_url($path.'promotions/promotion/');?>" class="btn btn-default pull-right "><span class="glyphicon glyphicon-plus"></span>&nbsp;Dodaj promocję</a>
	  </div>
	  <div class="panel-body">
		 <table class="table table-striped" id="promotions-table">
			<thead class="table-header">
			<tr>
				<th style="width:100px">Id</th>
				<th>Nazwa</th>
				<th>Aktywny</th>
				<th style="width:200px">Akcje</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach($promotions as $id_promotion =>$promotion)
			{
				echo
				'<tr>
					<td>'.$id_promotion.'</td>
					<td>'.$promotion['name'].'</td>
					<td ><a href="'.base_url($path.'promotions/changeactive/'.$id_promotion).'" title="active" class="center glyphicon glyphicon-'.($promotion['id_status']==1 ? 'ok green' : 'remove red').'"></a></td>
					<td>
						<a href="'.base_url($path.'promotions/promotion/'.$id_promotion."/".$promotion['id_product']).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Edytuj</a>
					<button class="btn btn-default btn-sm deleteButton" data-toggle="modal" data-target="#modalDelete" rel="'.$id_promotion.'"><span class="glyphicon glyphicon-trash"></span>&nbsp;Usuń</button>
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
		<span class="panel-header">Grupy klientów</span> 
		<a href="<?php echo base_url($path.'discounts/group/');?>" class="btn btn-default pull-right "><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Dodaj grupę użytkowników</a>
	  </div>
	  <div class="panel-body">
		 <table class="table table-striped" id="discount-groups-table">
			<thead class="table-header">
			<tr>
				<th style="width:100px">Id</th>
				<th>Nazwa</th>
				<th style="width:200px">Akcje</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach($groups as $id_group =>$group)
			{
				echo
				'<tr>
					<td>'.$id_group.'</td>
					<td>'.$group['name'].'</td>
					<td>';
					//<a href="'.base_url($path.'discounts/group_view/'.$id_group).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Podgląd</a>
						echo '<a href="'.base_url($path.'discounts/group/'.$id_group).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Edytuj</a>
					</td>
				</tr>';
		
			}
			?>
			</tbody>
		</table>
	  </div>
	</div>
	
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalDelete">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Usuwanie elementu 
				</div>
			</div>		
			<p class="center">Czy napewno chcesz usunąć ten element?</p>
			<form action="<?php echo base_url($path."promotions/del");?>" method="post" class="center">
				<input type="hidden" id="idToDel" name="idToDel" />
				<br/>
				<button class="btn btn-danger" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Tak</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Nie</a>
				<br/><br/>
			</form>
		</div>
	  </div>
	</div>