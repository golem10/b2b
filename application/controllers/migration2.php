<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Migration extends CI_Controller
{	
	private $path = 'site/';

	function __construct()
  	{
		parent::__construct();
		$this->load->database();
		$this->load->model('access');
		$this->load->model('clientsmodel','client');
		$this->load->model('productsmodel','products');
		$this->load->model('ordersmodel','orders');
		$this->load->model('settingsmodel','settings');
		$this->load->model('loyaltymodel','loyalty');
		$this->load->model('inquiriesmodel','inquiries');
		$this->load->model('paymentsmodel','payments');
		$this->load->library('form_validation');
		$this->load->helper('file');
		$this->load->helper('url');	/*
		$sol="";
		$pass="hf^6asnHGJ14dh^&21GF";
		
		if(isset($_POST['password']))
		{
			if(($_POST['password'] != md5($pass)) || ($_POST['login'] != "user_jkk"))
			die();
		}
		else
			die(); */
	}
	public function importClients()
	{		
		 $data = file_get_contents("php://input");
			// echo $data;
			// die();
			//$data = $_POST;
		// //	$data="test";
			// $url= $_SERVER['DOCUMENT_ROOT'].substr($_SERVER['REDIRECT_URL'],0,-23);
			
			// if ( ! write_file('./uploads/file.php', $data))
			// {
				// // echo 'Unable to write the file';
			// }
			// else
			// {
				 // //echo 'File written!';
			// }
			// if ( ! write_file($url.'/uploads/file2.php', $data))
			// {
				// // echo 'Unable to write the file';
			// }
			// else
			// {
				// // echo 'File written!';
			// }
		if($data)
		{
			$xml=$data;
	  
			$xml = str_replace('xml:space="preserve"> </adr_Adres',"/",$xml);

			$deXml = simplexml_load_string($xml);
			$deJson = json_encode($deXml);
			$xml_array = json_decode($deJson,TRUE);
			if (! empty($main_heading)) {
				$returned = $xml_array[$main_heading];
				print_r($returned);
			} else {
			print_r($xml_array);
				$return = $this->clients->importClients($xml_array);
				echo $return;
			}	
		}
		else
			echo 0;
	}
	
	public function index(){}	
	public function importPayments()
	{
		 if(isset($_POST['xml']))
		{
			$xml=$_POST['xml'];
			$xml = str_replace('xml:space="preserve"> </adr_Adres',"/",$xml);
			 $deXml = simplexml_load_string($xml);
			 $deJson = json_encode($deXml);
			 $xml_array = json_decode($deJson,TRUE);
			 if (! empty($main_heading)) {
				 $returned = $xml_array[$main_heading];
				 print_r($returned);
			 } else {
				 $return=$this->payments->importPayments($xml_array);
				echo $return;
			}	
		}
		else	
			echo 0;

	}	
		
	public function getOrdersXML($date="0000-00-00 00:00:00")
	{
		echo $this->orders->getOrdersXML($date);	
	}
	
	public function importProducts()
	{
	
// $opts = array(
  // 'http'=>array(
    // 'method'=>"POST",
    // 'header'=>"Accept-language: Pl\r\n" .
              // "Cookie: foo=bar\r\n"
  // )
// );

// $context = stream_context_create($opts);
	//$data = file_get_contents("php://input", false, $context);
	$data = file_get_contents("php://input");
			

			$url= $_SERVER['DOCUMENT_ROOT'].substr($_SERVER['REDIRECT_URL'],0,-23);
			
			if ( ! write_file('./uploads/prod_file.php', $data))
			{
				// echo 'Unable to write the file';
			}
			else
			{
				// echo 'File written!';
			}
			if ( ! write_file($url.'/uploads/prod_file2.php', $data))
			{
				// echo 'Unable to write the file';
			}
			else
			{
				// echo 'File written!';
			}
		if($data)
		{
			//$xml=iconv("ISO-8859-1","UTF-8",$data);
			//$xml=mb_convert_encoding($data,"UTF-8");
			//$xml = str_replace('xml:space="preserve"'," ",$xml);
			
//$tab = array("UTF-8", "ASCII", "Windows-1252", "ISO-8859-15", "ISO-8859-1", "ISO-8859-6", "CP1256"); 
			$xml = $data;
			$deXml = simplexml_load_string($xml);
			$deJson = json_encode($deXml);
			$xml_array = json_decode($deJson,TRUE);
			if (! empty($main_heading)) {
				$returned = $xml_array[$main_heading];
				print_r($returned);
			} else {
				$return=$this->products->importProducts($xml_array);
				echo $return;
			}	
		}
		else	
			echo "0 brak $DATA";
	}
	public function updateProducts()
	{
		$xml=$_POST['xml'];
		$deXml = simplexml_load_string($xml);
		$deJson = json_encode($deXml);
		$xml_array = json_decode($deJson,TRUE);
		if (! empty($main_heading)) {
			$returned = $xml_array[$main_heading];
			print_r($returned);
		} else {
			$this->products->updateProducts($xml_array);
		}	
		
	}
	
	public function updateClients()
	{
		$xml=$_POST['xml'];
		$deXml = simplexml_load_string($xml);
		$deJson = json_encode($deXml);
		$xml_array = json_decode($deJson,TRUE);
		if (! empty($main_heading)) {
			$returned = $xml_array[$main_heading];
			print_r($returned);
		} else {
			$this->clients->updateClients($xml_array);
		}			
	}
	
}
?>