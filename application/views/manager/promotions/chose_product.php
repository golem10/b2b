 
<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span>
		<a href="<?php echo $return ? base_url($path.'promotions/promotion/0/0/'.$return) : base_url($path.'promotions/promotion/'); ?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
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
						<a href="'.base_url($path.'promotions/promotion/0/0/'.$id_category).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Zobacz</a>
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
		<span class="panel-header">Produkty</span>
	  </div>
	  <div class="panel-body">
		 <table class="table table-striped" id="products-table">
			<thead class="table-header">
			<tr>
				<th style="width:100px">Id</th>
				<th>Nazwa</th>
				<th style="width:100px">Akcje</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach($products as $id_product =>$product)
			{
				echo
				'<tr>
					<td>'.$id_product.'</td>
					<td>'.$product['name'].'</td>
					<td>
						<a href="'.base_url($path.'promotions/promotion/0/'.$id_product).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Wybierz</a>
					</td>
				</tr>';
		
			}
			?>
			</tbody>
		</table>
	  </div>
	</div>
	
</div>