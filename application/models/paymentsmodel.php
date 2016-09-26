<?php 

class Paymentsmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('access');
    }
	//migration//
	
	private function paymentsToInvoicesOne($post=array())
	{
		foreach($post  as $id=>$value)
			{	
				if(strtoupper(substr($value['nzf_NumerPelny'],0,1)) == 'K')
				{
					
					if($value['nzf_IdObiektu'])
						$data1[$id]['id_client']=$value['nzf_IdObiektu'];
					else
						$data1[$id]['id_client']="";
								
					if($value['nzf_NumerPelny'])
					{
						$data1[$id]['facture_code']=$value['nzf_NumerPelny'];
					}
					else
						$data1[$id]['facture_code']="";
					if($value['dok_DoDokId '])
						{
							$data1[$id]['id_facture']=$value['dok_DoDokId '];
						}
						else
							$data1[$id]['id_facture']="";
					if($value['nzf_NumerPelny'])
					{
						$data1[$id]['facture_code']=$value['nzf_NumerPelny'];
					}
					else
						$data1[$id]['facture_code']="";
					if($value['nzf_Data'])
					{
						$data1[$id]['date']=$value['nzf_Data'];
					}
					else
						$data1[$id]['date']="0000-00-00";
					
					if($value['nzf_WartoscPierwotna'])		
					{
						$value1 = str_replace(',','.',($value['nzf_WartoscPierwotna']))-str_replace(',','.',($value['naleznosc']));
						$data1[$id]['value']= $value1;
					}
					else
						$data1[$id]['value']="";						
				}
				else
				{
					if($value['nzf_WartoscPierwotna'])
					{ // id obiektu to client....
						if($value['nzf_IdObiektu'])
							$data[$id]['id_client']=$value['nzf_IdObiektu'];
						else
							$data[$id]['id_client']="";
									
						if($value['nzf_NumerPelny'])
						{
							$data[$id]['facture_code']=$value['nzf_NumerPelny'];
						}
						else
							$data[$id]['facture_code']="";
						if($value['dok_DoDokId'])
						{
							$data[$id]['id_order']=$value['dok_DoDokId'];
						}
						else
							$data[$id]['id_order']="";
						if($value['nzf_Data'])
						{
							$data[$id]['date']=$value['nzf_Data'];
						}
						else
							$data[$id]['date']="0000-00-00";
						
						if($value['nzf_WartoscPierwotna'])		
						{
							$value1 = str_replace(',','.',($value['nzf_WartoscPierwotna']))-str_replace(',','.',($value['naleznosc']));
							$data[$id]['value']= $value1;
						}
						else
							$data[$id]['value']="";
						
						$this->db->query('UPDATE payments SET paid = paid +'.str_replace(',','.',$value1)." where facture_code = '".$value['nzf_NumerPelny']."'");
					}
				}
				
			}
			$tab[0]=$data;
			$tab[1]=$data1;
			return $tab;
	}
	private function paymentsToInvoicesMore($post=array())
	{
		foreach($post['Payments']  as $id=>$value)
			{	//echo "<br/><br/>WIECEJ Płatności<br/><br/>";
				if(strtoupper(substr($value['nzf_NumerPelny'],0,1)) == 'K')
				{
					
					if($value['nzf_IdObiektu'])
						$data1[$id]['id_client']=$value['nzf_IdObiektu'];
					else
						$data1[$id]['id_client']="";
								
					if($value['nzf_NumerPelny'])
					{
						$data1[$id]['facture_code']=$value['nzf_NumerPelny'];
					}
					else
						$data1[$id]['facture_code']="";
					if($value['dok_DoDokId'])
						{
							$data1[$id]['id_facture']=$value['dok_DoDokId'];
						}
						else
							$data1[$id]['id_facture']="";
					if($value['nzf_NumerPelny'])
					{
						$data1[$id]['facture_code']=$value['nzf_NumerPelny'];
					}
					else
						$data1[$id]['facture_code']="";
					if($value['nzf_Data'])
					{
						$data1[$id]['date']=$value['nzf_Data'];
					}
					else
						$data1[$id]['date']="0000-00-00";
					
					if($value['nzf_WartoscPierwotna'])		
					{
						$value1 = str_replace(',','.',($value['nzf_WartoscPierwotna']))-str_replace(',','.',($value['naleznosc']));
						$data1[$id]['value']= $value1;
					}
					else
						$data1[$id]['value']="";						
				}
				else
				{
					if($value['nzf_WartoscPierwotna'])
					{ // id obiektu to client....
						if($value['nzf_IdObiektu'])
							$data[$id]['id_client']=$value['nzf_IdObiektu'];
						else
							$data[$id]['id_client']="";
									
						if($value['nzf_NumerPelny'])
						{
							$data[$id]['facture_code']=$value['nzf_NumerPelny'];
						}
						else
							$data[$id]['facture_code']="";
						if($value['dok_DoDokId'])
						{
							$data[$id]['id_order']=$value['dok_DoDokId'];
						}
						else
							$data[$id]['id_order']="";
						if($value['nzf_Data'])
						{
							$data[$id]['date']=$value['nzf_Data'];
						}
						else
							$data[$id]['date']="0000-00-00";
						
						if($value['nzf_WartoscPierwotna'])		
						{
							$value1 = str_replace(',','.',($value['nzf_WartoscPierwotna']))-str_replace(',','.',($value['naleznosc']));
							$data[$id]['value']= $value1;
						}
						else
							$data[$id]['value']="";
						
						$this->db->query('UPDATE payments SET paid = paid +'.str_replace(',','.',$value1)." where facture_code = '".$value['nzf_NumerPelny']."'");
					}
				}
			}
			$tab[0]=$data;
			$tab[1]=$data1;
			return $tab;
	}	
	public function setPaymentsToInvoices($post=array(), $id_list = 0)
	{	
		//echo "<br/>".count($post['Payments']);
		if(isset($post['Payments']['nzf_IdObiektu']))
			$data = $this->paymentsToInvoicesOne($post);			
		else
			$data = $this->paymentsToInvoicesMore($post);	
			
		//print_r($data);
		//print_r($post);
		$a=1;$b=1;
		if(count($data[0]) > 0)
		{
			$this->db->insert_batch('payments_true', $data[0]);
			if($this->db->affected_rows() > 0) $a =1;else $a = 0;
			foreach($data[0] as $k=>$v)
				{
					$data[0][$k]['id_import'] = $id_list;				
				}
				$this->db->insert_batch('import_payments_true', $data[0]); 
		}
		if(count($data[1]) > 0)
		{
			$this->db->insert_batch('corrections_settl', $data[1]);
			if($this->db->affected_rows() > 0) $b =1;else $b = 0;
		}
		
		if($a == 1 && $b == 1)
			return 1;
		else return 0;
	}
	private function importPaymentsOne($post=array(),$url)
	{	$data1=array();$data = array();$data2=array();$data3 = array();
		foreach($post  as $id=>$value)
			{	
			if(strtoupper(substr($value['nrFaktury'],0,1)) == 'K')
				{	$data1[$id]['create_date']=date("Y-m-d H:i:s");
					if($value['idFaktury'])
						$data1[$id]['id_facture']=$value['idFaktury'];
					else
						$data1[$id]['id_facture']="";
								
					if($value['IdPlatnik'])
						$data1[$id]['id_client']=$value['IdPlatnik'];
					else
						$data1[$id]['id_client']="";
					if($value['nrFaktury'])
						$data1[$id]['facture_code']=$value['nrFaktury'];
					else
						$data1[$id]['facture_code']="";
					if($value['nrZamowienie'])
						$data1[$id]['id_order']=$value['nrZamowienie'];
					else
						$data1[$id]['id_order']="";
					if($value['WartoscNetto'])			
						$data1[$id]['amount']=str_replace(',','.',$value['WartoscNetto']);
					else
						$data1[$id]['amount']="";
					if($value['WartoscBrutto'])
						$data1[$id]['amount_b']=str_replace(',','.',$value['WartoscBrutto']);
					else
						$data1[$id]['amount_b']="";
					//$data[$id]['url_facture']=$value['url_facture'];
					if($value['DataWystawienia'])
						$data1[$id]['date']=$value['DataWystawienia'];
					else
						$data1[$id]['date']="";
					if($value['TerminPlatnosci'])
						$data1[$id]['deadline']=$value['TerminPlatnosci'];
					else
						$data[$id]['deadline']="";
					 if($value['pdf'])
					 {	
						if(file_put_contents(($url.$value['idFaktury'].".pdf"), base64_decode($value['pdf'])))
						{
						  $v=(string)$value['idFaktury'];
						  $data1[$id]['facture_url'] = $v.".pdf";
						}
						else
							$data1[$id]['facture_url'] = 0;
							
					 }

				}
			else
				{
					$to_update =0;
					$this->db->select('facture_code');
					$this->db->from('payments');
					$this->db->where('facture_code', $value['nrFaktury']);
					foreach($this->db->get()->result() as $item)
					{	
						$to_update = 1;
					}
				
					if($to_update == 1)
					{
						if($value['idFaktury'])
							$data2[$id]['id_facture']=$value['idFaktury'];
						else
							$data2[$id]['id_facture']="";
									
						if($value['IdPlatnik'])
							$data2[$id]['id_client']=$value['IdPlatnik'];
						else
							$data2[$id]['id_client']="";
						if($value['nrFaktury'])
							$data2[$id]['facture_code']=$value['nrFaktury'];
						else
							$data2[$id]['facture_code']="";
						if($value['nrZamowienie'])
							$data2[$id]['id_order']=$value['nrZamowienie'];
						else
							$data2[$id]['id_order']="";
						if($value['WartoscNetto'])			
							$data2[$id]['amount']=str_replace(',','.',$value['WartoscNetto']);
						else
							$data2[$id]['amount']="";
						if($value['WartoscBrutto'])
							$data2[$id]['amount_b']=str_replace(',','.',$value['WartoscBrutto']);
						else
							$data2[$id]['amount_b']="";
						//$data[$id]['url_facture']=$value['url_facture'];
						if($value['DataWystawienia'])
							$data2[$id]['date']=$value['DataWystawienia'];
						else
							$data2[$id]['date']="";
						if($value['TerminPlatnosci'])
							$data2[$id]['deadline']=$value['TerminPlatnosci'];
						else
							$data2[$id]['deadline']="";
						 if($value['pdf'])
						 {	
							 if(file_put_contents(($url.$value['idFaktury'].".pdf"), base64_decode($value['pdf'])))
							 {
								  $v=(string)$value['idFaktury'];
								  $data2[$id]['facture_url'] = $v.".pdf";
							 }
							else
								$data2[$id]['facture_url'] = 0;
						 }
					}
					else
					{	$data[$id]['create_date']=date("Y-m-d H:i:s");
						if($value['idFaktury'])
							$data[$id]['id_facture']=$value['idFaktury'];
						else
							$data[$id]['id_facture']="";
									
						if($value['IdPlatnik'])
							$data[$id]['id_client']=$value['IdPlatnik'];
						else
							$data[$id]['id_client']="";
						if($value['nrFaktury'])
							$data[$id]['facture_code']=$value['nrFaktury'];
						else
							$data[$id]['facture_code']="";
						if($value['nrZamowienie'])
							$data[$id]['id_order']=$value['nrZamowienie'];
						else
							$data[$id]['id_order']="";
						if($value['WartoscNetto'])			
							$data[$id]['amount']=str_replace(',','.',$value['WartoscNetto']);
						else
							$data[$id]['amount']="";
						if($value['WartoscBrutto'])
							$data[$id]['amount_b']=str_replace(',','.',$value['WartoscBrutto']);
						else
							$data[$id]['amount_b']="";
						//$data[$id]['url_facture']=$value['url_facture'];
						if($value['DataWystawienia'])
							$data[$id]['date']=$value['DataWystawienia'];
						else
							$data[$id]['date']="";
						if($value['TerminPlatnosci'])
							$data[$id]['deadline']=$value['TerminPlatnosci'];
						else
							$data[$id]['deadline']="";
						 if($value['pdf'])
						 {	
							 if(file_put_contents(($url.$value['idFaktury'].".pdf"), base64_decode($value['pdf'])))
							 {
							  $v=(string)$value['idFaktury'];
							  $data[$id]['facture_url'] = $v.".pdf";
							 }
							else
								$data[$id]['facture_url'] = 0;
						 }
					}
				 }
				
			}
			
			$tab[0] = $data;
			$tab[1] = $data1;
			$tab[2] = $data2;
			$tab[3] = $data3;
			return $tab;
	}
	private function importPaymentsMore($post=array(),$url)
	{	$data1=array();$data = array();$data2=array();$data3 = array();
		foreach($post['invoice']  as $id=>$value)
			{
				if(strtoupper(substr($value['nrFaktury'],0,1)) == 'K')
				{
					$to_update =0;
					$this->db->select('id_facture');
					$this->db->from('payments');
					$this->db->where('id_facture', $value['idFaktury']);
					foreach($this->db->get()->result() as $item)
					{	
						$to_update = 1;
					}
					if($to_update == 1)
					{
						if($value['idFaktury'])
							$data3[$id]['id_facture']=$value['idFaktury'];
						else
							$data3[$id]['id_facture']="";
									
						if($value['IdPlatnik'])
							$data3[$id]['id_client']=$value['IdPlatnik'];
						else
							$data3[$id]['id_client']="";
						if($value['nrFaktury'])
							$data3[$id]['facture_code']=$value['nrFaktury'];
						else
							$data3[$id]['facture_code']="";
						if($value['nrZamowienie'])
							$data3[$id]['id_order']=$value['nrZamowienie'];
						else
							$data3[$id]['id_order']="";
						if($value['WartoscNetto'])			
							$data3[$id]['amount']=str_replace(',','.',$value['WartoscNetto']);
						else
							$data3[$id]['amount']="";
						if($value['WartoscBrutto'])
							$data3[$id]['amount_b']=str_replace(',','.',$value['WartoscBrutto']);
						else
							$data3[$id]['amount_b']="";
						//$data[$id]['url_facture']=$value['url_facture'];
						if($value['DataWystawienia'])
							$data3[$id]['date']=$value['DataWystawienia'];
						else
							$data3[$id]['date']="";
						if($value['TerminPlatnosci'])
							$data3[$id]['deadline']=$value['TerminPlatnosci'];
						else
							$data3[$id]['deadline']="";
						 if($value['pdf'])
						 {	
							 if(file_put_contents(($url.$value['idFaktury'].".pdf"), base64_decode($value['pdf'])))
							 {
								  $v=(string)$value['idFaktury'];
								  $data3[$id]['facture_url'] = $v.".pdf";
							 }
							else
								$data3[$id]['facture_url'] = 0;
						 }
					}
					else
					{	$data1[$id]['create_date']=date("Y-m-d H:i:s");
						if($value['idFaktury'])
							$data1[$id]['id_facture']=$value['idFaktury'];
						else
							$data1[$id]['id_facture']="";
									
						if($value['IdPlatnik'])
							$data1[$id]['id_client']=$value['IdPlatnik'];
						else
							$data1[$id]['id_client']="";
						if($value['nrFaktury'])
							$data1[$id]['facture_code']=$value['nrFaktury'];
						else
							$data1[$id]['facture_code']="";
						if($value['nrZamowienie'])
							$data1[$id]['id_order']=$value['nrZamowienie'];
						else
							$data1[$id]['id_order']="";
						if($value['WartoscNetto'])			
							$data1[$id]['amount']=str_replace(',','.',$value['WartoscNetto']);
						else
							$data1[$id]['amount']="";
						if($value['WartoscBrutto'])
							$data1[$id]['amount_b']=str_replace(',','.',$value['WartoscBrutto']);
						else
							$data1[$id]['amount_b']="";
						//$data[$id]['url_facture']=$value['url_facture'];
						if($value['DataWystawienia'])
							$data1[$id]['date']=$value['DataWystawienia'];
						else
							$data1[$id]['date']="";
						if($value['TerminPlatnosci'])
							$data1[$id]['deadline']=$value['TerminPlatnosci'];
						else
							$data1[$id]['deadline']="";
						 if($value['pdf'])
						 {	
							 if(file_put_contents(($url.$value['idFaktury'].".pdf"), base64_decode($value['pdf'])))
							 {
								  $v=(string)$value['idFaktury'];
								  $data1[$id]['facture_url'] = $v.".pdf";
							  }
							else
									$data1[$id]['facture_url'] = 0;
						 }
					}

				}
			else
				{	$to_update =0;
					$this->db->select('facture_code');
					$this->db->from('payments');
					$this->db->where('facture_code', $value['nrFaktury']);
					
					foreach($this->db->get()->result() as $item)
					{	
						$to_update = 1;
					}
					if($to_update == 1)
					{	
						if($value['idFaktury'])
							$data2[$id]['id_facture']=$value['idFaktury'];
						else
							$data2[$id]['id_facture']="";
									
						if($value['IdPlatnik'])
							$data2[$id]['id_client']=$value['IdPlatnik'];
						else
							$data2[$id]['id_client']="";
						if($value['nrFaktury'])
							$data2[$id]['facture_code']=$value['nrFaktury'];
						else
							$data2[$id]['facture_code']="";
						if($value['nrZamowienie'])
							$data2[$id]['id_order']=$value['nrZamowienie'];
						else
							$data2[$id]['id_order']="";
						if($value['WartoscNetto'])			
							$data2[$id]['amount']=str_replace(',','.',$value['WartoscNetto']);
						else
							$data2[$id]['amount']="";
						if($value['WartoscBrutto'])
							$data2[$id]['amount_b']=str_replace(',','.',$value['WartoscBrutto']);
						else
							$data2[$id]['amount_b']="";
						//$data[$id]['url_facture']=$value['url_facture'];
						if($value['DataWystawienia'])
							$data2[$id]['date']=$value['DataWystawienia'];
						else
							$data2[$id]['date']="";
						if($value['TerminPlatnosci'])
							$data2[$id]['deadline']=$value['TerminPlatnosci'];
						else
							$data2[$id]['deadline']="";
						 if($value['pdf'])
						 {	
							 if(file_put_contents(($url.$value['idFaktury'].".pdf"), base64_decode($value['pdf'])))
							 {
								  $v=(string)$value['idFaktury'];
								  $data2[$id]['facture_url'] = $v.".pdf";
							 }
							else
								$data2[$id]['facture_url'] = 0;
						 }
					}
					else
					{	$data[$id]['create_date']=date("Y-m-d H:i:s");
						if($value['idFaktury'])
							$data[$id]['id_facture']=$value['idFaktury'];
						else
							$data[$id]['id_facture']="";
									
						if($value['IdPlatnik'])
							$data[$id]['id_client']=$value['IdPlatnik'];
						else
							$data[$id]['id_client']="";
						if($value['nrFaktury'])
							$data[$id]['facture_code']=$value['nrFaktury'];
						else
							$data[$id]['facture_code']="";
						if($value['nrZamowienie'])
							$data[$id]['id_order']=$value['nrZamowienie'];
						else
							$data[$id]['id_order']="";
						if($value['WartoscNetto'])			
							$data[$id]['amount']=str_replace(',','.',$value['WartoscNetto']);
						else
							$data[$id]['amount']="";
						if($value['WartoscBrutto'])
							$data[$id]['amount_b']=str_replace(',','.',$value['WartoscBrutto']);
						else
							$data[$id]['amount_b']="";
						//$data[$id]['url_facture']=$value['url_facture'];
						if($value['DataWystawienia'])
							$data[$id]['date']=$value['DataWystawienia'];
						else
							$data[$id]['date']="";
						if($value['TerminPlatnosci'])
							$data[$id]['deadline']=$value['TerminPlatnosci'];
						else
							$data[$id]['deadline']="";
						 if($value['pdf'])
						 {	
							 if(file_put_contents(($url.$value['idFaktury'].".pdf"), base64_decode($value['pdf'])))
							 {
								  $v=(string)$value['idFaktury'];
								  $data[$id]['facture_url'] = $v.".pdf";
							 }
							else
								$data[$id]['facture_url'] = 0;
						 }
					}
				 }
				
			}
			//data faktury nowe
			//data1 korekty nowe
			//data2 faktury update
			//data3 korekty nowe
			$tab[0] = $data;
			$tab[1] = $data1;
			$tab[2] = $data2;
			$tab[3] = $data3;
			return $tab;
	}
	public function importPayments($post=array(),$id_list)
	{		
		$a=1;$b=1;
		$url=$_SERVER['DOCUMENT_ROOT'].substr($_SERVER['SCRIPT_NAME'],0,-9)."/uploads/factures/";
		if(isset($post['invoice']['idFaktury']))
			$data = $this->importPaymentsOne($post,$url);
		else
			$data = $this->importPaymentsMore($post,$url);
		if(count($data[0]) >0 )
			{
			 $this->db->insert_batch('payments', $data[0]); 
			 if($this->db->affected_rows() > 0) $a =1; else  $a = 0;		
			foreach($data[0] as $k=>$v)
				{
				$data[0][$k]['id_list'] = $id_list;	
				}
				$this->db->insert_batch('import_payments', $data[0]); 
			}
		if(count($data[2]) >0 )
			{
			 $this->db->update_batch('payments', $data[2],'facture_code'); 
			 if($a == 0)
				if($this->db->affected_rows() > 0) $a =1; else  $a = 0;		
			foreach($data[2] as $k=>$v)
				{
				$data[2][$k]['id_list'] = $id_list;	
				}
				$this->db->insert_batch('import_payments', $data[2]); 
			}
		if(count($data[1]) > 0 )
			{
			$this->db->insert_batch('corrections', $data[1]);
			if($a == 0)
				if($this->db->affected_rows() > 0) $a =1; else  $a = 0;
			foreach($data[1] as $k=>$v)
				{
				$data[1][$k]['id_list'] = $id_list;	
				}
				$this->db->insert_batch('import_corrections', $data[1]); 
			}
		if(count($data[3]) > 0 )
			{
			$this->db->update_batch('corrections', $data[3],'id_facture');
			if($a == 0)
				if($this->db->affected_rows() > 0) $a =1; else  $a = 0;
			foreach($data[3] as $k=>$v)
				{
				$data[3][$k]['id_list'] = $id_list;	
				}
				$this->db->insert_batch('import_corrections', $data[3]); 
			}
		if($a == 1 && $b == 1)
			return 1;
		else return 0;
	}
	public function getPaymentsByClient($id_client=0,$is_paid =0)
	{		$list=array();
			$this->db->select('p.*, o.date as order_date');
			$this->db->from('payments as p');
			$this->db->join('orders as o', 'o.id_order = p.id_order','left');
			$this->db->where('p.id_client', $id_client);
			$where = "p.id_client =".$id_client;
			$this->db->order_by('p.date','desc');
			$this->db->order_by('p.id_payment','desc');
			$this->db->group_by('p.id_facture');
			if($is_paid == 0)
			{
				$where .= " and p.id_status = 1 and p.amount_b > p.paid";
			}
			else
			{	$t1 = strtotime(date("Y-m-d")) - 15552000;
				$t2 = date("Y-m-d", $t1);
				$where .= " and (p.id_status = 2 or p.amount_b <= p.paid) and p.date > '".$t2."'";
							
				$this->db->limit(10);
			}
			$this->db->where($where);	
			$fields = $this->db->list_fields('payments');
			foreach($this->db->get()->result() as $item)
			{	
				foreach ($fields as $field)
					{
					$list[$item->id_payment][$field]=$item->$field;
					}
					$list[$item->id_payment]['order_date']=$item->order_date;
			}	
			return $list;
	}
	public function getCorrectionsByClient($id_client=0,$factures)
	{		
			foreach($factures as $id_facture=>$fac)
						{
						$tab[$fac['id_facture']]=$fac['id_facture'];
						}
			$list=array();
			if(isset($tab))
			{
			
			$this->db->select('c.id_facture as id_cor, cs.id_facture as id_fac, cs.facture_code, c.amount_b,c.date,c.deadline, c.facture_url');
			$this->db->from('corrections as c');
			$this->db->join('corrections_settl as cs', 'c.facture_code = cs.facture_code','left');
			$where = "c.id_client =".$id_client;
			
			$where .= " and cs.id_facture in (".implode(",",$tab).")";
						
			
			$this->db->where($where);	
			foreach($this->db->get()->result() as $item)
				{	
			
					$list[$item->id_fac][$item->id_cor]['facture_code']=$item->facture_code;
					$list[$item->id_fac][$item->id_cor]['amount_b']=$item->amount_b;
					$list[$item->id_fac][$item->id_cor]['date']=$item->date;
					$list[$item->id_fac][$item->id_cor]['deadline']=$item->deadline;
					$list[$item->id_fac][$item->id_cor]['facture_url']=$item->facture_url;
				}	
			}
			return $list;
	}
	public function getPaymentMaxNotPaid($id_client=0)
	{		$list=array();
			$this->db->select('min(deadline) as deadline');
			$this->db->from('payments as p');
			$this->db->where('p.id_client = '.$id_client.' and p.paid < p.amount_b');
			foreach($this->db->get()->result() as $item)
			{	 
					$deadline=$item->deadline;
			}	
			return $deadline;
	}
	public function countPayments($id_client=0){
		$this->db->select('id_payment');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_client', $id_client);
		return $this->db->count_all_results('payments');
			
	}
	public function sumPaymentsToPay($id_client=0){
		$this->db->select('id_facture,amount_b,paid');
		$this->db->from('payments');
		$this->db->where('id_client = '.$id_client.' and paid < amount_b');
		$this->db->group_by('id_facture');
		$paid=0;$amount_b =0;
		foreach($this->db->get()->result() as $item)
			{	 
					$paid+=$item->paid;
					$amount_b+=$item->amount_b;
					
			}	
			return $amount_b-$paid;
			
	}
	
}