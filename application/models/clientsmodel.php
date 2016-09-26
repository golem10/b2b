<?php 

class Clientsmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('access');
    }
 // migration/
 
	
	 public function importClients($post=array(), $id_list)
	{	//echo "<br/>".count($post['Results_from_Query_x003A__Customers'])."<br/>";
		if(isset($post['Results_from_Query_x003A__Customers']['kh_Id']))
		{
			foreach($post as $id=>$value)
			{ 
				$data[$id]['id_client']=$value['kh_Id'];
				if($value['kh_Symbol'])
					$data[$id]['symbol']=$value['kh_Symbol'];	
				else
					$data[$id]['symbol']="";
				if($value['adr_NazwaPelna'])
					$data[$id]['name']=$value['adr_NazwaPelna'];
				else
					$data[$id]['name']="";
				if($value['adr_Adres'])
					$data[$id]['street']=$value['adr_Adres'];	
				else
					$data[$id]['street']="";
				if($value['adr_Kod'])
					$data[$id]['post_code']=$value['adr_Kod'];	
				else
					$data[$id]['post_code']="";
				if($value['adr_Miejscowosc'])			
					$data[$id]['city']=$value['adr_Miejscowosc'];
				else
					$data[$id]['city']="";
				if($value['adr_Adres'])
					$data[$id]['delivery_street']=$value['adr_Adres'];
				else
					$data[$id]['delivery_street']="";
				if($value['adr_Miejscowosc'])
					$data[$id]['delivery_city']=$value['adr_Miejscowosc'];
				else
					$data[$id]['delivery_city']="";
				if($value['adr_Kod'])
					$data[$id]['delivery_post_code']=$value['adr_Kod'];	
				else
					$data[$id]['delivery_post_code']="";
				if($value['kh_Imie'] && $value['kh_Nazwisko'])
					$data[$id]['name_person']=$value['kh_Imie']." ".$value['kh_Nazwisko'];
				else
					$data[$id]['name_person']="";
				if($value['kh_EMail'])
					$data[$id]['email']=$value['kh_EMail'];
				else
					$data[$id]['email']="";
			//	$data[$id]['nip']=$value['nip'];
				if($value['adr_NIP'])
					$data[$id]['nip']=$value['adr_NIP'];
				else
					$data[$id]['nip']="";
				if($value['adr_Telefon'])
					$data[$id]['phone_number']=$value['adr_Telefon'];
				else
					$data[$id]['phone_number']="";
				$data[$id]['date_upd']=date("Y-m-d H:i:s");
				
				$to_update = 0;
				$this->db->select('id_client');
				$this->db->from('clients');
				$this->db->where('id_client', $value['kh_Id']);
				foreach($this->db->get()->result() as $item)
				{	
					$to_update = 1;
				}
				if($to_update == 1)
					$data_update[$id] = $data[$id];
				else
					$data_insert[$id] = $data[$id];
			}
		}
		else
		{
			foreach($post['Results_from_Query_x003A__Customers'] as $id=>$value)
			{ 
				$data[$id]['id_client']=$value['kh_Id'];
				if($value['kh_Symbol'])
					$data[$id]['symbol']=$value['kh_Symbol'];	
				else
					$data[$id]['symbol']="";
				if($value['adr_NazwaPelna'])
					$data[$id]['name']=$value['adr_NazwaPelna'];
				else
					$data[$id]['name']="";
				if($value['adr_Adres'])
					$data[$id]['street']=$value['adr_Adres'];	
				else
					$data[$id]['street']="";
				if($value['adr_Kod'])
					$data[$id]['post_code']=$value['adr_Kod'];	
				else
					$data[$id]['post_code']="";
				if($value['adr_Miejscowosc'])			
					$data[$id]['city']=$value['adr_Miejscowosc'];
				else
					$data[$id]['city']="";
				if($value['adr_Adres'])
					$data[$id]['delivery_street']=$value['adr_Adres'];
				else
					$data[$id]['delivery_street']="";
				if($value['adr_Miejscowosc'])
					$data[$id]['delivery_city']=$value['adr_Miejscowosc'];
				else
					$data[$id]['delivery_city']="";
				if($value['adr_Kod'])
					$data[$id]['delivery_post_code']=$value['adr_Kod'];	
				else
					$data[$id]['delivery_post_code']="";
				if($value['kh_Imie'] && $value['kh_Nazwisko'])
					$data[$id]['name_person']=$value['kh_Imie']." ".$value['kh_Nazwisko'];
				else
					$data[$id]['name_person']="";
				if($value['kh_EMail'])
					$data[$id]['email']=$value['kh_EMail'];
				else
					$data[$id]['email']="";
			//	$data[$id]['nip']=$value['nip'];
				if($value['adr_NIP'])
					$data[$id]['nip']=$value['adr_NIP'];
				else
					$data[$id]['nip']="";
				if($value['adr_Telefon'])
					$data[$id]['phone_number']=$value['adr_Telefon'];
				else
					$data[$id]['phone_number']="";
				$data[$id]['date_upd']=date("Y-m-d H:i:s");
				
				$to_update = 0;
				$this->db->select('id_client');
				$this->db->from('clients');
				$this->db->where('id_client', $value['kh_Id']);
				foreach($this->db->get()->result() as $item)
				{	
					$to_update = 1;
				}
				if($to_update == 1)
					$data_update[$id] = $data[$id];
				else
					$data_insert[$id] = $data[$id];
			}
		}
		$a=1;$b=1;
		$array_hist = array();
		
		
		if(isset($data_update))
			{
			$this->db->update_batch('clients', $data_update, 'id_client'); 
			$array_hist = array_merge($array_hist, $data_update);
			if($this->db->affected_rows() > 0) $a =1; else  $a = 0;
			}
		if(isset($data_insert))
			{
			$this->db->insert_batch('clients', $data_insert); 
			$array_hist = array_merge($array_hist, $data_insert);
			if($this->db->affected_rows() > 0) $b=1; else  $b = 0;
			}
		if(count($array_hist))
			{
			foreach($array_hist as $k=>$v)
				{
				$array_hist[$k]['id_import'] = $id_list;	
				}
			$this->db->insert_batch('import_clients',$array_hist);
			
			}
		if($a == 1 && $b == 1)
			return 1;
		else return 0;
	}
	
	public function updateClients($post=array())
	{
		foreach($post as $id=>$value)
		{
			$data[$id]['id_client']=$value['id_client'];
			$data[$id]['name']=$value['name'];
			$data[$id]['street']=$value['street'];
			$data[$id]['city']=$value['city'];
			$data[$id]['delivery_street']=$value['delivery_street'];
			$data[$id]['delivery_city']=$value['delivery_city'];
			$data[$id]['name_person']=$value['name_person'];
			$data[$id]['email']=$value['email'];
			$data[$id]['nip']=$value['nip'];
			$data[$id]['phone_number']=$value['phone_number'];
			$data[$id]['date_upd']=date("Y-m-d H:i:s");
		}
		$this->db->update_batch('clients', $data, 'id_client'); 
	}
 //end of migration
	public function getClientsImportDetails($id_client=0)
	{	$this->db->select('ip.*, il.time_start');
		$this->db->from('import_clients ip');
		$this->db->join('import_list as il', 'il.id_import = ip.id_import', 'left');
		$this->db->where('id_client', $id_client);
		$fields = $this->db->list_fields('import_clients');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id][$field]=$item->$field;
							}
							$list[$item->id]['date']=$item->time_start;
		}	
		return $list;
	}
	public function getLimitsForClient($id_client=0)
	{
		$this->db->select('limit_amount,limit_facture');
		$this->db->from('clients');
		$this->db->where('id_client', $id_client);
		$list = array();
		foreach($this->db->get()->result() as $item)
		{	
				$list['limit_amount']=$item->limit_amount;
				$list['limit_facture']=$item->limit_facture;

		}	
		return $list;
	}
	public function getList()
	{
		$this->db->select('*');
		$this->db->from('clients');
		$this->db->where('id_status !=', 0);
		$this->db->order_by('name', 'asc');
		$list = array();
		$fields = $this->db->list_fields('clients');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_client][$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function getListForFixedPrice($fixed_price)
	{
		$this->db->select('*');
		$this->db->from('clients');
		$this->db->where('id_status !=', 0);
		$this->db->where_in('id_client', $fixed_price['clients']);
		$this->db->order_by('name', 'asc');
		$list = array();
		$fields = $this->db->list_fields('clients');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_client][$field]=$item->$field;
							}
		}	
		return $list;
	}
        public function getClientsCount()
	{
		$this->db->select('count(*) as clientsCount');
		$this->db->from('clients');
        	foreach($this->db->get()->result() as $row)
                {
                    $tmp=$row->clientsCount;
                }
		return $tmp;
	}
	public function getClientsById($data=array())
	{
		$this->db->select('*');		
		$this->db->from('clients');
		$this->db->where('id_status !=', 0);
		$this->db->where_in('id_client',$data);
		$list = array();
		$fields = $this->db->list_fields('clients');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_client][$field]=$item->$field;
							}
		}	
		return $list;
	}
	
	public function getById($id=0)
	{
		$this->db->select('*');
		$this->db->from('clients');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_client', $id);
		$list = array();
		$fields = $this->db->list_fields('clients');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function updateSettings($id=0,$data=array())
	{
		$tab['inquiry']=$data['inquiry'];
		$tab['loyalty']=$data['loyalty'];
		$tab['id_user_system']=$data['id_user_system'];
		$tab['limit_amount']=$data['amount'];
		$tab['limit_facture']=$data['amount_facture'];	
		$tab['accpeted_orders_emails']=$data['accpeted_orders_emails'];	
		$tab['date_upd']=date("Y-m-d H:i:s");
		$this->db->where('id_client ',$id);
		return $this->db->update('clients',$tab); 		
	}
	
	public function delProdAvail($post=array())
	{	
		$this->db->where('id_user', $post['id_user']);
		$this->db->where('id_product', $post['idToDel']);
		 $this->db->delete('users_products_availability');
	}
	public function setClientCategoryAvailability($post=array())
	{	
		$this->db->where('id_user', $post['id_user_product']);
		$this->db->delete('users_categories_availability');
		foreach($post['id_categories'] as $k=>$v)
		{
		$data[$k]['id_category']=$v;
		$data[$k]['id_user']=$post['id_user_product'];
		}
		if($data)
			return $this->db->insert_batch('users_categories_availability', $data); 
		else
			{
			 $this->db->where('id_user', $post['id_user_product']);		
			return $this->db->delete('users_categories_availability');		
			}
	}	
	public function getClientCategoryAvailability($id_user)
	{	
		$this->db->select('ca.id_category, c.name');
		$this->db->from('users_categories_availability as ca');
		$this->db->join('products_categories c', 'ca.id_category = c.id_category', 'left');
		$this->db->where('id_user', $id_user);
		$list = array();
		foreach($this->db->get()->result() as $item)
		{	
			$list[$item->id_category]=$item->name;
		}	
		return $list;
	}
	public function setClientProductsAvailability($post=array())
	{
		// $this->db->where('id_user', $post['id_user_product']);		
		//$this->db->delete('users_products_availability');
		if(count($post['id_products']) > 0)
		{
			foreach($post['id_products'] as $k=>$v)
			{
			$data[$k]['id_product']=$v;
			$data[$k]['id_user']=$post['id_user_product'];
			
			}
			
			return $this->db->insert_batch('users_products_availability', $data); 
		}
	}
	public function getClientProductsAvailability($id_user)
	{	
		$this->db->select('ca.id_product, p.name');
		$this->db->from('users_products_availability as ca');
		$this->db->join('products p', 'ca.id_product = p.id_product', 'left');
		$this->db->where('id_user', $id_user);
		$list = array();
		foreach($this->db->get()->result() as $item)
		{	
			$list[$item->id_product]=$item->name;
		}	
		return $list;
	}
	public function  setStartLoyaltyPointsForClient($id,$points)
	{	
		$data['used_start_loyalty_points']= $points;
		$this->db->where('id_client', $id);
		 $this->db->update('clients',$data);
	}
	public function  setLoyaltyPointsForClient($id,$points)
	{	$data['used_loyalty_points']= $points;
		$this->db->where('id_client', $id);
		 $this->db->update('clients',$data);
	}
	
}