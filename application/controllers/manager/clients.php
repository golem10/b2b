<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Clients extends CI_Controller
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
		$this->load->model('discountsmodel','discounts');
		$this->load->model('paymentsmodel','payments');
		$this->load->model('loyaltymodel','loyalty');
		$this->load->library('form_validation');
		if(!$this->access->isLogIn())
			redirect(base_url($this->path."login"), 'refresh');	
		elseif($this->session->userdata('id_profile') >= 3)
			redirect(base_url(), 'refresh');
		
		// if($this->session->userdata('id_profile') == 2 && !$this->access->checkPermissions(2,1))
			// redirect(base_url("manager"), 'refresh');
			
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
	{ 
		$vars=array();
		switch ($system_message) {
			case 1:
				$vars['msg_val']='Zadanie wykonano pomyślnie';
				$vars['msg']=1;
				break;
			case 2:
				$vars['msg_val']='Błąd wykonywania czynności';
				$vars['msg']=2;
				break;
		}
		//$vars['clients']=$this->client->getList();
		$vars['title']="Klienci";
		$this->display($this->path."clients/view",$vars);
	}
	public function view($id=0,$system_message=0)
	{ 	
		$vars=array();
		$vars['tab']=1;
		switch ($system_message) {
			case 1:
				$vars['msg_val']='Zadanie wykonano pomyślnie';
				$vars['msg']=1;
				break;
			case 2:
				$vars['msg_val']='Błąd wykonywania czynności';
				$vars['msg']=2;
				break;
		}
		if($_POST)
			{
				if(isset($_GET['action']))
				{
					if($_GET['action'] == 'setLoyaltyPoints')
					{
						$this->client->setLoyaltyPointsForClient($id,$_POST['used_loyalty_points']);
						$vars['msg_val']='Zadanie wykonano pomyślnie';
						$vars['msg']=1;
						$vars['tab']=7;
					}
					else if($_GET['action'] == 'setStartLoyaltyPoints')
					{
						$this->client->setStartLoyaltyPointsForClient($id,$_POST['used_start_loyalty_points']);
						$vars['msg_val']='Zadanie wykonano pomyślnie';
						$vars['msg']=1;
						$vars['tab']=7;
					}
					else if($_GET['action'] == 'settings')
					{
						$_POST['amount']=str_replace(",",".",$_POST['amount']);
						$return=$this->client->updateSettings($id,$_POST);
						switch ($return) {
							case 1:
								$vars['msg_val']='Zadanie wykonano pomyślnie';
								$vars['msg']=1;
								break;
							case 2:
								$vars['msg_val']='Błąd wykonywania czynności';
								$vars['msg']=2;
								break;
							}
						$vars['tab']=4;
					}
					else if($_GET['action'] == 'discounts')
					{
						$return = $this->discounts->setValuesForDiscountsGroups($_POST,$id);
						switch ($return) {
							case 1:
								$vars['msg_val']='Zadanie wykonano pomyślnie';
								$vars['msg']=1;
								break;
							case 2:
								$vars['msg_val']='Błąd wykonywania czynności';
								$vars['msg']=2;
								break;
							}
						$vars['tab']=8;
					}
				}
				else
				{
				
				}
			}
		$vars['id_user_product'] = 0;
		if($_GET)
		{
			if($_GET['action'] == 'products')
					$vars['tab']=6;					
			elseif($_GET['action'] == 'contracts')
					$vars['tab']=5;	

			if(isset($_GET['id_user']))	
				{
				$id_user_product = $_GET['id_user'];
				$vars['id_user_product'] = $id_user_product;
				}
		}
		$vars['loyalty_points']=$this->loyalty->getLoyaltyPointsForClientAll($id);
		$vars_1['path']=$vars['path']=$this->path;
		$vars['client']=$this->client->getById($id);
		$vars['users_accept']=$this->access->getUsersListByProfile(4,$id);
		$vars['users_introductory']=$this->access->getUsersListByProfile(3,$id);
		$vars['user_system'] = $this->access->getUserById($vars['client']['id_user_system']);
		$vars['users_system'] = $this->access->getUsersListByRole(array(1,2));
		$vars['contracts_available']=$this->contracts->getByStatus(1,$id);
		$vars['contracts_expired']=$this->contracts->getByStatus(2,$id);
		$vars['orders']=$this->orders->getOrdersByClient($id);
		$vars_1['orders']=$this->orders->getOrdersByStatus($id,2);
		$vars['payments']=$this->payments->getPaymentsByClient($id);
		$vars['categories']=$this->products->getCategoriesListGroupByParent();
		$vars['productsGroups'] = $this->discounts->getDiscountsGroupsAll();
		$vars['productsGroupsValues'] = $this->discounts->getDiscountsGroupsValues($id);
		$vars['block_orders_to_realization']=$this->load->view($this->path."clients/block_orders", $vars_1, true);
		$vars['block_contracts']=$this->load->view($this->path."clients/block_contracts", $vars, true);
		$vars['block_orders']=$this->load->view($this->path."orders/block_orders", $vars, true);
		$vars['block_payments']=$this->load->view($this->path."payments/block_payments", $vars, true);
		$vars['block_discounts']=$this->load->view($this->path."clients/block_discounts", $vars, true);
		if(!isset($id_user_product))
			$vars['block_products']=$this->load->view($this->path."clients/block_products_users", $vars, true);
		else
		{
			$vars['available_category']=$this->clients->getClientCategoryAvailability($id_user_product);
			$vars['available_product']=$this->clients->getClientProductsAvailability($id_user_product);
			$vars['block_products']=$this->load->view($this->path."clients/block_products", $vars, true);			
		}
		$vars['title']="Informacje o kliencie";
		$this->display($this->path."clients/info",$vars);
	}
	public function addProductAvailable($id_category = 0, $id_client = 0, $id_user_product = 0)
	{
		if($_POST)
			{
				$system_message=$this->clients->setClientProductsAvailability($_POST);
				redirect(base_url($this->path."clients/view/".$id_client."/".$system_message."?action=products"));	
			}
		$vars['categories']=$this->products->getCategoriesList($id_category);
		$vars['products']=$this->products->getProductsList($id_category);
		$vars['category']=$this->products->getCategoryById($id_category);
		$vars['available_product']=$this->clients->getClientProductsAvailability($id_user_product);
		$vars['id_client'] = $id_client;
		$vars['id_user_product'] = $id_user_product;
		$vars['title']="Wybierz produkty z kategorii";
		$this->display($this->path."clients/productsView",$vars);
	}
	
	public function setClientCategoryAvailability($id_client = 0)
	{
		$system_message=$this->clients->setClientCategoryAvailability($_POST);
		redirect(base_url($this->path."clients/view/".$id_client."/".$system_message."?action=products"));	
	}
	public function deleteContract($id=0,$system_message=0)
	{
		$return=$this->contracts->deleteContract($_POST['idToDel']);		
		redirect(base_url($this->path."clients/view/".$id."?action=contracts"));	
	}
	public function newContract($id_client=0,$system_message=0,$id_category=0,$id_contract=0)
	{ 	$vars=array();
		if($_POST)
			{
				if(isset($_POST['price']))
					{
						if($id_contract == 0)
							$id_contract=$this->contracts->addContract($this->session->userdata('id_user'),$id_client);
						
						$return=$this->contracts->addProduct($_POST,$id_contract);
						if(isset($return['msg']))
							{	$vars['msg_val']=$return['msg_val'];
								$vars['msg']=$return['msg'];
							}
						else{
						$system_message=1;
						redirect(base_url($this->path."clients/newContract/".$id_client."/".$system_message."/".$id_category."/".$id_contract, 'refresh'));	
						}
					}
				elseif(isset($_POST['idToDel']))
					{
						$system_message=$this->contracts->delProduct($_POST['idToDel']);
					}
				elseif(isset($_POST['id_contract']))
					{
						$system_message=$this->contracts->save($_POST);
						redirect(base_url($this->path."clients/view/".$id_client."/".$system_message."?action=contracts"));	
					}
			}		
		switch ($system_message) {
			case 1:
				$vars['msg_val']='Zadanie wykonano pomyślnie';
				$vars['msg']=1;
				break;
			case 2:
				$vars['msg_val']='Błąd wykonywania czynności';
				$vars['msg']=2;
				break;
		}
		
		$vars['category']=$this->products->getCategoryById($id_category);
		if(!isset($vars['category']['id_category']))
			$vars['category']['id_category']=0;
		$vars['id_categoryMain']=$id_category;
		$vars['title']="Kontrakt";
		$vars['id_contract']=$id_contract;
		$vars['contract_products']=$this->contracts->getProductsListForInfo($id_contract);
		$vars['categories']=$this->products->getCategoriesList($id_category);
		//$vars['products']=$this->products->getProductsList($id_category);
		$vars['client']=$this->client->getById($id_client);
		$vars['contract']=$this->contracts->getContract($id_contract);
		$this->display($this->path."clients/new_contract",$vars);
	}
	public function editContractProduct($id_client=0,$system_message=0,$id_category=0,$id_contract=0)
	{
		if($_POST)
			{
			$system_message=$this->contracts->editProduct($_POST);
			}
		redirect(base_url($this->path."clients/newContract/".$id_client."/".$system_message."/0/".$id_contract));	
	}
	public function delProdAvail($id_client=0,$system_message=0,$id_category=0,$id_contract=0)
	{
		if($_POST)
			{
			$system_message=$this->clients->delProdAvail($_POST);
			}
		redirect(base_url($this->path."clients/view/".$id_client."?action=products"));	
	}
	///////////////////////////////////////////////////////////////
	
}

?>