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
 
	
	 public function importClients($post=array())
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
				if(!is_array($value['adr_Adres']));
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
		$a=1;$b=1;
		if(isset($data_update))
			$a=$this->db->update_batch('clients', $data_update, 'id_client'); 
		if(isset($data_insert))
			$b=$this->db->insert_batch('clients', $data_insert); 
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
		$tab['date_upd']=date("Y-m-d H:i:s");
		$this->db->where('id_client ',$id);
		return $this->db->update('clients',$tab); 		
	}
	
}