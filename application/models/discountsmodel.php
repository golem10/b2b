<?php 

class Discountsmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('access');
    }
 
	public function getListForUser($id_client=0)
	{
		$this->db->select('d.*, c.name as c_name, c.img as c_img');
		$this->db->from('discounts as d');
		$this->db->join('discounts_groups as dg', 'd.id_discount = dg.id_discount', 'left');
		$this->db->join('groups_clients as gc', 'gc.id_group = dg.id_group', 'left');
		$this->db->join('products_categories as c', 'c.id_category = d.id_category', 'left');
		$this->db->where('gc.id_client ', $id_client);
		$this->db->where('d.id_status', 1);
		$list = array();
		$fields = $this->db->list_fields('discounts');
		foreach($this->db->get()->result() as $item)
		{		
				foreach ($fields as $field)
							{
							$list[$item->id_discount][$field]=$item->$field;
							}
							$list[$item->id_discount]['c_img']=$item->c_img;
							$list[$item->id_discount]['c_name']=$item->c_name;
							
		}	
		return $list;
	}
	
	
	public function getList()
	{
		$this->db->select('*');
		$this->db->from('discounts');
		$this->db->where('id_status !=', 0);
		$list = array();
		$fields = $this->db->list_fields('discounts');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_discount][$field]=$item->$field;
							}
		}	
		return $list;
	}
	
	
	public function getDiscountsById($data=array())
	{
		$this->db->select('*');		
		$this->db->from('discounts');
		$this->db->where('id_status !=', 0);
		$this->db->where_in('id_discount',$data);
		$list = array();
		$fields = $this->db->list_fields('discounts');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_discount][$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function getById($id=0)
	{
		$this->db->select('*');
		$this->db->from('discounts');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_discount', $id);
		$list = array();
		$fields = $this->db->list_fields('discounts');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
		}	
		return $list;
	}
	
	public function getGroupsWithDiscount($id=NULL)
	{
		$this->db->select('*');
		$this->db->from('groups');
		$this->db->where('id_status !=', 0);
		$list = array();
		$fields = $this->db->list_fields('groups');
		foreach($this->db->get()->result() as $item)
		{
			foreach ($fields as $field)
			{
				$list[$item->id_group][$field]=$item->$field;
			}
		}
		
		$this->db->select('id_group');
		$this->db->from('discounts_groups');
		$this->db->where('id_discount', $id);
		$groups = $this->db->get()->result_array();
		$groups_ids = array();
		
		foreach($groups as $g){
			$groups_ids[] = $g['id_group'];
		}
		
		foreach($list as $k => $l){
			in_array($k, $groups_ids) ? $list[$k]['checked'] = 1 : $list[$k]['checked'] = 0;
		}
		
		return $list;
	}
	
	public function getCategories()
	{
		$this->db->select('*');
		$this->db->from('products_categories');
		$this->db->where('id_status !=', 0);
		$list = array();
		$fields = $this->db->list_fields('products_categories');
		foreach($this->db->get()->result() as $item)
		{	
			foreach ($fields as $field)
			{
				$list[$item->id_category][$field]=$item->$field;
			}
		}	
		return $list;
	}
	
	public function getPositions($id=NULL)
	{
		$this->db->select('*');
		$this->db->from('discounts_positions');
		$this->db->where('id_discount', $id);
		$list = array();
		$fields = $this->db->list_fields('discounts_positions');
		foreach($this->db->get()->result() as $item)
		{	
			foreach ($fields as $field)
			{
				$list[$item->id_position][$field]=$item->$field;
			}
		}	
		return $list;
	}
	
	public function checkNameIsUnique($name, $id){
		if($id){
			$this->db->select('*');
			$this->db->from('discounts');
			$this->db->where('id_discount', $id);
			$this->db->where('name', $name);
			if($this->db->count_all_results() == 1) return true;
		}
		
		$this->db->select('*');
		$this->db->from('discounts');
		$this->db->where('name', $name);
		if($this->db->count_all_results() == 1) return false;
		
		return true;
	}
	
	public function addOrUpdateDiscount($discount, $id){
		if($id){
			$this->db->where('id_discount', $id);
			$this->db->update('discounts', $discount);
			return $id;
		} else {
			$this->db->insert('discounts', $discount);
			return $this->db->insert_id();
		}
	}
	
	public function assignGroupsToDiscount($groups, $id_discount){
		$this->db->delete('discounts_groups', array('id_discount' => $id_discount));
		foreach($groups as $g){
			$this->db->insert('discounts_groups', array('id_discount' => $id_discount, 'id_group' => $g));
		}
	}
	
	public function assignPositionsToDiscount($positions, $id_discount){
		$this->db->delete('discounts_positions', array('id_discount' => $id_discount));
		foreach($positions as $p){
			$this->db->insert('discounts_positions', array('id_discount' => $id_discount, 'amount' => $p['amount'], 'discount' => $p['discount']));
		}
	}
	
	public function getPositionsOfDiscount($id=0)
	{
		$this->db->select('*');
		$this->db->from('discounts_positions');
		$this->db->where('id_discount', $id);
		$list = array();
		$fields = $this->db->list_fields('discounts');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function delete($id_discount)
	{
		$dane['id_status'] = 0;
		$this->db->where('id_discount',$id_discount);
		$this->db->update("discounts",$dane);
	}
	public function deleteGroup($id_group)
	{
		$dane['id_status'] = 0;
		$this->db->where('id_group',$id_group);
		$this->db->update("groups",$dane);
	}
	public function getDiscountsGroupsAll()
	{	$this->db->select('*');
		$this->db->from('products_discounts_groups');
		$list=array();
		foreach($this->db->get()->result() as $item)
		{	
							$list[$item->id_discount_group]['name']=$item->name;														
		}	
		return $list;
	}
	public function getDiscountsGroupsValues($id_client=0)
	{	$this->db->select('*');
		$this->db->from('products_discounts_groups_clients');
		$this->db->where('id_client',$id_client);
		$list=array();
		foreach($this->db->get()->result() as $item)
		{	
							$list[$item->id_discount_group]['value']=$item->value;														
		}	
		return $list;
	}
	public function setValuesForDiscountsGroups($post=array(),$id_client=0)
	{
		$this->db->where('id_client',$id_client);
		$this->db->delete('products_discounts_groups_clients');
		foreach($post as $k=>$v)
		{
			$id = explode("_",$k);
			$data[$id[3]]["id_discount_group"] = $id[3];
			$data[$id[3]]["value"] = $v;
			$data[$id[3]]["id_client"] = $id_client;
		}
		$this->db->insert_batch('products_discounts_groups_clients', $data); 
		return 1;

	}

	
}