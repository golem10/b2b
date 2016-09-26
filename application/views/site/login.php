<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="<?php echo base_url("images/fav-icon.png");?>"> 

<title>JKK – Platforma B2B</title>
<?php foreach($css as $value)
	echo '<link rel="stylesheet" href="'.base_url("css/".$value).'" />';
?>
<?php foreach($js as $value)
	echo '<script type="text/javascript" language="javascript" src="'.base_url("js/".$value).'"></script>';
?>

<title>Test</title>
<!--[if lt IE 9]><script type='text/javascript' src='<?php echo base_url("js/excanvas.js");?>'></script><![endif]-->
<script type='text/javascript' src='<?php echo base_url("js/icaptcha.js");?>'></script>

</head>
<body onload="icaptcha(6,'#333333','Błędny kod z obrazka',40,'php')">

<div id="header">
	<div id="top-user-info">
		<div class="w960">
			<div class="text_top"><span>Kompleksowe zaopatrzenie artykułów papierniczych i akcesoriów dla firm</span></div>
			<div class="contact_top">Kontakt: <span class="email">jkkbiuro@jkk.poznan.pl</span><span class="phone">61 656 10 10</span></div>
			<div class="clear"></div>
		</div>
	</div>
	<div id="top-middle-bar">
		<div class="w960">
			<div id="logo">
				<a href="<?php echo base_url();?>"></a>
			</div>
			<div id="block-login">	
				<p>Logowanie <span><a id="forgotten-password" data-toggle="modal" data-target="#forgotten-password-modal">(zapomniałem hasła)</a></span<</p>
				<form class="form-inline" method="post" action="" role="form">
				  <div class="form-group <?php echo (isset($login_error)) ? "has-error" : "";?>" style="margin-bottom:0px">
					<input type="text" class="form-control"  name="login" placeholder="login" style="float:left">
				  </div>
				  <div class="form-group  <?php echo (isset($login_error)) ? "has-error" : "";?>" style="margin-bottom:0px">
					  <input class="form-control" type="password" name="password" placeholder="hasło" style="float:left">
				  </div>
				   <div class="form-group" style="margin-bottom:0px">
					   <button type="submit" class="btn btn-default button big-button"  style="float:left">Zaloguj</button>
				  </div>
				</form>
			</div>
			
			<div class="clear"></div>			
		</div>
	</div>
