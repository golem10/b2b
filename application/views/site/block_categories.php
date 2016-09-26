<?php if(isset($to_cat_list))
{
echo '<div class="w960">';
}?>
<div id="index-categories-block">
	<h2 class="header-h2">Kategorie produktów</h2>
	<div class="clear"></div>
	<div class="index-categories-box">
		<?php 
		$i=0;
		foreach($categories as $id_category=>$category)
		{
		$i++;
		if($i%6 == 0)
			$borderNone='style="border-right:none"';
		else
			$borderNone='';
		?>
		<div class="item" <?php echo $borderNone;?>>
			<?php
			if($category['access'] == 0)
				echo "<a href='#'  style='opacity:0.5' data-toggle='modal' data-target='#modalInfoCategories'>";
			else
				{
				?>
			<a href="<?php echo base_url("categories/index/".$id_category);?>">
			<?php
			}
			?>
				<div class="image">
					<div class="image"><img src="<?php echo base_url("images/categories/".$category['img']);?>" /></div>
				</div>
				<p class="category_name">
					<?php if(strlen($category['name']) > 35)
						{
							echo substr($category['name'],0,35)."...";
						}
						else
							echo $category['name'];
					?>
				</p>
			</a>			
		</div>
		<?php } ?>
		<div class="item" style="border-right:none">
			<a href="<?php echo base_url("promotions/");?>">
				<div class="image">
					<div class="image"><img src="<?php echo base_url("images/categories/promo.png");?>" /></div>
				</div>
				<p class="category_name">
					Promocje
				</p>
			</a>			
		</div>
		<div class="clear"></div>
	</div>
</div>

<?php if(isset($to_cat_list))
{
echo '</div>';
}?>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalInfoCategories">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Brak dostępu
			</div>
		</div>		
		<p class="center">Brak dostępu do tej kategorii<br/><br/>	
		<a class="btn btn-primary closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;OK</a>
		<br/><br/></p>
	</div>
  </div>
</div>
<script>
$(function(){
	$(".closeModal").click(function(){
		$('#modalInfoCategories').modal('hide');
	});
});
</script>