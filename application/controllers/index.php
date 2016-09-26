<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Index extends CI_Controller
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
		$this->load->model('promotionsmodel','promotions');
		$this->load->model('discountsmodel','discounts');
		$this->load->model('articlesmodel','articles');
		$this->load->model('articlesmodel','payments');
		$this->load->library('form_validation');
		$this->load->helper('url');	
		if(!$this->access->isLogIn())
			redirect(base_url("login"),'refresh');
		elseif($this->session->userdata('id_profile') < 3)
			redirect(base_url("login"), 'refresh');
	}
		
	private function display($site=NULL,$vars=array())
	{	$vars['loyalty_points']=$this->loyalty->getLoyaltyPointsForClient($this->session->userdata('id_client'));
		$vars['css']=array("bootstrap.css",$this->path."main.css","nivo-slider.css");
		$vars['js']=array("jquery-2-1-1.min.js","bootstrap.min.js","jquery.vticker-min.js","jquery.nivo.slider.js","general.js");
		$vars['path']=$this->path;
		$vars['contact']=$this->access->getFooterContact();
		$vars['traders']=$this->access->getFooterTraders();
		$vars['to_pay']=$this->payments->sumPaymentsToPay($this->session->userdata('id_client'));
		$this->load->view($this->path.'header',$vars);
		if($site!=NULL)
			$this->load->view($site,$vars);
		$this->load->view($this->path.'footer',$vars);
	}
	
	public function index()
	{ 
		$vars=array();
		$user_tab['id_user']=$this->session->userdata('id_user');
		$user_tab['id_client']=$this->session->userdata('id_client');
		$vars['sum_cart']=$this->orders->sumCartByUser($this->session->userdata('id_user'));	
		$vars['favorite_list']=$this->products->getFavoriteList($this->session->userdata('id_user'));
		$vars['colors']=$this->products->getColorsList();
		$vars['producers']=$this->products->getProducersList();
		$vars['client']=$this->client->getById($this->session->userdata('id_client'));
		$vars['adviser']=$this->access->getUserByIdShort($vars['client']['id_user_system']);
		$vars['categories']=$this->products->getCategoriesListByParentId(0,$user_tab);
		$vars['path']=$this->path;
		$vars['promotions'] = $this->promotions->getListForUser($this->session->userdata('id_client'));
		$vars['discounts'] = $this->discounts->getListForUser($this->session->userdata('id_client'));
		$vars['vars_products']['title']="Produkty w promocji";
		$vars['news'] =$this->articles->getNewsList();
		$vars['block_news']=$this->load->view($this->path."block_news", $vars, true);
		$vars['block_promotion']=$this->load->view($this->path."block_promotion", $vars, true);
		$vars['block_search']=$this->load->view($this->path."block_search", $vars, true);
		$vars['block_products']=$this->load->view($this->path."block_products", $vars, true);
		$vars['block_categories']=$this->load->view($this->path."block_categories", $vars, true);
		$this->display($this->path."index",$vars);
	}
	public function changePassword()
	{	
		$this->access->setPassword($this->session->userdata('id_user'),$_POST['password']);
		redirect(base_url(),'refresh');
	}
	
}
?>