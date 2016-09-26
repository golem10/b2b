<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Products extends CI_Controller
{	
	private $path = 'manager/';
	function __construct()
  	{
		parent::__construct();
		$this->load->helper('url');// ładne adresy url
		$this->load->model('access');
		$this->load->model('productsmodel','products');
		$this->load->model('clientsmodel','client');
		$this->load->library('form_validation');
		if(!$this->access->isLogIn())
			redirect(base_url($this->path."login"), 'refresh');	
		elseif($this->session->userdata('id_profile') >= 3)
			redirect(base_url(), 'refresh');
		if($this->session->userdata('id_profile') == 2 && !$this->access->checkPermissions(2,4))
			 redirect(base_url("manager"), 'refresh');	
	}
		
	private function display($site=NULL,$vars=array())
	{	$vars['menu_permission']=$this->access->getPermissionsForMenu(2);
		$vars['css']=array($this->path."main.css","bootstrap.css",$this->path."jquery.dataTables.min.css",$this->path."dataTables.tableTools.min.css");
		$vars['js']=array("jquery-2-1-1.min.js","bootstrap.min.js","modalDialogAction.js","jquery.dataTables.min.js","dataTables.tableTools.min.js","products.js","bootstrap4dataTables.js","ckeditor/ckeditor.js");
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
	
	public function index($id_category=0,$system_message=0)
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
		$vars['categories']=$this->products->getCategoriesList($id_category);
		//$vars['products']=$this->products->getProductsList($id_category);
		$vars['category']=$this->products->getCategoryById($id_category);
		$vars['id_category_active'] = $id_category;
		$vars['title']="Kategorie";
		$this->display($this->path."products/view",$vars);
	}
	public function deleteImage($id=0,$system_message=0)
	{
		$return=$this->products->deleteImage($_POST['idToDel']);		
		redirect(base_url($this->path."products/view/".$id."/".$return),'refresh');
	}
	public function setDefaultImage($id=0,$id_product=0)
	{
		$return=$this->products->setDefaultImage($id,$id_product);		
		redirect(base_url($this->path."products/view/".$id_product."/".$return),'refresh');
	}
	public function delProduct($id=0,$system_message=0)
	{
		$return=$this->products->deleteProduct($_POST['idToDel']);		
		if(isset($_GET['news']))
			redirect(base_url($this->path."products/news"),'refresh');
		else
			redirect(base_url($this->path."products/index/".$id),'refresh');
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
		if(isset($_POST))
			{
				if(isset($_GET['action']))
				{
					if($_GET['action']=="addImage")
					{
						$return=$this->products->uploadImage($id,$_POST);		
						$vars['msg_val']=$return;	
						if($vars['msg_val']!="")
							$return=2;
						else
							$return=1;
					}
					elseif($_GET['action']=="changeStatus")
					{ 
						$return=$this->products->changeStatus($id,$_POST['id_status']);		
						
					}
					elseif($_GET['action']=="settings")
					{ 
						$return=$this->products->updateSettings($id,$_POST);
						$vars['tab']=2;		
					}
					elseif($_GET['action']=="changeCategory")
					{ 
						$return=$this->products->changeCategory($id,$_POST);						
					}
					
					elseif($_GET['action']=="productsAvailability")
					{ 
						$return=$this->products->updateProductsAvailability($id,$_POST);						
					}
					elseif($_GET['action']=="changeDiscountGroup")
					{ 
						$return=$this->products->setDiscountsGroups($id,$_POST);						
					}
					elseif($_GET['action']=="updatePrice")
					{ 
						$return=$this->products->updatePrice($id,$_POST);						
					}
				if(isset($return	))
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
		if(isset($_GET['action']))
				{
				if($_GET['action'] == 'fixedPrice')
					$vars['tab']=3;
				elseif($_GET['action'] == 'related')
					$vars['tab']=4;
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
		
		$vars['path']=$this->path;	
		$vars['fixed_prices'] = $this->products->getFixedPrices($id);
		$vars['categories'] = $this->products->getCategoriesListGroupByParent();	
		$vars['product']=$this->products->getProductWithPriceById($id);
		$vars['colors']=$this->products->getColorsList(true, 'id_color');
		$vars['discounts_groups']=$this->products->getDiscountsGroups();
		$vars['producers']=$this->products->getProducersList(true);
		$vars['images']=$this->products->getImages($id);
		$vars['statuses']=$this->products->getStatusList();
		$vars['users_accept']=$this->access->getUsersListByProfile(3,$id);
		$vars['users_introductory']=$this->access->getUsersListByProfile(4,$id);
		$vars['related_products'] = $this->products->getRelatedProductsManager($id);
		$vars['block_fixed_prices']=$this->load->view($this->path."products/block_fixed_prices", $vars, true);
		$vars['block_related_products']=$this->load->view($this->path."products/block_related_products", $vars, true);
		$vars['title']="Informacje o produkcie";
		$this->display($this->path."products/info",$vars);
	}
	
	public function clientsToFixedPrice($id_product=0,$price=0)
	{ 
		$vars=array();
		$vars['fixed_price'] = $this->products->getFixedPrice($id_product,$price);

		if(isset($_POST['id_clients']))
			{
			print_r($_POST['id_clients']); echo"<br/><br/>";
			print_r($_POST); echo"<br/><br/>";
			$_POST['price']=str_replace(",",".",$_POST['price']);
			$return = $this->products->setFixedPrices($id_product,$_POST);
			redirect(base_url($this->path."products/view/".$id_product."/".$return),'refresh');
			}
		$vars['id_product']=$id_product;
		$vars['clients']=$this->client->getListForFixedPrice($vars['fixed_price']);
		$vars['title']="Cena stała";
		$this->display($this->path."products/view_clients_fixed_price",$vars);
	}
	
	public function fixedPrice($id_product=0,$price=0)
	{ 
		$vars=array();
		$vars['fixed_price'] = $this->products->getFixedPrice($id_product,$price);
		if(isset($_POST['id_clients']))
			{
			$_POST['price']=str_replace(",",".",$_POST['price']);
			$return = $this->products->setFixedPrices($id_product,$_POST,$price);
			redirect(base_url($this->path."products/view/".$id_product."/".$return."?action=fixedPrice"),'refresh');
			}
		$vars['clients']=$this->client->getList();
		$vars['title']="Cena stała";
		$this->display($this->path."products/fixed_price",$vars);
	}
	public function news($id=0,$system_message=0)
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
		$vars['products']=$this->products->getNewProductsList();
		$vars['title']="Kategorie";
		$this->display($this->path."products/view_news",$vars);
	}
	public function all_assigned($id=0,$system_message=0)
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
		//$vars['products']=$this->products->getAllAssignedProductsList();
		$vars['title']="Kategorie";
		$this->display($this->path."products/view_all_assigned",$vars);
	}
	public function deletedProducts($id=0,$system_message=0)
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
		$vars['products']=$this->products->getNewProductsList();
		$this->display($this->path."products/deletedProducts",$vars);
	}
	public function setRelated($id_rel=0,$id_product = 0)
	{
		$return=$this->products->setRelatedProduct($id_rel,$id_product);		
		redirect(base_url($this->path."products/view/".$id_product."/".$return."?action=related"),'refresh');
	}
	public function setRelativeCheckbox($id_product = 0)
	{
		$return=$this->products->setRelatedProductAll($_POST,$id_product);		
		redirect(base_url($this->path."products/view/".$id_product."/".$return."?action=related"),'refresh');
	}
	public function delRelatedProduct($id=0,$system_message=0)
	{
		$return=$this->products->delRelatedProduct($_POST['idToDel'],$id);		
		redirect(base_url($this->path."products/view/".$id."/".$return."?action=related"),'refresh');
	}
	public function delFixedPrice($id=0,$system_message=0)
	{
		$return=$this->products->delFixedPrice($_POST['idToDel'],$id);		
		redirect(base_url($this->path."products/view/".$id."/".$return."?action=fixedPrice"),'refresh');
	}
	public function returnProduct($id=0,$system_message=0)
	{
		$return=$this->products->returnProduct($_POST['idToDel']);		
		redirect(base_url($this->path."products/deletedProducts/0/".$return),'refresh');
	}
	///////////////////////////////////////////////////////////////
	
}

?>