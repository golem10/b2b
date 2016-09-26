<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Loyalty extends CI_Controller
{	
	private $path = 'manager/';
	function __construct()
  	{
		parent::__construct();
		$this->load->helper('url');// ładne adresy url
		$this->load->model('access');
		$this->load->model('productsmodel','products');
		$this->load->model('clientsmodel','client');
		$this->load->model('loyaltymodel','loyalty');
		$this->load->model('settingsmodel','settings');
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
		$vars['js']=array("jquery-2-1-1.min.js","bootstrap.min.js","modalDialogAction.js","jquery.dataTables.min.js","dataTables.tableTools.min.js","loyalty.js","bootstrap4dataTables.js");
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
		$return=$system_message;
		if(isset($_POST))
			{
				if(isset($_GET['action']))
				{
					if($_GET['action']=="settings")
					{ 
						$return=$this->loyalty->setLoyalty($_POST);		
					}
					elseif($_GET['action']=="addReward")
					{ 				
						if ($this->form_validation->run('addReward') != FALSE)
						{ 
							$this->loyalty->addReward($_POST);
							$return=1;
						}
						else
						{
							$vars['msg']=2;
							$vars['msg_val']=validation_errors();
						}
					}
					elseif($_GET['action']=="editReward")
					{ 				
						if ($this->form_validation->run('addReward') != FALSE)
						{ 
							$this->loyalty->updateReward($_POST);
							$return=1;
						}
						else
						{
							$vars['msg']=2;
							$vars['msg_val']=validation_errors();
						}
					}
				}
					
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
		$vars['loyalty_settings']=$this->loyalty->getLoyalty();
		$vars['rewards']=$this->loyalty->getRewards();
		$vars['path']=$this->path;
		$vars['title']="System lojalościowy";
		$vars['block_rewards']=$this->load->view($this->path."loyalty/block_rewards", $vars, true);		
		$this->display($this->path."loyalty/view",$vars);
	}
	public function deleteReward()
	{	
		$this->loyalty->deleteReward($_POST['idToDel']);
		redirect(base_url($this->path."loyalty/index/1"),'refresh');
	}
		
	///////////////////////////////////////////////////////////////
	
}

?>