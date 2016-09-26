<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span> 
	  </div>
	  <div class="panel-body">
	  
		<ul class="nav nav-tabs" role="tablist">
		<!--	<li ><a href="#rewards-panel" role="tab" data-toggle="tab">Nagrody</a></li> -->
			<li class="active"> <a href="#settings-panel" role="tab" data-toggle="tab">Ustawienia</a></li>
		</ul>
		<div class="tab-content">
			<!-- <div class="tab-pane fade " id="rewards-panel" >
				<?php echo $block_rewards;?>
			</div>	-->
		
			<div class="tab-pane fade in active" id="settings-panel" >
				<form class="form-horizontal" role="form" method="post" action="?action=settings">
					<div class="row">&nbsp;</div>
					<div class="row">
						<div class="col-md-4" style="text-align:center">
							<div class="panel panel-default">
								<div class="panel-heading">
									Ilość punktów za określoną wartość zakupów
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label for="loyality_points" class="col-sm-4 control-label">Ilość punktów</label>
										<div class="col-sm-6">
										  <input type="text" class="form-control" id="loyalty_points" placeholder="" name="loyalty_points" value="<?php echo $loyalty_settings[1]['value'];?>">
										</div>
									  </div>
									  <div class="form-group">
										<label for="loyalty_price" class="col-sm-4 control-label">Wartość zakupów</label>
										<div class="col-sm-6">
										  <input type="text" class="form-control" id="loyalty_price" name="loyalty_price"  value="<?php echo $loyalty_settings[2]['value'];?>">
										</div>
									</div>
									
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
			</div>	
			
		</div>
		
	  </div>
	</div>
	
</div>