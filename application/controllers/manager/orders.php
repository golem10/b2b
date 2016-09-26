<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Orders extends CI_Controller
{	
	private $path = 'manager/';
	function __construct()
  	{
		parent::__construct();
		$this->load->helper('url');// ładne adresy url
		$this->load->model('access');
		$this->load->model('clientsmodel','client');
		$this->load->model('contractsmodel','contracts');
		$this->load->model('productsmodel','products');
		$this->load->model('ordersmodel','orders');
		$this->load->library('email');
		$this->load->library('form_validation');
		if(!$this->access->isLogIn())
			redirect(base_url($this->path."login"), 'refresh');	
		elseif($this->session->userdata('id_profile') >= 3)
			redirect(base_url(), 'refresh');
			
		if($this->session->userdata('id_profile') == 2 && !$this->access->checkPermissions(2,2))
			 redirect(base_url("manager"), 'refresh');	
	}
		
	private function display($site=NULL,$vars=array())
	{	$vars['menu_permission']=$this->access->getPermissionsForMenu(2);
		$vars['css']=array($this->path."main.css","jquery-ui.css","bootstrap.css",$this->path."jquery.dataTables.min.css",$this->path."dataTables.tableTools.min.css");
		$vars['js']=array("jquery-2-1-1.min.js","jquery-ui.js","bootstrap.min.js","modalDialogAction.js","jquery.dataTables.min.js","dataTables.tableTools.min.js","bootstrap4dataTables.js","clients.js");
		$vars['path']=$this->path;
		$this->load->view($this->path.'header',$vars);
		if(isset($vars['msg']))
			{
			if($vars['msg_val']!="")
			$this->load->view($this->path.'info_status',$vars);
			}
		if($site!=NULL)
			$this->load->view($site,$vars);
		$this->load->view($this->path.'footer');
	}
	
	public function index($system_message=0)
	{	$vars=array();
		$vars['path']=$this->path;
		$vars['orders']=$this->orders->getOrders();
		$vars['block_orders']=$this->load->view($this->path."orders/block_orders", $vars, true);
		$vars['title']="Lista zamówień";
		$this->display($this->path."orders/view",$vars);
	}
	public function info($id_order=0,$system_message=0)
	{ 
		$vars=array();
		$vars['order']=$this->orders->getOrderById($id_order);
		$vars['client']=$this->client->getById($vars['order']['id_client']);
		if(isset($_POST))
			{
				if(isset($_GET['action']))
				{					
					if($_GET['action']=="changeStatus")
					{ 
						$return=$this->orders->changeStatus($id_order,$_POST['id_status']);		
						if($return == 99)
						{
							
							$user=$this->access->getUserById($vars['order']['id_user_accept']);
							$email[0]=$user['email'];
							$client_t=$this->client->getById($vars['order']['id_client']);
							$user=$this->access->getUserById($client_t['id_user_system']);
							$email[1]=$user['email'];
							$email[2]='jkk@partnerjkk.pl';
							$l=1;
							$temp=explode(",",$vars['client']['accpeted_orders_emails']);
								foreach($temp as $k=>$v)
								{
									$l++;
									$email[$l]=$v;
								}
											
							//$email[2]=$client_t['email'];
							
							$order_text = "<p>Klient: ".$client_t['name']."</p><p>Zamówienie <strong>".$id_order."</strong> zostało odwieszone i przekazane do realizacji.</p>";
							foreach($email as $id=>$address)
							{				
							 $this->email->to($address);
							 $this->email->from('jkk@partnerjkk.pl', 'JKK PARTER');
							 $this->email->subject('Zamówienie JKK PARTNER ');
							 $this->email->message($order_text);			
							 $this->email->send();
							}
						}
						$return = 1;
						$vars['order']['id_status'] = $_POST['id_status'];
					}
					switch ($return) {
					case 1:
						$vars['msg_val']='Zadanie wykonano pomyślnie';
						$vars['msg']=1;
						break;
					case 2:
						if(!isset($vars['msg_val']))
							$vars['msg_val']='Błąd wykonywania czynności';
						$vars['msg']=2;
						break;
					}
				}
				
			}
		$vars['path']=$this->path;
		
		$vars['products']=$this->orders->getProductsToOrder($id_order);
		$vars['statuses']=$this->orders->getStatuses();
		if($vars['order']['number_subiekt'] != "")
			$vars['title']="Zamówienie nr: ".$vars['order']['number_subiekt'];
		else
			$vars['title']="Zamówienie";
		$this->display($this->path."orders/info",$vars);
	}
	
	
}

?>