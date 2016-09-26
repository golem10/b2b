<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="<?php echo base_url("images/logo_jkk_182x82.png");?>"> 

<title></title>
<?php foreach($css as $value)
	echo '<link rel="stylesheet" href="'.base_url("css/".$value).'" />';
?>
<?php foreach($js as $value)
	echo '<script type="text/javascript" language="javascript" src="'.base_url("js/".$value).'"></script>';
?>

</head>
<body>


<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo base_url($path);?>"><img src="<?php echo base_url("images/logo_jkk_182x82.png");?>" id="logo" /></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	  <ul class="nav navbar-nav">
		<?php if(($this->session->userdata('id_profile') == 2 && isset($menu_permission[1])) || $this->session->userdata('id_profile') == 1): ?>
		<li><a href="<?php echo base_url($path."clients");?>">Klienci</a></li>
		<?php endif; ?>
		<?php if(($this->session->userdata('id_profile') == 2 && isset($menu_permission[2])) || $this->session->userdata('id_profile') == 1): ?>
		<li><a href="<?php echo base_url($path."orders");?>">Zamówienia</a></li>
		<?php endif; ?>
		<?php if(($this->session->userdata('id_profile') == 2 && isset($menu_permission[3])) || $this->session->userdata('id_profile') == 1): ?>
		
		<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Oferty <b class="caret"></b></a>
		 <ul class="dropdown-menu">
			<li><a href="<?php echo base_url($path."inquiries/create");?>">Nowa oferta</a></li>
			<li><a href="<?php echo base_url($path."inquiries/offerts");?>">Oferty</a></li>
            <li><a href="<?php echo base_url($path."inquiries");?>">Zapytania ofertowe</a></li>
          </ul>	
		</li>
		<?php endif; ?>
		<?php if(($this->session->userdata('id_profile') == 2 && isset($menu_permission[4])) || $this->session->userdata('id_profile') == 1): ?>
		<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Produkty <b class="caret"></b></a>
		 <ul class="dropdown-menu">
            <li><a href="<?php echo base_url($path."products");?>">Lista produktów</a></li>
			<li><a href="<?php echo base_url($path."products/news");?>">Nowe produkty</a></li>
			<?php /*<li><a href="<?php echo base_url($path."products/all_assigned");?>">Wszystkie przypisane</a></li>*/ ?>
			<li><a href="<?php echo base_url($path."products/deletedProducts");?>">Usunięte produkty</a></li>
            <li><a href="#"  data-toggle="modal" data-target="#modalImportPrices">Import cennika</a></li>
          </ul>	
		</li>
		<?php endif; ?>
		<!-- <li><a href="<?php echo base_url($path."loyalty");?>">System lojalnościowy</a></li>	 -->
		<?php if(($this->session->userdata('id_profile') == 2 && isset($menu_permission[5])) || $this->session->userdata('id_profile') == 1): ?>
		<li><a href="<?php echo base_url($path."promotions");?>">Promocje</a></li>	
		<?php endif; ?>
		<?php if(($this->session->userdata('id_profile') == 2 && isset($menu_permission[6])) || $this->session->userdata('id_profile') == 1): ?>		
		<li><a href="<?php echo base_url($path."discounts");?>">Rabaty</a></li>
		
		<?php endif; ?>
		<?php if(($this->session->userdata('id_profile') == 2 && isset($menu_permission[7])) || $this->session->userdata('id_profile') == 1): ?>
		<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Narzędzia <b class="caret"></b></a>
		 <ul class="dropdown-menu">
            <li><a href="<?php echo base_url($path."dictionaries");?>">Słowniki</a></li>	
			<li><a href="<?php echo base_url($path."newsletter");?>">Newsletter</a></li>
		   	<li><a href="<?php echo base_url($path."raports");?>">Raport</a></li>	
			<li><a href="<?php echo base_url($path."loyalty");?>">System lojalnościowy</a></li>
            <li><a href="<?php echo base_url($path."articles");?>">CMS</a></li>
			<li><a href="<?php echo base_url($path."import");?>">Import danych</a></li>
			
			<li><a href="<?php echo base_url($path."users");?>">Użytkownicy</a></li>	
			<li><a href="<?php echo base_url($path."permissions");?>">Uprawnienia</a></li>	
			
          </ul>
		</li>
		<?php endif; ?>
			
		
	  </ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Moje konto <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <!-- <li><a href="#">Ustawienia</a></li>
            <li class="divider"></li> -->
            <li><a href="<?php echo base_url($path."login/out");?>">Wyloguj</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalImportPrices">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Zaimportuj cennik
				</div>
			</div>		
			<p class="center">Wybierz plik CSV z aktualnym cennikiem</p>
			<form action="<?php echo base_url($path."import/priceList");?>" method="post" class="center" enctype="multipart/form-data">
				<input type="file" name="userfile" style="width:96px;margin:0 auto" />
				<br/>
				<button class="btn btn-primary" ><span class="glyphicon glyphicon-file"></span>&nbsp;Import</button>&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Anuluj</a>
				<br/><br/>
			</form>
		</div>
	  </div>
</div>