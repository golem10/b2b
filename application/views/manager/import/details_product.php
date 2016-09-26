<div id="main-content" style="height:300px">
	<div id="main-content">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<span class="panel-header"><?php echo $title;?></span> 
		  </div>
		  <div class="panel-body">
				
				<div class="col-md-12">
					<div class="panel panel-default">				
						<div class="panel-body" id="">
							<table class="table table-striped" id="import_list-table">
								<thead class="table-header">
								<?php if($source == 2) {?>
								<tr>
									<th>Symbol</th>
									<th>Nazwa</th>
									<th>NIP</th>
									<th>Ulica</th>
									<th>Miasto</th>
									<th>Email</th>
									<th>Data</th>
								</tr>								
								<?php
								}
								elseif($source == 1)
								{
								?>
								<tr>
									<th>Kod</th>
									<th>Nazwa</th>
									<th>Opis</th>
									<th>Cena</th>
									<th>VAT</th>
									<th>Data</th>
								</tr>	
								<?php
								}								
								?>								
								</thead>
								<tbody>
								<?php
								 if($source == 2) {
									foreach ($pos as $id=>$value)
										{
											echo "<tr><td>".$value['symbol']."</td>";
											echo "<td>".$value['name']."</td>";
											echo "<td>".$value['nip']."</td>";
											echo "<td>".$value['street']."</td>";
											echo "<td>".$value['city']."</td>";
											echo "<td>".$value['email']."</td>";
											echo "<td>".$value['date']."</td>";
											echo '</tr>';

										}							
								
								}
								elseif($source == 1)
								{
								
									foreach ($pos as $id=>$value)
										{
											echo "<tr><td>".$value['code']."</td>";
											echo "<td>".$value['name']."</td>";
											echo "<td>".$value['description']."</td>";
											echo "<td>".$value['price']."</td>";
											echo "<td>".$value['vat']."</td>";
											echo "<td>".$value['date']."</td>";
											echo '</tr>';

										}
								
								}								
								?>
								
								</tbody>
							</table>
						</div>
					</div>				
				</div>
		  </div>
		</div>
	</div>	
</div>




<script>
$(function(){
	
	$('#import_list-table').dataTable( {
		stateSave: true,
		 "language": {
            "lengthMenu": "_MENU_ pozycji na stronę",
            "zeroRecords": "Brak znalezionych pozycji",
            "info": "Strona _PAGE_ z _PAGES_",
            "infoEmpty": "Brak pozycji",
            "infoFiltered": "(z _MAX_ pozycji)",
			"search": "Szukaj",
			"paginate": {
				"first":    "Pierwsza",
				"previous": "Poprzednia",
				"next":     "Następna",
				"last":     "Ostatnia"
			}			
        }
    });
	
});
</script>
