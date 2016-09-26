<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Permissions extends CI_Controller
{	
	private $path = 'manager/';
	function __construct()
  	{
		parent::__construct();
		$this->load->helper('url');// ładne adresy url
		$this->load->model('access');
		$this->load->library('form_validation');
		if(!$this->access->isLogIn())
			redirect(base_url($this->path."login"), 'refresh');	
		elseif($this->session->userdata('id_profile') >= 3)
			redirect(base_url(), 'refresh');
		if($this->session->userdata('id_profile') == 2 && !$this->access->checkPermissions(2,7))
			 redirect(base_url("manager"), 'refresh');		
	}
		
	private function display($site=NULL,$vars=array())
	{
		$vars['css']=array($this->path."main.css","jquery-ui.css","bootstrap.css",$this->path."jquery.dataTables.min.css",$this->path."dataTables.tableTools.min.css");
		$vars['js']=array("jquery-2-1-1.min.js","jquery-ui.js","bootstrap.min.js","modalDialogAction.js","jquery.dataTables.min.js","dataTables.tableTools.min.js","bootstrap4dataTables.js","raports.js");
		$vars['path']=$this->path;
		$vars['menu_permission']=$this->access->getPermissionsForMenu(2);
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
		if($_POST)
			{
			$this->access->updatePermissions(2,$_POST);
			redirect(base_url("manager/permissions/index/1"), 'refresh');
			}
		$vars['permissions'] = $this->access->getPermissions(2);
		$vars['title']="Uprawnienia";
		$this->display($this->path."permissions/view",$vars);
	}
	
	///////////////////////////////////////////////////////////////
	
}

?>