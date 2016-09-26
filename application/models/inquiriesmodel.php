<?php 

class Inquiriesmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('productsmodel','products');
		$this->load->model('ordersmodel','orders');

		$this->load->model('access');
    }
	public function getInquiriesAll(){
		$this->db->select('*');
		$this->db->from('inquiries');
		$this->db->where('id_status !=', 0);
		$this->db->order_by('id_inquiry', 'desc');
		$list = array();
		$fields = $this->db->list_fields('inquiries');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_inquiry][$field]=$item->$field;
							}
		}
		return $list;
	}
	public function getOffertsAll(){
		$this->db->select('*');
		$this->db->from('offerts');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_status !=', 99);
		$this->db->order_by('id_offer', 'desc');
		$list = array();
		$fields = $this->db->list_fields('offerts');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_offer][$field]=$item->$field;
							}
		}
		return $list;
	}
	public function cancelInquiry($id,$id_user){
		$this->db->where('id_inquiry', $id);
		$this->db->where('id_user', $id_user);
		$data['id_status']=0;
		$this->db->update('inquiries',$data);		

	}
	
	public function countInquiries($id_user=0){
		$this->db->select('id_inqury');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_status !=', 3);
		$this->db->where('id_user', $id_user);
		return $this->db->count_all_results('inquiries');
			
	}
	public function getInquiryById($id){
		$this->db->select('*');
		$this->db->from('inquiries');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_inquiry', $id);

		$list = array();
		$fields = $this->db->list_fields('inquiries');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
		}
		return $list;
		
	}
	public function getProductsPrices($id_client=0,$products=array())
	{
		$list = array();
		$tab_temp = array();
		foreach($products as $k=>$v)
			{$tab_temp[$k]=$v['id_product'];}
		$tab = implode(",",$tab_temp);
		$where = " p.id_product IN (".$tab.")";
		$list = $this->products->getProductsSql($where,"","","",$id_client);
		return $list;
	}
	public function getProductsToInquiry($id_inquiry=0)
	{
		$this->db->select('*');
		$this->db->from('inquiries_products');
		$this->db->where('id_inquiry', $id_inquiry);
		$list = array();
		$fields = $this->db->list_fields('inquiries_products');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id][$field]=$item->$field;
							}
		}
		return $list;		
	}
	public function getInquiries($id_user=0,$page_start=0){
		$this->db->select('*');
		$this->db->from('inquiries');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_status !=', 3);
		$this->db->where('id_user', $id_user);
		$this->db->order_by('id_inquiry', 'desc');
		$this->db->limit("12",$page_start);	
		$list = array();
		$fields = $this->db->list_fields('inquiries');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_inquiry][$field]=$item->$field;
							}
		}
		return $list;
		
	}
	public function getInquiriesProducts($inquiries=array()){
		$i=0;
		$id_where_in=array();
		$list=array();
		if(count($inquiries)>0)
		{
			foreach($inquiries as $id_inquiry=>$v)
			{
				$id_where_in[$i]=$id_inquiry;
				$i++;
			}
			$this->db->select('*');
			$this->db->from('inquiries_products');
			$this->db->where_in('id_inquiry', $id_where_in);
			$list = array();
			$fields = $this->db->list_fields('inquiries_products');
			foreach($this->db->get()->result() as $item)
			{	
					foreach ($fields as $field)
								{
								$list[$item->id_inquiry][$item->id][$field]=$item->$field;
								}
			}
		}
		return $list;
		
	}
	public function sendAnswer($post,$id_user)
	{
		foreach($post['amount'] as $id=>$v)
		{	$price =  str_replace(",",".",$v);
			$data = array(
               'price' => $price
            );

			$this->db->where('id', $id);
			$this->db->update('inquiries_products', $data); 
		}
		$this->db->where('id_inquiry', $post['id_inquiry']);
		return $this->db->update('inquiries', array('id_system_user'=>$id_user,'date_respond'=>date("Y-m-d"),'id_status'=>2)); 
	}
	public function sendInquiry($id_user=0,$id_client=0)
	{
		$this->db->select('cp.id_product,cp.name,sum(cp.amount) as amount');
		$this->db->from('carts_products as cp');
		$this->db->join('carts as c', 'cp.id_cart = c.id_cart');
		$this->db->where('c.id_status', 1);
		$this->db->where('id_user', $id_user);
		$this->db->group_by('id_product');
		$list = array();
		foreach($this->db->get()->result() as $item)
		{					
							$list[$item->id_product]['name']=$item->name;
							$list[$item->id_product]['amount']=$item->amount;
							$tab_to_del[$item->id_product]=$item->id_product;

		}
		if(count($list) == 0)
			redirect(base_url("inquiries"),'refresh');
		// $this->db->where_in('id_product', $tab_to_del);
		// $this->db->delete('carts_products', $tab_to_del); 
		$data['id_user']=$id_user;
		$data['id_client']=$id_client;
		$data['date']=date("Y-m-d");
		$this->db->insert('inquiries',$data);
		$this->db->select_max('id_inquiry');
		$this->db->from('inquiries');
		$this->db->where("id_user",$id_user);
		foreach($this->db->get()->result() as $item)
		{
			$id_inquiry=$item->id_inquiry;
		}

		foreach($list as $id_product=>$value)
		{
			$data2[$id_product]['id_product'] = $id_product;
			$data2[$id_product]['name'] = $value['name'];
			$data2[$id_product]['amount'] = $value['amount'];
			$data2[$id_product]['id_user'] = $id_user;
			$data2[$id_product]['id_inquiry'] = $id_inquiry;
		}
		$this->db->insert_batch('inquiries_products', $data2); 
	}
	
	public function createFromOrder($id_order=0,$id_user=0,$id_client=0)
	{
		$this->db->select('op.id_product,op.name,sum(op.amount) as amount');
		$this->db->from('orders_products as op');
		$this->db->join('orders as o', 'op.id_order = op.id_order');
		$this->db->where('id_user', $id_user);
		$this->db->where('op.id_order', $id_order);
		$this->db->group_by('id_product');
		$list = array();
		foreach($this->db->get()->result() as $item)
		{					
							$list[$item->id_product]['name']=$item->name;
							$list[$item->id_product]['amount']=$item->amount;
							$tab_to_del[$item->id_product]=$item->id_product;
		}
		// $this->db->where_in('id_product', $tab_to_del);
		// $this->db->delete('carts_products', $tab_to_del); 
		$data['id_user']=$id_user;
		$data['id_client']=$id_client;
		$data['date']=date("Y-m-d");
		$this->db->insert('inquiries',$data);
		$this->db->select_max('id_inquiry');
		$this->db->from('inquiries');
		$this->db->where("id_user",$id_user);
		foreach($this->db->get()->result() as $item)
		{
			$id_inquiry=$item->id_inquiry;
		}
		$data2=array();
		foreach($list as $id_product=>$value)
		{
			$data2[$id_product]['id_product'] = $id_product;
			$data2[$id_product]['name'] = $value['name'];
			$data2[$id_product]['amount'] = $value['amount'];
			$data2[$id_product]['id_user'] = $id_user;
			$data2[$id_product]['id_inquiry'] = $id_inquiry;
		}
		$this->db->insert_batch('inquiries_products', $data2); 
	}
	
	public function createCartFromInquiry($id_inquiry=0,$id_user=0,$id_client=0)
	{
		//$id_cart_active=$this->orders->getCartByUser($id_user);
		$this->db->where("id_inquiry",$id_inquiry);
		$this->db->update('inquiries', array('id_status'=>3)); 
		
		$data1['id_user']=$id_user;
		$data1['id_status']=2;
		$data1['id_inquiry'] = $id_inquiry;
		$data1['date_accepted'] = date("Y-m-d H:i:s");
		$data1['id_client']=$id_client;
		$this->db->insert('carts', $data1); 			
		$id_cart_active=$this->db->insert_id();
		
		$products=$this->getProductsToInquiry($id_inquiry);				
		foreach($products as $id=>$value)
		{
			$product1 = $this->products->getProductWithPriceById($value['id_product']);
			$list[$id]['vat'] = $product1['vat'];
			$list[$id]['id_product']=$value['id_product'];		
			$list[$id]['name']=$value['name'];
			$list[$id]['price']=$value['price'];	
			$list[$id]['amount']=$value['amount'];
			$list[$id]['id_cart']=$id_cart_active;	
		}
		$this->db->insert_batch('carts_products', $list); 
	}
	public function getProductsToOffer($id_offer=0)
	{
		$this->db->select('*');
		$this->db->from('offerts_products');
		$this->db->where('id_offer', $id_offer);
		$list = array();
		$fields = $this->db->list_fields('offerts_products');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id][$field]=$item->$field;
							}
		}
		return $list;		
	}
	public function createCartFromOffer($id_offer=0,$id_user=0,$id_client=0)
	{
		//$id_cart_active=$this->orders->getCartByUser($id_user);
		$this->db->where("id_offer",$id_offer);
		$this->db->update('offerts', array('id_status'=>3)); 
		
		$data1['id_user']=$id_user;
		$data1['id_status']=2;
		$data1['id_offer'] = $id_offer;
		$data1['date_accepted'] = date("Y-m-d H:i:s");
		$data1['id_client']=$id_client;
		$this->db->insert('carts', $data1); 			
		$id_cart_active=$this->db->insert_id();
		
		$products=$this->getProductsToOffer($id_offer);				
		foreach($products as $id=>$value)
		{
			$product1 = $this->products->getProductWithPriceById($value['id_product']);
			$list[$id]['vat'] = $product1['vat'];
			$list[$id]['id_product']=$value['id_product'];		
			$list[$id]['name']=$value['name'];
			$list[$id]['price']=$value['price'];	
			$list[$id]['amount']=$value['amount'];
			$list[$id]['id_cart']=$id_cart_active;	
		}
		$this->db->insert_batch('carts_products', $list); 
	}
	public function getProductsOfferListForInfo($id_offer=0)
	{	$list = array();
		$fields = $this->db->list_fields('offerts_products');
		$query = $this->db->query('Select cp.id,cp.id_product,cp.id_offer,cp.amount,cp.price,cp.id_status,p.name from offerts_products as cp LEFT JOIN products  as p ON p.id_product=cp.id_product where cp.id_status != 0 and cp.id_offer ='.$id_offer);
		foreach($query->result() as $item)
		{	
			foreach ($fields as $field)
							{
							if(isset($item->$field))
								$list[$item->id][$field]=$item->$field;
							}
							$list[$item->id]['name']=$item->name;
		}
		return $list;
	}
	public function addOffer($id_user=0)
	{	
		$this->db->select('id_offer');
		$this->db->from('offerts');
		$this->db->where('id_user', $id_user);
		$this->db->where('id_status', 99);	
		foreach($this->db->get()->result() as $item)
		{	
			$this->db->where('id_offer', $item->id_offer);		
			$this->db->delete('offerts_products');
		}	
		$this->db->where('id_user', $id_user);
		$this->db->where('id_status', 99);	
		$this->db->delete('offerts');
		
		$data['id_user']=$id_user;
		$data['id_status']=99;
		$this->db->insert('offerts', $data); 
		$last_id = $this->db->insert_id();
		return $last_id;
	}
	public function getProductName($id)
	{
		$this->db->select('name');
		$this->db->from('products');
		$this->db->where('id_product', $id);
		$result=$this->db->get()->row();
		return $result->name;
	}
	public function addProduct($post=array(),$id_offer=0)
	{	
		$this->db->select('id_offer');
		$this->db->from('offerts_products');
		$this->db->where('id_offer', $id_offer);
		$this->db->where('id_product', $post['id_product']);	
		$this->db->where('id_status',1);	
		$result=$this->db->get()->result();
		if(count($result) > 0)
			{
				$tab['msg_val']='Produkt jest już dodany do definiwoanej oferty';
				$tab['msg']=2;
				return $tab;
			}
			
		$data['id_offer']=$id_offer;
		$data['id_product']=$post['id_product'];
		$data['amount']=$post['amount'];
		$data['name']=$this->getProductName($post['id_product']);
		$data['price']=str_replace(",",".",$post['price']);
		return $this->db->insert('offerts_products', $data); 		
	}
	public function editProduct($post)
	{
		$this->db->where('id', $post['id_product']);	
		$data['amount'] = $post['amount'];
		$data['price'] = $post['price'];
		return $this->db->update('offerts_products',$data);
	}
	
	public function delProduct($id=0)
	{
		$this->db->where('id', $id);		
		$this->db->delete('offerts_products');
	}

	public function getOffer($id_offer=0)
	{	$list= array();
		$this->db->select('*');
		$this->db->from('offerts');
		$this->db->where('id_offer', $id_offer);
		$this->db->where('id_status !=', 0);	
		$fields = $this->db->list_fields('offerts');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function save($data=array())
	{
		$tab['id_status']=1;
		if($data['name']=="")
			$tab['name']="Oferta z dnia: ".date("Y-m-d");
		else
			$tab['name']=$data['name'];
		$tab['date_from']=$data['date_from'];	
		$tab['date_to']=$data['date_to'];	
		$tab['id_client']=$data['id_client'];	
		$this->db->where('id_offer ',$data['id_offer']);
		return $this->db->update('offerts',$tab); 		
	} 
	public function getActiveOffertsByClient($id_client=0,$page_start=0){
		$this->db->select('*');
		$this->db->from('offerts');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_status !=', 3);
		$this->db->where('date_from <=', date("Y-m-d"));
		$this->db->where('date_to >=', date("Y-m-d"));
		$this->db->where('id_client', $id_client);
		$this->db->order_by('id_offer', 'desc');
		$this->db->limit("12",$page_start);	
		$list = array();
		$fields = $this->db->list_fields('offerts');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_offer][$field]=$item->$field;
							}
		}
		return $list;
		
	}
	public function countOfferts($id_client=0){
		$this->db->select('id_offer');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_status !=', 3);
		$this->db->where('date_from <=', date("Y-m-d"));
		$this->db->where('date_to >=', date("Y-m-d"));
		$this->db->where('id_client', $id_client);
		return $this->db->count_all_results('offerts');
			
	}
	public function getOffertsProducts($offerts=array()){
		$i=0;
		$id_where_in=array();
		$list=array();
		if(count($offerts)>0)
		{
			foreach($offerts as $id_offer=>$v)
			{
				$id_where_in[$i]=$id_offer;
				$i++;
			}
			$this->db->select('*');
			$this->db->from('offerts_products');
			$this->db->where_in('id_offer', $id_where_in);
			$list = array();
			$fields = $this->db->list_fields('offerts_products');
			foreach($this->db->get()->result() as $item)
			{	
					foreach ($fields as $field)
								{
								$list[$item->id_offer][$item->id][$field]=$item->$field;
								}
			}
		}
		return $list;
		
	}
}