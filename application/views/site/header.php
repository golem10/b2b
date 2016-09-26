<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="<?php echo base_url("images/logo_jkk_182x82.png");?>"> 

<title>JKK – Platforma B2B</title>
<?php foreach($css as $value)
	echo '<link rel="stylesheet" href="'.base_url("css/".$value).'" />';
?>
<?php foreach($js as $value)
	echo '<script type="text/javascript" language="javascript" src="'.base_url("js/".$value).'"></script>';
?>

</head>
<body>




<div id="header">
	<div id="top-user-info">
		<div class="w960">
			<div class="ur_adviser"><p>Twój doradca:</p> <span><?php echo $adviser['firstname']." ".$adviser['lastname'].", ".$adviser['email']."<br/>".$adviser['phone_number'];?></span><div class="clear"></div></div>
			<?php if($this->session->userdata('id_profile') == 4 && $client['loyalty'] == 1) {?><a href="<?php echo base_url("articles/view/3");?>"><div class="loyality_points">Punkty: <span><?php echo ($loyalty_points!=0) ? number_format($loyalty_points,0,'',' ') : "0";?></span></div></a> <?php } ?>
			<div class="user_info"><p><a href="<?php echo base_url("company_information");?>"><span class="client-text">Klient:</span> <span class="client-info"><?php echo $this->session->userdata('firstname')." ".$this->session->userdata('lastname'); 
				if($this->session->userdata('mpk') !="") echo " (".$this->session->userdata('mpk').")";
				echo "<br/>".substr($client['name'],0,50); echo (strlen($client['name']) > 50) ? " (...)" : "" ;?> </span></a></p>
			<div class="btn-group">
				<div class="settings_button dropdown-toggle" data-toggle="dropdown"></div>
					<ul class="dropdown-menu dropdown-menu-right" role="menu">
						<li><a href="#"  data-toggle="modal" data-target="#change-password-modal">Zmień hasło</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo base_url("login/out");?>">Wyloguj</a></li>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div id="top-middle-bar">
		<div class="w960">
			<div id="logo">
				<a href="<?php echo base_url();?>"></a>
			</div>
			<?php echo($to_pay) ? '<p id="to-pay-info">Do zapłaty: <span>'.number_format($to_pay,2,',','').'zł</span></p>' : ""; ?>			
			<div class="search-block">
				<form action="<?php echo base_url("search");?>" role="form">
					<div class="input-group">
					  <input class="form-control " type="text" id="search-input" name="search" placeholder="nazwa produktu, kod produktu, opis" autocomplete="off">
					  <input type="hidden" id="base_url-search" value="<?php echo base_url();?>" />
					  <span class="input-group-btn">
						<button class="btn btn-default" type="submit"><div class="search-icon"></div></button>
					  </span>
					</div>
					<div id="search-input-droplist" style="">
						
					</div>
				</form>
			</div>			
			<div class="cart-block">
				<div class="ur-cart-text">Twój<br/>koszyk</div>
				<a href="<?php echo base_url("search?inFavorite=1");?>" class="favourites">Ulubione produkty (<span id="favorite_amount"><?php echo count($favorite_list);?></span>)</a>
				<a href="<?php echo base_url("orders/cart");?>">
					<div class="cart-box">				
							<p><span class="label-cart">netto:</span><span class="value-cart"><span id="value-cart-to-use"><?php if(!$sum_cart[1]) echo "0,00"; else echo  number_format($sum_cart[1],2,',','');?></span> zł</span></span><br clear="all"/></p>
							<p><span class="label-cart">brutto:</span><span class="value-cart-n"><span id="value-cart-to-use-b"><?php if(!$sum_cart[2]) echo "0,00"; else echo number_format($sum_cart[2],2,',','');?></span> zł</span><br clear="all"/></p>						
					</div>
				</a>
			</div>		
			<div class="clear"></div>	
			
		</div>
	</div>
	<div id="menu">
		<div class="w960">
			<ul>
				<li><a href="<?php echo base_url();?>" class="home"><span></span></a></li>
				<li><a href="<?php echo base_url("categories");?>">Produkty</a></li>
				<li><a href="<?php echo base_url("promotions");?>">Promocje</a></li>
				<li><a href="<?php echo base_url("orders"); ?>">Zamówienia</a></li>
				<?php if($client['inquiry'] == 1){?><li><a href="<?php echo base_url("inquiries");?>">Zapytania ofertowe</a></li><?php } ?>
				<li><a href="<?php echo base_url("inquiries/offerts");?>">Oferty</a></li>
				<?php if($this->session->userdata('id_profile') == 4) {?><li><a href="<?php echo base_url("payments");?>">Płatności</a></li><?php }?>
				<?php if($client['loyalty'] == 1){?><li><a href="<?php echo base_url("articles/view/3");?>">Katalog nagród</a></li><?php } ?>
				<li><a href="<?php echo base_url("company_information");?>">Dane firmowe</a></li>
			</ul>
		</div>
	</div>
</div>

<div class="modal fade" id="change-password-modal">
  <div class="modal-dialog modal-sm" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Zamknij</span></button>
        <h4 class="modal-title">Zmiana hasła</h4>
      </div>
	  <form action="<?php echo base_url("index/changePassword");?>" method="post" id="changePasswordForm">
		  <div class="modal-body">
			<div class="alert alert-danger fade in" role="alert" style="display:none" id="changePasswordMsgBox">
				  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				   <p id="changePasswordMsg">Pole Nazwa jest wymagane.</p>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPasswordChange">Hasło</label>
				<div class="controls">
					<input type="password" id="inputPasswordChange" class="form-control"  placeholder="hasło" name="password">
				</div><br/>
				<div class="control-group">
					<label class="control-label" for="inputPasswordChangeRepeat">Powtórz hasło</label>
					<div class="controls">
						<input type="password" id="inputPasswordChangeRepeat" class="form-control"  placeholder="powtórz hasło" name="passwordRepeat">
					</div>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" id="changePasswordButton">Zmień hasło</button>
		  </div>
	  </form>
    </div>
  </div>
</div>