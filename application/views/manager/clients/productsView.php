 
<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span> 
		<a href="<?php echo base_url($path.'clients/view/'.$id_client."?action=products");?>" class="btn btn-default pull-right "><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
	  </div>
	  <div class="panel-body">
		 <table class="table table-striped" id="categories-table">
			<thead class="table-header">
			<tr>
				<th style="width:100px">Id</th>
				<th>Nazwa</th>
				<th style="width:100px">Akcje</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach($categories as $id_category =>$category)
			{
				echo
				'<tr>
					<td>'.$id_category.'</td>
					<td>'.$category['name'].'</td>
					<td>
						<a href="'.base_url($path.'clients/addProductAvailable/'.$id_category."/".$id_client."/".$id_user_product).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Rozwiń i zobacz produkty</a>
					</td>
				</tr>';
		
			}
			?>
			</tbody>
		</table>
	  </div>
	</div>
	<form method="post">
	<?php 	echo '<input type="hidden" name="id_user_product" value="'.$id_user_product.'" />';?>
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header">Produkty</span>
	  </div>
	  <div class="panel-body">
		 <p class="btn btn-primary btn-xs check" style="margin:0px 20px 20px 20px;float:right" id="checkAllProducts_btn"><span class="glyphicon glyphicon-check"></span>&nbsp;<span class="text-btn-prod-prod">Zaznacz wszystkie widoczne</span></p>
		 <table class="table table-striped" id="products-table-available">
			<thead class="table-header">
			<tr>
				<th style="width:100px">Id</th>
				<th>Nazwa</th>
			</tr>
			</thead>
			<tbody>
			<?php
		
			foreach($products as $id_product =>$product)
			{		
				if(isset($available_product[$id_product]))
					$checked = "checked";
				else
					$checked ="";
				echo
				"<tr>
					<td><input type='checkbox' name='id_products_temp[]' value='".$id_product."' ".$checked." class='checkbox_prod to_set_checkbox'></td>";
				echo'
					<td>'.$product['name'].'</td>
				</tr>';
		
			}
			?>
			</tbody>
		</table>
	  </div>
	</div>
	<button class="btn btn-primary btn-block">
		<span class="glyphicon glyphicon-edit"></span>&nbsp;Zapisz
	</button>
	<div id="checkboxex-box" style="display:none">
				<?php
							foreach($products as $id_product =>$product)
							{	if(isset($available_product[$id_product]))
									echo "<input type='checkbox' name='id_products[]'  id='checkbox_table".$id_product."'	 value='".$id_product."' checked class='checkbox_prod'>";	
								
							}
							?>
						
				</div>
				
	</form>
	<br/><br/>
	
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
$('#products-table-available').dataTable( {
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
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"fnDrawCallback":function(){
			$( ".to_set_checkbox").unbind( "click" );
			$(".to_set_checkbox").click(function(){
				val = $(this).val();
				if($('#checkbox_table'+val).val())
					$('#checkbox_table'+val).remove();
				else
					$("#checkboxex-box").append('<input type="checkbox" name="id_products[]" value="'+val+'" id="checkbox_table'+val+'" checked/>');
			});
		}
       
    });
});
</script>