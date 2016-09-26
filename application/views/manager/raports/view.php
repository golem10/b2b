 
<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span> 
	  </div>
	  <div class="panel-body">
		 <table class="table table-striped" id="raport-table">
			<thead class="table-header">
			<tr>
				<th style="width:100px">Id</th>
				<th>Klient</th>
				<th>Produkt</th>
				<th>Cena jedn. netto</th>
				<th>Ilość</th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			</tfoot>
			<tbody>
			<?php
			foreach($raport_positions as $id_position =>$position)
			{
				echo
				'<tr>
					<td>'.$id_position.'</td>
					<td>'.$position['client'].'</td>
					<td>'.$position['product_name'].'</td>
					<td>'.$position['price'].' zł</td>
					<td>'.$position['amount'].'</td>
				</tr>';
		
			}
			?>
			</tbody>
		</table>
	  </div>
	</div>
	
</div>