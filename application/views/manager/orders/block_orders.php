<br/>

<table class="table table-striped orders-table" id="orders-table">
	<thead class="table-header">
	<tr>
		<th style="width:100px">Id</th>
		<th>Numer zamówienia</th>
		<th>Data złożenia zamówienia</th>
		<th>Data dostawy</th>
		<th>Użytkownik akceptujący</th>	
		<th>Status</th>
		<th>Akcja</th>			
	</tr>
	</thead>

	<tbody>
		<?php
			foreach ($orders as $id_order=>$value)
				{
					echo "<tr><td style='".$value['style']."'>".$id_order."</td>";
					echo "<td style='".$value['style']."'>".$value['number_subiekt']."</td>";
					echo "<td style='".$value['style']."'>".$value['date']."</td>";
					echo "<td style='".$value['style']."'>".$value['delivery_date']."</td>";
					echo "<td style='".$value['style']."'>".mb_substr($value['firstname'], 0,1).' '.$value['lastname']."</td>";
					echo "<td style='".$value['style']."'>".$value['s_name']."</td>";
					echo '<td style="'.$value['style'].'">
						<a href="'.base_url($path.'orders/info/'.$id_order).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Zobacz</a>
						</td></tr>';

				}
		?>
	</tbody>
	
</table>

