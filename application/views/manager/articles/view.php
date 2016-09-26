 
<div id="main-content">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<span class="panel-header"><?php echo $title;?></span> 
	  </div>
	  <div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
		<li <?php echo ($tab == 1) ?  'class="active"' : "" ;?>><a href="#news-panel" role="tab" data-toggle="tab">Aktualności</a></li>
		  <li <?php echo ($tab == 2) ?  'class="active"' : "" ;?>><a href="#articles-panel" role="tab" data-toggle="tab">Artykuły</a></li>
		  <li <?php echo ($tab == 3) ?  'class="active"' : "" ;?>><a href="#traders-panel" role="tab" data-toggle="tab">Handlowcy</a></li>
		  <li <?php echo ($tab == 4) ?  'class="active"' : "" ;?> ><a href="#contacts-panel" role="tab" data-toggle="tab">Kontakt</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade <?php echo ($tab == 4) ?  'in active' : "" ;?>" id="contacts-panel">
				<form class="form-horizontal w700" method="post">
					<div class="control-group">
						<label class="control-label" for="name">Nazwa</label>
						<div class="controls">
							<input type="text" id="name" class="form-control"  placeholder="Nazwa" name="name" <?php echo (isset($post['name'])) ? 'value="'.$post['name'].'"' : 'value="'.$contact['name'].'"' ?> >
						</div>
						<label class="control-label" for="street">Ulica</label>
						<div class="controls">
							<input type="text" id="street" class="form-control"  placeholder="Ulica" name="street" <?php echo (isset($post['street'])) ? 'value="'.$post['street'].'"' : 'value="'.$contact['street'].'"' ?> >
						</div>						
						<label class="control-label" for="city">Miasto</label>
						<div class="controls">
							<input type="text" id="city" class="form-control"  placeholder="Miejscowość" name="city" <?php echo (isset($post['city'])) ? 'value="'.$post['city'].'"' : 'value="'.$contact['city'].'"' ?> >
						</div>
						<label class="control-label" for="nip">NIP</label>
						<div class="controls">
							<input type="text" id="nip" class="form-control"  placeholder="NIP" name="nip" <?php echo (isset($post['nip'])) ? 'value="'.$post['nip'].'"' : 'value="'.$contact['nip'].'"' ?> >
						</div>
						<label class="control-label" for="bank_account">Nr konta bankowego</label>
						<div class="controls">
							<input type="text" id="bank_account" class="form-control"  placeholder="Nr konta bankowego" name="bank_account" <?php echo (isset($post['bank_account'])) ? 'value="'.$post['bank_account'].'"' : 'value="'.$contact['bank_account'].'"' ?> >
						</div>
						<label class="control-label" for="email">Adres e-mail</label>
						<div class="controls">
							<input type="text" id="email" class="form-control"  placeholder="Adres email" name="email" <?php echo (isset($post['email'])) ? 'value="'.$post['email'].'"' : 'value="'.$contact['email'].'"' ?> >
						</div>
						<label class="control-label" for="phone1">Nr telefonu 1</label>
						<div class="controls">
							<input type="text" id="phone1" class="form-control"  placeholder="Nr telefonu 1" name="phone1" <?php echo (isset($post['phone1'])) ? 'value="'.$post['phone1'].'"' : 'value="'.$contact['phone1'].'"' ?> >
						</div>
						<label class="control-label" for="phone2">Nr telefonu 2</label>
						<div class="controls">
							<input type="text" id="phone2" class="form-control"  placeholder="Nr telefonu 1" name="phone2" <?php echo (isset($post['phone2'])) ? 'value="'.$post['phone2'].'"' : 'value="'.$contact['phone2'].'"' ?> >
						</div>
						<label class="control-label" for="fax">Fax</label>
						<div class="controls">
							<input type="text" id="fax" class="form-control"  placeholder="Fax" name="fax" <?php echo (isset($post['fax'])) ? 'value="'.$post['fax'].'"' : 'value="'.$contact['fax'].'"' ?> >
						</div>
					</div>
					<br/>
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn btn-primary">
								<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Zapisz
							</button>
								<a href="<?php echo base_url($path."articles/");?>" class="btn btn-default pull-right btn-default"><span class="glyphicon glyphicon-share-alt"></span>&nbsp;Powrót</a>

						</div>
					</div>
				</form>
			</div>
			<div class="tab-pane fade <?php echo ($tab == 3) ?  'in active' : "" ;?>" id="traders-panel">
				<br/>
				<a href="<?php echo base_url($path.'articles/addTrader/');?>" class="btn btn-default pull-right btn-default" id="new-discount-position"><span class="glyphicon glyphicon-plus"></span>&nbsp;Dodaj handlowca</a>
				<br/><br/>
				<table class="table table-striped " id="traders-table">
					<thead class="table-header">
					<tr>
						<th style="width:100px">Id</th>
						<th>Nazwa</th>
						<th>Akcja</th>			
					</tr>
					</thead>
					<tbody>
						<?php
							foreach ($traders as $id=>$value)
								{
									echo "<tr><td>".$id."</td>";
									echo "<td>".$value['name']."</td>";
									echo '<td style="width:150px">
										<a href="'.base_url($path.'articles/editTraders/'.$id).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edycja</a>
										<button class="btn btn-sm btn-default deleteButton" data-toggle="modal" data-target="#modalDelete" rel="'.$id.'"><span class="glyphicon glyphicon-trash" ></span>&nbsp;Usuń</button>
										
										</td></tr>';
								}
						?>
					</tbody>			
				</table>
			</div>
			<div class="tab-pane fade <?php echo ($tab == 2) ?  'in active' : "" ;?>"" id="articles-panel">
				<br/>
				<table class="table table-striped " id="articles-table">
					<thead class="table-header">
					<tr>
						<th style="width:100px">Id</th>
						<th>Tytuł</th>
						<th>Akcja</th>			
					</tr>
					</thead>
					<tbody>
						<?php
							foreach ($articles as $id=>$value)
								{
									echo "<tr><td>".$id."</td>";
									echo "<td>".$value['title']."</td>";
									echo '<td style="width:150px">
										<a href="'.base_url($path.'articles/edit/'.$id).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edycja</a>
										</td></tr>';
								}
						?>
					</tbody>			
				</table>
			</div>
			<div class="tab-pane fade <?php echo ($tab == 1) ?  'in active' : "" ;?>" id="news-panel">
				<br/>
				<a href="<?php echo base_url($path.'articles/add/');?>" class="btn btn-default pull-right btn-default" id="new-discount-position"><span class="glyphicon glyphicon-plus"></span>&nbsp;Dodaj aktualność</a>
				<br/><br/>
				<table class="table table-striped " id="articles-table">
					<thead class="table-header">
					<tr>
						<th style="width:100px">Id</th>
						<th>Tytuł</th>
						<th>Akcja</th>			
					</tr>
					</thead>
					<tbody>
						<?php
							foreach ($news as $id=>$value)
								{
									echo "<tr><td>".$id."</td>";
									echo "<td>".$value['title']."</td>";
									echo '<td style="width:150px">
										<a href="'.base_url($path.'articles/edit/'.$id).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edycja</a>
										<button class="btn btn-sm btn-default deleteButton1" data-toggle="modal" data-target="#modalDelImg" rel="'.$id.'"><span class="glyphicon glyphicon-trash" ></span>&nbsp;Usuń</button>
										</td></tr>';
								}
						?>
					</tbody>			
				</table>
			</div>
		</div>
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
			<form action="<?php echo base_url($path."articles/delete/");?>" method="post" class="center">
				<input type="hidden" id="idToDel1" name="idToDel" />
				<br/>
				<button class="btn btn-danger" ><span class="glyphicon glyphicon-ok"></span>&nbsp;Tak</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-default closeModal" ><span class="glyphicon glyphicon-remove"></span>&nbsp;Nie</a>
				<br/><br/>
			</form>
		</div>
	  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modalDelete">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Usuwanie elementu 
			</div>
		</div>		
		<p class="center">Czy napewno chcesz usunąć ten element?</p>
		<form action="<?php echo base_url($path."articles/deleteTrader/");?>" method="post" class="center">
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