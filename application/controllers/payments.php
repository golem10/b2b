<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payments extends CI_Controller
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
		$this->load->model('paymentsmodel','payments');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->helper('url');	
		if(!$this->access->isLogIn())
			redirect(base_url("login"),'refresh');	
		elseif($this->session->userdata('id_profile') == 3) 
			redirect(base_url(),'refresh');	
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
		if($this->session->userdata('id_profile') == 4)
		{
			$vars['sum_cart']=$this->orders->sumCartByUser($this->session->userdata('id_user'));			
			$vars['favorite_list']=$this->products->getFavoriteList($this->session->userdata('id_user'));
			$vars['client']=$this->client->getById($this->session->userdata('id_client'));
			$vars['adviser']=$this->access->getUserByIdShort($vars['client']['id_user_system']);
			
			// $config['base_url'] = base_url('payments/index/');
			// $config['total_rows'] = $this->payments->countPayments($this->session->userdata('id_client'));
			// $config['uri_segment']=3;	
			// $this->pagination->initialize($config); 
			// $vars['pagination_links']=$this->pagination->create_links();
			// $vars['page']=$page_start;
			$vars['pagination_links'] ="";
			$vars['path']=$this->path;
			$vars['breadcrumbs']=$this->load->view($this->path."breadcrumbs", $vars, true);		
			$vars['payments']=$this->payments->getPaymentsByClient($this->session->userdata('id_client'),0);	
			$vars['payments_old']=$this->payments->getPaymentsByClient($this->session->userdata('id_client'),1);
			$vars['corrections']=$this->payments->getCorrectionsByClient($this->session->userdata('id_client'),$vars['payments']);	
			$vars['corrections_old']=$this->payments->getCorrectionsByClient($this->session->userdata('id_client'),$vars['payments_old']);
			$this->display($this->path."payments",$vars);
		}
	}
	
}
?>