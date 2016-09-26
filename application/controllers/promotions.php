<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Promotions extends CI_Controller
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
	
	public function index($page_start=0)
	{ 	
		$vars=array();
		$user_tab['id_user']=$this->session->userdata('id_user');
		$user_tab['id_client']=$this->session->userdata('id_client');

		$vars['sum_cart']=$this->orders->sumCartByUser($this->session->userdata('id_user'));	
		$vars['favorite_list']=$this->products->getFavoriteList($this->session->userdata('id_user'));
		$vars['client']=$this->client->getById($this->session->userdata('id_client'));
		$vars['adviser']=$this->access->getUserByIdShort($vars['client']['id_user_system']);
		
		$vars['products']=$this->products->getProductsToPromotions($user_tab,$page_start);
		$config['base_url'] = base_url('promotions/index/');
		$config['total_rows'] = $this->products->countProductsToPromotions($user_tab,$page_start);
		$config['uri_segment']=3;	
		$this->pagination->initialize($config); 
		//$vars['pagination_links']=$this->pagination->create_links();
		$vars['page']=$page_start;
		
		$vars['path']=$this->path;
		$vars['vars_products']['title'] = "Promocje";
		$vars['breadcrumbs']=$this->load->view($this->path."breadcrumbs", $vars, true);
		$vars['block_products']=$this->load->view($this->path."block_products", $vars, true);
		$this->display($this->path."search",$vars);
	}
	
}
?>