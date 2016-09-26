<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inquiries extends CI_Controller
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
		$this->load->model('inquiriesmodel','inquiries');
		$this->load->library('form_validation');
		if(!$this->access->isLogIn())
			redirect(base_url($this->path."login"), 'refresh');	
		elseif($this->session->userdata('id_profile') >= 3)
			redirect(base_url(), 'refresh');
		if($this->session->userdata('id_profile') == 2 && !$this->access->checkPermissions(2,3))
			 redirect(base_url("manager"), 'refresh');	
			
	}
		
	private function display($site=NULL,$vars=array())
	{	$vars['menu_permission']=$this->access->getPermissionsForMenu(2);
		$vars['css']=array($this->path."main.css","jquery-ui.css","bootstrap.css",$this->path."jquery.dataTables.min.css",$this->path."dataTables.tableTools.min.css");
		$vars['js']=array("jquery-2-1-1.min.js","jquery-ui.js","bootstrap.min.js","modalDialogAction.js","jquery.dataTables.min.js","dataTables.tableTools.min.js","bootstrap4dataTables.js","clients.js");
		$vars['path']=$this->path;
		$vars['contact']=$this->access->getFooterContact();
		$vars['traders']=$this->access->getFooterTraders();
		$this->load->view($this->path.'header',$vars);
		if(isset($vars['msg']))
			{
			if($vars['msg_val']!="")
			$this->load->view($this->path.'info_status',$vars);
			}
		if($site!=NULL)
			$this->load->view($site,$vars);
		$this->load->view($this->path.'footer',$vars);
	}
	
	public function index($system_message=0)
	{	$vars=array();
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
		$vars['path']=$this->path;
		$vars['inquiries']=$this->inquiries->getInquiriesAll();
		$vars['block_inquiries']=$this->load->view($this->path."inquiries/block_inquiries", $vars, true);
		$vars['title']="Lista zapytań ofertowych";
		$this->display($this->path."inquiries/view",$vars);
	}
	public function info($id_inquiry=0,$system_message=0)
	{ 
		$vars=array();
		if(isset($_POST))
			{
				if(isset($_POST['id_inquiry']))
				{									 
					$return=$this->inquiries->sendAnswer($_POST,$this->session->userdata('id_user'));	
					redirect(base_url($this->path."inquiries/index/".$return),'refresh');				
					
				}
				
			}
		$vars['path']=$this->path;
		$vars['id_inquiry']=$id_inquiry;
		$vars['inquiry']=$this->inquiries->getInquiryById($id_inquiry);
		$vars['client']=$this->client->getById($vars['inquiry']['id_client']);
		$vars['products']=$this->inquiries->getProductsToInquiry($id_inquiry);
		$vars['productsPrices']=$this->inquiries->getProductsPrices($vars['inquiry']['id_client'],$vars['products']);
		$vars['title']="Zapytanie ofertowe";
		$this->display($this->path."inquiries/info",$vars);
	}
	public function offerts($system_message=0)
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
		$vars['path']=$this->path;
		$vars['offerts']=$this->inquiries->getOffertsAll();
		$vars['block_offers']=$this->load->view($this->path."inquiries/block_offers", $vars, true);
		$vars['title']="Oferty";
		$this->display($this->path."inquiries/view_offers",$vars);
	}
	public function create($id_client=0,$system_message=0,$id_category=0,$id_offer=0)
	{ 	$vars=array();
		if($_POST)
			{
				if(isset($_POST['price']))
					{
						if($id_offer == 0)
							$id_offer=$this->inquiries->addOffer($this->session->userdata('id_user'),$id_client);
						
						$return=$this->inquiries->addProduct($_POST,$id_offer);
						if(isset($return['msg']))
							{	$vars['msg_val']=$return['msg_val'];
								$vars['msg']=$return['msg'];
							}
						else{
						$system_message=1;
						redirect(base_url($this->path."inquiries/create/".$id_client."/".$system_message."/".$id_category."/".$id_offer, 'refresh'));	
						}
					}
				elseif(isset($_POST['idToDel']))
					{
						$system_message=$this->inquiries->delProduct($_POST['idToDel']);
					}
				elseif(isset($_POST['id_offer']))
					{
						$system_message=$this->inquiries->save($_POST);
						redirect(base_url($this->path."inquiries/offerts/".$system_message));	
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
		$vars['title']="Stwórz ofertę";
		$vars['id_offer']=$id_offer;
		$vars['offer_products']=$this->inquiries->getProductsOfferListForInfo($id_offer);
		$vars['categories']=$this->products->getCategoriesList($id_category);
		$vars['category']=$this->products->getCategoryById($id_category);
		$vars['products']=$this->products->getProductsList($id_category);
		$vars['id_categoryMain'] = $id_category;
		$vars['client']=$this->client->getById($id_client);
		$vars['offer']=$this->inquiries->getOffer($id_offer);
		$vars['clients']=$this->clients->getList();
		$this->display($this->path."inquiries/new_offer",$vars);
	}
	public function update($id_client=0,$system_message=0,$id_category=0,$id_offer=0)
	{
		if($_POST)
			{
			$system_message=$this->inquiries->editProduct($_POST);
			}
		redirect(base_url($this->path."inquiries/create/".$id_client."/".$system_message."/0/".$id_offer));	
	}
	
	
}

?>