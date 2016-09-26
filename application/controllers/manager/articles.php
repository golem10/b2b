<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Articles extends CI_Controller
{	
	private $path = 'manager/';
	function __construct()
  	{
		parent::__construct();
		$this->load->helper('url');// ładne adresy url
		$this->load->model('access');
		$this->load->model('clientsmodel','client');
		$this->load->model('articlesmodel','articles');
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
		$vars['css']=array($this->path."main.css","jquery-ui.css","bootstrap.css",$this->path."jquery.dataTables.min.css",$this->path."dataTables.tableTools.min.css");
		$vars['js']=array("jquery-2-1-1.min.js","jquery-ui.js","bootstrap.min.js","modalDialogAction.js","jquery.dataTables.min.js","dataTables.tableTools.min.js","bootstrap4dataTables.js","articles.js","ckeditor/ckeditor.js");
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
	
	public function index($system_message=99)
	{	$vars=array();
		$vars['tab']=1;	
		if($_POST)
			{													 
				$system_message=$this->articles->updateContact($_POST);	
				$_GET['action'] = 'contact';
			}
		switch ($system_message) {
			case 1:
				$vars['msg_val']='Zadanie wykonano pomyślnie';
				$vars['msg']=1;
				break;
			case 2:
				$vars['msg_val']='Błąd wykonywania czynności';
				$vars['msg']=0;
				break;
		}
		if($_GET)
		{
			if($_GET['action'] == 'news')
					$vars['tab']=1;					
			elseif($_GET['action'] == 'articles')
					$vars['tab']=2;				
			elseif($_GET['action'] == 'traders')
					$vars['tab']=3;				
			elseif($_GET['action'] == 'contact')
					$vars['tab']=4;				
		}
		$vars['path']=$this->path;
		$vars['articles']=$this->articles->getList();
		$vars['news']=$this->articles->getNewsList();
		$vars['traders']=$this->articles->getListTraders();
		$vars['contact']=$this->articles->getContact();
		$vars['title']="CMS";
		$this->display($this->path."articles/view",$vars);
	}
	public function edit($id_article=0,$system_message=0)
	{ 
		$vars=array();
		if(isset($_POST))
			{
				if ($this->form_validation->run('article') != FALSE)
				{ 										 
					$return=$this->articles->updateArticle($_POST,$id_article);	
					redirect(base_url($this->path."articles/index/".$return),'refresh');				
					
				}
				else
				{
					$vars['msg']=2;
					$vars['msg_val']=validation_errors();
				}
				
			}
		$vars['path']=$this->path;
		$vars['id_article']=$id_article;
		$vars['article']=$this->articles->getArticleById($id_article);
		$vars['title']="Artykuł: ".$vars['article']['title'];
		$this->display($this->path."articles/edit",$vars);
	}
	public function add($system_message=0)
	{ 
		$vars=array();
		if($_POST)
			{
				if ($this->form_validation->run('article') != FALSE)
				{ 										 
					$return=$this->articles->insertArticle($_POST,1);	
					redirect(base_url($this->path."articles/index/".$return),'refresh');				
					
				}
				else
				{
					$vars['msg']=2;
					$vars['msg_val']=validation_errors();
				}
				
			}
		$vars['path']=$this->path;
	
		$vars['title']="Dodaj";
		$this->display($this->path."articles/add",$vars);
	}
	public function addTrader($system_message=0)
	{ 
		$vars=array();
		$vars['trader']=array('name'=>"",'phone'=>"",'email'=>"");
		if($_POST)
			{
				if ($this->form_validation->run('trader') != FALSE)
				{ 										 
					$return=$this->articles->insertTrader($_POST);	
					redirect(base_url($this->path."articles/index/".$return."?action=traders"),'refresh');				
					
				}
				else
				{
					$vars['msg']=2;
					$vars['msg_val']=validation_errors();
				}
				
			}
		$vars['path']=$this->path;
		$vars['title']="Dodaj handlowca";
		$this->display($this->path."articles/addTrader",$vars);
	}
	public function editTraders($id_trader=0,$system_message=0)
	{ 
		$vars=array();
		if($_POST)
			{
				if ($this->form_validation->run('trader') != FALSE)
				{ 										 
					$return=$this->articles->updateTrader($_POST,$id_trader);	
					redirect(base_url($this->path."articles/index/".$return."?action=traders"),'refresh');				
					
				}
				else
				{
					$vars['msg']=2;
					$vars['msg_val']=validation_errors();
				}
				
			}
		$vars['path']=$this->path;
		$vars['id_trader']=$id_trader;
		$vars['trader']=$this->articles->getTraderById($id_trader);
		$vars['title']="Handlowiec: ".$vars['trader']['name'];
		$this->display($this->path."articles/editTrader",$vars);
	}
	public function delete($system_message=0)
	{
		$return=$this->articles->delete($_POST['idToDel']);		
		redirect(base_url($this->path."articles/index/".$return."?action=news"),'refresh');
	}
	public function deleteTrader($system_message=0)
	{
		$return=$this->articles->deleteTrader($_POST['idToDel']);		
		redirect(base_url($this->path."articles/index/".$return."?action=traders"),'refresh');
	}
	
	
}

?>