<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Index extends CI_Controller
{	
	private $path = 'manager/';

	function __construct()
  	{
		parent::__construct();
		$this->load->model('access');
		$this->load->library('form_validation');
		$this->load->helper('url');
		if(!$this->access->isLogIn())
			redirect(base_url($this->path."login"), 'refresh');	
		elseif($this->session->userdata('id_profile') >= 3)
			redirect(base_url(), 'refresh');
	}
		
	private function display($site=NULL,$vars=array())
	{	
		$vars['css']=array($this->path."main.css","bootstrap.css");
		$vars['js']=array("jquery-2-1-1.min.js","bootstrap.min.js");
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
		$vars=array();
		$this->display($this->path."index",$vars);
	}
	
	
}
?>