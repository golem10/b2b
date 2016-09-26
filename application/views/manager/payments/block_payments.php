<br/>
<style>
.alert-success{background-color:#dff0d8 !important}
.alert-danger{background-color:#f2dede !important}

</style>
<table class="table orders-table">
	<thead class="table-header">
	<tr>
		<th>Nr faktury</th>
		<th>Data złożenia zamówienia</th>
		<th>Data wystawienia</th>
		<th>Termin płatności</th>
		<th>Wartość</th>
		<th>Status</th>	
		<th>Akcja</th>			
	</tr>
	</thead>

	<tbody>
		<?php
			foreach ($payments as $id_payment=>$payment)
				{	
					if($payment['id_status'] == 2 || $payment['paid'] == $payment['amount'])
					{ $status = "Zapłacono";
						$class="alert alert-success";
					}
					else
					{
						$class="alert alert-danger";
						$status = "Niezapłacono";
					}
					echo "<tr class='".$class."'>";
					echo "<td >".$payment['facture_code']."</td>";
					echo "<td>".$payment['order_date']."</td>";
					echo "<td>".$payment['date']."</td>";
					echo "<td>".$payment['deadline']."</td>";
					echo "<td>".$payment['amount']." zł</td>";
					echo "<td>".$status."</td>";
					echo '<td><a href="'.base_url('uploads/factures/'.$payment['facture_url']).'" class="btn btn-default btn-sm" target="_blank"><span class="glyphicon glyphicon-file"></span>&nbsp;Pobierz fakturę PDF</a>
						</td></tr>';

				}
		?>
	</tbody>
	
</table>

