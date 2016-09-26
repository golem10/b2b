<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-md-9">
		<table class="table table-bordered table-hover table-striped ">
			<thead class="table-header">
			<tr>
				<th>Id</th>
				<th>Cena</th>
				
				<th style="width:280px">Akcje</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach($fixed_prices as $k=>$v)
			{
				echo
				'<tr>
					<td>'.($k+1).'</td>
					<td>'.$v.'</td>					
					<td>
						<a href="'.base_url($path.'products/clientsToFixedPrice/'.$product['id_product']."/".$v).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Podgląd</a>&nbsp;&nbsp;
						<a href="'.base_url($path.'products/fixedPrice/'.$product['id_product']."/".$v).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edytuj</a>&nbsp;&nbsp;
						<button class="btn btn-default btn-sm deleteButton" data-toggle="modal" data-target="#modalDelete" rel="'.$v.'"><span class="glyphicon glyphicon-trash"></span>&nbsp;Usuń</button>
					</td>
				</tr>';	
			}
			?>
			</tbody>
		</table>
	</div>
	<div class="col-md-1">
	</div>
	<div class="col-md-2">
		<a href="<?php echo base_url($path."products/fixedPrice/".$product['id_product']);?>" type="submit" class="btn btn-primary btn-block">
			<span class="glyphicon glyphicon-usd"></span>&nbsp;Nowa cena stała
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
		<form action="<?php echo base_url($path."products/delFixedPrice/".$product['id_product']);?>" method="post" class="center">
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

