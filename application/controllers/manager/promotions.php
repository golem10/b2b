<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Promotions extends CI_Controller
{	
	private $path = 'manager/';
	function __construct()
  	{
		parent::__construct();
		$this->load->helper('url');// ładne adresy url
		$this->load->model('access');
		$this->load->model('groupsmodel','groups');
		$this->load->model('promotionsmodel','promotions');
		$this->load->model('productsmodel','products');
		$this->load->library('form_validation');
		if(!$this->access->isLogIn())
			redirect(base_url($this->path."login"), 'refresh');	
		elseif($this->session->userdata('id_profile') >= 3)
			redirect(base_url(), 'refresh');
		if($this->session->userdata('id_profile') == 2 && !$this->access->checkPermissions(2,5))
			 redirect(base_url("manager"), 'refresh');		
	}
		
	private function display($site=NULL,$vars=array())
	{	$vars['menu_permission']=$this->access->getPermissionsForMenu(2);
		$vars['css']=array($this->path."main.css","jquery-ui.css","bootstrap.css",$this->path."jquery.dataTables.min.css",$this->path."dataTables.tableTools.min.css",$this->path."discounts.css");
		$vars['js']=array("jquery-2-1-1.min.js","jquery-ui.js","bootstrap.min.js","modalDialogAction.js","jquery.dataTables.min.js","dataTables.tableTools.min.js","products.js","bootstrap4dataTables.js", "promotions.js","ckeditor/ckeditor.js");
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
		$vars['path']=$this->path;
		$vars['title']="Promocje";
		$type = 1;
		$vars['groups']=$this->groups->getList($type);
		$vars['promotions']=$this->promotions->getList();
		$this->display($this->path."promotions/index",$vars);
	}
	
	public function promotion($id=NULL,$id_product=0,$id_category=0)
	{
		if($id_product==0)
		{
			
			$vars['categories']=$this->products->getCategoriesList($id_category);
			$vars['products']=$this->products->getProductsListActive($id_category);
			$vars['category']=$this->products->getCategoryById($id_category);
			$vars['title']="Wybierz produkt dla promocji";
			$vars['return']=$this->products->getCategoryParentId($id_category);
			$this->display($this->path."promotions/chose_product",$vars);
		}
		else
		{
			$vars['post']=$_POST;
			$vars['path']=$this->path;
			$vars['groups']=$this->promotions->getGroupsWithPromotion($id);
			$vars['positions']=$this->promotions->getPositions($id);
			$vars['gratises']=$this->promotions->getGratises($id);
			$vars['dates']=$this->promotions->getDates($id);
			$vars['promotion']=$this->promotions->getById($id);
			
			$vars['def']=array(
						'id_group'=>'',
						'name'=>'',
						'description'=>''
				);
			
			if($vars['promotion']){
				$vars['def']=$vars['promotion'];
				$vars['title']="Edycja promocji ". $vars['promotion']['name'];
			} else {
				$vars['title']="Tworzenie promocji";
			}
			
			if ($this->form_validation->run('addPromotion') != FALSE)
			{ 		
				if(!$this->promotions->checkNameIsUnique($_POST['name'],$id))
					{
						$vars['msg_val'].='Ta nazwa jest już zajęta';
						$vars['msg']=2;
					}
				else{
					$promotion = array(
						'name' => $_POST['name'],
						'description' => $_POST['description'],
						'id_product' => $id_product,						
						
					);
					if(isset($_POST['id_type']))
					{
						$promotion['id_type'] = $_POST['id_type'];
						$promotion['id_status'] = 1;
						}
					$last_id = $this->promotions->addOrUpdatePromotion($promotion,$id);
					
					$this->promotions->assignGroupsToPromotion($_POST['groups'], $last_id);
					if(isset($_POST['id_type']))
					{
						if($_POST['id_type'] == 1)
						{
							$tab['date_from']=$_POST['date_from'];
							$tab['date_to']=$_POST['date_to'];
							$tab['price']=str_replace(",",".",$_POST['price']);
							$this->promotions->assignDateToPromotion($tab, $last_id);
						}
						else if($_POST['id_type'] == 2)
						{
							$this->promotions->assignPositionsToPromotion($_POST['positions'], $last_id);
						}
						else if($_POST['id_type'] == 3)
						{
							$this->promotions->assignGratisToPromotion($_POST['positions'], $last_id);
						}
					}
					redirect(base_url($this->path."promotions"),'refresh');
				}
				
			}
			else
			{
				$vars['msg']=2;
				$vars['msg_val']=validation_errors();
			}
			
			$vars['product']=$this->products->getProductById($id_product);
			$this->display($this->path."promotions/add",$vars);
		}
	}
	
	public function changeactive($id_promotion=0)
	{	$this->promotions->changeactive($id_promotion);
		redirect(base_url($this->path."promotions"),'refresh');
	}
	
	public function del()
	{	$this->promotions->delete($_POST['idToDel']);
		redirect(base_url($this->path."promotions/index/1"),'refresh');
	}
	///////////////////////////////////////////////////////////////
	
}

?>