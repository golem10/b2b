<br/>

<table class="table table-striped orders-table">
	<thead class="table-header">
	<tr>
		<th style="width:100px">Id</th>
		<th>Data złożenia zapytania</th>
		<th>Data odpowiedzi</th>
		<th>Status</th>
		<th>Akcja</th>			
	</tr>
	</thead>

	<tbody>
		<?php
			foreach ($inquiries as $id_inquiry=>$value)
				{ if($value['id_status'] == 1)
					{  $info_text = "Oczekwianie na odpowiedź";
						$style="green-table-row";
					}
				  elseif($value['id_status'] == 2)
					{
						$info_text = "Odpowiedziano";
						$style="yellow-table-row";
					}
				  elseif($value['id_status'] == 3)
					{
						$info_text = "Wykorzystano";
						$style="grey-table-row";				
					}
					echo "<tr><td class='".$style."'>".$id_inquiry."</td>";
					echo "<td class='".$style."'>".$value['date']."</td>";
					echo "<td class='".$style."'>".$value['date_respond']."</td>";
					echo "<td class='".$style."'>".$info_text."</td>";
					echo '<td class="'.$style.'">';
					if($value['id_status']==1) echo '<a href="'.base_url($path.'inquiries/info/'.$id_inquiry).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Odpowiedz</a>';
					echo	'</td></tr>';

				}
		?>
	</tbody>
	
</table>

