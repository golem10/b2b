
<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?><?php if (isset($contract['name'])) echo ($contract['name'] != "") ? " => ".$contract['name'] : "";?></span> 
		<a href="<?php echo base_url($path."clients/view/".$client['id_client']."?action=contracts");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
	  </div>
	  <div class="panel-body">
		  <div class="col-md-6" >
			<div class="panel panel-default">
			  <div class="panel-heading">
				Produkty przypisane do kontraktu
			  </div>
			  <div class="panel-body">
				 <table class="table table-striped" id="products-contract-table">
					<thead class="table-header">
					<tr>
						<th style="width:100px">Id</th>
						<th>Nazwa</th>
						<th>Ilość</th>
						<th>Pozostało</th>
						<th>Cena</th>
						<th style="width:150px">Akcje</th>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach($contract_products as $id_product =>$product)
					{
						echo
						'<tr>
							<td>'.$id_product.'</td>
							<td>'.$product['name'].'</td>
							<td id="amount'.$id_product.'">'.$product['amount'].'</td>
							<td id="amount_left'.$id_product.'">'.$product['amount_left'].'</td>
							<td id="price'.$id_product.'">'.$product['price'].'</td>
							<td><button class="btn btn-default btn-sm editButton"  data-toggle="modal" data-target="#modalEditProduct" rel="'.$id_product.'"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edytuj</button>&nbsp;&nbsp;
								<button class="btn btn-default btn-sm deleteButton" data-toggle="modal" data-target="#modalDelProduct" rel="'.$id_product.'"><span class="glyphicon glyphicon-trash"></span>&nbsp;Usuń</button>
							</td>
						</tr>';
				
					}
					?>
					</tbody>
				</table>
				<?php if(count($contract_products) > 0)
					{
					?>
					<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalSave">
						<span class="glyphicon glyphicon-floppy-save"></span>&nbsp;Zapisz kontrakt
					</button>
					<?php
					}
					?>
			  </div>
			</div>
		  </div>
		  <div class="col-md-6" >
			  <div class="panel panel-default">
				<div class="panel-heading">
					Kategorie
					<?php if(isset($category['id_parent']) && $category['id_category']!=0 ) {?>
					<a href="<?php echo base_url($path.'clients/newContract/'.$client['id_client'].'/0/'.$category['id_parent'].'/'.$id_contract);?>" class="btn btn-default pull-right "><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
					<?php }?>
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
									<a href="'.base_url($path.'clients/newContract/'.$client['id_client']."/0/".$id_category."/".$id_contract).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Wybierz</a>
								</td>
							</tr>';
					
						}
						?>
						</tbody>
					</table>
				</div>
			  </div>
			  <div class="panel panel-default">
			  <div class="panel-heading">
				Produkty
			  </div>
			  <div class="panel-body">
				 <table class="table table-striped" id="products-contracts-table">
					<thead class="table-header">
					<tr>
						<th style="width:100px">Id</th>
						<th>Kod</th>
						<th>Nazwa</th>
						<th>Cena</th>
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

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalEditProduct">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Edytuj produkt
			</div>
		</div>		
		<form action="<?php echo base_url($path."clients/editContractProduct/".$client['id_client']."/0/0/".$id_contract);?>" method="post">
			<input type="hidden" id="id_producte" name="id_product" />
			  <div class="form-group">
				<label for="amounte" class="col-sm-2 control-label">Ilość</label>
				<div class="col-sm-12">
				  <input type="text" class="form-control" id="amounte" name="amount" placeholder="0">
				</div>
			  </div><br clear="all"/><br clear="all"/>
			   <div class="form-group">
				<label for="amounte" class="col-sm-2 control-label">Pozostało</label>
				<div class="col-sm-12">
				  <input type="text" class="form-control" id="amountle" name="amount_left" placeholder="0">
				</div>
			  </div><br clear="all"/><br clear="all"/>
			  <div class="form-group">
				<label for="pricee" class="col-sm-2 control-label">Cena</label>
				<div class="col-sm-12">
				  <input type="text" class="form-control" id="pricee" name="price"  placeholder="0.00">
				</div>
			  </div>
			<br clear="all"/><br clear="all"/>
			<div class="center">
				<button class="btn btn-primary" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Zapisz</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Anuluj</a>
			</div>
			<br/><br/>
		</form>
	</div>
  </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalAddProduct">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Dodaj produkt do kontraktu
			</div>
		</div>		
		<form action="<?php echo base_url($path."clients/newContract/".$client['id_client']."/0/0/".$id_contract);?>" method="post">
			<input type="hidden" id="id_product" name="id_product" />
			  <div class="form-group">
				<label for="amount" class="col-sm-2 control-label">Ustal ilość</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="amount" name="amount" placeholder="0">
				</div>
			  </div><br clear="all"/>
			  <div class="form-group">
				<label for="price" class="col-sm-2 control-label">Ustal cenę</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="price" name="price"  placeholder="0.00">
				</div>
			  </div>
			<br clear="all"/><br clear="all"/>
			<div class="center">
				<button class="btn btn-primary" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Zapisz</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Anuluj</a>
			</div>
			<br/><br/>
		</form>
	</div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalSave">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Zapisz kontrakt
			</div>
		</div>		
		<form action="" method="post" style="padding:10px">
			<input type="hidden" id="id_contract" name="id_contract" value="<?php echo $id_contract;?>" />
			  <div class="form-group">
				<label for="name" class="control-label">Nazwa</label>
				<div class="">
				  <input type="text" class="form-control" id="name" name="name" placeholder="nazwa" value="<?php echo (isset($contract['name'])) ? $contract['name'] : "";?>">
				</div>
			  </div><br clear="all"/>
			  <div class="form-group">
				<label for="date_availability" class="control-label">Data ważności kontraktu</label>
				<div class="">
				  <input type="text" class="form-control" id="date_availability" name="date_availability" >
				</div>
			  </div>
			<br clear="all"/>
			<div class="center">
				<button class="btn btn-primary" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Zapisz</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Anuluj</a>
			</div>
			<br/>
		</form>
	</div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalDelProduct">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Usuwanie elementu 
				</div>
			</div>		
			<p class="center">Czy napewno chcesz usunąć ten element?</p>
			<form action="" method="post" class="center">
				<input type="hidden" id="idToDel" name="idToDel" />
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
		$(".editButton").click(function(){
			id = $(this).attr("rel");
			$("#amounte").val($("#amount"+id).html());
			$("#amountle").val($("#amount_left"+id).html());
			$("#pricee").val($("#price"+id).html());
			$("#id_producte").val(id);
		});
		<?php if(isset($contract['date_availability'])) if($contract['date_availability'] != "0000-00-00")
			{
			?>
			$( "#date_availability" ).datepicker( "setDate", "<?php echo $contract['date_availability'];?>" );
		<?php }
		?>
		
$('#products-contracts-table').dataTable( {
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
		 "sAjaxSource": "<?php echo base_url("manager/tabledata/allProductsForContracts/".$id_categoryMain);?>", 
		 "fnDrawCallback":function(){
			$(".addProduct").click(function()
			{
					$("#id_product").val($(this).attr("rel"));
			});
		}	
		
    });
	});
</script>