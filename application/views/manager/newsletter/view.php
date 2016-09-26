 
<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span> 
	  </div>
	  <div class="panel-body">
		<?php if(isset($return_msg))
		{
			echo $return_msg;
		}
		else
		{
		?>
		<form role="form" method="POST">
			<div class="panel-group" id="accordion">
			  <div class="panel panel-default">
				<div class="panel-heading">
				  <h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
					 Adresaci
					</a>
				  </h4>
				</div>
				<div id="collapseOne" class="panel-collapse collapse">
				  <div class="panel-body">
					<table class="table table-striped" id="clients-table-newsletter">
						<thead class="table-header">
						<tr>
							<th width="50px"></th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach($clients as $id_client =>$client)
						{
							echo
							'<tr>
								<td> 
									<input type="checkbox" value="'.$client['email'].'" name="emails_temp[]"  class="to_set_checkbox" id="email'.$id_client.'" rel="'.$id_client.'">
								</td>
								<td><label for="email'.$id_client.'" style="font-weight:normal">'.$client['name'].'</label></td>
							</tr>';					
						}
						?>
						</tbody>
					</table>			
				  </div>
				</div>
			  </div>
			</div>	
			
			<div class="form-group">
				<label class="control-label" for="title">Tytuł</label>
				<div class="controls">
					<input type="text" id="title" class="form-control"  placeholder="tytuł" name="title" >
				</div>
				<br/>
				<label for="text">Treść wiadomości</label>
				<textarea class="form-control" id="text" name="text" placeholder="Tutaj wpisz treść..."></textarea>
			</div>
			<button type="submit" class="btn btn-primary">
				<span class="glyphicon glyphicon-send"></span>&nbsp;&nbsp;Wyślij wiadomość
			</button>
			<div id="checkboxex-box" style="display:none">
				
			</div>
		</form>
		<?php
		}
		?>
	  </div>
	</div>
</div>


<script>

$(function(){
$('#clients-table-newsletter').dataTable( {
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
				rel = $(this).attr("rel");
				if($('#checkbox_table'+rel).val())
					$('#checkbox_table'+rel).remove();
				else
					$("#checkboxex-box").append('<input type="checkbox" name="emails[]" value="'+val+'" id="checkbox_table'+rel+'" checked />');
			});
		}
       
    });
});
	CKEDITOR.replace( 'text',{
  "filebrowserImageUploadUrl": "<?php echo base_url("/js/ckeditor/plugins/imgupload/imgupload.php");?>",
  'extraPlugins': 'imgbrowse',
  'filebrowserImageBrowseUrl': '<?php echo base_url("/js/ckeditor/plugins/imgbrowse/imgbrowse.html");?>'
} );
</script>