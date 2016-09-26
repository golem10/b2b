<div id="main-content">

<div class="panel panel-default" style="">
  <div class="panel-heading">
	<span class="panel-header"><?php echo $title;?></span> 
	<a href="<?php echo base_url($path."discounts/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
  </div>
  <div class="panel-body">
	<form class="form-horizontal" method="post">
		<div class="control-group">
			<label class="control-label" for="groupname">Nazwa grupy</label>
			<div class="controls">
				<input type="text" id="groupname" class="form-control"  placeholder="Nazwa grupy" name="name" <?php echo (isset($post['name'])) ? 'value="'.$post['name'].'"' : 'value="'.$def['name'].'"' ?> >
			</div>
		</div>
		<br/><br/>
		<div class="control-group" id="client-checkbox" >
                        <table id="promotions-groups-table" class="table table-striped">
                            <thead class="table-header">
								<tr>
									<th>Klient</th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach($clients as $item){
								$item['checked'] ? $checked='checked' : $checked='';
								echo '<tr><td><input type="checkbox" class="to_set_checkbox"  name="clients_temp['.$item['id_client'].']" value="'.$item['id_client'].'" '.$checked.' />&nbsp&nbsp'.$item['name'].'</input></td></tr>';
							}?>
							</tbody>
						
                        </table>
		</div>
		<br/><br/>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary">
					<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Zapisz
				</button>
					<a href="<?php echo base_url($path."discounts/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>

			</div>
			<div id="checkboxex-box" style="display:none">
				<?php
							foreach($clients as $item)
							{	if($item['checked'])
								echo '<input type="checkbox" name="clients['.$item['id_client'].']" value="'.$item['id_client'].'" checked id="checkbox_table'.$item['id_client'].'" />';			
												
							}
							?>
				</div>
		</div>
	</form>
	
</div>
</div>


<script>
$(function(){
$('#promotions-groups-table').dataTable( {
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
		"fnDrawCallback":function(){
			$( ".to_set_checkbox").unbind( "click" );
			$(".to_set_checkbox").click(function(){
				val = $(this).val();
				if($('#checkbox_table'+val).val())
					$('#checkbox_table'+val).remove();
				else
					$("#checkboxex-box").append('<input type="checkbox" name="clients[]" value="'+val+'" id="checkbox_table'+val+'" checked/>');
			});
		}
       
    });
});
</script>
