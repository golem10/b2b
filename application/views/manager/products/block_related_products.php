<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-md-6">
		<table class="table table-striped" id="products-table11">
			<thead class="table-header">
			<tr>
				<th style="width:100px">Id</th>
				<th>Kod produktu</th>
				<th>Nazwa</th>			
				<th style="width:200px">Akcje</th>
			</tr>
			</thead>
			<tbody>
				<?php 
				$where_in_related = "";
				foreach($related_products as $k=>$v)
				{
				$where_in_related_tab[$k] = $v['id_product']; 
				?>
				<tr>
					<td><?php echo $v['id_product'];?></td>
					<td><?php echo $v['code'];?></td>
					<td><?php echo $v['name'];?></td>
					<td><button class="btn btn-default btn-sm deleteButton2" data-toggle="modal" data-target="#modalDelete1" rel="<?php echo $v['id_product'];?>"><span class="glyphicon glyphicon-trash"></span>&nbsp;Usuń</button></td>
				</tr>
				<?php
				}
				if(isset($where_in_related_tab))
				$where_in_related=implode('_',$where_in_related_tab);
				?>
			</tbody>
			
		</table>
	</div>
	
	<div class="col-md-6">
		<form method="post" action="<?php echo base_url("manager/products/setRelativeCheckbox/".$product['id_product']);?>">
			<div id="checkboxex-box" style="display:none">

			</div>
			<button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-random"></span>&nbsp;Powiąż zaznaczone</button>	
			 <p class="btn btn-primary btn-xs check" style="float:right" id="checkAllProducts_btn"><span class="glyphicon glyphicon-check"></span>&nbsp;<span class="text-btn-prod-prod">Zaznacz wszystkie widoczne</span></p>
		</form>
		<br/>
		<table class="table table-striped" id="products-table">
			<thead class="table-header">
			<tr></th>
				<th style="width:50px">Id</th>
				<th>Kod produktu</th>
				<th>Nazwa</th>			
				
			</tr>
			</thead>
			<tbody>
			
			</tbody>
		</table>
		
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalDelete1">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Usuwanie elementu 
			</div>
		</div>		
		<p class="center">Czy napewno chcesz usunąć ten element?</p>
		<form action="<?php echo base_url($path."products/delRelatedProduct/".$product['id_product']);?>" method="post" class="center">
			<input type="hidden" id="idToDel2" name="idToDel" />
			<br/>
			<button class="btn btn-danger" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Tak</button>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Nie</a>
			<br/><br/>
		</form>
		
	</div>
  </div>
</div>

<script>
$(function(){
$("#checkAllProducts_btn").click(function(){
		
		if($(this).hasClass("check"))
			{$(".to_set_checkbox").click();
			$(".text-btn-prod-prod").html("Odznacz wszystkie");
			$(this).removeClass("check");
			}
		else
			{$(".to_set_checkbox").click();
			$(".text-btn-prod-prod").html("Zaznacz wszystkie");
			$(this).addClass("check");
			}
	});
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
		 "sAjaxSource": "<?php echo base_url("manager/tabledata/allProductsForRelated/".$product['id_product']."/".$where_in_related);?>",  
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
			$(".to_set_checkbox").unbind( "click" );
				$(".to_set_checkbox").click(function(){
					val = $(this).val();
					
					if($('#checkbox_table'+val).val())
						$('#checkbox_table'+val).remove();
					else
						$("#checkboxex-box").append('<input type="checkbox" name="id_products[]" value="'+val+'" id="checkbox_table'+val+'" checked class="checked-chekboxes"/>');
				});
			$(".checked-chekboxes").each(function(){
				val = $(this).val();
				 $("#checkbox_table_tmp"+val).attr("checked","checked");
			});
			
		}	 
    });
	$('#products-table11').dataTable( {
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

