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
							<?php if($source != 3) 
							{?>
							<table class="table table-striped" id="import_list-table">
								<thead class="table-header">
								<?php if($source == 1) {?>
								<tr>
									<th>Symbol</th>
									<th>Nazwa</th>
									<th>NIP</th>
									<th>Ulica</th>
									<th>Miasto</th>
									<th>Email</th>
									<th>Akcje</th>
								</tr>								
								<?php
								}
								elseif($source == 2)
								{
								?>
								<tr>
									<th>Kod</th>
									<th>Nazwa</th>
									<th>Opis</th>
									<th>Cena</th>
									<th>VAT</th>
									<th>Akcje</th>
								</tr>	
								<?php
								}								
								?>
								</thead>
								<tbody>
									
								</tbody>
							</table>
							<?php
							}else
							{
							?>
							<div class="col-md-4">
								<h4>Faktury</h4>
								<table class="table table-striped" id="invoices-table">
									<thead class="table-header">
									<tr>
										<th>Nr faktury</th>	
										<th>Plik dokumentu</th>	
									</tr>								
									
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
							<div class="col-md-4">
								<h4>Korekty</h4>
								<table class="table table-striped" id="corrections-table">
									<thead class="table-header">
									<tr>
										<th>Nr korekty</th>	
										<th>Plik dokumentu</th>	
									</tr>								
									
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
							<h4>Płatności</h4>
							<div class="col-md-4">
								<table class="table table-striped" id="payments-table">
									<thead class="table-header">
									<tr>
										<th>Nr faktury</th>		
										<th>Kwota</th>											
									</tr>								
									
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
							<?php
							}?>
						</div>
					</div>				
				</div>
		  </div>
		</div>
	</div>	
</div>




<script>

$(function(){
<?php if($source != 3) 
{?>	
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
        },
		"bProcessing": true,
		 "bServerSide": true,
		 <?php if($source == 1) 
		 {?>
		 "sAjaxSource": "<?php echo base_url("manager/tabledata/import_clients/".$id_import);?>"
		<?php
		}
		elseif($source == 2)
		{
		?>
		"sAjaxSource": "<?php echo base_url("manager/tabledata/import_products/".$id_import);?>"
		<?php
		}
		?>
    });
	<?php }
	else {
	?>
	$('#invoices-table').dataTable( {
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
        },
		"bProcessing": true,
		 "bServerSide": true,
		"sAjaxSource": "<?php echo base_url("manager/tabledata/import_invoices/".$id_import);?>"
	});
	$('#corrections-table').dataTable( {
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
        },
		"bProcessing": true,
		 "bServerSide": true,
		"sAjaxSource": "<?php echo base_url("manager/tabledata/import_corrections/".$id_import);?>"
	});
	$('#payments-table').dataTable( {
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
        },
		"bProcessing": true,
		 "bServerSide": true,
		"sAjaxSource": "<?php echo base_url("manager/tabledata/import_payments/".$id_import);?>"
	});
	<?php
	}
	?>
});

</script>
