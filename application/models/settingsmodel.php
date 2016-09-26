<?php 

class Settingsmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('access');
    }
	
	
	/// uzyte gdzies wiec tu zostalo...
	public function getLoyalty()
	{
		$this->db->select('*');
		$this->db->from('settings');
		$this->db->where('id', 1);
		$this->db->or_where('id', 2);		
		$fields = $this->db->list_fields('settings');
		foreach($this->db->get()->result() as $item)
		{	
			foreach ($fields as $field)
				{
				$list[$item->id][$field]=$item->$field;
				}
		}	
		return $list;
	}
	public function setLoyalty($post)
	{
		$this->db->where("id",1);
		$this->db->update('settings',array("value"=>$post['loyalty_points']));
		$this->db->where("id",2);
		$this->db->update('settings',array("value"=>$post['loyalty_price']));
		return 1;

	}
	public function getEmail()
	{
		$this->db->select('*');
		$this->db->from('settings');
		$this->db->where('id', 3);		
		$fields = $this->db->list_fields('settings');
		foreach($this->db->get()->result() as $item)
		{	
				$list=$item->value;
		}	
		return $list;
	}
	
}