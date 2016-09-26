<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" />
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="<?php echo base_url("images/fav-icon.png");?>"> 
<title>JKK Administracja</title>
<link rel="stylesheet" href="<?php echo base_url("css/bootstrap.min.css");?>">
<link rel="stylesheet" href="<?php echo base_url("css/manager/login.css");?>">

<script src="<?php echo base_url("js/jquery-2-1-1.min.js");?>"></script>
<script src="<?php echo base_url("js/bootstrap.min.js");?>"></script>

</head>

<body>


<div id="container">

	<div id="login-form">	
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title">Panel logowania</h3>
		  </div>
		  <div class="panel-body">
				<form method="post">
				<div class="form-group">
					<div class="input-group">
					  <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
					  <input class="form-control" type="name" name='login' placeholder="login">
					</div>
				 </div>		
				
				<div class="form-group">
					<div class="input-group ">
					  <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
					  <input class="form-control" type="password" name='pass' placeholder="hasło">
					</div>
				 </div>		
				
				<button type="submit" class="btn btn-primary">
							<span class="glyphicon glyphicon-chevron-right"></span>&nbsp;Zaloguj
				</button>
				</form>
				
		  </div>
		</div>	
	</div>
	
</div>	
	
</body>
</html>