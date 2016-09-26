<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-md-5">
		<div class="panel panel-default">
		  <div class="panel-heading">Wybierz użytkownika
		  </div>
		   <div class="panel-body">
				<table class="table table-striped" id="products-available-table">
					<thead class="table-header">
					<tr>
						<th style="width:100px">Id</th>
						<th>Użytkownik</th>
						<th style="width:100px">Akcja</th>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach($users_accept as $id_user =>$v)
					{
						echo
						'<tr>
							<td>'.$id_user.'</td>
							<td>'.$v['firstname'].' '.$v['lastname'].'</td>
							<td><a href="?id_user='.$id_user.'&action=products"class="btn btn-default btn-sm" data-toggle="modal""><span class="glyphicon glyphicon-pencil"></span>&nbsp;Wybierz</a></td>
						</tr>';
				
					}
					foreach($users_introductory as $id_user =>$v)
					{
						echo
						'<tr>
							<td>'.$id_user.'</td>
							<td>'.$v['firstname'].' '.$v['lastname'].'</td>
							<td><a href="?id_user='.$id_user.'&action=products"class="btn btn-default btn-sm" data-toggle="modal""><span class="glyphicon glyphicon-pencil"></span>&nbsp;Wybierz</a></td>
						</tr>';
				
					}
					?>
					
					</tbody>
				</table>
				
		   </div>
		</div>
	</div>
	
</div>