<?php 
	if($msg==1)
		$class="alert-success";
	elseif($msg==2)
		$class="alert-danger";
?>
<div class="alert <?php echo $class;?> fade in status-info-box" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
       <?php echo $msg_val;?>
</div>