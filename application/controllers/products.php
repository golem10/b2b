<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Products extends CI_Controller
{	
	private $path = 'site/';

	function __construct()
  	{
		parent::__construct();
		$this->load->model('access');
		$this->load->model('clientsmodel','client');
		$this->load->model('productsmodel','products');
		$this->load->model('contractsmodel','contracts');
		$this->load->model('ordersmodel','orders');
		$this->load->model('loyaltymodel','loyalty');
		$this->load->library('form_validation');
		$this->load->helper('url');	
		if(!$this->access->isLogIn())
			redirect(base_url("login"),'refresh');
		elseif($this->session->userdata('id_profile') < 3)
			redirect(base_url("login"), 'refresh');
	}
		
	private function display($site=NULL,$vars=array())
	{	$vars['loyalty_points']=$this->loyalty->getLoyaltyPointsForClient($this->session->userdata('id_client'));
		$vars['css']=array("bootstrap.css",$this->path."main.css","prettyPhoto.css","amazon_scroller.css");
		$vars['js']=array("jquery-2-1-1.min.js","bootstrap.min.js","general.js","jquery.prettyPhoto.js","amazon_scroller.js");
		$vars['path']=$this->path;
		$vars['contact']=$this->access->getFooterContact();
		$vars['traders']=$this->access->getFooterTraders();
		$vars['to_pay']=$this->payments->sumPaymentsToPay($this->session->userdata('id_client'));
		$this->load->view($this->path.'header',$vars);
		if($site!=NULL)
			$this->load->view($site,$vars);
		$this->load->view($this->path.'footer',$vars);
	}
	
	public function index($id_category=0)
	{ 	
	
	}
	public function view($id_product=0)
	{ 	
		$user_tab['id_user']=$this->session->userdata('id_user');
		$user_tab['id_client']=$this->session->userdata('id_client');
		$vars['sum_cart']=$this->orders->sumCartByUser($this->session->userdata('id_user'));	
		$vars['favorite_list']=$this->products->getFavoriteList($this->session->userdata('id_user'));
		$vars['client']=$this->client->getById($this->session->userdata('id_client'));
		$vars['adviser']=$this->access->getUserByIdShort($vars['client']['id_user_system']);
		$vars['path']=$this->path;
		$vars['product']=$this->products->getProductById($id_product,$user_tab);
		$vars['producer']=$this->products->getProducerById($vars['product']['id_producer']);
		if($vars['product'] == 0)
			redirect(base_url(), 'refresh');
		$vars['statuses']=$this->products->getStatusList();
		$vars['product_in_promotions']=$this->products->getIdProductInPromotions($this->session->userdata('id_client'),$id_product);
		$vars['id_category']=$vars['product']['id_category'];
		$vars['images']=$this->products->getImages($id_product);
		$vars['imageDefault']=$this->products->getDefaultImage($id_product);
		$vars['category']=$this->products->getCategoryById($vars['product']['id_category']);
		$vars['categories']=$this->products->getCategoriesListGroupByParentAccess($user_tab);
		$vars['breadcrumbs']=$this->load->view($this->path."breadcrumbs", $vars, true);		
		$vars['related_products'] = $this->products->getRelatedProducts($id_product);
		$vars['block_product_info']=$this->load->view($this->path."block_product_info", $vars, true);
		$vars['block_left_categories']=$this->load->view($this->path."block_left_categories", $vars, true);
		$this->display($this->path."product",$vars);
	}
	
	public function addToFavoriteList($id_product=0)
	{ 	
		$this->products->addToFavoriteList($id_product,$this->session->userdata('id_user'));
	}
	
}
?>