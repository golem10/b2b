<div id="footer">
	<div id="blue-bar">
		<div class="w960">
			<div class="left-column">
				<div class="left-column">KONTO</div>
				<div class="right-column">ZAMÓWIENIA</div>
			</div>
			<div class="right-column">
				<div class="left-column">INFORMACJE</div>
				<div class="right-column">KONTAKT</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div id="info-bar">
		<div class="w960">
			<div class="left-column">
				<div class="left-column">
					<ul>
						<li><a href="<?php echo base_url("orders"); ?>">Moje zamówienia</a></li>
						<li><a href="<?php echo base_url("orders/cart"); ?>">Mój koszyk</a></li>
						<li><a href="<?php echo base_url("search?inFavorite=1"); ?>">Moje ulubione</a></li>
						<li><a href="<?php echo base_url("company_information"); ?>">Dane firmowe</a></li>
						<?php if($this->session->userdata('id_profile') == 4) {;?><li><a href="<?php echo base_url("payments");?>">Płatności</a></li><?php }?>					
					</ul>
				</div>
				<div class="right-column">
					<ul>
						<li><a href="<?php echo base_url("categories"); ?>">Produkty</a></li>
						<li><a href="<?php echo base_url("promotions");?>">Promocje</a></li>
						<li><a href="<?php echo base_url("inquiries");?>">Zapytania ofertowe</a></li>
						<li><a href="<?php echo base_url("contracts");?>">Kontrakty</a></li>
					</ul>
				</div>
				<div class="clear"></div>
			</div>
			<div class="right-column">
				<div class="left-column">
					<ul>
						<?php if($this->session->userdata('id_profile') == 4) {;?><li><a href="<?php echo base_url("articles/view/3");?>">Katalog nagród</a></li><?php }?>			
						<li><a href="<?php echo base_url("articles/view/1");?>">Regulamin</a></li>
						<li><a href="<?php echo base_url("articles/view/2");?>">Polityka cookie</a></li>
					</ul>
				</div>
				<div class="right-column">
					<p class="big1">Masz pytanie?</p>
					Jesteśmy do Twojej dyspozycji<br/>
					
					<?php foreach ($traders as $id=>$trader)
					{
					?>
					<span class="white"><?php echo $trader['name'];?></span>
					<ul class="person">
						<li><?php echo $trader['email'];?></li>
						<li><?php echo $trader['phone'];?></li>
					</ul>
					<?php }?>					
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
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

</body>
</html>