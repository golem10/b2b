<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dictionaries extends CI_Controller
{	
	private $path = 'manager/';
	function __construct()
  	{
		parent::__construct();
		$this->load->helper('url');// ładne adresy url
		$this->load->model('access');
		$this->load->model('productsmodel','products');
		$this->load->library('form_validation');
		if(!$this->access->isLogIn())
			redirect(base_url($this->path."login"), 'refresh');	
		elseif($this->session->userdata('id_profile') >= 3)
			redirect(base_url(), 'refresh');
		if($this->session->userdata('id_profile') == 2 && !$this->access->checkPermissions(2,7))
			 redirect(base_url("manager"), 'refresh');		
	}
	
	private function display($site=NULL,$vars=array())
	{	$vars['menu_permission']=$this->access->getPermissionsForMenu(2);
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
		$vars['category']=$this->products->getCategoryById($id_category);
		$vars['producers']=$this->products->getProducersList(true, 'id_producer');
		$vars['colors']=$this->products->getColorsList(true, 'id_color');
		$vars['id_cat']=$id_category;
		$vars['title']="Kategorie";
		$this->display($this->path."dictionaries/view",$vars);
	}
	
	function category($id_parent=null, $id=null){
		$vars = array();
		if(isset($_POST) && !empty($_POST)){
			if($this->form_validation->run('updateCategory') != FALSE){
				if($id){
					if($this->products->updateCategory($_POST, $id)){
						redirect(base_url($this->path."dictionaries/index/".$id_parent."/1"), 'refresh');	
					};
				} else {
					if($this->products->insertCategory($_POST, $id_parent)){
						redirect(base_url($this->path."dictionaries/index/".$id_parent."/1"), 'refresh');	
					};
				}
			}
			if($id){
				$category = $this->products->getCategoryById($id);
				if($_POST['name'] == $category['name']){
					redirect(base_url($this->path."dictionaries/index/".$id_parent."/1"), 'refresh');
				};
			}
			$vars['msg_val']='Nazwa musi być unikalna';
			$vars['msg']=2;
		}
		
		if(isset($_GET['action'])){
			if($_GET['action']=="addImage"){
				$return=$this->products->uploadCategoryImage($id,$_POST);		
				$vars['msg_val']=$return;	
				if($vars['msg_val']!=""){
					$vars['msg_val']='Błąd wykonywania czynności';
					$vars['msg']=2;
				} else {
					$vars['msg_val']='Zadanie wykonano pomyślnie';
					$vars['msg']=1;
				}
			}
		}
		
		if($id){
			$vars['category']=$this->products->getCategoryById($id);
			$vars['title']='Edytuj kategorię';
		} else {
			$vars['category']['name']='';
			$vars['category']['img']='';
			$vars['title']='Dodaj kategorię';
		}
		$vars['id_parent'] = $id_parent;
		$vars['id_category'] = $id;
		$this->display($this->path."dictionaries/addcategory",$vars);
	}
	public function deleteCatImage($id_parent =0, $id_category = 0)
	{
		$return=$this->products->deleteCatImage($_POST['idToDel']);		
		redirect(base_url($this->path."dictionaries/category/".$id_parent."/".$id_category),'refresh');
	}
	function color($id=null){
		$vars = array();
		if(isset($_POST) && !empty($_POST)){
			if($this->form_validation->run('updateColor') != FALSE){
				if($id){
					if($this->products->updateColor($_POST, $id)){
						redirect(base_url($this->path."dictionaries/index/0/1"), 'refresh');	
					};
				} else {
					if($this->products->insertColor($_POST)){
						redirect(base_url($this->path."dictionaries/index/0/1"), 'refresh');	
					};
				}
			}
			if($id){
				$color = $this->products->getColorById($id);
				if($_POST['name'] == $color['name']){
					redirect(base_url($this->path."dictionaries/index/0/1"), 'refresh');
				};
			}
			$vars['msg_val']='Nazwa musi być unikalna';
			$vars['msg']=2;
		}
		
		if($id){
			$vars['color']=$this->products->getColorById($id);
			$vars['title']='Edytuj kolor';
		} else {
			$vars['color']['name']='';
			$vars['title']='Dodaj kolor';
		}
		$this->display($this->path."dictionaries/addcolor",$vars);
	}
	
	function producer($id=null){
		$vars = array();
		if(isset($_POST) && !empty($_POST)){
			if($this->form_validation->run('updateColor') != FALSE){
				if($id){
					if($this->products->updateProducer($_POST, $id)){
						redirect(base_url($this->path."dictionaries/index/0/1"), 'refresh');	
					};
				} else {
					if($this->products->insertProducer($_POST)){
						redirect(base_url($this->path."dictionaries/index/0/1"), 'refresh');	
					};
				}
			}
			if($id){
				$producer = $this->products->getProducerById($id);
				if($_POST['name'] == $producer['name']){
					redirect(base_url($this->path."dictionaries/index/0/1"), 'refresh');
				};
			}
			$vars['msg_val']='Nazwa musi być unikalna';
			$vars['msg']=2;
		}
		
		if($id){
			$vars['producer']=$this->products->getProducerById($id);
			$vars['title']='Edytuj producenta';
		} else {
			$vars['producer']['name']='';
			$vars['title']='Dodaj producenta';
		}
		$this->display($this->path."dictionaries/addproducer",$vars);
	}
	
	public function delCategory(){
		$this->access->delCategory($_POST['idToDelCategory']);
		
		redirect(base_url($this->path."dictionaries"),'refresh');
	}
	
	public function delColor(){
		$this->access->delColor($_POST['idToDelColor']);
		
		redirect(base_url($this->path."dictionaries"),'refresh');
	}
	
	public function delProducer(){
		$this->access->delProducer($_POST['idToDelProducer']);
		
		redirect(base_url($this->path."dictionaries"),'refresh');
	}
	
	///////////////////////////////////////////////////////////////
	
}

?>