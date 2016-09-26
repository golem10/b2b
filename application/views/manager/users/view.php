 
<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span> 
		<a href="<?php echo base_url($path."users/adduser/");?>" class="btn btn-default pull-right btn-primary"><span class="glyphicon glyphicon-plus"></span>&nbsp;Dodaj użytkownika</a>
	  </div>
	  <div class="panel-body">
		 <table class="table table-striped" id="users-table">
			<thead class="table-header">
			<tr>
				<th>Id</th>
				<th>Imie i Nazwisko</th>
				<th>login</th>
				<th class="center">Aktywny</th>
				<th>Ostatnie logowanie</th>
				<th>Akcje</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach($users as $id_user =>$user)
			{
				echo
				'<tr>
					<td>'.$id_user.'</td>
					<td>'.mb_substr($user['firstname'], 0,1).' '.$user['lastname'].'</td>
					<td>'.$user['login'].'</td>
					<td ><a href="'.base_url($path.'users/activeuser/'.$id_user).'" title="active" class="center glyphicon glyphicon-'.($user['active']==1 ? 'ok green' : 'remove red').'"></a></td>
					<td>'.$user['last_login'].'</td>
					<td>
						<a href="'.base_url($path.'users/edituser/'.$id_user).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edytuj</a>&nbsp;&nbsp;
						<button class="btn btn-default btn-sm deleteButton" data-toggle="modal" data-target="#modalDelete" rel="'.$id_user.'"><span class="glyphicon glyphicon-trash"></span>&nbsp;Usuń</button>
					</td>
				</tr>';
		
			}
			?>
			</tbody>
		</table>
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
			<form action="<?php echo base_url($path."users/deluser");?>" method="post" class="center">
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
	
</div>