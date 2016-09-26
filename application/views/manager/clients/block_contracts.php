<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-md-5">
		<div class="panel panel-default">
			<div class="panel-heading">
				Obowiązujące
			</div>
			<div class="panel-body">	
				<table class="table table-striped" id="availability-users-table">
					<thead class="table-header">
					<tr>
						<th style="width:100px">Id</th>
						<th>Nazwa</th>
						<th>Data</th>
						<th style="width:200px">Akcje</th>							
					</tr>
					</thead>
					<tbody>
						<?php
							foreach ($contracts_available as $id_contract=>$value)
								{
									echo "<tr><td>".$id_contract."</td>";
									echo "<td>".$value['name']."</td>";
									echo "<td>".$value['date_availability']."</td>";
									echo '<td><a href="'.base_url($path.'clients/newContract/'.$client['id_client']."/0/0/".$id_contract).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Podgląd</a>
									<button  class="btn btn-default btn-sm deleteButton" data-toggle="modal" data-target="#modalDelete" rel="'.$id_contract.'"><span class="glyphicon glyphicon-trash" ></span>&nbsp;Usuń</button>
									</td></tr>';
								}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-5" >
		<div class="panel panel-default">
			<div class="panel-heading">
				Wygasłe 
			</div>
			<div class="panel-body">
				<table class="table table-striped" id="availability-users-table">
					<thead class="table-header">
					<tr>
						<th style="width:100px">Id</th>
						<th>Nazwa</th>
						<th>Data</th>
						<th style="width:200px">Akcje</th>
					</tr>
					</thead>
					<tbody>
						<?php
							foreach ($contracts_expired as $id_contract=>$value)
								{	
									echo "<tr><td >".$id_contract."</td>";
									echo "<td>".$value['name']."</td>";
									echo "<td>".$value['date_availability']."</td>";
									echo '<td><a href="'.base_url($path.'clients/newContract/'.$client['id_client']."/0/0/".$id_contract).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Podgląd</a>
									<button  class="btn btn-default btn-sm deleteButton" data-toggle="modal" data-target="#modalDelete" rel="'.$id_contract.'"><span class="glyphicon glyphicon-trash" ></span>&nbsp;Usuń</button></td></tr>';

								}
						?>
					</tbody>
				</table>			
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<a href="<?php echo base_url($path."clients/newContract/".$client['id_client']);?>" class="btn btn-primary btn-block">
			<span class="glyphicon glyphicon-edit"></span>&nbsp;Nowy kontrakt
		</a>
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
		<form action="<?php echo base_url("manager/clients/deleteContract/".$client['id_client']);?>" method="post" class="center">
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