<div id="index-promotion-block">
	<h2 class="header-h2">Aktualne rabaty</h2><h2 class="header-h2">Promocje dla Ciebie</h2>
	<div class="clear"></div>
	<div class="index-promotion-box">
		<div class="box-left">
			<?php
			if(count($discounts) > 0)
			{
			?>
			<div class="slider-wrapper">
				<div id="slider" class="nivoSlider">
					<?php 					
					foreach($discounts as $id_discount=>$discount)
					{?>
						<img src="<?php echo base_url("images/categories/".$discount['c_img']);?>" data-thumb="<?php echo base_url("images/categories/".$discount['c_img']);?>" alt="" title="#htmlcaption<?php echo $id_discount;?>"/>
					<?php
					}?>
				</div>
			</div>
			<?php foreach($discounts as $id_discount=>$discount)
					{?>
					<div id="htmlcaption<?php echo $id_discount;?>" class="nivo-html-caption">
						<strong id="h1<?php echo $id_discount;?>">Obniżka na <?php echo $discount['c_name']?></strong>
						<br/><br/><br/>
						<a class="button discount_details" data-toggle="modal" data-target="#modalInfo" rel="<?php echo $id_discount;?>" onClick="details_discounts(<?php echo $id_discount;?>)">Szczegóły</a>
					</div>
					<div id="htmldesc<?php echo $id_discount;?>" class="htmldesc">
						<?php echo $discount['description'] ?>
					</div>
					<?php
					}
			}
			else
			{?>
			<div class="info-box1">
				<div class="info-box ">
					<img src="<?php echo base_url("images/icon_rabats.png");?>" align="left"/>Przykro nam, ale obecnie nie masz przydzielonych rabatów.
				</div>
			</div>
			<?php
			}?>
		</div>
		<div class="box-right">
			<?php
			if(count($promotions) > 0)
			{
			?>
			<div id="news-container1">
				<ul>
					<?php $i=0; foreach($promotions as $id=>$promotion)
					{$i++;?>
						<li><a href="<?php echo base_url("products/view/".$promotion['id_product']);?>"><strong><?php echo $i.". ".$promotion['name']."</strong><br/>".$promotion['description'];?></a></li>
					<?PHP
					}?>
				</ul>
			</div>
			<?php
			}
			else
			{?>
			<div class="info-box2">
				<div class="info-box">
					<img src="<?php echo base_url("images/icon_promo.png");?>" align="left"/>Przykro nam, ale obecnie nie mamy dla Ciebie oferty promocyjnej.
				</div>
			</div>
			<?php
			}?>
		</div>
		
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalInfo">
  <div class="modal-dialog ">
	<div class="modal-content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Szczegóły obniżki
			</div>
		</div>		
		<div id="modalInfoContent">
			
		</div>
		<div class="button-bar">
			<a class="btn btn-primary closeModal pull-right closeDiscInfo" ><span class="glyphicon glyphicon-remove"></span>Zamknij</a><div class="clear"></div>
		</div>
	</div>
  </div>
</div>
<script type="text/javascript">
function details_discounts(id)
{
$("#modalInfoContent").html($("#htmldesc"+id).html());
$(".panel-heading").html($("#h1"+id).html());
}
$(function(){
	 $(".closeDiscInfo").click(function(){
		$('#modalInfo').modal('hide')
	});
	
	
        $('#news-container1').vTicker({
		speed: 1000,
		pause: 4000,
		animation: 'fade',
		mousePause: true,
		showItems: 4,
		height: 0
	});
});
$(window).load(function() {
        $('#slider').nivoSlider({ effect: 'fade',randomStart: true,animSpeed: 1000 ,   directionNav: false, controlNav: false   });
    });
</script>