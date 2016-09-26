<?php 

class Contractsmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('access');
    }
	
	public function addProduct($post=array(),$id_contract=0)
	{	
		$this->db->select('id_contract');
		$this->db->from('contracts_products');
		$this->db->where('id_contract', $id_contract);
		$this->db->where('id_product', $post['id_product']);	
		$this->db->where('id_status',1);	
		$result=$this->db->get()->result();
		if(count($result) > 0)
			{
				$tab['msg_val']='Produkt jest już dodany do definiwoanego kontraktu';
				$tab['msg']=2;
				return $tab;
			}
			
		$data['id_contract']=$id_contract;
		$data['id_product']=$post['id_product'];
		$data['amount']=$post['amount'];
		$data['amount_left']=$post['amount'];
		$data['price']=str_replace(",",".",$post['price']);
		return $this->db->insert('contracts_products', $data); 
		
	}
	
	public function addContract($id_user=0,$id_client=0)
	{	
		$this->db->select('id_contract');
		$this->db->from('contracts');
		$this->db->where('id_client', $id_client);
		$this->db->where('id_status', 99);	
		foreach($this->db->get()->result() as $item)
		{	
			$this->db->where('id_contract', $item->id_contract);		
			$this->db->delete('contracts_products');
		}	
		$this->db->where('id_client', $id_client);
		$this->db->where('id_status', 99);		
		$this->db->delete('contracts');
		
		$data['id_user']=$id_user;
		$data['id_client']=$id_client;
		$this->db->insert('contracts', $data); 
		$this->db->select_max('id_contract');
		$this->db->from('contracts');
		$this->db->where('id_user',$id_user);
		$this->db->where('id_client',$id_client);
		foreach($this->db->get()->result() as $item)
		{	
			return $item->id_contract;
		}	
	}
	public function getContract($id_contract=0)
	{	$list= array();
		$this->db->select('*');
		$this->db->from('contracts');
		$this->db->where('id_contract', $id_contract);
		$this->db->where('id_status !=', 0);	
		$fields = $this->db->list_fields('contracts');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function editProduct($post)
	{
		$this->db->where('id', $post['id_product']);	
		$data['amount'] = $post['amount'];
		$data['amount_left'] = $post['amount_left'];
		$data['price'] = $post['price'];
		return $this->db->update('contracts_products',$data);
	}
	public function setAmount($amount,$id)
	{
		$this->db->where('id', $id);	
		$data['amount_left'] = $amount;
		return $this->db->update('contracts_products',$data);
	}
	public function delProduct($id=0)
	{
		$this->db->where('id', $id);		
		$this->db->delete('contracts_products');
	}
	public function getProductsForClient($id_client=0)
	{	$list = array();
		$fields = $this->db->list_fields('contracts_products');
		$query = $this->db->query('Select cp.id,cp.id_product,cp.id_contract,cp.amount,cp.amount_left,cp.price,cp.id_status from contracts_products as cp LEFT JOIN contracts  as c ON c.id_contract=cp.id_contract where cp.id_status = 1 and c.id_status = 1 and c.id_client ='.$id_client);
		foreach($query->result() as $item)
		{	
			foreach ($fields as $field)
							{
							$list[$item->id_product][$item->id][$field]=$item->$field;
							}
		}
		return $list;
	}
	public function getProductsList($id_contract=0)
	{	$list = array();
		$fields = $this->db->list_fields('contracts_products');
		$query = $this->db->query('Select cp.id,cp.id_product,cp.id_contract,cp.amount,cp.amount_left,cp.price,cp.id_status,p.name from contracts_products as cp LEFT JOIN products  as p ON p.id_product=cp.id_product where cp.id_status != 0 and cp.amount_left > 0 and cp.id_contract ='.$id_contract);
		foreach($query->result() as $item)
		{	
			foreach ($fields as $field)
							{
							$list[$item->id][$field]=$item->$field;
							}
							$list[$item->id]['name']=$item->name;
		}
		return $list;
	}
	public function getProductsListForInfo($id_contract=0)
	{	$list = array();
		$fields = $this->db->list_fields('contracts_products');
		$query = $this->db->query('Select cp.id,cp.id_product,cp.id_contract,cp.amount,cp.amount_left,cp.price,cp.id_status,p.name from contracts_products as cp LEFT JOIN products  as p ON p.id_product=cp.id_product where cp.id_status != 0 and cp.id_contract ='.$id_contract);
		foreach($query->result() as $item)
		{	
			foreach ($fields as $field)
							{
							$list[$item->id][$field]=$item->$field;
							}
							$list[$item->id]['name']=$item->name;
		}
		return $list;
	}
	public function getProductsLists($contracts)
	{	$list = array();
		$i=0;
		foreach($contracts as $id_contract=>$contract)
			  {$where_in[$i]=$id_contract;$i++;}
		if(isset($where_in))
		{
		$fields = $this->db->list_fields('contracts_products');
		$this->db->select('cp.*, p.name, p.vat');
		$this->db->from('contracts_products as cp');
		$this->db->join('products as p', 'p.id_product = cp.id_product', 'left');
		$this->db->where_in('id_contract', $where_in);
		$this->db->where('cp.id_status !=', 0);	
		
		foreach($this->db->get()->result() as $item)
		{	
			foreach ($fields as $field)
							{
							$list[$item->id_contract][$item->id][$field]=$item->$field;
							}
							$list[$item->id_contract][$item->id]['name']=$item->name;
							$list[$item->id_contract][$item->id]['vat']=$item->vat;
		}
		}
		return $list;
	}
	
	public function save($data=array())
	{
		$tab['id_status']=1;
		if($data['name']=="")
			$tab['name']="Kontrakt z dnia: ".date("Y-m-d");
		else
			$tab['name']=$data['name'];
		$tab['date_availability']=$data['date_availability'];	
		$tab['date_set']=date("Y-m-d");
		$this->db->where('id_contract ',$data['id_contract']);
		return $this->db->update('contracts',$tab); 		
	}
	public function getByStatus($id_status=1,$id_client=0)
	{
		$this->db->select('*');
		$this->db->from('contracts');
		//$this->db->where('id_client', $id_client);
		//$this->db->where('id_status !=',0);
		$where = "(id_client =".$id_client." and id_status != 0) ";
		if($id_status == 1)
		{	$where .= "and ( id_status =".$id_status." and (date_availability >='".date("Y-m-d")."' or  date_availability ='0000-00-00'))";
			// $this->db->where('id_status',$id_status);
			// $this->db->where('date_availability >',date("Y-m-d"));
			// $this->db->or_where('date_availability =',"0000-00-00");
			
		}
		if($id_status == 2)
		{	$where .= "and (id_status =".$id_status." or (date_availability <='".date("Y-m-d")."' and  date_availability !='0000-00-00'))";
			// $this->db->where('date_availability <',date("Y-m-d"));
			// $this->db->where('date_availability !=',"0000-00-00");
			// $this->db->or_where('id_status',$id_status);
		}
		$this->db->where($where);
		$list = array();
		$fields = $this->db->list_fields('contracts');
		foreach($this->db->get()->result() as $item)
		{	
			foreach ($fields as $field)
				{
				$list[$item->id_contract][$field]=$item->$field;
				}
		}			
		return $list;
	}
	public function deleteContract($id=0)
	{	$data['id_status'] = 0;	
		$this->db->where('id_contract',$id);
		return $this->db->update("contracts",$data); 	
	}
	
	
}