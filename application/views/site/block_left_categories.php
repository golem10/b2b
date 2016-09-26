<div id="left-categories-block">
	<h2 class="header-h2">Kategorie produktów</h2>
	<div class="clear"></div>
	<div class="left-categories-box">
		<ul>
		<?php 
			foreach($categories[0] as $id=>$value)
				{	if($id == $id_category)
						$style="active";
					else
						$style="";						
					if($id == $id_category || ($category['id_parent'] != 0 && $id==$category['id_parent']))
						{
							$style1="style='height:auto'";
							$class_span = "collapse-submenu";
						}
					else
						{	$style1="";
							$class_span = "";
						}
					echo "<li><span class='expand-submenu ".$class_span."' rel='".$id."'></span>";
					if($value['access'] == 0)
						{
						echo "<a href='#' class='".$style." unavailable' data-toggle='modal' data-target='#modalInfo'> ".$value['name']. "&nbsp;("  ;
						if(isset($value['count2']))
							echo "<span id='countProdAvail".$id."'>".$value['count2']."/</span>";
						echo "<span id='countProd".$id."'>".$value['count']."</span>) ";
						}
					else
					{
						echo "<a href='".base_url("categories/index/".$id)."' class='".$style."'> ".$value['name']. "&nbsp;("  ;
						if(isset($value['count2']))
							echo "<span id='countProdAvail".$id."'>".$value['count2']."/</span>";
						echo "<span id='countProd".$id."'>".$value['count']."</span>) ";
					}	
					echo "</a>";
						
						$countProdAvail[$id] = 0;
							if(isset($categories[$id]))
							{  echo "<div id='submenu-block".$id."' class='submenu-block' ".$style1.">";
								echo "<ul id='submenu".$id."'>";
								$countProd[$id]=$value['count'];
								// if(isset($value['count2']))
									// $countProdAvail[$id]=$value['count2'];
								foreach($categories[$id] as $id1=>$value1)
									{	$countProd[$id]+=$value1['count'];
										if(isset($value1['count2']))
											$countProdAvail[$id] += $value1['count2'];
											
									
										if($id1 == $id_category)
											$style="active";
										else
											$style="";
										echo "<li>";
										if($value1['access'] == 0)
											{
											echo "<a href='#' class='".$style." unavailable' data-toggle='modal' data-target='#modalInfo'> ".$value1['name']. "&nbsp;("  ;
											if(isset($value1['count2']))
												echo "<span id='countProdAvail".$id1."'>".$value1['count2']."/</span>";
											echo "<span id='countProd".$id1."'>".$value1['count']."</span>) ";
											}
										else
											{
											echo "<a href='".base_url("categories/index/".$id1)."' class='".$style."'> ".$value1['name']. "&nbsp;("  ;
											if(isset($value1['count2']))
												echo "<span id='countProdAvail".$id1."'>".$value1['count2']."/</span>";
											echo "<span id='countProd".$id1."'>".$value1['count']."</span>) ";
											}
											echo "</a>";
										echo "</li>";			
									}		
								echo "</ul></div>";
								}
						
					echo"</li>";
				}
			?>
		</ul>
		<div class="clear"></div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalInfo">
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
		$('#modalInfo').modal('hide');
	});
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
	<?php
	foreach($countProd as $idC=>$vC)
	{?>
	$("#countProd<?php echo $idC;?>").html("<?php echo $vC;?>");
	<?php
	}	
	if(isset($countProdAvail))
		foreach($countProdAvail as $idC=>$vC)
		{?>
		$("#countProdAvail<?php echo $idC;?>").html("<?php echo $vC;?>/");
		<?php
		}	
	?>
});
</script>

