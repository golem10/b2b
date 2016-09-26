<br/>

<table class="table table-striped orders-table" id="orders-table">
	<thead class="table-header">
	<tr>
		<th>Numer zamówienia</th>
		<th>Data złożenia zamówienia</th>
		<th>Data dostawy</th>
		<th>Akcja</th>			
	</tr>
	</thead>

	<tbody>
		<?php
			foreach ($orders as $id_order=>$value)
				{
					echo "<td style='".$value['style']."'>".$value['number_subiekt']."</td>";
					echo "<td style='".$value['style']."'>".$value['date']."</td>";
					echo "<td style='".$value['style']."'>".$value['delivery_date']."</td>";
					echo '<td style="'.$value['style'].'">
						<a href="'.base_url($path.'orders/info/'.$id_order).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Zobacz</a>
						</td></tr>';

				}
		?>
	</tbody>
	
</table>

