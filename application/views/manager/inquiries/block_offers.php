<br/>

<table class="table table-striped orders-table">
	<thead class="table-header">
	<tr>
		<th style="width:100px">Id</th>
		<th>Nazwa</th>
		
		<th>Daty</th>
		<th>Status</th>
		<th>Akcja</th>			
	</tr>
	</thead>

	<tbody>
		<?php
			foreach ($offerts as $id_offer=>$value)
				{ if($value['id_status'] == 1)
					{  $info_text = "Do wykorzystania";
						$style="green-table-row";
					}
				 
				  elseif($value['id_status'] == 3)
					{
						$info_text = "Wykorzystano";
						$style="grey-table-row";				
					}
					echo "<tr><td class='".$style."'>".$id_offer."</td>";
					echo "<td class='".$style."'>".$value['name']."</td>";
				//	echo "<td class='".$style."'>".$value['id_client']."</td>";
					echo "<td class='".$style."'>".$value['date_from']." - ".$value['date_to']."</td>";
					echo "<td class='".$style."'>".$info_text."</td>";
					echo '<td class="'.$style.'">';
					if($value['id_status']==1) echo '<a href="'.base_url($path.'inquiries/create/0/0/0/'.$id_offer).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edytuj</a>';
					echo	'</td></tr>';

				}
		?>
	</tbody>
	
</table>

