<?php 

class Ordersmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('productsmodel','products');
		$this->load->model('contractsmodel','contracts');
		$this->load->model('clientsmodel','clients');
		$this->load->model('groupsmodel','groups');
		$this->load->model('paymentsmodel','payments');
		$this->load->model('access');
    }
	
	public function setOrderNbr($post=array())
	{
		foreach($post as $id=>$order)
		{
			$data['number_subiekt'] = $order['numer'];
			$this->db->where('id_order ',$order['id_order']);
			$this->db->update("orders", $data);
		}
	}
	
	public function getOrdersJSON()
	{
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->where('id_order >=',1);
		$order['data'] = array();
		$order['succes']=0; 
		$order['msg']="Błąd pobierana zamówień";
		foreach($this->db->get()->result() as $item)
		{
			$order['data'][$item->id_order]= array(
											'id_order' => $item->id_order,
											'id_client'=>$item->id_client,
											'date'=>$item->date,
											'delivery_date'=>$item->delivery_date,
											'id_status'=>$item->id_status,
											);
			$order['succes']=1;		
			$order['msg']="Pobrano zamówienia";
			
			$this->db->select('*');
			$this->db->from('orders_products');
			$this->db->where('id_order',$item->id_order);
			foreach($this->db->get()->result() as $item2)
				{
				$order['data'][$item->id_order]['products'][$item2->id] = array(
											'id_product' => $item2->id_product,
							 				'name'=>$item2->name,
											'price'=>$item2->price,
											'amount'=>$item2->amount,
											'id_status'=>$item2->id_status,
											);
				}		
		}	
		return json_encode($order);
	}
	public function getOrdersXML($date="0000-00-00 00:00:00")
	{
		$i=0;
		$this->db->select('o.*, c.symbol');
		$this->db->from('orders as o');
		$this->db->join('clients as c', 'o.id_client = c.id_client','left');				
		$where= "`id_order` >= 1 AND (`date` > '".$date."' or `number_subiekt` = '') AND `o`.`id_status` != 0 AND `o`.`id_status` != 99";
		 // $this->db->where('id_order >=',1);
		 // $this->db->where('date >',$date);
		 // $this->db->where('o.id_status !=', 0);
		 // $this->db->where('o.id_status !=', 99);
		$this->db->where($where);
		
		$r = '<?xml version="1.0" encoding="utf-8"?>';
		$r.="<orders>";
		
		foreach($this->db->get()->result() as $item)
		{	
		$r.="<order>";
			$r.="<id_order>".$item->id_order."</id_order>";
			$r.="<kh_Id>".$item->id_client."</kh_Id>";
			$r.="<kh_Symbol>".$item->symbol."</kh_Symbol>";
			$r.="<date>".$item->date."</date>";
			$r.="<delivery_date>".$item->delivery_date."</delivery_date>";
			$r.="<id_status>".$item->id_status."</id_status>";
			
			$r.="<products>";
			$this->db->select('op.*, p.code');
			$this->db->from('orders_products as op');
			$this->db->join('products as p', 'p.id_product = op.id_product','left');
			$this->db->where('id_order',$item->id_order);
			foreach($this->db->get()->result() as $item2)
				{
				//$price = $item2->price + (($item2->price * $item2->vat)/100);
				//$price = round($price,2);
				$r.="<product>";
				$r.="<tw_Id>".$item2->id_product."</tw_Id>";
				$r.="<tw_Symbol>".$item2->code."</tw_Symbol>";
				$r.="<name>".$item2->name."</name>";
				$r.="<price>".$item2->price."</price>";
				$r.="<amount>".$item2->amount."</amount>";
				$r.="<id_status>".$item2->id_status."</id_status>";				
				$r.="</product>";
				}	
			$r.="</products>";
			$r.="</order>";
			$i++;
		}	
		$r.="</orders>";
		$r = str_replace("&","&amp;",$r);
		if($i == 0)
			return "";
		else			
			return $r;
	}		
	
	public function createCartFromHistory($id_cart=0,$id_user=0,$id_client=0)
	{
		$id_cart_active=$this->getCartByUser($id_user);
		if($id_cart_active == 0)
			{
			$data1['id_user']=$id_user;
			$data1['id_client']=$id_client;
			$this->db->insert('carts', $data1); 
			$id_cart_active=$this->getCartByUser($id_user);
			}
		
		$this->db->select('cp.amount as amount,p.name as name,p.price as price, p.fixed_price as fixed_price, p.id_product as id_product, p.id_category as id_category');
		$this->db->from('carts_products as cp');
		$this->db->join('carts as c', 'c.id_cart = cp.id_cart');
		$this->db->join('products as p', 'p.id_product = cp.id_product');
		$this->db->where('c.id_user', $id_user);
		$this->db->where('cp.id_cart', $id_cart);
		$list = array();
		foreach($this->db->get()->result() as $item)
		{	$list[$item->id_product]['id_product']=$item->id_product;		
			$list[$item->id_product]['name']=$item->name;
			$list[$item->id_product]['price']=$item->price;	
			
				$where =" p.id_product = ".$item->id_product." ";
				$page_start = 0;
				$per_page = 0;
				$order_by="";
				$list_temp = $this->getProductsSql($where,$order_by,$page_start,$per_page,0,$item->amount);	
				
				 $list[$item->id_product]['price']=$list_temp[$item->id_product]['price'];
			/* get correct price */
			// $price1 = $this->products->getFixedPriceForProduct($item->id_product,$id_client);
							// /* get correct price */
			// if($price1 > 0)
			// {
				// $data[$item->id_product]['price'] = $price1;
				// //$list[$item->id_product]['old_price'] = $item->price;
			// }	
			// else
			// {
					// $id_group = $this->groups->getGroupForClient($this->session->userdata('id_client'));
					// $this->db->select('d.price as price');
					// $this->db->from('promotions as p');
					// $this->db->join('promotions_dates as d', 'd.id_promotion = p.id_promotion', 'left');
					// $this->db->join('promotions_groups as g', 'g.id_promotion = p.id_promotion', 'left');
					// $this->db->where('p.id_product', $item->id_product);
					// $this->db->where('p.id_status', 1);
					// $this->db->where('g.id_group', $id_group);
					// $this->db->where('d.date_from <=', date("Y-m-d"));
					// $this->db->where('d.date_to >=', date("Y-m-d"));
					// $this->db->where('p.id_type', 1);						
					// foreach($this->db->get()->result() as $item1)
					// {	
						// $list[$item->id_product]['price'] = $item1->price;
						// $test = 1;
						// //$list[$i]['old_price'] = $item->price;
					// }	
					// if(!isset($test))
					// {							
						// $this->db->select('p.discount as discount');
						// $this->db->from('discounts as d');
						// $this->db->join('discounts_positions as p', 'p.id_discount = d.id_discount', 'left');
						// $this->db->join('discounts_groups as g', 'g.id_discount = d.id_discount', 'left');
						// $this->db->where('d.id_category', $item->id_category);
						// $this->db->where('d.id_status', 1);
						// $this->db->where('g.id_group', $id_group);
						// $this->db->where('p.amount', 0);
						// foreach($this->db->get()->result() as $item2)
							// {	
							// $list[$item->id_product]['price'] = $item->price - (($item->price * $item2->discount)/100);
							// //$list[$i]['old_price'] = $item->price;
							// }
				// }
				
			// }/* end  get correct price */
			
			$list[$item->id_product]['amount']=$item->amount;
			$list[$item->id_product]['id_cart']=$id_cart_active;			
		}
		
		$this->db->insert_batch('carts_products', $list); 
		
	}
	public function getCartsForHistory($id_user=0,$page_start=0){
		$this->db->select('*');
		$this->db->from('carts');
		$this->db->where('id_status >', 1);
		$this->db->where('id_user', $id_user);
		$this->db->order_by('date_accepted', 'desc');
		$this->db->limit("10",$page_start);	
		$list = array();
		$fields = $this->db->list_fields('carts');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_cart][$field]=$item->$field;
							}
		}
		return $list;
		
	}
	public function countCartsForHistory($id_user=0){
		$this->db->select('count(id_cart) as c');
		$this->db->where('id_status >', 1);
		$this->db->where('id_user', $id_user);
		return $this->db->count_all_results('carts');
			
	}
	
	public function changeStatus($id_order=0,$id_status=1)
	{
		$this->db->select('id_status');
		$this->db->from('orders');
		$this->db->where('id_order', $id_order);
		foreach($this->db->get()->result() as $item)
		{
			$id_status_old = $item->id_status;
		}
		$data['id_status'] = $id_status;
		$this->db->where('id_order',$id_order);	
		$this->db->update("orders", $data); 
		return $id_status_old;
	}
	public function getStatuses(){
		$this->db->select('*');
		$this->db->from('orders_status');
		$this->db->where('id_status ', 1);
		$list = array();
		$fields = $this->db->list_fields('orders_status');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id][$field]=$item->$field;
							}
		}
		return $list;
	}
	public function getProductsToOrder($id_order=0){
		$this->db->select('*');
		$this->db->from('orders_products');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_order', $id_order);
		$list = array();
		$fields = $this->db->list_fields('orders_products');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id][$field]=$item->$field;
							}
		}
		return $list;
	}
	
	public function getOrderById($id_order=0){
		$this->db->select('o.*, os.name as s_name, os.style, u.firstname, u.lastname');
		$this->db->from('orders as o');
		$this->db->join('orders_status as os', 'o.id_status = os.id', 'left');
		$this->db->join('users as u', 'o.id_user_accept = u.id_user', 'left');
		$this->db->where('o.id_status !=', 0);
		$this->db->where('o.id_order', $id_order);
		$list = array();
		$fields = $this->db->list_fields('orders');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
							$list['s_name']=$item->s_name;
							$list['style']=$item->style;
							$list['firstname']=$item->firstname;
							$list['lastname']=$item->lastname;
		}
		return $list;
		
	}
	public function getOrders(){
		$this->db->select('o.*, os.name as s_name, os.style, u.firstname, u.lastname');
		$this->db->from('orders as o');
		$this->db->join('orders_status as os', 'o.id_status = os.id', 'left');
		$this->db->join('users as u', 'o.id_user_accept = u.id_user', 'left');
		$list = array();
		$fields = $this->db->list_fields('orders');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_order][$field]=$item->$field;
							}
							$list[$item->id_order]['s_name']=$item->s_name;
							$list[$item->id_order]['style']=$item->style;
							$list[$item->id_order]['firstname']=$item->firstname;
							$list[$item->id_order]['lastname']=$item->lastname;
		}
		return $list;
		
	}
	public function getOrdersByClient($id_client=0){
		$this->db->select('o.*, os.name as s_name, os.style, u.firstname, u.lastname');
		$this->db->from('orders as o');
		$this->db->join('orders_status as os', 'o.id_status = os.id', 'left');
		$this->db->join('users as u', 'o.id_user_accept = u.id_user', 'left');
		$this->db->where('o.id_client', $id_client);
		$list = array();
		$fields = $this->db->list_fields('orders');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_order][$field]=$item->$field;
							}
							$list[$item->id_order]['s_name']=$item->s_name;
							$list[$item->id_order]['style']=$item->style;
							$list[$item->id_order]['firstname']=$item->firstname;
							$list[$item->id_order]['lastname']=$item->lastname;
		}
		return $list;
		
	}
	public function getProductsToOrders($orders=array()){
		$i=0;
		$list = array();
		foreach($orders as $id_order=>$v)
		{	
			$id_where_in[$i]=$id_order;
			$i++;
		}
		if(isset($id_where_in))
		{
			$this->db->select('*');
			$this->db->from('orders_products');
			$this->db->where('id_status !=', 0);
			$this->db->where_in('id_order', $id_where_in);
			
			$fields = $this->db->list_fields('orders_products');
			foreach($this->db->get()->result() as $item)
			{	
					foreach ($fields as $field)
								{
								$list[$item->id_order][$item->id][$field]=$item->$field;
								}
			}
		}
		return $list;
	}
	public function getOrdersByStatusSite($id_client=0,$id_status=0,$id_profile){
		$this->db->select('o.*, os.name as s_name, os.style, u.firstname, u.lastname');
		$this->db->from('orders as o');
		$this->db->join('orders_status as os', 'o.id_status = os.id', 'left');
		$this->db->join('users as u', 'o.id_user_accept = u.id_user', 'left');
		$this->db->where('o.id_client', $id_client);
		$this->db->where('o.id_status', $id_status);
		$this->db->order_by('o.date','desc');
		if($id_profile == 3)
			$this->db->where('o.id_user', $this->session->userdata('id_user'));
		$list = array();
		$fields = $this->db->list_fields('orders');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_order][$field]=$item->$field;
							}
							$list[$item->id_order]['s_name']=$item->s_name;
							$list[$item->id_order]['style']=$item->style;
							$list[$item->id_order]['user']=$item->firstname." ".$item->lastname;
		}
		return $list;
		
	}
	public function getOrdersByStatus($id_client=0,$id_status=0){
		$this->db->select('o.*, os.name as s_name, os.style, u.firstname, u.lastname');
		$this->db->from('orders as o');
		$this->db->join('orders_status as os', 'o.id_status = os.id', 'left');
		$this->db->join('users as u', 'o.id_user_accept = u.id_user', 'left');
		$this->db->where('o.id_client', $id_client);
		$this->db->where('o.id_status', $id_status);
		$list = array();
		$fields = $this->db->list_fields('orders');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_order][$field]=$item->$field;
							}
							$list[$item->id_order]['s_name']=$item->s_name;
							$list[$item->id_order]['style']=$item->style;
							$list[$item->id_order]['firstname']=$item->firstname;
							$list[$item->id_order]['lastname']=$item->lastname;
		}
		return $list;
		
	}
	public function acceptOrder($carts=array(),$post=array(),$id_client=0,$id_user=0,$settigs_loyalty,$products_contracts=array())
	{
		$i=0;
		foreach($carts as $id_cart=>$v)
		{	
			$data['id_user']=$v['id_user'];
			$data['mpk']=$v['mpk'];
			$id_where_in[$i]=$id_cart;
			$id_inquiry = $v['id_inquiry'];
			$id_offer = $v['id_offer'];
			$i++;
		}
	
		
		$data['id_client']=$id_client;
		$data['id_user_accept']=$id_user;
		$data['payment_type']=$post['payment_type'];
		$data['id_status']=2;
		$data['delivery_date']=$post['delivery_date'];
		$data['date']=date("Y-m-d H:i:s");
		$this->db->insert('orders',$data);
		
		$this->db->select_max('id_order');
		$this->db->from('orders');
		$this->db->where("id_client",$id_client);
		$this->db->where("id_user_accept",$id_user);
		foreach($this->db->get()->result() as $item)
		{
			$id_order=$item->id_order;
		}
		
		if($id_inquiry == 0 && $id_offer == 0)
			$this->db->select('p.code, cp.id_product, cp.name, p.price, SUM( cp.amount ) AS amount, cp.id_contract,p.id_category,p.vat, p.id_info_status, p.loyalty');
		else
			$this->db->select('p.code, cp.id_product, cp.name, cp.price, SUM( cp.amount ) AS amount, cp.id_contract,p.id_category,p.vat, p.id_info_status, p.loyalty');
		$this->db->from('carts_products as cp');
		$this->db->join('products as p', 'p.id_product = cp.id_product', 'left');
		$this->db->where_in("id_cart",$id_where_in);
		$this->db->group_by('id_product, name, price, id_contract');
		$i=0;
		$loyalty_points=0;
		$order_text="<p><strong>ID zamówienia:".$id_order."</strong></p><p><strong>Szczegóły:</strong></p><table border='1'><tr><td><strong>Kod prod.</strong></td><td><strong>Produkt</strong></td><td><strong>Cena jedn. netto</strong></td><td><strong>Cena jedn. brutto</strong></td><td><strong>Ilość</strong></td><td><strong>Wartość netto</strong></td></tr>";
		
		$suma=0;
		$suma_b=0;
		$gratis = "";
		foreach($this->db->get()->result() as $item)
		{ 
			
			$list[$i]['id_product']=$item->id_product;
			$list[$i]['name']=$item->name;
			$list[$i]['price']=$item->price;
			$list[$i]['vat']=$item->vat;
			$is_contract=0;
			foreach ($products_contracts as $id_prod_c=>$prod_c)
			{
				if($prod_c['id_product'] == $item->id_product)
					{
						if($item->amount <= $prod_c['amount_left'])
						{
							$list[$i]['price'] = $prod_c['price'];
							$a_left = $prod_c['amount_left'] - $item->amount;
							$this->contracts->setAmount($a_left,$prod_c['id']);
							$is_contract = 1;
						}
						else
						{	$list[$i]['name'] .= " (kontraktowy)";
							$list[$i]['amount'] = $prod_c['amount_left'];
							$list[$i]['price'] =  $prod_c['price'];
							$list[$i]['id_contract']=$item->id_contract;
							$list[$i]['id_order']=$id_order;
							$this->contracts->setAmount(0,$prod_c['id']);
							$suma+=$list[$i]['price']*$list[$i]['amount'] ;							
							$i++;							
							$list[$i]['id_product']=$item->id_product;
							$list[$i]['name']=$item->name;
							$list[$i]['price']=$item->price;
							$list[$i]['amount']=$item->amount - $prod_c['amount_left'];
							
							$is_contract = 2;
						}
					}
					
					
			}
			/* get correct price */
			if($id_inquiry == 0 && $id_offer == 0)
			{
				if($is_contract != 1)
				{	
					$order_by="";
					$page_start=0;
					$per_page = 0;
					$where = " p.id_product = ".$item->id_product." ";
					$list_temp = $this->products->getProductsSql($where,$order_by,$page_start,$per_page,0,$item->amount);	
					$list[$i]['price'] = $list_temp[$item->id_product]['price'];
					if($list_temp[$item->id_product]['gratis'] !="")
					{	
						$this->db->select('MAX(d.amount) as amount, d.gratis');
						$this->db->from('promotions as p');
						$this->db->join('promotions_gratises as d', 'd.id_promotion = p.id_promotion', 'left');
						$this->db->join('promotions_groups as g', 'g.id_promotion = p.id_promotion', 'left');
						$this->db->where('p.id_promotion', $list_temp[$item->id_product]['gratis']);
						$this->db->where('d.amount <=', $item->amount);			
						$this->db->group_by('amount');
						$this->db->order_by('amount',"desc");
						$this->db->limit('1');
						foreach($this->db->get()->result() as $item1)
						{									
							if($gratis == "")
								$gratis = "Gratis: ";
							$gratis.=$item1->gratis." ";

						}	
					}
					
				}/* end  get correct price */	
			}
			$item->amount = round($item->amount,2);
			$list[$i]['amount']=$item->amount;
			$list[$i]['id_contract']=$item->id_contract;
			$list[$i]['id_order']=$id_order;	
			$order_text.="<tr><td>".$item->code."</td><td>".$item->name."</td><td>".number_format($list[$i]['price'],2,',','')." zł</td><td>".number_format($list[$i]['price']+($list[$i]['price']*$item->vat/100),2,',','')."</td><td>".$item->amount."</td><td>".number_format($list[$i]['price']*$item->amount,2,',','')." zł</td></tr>";
			$suma+=$list[$i]['price']*$item->amount;
			$suma_b+=($list[$i]['price']+($list[$i]['price']*$item->vat/100))*$item->amount;
			$client=$this->client->getById($id_client);
			$is_loy = 0;
			if($client['loyalty'] == 1)
			{
				if(isset($loyaltyProduct))
				{
					if($loyaltyProduct == 1)
						$is_loy = 1;
				}
				else
				{
				$is_loy = 1;
				}
			}

				
				if($is_loy == 1)
				{
					$loyalty_points += ($list[$i]['price']*$list[$i]['amount'] )/$settigs_loyalty[2]['value']*$settigs_loyalty[1]['value'];					
				}
			$i++;
			
		}
		$loyalty_points = round($loyalty_points,-1);
		$order_text .="</table>";
		$update_array['information']=$post['information'];	
		$update_array['information'].=$gratis;	

		$order_text.="<br/><strong>Całkowita wartość zamówienia (netto):</strong> ".number_format($suma,2,',','')." zł </br>";
		$order_text.="<strong>Całkowita wartość zamówienia (brutto):</strong> ".number_format($suma_b,2,',','')." zł </br></br>";	
		$order_text.="<strong>Płatność:</strong> ";
		
		$order_text .= ($post['payment_type']==2) ? "Gotówka" : "Przelew";
		$order_text.="<br/><br/>";
		if($update_array['information'] != "") $order_text.="<strong>Uwagi</strong><br/>".$update_array['information']."</br></br>";
		
		if($suma <= 100)
			$loyalty_points = 0;
		$order_text.="<strong>Data dostawy: </strong>".$post['delivery_date']."<br/>";
		//$order_text.="\n\n Ilość punktów lojalnościowych: ".$loyalty_points;

		$this->db->insert_batch('orders_products', $list);
		
		$check_limits=$this->checkLimits($id_client);
		$update_array['loyalty_points']=$loyalty_points;
		if($check_limits['val'] == 1)
		{
			$update_array['id_status']=99;
		}
		 $this->db->where_in("id_cart",$id_where_in);
		 $this->db->update('carts',array("id_status"=>3));
		 $this->db->where("id_order",$id_order);
		 $this->db->update('orders',$update_array);
		$r[0] = $order_text;
		$r[1] = $check_limits;
		return $r;
	}
	
	private function checkLimits($id_client=0)
	{
		$this->db->select('id_order');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_client', $id_client);
		$this->db->where('paid', 0);
		$c = $this->db->count_all_results('orders');
		
		$this->db->select('op.price,op.amount');
		$this->db->from('orders_products as op');
		$this->db->join('orders as o', 'o.id_order = op.id_order', 'left');
		$this->db->where('o.id_client', $id_client);
		$this->db->where('o.paid', 0);
		$sum=0;
		foreach($this->db->get()->result() as $item)
		{	
			$sum+=$item->amount*$item->price;
		}
		$limits=$this->clients->getLimitsForClient($id_client);
		
		$deadline = $this->payments->getPaymentMaxNotPaid($id_client);
	
		$days = strtotime(date("Y-m-d")) - strtotime($deadline) ;
		$days = round($days/3600/24);
		
		if($limits['limit_amount']<=$sum && $limits['limit_amount'] >0)
			{
			$return['val']=1;
			$return['txt'] = "Limit kwoty niezapłaconych faktur został przekroczony.<br/><br/>Do czasu uregulowania płatności, realizacja zamówienia zostaje wstrzymana.";
			}
		else if(($limits['limit_facture'] < $days) && $limits['limit_facture'] >0 && $deadline)
			{
			$return['val']=1;
			$a = $days - $limits['limit_facture'];
			if($a==1)
				$day_name = "dzień";
			else
				$day_name = "dni";
			$return['txt'] = "Dozwolony czas na opłacenie zaległych faktur został przekroczony o ".$a." ".$day_name.". <br/><br/>Ureguluj zaległości.";
			}
		else
			{
			$return['val']=3;
			$return['txt'] = "Zamówienie zostało wysłane.";
			}
							
		return $return;
			
	}
	public function getSummaryProductsToOrder($carts=array(),$products_contracts=array(),$settings_loyalty,$id_client)
	{	$i=0;
		$client=$this->client->getById($id_client);
		$loyalty_points = 0;
		foreach($carts as $id_cart=>$v)
		{
			$id_where_in[$i]=$id_cart;
			$id_inquiry = $v['id_inquiry'];
			$id_offer = $v['id_offer'];
			$i++;
		}
		if($id_inquiry == 0 && $id_offer == 0)
			$this->db->select('cp.id_product, cp.name, p.price, SUM( cp.amount ) AS amount, cp.id_contract,p.id_category,p.vat, p.id_info_status, p.loyalty');
		else
			$this->db->select('cp.id_product, cp.name, cp.price, SUM( cp.amount ) AS amount, cp.id_contract,p.id_category,p.vat, p.id_info_status, p.loyalty');
		$this->db->from('carts_products as cp');
		$this->db->join('products as p', 'p.id_product = cp.id_product', 'left');
		$this->db->where_in("id_cart",$id_where_in);
		$this->db->group_by('id_product, name, price, id_contract');
		$i=0;
		foreach($this->db->get()->result() as $item)
		{ 	$list[$i]['price']=$item->price;
			$list[$i]['id_product']=$item->id_product;
			$list[$i]['name']=$item->name;
			$list[$i]['amount']=round($item->amount,2);
			$is_contract=0;
			foreach ($products_contracts as $id_prod_c=>$prod_c)
			{	
				if($prod_c['id_product'] == $item->id_product)
					{
						if($item->amount <= $prod_c['amount_left'])
						{
							$list[$i]['price'] = $prod_c['price'];
							$is_contract = 1;
						}
						else
						{	$list[$i]['name'] .= " (kontraktowy)";
							$list[$i]['amount'] = $prod_c['amount_left'];
							$list[$i]['price'] =  $prod_c['price'];
							$list[$i]['id_contract']=$item->id_contract;
							$list[$i]['id_info_status']=$item->id_info_status;
							$list[$i]['loyalty']=$item->loyalty;
							
							$i++;
							$list[$i]['price']=$item->price;
							$list[$i]['id_product']=$item->id_product;
							$list[$i]['name']=$item->name;
							$list[$i]['amount']=$item->amount - $prod_c['amount_left'];
							
							$is_contract = 2;
						}
					}
					
			}
			if($id_inquiry == 0 && $id_offer == 0)
			{
			
			/* get correct price */
				if($is_contract != 1)
				{		
					$order_by="";
					$page_start=0;
					$per_page = 0;
					$where = " p.id_product = ".$item->id_product." ";
					$list_temp = $this->products->getProductsSql($where,$order_by,$page_start,$per_page,0,$item->amount);	
					$list[$i]['price'] = $list_temp[$item->id_product]['price'];

					if($list_temp[$item->id_product]['gratis'] !="")
					{	
						$this->db->select('MAX(d.amount) as amount, d.gratis');
						$this->db->from('promotions as p');
						$this->db->join('promotions_gratises as d', 'd.id_promotion = p.id_promotion', 'left');
						$this->db->join('promotions_groups as g', 'g.id_promotion = p.id_promotion', 'left');
						$this->db->where('p.id_promotion', $list_temp[$item->id_product]['gratis']);
						$this->db->where('d.amount <=', $item->amount);			
						$this->db->group_by('amount');
						foreach($this->db->get()->result() as $item1)
						{				
							$list[$i]['gratis']=$item1->gratis;

						}	
					}
				
					$loyalty_points=0;
					$is_loy = 0;
					
					if($client['loyalty'] == 1)
					{
						if(isset($loyaltyProduct))
						{ 
							if($loyaltyProduct == 1)
								$is_loy = 1;
						}
						else
						{
						$is_loy = 1;
						}
					}
					
						
					if($is_loy == 1)
					{	
						$loyalty_points += ($list[$i]['price']*$list[$i]['amount'] )/$settings_loyalty[2]['value']*$settings_loyalty[1]['value'];
					}
				}
			}
			$list[$i]['id_contract']=$item->id_contract;
			$list[$i]['id_info_status']=$item->id_info_status;
			$list[$i]['loyalty']=$loyalty_points;
			$list[$i]['vat']=$item->vat;
			$i++;
		}	
		return $list;	
	}
	public function updateProductAmount($amount, $id)
	{
		$data = array('amount' => $amount);
		$this->db->where('id', $id);
		$this->db->update('carts_products', $data); 
	}
	public function deleteProductCart($id_product=0,$is_order = 0)
	{	
		// if($is_order == 1)
		// {
		// $data = array('id_status' => 0);
		// $this->db->where('id', $id_product);
		// $this->db->update('carts_products', $data);
		
		// $this->db->select('id_cart');
		// $this->db->from('carts_products');
		// $this->db->where('id', $id_product);
		// $row = $this->db->get()->row();
		

		// $this->db->where('id_cart', $row->id_cart);
		// $this->db->where('id_status', 1);
		// $this->db->from('carts_products');
		// if($this->db->count_all_results() < 1){
			// $data['id_status'] = 4;
			// $this->db->where("id_cart",$row->id_cart());
			// $this->db->update('carts', $data);	
			// }
		// }
		// else
		// {
		$this->db->where('id', $id_product);
		$this->db->delete('carts_products');
		//}
	}
	public function getCartsOrderSite($id_client=0,$id_profile){
		$this->db->select('carts.*, users.firstname, users.lastname');
		$this->db->from('carts');
		$this->db->join('users', 'carts.id_user = users.id_user');
		$this->db->where('carts.id_status', 2);
		$this->db->where('carts.id_client', $id_client);
		$this->db->order_by('carts.date_accepted','desc');
		if($id_profile == 3)
			$this->db->where('carts.id_user', $this->session->userdata('id_user'));
		$list = array();
		$fields = $this->db->list_fields('carts');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_cart][$field]=$item->$field;
							}
							$list[$item->id_cart]['user']=$item->firstname." ".$item->lastname;
		}
		return $list;		
	}
	public function getCartsOrder($id_client=0){
		$this->db->select('carts.*, users.firstname, users.lastname');
		$this->db->from('carts');
		$this->db->join('users', 'carts.id_user = users.id_user');
		$this->db->where('carts.id_status', 2);
		$this->db->where('carts.id_client', $id_client);
		$list = array();
		$fields = $this->db->list_fields('carts');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_cart][$field]=$item->$field;
							}
							$list[$item->id_cart]['user']=$item->firstname." ".$item->lastname;
		}
		return $list;		
	}
	public function getCartsOrderCanceled($id_client=0){
		$this->db->select('carts.*, users.firstname, users.lastname');
		$this->db->from('carts');
		$this->db->join('users', 'carts.id_user = users.id_user');
		$this->db->where('carts.id_status', 4);
		$this->db->where('carts.id_client', $id_client);
		$this->db->order_by('carts.date_accepted','desc');
		$list = array();
		$fields = $this->db->list_fields('carts');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_cart][$field]=$item->$field;
							}
							$list[$item->id_cart]['user']=$item->firstname." ".$item->lastname;
		}
		return $list;		
	}
	public function getCartOrder($id_cart=0){
		$this->db->select('carts.*,  users.mpk, users.firstname, users.lastname');
		$this->db->from('carts');
		$this->db->join('users', 'carts.id_user = users.id_user');
		$this->db->where('carts.id_status', 2);
		$this->db->where('carts.id_cart', $id_cart);
		$list = array();
		$fields = $this->db->list_fields('carts');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_cart][$field]=$item->$field;
							}
							$list[$item->id_cart]['user']=$item->firstname." ".$item->lastname;
							$list[$item->id_cart]['mpk']=$item->mpk;
		}
		return $list;
		
	}
	
	public function getCartProductsToAccept($carts=array()){
		$i=0;
		$id_where_in=array();
		$list=array();
		if(count($carts)>0)
		{
			foreach($carts as $id_cart=>$v)
			{
				$id_where_in[$i]=$id_cart;
				$i++;
			}
			$this->db->select('carts_products.*, products.amount_decimal');
			$this->db->from('carts_products');
			$this->db->join('products', 'carts_products.id_product = products.id_product');
			$this->db->where_in('id_cart', $id_where_in);
			$list = array();
			$fields = $this->db->list_fields('carts_products');
			foreach($this->db->get()->result() as $item)
			{	
					foreach ($fields as $field)
								{
								$list[$item->id_cart][$item->id][$field]=$item->$field;
								}
								$list[$item->id_cart][$item->id]['amount_decimal']=$item->amount_decimal;
			}
		}
		return $list;
		
	}
	public function getCartProducts($id_user=0){
		$this->db->select('carts_products.*, products.amount_decimal');
		$this->db->from('carts_products');
		$this->db->join('carts', 'carts_products.id_cart = carts.id_cart');
		$this->db->join('products', 'carts_products.id_product = products.id_product');
		$this->db->where('carts.id_status', 1);
		$this->db->where('id_user', $id_user);
		$list = array();
		$fields = $this->db->list_fields('carts_products');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id][$field]=$item->$field;
							}
							$list[$item->id]['amount_decimal']=$item->amount_decimal;
		}
		return $list;
		
	}
	public function sumCartByUser( $id_user=0){
		$sum=array();
		$result=$this->db->query("SELECT SUM(cp.price*cp.amount) as sum,SUM((cp.price+(cp.price*cp.vat)/100)*cp.amount) as sum_b
		FROM carts_products as cp
		JOIN carts as c
		ON cp.id_cart=c.id_cart
		WHERE c.id_user=".$id_user."
		and c.id_status= 1");
		
		foreach($result->result() as $item)
		{	
			$sum[1]=$item->sum;
			$sum[2]=round($item->sum_b,2);
		}
		// $result=$this->db->query("SELECT cp.price,cp.amount,cp.vat
		// FROM carts_products as cp
		// JOIN carts as c
		// ON cp.id_cart=c.id_cart
		// WHERE c.id_user=".$id_user."
		// and c.id_status= 1");
		
		// foreach($result->result() as $item)
		// {	echo $item->price." | ".$item->amount." | ".$item->vat."<br/>"; 
				// echo $item->price*$item->amount+((($item->price*$item->amount)*$item->vat));
		// }
		// die();
		return $sum;
	}
	public function getCartByUser( $id_user=0){
		$id_cart=0;
		$this->db->select('id_cart');
		$this->db->where('id_status', 1);
		$this->db->where('id_user', $id_user);
		$this->db->from('carts');
		foreach($this->db->get()->result() as $item)
		{	
			$id_cart=$item->id_cart;
		}
		return $id_cart;
	}
	private function checkProductInOrder($id_product=0,$id_cart=0,$price=0,$id_contract=0){
		$id=0;
		$this->db->select('id');
		$this->db->where('id_status', 1);
		$this->db->where('id_product', $id_product);
		$this->db->where('price', $price);
		$this->db->where('id_cart', $id_cart);
		$this->db->where('id_contract', $id_contract);
		$this->db->from('carts_products');
		foreach($this->db->get()->result() as $item)
		{	
			$id=$item->id;
		}
		return $id;
	}
	private function getPriceForProductByContract($id_product=0, $id_contract=0)
	{	
		$this->db->select('price');
		$this->db->where('id_status', 1);
		$this->db->where('id_product', $id_product);
		$this->db->where('id_contract', $id_contract);
		$this->db->from('contracts_products');
		foreach($this->db->get()->result() as $item)
		{	
			$price=$item->price;
		}
		return $price;
	}
	
	public function addProductToOrder($id_product=0, $vars=array(), $amount=0, $product=array(),$id_contract=0)
	{	
		if($id_contract == 0)	
			{
				// $data['price']=$product['price'];
							// $price1 = $this->products->getFixedPriceForProduct($id_product,$vars['id_client']);
							// /* get correct price */
							// if($price1 > 0)
							// {
								// $data['price'] = $price1;
								// //$list[$item->id_product]['old_price'] = $item->price;
							// }		
							// else
							// {	$id_group = $this->groups->getGroupForClient($this->session->userdata('id_client'));
								// $this->db->select('d.price as price');
								// $this->db->from('promotions as p');
								// $this->db->join('promotions_dates as d', 'd.id_promotion = p.id_promotion', 'left');
								// $this->db->join('promotions_groups as g', 'g.id_promotion = p.id_promotion', 'left');
								// $this->db->where('p.id_product', $id_product);
								// $this->db->where('p.id_status', 1);
								// $this->db->where('g.id_group', $id_group);
								// $this->db->where('d.date_from <=', date("Y-m-d"));
								// $this->db->where('d.date_to >=', date("Y-m-d"));
								// $this->db->where('p.id_type', 1);						
								// foreach($this->db->get()->result() as $item1)
								// {	
									// $data['price'] = $item1->price;
									// $old_price = 1;
								// }	
								// if(!isset($old_price))
								// {	
									// $cat=$this->products->getCategoryById($product['id_category']);					
									// $this->db->select('p.discount as discount');
									// $this->db->from('discounts as d');
									// $this->db->join('discounts_positions as p', 'p.id_discount = d.id_discount', 'left');
									// $this->db->join('discounts_groups as g', 'g.id_discount = d.id_discount', 'left');
										// $where ="(`d`.`id_category` = '".$product['id_category']."' OR `d`.`id_category` = '".$cat['id_parent']."') AND `d`.`id_status` = 1 AND `g`.`id_group` = '".$id_group."' AND `p`.`amount` = 0";
										// $this->db->where($where);
									// foreach($this->db->get()->result() as $item2)
										// {	
										// $data['price'] = $data['price'] - (($data['price'] * $item2->discount)/100);
									
										// }
								// }
							// }
							// /* end  get correct price */
							$order_by="";
							$page_start=0;
							$per_page = 0;
							$where = " p.id_product = ".$id_product." ";
							$product_tab= $this->products->getProductsSql($where,$order_by,$page_start,$per_page,0,$amount);
							$data['price'] = $product_tab[$id_product]['price'];
			}
		else
			$data['price']=$this->getPriceForProductByContract($id_product,$id_contract);
			
		$id_cart=$this->getCartByUser($vars['id_user']);
		if($id_cart == 0)
			{
			$data1['id_user']=$vars['id_user'];
			$data1['id_client']=$vars['id_client'];
			$this->db->insert('carts', $data1); 
			$id_cart=$this->getCartByUser($vars['id_user']);
			}
		$productInOrder=$this->checkProductInOrder($id_product,$id_cart,$data['price'],$id_contract);
		$data['name']=$product['name'];	
		$data['vat']=$product['vat'];			
		$data['id_contract']=$id_contract;
		$data['id_cart']=$id_cart;
		$data['id_product']=$id_product;
		$data['amount']=$amount;
		if($productInOrder != 0)
			{
			$this->db->query('UPDATE carts_products SET amount = amount+'.$amount.' where id='.$productInOrder );
			}			
		else
			$this->db->insert('carts_products', $data); 	
	}
	public function acceptCart($id_user)
	{	$this->db->select_max('id_cart');
		$this->db->from('carts');
		$this->db->where("id_user",$id_user);
		$this->db->where("id_status",1);
		foreach($this->db->get()->result() as $item)
		{
			$id_cart=$item->id_cart;
		}
		
		$data['date_accepted']=date("Y-m-d H:i:s");
		$data['id_status']=2;
		if(isset($id_cart))			
			$this->db->update('carts', $data, "id_cart =".$id_cart);
		
	}
	public function clearCart($id_user=0)
	{	$this->db->select('id_cart');
		$this->db->from('carts');
		$this->db->where("id_user",$id_user);
		$this->db->where("id_status",1);
		foreach($this->db->get()->result() as $item)
		{	
			$id_cart=$item->id_cart;
		}
		$this->db->where("id_cart",$id_cart);
		$this->db->delete('carts');
		$this->db->where("id_cart",$id_cart);
		$this->db->delete('carts_products');
		
		
	}
	public function subtotalCart($id_user,$post)
	{	
		$i=0;
		foreach($post['product_amount'] as $id=>$amount)
			{
			$data[$i]=
				   array(
					  'id' =>$id,
					  'amount' => $amount,
				   );
				$i++;
			}
		$this->db->update_batch('carts_products', $data, 'id');
		$this->checkPriceCart($id_user);
	}
	public function cancelCart($id_cart)
	{	$data['id_status'] = 4;
		$this->db->where("id_cart",$id_cart);
		$this->db->update('carts', $data);
	}
	public function activeCart($id_cart)
	{	$data['id_status'] = 1;
		$this->db->where("id_cart",$id_cart);
		$this->db->update('carts', $data);
	}
	public function checkPriceCart($id_user=0)
	{	
		$products_list=$this->getCartProducts($id_user);
		$i=0;
		foreach($products_list as $id=>$value)
			{
				if($value['id_contract'] == 0)
				{
					//$product=$this->products->getProductById($value['id_product'],$this->session->userdata('id_client'));
					$product=$this->products->getProductByIdWithPromotions($value['id_product'],$this->session->userdata('id_client'),$value['amount']);
				
					if($product['price'] != $value['price'])
						$data[$i]=array(
							  'id' =>$id,
							  'price' => $product['price']
							);
				}
				$i++;				
			}
			if(isset($data))
				$this->db->update_batch('carts_products', $data, 'id');
	}
}