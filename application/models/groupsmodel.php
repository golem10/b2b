<?php 

class Groupsmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('access');
    }
 
	
	public function getList($type = null)
	{
		$this->db->select('*');
		$this->db->from('groups');
		$this->db->where('id_status !=', 0);
		if($type){
			$this->db->where('type', $type);
		}
		$list = array();
		$fields = $this->db->list_fields('groups');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_group][$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function getGroupsById($data=array())
	{
		$this->db->select('*');		
		$this->db->from('groups');
		$this->db->where('id_status !=', 0);
		$this->db->where_in('id_groups',$data);
		$list = array();
		$fields = $this->db->list_fields('groups');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_group][$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function getById($id=0)
	{
		$this->db->select('*');
		$this->db->from('groups');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_group', $id);
		$list = array();
		$fields = $this->db->list_fields('groups');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function getGroupForClient($id=NULL)
	{
		$this->db->select('id_group');
		$this->db->from('groups_clients');
		$this->db->where('id_client', $id);
		foreach($this->db->get()->result() as $item)
		{
			$tab[$item->id_group]=$item->id_group;
		}
		if(isset($tab))
			return implode(',',$tab);
		else
			return 0;
	}
	public function getClientsWithGroup($id=NULL)
	{
		$this->db->select('*');
		$this->db->from('clients');
		$this->db->where('id_status !=', 0);
                $this->db->order_by("name","asc");
		$list = array();
		$fields = $this->db->list_fields('clients');
		foreach($this->db->get()->result() as $item)
		{
			foreach ($fields as $field)
			{
				$list[$item->id_client][$field]=$item->$field;
			}
		}
		$this->db->select('id_client');
		$this->db->from('groups_clients');
		$this->db->where('id_group', $id);
		$clients = $this->db->get()->result_array();
		$clients_ids = array();
		
		foreach($clients as $c){
			$clients_ids[] = $c['id_client'];
		}
		
		foreach($list as $k => $l){
			in_array($k, $clients_ids) ? $list[$k]['checked'] = 1 : $list[$k]['checked'] = 0;
		}
		
		return $list;
	}
	
	public function checkNameIsUnique($name, $id){
		if($id){
			$this->db->select('*');
			$this->db->from('groups');
			$this->db->where('id_group', $id);
			$this->db->where('name', $name);
			$this->db->where('id_status !=', 0);
			if($this->db->count_all_results() == 1) return true;
		}
		
		$this->db->select('*');
		$this->db->from('groups');
		$this->db->where('name', $name);
		$this->db->where('id_status !=', 0);
		if($this->db->count_all_results() == 1) return false;
		
		return true;
	}
	
	public function addOrUpdateGroup($group, $id){
		if($id){
			$this->db->where('id_group', $id);
			$this->db->update('groups', $group);
			return $id;
		} else {
			$this->db->insert('groups', $group);
			return $this->db->insert_id();
		}
	}
	
	public function assignClientsToGroup($clients, $id_group){
		$this->db->where('id_group', $id_group);
		$this->db->delete('groups_clients');
		foreach($clients as $c){
			$this->db->insert('groups_clients', array('id_group' => $id_group, 'id_client' => $c));
		}
	}
	
	public function updateSettings($id=0,$data=array())
	{
		// $tab['inquiry']=$data['inquiry'];
		// $tab['loyalty']=$data['loyalty'];
		// $tab['limit_amount']=$data['amount'];
		// $tab['limit_facture']=$data['amount_facture'];	
		// $tab['date_upd']=date("Y-m-d H:i:s");
		// $this->db->where('id_group ',$id);
		// return $this->db->update('groups',$tab); 		
	}
	
}