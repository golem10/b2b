<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inquiries extends CI_Controller
{	
	private $path = 'site/';

	function __construct()
  	{
		parent::__construct();
		$this->load->model('access');
		$this->load->model('clientsmodel','client');
		$this->load->model('productsmodel','products');
		$this->load->model('ordersmodel','orders');
		$this->load->model('settingsmodel','settings');
		$this->load->model('loyaltymodel','loyalty');
		$this->load->model('inquiriesmodel','inquiries');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->helper('url');	
		if(!$this->access->isLogIn())
			redirect(base_url("login"),'refresh');	
		elseif($this->session->userdata('id_profile') < 3)
			redirect(base_url("login"), 'refresh');
	}
		
	private function display($site=NULL,$vars=array())
	{	
		$vars['loyalty_points']=$this->loyalty->getLoyaltyPointsForClient($this->session->userdata('id_client'));
		$vars['css']=array("bootstrap.css",$this->path."main.css","jquery-ui.css");
		$vars['js']=array("jquery-2-1-1.min.js","jquery-ui.js","bootstrap.min.js","general.js","modalDialogAction.js","orders.js");
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
		$vars['sum_cart']=$this->orders->sumCartByUser($this->session->userdata('id_user'));	
		$vars['cart_products']=$this->orders->getCartProducts($this->session->userdata('id_user'));	
		$vars['favorite_list']=$this->products->getFavoriteList($this->session->userdata('id_user'));
		$vars['client']=$this->client->getById($this->session->userdata('id_client'));
		$vars['adviser']=$this->access->getUserByIdShort($vars['client']['id_user_system']);
		$vars['path']=$this->path;
		
		$vars['inquiries']=$this->inquiries->getInquiries($this->session->userdata('id_user'),$page_start);	
		$vars['inquiries_products']=$this->inquiries->getInquiriesProducts($vars['inquiries']);
		$config['base_url'] = base_url('inquiries/index/');
		$config['total_rows'] = $this->inquiries->countInquiries($this->session->userdata('id_user'));
		$config['uri_segment']=3;	
		$this->pagination->initialize($config); 
		$vars['pagination_links']=$this->pagination->create_links();
		$vars['page']=$page_start;
					
		$vars['breadcrumbs']=$this->load->view($this->path."breadcrumbs", $vars, true);		
		$this->display($this->path."inquiries_list",$vars);
	}
	public function createCartFromInquiry($id_inquiry=0)
	{ 
		$this->inquiries->createCartFromInquiry($id_inquiry,$this->session->userdata('id_user'),$this->session->userdata('id_client'));	
		redirect(base_url('orders/cart'),'refresh');	
	}
	public function cancelInquiry($id_inquiry=0)
	{ 
		$this->inquiries->cancelInquiry($id_inquiry,$this->session->userdata('id_user'));	
		redirect(base_url('inquiries'),'refresh');	
	}
	
	public function createFromOrder($id_order=0)
	{ 
		$this->inquiries->createFromOrder($id_order,$this->session->userdata('id_user'),$this->session->userdata('id_client'));	
		redirect(base_url('inquiries?created=1'),'refresh');	
	}
	
	public function offerts($page_start=0)
	{ 	
		$vars['sum_cart']=$this->orders->sumCartByUser($this->session->userdata('id_user'));	
		$vars['cart_products']=$this->orders->getCartProducts($this->session->userdata('id_user'));	
		$vars['favorite_list']=$this->products->getFavoriteList($this->session->userdata('id_user'));
		$vars['client']=$this->client->getById($this->session->userdata('id_client'));
		$vars['adviser']=$this->access->getUserByIdShort($vars['client']['id_user_system']);
		$vars['path']=$this->path;
		
		$vars['offerts']=$this->inquiries->getActiveOffertsByClient($this->session->userdata('id_client'),$page_start);	
		$vars['offerts_products']=$this->inquiries->getOffertsProducts($vars['offerts']);
		$config['base_url'] = base_url('inquiries/offerts/');
		$config['total_rows'] = $this->inquiries->countOfferts($this->session->userdata('id_client'));
		$config['uri_segment']=3;	
		$this->pagination->initialize($config); 
		$vars['pagination_links']=$this->pagination->create_links();
		$vars['page']=$page_start;
					
		$vars['breadcrumbs']=$this->load->view($this->path."breadcrumbs", $vars, true);		
		$this->display($this->path."offerts_list",$vars);
	}
	public function createCartFromOffer($id_offer=0)
	{ 
		$this->inquiries->createCartFromOffer($id_offer,$this->session->userdata('id_user'),$this->session->userdata('id_client'));	
		redirect(base_url('orders/'),'refresh');	
	}
	
}
?>