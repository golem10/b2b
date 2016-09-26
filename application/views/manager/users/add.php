<div id="main-content">

<div class="panel panel-default">
  <div class="panel-heading">
	<span class="panel-header"><?php echo $title;?></span> 
	<a href="<?php echo base_url($path."users/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>
  </div>
  <div class="panel-body">
	<form class="form-horizontal w500" method="post">
		<div class="control-group">
			<label class="control-label" for="mpk">MPK</label>
			<div class="controls">
				<input type="text" id="mpk" class="form-control"  placeholder="numer mpk" name="mpk" <?php echo (isset($post['mpk'])) ? 'value="'.$post['mpk'].'"' : 'value="'.$def['mpk'].'"' ?> >
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="firstname">Imię</label>
			<div class="controls">
				<input type="text" id="firstname" class="form-control"  placeholder="imię" name="firstname" <?php echo (isset($post['firstname'])) ? 'value="'.$post['firstname'].'"' : 'value="'.$def['firstname'].'"' ?> >
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="lastname">Nazwisko</label>
			<div class="controls">
				<input type="text" id="lastname" class="form-control" placeholder="nazwisko" name="lastname" <?php echo (isset($post['lastname'])) ? 'value="'.$post['lastname'].'"' : 'value="'.$def['lastname'].'"' ?>>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="login">Login</label>
			<div class="controls">
				<input type="text" id="login" class="form-control"  placeholder="login" name="login" <?php echo (isset($post['login'])) ? 'value="'.$post['login'].'"' : 'value="'.$def['login'].'"' ?>>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputEmail">E-mail</label>
			<div class="controls">
				<input type="text" id="inputEmail" class="form-control"  placeholder="e-mail" name="email" <?php echo (isset($post['email'])) ? 'value="'.$post['email'].'"' :  'value="'.$def['email'].'"' ?>>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="phone_number">Numer telefonu</label>
			<div class="controls">
				<input type="text" id="phone_number" class="form-control"  placeholder="numer telefonu" name="phone_number" <?php echo (isset($post['phone_number'])) ? 'value="'.$post['phone_number'].'"' :  'value="'.$def['phone_number'].'"' ?>>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputPassword">Hasło</label>
			<div class="controls">
				<input type="password" id="inputPassword" class="form-control"  placeholder="hasło" name="password" <?php echo (isset($post['password'])) ? 'value="'.$post['password'].'"' : 'value="'.$def['password'].'"' ?>>
			</div>
		</div>
		<div class="control-group" <?php if(isset($id_user))echo ($id_user== $this->session->userdata('id_user')) ? "style='Display:none'" : "";?>>
			<label class="control-label" for="profil" >Profil</label>
			<div class="controls">
				<select name="profile" id="profil"  class="form-control" >
					<?php foreach($profile as $item){ ?>		
						<option <?php echo ((isset($post['profile']) && $post['profile']==$item['id_profile']) || $def['profile']==$item['id_profile']) ? 'selected="selected"' : ''?>  value="<?php echo $item['id_profile'] ?>"><?php echo $item['name'] ?></option>
					<?php } ?>
			 	</select>
			</div>
		</div>
		<div class="control-group" style="display:none" id="client-select" >
			<label class="control-label" for="client">Klient</label>
			<div class="controls">
				<select name="client" id="client"  class="form-control" >
					<option value="0">---</option>
					<?php foreach($clients as $item){ ?>		
						<option <?php echo ((isset($post['client']) && $post['client']==$item['id_client']) || $def['client']==$item['id_client']) ? 'selected="selected"' : ''?>  value="<?php echo $item['id_client'] ?>"><?php echo $item['name'] ?></option>
					<?php } ?>
			 	</select>
			</div>
		</div>
		<br/><br/>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary">
					<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Zapisz
				</button>
					<a href="<?php echo base_url($path."users/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>

			</div>
		</div>
	</form>
	
</div>
</div>
