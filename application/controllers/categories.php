<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Categories extends CI_Controller
{	
	private $path = 'site/';

	function __construct()
  	{
		parent::__construct();
		$this->load->model('access');
		$this->load->model('clientsmodel','client');
		$this->load->model('ordersmodel','orders');
		$this->load->model('productsmodel','products');
		$this->load->model('loyaltymodel','loyalty');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->helper('url');	
		if(!$this->access->isLogIn())
			redirect(base_url("login"),'refresh');	
		elseif($this->session->userdata('id_profile') < 3)
			redirect(base_url("login"), 'refresh');
	}
		
	private function display($site=NULL,$vars=array())
	{	$vars['loyalty_points']=$this->loyalty->getLoyaltyPointsForClient($this->session->userdata('id_client'));
		$vars['css']=array("bootstrap.css",$this->path."main.css");
		$vars['js']=array("jquery-2-1-1.min.js","bootstrap.min.js","general.js");
		$vars['path']=$this->path;
		$vars['contact']=$this->access->getFooterContact();
		$vars['traders']=$this->access->getFooterTraders();
		$vars['to_pay']=$this->payments->sumPaymentsToPay($this->session->userdata('id_client'));
		$this->load->view($this->path.'header',$vars);
		if($site!=NULL)
			$this->load->view($site,$vars);
		$this->load->view($this->path.'footer',$vars);
	}
	
	public function index($id_category=0,$page_start=0)
	{ 	
		$vars=array();
		if($this->session->userdata('per_page'))
			$pp=$this->session->userdata('per_page');
		else
			$pp = 12;
		if(isset($_POST['site_submit_text']))
		{
			$page_start = ($_POST['site_submit_text']-1)*$pp;
			redirect(base_url("categories/index/".$id_category."/".$page_start), 'refresh');		
		}
		$user_tab['id_user']=$this->session->userdata('id_user');
		$user_tab['id_client']=$this->session->userdata('id_client');
		$vars['per_page'] = $this->session->userdata('per_page');
		$vars['sort'] = $this->session->userdata('sort');
		if($id_category == 0)
		{	$vars['to_cat_list'] = 1;
			$vars['sum_cart']=$this->orders->sumCartByUser($this->session->userdata('id_user'));	
			$vars['favorite_list']=$this->products->getFavoriteList($this->session->userdata('id_user'));
			$vars['colors']=$this->products->getColorsList();
			$vars['producers']=$this->products->getProducersList();
			$vars['client']=$this->client->getById($this->session->userdata('id_client'));
			$vars['adviser']=$this->access->getUserByIdShort($vars['client']['id_user_system']);
			$vars['categories']=$this->products->getCategoriesListByParentId(0,$user_tab);
			$vars['path']=$this->path;
			$this->display($this->path."block_categories",$vars);
		}
		else
		{
		
		$vars['id_category']=$id_category;
		$vars['sum_cart']=$this->orders->sumCartByUser($this->session->userdata('id_user'));	
		$vars['favorite_list']=$this->products->getFavoriteList($this->session->userdata('id_user'));
		$vars['client']=$this->client->getById($this->session->userdata('id_client'));
		$vars['adviser']=$this->access->getUserByIdShort($vars['client']['id_user_system']);
		$vars['category']=$this->products->getCategoryById($id_category);
		$vars['categories']=$this->products->getCategoriesListGroupByParentAccess($user_tab);
		$vars['products']=$this->products->getProductsToCategory($id_category,$user_tab,$page_start);
		
		$vars['products_in_promotions']=$this->products->getIdProductsInPromotions($this->session->userdata('id_client'));
		
		$config['base_url'] = base_url('categories/index/'.$id_category);
		$config['total_rows'] = $this->products->countProductsToCategory($id_category,$user_tab);
		$config['uri_segment']=4;	
		$config['per_page']=$vars['per_page'];
		$this->pagination->initialize($config); 
		$vars['pagination_links']=$this->pagination->create_links();
		$vars['page']=$page_start;
		$vars['total_rows'] = round($config['total_rows']/$vars['per_page']);
		$vars['path']=$this->path;
		
		$vars['breadcrumbs']=$this->load->view($this->path."breadcrumbs", $vars, true);
		$vars['block_products']=$this->load->view($this->path."block_products", $vars, true);
		$vars['block_left_categories']=$this->load->view($this->path."block_left_categories", $vars, true);
		$this->display($this->path."categories",$vars);
		}
	}
	public function setPerPage($per_page=12)
	{
		$this->session->unset_userdata('per_page');
		$this->session->set_userdata(array("per_page"=>$per_page));
	}
	public function setSort($sort=1)
	{
		$this->session->unset_userdata('sort');
		$this->session->set_userdata(array("sort"=>$sort));
	}
	
}
?>