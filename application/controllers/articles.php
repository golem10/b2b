<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Articles extends CI_Controller
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
		$this->load->model('articlesmodel','articles');
		$this->load->library('form_validation');
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
	
	public function index($id_category=0)
	{ 	
	
	}
	public function view($id_article=0)
	{ 	$vars['sum_cart']=$this->orders->sumCartByUser($this->session->userdata('id_user'));	
		$vars['favorite_list']=$this->products->getFavoriteList($this->session->userdata('id_user'));
		$vars['client']=$this->client->getById($this->session->userdata('id_client'));
		$vars['adviser']=$this->access->getUserByIdShort($vars['client']['id_user_system']);
		$vars['path']=$this->path;

		$vars['breadcrumbs']=$this->load->view($this->path."breadcrumbs", $vars, true);		
		$vars['article']=$this->articles->getArticleById($id_article);
		$this->display($this->path."article",$vars);
	}
	

	
}
?>