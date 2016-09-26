<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-md-5">
		<div class="panel panel-default">
		  <div class="panel-heading">
			Dostęp do produktów
		  </div>
		   <div class="panel-body">
				<table class="table table-striped" id="products-available-table">
					<thead class="table-header">
					<tr>
						<th style="width:100px">Id</th>
						<th>Nazwa</th>
						<th style="width:100px">Akcja</th>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach($available_product as $id_product =>$name)
					{
						echo
						'<tr>
							<td>'.$id_product.'</td>
							<td>'.$name.'</td>
							<td><button class="btn btn-default btn-sm deleteButton2" data-toggle="modal" data-target="#modalDelete2" rel="'.$id_product.'"><span class="glyphicon glyphicon-trash"></span>&nbsp;Usuń</button></td>
						</tr>';
				
					}
					?>
					</tbody>
				</table>
				<a href="<?php echo base_url($path."clients/addProductAvailable/0/".$client['id_client']."/".$id_user_product);?>" class="btn btn-primary btn-block">
					<span class="glyphicon glyphicon-edit"></span>&nbsp;Dostęp do produktów
				</a>
		   </div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="panel panel-default">
		  <div class="panel-heading">
			Dostęp do kategorii
		  </div>
		   <div class="panel-body">
				<?php if(count($available_category) > 0)
				{	echo "<ul class='category-list category-list-view'>";
					foreach($categories[0] as $id=>$value)
						{	if(isset($available_category[$id]))
							{
							echo "<li><a> ".$value['name']."  </a>";
								
									if(isset($categories[$id]))
									{ 
										echo "<ul>";
										
										foreach($categories[$id] as $id1=>$value1)
											{		if(isset($available_category[$id1]))																						
														echo "<li><a> ".$value1['name']." </a></li>";			
											}		
										echo "</ul>";
										}
								
							echo "</li>";
							}
						}
					echo "</ul>";
				}
				else
					echo "Brak specjalnych ustawień dostępu do kategorii.";
				?>
				<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalSetCategory">
					<span class="glyphicon glyphicon-edit"></span>&nbsp;Dostęp do kategorii
				</button>
		   </div>
		</div>
	</div>
	
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalDelete2">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Usuwanie elementu 
			</div>
		</div>		
		<p class="center">Czy napewno chcesz usunąć ten element?</p>
		<form action="<?php echo base_url($path."clients/delProdAvail/".$client['id_client']);?>" method="post" class="center">
			<input type="hidden" id="idToDel2" name="idToDel" />
			<input type="hidden" name="id_user" value="<?php echo $id_user_product;?>" />
			<br/>
			<button class="btn btn-danger" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Tak</button>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Nie</a>
			<br/><br/>
		</form>
	</div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalSetCategory">
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Wybierz dostępne kategorie
				</div>
			</div>		
			<form action="<?php echo base_url($path."clients/setClientCategoryAvailability/".$client['id_client']);?>" method="post">
				<input type="hidden" name="id_user_product" value="<?php echo $id_user_product?>" />
				<p class="btn btn-primary btn-xs check" style="margin:0px 20px 20px 20px;float:right" id="checkAllCategories_btn"><span class="glyphicon glyphicon-check"></span>&nbsp;<span class="text-btn-prod-cat">Zaznacz wszystkie</span></p>
				<ul class="category-list">
				<?php 
					foreach($categories[0] as $id=>$value)
						{	if(isset($available_category[$id]))
								$checked = "checked";
							else
								$checked ="";
							echo "<li><input type='checkbox' name='id_categories[]' value='".$id."' ".$checked." class='checkbox-category'><a class='expand-submenu' rel='".$id."'> ".$value['name']."  </a>";
								
									if(isset($categories[$id]))
									{ 
									echo "<div id='submenu-block".$id."' class='submenu-block'>";
										echo "<ul id='submenu".$id."'>";
										
										foreach($categories[$id] as $id1=>$value1)
											{		if(isset($available_category[$id1]))
														$checked = "checked";
													else
														$checked ="";										
													echo "<li><input type='checkbox' name='id_categories[]' value='".$id1."' ".$checked." class='checkbox-category checkbox-category".$id."'><a> ".$value1['name']." </a></li>";			
											}		
										echo "</ul></div>";
										}
								
							echo "</li>";
						}
					?>
				</ul>
				
				<br/>
				<p class="center"> 
					<button class="btn btn-primary" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Zapisz</button>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Anuluj</a>
				</p>
				<br/><br/>
			</form>
		</div>
	  </div>
	</div>
<script>
$(function(){
	$(".expand-submenu").click(function(){
		id = $(this).attr("rel");
		h = $("#submenu"+id).height();		
		if($(this).hasClass("collapse-submenu"))
		{
			$("#submenu-block"+id).animate({"height": 0});
				$(this).removeClass("collapse-submenu");
		}
		else
		{
			$("#submenu-block"+id).animate({"height": h});
			$(this).addClass("collapse-submenu");
		}			
	});	
	$(".deleteButton2").click(function()
	{
		if($(this).attr("rel-type")!==undefined){
			var type = $(this).attr("rel-type");
			$("#idToDel2"+type).val($(this).attr("rel"));
		} else {
			$("#idToDel2").val($(this).attr("rel"));
		}
	});	
	$(".checkbox-category").click(function(){ 
		id = $(this).attr("value");
		$(".checkbox-category"+id).click();
	});
	
	$("#checkAllCategories_btn").click(function(){
		if($(this).hasClass("check"))
			{
			$(".checkbox-category").click();
			$(".text-btn-prod-cat").html("Odznacz wszystkie");
			$(this).removeClass("check");
			}
		else
			{
			$(".checkbox-category").removeAttr("checked");
			$(".text-btn-prod-cat").html("Zaznacz wszystkie");
			$(this).addClass("check");
			}
	});
});
</script>