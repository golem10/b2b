<?php 

class Productsmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('access');
		$this->load->model('groupsmodel','groups');
    }
	//migration//
	public function importCategories($post=array())
	{
		foreach($post as $id=>$value)
		{
			$data[$id]['id_category']=$value['id_category'];
			$data[$id]['name']=$value['name'];
			$data[$id]['id_parent']=0;
		}
		$this->db->insert_batch('products_categories', $data); 

	}
	public function importProducts($post=array())
	{
		foreach($post['Results_from_Query_x003A__Products'] as $id=>$value)
		{
		if($value['tw_Id'])
			$data[$id]['id_product']=$value['tw_Id'];
		else
			$data[$id]['id_product']="";
		if($value['tw_Nazwa'])
			$data[$id]['name']=$value['tw_Nazwa'];
		else
			$data[$id]['name']="";
		// if($value['tw_Opis'])
			// $data[$id]['description']=$value['tw_Opis'];
		// else
			// $data[$id]['description']="";
		if($value['tw_Uwagi'])
			$data[$id]['comments']=$value['tw_Uwagi'];
		else
			$data[$id]['comments']="";
		if($value['VAT'])
			$data[$id]['vat']=$value['VAT'];
		else
			$data[$id]['vat']="";
		if($value['tw_Symbol'])
			$data[$id]['code']=$value['tw_Symbol'];
		else
			$data[$id]['code']="";
			
		$data[$id]['date_upd']=date("Y-m-d");
			
			$to_update = 0;
			$this->db->select('id_product');
			$this->db->from('products');
			$this->db->where('id_product', $value['tw_Id']);
			foreach($this->db->get()->result() as $item)
			{	
				$to_update = 1;
			}
			if($to_update == 1)
				$data_update[$id] = $data[$id];
			else
				{
				$data[$id]['date_add']=date("Y-m-d");
				$data[$id]['id_status']=2;
				if($value['tc_CenaNetto1'])
					$data[$id]['price']=$value['tc_CenaNetto1'];
				else
					$data[$id]['price']=0;
				$data_insert[$id] = $data[$id];
				
				}
		}
		$a=1;$b=1;
		print_r($data_update);
		print_r($data_insert);
		if(isset($data_update))
			$a=$this->db->update_batch('products', $data_update, 'id_product'); 
		if(isset($data_insert))			
			$b=$this->db->insert_batch('products', $data_insert);
		echo $a."<br/>";
		echo $b."<br/>";
		//if($a == 1 && $b == 1)
		//	return 1;
		//else return "error";

	}
	public function updateProducts($post=array())
	{
		foreach($post as $id=>$value)
		{
			$data[$id]['id_product']=$value['id_product'];
			$data[$id]['name']=$value['name'];
			$data[$id]['description']=$value['description'];
			$data[$id]['price']=$value['price'];
			$data[$id]['color']=$value['color'];
			$data[$id]['producent']=$value['producent'];
			$data[$id]['comments']=$value['comments'];
			$data[$id]['vat']=$value['vat'];
			$data[$id]['code']=$value['code'];
			$data[$id]['date_edited']=date("Y-m-d");
			$data[$id]['id_category']=$value['id_category'];
		}
		$this->db->update_batch('products', $data, 'id_product'); 
	}
	//favourite list
	public function getFavoriteList($id_user)
	{	$list=array();
		$this->db->select('id_product');
		$this->db->from('favorites_list');
		$this->db->where('id_user ', $id_user);
		$fields = $this->db->list_fields('favorites_list');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_product]=$item->id_product;
							}
		}	
		return $list;
	}
	public function addToFavoriteList($id_product,$id_user)
	{	
		$this->db->select('id_product');
		$this->db->from('favorites_list');
		$this->db->where('id_product ', $id_product);
		$this->db->where('id_user ', $id_user);
		foreach($this->db->get()->result() as $item)
		{	
			$id_favorite=1;
		}	
		if(isset($id_favorite))
		{
			$this->db->where('id_product ', $id_product);
			$this->db->where('id_user ', $id_user);
			$this->db->delete('favorites_list');
		}
		else
		{
			$data['id_product']=$id_product;
			$data['id_user']=$id_user;
			$data['date_add']=date("Y-m-d");
			$this->db->insert('favorites_list', $data); 
		}
	}
	// categories
	public function getCategoriesList($id=0)
	{
		$this->db->select('*');
		$this->db->from('products_categories');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_parent ', $id);
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
	
	public function getCategoriesListGroupByParent()
	{
		$query="
			SELECT pc . * , COUNT( p.id_product ) AS cnt
			FROM products_categories AS pc
			LEFT JOIN products AS p ON p.id_category = pc.id_category
			WHERE pc.id_status != 0
			GROUP BY pc.id_category";	
		$result = $this->db->query($query);		
		
		$list = array();
		$fields = $this->db->list_fields('products_categories');
		foreach($result->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_parent][$item->id_category][$field]=$item->$field;
							}
							$list[$item->id_parent][$item->id_category]['count']=$item->cnt;
		}	
		return $list;
	}
	public function getCategoriesListByParentId($id=0)
	{
		$query="
			SELECT pc . *
			FROM products_categories AS pc
			WHERE pc.id_status != 0 and id_parent =".$id;

		$result = $this->db->query($query);		
		
		$list = array();
		$fields = $this->db->list_fields('products_categories');
		foreach($result->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_category][$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function getCategoryById($id=0)
	{
		$this->db->select('*');
		$this->db->from('products_categories');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_category', $id);
		$list = array();
		$fields = $this->db->list_fields('products_categories');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
		}	
		if(!isset($list['id_parent']))
			$list['id_parent']=0;
		return $list;
	}
	
	private function getUserAccess($user_tab=array())
	{	;
		$this->db->select('id_product');
		$this->db->from('products_availability_users');
		$this->db->where('id_user', $user_tab['id_user']);
		$list = array();
		foreach($this->db->get()->result() as $item)
		{	
							$list['user'][$item->id_product]=$item->id_product;
		}	
		$this->db->select('id_product');
		$this->db->from('products_availability_clients');
		$this->db->where('id_client', $user_tab['id_client']);
		foreach($this->db->get()->result() as $item)
		{				
							$list['client'][$item->id_product]=$item->id_product;
		}	
		return $list;
	}
	
	// products
	public function getIdProductsInPromotions($id_client=0)
	{
		$this->db->select('id_product');
		$this->db->from('promotions as p');
		$this->db->join('promotions_groups as pg', 'p.id_promotion = pg.id_promotion', 'left');
		$this->db->join('groups_clients as gc', 'gc.id_group = pg.id_group', 'left');
		$this->db->where('gc.id_client ', $id_client);
		$this->db->where('p.id_status ', 1);
		$this->db->group_by('id_product');
		$list = array();
		$a = 0;
		foreach($this->db->get()->result() as $item)
		{	
			
			$tab[$item->id_product] = $item->id_product;
					
		}
			return $tab;
	}
	public function countProductsToCategory($id_category=0,$user_tab=array())
	{	
		$access_data=$this->getUserAccess($user_tab);
		$where_in_id=array();
		if($id_category != 0)
		{	$where_in_id=$id_category;
			$cats=$this->getCategoriesList($id_category);
			foreach($cats as $id=>$value)
				$where_in_id.=",".$id;
		}
		if($id_category != 0)
			$query="
			SELECT p . * , COUNT( pa.id_product ), COUNT( pa.id_product ) AS cnt, COUNT( pac.id_product ) AS cnt2
			FROM products AS p
			LEFT JOIN products_availability_users AS pa ON p.id_product = pa.id_product
			LEFT JOIN products_availability_clients AS pac ON p.id_product = pac.id_product
			WHERE p.id_category IN (".$where_in_id.")
			AND  p.id_status = 1
			GROUP BY p.id_product";	
		$result = $this->db->query($query);		
		$count =0;
			
		foreach($result->result() as $item)
		{	$access_prod=1;
			if($item->cnt > 0)
			{ echo $item->id_product;
				if(!isset($access_data['user'][$item->id_product]))
					$access_prod=0;
			}
			else if($item->cnt2 > 0)
			{
				if(!isset($access_data['client'][$item->id_product]))
					$access_prod=0;
			}
			
			if($access_prod == 1)
			{
				$count++;
			}
		}	
		return $count;		
	}
	public function getProductsToCategory($id_category=0,$user_tab=array(),$page_start=0)
	{	
		$access_data=$this->getUserAccess($user_tab);
		$where_in_id=array();
		
		if($id_category != 0)
		{	$where_in_id=$id_category;
			$cats=$this->getCategoriesList($id_category);
			foreach($cats as $id=>$value)
				$where_in_id.=",".$id;
		}
		if($id_category != 0)
			$query="
			SELECT p . * , COUNT( pa.id_product ), COUNT( pa.id_product ) AS cnt, COUNT( pac.id_product ) AS cnt2, img.url as url
			FROM products AS p
			LEFT JOIN products_availability_users AS pa ON p.id_product = pa.id_product
			LEFT JOIN products_availability_clients AS pac ON p.id_product = pac.id_product
			LEFT JOIN products_images AS img ON p.id_product = img.id_product
			WHERE p.id_category IN (".$where_in_id.")
			AND  p.id_status = 1
			GROUP BY p.id_product limit ".$page_start.", 20";	
		$result = $this->db->query($query);		
		$list = array();
		$fields = $this->db->list_fields('products');
			
		foreach($result->result() as $item)
		{	$access_prod=1;
			if($item->cnt > 0)
			{ echo $item->id_product;
				if(!isset($access_data['user'][$item->id_product]))
					$access_prod=0;
			}
			else if($item->cnt2 > 0)
			{
				if(!isset($access_data['client'][$item->id_product]))
					$access_prod=0;
			}
			
			if($access_prod == 1)
			{
				
				foreach ($fields as $field)
							{
							$list[$item->id_product][$field]=$item->$field;
							}
							/* get correct price */
							if($item->fixed_price > 0)
							{
								$list[$item->id_product]['price'] = $item->fixed_price;
								$list[$item->id_product]['old_price'] = $item->price;
							}		
							else
							{	$id_group = $this->groups->getGroupForClient($this->session->userdata('id_client'));
								$this->db->select('d.price as price');
								$this->db->from('promotions as p');
								$this->db->join('promotions_dates as d', 'd.id_promotion = p.id_promotion', 'left');
								$this->db->join('promotions_groups as g', 'g.id_promotion = p.id_promotion', 'left');
								$this->db->where('p.id_product', $item->id_product);
								$this->db->where('p.id_status', 1);
								$this->db->where('g.id_group', $id_group);
								$this->db->where('d.date_from <=', date("Y-m-d"));
								$this->db->where('d.date_to >=', date("Y-m-d"));
								$this->db->where('p.id_type', 1);						
								foreach($this->db->get()->result() as $item1)
								{	
									$list[$item->id_product]['price'] = $item1->price;
									$list[$item->id_product]['old_price'] = $item->price;
								}	
								if(!isset($list[$item->id_product]['old_price']))
								{							
									$this->db->select('p.discount as discount');
									$this->db->from('discounts as d');
									$this->db->join('discounts_positions as p', 'p.id_discount = d.id_discount', 'left');
									$this->db->join('discounts_groups as g', 'g.id_discount = d.id_discount', 'left');
									$this->db->where('d.id_category', $item->id_category);
									$this->db->where('d.id_status', 1);
									$this->db->where('g.id_group', $id_group);
									$this->db->where('p.amount', 0);
									foreach($this->db->get()->result() as $item2)
										{	
										$list[$item->id_product]['price'] = $item->price - (($item->price*$item2->discount)/100);
										$list[$item->id_product]['old_price'] = $item->price;
										}
								}
							}
							/* end  get correct price */
							
							$list[$item->id_product]['count_u']=$item->cnt;
							$list[$item->id_product]['count_c']=$item->cnt2;
							$list[$item->id_product]['url']=$item->url;
			}
		}	
		return $list;
	}
	private function getOrderedBefore($id_user=0){
		$this->db->select('cp.id_product');
		$this->db->from('carts_products as cp');
		$this->db->join('carts as c', 'c.id_cart = cp.id_cart', 'left');
		$this->db->where('c.id_user', $id_user);	
		$this->db->group_by('cp.id_product');			
		foreach($this->db->get()->result() as $item)
		{	
				$list[$item->id_product]=$item->id_product;
		}	
		return $list;
	}
	
	public function getProductsToSearch($get=array(),$user_tab=array(),$page_start=0)
	{
		if(count($get)>0)
		{
			$access_data=$this->getUserAccess($user_tab);
			$where="";
			$inFavorite=array();
			$orderedBefore=array();
			if(isset($get['search']))
			{
				$where.="p.name like '%".$get['search']."%' or p.code like '%".$get['search']."%' or p.description like '%".$get['search']."%'";
			}
			if(isset($get['producent']))
			{	
				if($get['producent']!=0)
				{
					if($where != "")
						$where.=" and ";				
					$where.=" p.id_producer =".$get['producent'];
				}
			}
			if(isset($get['priceFrom']))
			{	
				if($get['priceFrom']!="")
				{
					if($where != "")
						$where.=" and ";
					$where.=" p.price > '".$get['priceFrom']."'";
				}
			}
			if(isset($get['priceTo']))
			{	
				if($get['priceTo']!="")
				{
					if($where != "")
						$where.=" and ";				
					$where.=" p.price < '".$get['priceTo']."'";
				}
			}
			if(isset($get['color']))
			{	if($get['color']!=0)
				{
					if($where != "")
						$where.=" and ";					
					$where.=" p.id_color =".$get['color'];
				}
			}
			if(isset($get['orderedBefore']))
			{
				if($get['orderedBefore'] == 1)
				{
					$orderedBefore=$this->getOrderedBefore($this->session->userdata('id_user'));					
				}
			}
			
			if(isset($get['inFavorite']))
			{
				if($get['inFavorite'] == 1)
				{
					$inFavorite=$this->getFavoriteList($this->session->userdata('id_user'));			
				}
			}
			$where_in_tab=$inFavorite + $orderedBefore;
			if(count($where_in_tab)>0)
				{
					if($where != "")
						$where.=" and ";	
				$w="p.id_product IN (";
				foreach($where_in_tab as $id=>$value)
					{	if($w == "p.id_product IN (")
							$w.=$id;
						else
							$w.=",".$id;					
					}
				$w.=")";
				$where.=$w;
				}
			
			if($where != "")
			{
				$query="
					SELECT p . * , COUNT( pa.id_product ), COUNT( pa.id_product ) AS cnt, COUNT( pac.id_product ) AS cnt2, img.url as url
					FROM products AS p
					LEFT JOIN products_availability_users AS pa ON p.id_product = pa.id_product
					LEFT JOIN products_availability_clients AS pac ON p.id_product = pac.id_product
					LEFT JOIN products_images AS img ON p.id_product = img.id_product
					WHERE ".$where." 
					AND  p.id_status = 1
					GROUP BY p.id_product limit ".$page_start.", 20";	
				$result = $this->db->query($query);		
				$list = array();
				$fields = $this->db->list_fields('products');
					
				foreach($result->result() as $item)
				{	$access_prod=1;
					if($item->cnt > 0)
					{ echo $item->id_product;
						if(!isset($access_data['user'][$item->id_product]))
							$access_prod=0;
					}
					else if($item->cnt2 > 0)
					{
						if(!isset($access_data['client'][$item->id_product]))
							$access_prod=0;
					}
					
					if($access_prod == 1)
					{
						foreach ($fields as $field)
									{
									$list[$item->id_product][$field]=$item->$field;
									}
									/* get correct price */
									if($item->fixed_price > 0)
									{
										$list[$item->id_product]['price'] = $item->fixed_price;
										$list[$item->id_product]['old_price'] = $item->price;
									}		
									else
									{	$id_group = $this->groups->getGroupForClient($this->session->userdata('id_client'));
										$this->db->select('d.price as price');
										$this->db->from('promotions as p');
										$this->db->join('promotions_dates as d', 'd.id_promotion = p.id_promotion', 'left');
										$this->db->join('promotions_groups as g', 'g.id_promotion = p.id_promotion', 'left');
										$this->db->where('p.id_product', $item->id_product);
										$this->db->where('p.id_status', 1);
										$this->db->where('g.id_group', $id_group);
										$this->db->where('d.date_from <=', date("Y-m-d"));
										$this->db->where('d.date_to >=', date("Y-m-d"));
										$this->db->where('p.id_type', 1);						
										foreach($this->db->get()->result() as $item1)
										{	
											$list[$item->id_product]['price'] = $item1->price;
											$list[$item->id_product]['old_price'] = $item->price;
										}	
										if(!isset($list[$item->id_product]['old_price']))
										{							
											$this->db->select('p.discount as discount');
											$this->db->from('discounts as d');
											$this->db->join('discounts_positions as p', 'p.id_discount = d.id_discount', 'left');
											$this->db->join('discounts_groups as g', 'g.id_discount = d.id_discount', 'left');
											$this->db->where('d.id_category', $item->id_category);
											$this->db->where('d.id_status', 1);
											$this->db->where('g.id_group', $id_group);
											$this->db->where('p.amount', 0);
											foreach($this->db->get()->result() as $item2)
												{	
												$list[$item->id_product]['price'] = $item->price - (($item->price*$item2->discount)/100);
												$list[$item->id_product]['old_price'] = $item->price;
												}
										}
									}
									/* end  get correct price */
									$list[$item->id_product]['count_u']=$item->cnt;
									$list[$item->id_product]['count_c']=$item->cnt2;
									$list[$item->id_product]['url']=$item->url;
					}
				}	
				return $list;	
			}
		}
		else
			return array();
	}
	public function countProductsToSearch($get=array(),$user_tab=array(),$page_start=0)
	{	$count=0;
		if(count($get)>0)
		{
			$access_data=$this->getUserAccess($user_tab);
			$where="";
			if(isset($get['name']))
			{
				$where.="p.name like '%".$get['name']."%'";
			}
			if(isset($get['producent']))
			{	
				if($get['producent']!=0)
				{
					if($where != "")
						$where.=" and ";				
					$where.="p.id_producer =".$get['producent'];
				}
			}
			if(isset($get['priceFrom']))
			{	
				if($get['priceFrom']!="")
				{
					if($where != "")
						$where.=" and ";
					$where.="p.price > '".$get['priceFrom']."'";
				}
			}
			if(isset($get['priceTo']))
			{	
				if($get['priceTo']!="")
				{
					if($where != "")
						$where.=" and ";				
					$where.="p.price < '".$get['priceTo']."'";
				}
			}
			if(isset($get['color']))
			{	if($get['color']!=0)
				{
					if($where != "")
						$where.=" and ";					
					$where.="p.id_color =".$get['color'];
				}
			}
			if($where != "")
			{
			
				$query="
					SELECT p . * , COUNT( pa.id_product ), COUNT( pa.id_product ) AS cnt, COUNT( pac.id_product ) AS cnt2, img.url as url
					FROM products AS p
					LEFT JOIN products_availability_users AS pa ON p.id_product = pa.id_product
					LEFT JOIN products_availability_clients AS pac ON p.id_product = pac.id_product
					LEFT JOIN products_images AS img ON p.id_product = img.id_product
					WHERE ".$where."
					GROUP BY p.id_product limit ".$page_start.", 20";	
				$result = $this->db->query($query);		
					
				foreach($result->result() as $item)
				{	$access_prod=1;
					if($item->cnt > 0)
					{ echo $item->id_product;
						if(!isset($access_data['user'][$item->id_product]))
							$access_prod=0;
					}
					else if($item->cnt2 > 0)
					{
						if(!isset($access_data['client'][$item->id_product]))
							$access_prod=0;
					}
					
					if($access_prod == 1)
					{
						$count++;
					}
				}	
				return $count;	
			}
		}
		else
			return 0;
	}
	public function getProductsToPromotions($user_tab=array(),$page_start=0)
	{
		$access_data=$this->getUserAccess($user_tab);
		$where_in_id="";
		$this->db->select('id_product');
		$this->db->from('promotions as p');
		$this->db->join('promotions_groups as pg', 'p.id_promotion = pg.id_promotion', 'left');
		$this->db->join('groups_clients as gc', 'gc.id_group = pg.id_group', 'left');
		$this->db->where('gc.id_client ', $user_tab['id_client']);
		$this->db->where('p.id_status ', 1);
		$this->db->group_by('id_product');
		$list = array();
		$a = 0;
		foreach($this->db->get()->result() as $item)
		{	
			
			$where_in_id .= $item->id_product;
			if($a < count($item)-1)
				$where_in_id .=",";	
			$a++;
			$is_product = 1;
			
		}	
		if(isset($is_product))
		{
				$query="
				SELECT p . * , COUNT( pa.id_product ), COUNT( pa.id_product ) AS cnt, COUNT( pac.id_product ) AS cnt2, img.url as url
				FROM products AS p
				LEFT JOIN products_availability_users AS pa ON p.id_product = pa.id_product
				LEFT JOIN products_availability_clients AS pac ON p.id_product = pac.id_product
				LEFT JOIN products_images AS img ON p.id_product = img.id_product
				WHERE p.id_product IN (".$where_in_id.")
				AND  p.id_status = 1
				GROUP BY p.id_product limit ".$page_start.", 20";	
				
				
			$result = $this->db->query($query);		
			$list = array();
			$fields = $this->db->list_fields('products');
				
			foreach($result->result() as $item)
			{	$access_prod=1;
				if($item->cnt > 0)
				{ echo $item->id_product;
					if(!isset($access_data['user'][$item->id_product]))
						$access_prod=0;
				}
				else if($item->cnt2 > 0)
				{
					if(!isset($access_data['client'][$item->id_product]))
						$access_prod=0;
				}
				
				if($access_prod == 1)
				{
					
					foreach ($fields as $field)
								{
								$list[$item->id_product][$field]=$item->$field;
								}
								/* get correct price */
								if($item->fixed_price > 0)
								{
									$list[$item->id_product]['price'] = $item->fixed_price;
									$list[$item->id_product]['old_price'] = $item->price;
								}		
								else
								{	$id_group = $this->groups->getGroupForClient($this->session->userdata('id_client'));
									$this->db->select('d.price as price');
									$this->db->from('promotions as p');
									$this->db->join('promotions_dates as d', 'd.id_promotion = p.id_promotion', 'left');
									$this->db->join('promotions_groups as g', 'g.id_promotion = p.id_promotion', 'left');
									$this->db->where('p.id_product', $item->id_product);
									$this->db->where('p.id_status', 1);
									$this->db->where('g.id_group', $id_group);
									$this->db->where('d.date_from <=', date("Y-m-d"));
									$this->db->where('d.date_to >=', date("Y-m-d"));
									$this->db->where('p.id_type', 1);						
									foreach($this->db->get()->result() as $item1)
									{	
										$list[$item->id_product]['price'] = $item1->price;
										$list[$item->id_product]['old_price'] = $item->price;
									}	
									if(!isset($list[$item->id_product]['old_price']))
									{							
										$this->db->select('p.discount as discount');
										$this->db->from('discounts as d');
										$this->db->join('discounts_positions as p', 'p.id_discount = d.id_discount', 'left');
										$this->db->join('discounts_groups as g', 'g.id_discount = d.id_discount', 'left');
										$this->db->where('d.id_category', $item->id_category);
										$this->db->where('d.id_status', 1);
										$this->db->where('g.id_group', $id_group);
										$this->db->where('p.amount', 0);
										foreach($this->db->get()->result() as $item2)
											{	
											$list[$item->id_product]['price'] = $item->price - (($item->price*$item2->discount)/100);
											$list[$item->id_product]['old_price'] = $item->price;
											}
									}
								}
								/* end  get correct price */
								
								$list[$item->id_product]['count_u']=$item->cnt;
								$list[$item->id_product]['count_c']=$item->cnt2;
								$list[$item->id_product]['url']=$item->url;
				}
			}	
			}
		return $list;
	}
	
	public function countProductsToPromotions($user_tab=0,$page_start=0)
	{
				
		$this->db->select('COUNT(p.id_product) as amount');
		$this->db->from('promotions as p');
		$this->db->join('promotions_groups as pg', 'p.id_promotion = pg.id_promotion', 'left');
		$this->db->join('groups_clients as gc', 'gc.id_group = pg.id_group', 'left');
		$this->db->where('gc.id_client ', $user_tab['id_client']);
		$this->db->where('p.id_status ', 1);

		$list = array();
		foreach($this->db->get()->result() as $item)
		{	
				return  $item->amount;
							
		}	
	}
	public function getProductsList($id_category=0)
	{
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_category', $id_category);
		$list = array();
		$fields = $this->db->list_fields('products');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_product][$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function getNewProductsList()
	{
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('id_status !=', 0);
		$this->db->where('date_edited', "0000-00-00");
		$list = array();
		$fields = $this->db->list_fields('products');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_product][$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function getStatusList()
	{
		$this->db->select('*');
		$this->db->from('products_info_status');
		$this->db->where('id_status !=', 0);
		$list = array();
		$fields = $this->db->list_fields('products_info_status');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_info_status][$field]=$item->$field;
							}
		}	
		return $list;
	}
	
	public function getProductById($id=0)
	{
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_product', $id);
		$list = array();
		$fields = $this->db->list_fields('products');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
							/* get correct price */
							if($item->fixed_price > 0)
							{
								$list['price'] = $item->fixed_price;
								$list['old_price'] = $item->price;
							}		
							else
							{	$id_group = $this->groups->getGroupForClient($this->session->userdata('id_client'));
								$this->db->select('d.price as price');
								$this->db->from('promotions as p');
								$this->db->join('promotions_dates as d', 'd.id_promotion = p.id_promotion', 'left');
								$this->db->join('promotions_groups as g', 'g.id_promotion = p.id_promotion', 'left');
								$this->db->where('p.id_product', $item->id_product);
								$this->db->where('p.id_status', 1);
								$this->db->where('g.id_group', $id_group);
								$this->db->where('d.date_from <=', date("Y-m-d"));
								$this->db->where('d.date_to >=', date("Y-m-d"));
								$this->db->where('p.id_type', 1);						
								foreach($this->db->get()->result() as $item1)
								{	
									$list['price'] = $item1->price;
									$list['old_price'] = $item->price;
								}	
								if(!isset($list[$item->id_product]['old_price']))
								{							
									$this->db->select('p.discount as discount');
									$this->db->from('discounts as d');
									$this->db->join('discounts_positions as p', 'p.id_discount = d.id_discount', 'left');
									$this->db->join('discounts_groups as g', 'g.id_discount = d.id_discount', 'left');
									$this->db->where('d.id_category', $item->id_category);
									$this->db->where('d.id_status', 1);
									$this->db->where('g.id_group', $id_group);
									$this->db->where('p.amount', 0);
									foreach($this->db->get()->result() as $item2)
										{	
										$list['price'] = $item->price - (($item->price * $item2->discount)/100);
										$list['old_price'] = $item->price;
										}
								}
							}
							/* end  get correct price */
		}	
		return $list;
	}
	
	public function getProductWithPriceById($id=0)
	{
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_product', $id);
		$list = array();
		$fields = $this->db->list_fields('products');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
		}	
		return $list;
	}
	
	public function changeStatus($id_product=0,$id_status=1)
	{
		$data['id_info_status'] = $id_status;
		$this->db->where('id_product',$id_product);	
		return $this->db->update("products", $data); 
	}
	
	public function uploadCategoryImage($id=0,$data=array())
	{
		$config['upload_path'] = './images/categories/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			return $this->upload->display_errors();
		}
		else
		{
			$a= $this->upload->data();
			$data['img']=$a['file_name'];
			$configI['image_library'] = 'gd2';
			$configI['source_image']	= './images/categories/'.$a['file_name'];
			$configI['create_thumb'] = TRUE;
			$configI['maintain_ratio'] = TRUE;
			$configI['width']	 = 80;
			$configI['height']	= 80;
			$this->updateCategoryImage($a['file_name'],$id);
			$this->load->library('image_lib', $configI); 
			$this->image_lib->resize();
			return  $this->image_lib->display_errors('<p>', '</p>');
		}
	}
	
	private function updateCategoryImage($name,$id_category)
	{	
		$data['img']=$name;
		$this->db->where('id_category', $id_category);
		$this->db->update('products_categories', $data); 
	}
	
	public function uploadImage($id=0,$data=array())
	{	$images=$this->getImages($id);
		if(count($images)>=3)
			return "Możesz dodać maksymalnie 3 zdjęcia";
		$config['upload_path'] = './uploads/images/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			return $this->upload->display_errors();
		}
		else
		{
			$a= $this->upload->data();
			$data['img']=$a['file_name'];
			$configI['image_library'] = 'gd2';
			$configI['source_image']	= './uploads/images/'.$a['file_name'];
			$configI['create_thumb'] = TRUE;
			$configI['maintain_ratio'] = TRUE;
			$configI['width']	 = 170;
			$configI['height']	= 220;
			$this->insertImage($a['file_name'],$id);
			$this->load->library('image_lib', $configI); 
			$this->image_lib->resize();
			return  $this->image_lib->display_errors('<p>', '</p>');
		}
	}
	private function insertImage($name,$id_product)
	{	
		$data['url']=$name;
		$data['id_product']=$id_product;
		$this->db->insert('products_images', $data); 
	}
	public function getImages($id_product=0)
	{	$list=array();
		$this->db->select('*');
		$this->db->from('products_images');
		$this->db->where('id_product', $id_product);
		$this->db->where('id_status', 1);
		$fields = $this->db->list_fields('products_images');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_image][$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function deleteImage($id=0)
	{			
		$this->db->where('id_image ',$id);
		return $this->db->delete("products_images"); 	
	}
	public function updateSettings($id=0,$data=array())
	{
		$tab['loyalty']=$data['loyalty'];
		$tab['id_status']=$data['id_status'];
		$tab['discount']=$data['discount'];
		$tab['description']=$data['description'];
		$tab['date_edited']=date("Y-m-d H:i:s");
		$this->db->where('id_product ',$id);
		return $this->db->update('products',$tab); 		
	}
	public function changeCategory($id=0,$data=array())
	{
		$tab['id_category']=$data['id_category'];
		$tab['date_edited']=date("Y-m-d H:i:s");
		$this->db->where('id_product ',$id);
		return $this->db->update('products',$tab); 		
	}
	public function updatePrice($id=0,$data=array())
	{	
		$tab['price']=$data['price'];
		$tab['fixed_price']=$data['fixed_price'];
		$tab['date_edited']=date("Y-m-d");
		$this->db->where('id_product ',$id);
		return $this->db->update('products',$tab); 		
	}
	public function getProductAvailabilityClients($id=0)
	{
		$this->db->select('*');
		$this->db->from('products_availability_clients');
		$this->db->where('id_product', $id);
		$list=array();
		foreach($this->db->get()->result() as $item)
		{	
							$list[$item->id_client]=$item->id_client;
		}	
		return $list;

	}
	public function getProductAvailabilityUsers($id=0)
	{
		$this->db->select('*');
		$this->db->from('products_availability_users');
		$this->db->where('id_product', $id);
		$list = array();
		foreach($this->db->get()->result() as $item)
		{	
							$list[$item->id_user]=$item->id_user;
		}	
		return $list;

	}
	public function updateProductsAvailability($id=0,$data=array())
	{	
		$this->db->where('id_product ',$id);
		$this->db->delete('products_availability_clients'); 	
		if(isset($data['id_clients_availability']))
		{			
			foreach($data['id_clients_availability'] as $value)
				$tab[$value] =  array('id_product' => $id, 'id_client' => $value);

			$this->db->insert_batch('products_availability_clients', $tab); 
		}
		
		$this->db->where('id_product',$id);
		$this->db->delete('products_availability_users'); 	
		if(isset($data['id_users_availability']))
		{
			$tab=array();			
			foreach($data['id_users_availability'] as $value)
				$tab[$value] =  array('id_product' => $id, 'id_user' => $value);
			$this->db->insert_batch('products_availability_users', $tab); 
		}
		return 1;
		
	}
	
	public function getCategoryParentId($id=0){
		$this->db->select('id_parent');
		$this->db->where('id_category', $id);
		$query = $this->db->get('products_categories', 1);
		if($query->num_rows() > 0){
			$row = $query->row();
			return $row->id_parent;
		}
		return null;
	}
	
	public function insertCategory($post, $id_parent){
		$data['date_upd'] = date("Y-m-d H:i:s");
		$data['name'] = $post['name'];
		$data['id_parent'] = $id_parent;
		return $this->db->insert("products_categories",$data); 
	}
	
	public function updateCategory($post, $id){
		$data['date_upd'] = date("Y-m-d H:i:s");
		$this->db->where('id_category',$id);
		$data['name'] = $post['name'];
		return $this->db->update("products_categories",$data); 
	}
	
	public function getColorById($id=null){
		if($id){
			$this->db->select('*');
			$this->db->where('id_color', $id);
			$query = $this->db->get('colors', 1);
			if($query->num_rows() > 0){
				$return = array();
				foreach($query->result_array() as $r){
					$return = $r;
				}
				return $return;
			}
		}
		return array();
	}
	
	public function getColorsList($id_as_key = false, $order = 'name'){
		$this->db->select('*');
		$this->db->where('id_status', 1);
		if($order) $this->db->order_by($order);
		$query = $this->db->get('colors');
		if($query->num_rows() > 0){
			$return = array();
			if($id_as_key){
				foreach($query->result_array() as $r){
					$return[$r['id_color']] = $r;
				}
			} else {
				$return = $query->result_array();
			}
			return $return;
		}
		return array();
	}
	
	public function insertColor($post){
		$data['date_upd'] = date("Y-m-d H:i:s");
		$data['name'] = $post['name'];
		return $this->db->insert("colors",$data); 
	}
	
	public function updateColor($post, $id){
		$data['date_upd'] = date("Y-m-d H:i:s");
		$this->db->where('id_color',$id);
		$data['name'] = $post['name'];
		return $this->db->update("colors",$data); 
	}
	
	public function getProducerById($id=null){
		if($id){
			$this->db->select('*');
			$this->db->where('id_producer', $id);
			$query = $this->db->get('producers', 1);
			if($query->num_rows() > 0){
				$return = array();
				foreach($query->result_array() as $r){
					$return = $r;
				}
				return $return;
			}
		}
		return array();
	}
	
	public function getProducersList($id_as_key = false, $order = 'name'){
		$this->db->select('*');
		$this->db->where('id_status', 1);
		if($order) $this->db->order_by($order);
		$query = $this->db->get('producers');
		if($query->num_rows() > 0){
			$return = array();
			if($id_as_key){
				foreach($query->result_array() as $r){
					$return[$r['id_producer']] = $r;
				}
			} else {
				$return = $query->result_array();
			}
			return $return;
		}
		return array();
	}
	
	public function insertProducer($post){
		$data['date_upd'] = date("Y-m-d H:i:s");
		$data['name'] = $post['name'];
		return $this->db->insert("producers",$data); 
	}
	
	public function updateProducer($post, $id){
		$data['date_upd'] = date("Y-m-d H:i:s");
		$this->db->where('id_producer',$id);
		$data['name'] = $post['name'];
		return $this->db->update("producers",$data); 
	}	
	
}