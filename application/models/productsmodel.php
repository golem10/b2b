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
	public function importProducts($post=array(),$id_list)
	{	//echo "<br/>".count($post['Results_from_Query_x003A__Products'])."<br/>";
		if(isset($post['Results_from_Query_x003A__Products']['tw_Id']))
		{
			foreach($post as $id=>$value)
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
				
			if($value['tc_CenaNetto1'])
				$data[$id]['price']=str_replace(",",".",$value['tc_CenaNetto1']);
			else
				$data[$id]['price']=0;	
				
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
					
					$data_insert[$id] = $data[$id];
					
					}
			}
		}
		else
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
				
			if($value['tc_CenaNetto1'])
				$data[$id]['price']=str_replace(",",".",$value['tc_CenaNetto1']);
			else
				$data[$id]['price']=0;
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
					
					$data_insert[$id] = $data[$id];
					
					}
			}
		}
		$a=1;$b=1;
		$array_hist = array();
		// print_r($data_update);echo "<br/>";
		// print_r($data_insert);
		if(isset($data_update))
			{$array_hist = array_merge($array_hist, $data_update);
			$this->db->update_batch('products', $data_update, 'id_product'); 
			if($this->db->affected_rows() > 0) $a =1; else  $a = 0;
			
			}
		if(isset($data_insert))	
			{
			$this->db->insert_batch('products', $data_insert);
			$array_hist = array_merge($array_hist, $data_insert);
			if($this->db->affected_rows() > 0) $b =1; else  $b = 0;
			}
		if(count($array_hist))
			{
			foreach($array_hist as $k=>$v)
				{
				$array_hist[$k]['id_import'] = $id_list;	
				if(isset($array_hist[$k]['date_add']))
					unset($array_hist[$k]['date_add']);
				if(isset($array_hist[$k]['id_status']))
					unset($array_hist[$k]['id_status']);
				}
				$this->db->insert_batch('import_products',$array_hist);
			
			}
		//echo $a."<br/>";
		//echo $b."<br/>";
		if($a == 1 && $b == 1)
			return 1;
		else return 0;

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
	
	public function getProductsImportDetails($id_product=0)
	{	$this->db->select('ip.*, il.time_start');
		$this->db->from('import_products ip');
		$this->db->join('import_list as il', 'il.id_import = ip.id_import', 'left');
		$this->db->where('id_product', $id_product);
		$fields = $this->db->list_fields('import_products');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id][$field]=$item->$field;
							}
							$list[$item->id]['date']=$item->time_start;
		}	
		return $list;
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
	public function getCategoriesListGroupByParentAccess($user_tab)
	{	$array_diff = array();
	$start_time = $last_time = $this->microtime_float();

		$access_data=$this->getUserAccess($user_tab);	
			if(count($access_data['products']) > 0)
			{
				$this->db->select('id_category, COUNT(id_product) as cnt');
				$this->db->from('products');
				$this->db->where_in('id_product', $access_data['products']);
				$this->db->where('id_status', 1);			
				$this->db->group_by('id_category');			
				$list = array();
				foreach($this->db->get()->result() as $item)
				{	
					$cat_count_access[$item->id_category]=$item->cnt;
				}
			
			}
			
			$where_in_id_cat = "";
			if($access_data['categories'] && $access_data['category_with_products'])
				$array_diff = array_diff($access_data['categories'],$access_data['category_with_products']);
			
			
		$query="
			SELECT pc . * 	
			FROM products_categories AS pc
			WHERE pc.id_status != 0
			order by pc.name";
		$result = $this->db->query($query);	
		
		$query = "SELECT COUNT( id_product ) as cnt, id_category
			FROM  `products` 
			WHERE id_status = 1
			GROUP BY id_category";
		$result_counts = $this->db->query($query);	
		foreach($result_counts->result() as $item)
			$products_counts[$item->id_category] = $item->cnt;
		$last_time = $this->microtime_float();
		$list = array();
		$fields = $this->db->list_fields('products_categories');
		foreach($result->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_parent][$item->id_category][$field]=$item->$field;
							}
							if(isset($products_counts[$item->id_category]))			
								$list[$item->id_parent][$item->id_category]['count']=$products_counts[$item->id_category];
							else
								$list[$item->id_parent][$item->id_category]['count'] = 0;
							if(isset($cat_count_access[$item->id_category]))
								$list[$item->id_parent][$item->id_category]['count2']=$cat_count_access[$item->id_category];
							else if(in_array($item->id_category,$array_diff))
							{
								if(isset($products_counts[$item->id_category]))		
									$list[$item->id_parent][$item->id_category]['count2']=$products_counts[$item->id_category];
								else
									$list[$item->id_parent][$item->id_category]['count'] = 0;
							}
								
							if(count($access_data['products']) > 0 && !isset($list[$item->id_parent][$item->id_category]['count2']))
							{
								$list[$item->id_parent][$item->id_category]['count2']=0;
							}
							if(count($access_data['categories']) > 0)
							{
								if(isset($access_data['categories'][$item->id_category]))
									$list[$item->id_parent][$item->id_category]['access']=1;
								else
									$list[$item->id_parent][$item->id_category]['access']=0;
							}
							else
								$list[$item->id_parent][$item->id_category]['access']=1;
							
		}	
		
		return $list;
	}
	
	public function getCategoriesListGroupByParent()
	{
		$query="
			SELECT pc . * , 
			(SELECT COUNT( p.id_product ) AS cnt1 from products  as p WHERE p.id_status = 1 and p.id_category = pc.id_category) as cnt		
			FROM products_categories AS pc
			WHERE pc.id_status != 0";
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
	public function getCategoriesListByParentId($id=0,$user_tab)
	{
		
		$access_data=$this->getUserAccess($user_tab);
			
		
		$query="
			 SELECT pc . *
			 FROM products_categories AS pc
			 WHERE pc.id_status != 0 and id_parent =".$id."
			order by pc.name";
			
		$result = $this->db->query($query);		
		
		$list = array();
		$fields = $this->db->list_fields('products_categories');
		foreach($result->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_category][$field]=$item->$field;
							}													
			

							if(count($access_data['categories']) > 0)
							{
								if(isset($access_data['categories'][$item->id_category]))
									$list[$item->id_category]['access']=1;
								else
									$list[$item->id_category]['access']=0;
							}
							else
								$list[$item->id_category]['access']=1;
							
		}	
		return $list;
		// $query="
			// SELECT pc . *
			// FROM products_categories AS pc
			// WHERE pc.id_status != 0 and id_parent =".$id;

		// $result = $this->db->query($query);		
		
		// $list = array();
		// $fields = $this->db->list_fields('products_categories');
		// foreach($result->result() as $item)
		// {	
				// foreach ($fields as $field)
							// {
							// $list[$item->id_category][$field]=$item->$field;
							// }
		// }	
		// return $list;
	}
	public function getCategoriesIdListByParentId($id=0)
	{
		
		
		$query="
			 SELECT pc . id_category
			 FROM products_categories AS pc
			 WHERE pc.id_status != 0 and id_parent =".$id;
			
		$result = $this->db->query($query);		
		
		$list = array();
		foreach($result->result() as $item)
		{	
							$list[$item->id_category]=$item->id_category;
						
		}	
		
		return $list;
		
	}
	public function getCategoryById($id=0)
	{
		$user_tab['id_user'] = $this->session->userdata('id_user');
		$access_data=$this->getUserAccess($user_tab);
		if(count($access_data['categories']) > 0)
				{
					if(!isset($access_data['categories'][$id]))
						return 0;
				}
				
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
	
	public function getUserAccess($user_tab=array())
	{	
		$this->db->select('id_category');
		$this->db->from('users_categories_availability');
		$this->db->where('id_user', $user_tab['id_user']);
		$list['categories']=array();
		$list['products'] = array();
		foreach($this->db->get()->result() as $item)
		{	
			$list['categories'][$item->id_category]=$item->id_category;
		}	
		$this->db->select('pa.id_product,p.id_category');
		$this->db->from('users_products_availability as pa');
		$this->db->join('products as p', 'pa.id_product = p.id_product', 'left');
		$this->db->where('id_user', $user_tab['id_user']);
		foreach($this->db->get()->result() as $item)
		{				
			$list['products'][$item->id_product]=$item->id_product;
			$list['category_with_products'][$item->id_category]=$item->id_category;
		}	
		return $list;
	}
	
	// products
	public function getIdProductsInPromotions($id_client=0)
	{	$tab= array();
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
	public function getIdProductInPromotions($id_client=0,$id_product=0)
	{	$tab= array();
		$this->db->select('id_product');
		$this->db->from('promotions as p');
		$this->db->join('promotions_groups as pg', 'p.id_promotion = pg.id_promotion', 'left');
		$this->db->join('groups_clients as gc', 'gc.id_group = pg.id_group', 'left');
		$this->db->where('gc.id_client ', $id_client);
		$this->db->where('p.id_status ', 1);
		$this->db->where('p.id_product ', $id_product);
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
		$count=0;
		if($id_category != 0)
		{	
			if(count($access_data['categories']) > 0)
				{
					if(isset($access_data['categories'][$id_category]))
							$where_in_id=$id_category;
				}	
			else
				$where_in_id=$id_category;
				
			$cats=$this->getCategoriesList($id_category);
			foreach($cats as $id=>$value)
			{
				if(count($access_data['categories']) > 0)
				{
					if(isset($access_data['categories'][$id]))
							$where_in_id.=",".$id;
				}				
				else
					$where_in_id.=",".$id;
				
			}
			
			$where_in_id_cat = "";
			$access_data['categories'][$id_category] = $id_category;
			$array_diff = array();
			if($access_data['categories'] && $access_data['products'])
				$array_diff = array_diff($access_data['categories'],$access_data['products']);
			$it=0;
			
			foreach($array_diff as $id=>$value)
			{ 	
				if(isset($cats[$id]))
				{
					IF($it==0)
					{
					$where_in_id_cat.=$id;
					$it=1;
					}
					else
						$where_in_id_cat.=",".$id;
				} 
				
			}
			
			if(count($cats) == 0)
				{
					$where_in_id_cat = $id_category;
				}
		}
			
					
		if($id_category != 0)
		{
			if(count($access_data['products']) > 0)
			{
			$where_in_idp="";
			foreach($access_data['products'] as $k=>$v)
			{
				if($where_in_idp!="") $where_in_idp .=",";
				$where_in_idp .= $v;
			}
			$query="
				SELECT p . *
				FROM products AS p
				WHERE";
				if($where_in_id_cat!="")
					$query.="(";
				$query.="(p.id_category IN (".$where_in_id.")
				AND  p.id_product IN (".$where_in_idp.")
				)";
				if($where_in_id_cat!="")
					$query.="OR p.id_category IN (".$where_in_id_cat."))";
				$query.="
				AND  p.id_status = 1		
				GROUP BY p.id_product";
				
			}
			else
			$query="
			SELECT p . * 
			FROM products AS p
			WHERE p.id_category IN (".$where_in_id.")
			AND  p.id_status = 1
			GROUP BY p.id_product";	
		}	
			
		$result = $this->db->query($query);		
		$list = array();
		$fields = $this->db->list_fields('products');
		return count($result->result());
		
	}
	public function getFixedPriceForProduct($id_product=0,$id_client=0)
	{	$price = 0;
		$this->db->select('price');
		$this->db->from('products_fixed_prices');
		$this->db->where('id_client', $id_client);
		$this->db->where('id_product', $id_product);
		foreach($this->db->get()->result() as $item)
		{	
			$price=$item->price;
		}	
		return $price;
	}
	public function getLoyaltyFixedPriceForProduct($id_product=0,$id_client=0)
	{	$loyalty = 0;
		$this->db->select('loyalty');
		$this->db->from('products_fixed_prices');
		$this->db->where('id_client', $id_client);
		$this->db->where('id_product', $id_product);
		foreach($this->db->get()->result() as $item)
		{	
			$loyalty=$item->loyalty;
		}	
		return $loyalty;
	}
	//// for tests
	public function microtime_float()
		{
			list($usec, $sec) = explode(" ", microtime());
			return ((float)$usec + (float)$sec);
		}
	public function getProductsSql($where,$order_by,$page_start,$per_page,$id_client=0,$amount=1)
	{
	$start_time = $last_time = $this->microtime_float();
	if($page_start == 0 && $per_page == 0)
		$limit ="";
	else
		$limit = 	"LIMIT ".$page_start.",".$per_page;
		
	$id_group = $this->groups->getGroupForClient($this->session->userdata('id_client'));
	
	$query="
				SELECT p . * , (
				SELECT id_parent
				FROM products_categories AS pc
				WHERE p.id_category = pc.id_category 
				LIMIT 1
				) AS id_parent_category,
				(select url from products_images as pi where   p.id_product = pi.id_product and pi.default = 1 limit 1 ) as url, (
				SELECT price
				FROM products_fixed_prices AS pfp
				WHERE p.id_product = pfp.id_product
				and pfp.id_client = ".$this->session->userdata('id_client')."
				LIMIT 1
				) AS fixed_price1,
				(
				SELECT loyalty
				FROM products_fixed_prices AS pfp
				WHERE p.id_product = pfp.id_product
				and pfp.id_client = ".$this->session->userdata('id_client')."
				LIMIT 1
				) AS loyalty_fixed_price, 
				(SELECT  `d`.`price` 
				FROM (
				`promotions` AS prom
				)
				LEFT JOIN  `promotions_dates` AS d ON  `d`.`id_promotion` =  `prom`.`id_promotion` 
				LEFT JOIN  `promotions_groups` AS g ON  `g`.`id_promotion` =  `prom`.`id_promotion` 
				WHERE  `prom`.`id_product` = p.id_product
				AND  `prom`.`id_status` =1
				AND  `g`.`id_group` IN  (".$id_group.")
				AND  `d`.`date_from` <=  '".date("Y-m-d")."'
				AND  `d`.`date_to` >=  '".date("Y-m-d")."'
				AND  `prom`.`id_type` =1 limit 1
				) AS price_promotion, 
				(SELECT  `pp`.`discount` 
				FROM (
				`promotions` AS prom
				)
				LEFT JOIN  `promotions_positions` AS pp ON  `pp`.`id_promotion` =  `prom`.`id_promotion` 
				LEFT JOIN  `promotions_groups` AS g ON  `g`.`id_promotion` =  `prom`.`id_promotion` 
				WHERE  `prom`.`id_product` = p.id_product
				AND  `prom`.`id_status` =1
				AND  `g`.`id_group` IN  (".$id_group.")
				AND  `pp`.`amount` <=  ".$amount."
				AND  ``.`id_type` =2 order by pp.amount desc limit 1
				) AS price_promotion_range, 
				(p.price - p.price*(SELECT `p`.`discount` as discount FROM (`discounts` as d) LEFT JOIN `discounts_positions` as p ON `p`.`id_discount` = `d`.`id_discount` LEFT JOIN `discounts_groups` as g ON `g`.`id_discount` = `d`.`id_discount` 
				WHERE (`d`.`id_category` = p.id_category or id_parent_category = `d`.`id_category`) 
				AND `d`.`id_status` = 1 AND `g`.`id_group` in (".$id_group.") AND `p`.`amount` <= ".$amount." order by p.amount desc limit 1)/100)  as price_discount,
				(p.price - p.price*(SELECT value as discount FROM (`products_discounts_groups_clients` as pdg) WHERE (`pdg`.`id_discount_group` = p.id_discount_group and id_client =";
				if($id_client == 0) $query .= $this->session->userdata('id_client');
				else  $query .= $id_client;
					
				$query .=")  limit 1)/100)  as price_group_discount,			
			
				(SELECT  prom.id_promotion 
				FROM (
				`promotions` AS prom
				)
				LEFT JOIN  `promotions_gratises` AS d ON  `d`.`id_promotion` =  `prom`.`id_promotion` 
				LEFT JOIN  `promotions_groups` AS g ON  `g`.`id_promotion` =  `prom`.`id_promotion` 
				WHERE  `prom`.`id_product` = p.id_product
				AND  `prom`.`id_status` =1
				AND  `g`.`id_group` IN  (".$id_group.")
				AND  `prom`.`id_type` =3 
				AND `d`.`amount` <= ".$amount." order by d.amount desc limit 1
				) AS gratis_promotion,
				
				(SELECT CASE WHEN fixed_price1 IS NOT null     THEN fixed_price1 
				WHEN price_promotion IS NOT NULL then price_promotion 
				WHEN gratis_promotion IS NOT NULL then p.price 
				WHEN price_promotion_range IS NOT NULL then price_promotion_range
				WHEN price_discount IS NOT NULL then price_discount 
				WHEN price_group_discount IS NOT NULL then price_group_discount 
				ELSE  p.price  END) as true_price
				FROM products AS p
				WHERE p.id_status = 1 and ".$where."
				GROUP BY p.id_product 
				  ".$order_by." ".$limit." ";
				// echo $query; 
				//print_r($query);die();
				$result = $this->db->query($query);	
				//echo "<br/><br/>4step - ".($this->microtime_float() - $last_time);	
				//$last_time = $this->microtime_float();
				$list = array();
				$fields = $this->db->list_fields('products');
				//echo "PO uprawnieniach - ".($this->microtime_float() - $last_time);	
				foreach($result->result() as $item)
				 {
				 foreach ($fields as $field)
									{
										$list[$item->id_product][$field]=$item->$field;
										$list[$item->id_product]['url']=$item->url;
										$list[$item->id_product]['gratis'] = $item->gratis_promotion;
										if(!$item->fixed_price1 && ($item->price_promotion || (($item->price_discount || $item->price_group_discount) && !$item->gratis_promotion) ))
										{
											 $list[$item->id_product]['old_price'] = $item->price;							
										}
										if(!$item->fixed_price1 && !$item->price_promotion && $item->price_discount && $item->discount == 0  && $item->price_group_discount == 0)							
											$list[$item->id_product]['price'] = $item->price;
										else
											$list[$item->id_product]['price'] = $item->true_price;	
										if($item->true_price == $item->fixed_price1)
											$list[$item->id_product]['loyalty'] = $item->loyalty_fixed_price;
									}
									
				 }
				
				// echo "<br/><br/>CALOSC - ".($this->microtime_float() - $start_time);	
				 return $list;
	}
	public function getProductsToCategory($id_category=0,$user_tab=array(),$page_start=0)
	{	
		// echo "<br/><br/>1step - ".($this->microtime_float() - $start_time);	
		// $last_time = $this->microtime_float();

		if($this->session->userdata('per_page'))
				$per_page = $this->session->userdata('per_page');
			else
				$per_page = 12;
		$access_data=$this->getUserAccess($user_tab);
		
		$where_in_id="";

		if($id_category != 0)
		{	
			if(count($access_data['categories']) > 0)
				{
					if(isset($access_data['categories'][$id_category]))
							$where_in_id=$id_category;
				}	
			else
				$where_in_id=$id_category;
				
			$cats=$this->getCategoriesList($id_category);
			foreach($cats as $id=>$value)
			{
				if(count($access_data['categories']) > 0)
				{
					if(isset($access_data['categories'][$id]))
							$where_in_id.=",".$id;
				}				
				else
					$where_in_id.=",".$id;
				
			}
			$where_in_id_cat = "";
			$array_diff = array();
			if($access_data['categories'] && $access_data['category_with_products'])
				$array_diff = array_diff($access_data['categories'],$access_data['category_with_products']);
			$it=0;
			foreach($array_diff as $id=>$value)
			{ 
				if(isset($cats[$id]))
				{
					IF($it==0)
					{
					$where_in_id_cat.=$id;
					$it=1;
					}
					else
						$where_in_id_cat.=",".$id;
				}
			}
			if(count($cats) == 0)
				{
					$where_in_id_cat = $id_category;
				}
		}
		// echo "<br/><br/>2step - ".($this->microtime_float() - $last_time);	
		// $last_time = $this->microtime_float();
		if($this->session->userdata('sort') == 1)
			$order_by = " ORDER BY p.name asc";
		elseif($this->session->userdata('sort') == 2)
			$order_by = " ORDER BY p.name desc";
		elseif($this->session->userdata('sort') == 3)
			$order_by = " ORDER BY CASE WHEN fixed_price1 IS NOT null     THEN fixed_price1 
				WHEN price_promotion IS NOT NULL then price_promotion 
				WHEN price_discount IS NOT NULL then price_discount 
				WHEN price_group_discount IS NOT NULL then price_group_discount 
														 ELSE  p.price END asc";
		elseif($this->session->userdata('sort') == 4)
			$order_by = " ORDER BY CASE WHEN fixed_price1 IS NOT null     THEN fixed_price1 
				WHEN price_promotion IS NOT NULL then price_promotion 
				WHEN price_discount IS NOT NULL then price_discount 
				WHEN price_group_discount IS NOT NULL then price_group_discount 
														 ELSE  p.price END desc";
		elseif($this->session->userdata('sort') == 5)
			$order_by = "ORDER BY p.code asc";
		else
			$order_by = "ORDER BY p.name asc";
			
		if($id_category != 0)
		{
				
			
				if(count($access_data['products']) > 0)
				{
					$where_in_idp="";
					foreach($access_data['products'] as $k=>$v)
					{
						if($where_in_idp!="") $where_in_idp .=",";
						$where_in_idp .= $v;
					}
					$where="";
					if($where_in_id_cat!="")
						$where.="(";
					$where.="(p.id_category IN (".$where_in_id.")
					AND  p.id_product IN (".$where_in_idp.")
					)";
					
					if($where_in_id_cat!="")
						$where.="OR p.id_category IN (".$where_in_id_cat."))";
					$where .=" AND  p.id_status = 1";
				}
				else								
					$where ="p.id_category IN (".$where_in_id.") AND  p.id_status = 1 ";
							
		}	
		//echo "<br/><br/>3step - ".($this->microtime_float() - $last_time);	
		//$last_time = $this->microtime_float();
				
				
		return $this->getProductsSql($where,$order_by,$page_start,$per_page);
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
	
	public function getProductsToSearch($get=array(),$user_tab=array(),$page_start=0,$s_type=1)
	{
		
		if(count($get)>0)
		{
			$access_data=$this->getUserAccess($user_tab);
			$where="";
			$inFavorite=array();
			$orderedBefore=array();
			
			if(isset($get['search']))
			{
				$search = explode(" ",$get['search']);
				$przyimki = array("z" => "z", "do"=>"do", "na"=>"na", "ze"=>"ze", "o"=>"o", "pod"=>"pod", "bez"=>"bez", "za"=>"za");

				if(count($search) > 1 )
				{		
					foreach ($search as $v)
					{	$v =  str_replace("'","\'",$v);
						if(!isset($przyimki[strtolower($v)]))
							if($s_type == 1)
							{	
								if($where=="")
									$where.="(p.name like '%".$v."%' or p.code like '%".$v."%')";		
								else
									$where.=" and (p.name like '%".$v."%' or p.code like '%".$v."%')";
							}
							
							elseif($s_type == 2)
							{
								if($where=="")
									$where.="(p.description like '%".$v."%')";		
								else
									$where.=" and (p.description like '%".$v."%')";
							}
					}
				}
				else
				{
				if($s_type == 1)					
					$where.="(p.name like '%".$get['search']."%' or p.code like '%".$get['search']."%')";
				elseif($s_type == 2)					
					$where.="(p.description like '%".$get['search']."%')";
				}
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
			$array_diff = array();
			$where_in_id_cat_diff = "";
			if(isset($access_data['category_with_products']) && isset($access_data['categories']))
				$array_diff = array_diff($access_data['categories'],$access_data['category_with_products']);
			$it=0;
			foreach($array_diff as $id=>$value)
			{ 
					IF($it==0)
					{
					$where_in_id_cat_diff.=$id;
					$it=1;
					}
					else
						$where_in_id_cat_diff.=",".$id;
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
			///////////////////	
			
			if(count($access_data['categories']) > 0)
			{$where_in_id_cat="0";	
				foreach($access_data['categories'] as $id=>$value)
						$where_in_id_cat.=",".$id;
			}				
			if(isset($where_in_id_cat))
			{
				$where .=" AND";
				if(count($array_diff) > 0)
					$where .="(";
				$where .=" p.id_category IN (".$where_in_id_cat.") ";
			}
			if(count($access_data['products']) > 0)
			{			$where_in_idp ="";
				foreach($access_data['products'] as $k=>$v)
				{	
					if($where_in_idp!="") $where_in_idp .=",";
					$where_in_idp .= $v;
				}
				$where .=" AND  p.id_product IN (".$where_in_idp."))";
			}
			if(count($array_diff) > 0)
			{
				$where .= "OR p.id_category IN (".$where_in_id_cat_diff."))";
			}
			///////
			if($where != "")
			{	$page_start = 0;
				$per_page = 0;
			//	$order_by="ORDER BY name";
			if($this->session->userdata('sort') == 1)
				$order_by = " ORDER BY p.name asc";
			elseif($this->session->userdata('sort') == 2)
				$order_by = " ORDER BY p.name desc";
			elseif($this->session->userdata('sort') == 3)
				$order_by = " ORDER BY CASE WHEN fixed_price1 IS NOT null     THEN fixed_price1 
					WHEN price_promotion IS NOT NULL then price_promotion 
					WHEN price_discount IS NOT NULL then price_discount 
					WHEN price_group_discount IS NOT NULL then price_group_discount 
															 ELSE  p.price END asc";
			elseif($this->session->userdata('sort') == 4)
				$order_by = " ORDER BY CASE WHEN fixed_price1 IS NOT null     THEN fixed_price1 
					WHEN price_promotion IS NOT NULL then price_promotion 
					WHEN price_discount IS NOT NULL then price_discount 
					WHEN price_group_discount IS NOT NULL then price_group_discount 
															 ELSE  p.price END desc";
			elseif($this->session->userdata('sort') == 5)
				$order_by = "ORDER BY p.code asc";
			else
				$order_by = "ORDER BY p.name asc";
				
				return $this->getProductsSql($where,$order_by,$page_start,$per_page);			
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
			$inFavorite=array();
			$orderedBefore=array();
			if(isset($get['search']))
			{
				$search = explode(" ",$get['search']);
				
				if(count($search) > 1 )
				{		
					foreach ($search as $v)
					{
						if($where=="")
							$where.="(p.name like '%".$v."%' or p.code like '%".$v."%' or p.description like '%".$v."%')";		
						else
							$where.=" and (p.name like '%".$v."%' or p.code like '%".$v."%' or p.description like '%".$v."%')";
					}
				}
				else
				{
					$where.="(p.name like '%".$get['search']."%' or p.code like '%".$get['search']."%' or p.description like '%".$get['search']."%')";
				}
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
			///////////////////	
		
			$where_in_id_cat="0";	
			if(count($where_in_tab)>0)
			{
				if(count($access_data['categories']) > 0)
				{
					foreach($access_data['categories'] as $id=>$value)
							$where_in_id_cat.=",".$id;
				}				
				
				if(count($where_in_id_cat) > 0)
					$where .=" AND  p.id_category IN (".$where_in_id_cat.") ";
				if(count($access_data['products']) > 0)
				{			
					foreach($access_data['products'] as $k=>$v)
					{
						if($where_in_idp!="") $where_in_idp .=",";
						$where_in_idp .= $v;
					}
					$where .="AND  p.id_product IN (".$where_in_idp.")";
				}
			}
			if($where != "")
			{
			
				$query="
					SELECT p . * , (select url from products_images as pi where   p.id_product = pi.id_product and pi.default = 1 limit 1 ) as url
					FROM products AS p
				
					WHERE ".$where."
					GROUP BY p.id_product limit ".$page_start.", 12";	
				$result = $this->db->query($query);		
					
				foreach($result->result() as $item)
				{	$access_prod=1;
					
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
		$this->db->join('promotions_dates as pd', 'p.id_promotion = pd.id_promotion', 'left');
		$this->db->join('groups_clients as gc', 'gc.id_group = pg.id_group', 'left');
		$where = 'gc.id_client = '.$user_tab['id_client']." and p.id_status = 1 and ((pd.date_from <= '".date("Y-m-d")."' and pd.date_to >= '".date("Y-m-d")."') or (pd.date_from is null and pd.date_to is null))";
		$this->db->where($where);
		$this->db->group_by('id_product');
		$list = array();
		$a = 0;
		foreach($this->db->get()->result() as $item)
		{	
			if($a !=0)
				$where_in_id .=",";	
			$where_in_id .= $item->id_product;
			
			$a++;
			$is_product = 1;
			
			
		}	

		
			
		if(count($where_in_id)>0)
		{ 	$where="";
			if(count($access_data['categories']) > 0)
			{ $where_in_id_cat="0";
				foreach($access_data['categories'] as $id=>$value)
						$where_in_id_cat.=",".$id;
			}				
			
			if(isset($where_in_id_cat))
				$where .=" AND  p.id_category IN (".$where_in_id_cat.") ";
			if(count($access_data['products']) > 0)
			{		$where_in_idp="";
				foreach($access_data['products'] as $k=>$v)
				{	
					if($where_in_idp!="") $where_in_idp .=",";
					$where_in_idp .= $v;
				}
				$where .="AND  p.id_product IN (".$where_in_idp.")";
			}
		}
		if(isset($is_product))
		 {	$where = "p.id_product IN (".$where_in_id.") ".$where;
			$order_by="";
			$page_start = 0;
			$per_page = 0;
			$list = $this->getProductsSql($where,$order_by,$page_start,$per_page);
				// $query="
				// SELECT p . * ,(select url from products_images as pi where   p.id_product = pi.id_product and pi.default = 1 limit 1 ) as url
				// FROM products AS p
				// WHERE p.id_product IN (".$where_in_id.") ".$where."
				// AND  p.id_status = 1			
				// GROUP BY p.id_product 
				// ORDER BY p.name
				// limit ".$page_start.", 12";	
			// $result = $this->db->query($query);		
			// $list = array();
			// $fields = $this->db->list_fields('products');
			// foreach($result->result() as $item)
			// {	$access_prod=1;
				
				// if($access_prod == 1)
				// {
					
					// foreach ($fields as $field)
								// {
								// $list[$item->id_product][$field]=$item->$field;
								// }
								// /* get correct price */
								// $price1 = $this->getFixedPriceForProduct($item->id_product,$user_tab['id_client']);
								// /* get correct price */
								// if($price1 > 0)
								// {
									// $list[$item->id_product]['price'] = $price1;
									// //$list[$item->id_product]['old_price'] = $item->price;
								// }			
								// else
								// {	$id_group = $this->groups->getGroupForClient($this->session->userdata('id_client'));
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
										// $list[$item->id_product]['old_price'] = $item->price;
									// }	
									// if(!isset($list[$item->id_product]['old_price']))
									// {	$cat=$this->getCategoryById($item->id_category);						
										// $this->db->select('p.discount as discount');
										// $this->db->from('discounts as d');
										// $this->db->join('discounts_positions as p', 'p.id_discount = d.id_discount', 'left');
										// $this->db->join('discounts_groups as g', 'g.id_discount = d.id_discount', 'left');
										
										// $where ="(`d`.`id_category` = '".$item->id_category."' OR `d`.`id_category` = '".$cat['id_parent']."') AND `d`.`id_status` = 1 AND `g`.`id_group` = '".$id_group."' AND `p`.`amount` = 0";
										// $this->db->where($where);
																			
										// foreach($this->db->get()->result() as $item2)
											// {	
											// $list[$item->id_product]['price'] = $item->price - (($item->price*$item2->discount)/100);
											// $list[$item->id_product]['old_price'] = $item->price;
											// }
									// }
								// }
								// /* end  get correct price */
								// $list[$item->id_product]['url']=$item->url;
				// }
			// }	
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
	public function getProductsListActive($id_category=0)
	{
		$this->db->select('p.*, pis.name as info_status_name');
		$this->db->from('products as p');
		$this->db->join('products_info_status as pis', 'pis.id_info_status = p.id_info_status', 'left');
		$this->db->where('p.id_status', 1);
		$this->db->where('p.id_category', $id_category);
		$list = array();
		$fields = $this->db->list_fields('products');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_product][$field]=$item->$field;
							}
							$list[$item->id_product]['info_status_name']=$item->info_status_name;
		}	
		return $list;
	}
	public function getProductsList($id_category=0)
	{
		$this->db->select('p.*, pis.name as info_status_name');
		$this->db->from('products as p');
		$this->db->join('products_info_status as pis', 'pis.id_info_status = p.id_info_status', 'left');
		$this->db->where('p.id_status !=', 0);
		$this->db->where('p.id_category', $id_category);
		$list = array();
		$fields = $this->db->list_fields('products');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_product][$field]=$item->$field;
							}
							$list[$item->id_product]['info_status_name']=$item->info_status_name;
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
	
	public function getProductById($id=0,$user_tab= array())
	{	
		$array_diff=array();
		if($user_tab)
			$access_data=$this->getUserAccess($user_tab);
		else {
			$access_data['categories'] = array();$access_data['products'] = array(); }
		if(isset($access_data['category_with_products']) && isset($access_data['categories']))
			$array_diff = array_diff($access_data['categories'],$access_data['category_with_products']);
		$product=$this->getProductWithPriceById($id);
		
		if(count($access_data['products']) > 0)
			{
				if(!isset($access_data['products'][$id]) && !isset($array_diff[$product['id_category']]))
					return 0;
			}
		if(!$user_tab)
		{
			$this->db->select('*');
			$this->db->from('products');
			$this->db->where('id_status !=', 0);
			$this->db->where('id_product', $id);
			$list = array();
			$fields = $this->db->list_fields('products');
			foreach($this->db->get()->result() as $item)
			{		
					if(count($access_data['categories']) > 0)
					{
						if(!isset($access_data['categories'][$item->id_category]))
							return 0;
					}
					
					foreach ($fields as $field)
								{
								$list[$field]=$item->$field;
								}							
			}	
		}
		else
		{
			$where = "p.id_product = ".$id." and id_status !=0 ";
			$order_by="";
			$page_start = 0;
			$per_page = 0;
			$result = $this->getProductsSql($where,$order_by,$page_start,$per_page);
			$list = $result[$id];
			$client=$this->client->getById($user_tab['id_client']);
			if($client['loyalty'] == 1)
			{
				
					if(isset($loyaltyProduct))
					{
						if($loyaltyProduct == 1)
							$list['loyalty'] = 1;
						else
							$list['loyalty'] = 0;
					}
			}
			else
				$list['loyalty'] = 0;
		}
		return $list;
	}
	
	public function getProductByIdWithPromotions($id=0,$id_client,$amount=1)
	{	$user_tab['id_user'] = $this->session->userdata('id_user');
		if($user_tab)
			$access_data=$this->getUserAccess($user_tab);
		else {
			$access_data['categories'] = array();
			$access_data['products'] = array(); }
		if(count($access_data['products']) > 0)
			{
				if(!isset($access_data['products'][$id]))
					return 0;
			}
		
				$order_by="";
				$page_start=0;
				$per_page = 0;
				$where = " p.id_product = ".$id." ";
				$list = $this->products->getProductsSql($where,$order_by,$page_start,$per_page,0,$amount);
			if(count($access_data['categories']) > 0)
			{
				if(!isset($access_data['categories'][$list[$id]['id_category']]))
					return 0;
			}
		// $this->db->select('*');
		// $this->db->from('products');
		// $this->db->where('id_status !=', 0);
		// $this->db->where('id_product', $id);
		
		// $list = array();
		// $fields = $this->db->list_fields('products');
		// foreach($this->db->get()->result() as $item)
		// {		
				// if(count($access_data['categories']) > 0)
				// {
					// if(!isset($access_data['categories'][$item->id_category]))
						// return 0;
				// }
				
				// foreach ($fields as $field)
							// {
							// $list[$field]=$item->$field;
							// }
							// if($user_tab)
							// {
								// $price1 = $this->getFixedPriceForProduct($item->id_product,$user_tab['id_client']);
								// /* get correct price */
								// if($price1 > 0)
								// {
									// $list['price'] = $price1;
									// //$list[$item->id_product]['old_price'] = $item->price;
								// }							
								// else
								// {	
									
									// $id_group = $this->groups->getGroupForClient($this->session->userdata('id_client'));
									// $this->db->select('MAX(d.amount) as amount, d.discount');
									// $this->db->from('promotions as p');
									// $this->db->join('promotions_positions as d', 'd.id_promotion = p.id_promotion', 'left');
									// $this->db->join('promotions_groups as g', 'g.id_promotion = p.id_promotion', 'left');
									// $this->db->where('p.id_product', $item->id_product);
									// $this->db->where('p.id_status', 1);
									// $this->db->where('amount <=', $amount);
									// $this->db->where('g.id_group', $id_group);
									// $this->db->where('p.id_type', 2);		
									// $this->db->group_by('amount');				
									// foreach($this->db->get()->result() as $item1)
									// {		if($item1->discount)
											// {
											// $list['price'] = $item1->discount;
											// $list['old_price'] = $item->price;
											// }
									// }	
									
									// // promotions gratises
									// if(!isset($list['old_price']))
									// {
										// $this->db->select('MAX(d.amount) as amount, d.gratis');
										// $this->db->from('promotions as p');
										// $this->db->join('promotions_gratises as d', 'd.id_promotion = p.id_promotion', 'left');
										// $this->db->join('promotions_groups as g', 'g.id_promotion = p.id_promotion', 'left');
										// $this->db->where('p.id_product', $item->id_product);
										// $this->db->where('p.id_status', 1);
										// $this->db->where('d.amount <=', $amount);
										// $this->db->where('g.id_group', $id_group);
										// $this->db->where('p.id_type', 3);			
										// $this->db->group_by('amount');
										// foreach($this->db->get()->result() as $item1)
										// {						
											// $list['gratis']=$item1->gratis;
											// $list['old_price']=1;
										// }	
									// }
									// // promotionS dates
									// if(!isset($list['old_price']))
									// {
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
											// $list['price'] = $item1->price;
											// $list['old_price'] = $item->price;
										// }	
									// }
									
									
									
									// // $this->db->select('d.price as price');
									// // $this->db->from('promotions as p');
									// // $this->db->join('promotions_dates as d', 'd.id_promotion = p.id_promotion', 'left');
									// // $this->db->join('promotions_groups as g', 'g.id_promotion = p.id_promotion', 'left');
									// // $this->db->where('p.id_product', $item->id_product);
									// // $this->db->where('p.id_status', 1);
									// // $this->db->where('g.id_group', $id_group);
									// // $this->db->where('d.date_from <=', date("Y-m-d"));
									// // $this->db->where('d.date_to >=', date("Y-m-d"));
									// // $this->db->where('p.id_type', 1);						
									// // foreach($this->db->get()->result() as $item1)
									// // {	
										// // $list['price'] = $item1->price;
										// // $list['old_price'] = $item->price;
									// // }	
									// //////////////////////////////////////////////
									// if(!isset($list[$item->id_product]['old_price']))
									// {							
										// $cat=$this->getCategoryById($item->id_category);					
										// $this->db->select('p.discount as discount');
										// $this->db->from('discounts as d');
										// $this->db->join('discounts_positions as p', 'p.id_discount = d.id_discount', 'left');
										// $this->db->join('discounts_groups as g', 'g.id_discount = d.id_discount', 'left');
											// $where ="(`d`.`id_category` = '".$item->id_category."' OR `d`.`id_category` = '".$cat['id_parent']."') AND `d`.`id_status` = 1 AND `g`.`id_group` = '".$id_group."' AND `p`.`amount` = 0";
										// $this->db->where($where);
										
										// foreach($this->db->get()->result() as $item2)
											// {	
											// $list['price'] = $item->price - (($item->price * $item2->discount)/100);
											// $list['old_price'] = $item->price;
											// }
									// }
									
									
								// }
							// }
							// /* end  get correct price */
		// }	
		return $list[$id];
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
			$this->insertImage($a['file_name'],$id,$data['description'],count($images));
			$this->load->library('image_lib', $configI); 
			$this->image_lib->resize();
			return  $this->image_lib->display_errors('<p>', '</p>');
		}
	}
	private function insertImage($name,$id_product,$description,$count_images)
	{	
		if($count_images == 0)
			$data['default']=1;
		else
				$data['default']=0;
		$data['url']=$name;
		$data['id_product']=$id_product;
		$data['description']=$description;
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
	public function getDefaultImage($id_product=0)
	{	$list=array();
		$this->db->select('*');
		$this->db->from('products_images');
		$this->db->where('id_product', $id_product);
		$this->db->where('id_status', 1);
		$this->db->where('default', 1);
		$fields = $this->db->list_fields('products_images');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
		}	
		return $list;
	}
	
	public function deleteImage($id=0)
	{			
		$this->db->where('id_image',$id);
		return $this->db->delete("products_images"); 	
	}
	public function deleteCatImage($id=0)
	{		
		$this->db->select('img');
		$this->db->from('products_categories');
		$this->db->where('id_category', $id);
		$list=array();
		foreach($this->db->get()->result() as $item)
		{	
					unlink(base_url("images/categories/".$item->img));		
		}	
		$this->db->where('id_category',$id);
		$data['img'] = "";	
		$this->db->update("products_categories",$data); 	
	}
	public function deleteProduct($id=0)
	{	$data['id_status'] = 0;	
		$this->db->where('id_product',$id);
		return $this->db->update("products",$data); 	
	}
	public function setDefaultImage($id=0,$id_product)
	{	$data['default'] = 0;	
		$this->db->where('id_product',$id_product);
		$this->db->update("products_images",$data); 
		$data['default'] = 1;	
		$this->db->where('id_image',$id);
		return $this->db->update("products_images",$data);		
	}
	public function updateSettings($id=0,$data=array())
	{
		$tab['loyalty']=$data['loyalty'];
		$tab['id_status']=$data['id_status'];
		$tab['discount']=$data['discount'];
		$tab['id_color']=$data['id_color'];
		$tab['id_producer']=$data['id_producer'];
		$tab['description']=$data['description'];
		$tab['amount_decimal']=$data['amount_decimal'];
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
		$tab['price']=str_replace(",",".",$data['price']);
		//$tab['fixed_price']=$data['fixed_price'];
		$tab['date_edited']=date("Y-m-d");
		$this->db->where('id_product ',$id);
		return $this->db->update('products',$tab); 		
	}
	public function returnProduct($id=0)
	{	
		$tab['id_status']=1;
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
	public function setFixedPrices($id_product=0,$post=array(),$price)
	{
		foreach($post['id_clients'] as $k=>$v)
		{$id_temp[$v] = $v;
		$data[$k]['id_product']=$id_product;
		$data[$k]['id_client']=$v;
		$data[$k]['price']=$post['price'];
		$data[$k]['loyalty']=$post['loyalty'];
		}
		$tab_id = implode(",",$id_temp);
		$this->db->where('id_product', $id_product);
		$this->db->where('price', $price);
		$this->db->delete('products_fixed_prices');
		
		return $this->db->insert_batch('products_fixed_prices', $data); 
	}
	public function getFixedPrices($id_product=0)
	{	$this->db->select('*');
		$this->db->from('products_fixed_prices');
		$this->db->where('id_product', $id_product);
		$this->db->group_by('id_product,price');
		$list=array();
		$i=0;
		foreach($this->db->get()->result() as $item)
		{	
							$list[$i]=$item->price;							
							$i++;
		}	
		return $list;
	}
	public function getDiscountsGroups()
	{	$this->db->select('*');
		$this->db->from('products_discounts_groups');
		$list=array();
		foreach($this->db->get()->result() as $item)
		{	
							$list[$item->id_discount_group]=$item->name;							
		}	
		return $list;
	}
	public function setDiscountsGroups($id,$post){
		$this->db->where('id_product',$id);
		$data['id_discount_group'] = $post['id_discount_group'];
		return $this->db->update("products",$data); 
	}	
	public function delFixedPrice($price,$id=0)
	{
		$this->db->where('id_product', $id);
		$this->db->where('price',$price);
		$this->db->delete('products_fixed_prices');
	}
	public function getFixedPrice($id_product=0,$price=0)
	{	$this->db->select('*');
		$this->db->from('products_fixed_prices');
		$this->db->where('id_product', $id_product);
		$this->db->where('price', $price);
		$list=array();
		$list['clients']=array();
		$list['price'] = "";
		$list['loyalty'] = 1;
		foreach($this->db->get()->result() as $item)
		{
							$list['clients'][$item->id_client]=$item->id_client;	
							$list['price']=$item->price;
							$list['loyalty']=$item->loyalty;								
		}	
		return $list;
	}
	public function delRelatedProduct($id_rel,$id_product=0)
	{
		$where = "(id_product = ".$id_product." and id_product2 = ".$id_rel." ) or (id_product2 = ".$id_product." && id_product = ".$id_rel.")";
		$this->db->where($where);
		return $this->db->delete('products_related');
		
	}
	public function getRelatedProducts($id_product=0)
	{	$this->db->select('*');
		$this->db->from('products_related');
		$this->db->where('id_product', $id_product);
		$this->db->or_where('id_product2', $id_product);
		$i=0;
		
		foreach($this->db->get()->result() as $item)
		{
			if($item->id_product == $id_product)
				$list[$i] = $item->id_product2;
			else
				$list[$i] = $item->id_product;
			$i++;
		}	
		$list1 = array();
		
		if(isset($list))
		{
		$where_tab = implode(',',$list);
		$where ="p.id_product in (".$where_tab.") and p.id_status != 0";
		$order_by="";
		$page_start="";
		$per_page="";
		$list1 = $this->getProductsSql($where,$order_by,$page_start,$per_page);
		// $this->db->select('p.id_product,p.code, p.name, (select url from products_images as pi where   p.id_product = pi.id_product and pi.default = 1 limit 1 ) as url');
		// $this->db->from('products as p');
		// $this->db->where('p.id_status !=', 0);
		// $this->db->where_in('p.id_product', $list);
		
		// $fields = $this->db->list_fields('products');
		// foreach($this->db->get()->result() as $item)
		// {	
			
							// $list1[$item->id_product]['id_product']=$item->id_product;
							// $list1[$item->id_product]['code']=$item->code;
							// $list1[$item->id_product]['name']=$item->name;
							// $list1[$item->id_product]['url']=$item->url;

		// }	
		}
		return $list1;
	
	}
	public function getRelatedProductsManager($id_product=0)
	{	$this->db->select('*');
		$this->db->from('products_related');
		$this->db->where('id_product', $id_product);
		$this->db->or_where('id_product2', $id_product);
		$i=0;
		
		foreach($this->db->get()->result() as $item)
		{
			if($item->id_product == $id_product)
				$list[$i] = $item->id_product2;
			else
				$list[$i] = $item->id_product;
			$i++;
		}	
		$list1 = array();
		
		if(isset($list))
		{
		$where_tab = implode(',',$list);
		$where ="p.id_product in (".$where_tab.") and p.id_status != 0";
		$order_by="";
		$page_start="";
		$per_page="";
		//$list1 = $this->getProductsSql($where,$order_by,$page_start,$per_page);
			$this->db->select('p.id_product,p.code, p.name, (select url from products_images as pi where   p.id_product = pi.id_product and pi.default = 1 limit 1 ) as url');
			$this->db->from('products as p');
			$this->db->where('p.id_status !=', 0);
			$this->db->where_in('p.id_product', $list);
			
			$fields = $this->db->list_fields('products');
			foreach($this->db->get()->result() as $item)
			{	
				
								$list1[$item->id_product]['id_product']=$item->id_product;
								$list1[$item->id_product]['code']=$item->code;
								$list1[$item->id_product]['name']=$item->name;
								$list1[$item->id_product]['url']=$item->url;

			}	
		}
		return $list1;
	
	}
	public function setRelatedProduct($id_rel=0,$id_product=0)
	{	$this->db->select('*');
		$this->db->from('products_related');
		$where = "(id_product = ".$id_product." and id_product2 = ".$id_rel." ) or (id_product2 = ".$id_product." && id_product = ".$id_rel.")";
		$this->db->where($where);
		foreach($this->db->get()->result() as $item)
		{
							$isset = 1;							
		}	
		if(!isset($isset))
		{
			$data['id_product']=$id_product;
			$data['id_product2']=$id_rel;
			$this->db->insert('products_related', $data); 
		}
		return 1;
	}
	public function setRelatedProductAll($post,$id_product=0)
	{	$i=0;
		foreach($post['id_products'] as $v)
		{
			$this->db->select('*');
			$this->db->from('products_related');
			$where = "(id_product = ".$id_product." and id_product2 = ".$v." ) or (id_product2 = ".$id_product." && id_product = ".$v.")";
			$this->db->where($where);
			foreach($this->db->get()->result() as $item)
			{
								$isset = 1;							
			}	
			if(!isset($isset))
			{
				$data[$i]['id_product']=$id_product;
				$data[$i]['id_product2']=$v;
			
			}
			$i++;
		}
		$this->db->insert_batch('products_related', $data); 
		return 1;
	}
	public function import_from_csv($content = "")
	{
		$row = explode("\n",$content);
		foreach($row as $k=>$v)
		{
			$col = explode(",",$v);
			if(isset($col[0]) && $col[0])
			{
				$data[$k]['id_product'] = $col[0];
				$data_history[$k]['id_product'] = $col[0];
				$data_history[$k]['id_user']= $this->session->userdata('id_user');	
			}
			if(isset($col[1]) && $col[1])
			{
				$data[$k]['price'] = $col[1];
				$data_history[$k]['price'] = $col[1];
			}
		}
		$this->db->update_batch('products', $data, 'id_product'); 
		
		if($this->db->affected_rows() > 0) 
		{	$this->db->insert_batch('import_products_prices', $data_history); 
			 return 1; 
		}
		else return 0;
	}
	
	
}