<?php 

class Loyaltymodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('access');
		$this->load->model('clientsmodel','clients');
    }
	
	
	public function getLoyaltyPointsForClient($id_client=0)
	{	$loyalty_points=0;
		$this->db->select_sum('loyalty_points');
		$this->db->from('orders');
		$this->db->where('orders.id_status != ', 0);
		$this->db->where('orders.id_client', $id_client);
		$this->db->join('payments', 'orders.id_order = payments.id_order');
		$this->db->where('payments.paid = payments.amount_b');		
		foreach($this->db->get()->result() as $item)
		{	if($item->loyalty_points)
				$loyalty_points=$item->loyalty_points;
		}	
		$client=$this->clients->getById($id_client);
		$loyalty_points = $loyalty_points - $client['used_loyalty_points'] + $client['used_start_loyalty_points'];
		return $loyalty_points;
	}	
	public function getLoyaltyPointsForClientAll($id_client=0)
	{	$loyalty_points=0;
		$this->db->select_sum('loyalty_points');
		$this->db->from('orders');
		$this->db->where('orders.id_status != ', 0);
		$this->db->where('orders.id_client', $id_client);
		$this->db->join('payments', 'orders.id_order = payments.id_order');
		$this->db->where('payments.paid = payments.amount_b');		
		foreach($this->db->get()->result() as $item)
		{	if($item->loyalty_points)
				$loyalty_points=$item->loyalty_points;
		}	
		return $loyalty_points;
	}
	
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
	public function addReward($post=array())
	{	
		$config['upload_path'] = './uploads/images/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			//return $this->upload->display_errors();
		}
		else
		{
			$data_image= $this->upload->data();
			$data['img']=$data_image['file_name'];
			$configI['image_library'] = 'gd2';
			$configI['source_image']	= './uploads/images/'.$data_image['file_name'];
			$configI['create_thumb'] = TRUE;
			$configI['maintain_ratio'] = TRUE;
			$configI['width']	 = 170;
			$configI['height']	= 220;
			$this->load->library('image_lib', $configI); 
			$this->image_lib->resize();
		}
		$data['name']=trim($post['name']);
		$data['points_value']=trim($post['points_value']);
		$data['description']=trim($post['description']);
		$this->db->insert('loyalty_rewards', $data); 
	}
	public function getRewards()
	{	$list=array();
		$this->db->select('*');
		$this->db->from('loyalty_rewards');
		$this->db->where('id_status', 1);
		$fields = $this->db->list_fields('loyalty_rewards');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_reward][$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function deleteReward($id=0)
	{			
		$data['id_status'] = 0;
		$this->db->where('id_reward',$id);
		return $this->db->update("loyalty_rewards", $data); 
	}	
	
	public function updateReward($post=array())
	{			
		$this->db->where('id_reward',$post['id_reward']);
		return $this->db->update("loyalty_rewards",array('name'=>$post['name'],'description'=>$post['description'],'points_value'=>$post['points_value'])); 
		
	}
}