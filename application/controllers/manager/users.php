<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller
{	
	private $path = 'manager/';
	function __construct()
  	{
		parent::__construct();
		$this->load->helper('url');// ładne adresy url
		$this->load->model('access');
		$this->load->model('clientsmodel','clients');
		$this->load->library('form_validation');
		if(!$this->access->isLogin())
			redirect(base_url($this->path."login"), 'refresh');	
		elseif($this->session->userdata('id_profile') == 2)
			redirect(base_url($this->path), 'refresh');	
		elseif($this->session->userdata('id_profile') >= 3)
			redirect(base_url(), 'refresh');
		if($this->session->userdata('id_profile') == 2 && !$this->access->checkPermissions(2,7))
			 redirect(base_url("manager"), 'refresh');		
	}
		
	private function display($site=NULL,$vars=array())
	{	$vars['menu_permission']=$this->access->getPermissionsForMenu(2);
		$vars['css']=array($this->path."main.css","bootstrap.css",$this->path."jquery.dataTables.min.css",$this->path."dataTables.tableTools.min.css");
		$vars['js']=array("jquery-2-1-1.min.js","bootstrap.min.js","modalDialogAction.js","users.js","jquery.dataTables.min.js","dataTables.tableTools.min.js");
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
		$vars['users']=$this->access->getUsersList();
		$vars['title']="Użytkownicy";
		$this->display($this->path."users/view",$vars);
	}
	///////////////////////////////////////////////////////////////
	
	public function activeUser($id_user)
	{	$this->access->activeUser($id_user);
		redirect(base_url($this->path."users/index/1"),'refresh');
	}
	
	public function addUser()
	{	$vars=array('post'=>$_POST,'profile'=>$this->access->getProfiles(),'clients'=>$this->clients->getList(),'error'=>'');
		$vars['msg_val']="";
		$vars['title']="Dodaj użytkownika";
		$vars['def']=array(
					'mpk'=>'',
					'firstname'=>'',
					'lastname'=>'',
					'login'=>'',
					'email'=>'',
					'password'=>'',
					'profile'=>'',
					'phone_number'=>'',
					'client'=>''
			);
		if ($this->form_validation->run('addUser') != FALSE)
		{ 		
						
			if($this->access->loginExist($_POST['login'],true))
				{
					$vars['msg_val'].='Login już istnieje';
					$vars['msg']=2;
				}
			else if($this->access->emailExist($_POST['email'],true))
				{
					$vars['msg_val'].='Konto z tym adresem email już istnieje';
					$vars['msg']=2;
				}
			else{
				$user=array('id_profile'=> $_POST['profile'], 'mpk'=> $_POST['mpk'],'firstname'=>$_POST['firstname'], 'lastname'=>$_POST['lastname'], 'login'=>$_POST['login'], 'password'=>$_POST['password'], 'email'=>$_POST['email'],'id_client'=> $_POST['client']);
				$this->access->addUser($user,true);
				redirect(base_url($this->path."users/index/1"),'refresh');
					
				
			}
			
		}
		else
		{
			$vars['msg']=2;
			$vars['msg_val']=validation_errors();
		}
		
		$this->display($this->path."users/add",$vars);
	}

	public function editUser($id)
	{	
		$vars=array('post'=>$_POST,'profile'=>$this->access->getProfiles(),'clients'=>$this->clients->getList(),'error'=>'');
		$vars['title']="Edytuj użytkownika";
		$user=$this->access->getUserById($id);
		$vars['def']=array(
					'mpk'=>$user['mpk'],
					'firstname'=>$user['firstname'],
					'lastname'=>$user['lastname'],
					'login'=>$user['login'],
					'email'=>$user['email'],
					'phone_number'=>$user['phone_number'],
					'password'=>'',
					'profile'=>$user['id_profile'],
					'client'=>$user['id_client']
			);
		$vars['id_user'] = $user['id_user'];
		if ($this->form_validation->run('editUser') != FALSE)
		{
			if($this->access->loginExist($_POST['login'],true) && $_POST['login']!=$user['login'])
						{$vars['error'].='<div class="error">Login Już istnieje</div>';}
					else if($this->access->emailExist($_POST['email'],true) && $_POST['email']!=$user['email'])
						{$vars['error'].='<div class="error">Konto z tym adresem email juz istnieje</div>';}
			else{
				$user=array('id_profile'=> $_POST['profile'], 'mpk'=> $_POST['mpk'],'firstname'=>$_POST['firstname'], 'lastname'=>$_POST['lastname'], 'login'=>$_POST['login'], 'email'=>$_POST['email'],'id_client'=> $_POST['client'],'phone_number'=> $_POST['phone_number']);
				if(isset($_POST['password']))
					$user['password']=$_POST['password']; 
				else $user['password']='';	
				if(	$user['id_profile'] == 1 || $user['id_profile'] == 2)
					$user['id_client'] = 0;
				$this->access->updUser($id,$user);
				redirect(base_url($this->path."users/index/1"),'refresh');
				}
			}
		$this->display($this->path.'users/add',$vars);
	}
	public function delUser()
	{	$this->access->delUser($_POST['idToDel']);
		$vars['users']=$this->access->getUsersList();
		redirect(base_url($this->path."users/index/1"),'refresh');
	}
}

?>