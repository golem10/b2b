<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-md-8">
		<?php
			echo '<div class="row">';
			foreach($rewards as $id_reward=>$reward)
			{ $img=explode(".",$reward['img']);
				if(isset($img[1]))
					$img_name=$img[0]."_thumb.".$img[1];
				else
					$img_name="";
				echo'
				  <div class="col-md-2">
					<div class="thumbnail">
					  <img src="'.base_url("uploads/images/".$img_name).'" alt="...">
					  <div class="caption">
						<h3 class="reward-name">'.$reward['name'].'</h3>
						<p class="reward-description">'.$reward['description'].'</p>
						<p class="points_value">'.number_format($reward['points_value'],0,'',' ').' pt</p>
						<p><a href="#" class="btn btn-primary btn-sm editButton" role="button" data-toggle="modal" data-target="#modalEditReward" rel="'.$id_reward.'"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edycja</a> <a href="#" class="btn btn-default btn-sm deleteButton" role="button" data-toggle="modal" data-target="#modalDelImg" rel="'.$id_reward.'"><span class="glyphicon glyphicon-trash"></span>&nbsp;Usuń</a></p>
					  </div>
					</div>
				  </div>';
			}
			echo '</div>';
		?>
	</div>
	<div class="col-md-1">
	</div>
	<div class="col-md-2">
		<a data-toggle="modal" data-target="#modalAddReward" class="btn btn-primary btn-block">
			<span class="glyphicon glyphicon-plus"></span>&nbsp;Dodaj nagrodę
		</a>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalEditReward">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Edytuj nagrodę
				</div>
			</div>		
			<form class="form-horizontal" role="form" action="?action=editReward" method="post" enctype="multipart/form-data">
				<input type="hidden" class="form-control" id="id_reward_E" name="id_reward">
				<div class="form-group">
					<label for="name_E" class="col-sm-2 control-label">Nazwa nagrody</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="name_E" name="name" placeholder="Nazwa nagrody">
					</div>
				</div>
				<div class="form-group">
					<label for="description_E" class="col-sm-2 control-label">Opis</label>
					<div class="col-sm-10">						
						<textarea class="form-control" id="description_E" name="description" placeholder="Opis"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="points_value_E" class="col-sm-2 control-label">Wartość punktowa</label>
					<div class="col-sm-10">						
						<input type="text" class="form-control" id="points_value_E" name="points_value" placeholder="wartość punktowa" />
					</div>
				</div>
				<div class="form-group">
					<label for="img_E" class="col-sm-2 control-label">Zdjęcie</label>
					<div class="col-sm-10">						
						<input type="file" name="userfile"  class="form-control" id="img_E" name="img" />
					</div>
				</div>
				<p class="center">
					<button class="btn btn-primary" ><span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Zapisz</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Anuluj</a>
				</p>
			</form>
			
		</div>
	  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalAddReward">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Dodaj nagrodę
				</div>
			</div>		
			<form class="form-horizontal" role="form" action="?action=addReward" method="post" enctype="multipart/form-data">
				
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">Nazwa nagrody</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="name" name="name" placeholder="Nazwa nagrody">
					</div>
				</div>
				<div class="form-group">
					<label for="description" class="col-sm-2 control-label">Opis</label>
					<div class="col-sm-10">						
						<textarea class="form-control" id="description" name="description" placeholder="Opis"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="points_value" class="col-sm-2 control-label">Wartość punktowa</label>
					<div class="col-sm-10">						
						<input type="text" class="form-control" id="points_value" name="points_value" placeholder="wartość punktowa" />
					</div>
				</div>
				<div class="form-group">
					<label for="img" class="col-sm-2 control-label">Zdjęcie</label>
					<div class="col-sm-10">						
						<input type="file" name="userfile"  class="form-control" id="img" name="img" />
					</div>
				</div>
				<p class="center">
					<button class="btn btn-primary" ><span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Zapisz</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Anuluj</a>
				</p>
			</form>
			
		</div>
	  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalDelImg">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Usuwanie elementu 
				</div>
			</div>		
			<p class="center">Czy napewno chcesz usunąć ten element?</p>
			<form action="<?php echo base_url($path."loyalty/deleteReward/");?>" method="post" class="center">
				<input type="hidden" id="idToDel" name="idToDel" />
				<br/>
				<button class="btn btn-danger" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Tak</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Nie</a>
				<br/><br/>
			</form>
		</div>
	  </div>
</div>
<script>
$(function(){
<?php if(isset($msg))
	if($msg == 2)
{?>	
	$("#modalAddReward").modal('show');
<?php
}
?>
var reward = new Array();
<?php 
foreach($rewards as $id_reward=>$reward)
	{
	echo "reward[".$id_reward."]={id_reward:'".$reward['id_reward']."',name:'".$reward['name']."',description:'".$reward['description']."',points_value:'".$reward['points_value']."'};";
	}
?>
	 $(".editButton").click(function(){
		$("#id_reward_E").val(reward[$(this).attr("rel")].id_reward);
		$("#name_E").val(reward[$(this).attr("rel")].name);
		$("#description_E").val(reward[$(this).attr("rel")].description);
		$("#points_value_E").val(reward[$(this).attr("rel")].points_value);
	 });
});
</script>