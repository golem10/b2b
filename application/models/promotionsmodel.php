<?php 

class Promotionsmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('access');
		$this->load->model('productsmodel','products');
    }
 
	
	public function getList()
	{
		$this->db->select('*');
		$this->db->from('promotions');
		$this->db->where('id_status !=', 0);
		$list = array();
		$fields = $this->db->list_fields('promotions');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_promotion][$field]=$item->$field;
							}
		}	
		return $list;
	}
	
	public function getListForUser($id_client=0)
	{
	
		$user_tab['id_user'] = $this->session->userdata('id_user');
		if($user_tab)
			$access_data=$this->products->getUserAccess($user_tab);
		else {
			$access_data['categories'] = array();
			$access_data['products'] = array(); }
			
		$this->db->select('p.*, pd.date_from,pd.date_to,prod.id_category');
		$this->db->from('promotions as p');
		$this->db->join('promotions_groups as pg', 'p.id_promotion = pg.id_promotion', 'left');
		$this->db->join('products as prod', 'prod.id_product = p.id_product', 'left');
		$this->db->join('groups_clients as gc', 'gc.id_group = pg.id_group', 'left');
		$this->db->join('promotions_dates as pd', 'p.id_promotion = pd.id_promotion', 'left');
		$where = 'gc.id_client = '.$id_client." and p.id_status = 1 and ((pd.date_from <= '".date("Y-m-d")."' and pd.date_to >= '".date("Y-m-d")."') or (pd.date_from is null and pd.date_to is null))";
		$this->db->where($where);
		// $this->db->where('gc.id_client ', $id_client);
		// $this->db->where('p.id_status ', 1);
		// $this->db->where('pd.date_from <=', date("Y-m-d"));
		// $this->db->where('pd.date_to >=', date("Y-m-d"));
		$list = array();
		$fields = $this->db->list_fields('promotions');
		
		foreach($this->db->get()->result() as $item)
		{		
			$no_access = 0;
			 if(count($access_data['products']) > 0)
				{
				 if(!isset($access_data['products'][$item->id_product]))
					 $no_access = 1;
			 }

			 if(count($access_data['categories']) > 0)
			 {
				 if(!isset($access_data['categories'][$item->id_category]))
					$no_access = 1;
			 }
			if($no_access == 0)
			foreach ($fields as $field)
						{
						$list[$item->id_promotion][$field]=$item->$field;
						}						
		}	
		
		return $list;
	}
	
	public function getPromotionsById($data=array())
	{
		$this->db->select('*');		
		$this->db->from('promotions');
		$this->db->where('id_status !=', 0);
		$this->db->where_in('id_promotion',$data);
		$list = array();
		$fields = $this->db->list_fields('promotions');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_promotion][$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function getById($id=0)
	{
		$this->db->select('*');
		$this->db->from('promotions');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_promotion', $id);
		$list = array();
		$fields = $this->db->list_fields('promotions');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
		}	
		return $list;
	}
	
	public function getGroupsWithPromotion($id=NULL)
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
		$this->db->from('promotions_groups');
		$this->db->where('id_promotion', $id);
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
		$this->db->from('promotions_positions');
		$this->db->where('id_promotion', $id);
		$list = array();
		$fields = $this->db->list_fields('promotions_positions');
		foreach($this->db->get()->result() as $item)
		{	
			foreach ($fields as $field)
			{
				$list[$item->id_position][$field]=$item->$field;
			}
		}	
		return $list;
	}
	public function getGratises($id=NULL)
	{
		$this->db->select('*');
		$this->db->from('promotions_gratises');
		$this->db->where('id_promotion', $id);
		$list = array();
		$fields = $this->db->list_fields('promotions_gratises');
		foreach($this->db->get()->result() as $item)
		{	
			foreach ($fields as $field)
			{
				$list[$item->id_gratis][$field]=$item->$field;
			}
		}	
		return $list;
	}
	public function getDates($id=NULL)
	{
		$this->db->select('*');
		$this->db->from('promotions_dates');
		$this->db->where('id_promotion', $id);
		$list = array();
		$fields = $this->db->list_fields('promotions_dates');
		foreach($this->db->get()->result() as $item)
		{	
			foreach ($fields as $field)
			{
				$list[$field]=$item->$field;
			}
		}	
		return $list;
	}
	public function checkNameIsUnique($name, $id){
		if($id){
			$this->db->select('*');
			$this->db->from('promotions');
			$this->db->where('id_promotion', $id);
			$this->db->where('name', $name);
			if($this->db->count_all_results() == 1) return true;
		}
		
		$this->db->select('*');
		$this->db->from('promotions');
		$this->db->where('name', $name);
		if($this->db->count_all_results() == 1) return false;
		
		return true;
	}
	
	public function addOrUpdatePromotion($promotion, $id){
		if($id){
			$this->db->where('id_promotion', $id);
			$this->db->update('promotions', $promotion);
			return $id;
		} else {
			$this->db->insert('promotions', $promotion); 		
			return $this->db->insert_id();
		}
	}
	
	public function assignGroupsToPromotion($groups, $id_promotion){
		$this->db->delete('promotions_groups', array('id_promotion' => $id_promotion));
		foreach($groups as $g){
			$this->db->insert('promotions_groups', array('id_promotion' => $id_promotion, 'id_group' => $g));
		}
	}
	
	public function assignPositionsToPromotion($positions, $id_promotion){
		$this->db->delete('promotions_positions', array('id_promotion' => $id_promotion));
		foreach($positions as $p){
			$this->db->insert('promotions_positions', array('id_promotion' => $id_promotion, 'amount' => $p['amount'], 'discount' => str_replace(",",".",$p['discount'])));
		}
	}
	public function assignDateToPromotion($info, $id_promotion)
	{		$this->db->delete('promotions_dates', array('id_promotion' => $id_promotion));
			$this->db->insert('promotions_dates',array('id_promotion' => $id_promotion, 'date_from' => $info['date_from'], 'date_to' => $info['date_to'], 'price' => $info['price']));
	}
	public function assignGratisToPromotion($positions, $id_promotion){
		$this->db->delete('promotions_gratises', array('id_promotion' => $id_promotion));
		foreach($positions as $p){
			$this->db->insert('promotions_gratises', array('id_promotion' => $id_promotion, 'amount' => $p['amount'], 'gratis' => $p['gratis']));
		}
	}
	
	public function getPositionsOfPromotion($id=0)
	{
		$this->db->select('*');
		$this->db->from('promotions_positions');
		$this->db->where('id_promotion', $id);
		$list = array();
		$fields = $this->db->list_fields('promotions');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
		}
		return $list;
	}
	public function changeactive($id_promotion)
	{
		$this->db->select('id_status');
		$this->db->from("promotions");
		$this->db->where('id_promotion',$id_promotion);
		foreach($this->db->get()->result() as $item)
		{if($item->id_status == 1)
				$dane['id_status'] = 2;
		else
			$dane['id_status'] = 1;
		}
		$this->db->where('id_promotion',$id_promotion);
		$this->db->update("promotions",$dane);
	}
	
	public function delete($id_promotion)
	{
		$dane['id_status'] = 0;
		$this->db->where('id_promotion',$id_promotion);
		$this->db->update("promotions",$dane);
	}
	
	public function updateSettings($id=0,$data=array())
	{
		// $tab['inquiry']=$data['inquiry'];
		// $tab['loyalty']=$data['loyalty'];
		// $tab['limit_amount']=$data['amount'];
		// $tab['limit_facture']=$data['amount_facture'];	
		// $tab['date_upd']=date("Y-m-d H:i:s");
		// $this->db->where('id_client ',$id);
		// return $this->db->update('clients',$tab); 		
	}
	
}