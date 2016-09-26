<?php 

class Raportsmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('access');
    }
 
	public function getList()
	{
		$this->db->select('op.name as op_name,op.price as op_price,SUM(op.amount) as op_amount,c.name as c_name');
		$this->db->from('orders_products as op');
		$this->db->join('orders as o', 'o.id_order = op.id_order', 'left');
		$this->db->join('clients as c', 'c.id_client = o.id_client', 'left');
		$this->db->where('o.id_status !=', 0);
		$this->db->group_by('op_name');
		$this->db->group_by('op_price');
		$this->db->group_by('c_name');
		$list = array();
		$fields = $this->db->list_fields('clients');
		$i=1;
		foreach($this->db->get()->result() as $item)
		{	
			$list[$i]['product_name']= $item->op_name;
			$list[$i]['price']= $item->op_price;
			$list[$i]['amount']= $item->op_amount;
			$list[$i]['client']= $item->c_name;
			$i++;		
		}	
		return $list;
	}
	
	
}