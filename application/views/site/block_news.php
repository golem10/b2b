<?php if(count($news) >0)
{?>
<div id="news-bar">
	<div class="w960">
		<h2 class="header-h2">Aktualności</h2>
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
		  <?php 
		  $active="";
		  $i=0;
		  $l=0;
		  foreach($news as $k=>$v)
		  {	
			if($i == 0)
				$active ='active';
			else
				 $active="";
				 
			if($i%2 == 0)
			{
				echo '		  
				<li data-target="#carousel-example-generic" data-slide-to="'.$l.'" class="'.$active.'"></li>
				';
				$l++;
			}
			
			$i++;
		  }?>
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
			 <?php 
			 $i=0;
			 foreach($news as $k=>$v)
			  {	
				if($i == 0)
					$active ='active';
				else
					$active="";
					
				if($i%2 == 0)
				{
					echo'<div class="item '.$active.'">';
					$side="left";
				}
				else
					$side="right";
				echo '		  			
					<div class="block block-'.$side.'">
						<p>'.$v['text'].'</p>
					</div>';
					
				if($i%2 != 0)
					echo '</div>';
					
					$i++;
			  }?>
			

		  </div>

		  
		</div>
	</div>
</div>
<?php 
}
?>