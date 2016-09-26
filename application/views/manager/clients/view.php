 
<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span> 
	  </div>
	  <div class="panel-body">
		 <table class="table table-striped" id="clients-list-table">
			<thead class="table-header">
			<tr>
				<th style="width:100px">Id</th>
				<th>Nazwa</th>
				<th style="width:100px">Akcje</th>
			</tr>
			</thead>
			<tbody>
			<?php
			// foreach($clients as $id_client =>$client)
			// {
				// echo
				// '<tr>
					// <td>'.$id_client.'</td>
					// <td>'.$client['name'].'</td>
					// <td>
						// <a href="'.base_url($path.'clients/view/'.$id_client).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Zobacz</a>
					// </td>
				// </tr>';
		
			// }
			?>
			</tbody>
		</table>
	  </div>
	</div>
	
</div>
<script>
$(function(){
	$('#clients-list-table').dataTable( {
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
		 "sAjaxSource": "<?php echo base_url("manager/tabledata/clients/");?>",      
    });
});
</script>