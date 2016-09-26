<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	private $path = 'manager/';
	function __construct()
    {
        parent::__construct();
		$this->load->model('access');
		$this->load->helper('url');
    } 
	
	public function index()
	{
		$vars=array();
		$login = $this->input->post('login');
		$pass = $this->input->post('pass');
		
		if($login && $pass)
		{
			if($this->access->logIn($login,$pass,true))
				redirect($this->path,'refresh');
		}
		if($this->access->logIn($login,$pass,true))
				redirect($this->path,'refresh');

		$this->load->view('login/view',$vars);
	}
	
	public function out()
	{
		$this->access->logOut(true);
				redirect(base_url($this->path.'login'),'refresh');
	}
	

	
}