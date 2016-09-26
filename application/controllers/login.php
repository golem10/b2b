<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller
{	
	private $path = 'site/';

	function __construct()
  	{
		parent::__construct();
                $this->load->model('clientsmodel','client');
		$this->load->model('access');
		$this->load->model('settingsmodel','settings');
		$this->load->library('form_validation');
		$this->load->helper('url');	
	}
		
	
	public function index($register=""){
		$vars=array();
		if($_POST)
			{ 
				if(isset($_POST['register']))
				{
					if ($this->form_validation->run('registerForm') != FALSE)
					{ 
					$text="<h2>Dane rejestracyjne</h2><br/>
					<h3>Nazwa firmy: ".$_POST['name']."</h3>
					<h3>NIP: ".$_POST['nip']."</h3>
					<h3>Imię i nazwisko: ".$_POST['person']."</h3>
					<h3>Nr kontaktowy: ".$_POST['phone']."</h3>
					<h3>Adres e-mail: ".$_POST['email']."</h3>
					";
					$register="success";
					$email = $this->settings->getEmail();
					
					$this->load->library('email');
					
					$this->email->from('jkk@partnerjkk.pl', 'JKK PARTER');
					$this->email->to($email); 
					$this->email->subject('Formularz rejestracyjny - JKK PARTNER');
					$this->email->message($text);	
					$this->email->send();
					
					$this->email->from('jkk@partnerjkk.pl', 'JKK PARTER');
					$this->email->to($_POST['email']); 
					$this->email->subject('Formularz rejestracyjny - JKK PARTNER');
					$this->email->message($text);	
					$this->email->send();
					redirect(base_url("login/index/register"),'refresh');
					}
					else
					{
					
					$vars['msg_val']=validation_errors('<div class="errors-msg">', '</div>');
					}
				}
				else
				{
				$login=$_POST['login'];
				$pass=$_POST['password'];
				if($this->access->logIn($login,$pass,false))
					redirect(base_url("index"),'refresh');
				else
					$vars['login_error'] =1; 
				}
			}
		
		$vars['css']=array("bootstrap.css",$this->path."login.css");
		$vars['js']=array("jquery-2-1-1.min.js","bootstrap.min.js");
		$vars['contact']=$this->access->getFooterContact();
		$vars['traders']=$this->access->getFooterTraders();
		$vars['clientsCount']=$this->client->getClientsCount();		$vars['register']=$register;		$this->load->view($this->path.'login',$vars);
	}
	
	public function out()
	{
		$this->access->logOut(true);
				redirect(base_url('login'),'refresh');
	}
	public function passwordReset()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$password = '';
		for ($i = 0; $i < 10; $i++) {
			$password .= $characters[rand(0, strlen($characters)-1)];
		}
		$return = $this->access->resetPassword($_POST['email'],$password);
		
		if($return == 1)
		{
			$this->load->library('email');		
			$this->email->from('jkk@partnerjkk.pl', 'JKK PARTER');
			$this->email->to($_POST['email']); 
			$text="<h3>Nowe hasło do platformy PARTNER JKK: ".$password."</h3>";
			$this->email->subject('Formularz rejestracyjny - JKK PARTNER');
			$this->email->message($text);	
			$this->email->send();
			redirect(base_url('login'),'refresh');
		}
		else
			redirect(base_url('login?msg=reminderError'),'refresh');
	}
	
}
?>