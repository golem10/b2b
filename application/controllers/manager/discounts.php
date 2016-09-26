<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Discounts extends CI_Controller
{	
	private $path = 'manager/';
	function __construct()
  	{
		parent::__construct();
		$this->load->helper('url');// ładne adresy url
		$this->load->model('access');
		$this->load->model('groupsmodel','groups');
		$this->load->model('discountsmodel','discounts');
		$this->load->model('productsmodel','products');
		$this->load->library('form_validation');
		if(!$this->access->isLogIn())
			redirect(base_url($this->path."login"), 'refresh');	
		elseif($this->session->userdata('id_profile') >= 3)
			redirect(base_url(), 'refresh');	
		if($this->session->userdata('id_profile') == 2 && !$this->access->checkPermissions(2,6))
			 redirect(base_url("manager"), 'refresh');	
			
	}
		
	private function display($site=NULL,$vars=array())
	{    $vars['menu_permission']=$this->access->getPermissionsForMenu(2);
		$vars['css']=array($this->path."main.css","bootstrap.css",$this->path."jquery.dataTables.min.css",$this->path."dataTables.tableTools.min.css");
		$vars['js']=array("jquery-2-1-1.min.js","bootstrap.min.js","modalDialogAction.js","jquery.dataTables.min.js","dataTables.tableTools.min.js","products.js","bootstrap4dataTables.js");
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
	
	public function index()
	{ 
		$vars['css']=array($this->path."main.css","bootstrap.css",$this->path."jquery.dataTables.min.css",$this->path."dataTables.tableTools.min.css",$this->path."discounts.css");
		$vars['js']=array("jquery-2-1-1.min.js","bootstrap.min.js","modalDialogAction.js","jquery.dataTables.min.js","dataTables.tableTools.min.js","products.js","bootstrap4dataTables.js");
		$vars['path']=$this->path;
		$vars['title']="Rabaty";
		$type = 1;
		$vars['groups']=$this->groups->getList($type);
		$vars['discounts']=$this->discounts->getList();
		$this->load->view($this->path.'header',$vars);
		$this->load->view($this->path.'discounts/index',$vars);
		$this->load->view($this->path.'footer');
	}
	
	public function discount($id=NULL)
	{
		$vars['post']=$_POST;
		$vars['css']=array($this->path."main.css","bootstrap.css",$this->path."jquery.dataTables.min.css",$this->path."dataTables.tableTools.min.css",$this->path."discounts.css");
		$vars['js']=array("jquery-2-1-1.min.js","bootstrap.min.js","modalDialogAction.js","jquery.dataTables.min.js","dataTables.tableTools.min.js","products.js","bootstrap4dataTables.js", "discounts.js","ckeditor/ckeditor.js");
		$vars['path']=$this->path;
		
		$vars['groups']=$this->discounts->getGroupsWithDiscount($id);
		$vars['categories']=$this->products->getCategoriesListGroupByParent();	
		$vars['positions']=$this->discounts->getPositions($id);
		$vars['discount']=$this->discounts->getById($id);
		
		$vars['def']=array(
					'id_group'=>'',
					'name'=>'',
					'description'=>''
			);
		
		if($vars['discount']){
			$vars['def']=$vars['discount'];
			$vars['title']="Edycja rabatu ". $vars['discount']['name'];
		} else {
			$vars['title']="Tworzenie rabatu";
		}
		
		if ($this->form_validation->run('addDiscount') != FALSE)
		{ 		
			if(!$this->discounts->checkNameIsUnique($_POST['name'],$id))
				{
					$vars['msg_val'].='Ta nazwa jest już zajęta';
					$vars['msg']=2;
				}
			else{
				$discount = array(
					'name' => $_POST['name'],
					'id_category' => $_POST['id_category'],
					'description' => $_POST['description'],
					'id_status' => 1
				);
				
				$last_id = $this->discounts->addOrUpdateDiscount($discount,$id);
				
				$this->discounts->assignGroupsToDiscount($_POST['groups'], $last_id);
				
				$this->discounts->assignPositionsToDiscount($_POST['positions'], $last_id);
				
				redirect(base_url($this->path."discounts"),'refresh');
			}
			
		}
		else
		{
			$vars['msg']=2;
			$vars['msg_val']=validation_errors();
		}
		
		
		$this->load->view($this->path.'header',$vars);
		$this->load->view($this->path.'discounts/adddiscount',$vars);
		$this->load->view($this->path.'footer');
	}
	
	public function group($id=NULL)
	{
		$vars['post']=$_POST;
		$vars['css']=array($this->path."main.css","bootstrap.css",$this->path."jquery.dataTables.min.css",$this->path."dataTables.tableTools.min.css",$this->path."discounts.css");
		$vars['js']=array("jquery-2-1-1.min.js","bootstrap.min.js","modalDialogAction.js","jquery.dataTables.min.js","dataTables.tableTools.min.js","products.js","bootstrap4dataTables.js", "discounts.js");
		$vars['path']=$this->path;
		
		$vars['clients']=$this->groups->getClientsWithGroup($id);
		$vars['group']=$this->groups->getById($id);
		
		$vars['def']=array(
					'id_group'=>'',
					'name'=>''
			);
		
		if($vars['group']){
			$vars['def']=$vars['group'];
			$vars['title']="Edycja grupy: ". $vars['group']['name'];
		} else {
			$vars['title']="Tworzenie grupy";
		}
		
		if ($this->form_validation->run('addGroup') != FALSE)
		{ 		
						
			if(!$this->groups->checkNameIsUnique($_POST['name'],$id))
				{
					$vars['msg_val'].='Ta nazwa jest już zajęta';
					$vars['msg']=2;
				}
			else{
				$group = array(
					'name' => $_POST['name'],
					'type' => 1,
					'id_status' => 1
				);
				
				$last_id = $this->groups->addOrUpdateGroup($group,$id);
				
				$this->groups->assignClientsToGroup($_POST['clients'], $last_id);
				
				redirect(base_url($this->path."discounts"),'refresh');
			}
			
		}
		else
		{
			$vars['msg']=2;
			$vars['msg_val']=validation_errors();
		}
		
		
		$this->load->view($this->path.'header',$vars);
		$this->load->view($this->path.'discounts/addgroup',$vars);
		$this->load->view($this->path.'footer');
	}
	public function group_view($id=NULL)
	{
		$vars['post']=$_POST;
		$vars['css']=array($this->path."main.css","bootstrap.css",$this->path."jquery.dataTables.min.css",$this->path."dataTables.tableTools.min.css",$this->path."discounts.css");
		$vars['js']=array("jquery-2-1-1.min.js","bootstrap.min.js","modalDialogAction.js","jquery.dataTables.min.js","dataTables.tableTools.min.js","products.js","bootstrap4dataTables.js", "discounts.js");
		$vars['path']=$this->path;
		
		$vars['clients']=$this->groups->getClientsWithGroup($id);
		$vars['group']=$this->groups->getById($id);
		
		$vars['def']=array(
					'id_group'=>'',
					'name'=>''
			);
		
		if($vars['group']){
			$vars['def']=$vars['group'];
			$vars['title']="Podgląd grupy: ". $vars['group']['name'];
		} else {
			$vars['title']="Tworzenie grupy";
		}
		
		
		
		$this->load->view($this->path.'header',$vars);
		$this->load->view($this->path.'discounts/view_group',$vars);
		$this->load->view($this->path.'footer');
	}
	public function view($id=0,$system_message=0)
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
		if(isset($_POST))
			{
				if(isset($_GET['action']))
				{
					if($_GET['action']=="addImage")
					{ /* TO DO */
						$this->products->uploadImage($id,$_POST);					
					}
					elseif($_GET['action']=="changeStatus")
					{ 
						$return=$this->products->changeStatus($id,$_POST['id_status']);						
					}
					elseif($_GET['action']=="settings")
					{ 
						$return=$this->products->updateSettings($id,$_POST);						
					}
					elseif($_GET['action']=="productsAvailability")
					{ 
						$return=$this->products->updateProductsAvailability($id,$_POST);						
					}
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
				}
			}
		$vars['clients']=$this->client->getList();
		$vars['users_by_role']=$this->access->getUsersListByRole(array(3,4));
		
		$vars['productAvailabilityClients']=$this->products->getProductAvailabilityClients($id);
		if(count($vars['productAvailabilityClients']) > 0)
			$vars['clients_available']=$this->client->getClientsById($vars['productAvailabilityClients']);
		else
			$vars['clients_available']=0;
			
		$vars['productAvailabilityUsers']=$this->products->getProductAvailabilityUsers($id);
		if(count($vars['productAvailabilityUsers']) > 0)
			$vars['users_available']=$this->access->getUsersById($vars['productAvailabilityUsers']);
		else
			$vars['users_available']=0;
			
		$vars['product']=$this->products->getProductById($id);
		$vars['statuses']=$this->products->getStatusList();
		$vars['users_accept']=$this->access->getUsersListByProfile(3,$id);
		$vars['users_introductory']=$this->access->getUsersListByProfile(4,$id);
		$vars['title']="Informacje o produkcie";
		$this->display($this->path."products/info",$vars);
	}
	
	
	public function del()
	{	$this->discounts->delete($_POST['idToDel']);
		redirect(base_url($this->path."discounts/index/1"),'refresh');
	}
	public function delGroup()
	{	$this->discounts->deleteGroup($_POST['idToDel']);
		redirect(base_url($this->path."discounts/index/1"),'refresh');
	}
	public function productsGroups($system_message=0)
	{ 
		if($_POST)
			{
			$return = $this->discounts->setValuesForDiscountsGroups($_POST);
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
			}
		$vars['productsGroups'] = $this->discounts->getDiscountsGroupsAll();
		$vars['title']="Grupy produktów";
		$this->display($this->path."discounts/products_groups",$vars);
	}
	///////////////////////////////////////////////////////////////
	
}

?>