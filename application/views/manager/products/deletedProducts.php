 
<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header">Usunięte produkty</span>
	  </div>
	  <div class="panel-body">
		 <table class="table table-striped" id="products-table">
			<thead class="table-header">
			<tr>
				<th style="width:100px">Id</th>
				<th>Kod produktu</th>
				<th>Nazwa</th>
				<th>Status</th>
				<th style="width:200px">Akcje</th>
			</tr>
			</thead>
			<tbody>
			
			</tbody>
		</table>
	  </div>
	</div>
	
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalDelete">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Przywracenie elementu 
				</div>
			</div>		
			<p class="center">Czy napewno chcesz przywrócić ten produkt?</p>
			<form action="<?php echo base_url($path."products/returnProduct/");?>" method="post" class="center">
				<input type="hidden" id="idToDel" name="idToDel" />
				<br/>
				<button class="btn btn-primary" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Tak</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Nie</a>
				<br/><br/>
			</form>
		</div>
	  </div>
</div>
<script>
$(function(){
$('#products-table').dataTable( {
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
		 "sAjaxSource": "<?php echo base_url("manager/tabledata/products_deleted/");?>", 
		"fnDrawCallback":function(){
			$(".deleteButton").click(function()
			{
				if($(this).attr("rel-type")!==undefined){
					var type = $(this).attr("rel-type");
					$("#idToDel"+type).val($(this).attr("rel"));
				} else {
					$("#idToDel").val($(this).attr("rel"));
				}
			});
		}	
    });
});
</script>