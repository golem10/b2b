<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Import extends CI_Controller
{	
	private $path = 'manager/';
	function __construct()
  	{
		parent::__construct();
		$this->load->helper('url');// ładne adresy url
		$this->load->model('access');
		$this->load->model('clientsmodel','clients');
		$this->load->model('productsmodel','products');
		$this->load->library('form_validation');
		if(!$this->access->isLogin())
			redirect(base_url($this->path."login"), 'refresh');	
		elseif($this->session->userdata('id_profile') == 2)
			redirect(base_url($this->path), 'refresh');	
		elseif($this->session->userdata('id_profile') >= 3)
			redirect(base_url(), 'refresh');
		if($this->session->userdata('id_profile') == 2 && !$this->access->checkPermissions(2,4))
			 redirect(base_url("manager"), 'refresh');		
	}
		
	private function display($site=NULL,$vars=array())
	{	$vars['menu_permission']=$this->access->getPermissionsForMenu(2);
		$vars['css']=array($this->path."main.css","bootstrap.css",$this->path."jquery.dataTables.min.css",$this->path."dataTables.tableTools.min.css");
		$vars['js']=array("jquery-2-1-1.min.js","bootstrap.min.js","modalDialogAction.js","jquery.dataTables.min.js","dataTables.tableTools.min.js","bootstrap4dataTables.js");
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
		$vars['title'] = "Import danych";
		$this->display($this->path."import/view",$vars);
	}
	public function details($id_import=0,$source)
	{ 
		$vars['title'] = "Szczegóły importu";
		$vars['id_import'] = $id_import;
		$vars['source'] = $source;
		$this->display($this->path."import/details",$vars);
	}
	public function details_position($source,$id_obj)
	{ 
		$vars['title'] = "Szczegóły importu";
		$vars['id_obj'] = $id_obj;
		$vars['source'] = $source;
		if($source == 1)
			$vars['pos']=$this->products->getProductsImportDetails($id_obj);
		else
			$vars['pos']=$this->clients->getClientsImportDetails($id_obj);
		$this->display($this->path."import/details_product",$vars);
	}
	public function priceList($system_message=0)
	{ 	
		$content_file = file_get_contents($_FILES['userfile']['tmp_name']);
		$result = $this->products->import_from_csv($content_file);
		if($result)
		{
		$vars['msg_val']='Ceny zostały prawidłowo zaimportowane';
		$vars['msg']=1;
		}
		else
		{
		$vars['msg_val']='Błąd podczas importu.';
		$vars['msg']=2;
		}
		$this->display($this->path."import/price_list_view",$vars);
	}
	///////////////////////////////////////////////////////////////
	
	
}

?>