 
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
			<div class="panel panel-default">
				<div class="panel-heading">
					Dostęp dla moderatora
				</div>
				
				<table class="table table-bordered table-hover table-striped ">
					<thead class="table-header">
					<tr>
						<th>Pozycja</th>
						<th style="width:300px">Dostęp</th>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach($permissions as $id =>$pos)
					{
						echo
						'<tr>
							<td>'.$pos['name'].'</td>
							<td>';
							?>
							<div class="btn-group" data-toggle="buttons">
							  <label class="btn <?php echo ($pos['access']==1) ? 'btn-primary active' : 'btn-default';?>">
								<input type="radio" name="access[<?php echo $id;?>]"  value="1" <?php echo ($pos['access']==1) ? 'checked' : '';?>>&nbsp;&nbsp;Tak&nbsp;&nbsp;
							  </label>
							  <label class="btn <?php echo ($pos['access']==0) ? 'btn-primary active' : 'btn-default';?>">
								<input type="radio" name="access[<?php echo $id;?>]"  value="0" <?php echo ($pos['access']==0) ? 'checked' : ''; ?>>&nbsp;&nbsp;Nie&nbsp;&nbsp;
							  </label>
							</div>
							<?php
							echo '</td>
						</tr>';
					}?>
					</tbody>
				</table>
				
				<div class="col-md-2"><br/><br/>
					<button type="submit" class="btn btn-primary btn-block">
						<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Zapisz
					</button>
				</div>
			</div>	

		</form>
		<?php
		}
		?>
	  </div>
	</div>
</div>


