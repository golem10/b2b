
<form class="form-horizontal" role="form" method="post" action="?action=discounts">
	<div class="row">&nbsp;</div>
	<div class="row">
		<div class="col-md-4" style="text-align:center">
			<div class="panel panel-default">
				<div class="panel-heading">
					Ustal wartości rabatów dla wybranych grup produktów
				</div>
				<div class="panel-body">
					<?php foreach($productsGroups as $k=>$v)
					{?>
					<div class="form-group">
						<label for="id_discount_group_<?php echo $k;?>" class="col-sm-4 control-label">Grupa <?php echo $v['name'];?></label>
						<div class="col-sm-6">
							<div class="input-group">										  
							   <input type="text" class="form-control" id="id_discount_group_<?php echo $k;?>" placeholder="0" name="id_discount_group_<?php echo $k;?>" value="<?php echo (isset($productsGroupsValues[$k])) ? $productsGroupsValues[$k]['value'] : "";?>" aria-describedby="sizing-addon<?php echo $k;?>">
							   <span class="input-group-addon" id="sizing-addon<?php echo $k;?>">%</span>
							</div>
						 
						</div>
					  </div>
					 <?php
					 }
					 ?>
					
				</div>
			</div>							
		</div>
		
		<div class="col-md-2">
			<button type="submit" class="btn btn-primary btn-block">
				<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Zapisz
			</button>
		</div>
	</div>
</form>