</div>
<div class="content">
	<div class="w960">
		<div class="background" style="position: relative;">
                    <div class="counter">
                        <?php 
                        //$clientsCount+=5000; //wartość startowa serwisu
                        while(strlen($clientsCount)<5)
                        {
                            $clientsCount='0'.$clientsCount;
                        }    
                        
                        for($i=0;$i<5;$i++)
                        {
                        ?>
                            <div class="count<?php echo $clientsCount[$i]; ?>" style="float: left;"></div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="airplane"></div>
		</div>
		<div class="form">
			<?php if(isset($login_error)){
			?>
			<form method="post" action="">
				<p class="h1">Formularz rejestracyjny</p>
				<div class="input-content">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Nazwa firmy" name="name">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="NIP" name="nip">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Imię i nazwisko" name="person">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Numer kontaktowy" name="phone">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Adres e-mail" name="email">
					</div>
					<input type="hidden" class="form-control" placeholder="" name="register" value="1">
					<div class="form-group ">
						<div class="checkbox">
							<label>
							  <input type="checkbox" value="1" name="agreement" id="agreement">Wyrażam zgodę na przetwarzanie danych osobwych
							</label>
						</div>		
					</div>
					<div id="captcha-box">
						<div id='icaptcha' style='height:50px;width:200px;background-color:#FFFFFF'></div>
						<a onClick='loadicaptcha()' style='cursor:pointer'>Wygeneruj nowy kod</a>
						
						<br>
						<div class="form-group ">
							<input type="text" id="code" size="7" maxlength="5" value="" class="form-control" placeholder="Wpisz kod z obrazka"/>
						</div>
						<br>
					</div>
					
				</div>
				<p class="h1 center"><button type="submit" class="btn btn-default button big-button" onclick="checking_icaptcha()">Zarejestruj</button></p>
			</form>
			<?php } else
			{?>
			<form method="post" action=""  name='validate'>
				<p class="h1">Formularz rejestracyjny</p>
				
				<div class="input-content">
					<div class="form-group <?php echo (set_value('name')=="" && $_POST) ? "has-error" : "";?>">
						<input type="text" class="form-control" placeholder="Nazwa firmy" name="name" value="<?php echo set_value('name'); ?>">
					</div>
					<div class="form-group  <?php echo (set_value('nip')=="" && $_POST) ? "has-error" : "";?>">
						<input type="text" class="form-control" placeholder="NIP" name="nip" value="<?php echo set_value('nip'); ?>">
					</div>
					<div class="form-group  <?php echo (set_value('person')=="" && $_POST) ? "has-error" : "";?>">
						<input type="text" class="form-control" placeholder="Imię i nazwisko" name="person" value="<?php echo set_value('person'); ?>">
					</div>
					<div class="form-group  <?php echo (set_value('phone')=="" && $_POST) ? "has-error" : "";?>">
						<input type="text" class="form-control" placeholder="Numer kontaktowy" name="phone" value="<?php echo set_value('phone'); ?>">
					</div>
					<div class="form-group  <?php echo (set_value('email')=="" && $_POST) ? "has-error" : "";?>">
						<input type="text" class="form-control" placeholder="Adres e-mail" name="email" value="<?php echo set_value('email'); ?>">
					</div>
					<input type="hidden" class="form-control" placeholder="" name="register" value="1">
					<div class="form-group ">
						<div class="checkbox">
							<label <?php echo (set_value('agreement')=="" && $_POST) ? "style='color:#c92b22'" : "";?>>
							  <input type="checkbox" value="1" name="agreement" id="agreement">Wyrażam zgodę na przetwarzanie danych osobwych
							</label>
						</div>		
					</div>
					<div id="captcha-box">
						<div id='icaptcha' style='height:50px;width:200px;background-color:#FFFFFF'></div>
						<a onClick='loadicaptcha()' style='cursor:pointer'>Wygeneruj nowy kod</a>
						
						<br>
						<div class="form-group ">
							<input type="text" id="code" size="7" maxlength="5" value="" class="form-control" placeholder="Wpisz kod z obrazka"/>
						</div>
						<br>
					</div>
				</div>
				<p class="h1 center"><button type="button" class="btn btn-default button big-button" onclick="checking_icaptcha()">Zarejestruj</button></p>
				
			</form>
			<?php
			}?>
			
		</div>
	</div>
</div>

<div id="footer">
	<div id="contact-bar">
		<div class="w960">
			<div class="left-column">
				<div class="left-column adress">
					<?php echo $contact['name'];?><br/>
					<?php echo $contact['street'];?><br/>
					<?php echo $contact['city'];?><br/>
					NIP: <?php echo $contact['nip'];?><br/>
					Nr konta bankowego:<br/><div style="font-size:11px"><?php echo $contact['bank_account'];?></div>
				</div>
				<div class="right-column houres" >
					pn - pt : 8<sup>00</sup> - 16<sup>00</sup><br/>
					sb i nd nieczynne
				</div>
			</div>
			<div class="right-column">
				<div class="left-column email">
				<?php echo $contact['email'];?>
					
				</div>
				<div class="right-column phone">
					<table style="width:100%">
						<tr>
							<td>tel.</td><td>+48 <span><?php echo $contact['phone1'];?></span></td>
						</tr>
						<tr>
							<td></td><td>+48 <span><?php echo $contact['phone2'];?></span></td>
						</tr>
						<tr>
							<td>fax.</td><td>+48 <span><?php echo $contact['fax'];?></span></td>
						</tr>	
					</table>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	
	<div id="black-bar">
		<div class="w960">
			<div class="jkk">Copyrights JKK Centrum Biurowe<br/><span>All rights reserved 2014</span></div>
			<a href="http://it4b.com.pl/" target="_blank">Design & Development by <span>IT4B</span></a>
		</div>
	</div>
</div>

<div id="informacja_o_ciasteczkach" class="cookie_info_belka">
   <div class="w960">
	   <div class="cookie_info_tekst">
		  Na naszym serwisie stosujemy pliki cookies w celach statystycznych i reklamowych. Korzystanie z witryny bez zmiany ustawień dotyczących cookies oznacza, że będą one zamieszczane w Państwa komputerze. Możecie Państwo dokonać w każdym czasie zmiany ustawień dotyczących przechowywania i uzyskiwania dostępu do cookies przy pomocy ustawień przeglądarki.
			<br/> <a href="javascript:zamknij_ciastka('');">[Zamknij]</a><div class="clear"></div>
	   </div>
	</div>
</div>

<script type="text/javascript">
$(function(){
	$('#login-error-modal').modal("show");
	
	$("#agreement").click(function(){
		if($( "#agreement:checked" ).length > 0)
			{
			$("#captcha-box").stop(true,false).animate({height:130,opacity:1});
			}
		else{
			$("#captcha-box").stop(true,false).animate({height:0,opacity:0});
			}
	});
});
   var c_value = document.cookie;
   var c_start = c_value.indexOf("ciasteczka_wylaczone=");

   if (c_start!=-1) {
      var helpObj;
      if (document.all){
      helpObj = document.all["informacja_o_ciasteczkach"];}
      else if (document.getElementById){
      helpObj = document.getElementById("informacja_o_ciasteczkach");}
      if (helpObj) {
      helpObj.style.display="none";}
   }

   function zamknij_ciastka() {
      //Get help object
      var helpObj;
      if (document.all){
      helpObj = document.all["informacja_o_ciasteczkach"];}
      else if (document.getElementById){
      helpObj = document.getElementById("informacja_o_ciasteczkach");}
      if (helpObj) {
      helpObj.style.display="none";}
      document.cookie='ciasteczka_wylaczone=tak; expires=Fri, 7 Jun 2024 20:47:11 UTC; path=/';
   }
   
</script>
<div class="modal fade" id="wrong-captcha-modal">
  <div class="modal-dialog modal-sm" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Zamknij</span></button>
        <h4 class="modal-title">Błąd</h4>
      </div>
		  <div class="modal-body">
			<p>Błędny kod z obrazka</p><br/>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
		  </div>

    </div>
  </div>
</div>
<div class="modal fade" id="forgotten-password-modal">
  <div class="modal-dialog modal-sm" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Zamknij</span></button>
        <h4 class="modal-title">Reset hasła</h4>
      </div>
	  <form action="<?php echo base_url("login/passwordReset");?>" method="post" class="center">
		  <div class="modal-body">
			<p>Wprowadź adres email, na który ma zostać wysłane nowe hasło.</p><br/>
			<div class="form-group ">
					<input type="text" name="email" class="form-control" placeholder="Adres e-mail"/>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary">Wyślij</button>
		  </div>
	  </form>
    </div>
  </div>
</div>
<?php if(isset($login_error)){
			?>
<div class="modal fade in" id="login-error-modal">
  <div class="modal-dialog modal-sm" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Zamknij</span></button>
        <h4 class="modal-title">Błąd logowania</h4>
      </div>
      <div class="modal-body">
        <p>Wprowadziłeś błędny login lub hasło.</p><br/>
		<p>Spróbuj zalogować się ponownie.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
<?php }
else if(isset($msg_val)){
			?>
<div class="modal fade in" id="login-error-modal">
  <div class="modal-dialog modal-sm" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Zamknij</span></button>
        <h4 class="modal-title">Błąd rejestracji</h4>
      </div>
      <div class="modal-body">
        <p><?php echo $msg_val;?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
<?php 
}
?>
<?php
if($register!=""){
?>
<div class="modal fade in" id="login-error-modal">
  <div class="modal-dialog modal-sm" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Zamknij</span></button>
        <h4 class="modal-title">Rejestracja</h4>
      </div>
      <div class="modal-body">
        <p>Formularz rejestracyjny został wysłany.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
<?php 
}
?>
<?php
if(isset($_GET['msg']))
	if($_GET['msg'] == "reminderError")
	{
	?>
	<div class="modal fade in" id="login-error-modal">
	  <div class="modal-dialog modal-sm" >
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Zamknij</span></button>
			<h4 class="modal-title">Błąd przypomnienia hasła</h4>
		  </div>
		  <div class="modal-body">
			<p>Podany adres e-mail jest nieprawidłowy</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
		  </div>
		</div>
	  </div>
	</div>
	<?php 
	}
?>