<ul>
<?php
	if(count($products) > 0) 
	foreach($products as $k=>$v)
		{?>
		<li onClick="set_product_search_dropdown(this)"><?php echo $v['name'];?></li>
		<?php
		}
	else
		echo "<li>Brak wyników wyszukiwania</li>";
?>
</ul>