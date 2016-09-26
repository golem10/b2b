<div id="main-content" style="height:300px">
	<div id="main-content">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<span class="panel-header"><?php echo $title;?></span> 
		  </div>
		  <div class="panel-body">
				<div class="col-md-3">
					<div class="panel panel-default">
						
						<div class="panel-body">
							<button  class="btn btn-primary btn-block" id="productImportButton">
								<span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Import towarów
							</button>
							<br/>
							<button  class="btn btn-primary btn-block" id="clientImportButton">
								<span class="glyphicon glyphicon-user" ></span>&nbsp;Import klientów
							</button>
							<br/>
							<button class="btn btn-primary btn-block" id="invoiceImportButton">
								<span class="glyphicon glyphicon-file" ></span>&nbsp;Import faktur / płatności
							</button>
						</div>
					</div>
					<div class="panel panel-default">				
						<div class="panel-body" id="resultBox">
							
						</div>
					</div>							
				</div>
				<div class="col-md-9">
					<div class="panel panel-default">				
						<div class="panel-body" id="">
							<table class="table table-striped" id="import_list-table">
								<thead class="table-header">
								<tr>
									<th style="width:100px">Id</th>
									<th>Data rozpoczęcia</th>
									<th>Data zakończenia</th>
									<th>Dane</th>
									<th>Typ</th>
									<th style="width:100px">Akcje</th>
								</tr>
								</thead>
								<tbody>
								
								</tbody>
							</table>
						</div>
					</div>				
				</div>
		  </div>
		</div>
	</div>	
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="loadingModal">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Import danych
				</div>
			</div>		
			<p class="center">
				Trwa import danych. Proszę czekać...<br/><br/>
				<img src="<?php echo base_url("images/preloader.gif");?>"/></p>
			<br/>
		</div>
	  </div>
</div>


<script>
$(function(){
	$("#productImportButton").click(function(){
		$('#loadingModal').modal('show');
		$("#resultBox").load("<?php echo base_url("import_products.php");?>",function(){$('#loadingModal').modal('hide');});
	});
	$("#clientImportButton").click(function(){
		$('#loadingModal').modal('show');
		$("#resultBox").load("<?php echo base_url("import_clients.php");?>",function(){$('#loadingModal').modal('hide');});
	});
	$("#invoiceImportButton").click(function(){
		$('#loadingModal').modal('show');
		$("#resultBox").load("<?php echo base_url("import_invoices.php");?>",function(){$('#loadingModal').modal('hide');});
	});
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
		 "sAjaxSource": "<?php echo base_url("manager/tabledata/import_list/");?>", 
		 "order": [[ 0, "desc" ]]		 
    });
});
</script>
