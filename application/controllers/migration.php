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
	public function deldblrecords(){
		// $query = $this->db->query('SELECT id_payment,id_facture,facture_code (SELECT count(*) FROM `payments` p2 where p1.facture_code = p2.facture_code group by facture_code) liczba FROM `payments` p1 having liczba > 1 limit 200');
		// $to_del = array();
		// $to_save = array();
		// foreach ($query->result() as $row)
		// {
		  
		   // if(isset($to_save[$row->id_facture]))
				// $to_del[$row->id_payment] = $row->id_payment;
		   // else
				// $to_save[$row->id_facture] = $row->id_payment;
		// }
		// echo "to del<br/>";
			// print_r($to_del);
		// echo "<br/><br/>to save<br/>";
			// print_r($to_save);
		// $this->db->where_in('id_payment', $to_del);
		// $this->db->delete('payments');
	
	}
	// public function dblrecords(){
		// $query = $this->db->query('SELECT min(id_facture) as id_f,facture_code, (SELECT count(*) FROM `payments` p2 where p1.facture_code = p2.facture_code group by facture_code) liczba FROM `payments` p1 group by facture_code, liczba having liczba > 1');
		// $to_del = array();
		// $to_save = array();
		// foreach ($query->result() as $row)
		// {	  
				// $to_del[$row->id_f] = $row->id_f;		  
		// }
		// echo "dbl<br/>";
			// print_r($to_del);
		// // echo "<br/><br/>to save<br/>";
			// // print_r($to_save);
		 // $this->db->where_in('id_facture', $to_del);
		// $this->db->delete('payments');
	
	// }
	public function getPaymentsToInvoices($id_list = 0)
	{
	$data = file_get_contents("php://input");
	//$data = "<Root><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-04-08</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>KFS 1378/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>151</nzf_IdObiektu><nzf_WartoscPierwotna>883,2</nzf_WartoscPierwotna><naleznosc>883,2</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>883,2</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-23</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1379/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>3</nzf_IdObiektu><nzf_WartoscPierwotna>242,93</nzf_WartoscPierwotna><naleznosc>242,93</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>242,93</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-23</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1381/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>3</nzf_IdObiektu><nzf_WartoscPierwotna>154,8</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>154,8</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-16</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1382/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2105</nzf_IdObiektu><nzf_WartoscPierwotna>395,54</nzf_WartoscPierwotna><naleznosc>395,54</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>395,54</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-16</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1383/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>1987</nzf_IdObiektu><nzf_WartoscPierwotna>332,54</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>332,54</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-23</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1384/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2475</nzf_IdObiektu><nzf_WartoscPierwotna>642,93</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>642,93</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-23</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1385/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>21</nzf_IdObiektu><nzf_WartoscPierwotna>78,72</nzf_WartoscPierwotna><naleznosc>78,72</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>78,72</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-30</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1386/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>1923</nzf_IdObiektu><nzf_WartoscPierwotna>38,19</nzf_WartoscPierwotna><naleznosc>38,19</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>38,19</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-16</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1387/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2285</nzf_IdObiektu><nzf_WartoscPierwotna>473,03</nzf_WartoscPierwotna><naleznosc>473,03</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>473,03</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-09</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>PA 85/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu></nzf_IdObiektu><nzf_WartoscPierwotna>24</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>24</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-23</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1388/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2706</nzf_IdObiektu><nzf_WartoscPierwotna>830,74</nzf_WartoscPierwotna><naleznosc>830,74</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>830,74</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-23</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1389/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>81</nzf_IdObiektu><nzf_WartoscPierwotna>79,83</nzf_WartoscPierwotna><naleznosc>79,83</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>79,83</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-23</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1390/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>81</nzf_IdObiektu><nzf_WartoscPierwotna>910,25</nzf_WartoscPierwotna><naleznosc>910,25</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>910,25</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-16</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1393/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2656</nzf_IdObiektu><nzf_WartoscPierwotna>138,01</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>138,01</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-16</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>KFS 1392/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2788</nzf_IdObiektu><nzf_WartoscPierwotna>55,01</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>55,01</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-16</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1394/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2789</nzf_IdObiektu><nzf_WartoscPierwotna>43</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>43</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-23</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1395/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>233</nzf_IdObiektu><nzf_WartoscPierwotna>199,65</nzf_WartoscPierwotna><naleznosc>199,65</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>199,65</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-23</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1397/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>8</nzf_IdObiektu><nzf_WartoscPierwotna>69,5</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>69,5</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-16</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1398/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2310</nzf_IdObiektu><nzf_WartoscPierwotna>218,37</nzf_WartoscPierwotna><naleznosc>218,37</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>218,37</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-23</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1399/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>254</nzf_IdObiektu><nzf_WartoscPierwotna>282,97</nzf_WartoscPierwotna><naleznosc>282,97</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>282,97</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-23</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1400/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2705</nzf_IdObiektu><nzf_WartoscPierwotna>278,96</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>278,96</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-16</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1401/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>1952</nzf_IdObiektu><nzf_WartoscPierwotna>572,45</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>572,45</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-16</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1377/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>563</nzf_IdObiektu><nzf_WartoscPierwotna>96,43</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>96,43</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-30</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1380/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>1933</nzf_IdObiektu><nzf_WartoscPierwotna>951,65</nzf_WartoscPierwotna><naleznosc>951,65</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>951,65</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-16</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1391/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>1823</nzf_IdObiektu><nzf_WartoscPierwotna>208,82</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>208,82</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-23</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1402/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>132</nzf_IdObiektu><nzf_WartoscPierwotna>196,8</nzf_WartoscPierwotna><naleznosc>196,8</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>196,8</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-04-08</nzf_TerminPlatnosci><nzf_Data>2015-03-09</nzf_Data><nzf_NumerPelny>FS 1396/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>1065</nzf_IdObiektu><nzf_WartoscPierwotna>241,26</nzf_WartoscPierwotna><naleznosc>241,26</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>241,26</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-24</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1409/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>3</nzf_IdObiektu><nzf_WartoscPierwotna>131,03</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>131,03</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-04-09</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1411/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>161</nzf_IdObiektu><nzf_WartoscPierwotna>125,95</nzf_WartoscPierwotna><naleznosc>125,95</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>125,95</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-24</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1412/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>23</nzf_IdObiektu><nzf_WartoscPierwotna>1429,88</nzf_WartoscPierwotna><naleznosc>1429,88</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>1429,88</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-17</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1413/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2517</nzf_IdObiektu><nzf_WartoscPierwotna>80,58</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>80,58</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-17</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1414/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>37</nzf_IdObiektu><nzf_WartoscPierwotna>78,57</nzf_WartoscPierwotna><naleznosc>78,57</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>78,57</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-24</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1415/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>44</nzf_IdObiektu><nzf_WartoscPierwotna>534,35</nzf_WartoscPierwotna><naleznosc>534,35</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>534,35</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-24</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1416/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>150</nzf_IdObiektu><nzf_WartoscPierwotna>234,27</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>234,27</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-24</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1419/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>257</nzf_IdObiektu><nzf_WartoscPierwotna>58,79</nzf_WartoscPierwotna><naleznosc>58,79</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>58,79</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-24</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1420/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>21</nzf_IdObiektu><nzf_WartoscPierwotna>829,88</nzf_WartoscPierwotna><naleznosc>829,88</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>829,88</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-04-09</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1410/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>1065</nzf_IdObiektu><nzf_WartoscPierwotna>1681,82</nzf_WartoscPierwotna><naleznosc>1681,82</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>1681,82</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-17</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1421/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>476</nzf_IdObiektu><nzf_WartoscPierwotna>111,82</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>111,82</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-17</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1422/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2118</nzf_IdObiektu><nzf_WartoscPierwotna>274,29</nzf_WartoscPierwotna><naleznosc>274,29</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>274,29</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-10</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>PA 86/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu></nzf_IdObiektu><nzf_WartoscPierwotna>7,53</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>7,53</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-04-09</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>941/15/u</nzf_NumerPelny><nzf_IdObiektu>1310</nzf_IdObiektu><nzf_WartoscPierwotna>25,12</nzf_WartoscPierwotna><naleznosc>25,12</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>25,12</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-04-09</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>940/15/u</nzf_NumerPelny><nzf_IdObiektu>1310</nzf_IdObiektu><nzf_WartoscPierwotna>12,99</nzf_WartoscPierwotna><naleznosc>12,99</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>12,99</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-13</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>kf/15/1593</nzf_NumerPelny><nzf_IdObiektu>1</nzf_IdObiektu><nzf_WartoscPierwotna>52,86</nzf_WartoscPierwotna><naleznosc>52,86</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>52,86</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-04-09</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>939/15/u</nzf_NumerPelny><nzf_IdObiektu>1310</nzf_IdObiektu><nzf_WartoscPierwotna>76,07</nzf_WartoscPierwotna><naleznosc>76,07</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>76,07</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-24</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1418/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>818</nzf_IdObiektu><nzf_WartoscPierwotna>83,91</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>83,91</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-10</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>PA 87/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu></nzf_IdObiektu><nzf_WartoscPierwotna>410</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>410</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-17</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1406/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2524</nzf_IdObiektu><nzf_WartoscPierwotna>33,23</nzf_WartoscPierwotna><naleznosc>33,23</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>33,23</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-13</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>kf/15/1635</nzf_NumerPelny><nzf_IdObiektu>1</nzf_IdObiektu><nzf_WartoscPierwotna>33,7</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>33,7</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-24</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1403/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2706</nzf_IdObiektu><nzf_WartoscPierwotna>238,32</nzf_WartoscPierwotna><naleznosc>238,32</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>238,32</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-24</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1408/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>741</nzf_IdObiektu><nzf_WartoscPierwotna>240,22</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>240,22</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-24</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1404/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>962</nzf_IdObiektu><nzf_WartoscPierwotna>1206,09</nzf_WartoscPierwotna><naleznosc>1206,09</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>1206,09</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-17</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1405/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>1865</nzf_IdObiektu><nzf_WartoscPierwotna>286,09</nzf_WartoscPierwotna><naleznosc>286,09</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>286,09</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-24</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1407/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>459</nzf_IdObiektu><nzf_WartoscPierwotna>91,02</nzf_WartoscPierwotna><naleznosc>91,02</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>91,02</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-17</nzf_TerminPlatnosci><nzf_Data>2015-03-10</nzf_Data><nzf_NumerPelny>FS 1417/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>1348</nzf_IdObiektu><nzf_WartoscPierwotna>67,53</nzf_WartoscPierwotna><naleznosc>67,53</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>67,53</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-18</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1442/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>1962</nzf_IdObiektu><nzf_WartoscPierwotna>671,46</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>671,46</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-25</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1464/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>23</nzf_IdObiektu><nzf_WartoscPierwotna>446,29</nzf_WartoscPierwotna><naleznosc>446,29</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>446,29</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-18</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1426/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>1912</nzf_IdObiektu><nzf_WartoscPierwotna>273,88</nzf_WartoscPierwotna><naleznosc>273,88</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>273,88</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-25</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1428/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2140</nzf_IdObiektu><nzf_WartoscPierwotna>242,93</nzf_WartoscPierwotna><naleznosc>242,93</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>242,93</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-18</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1429/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>1902</nzf_IdObiektu><nzf_WartoscPierwotna>560,74</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>560,74</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-18</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1433/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2524</nzf_IdObiektu><nzf_WartoscPierwotna>271</nzf_WartoscPierwotna><naleznosc>271</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>271</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-18</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1436/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>486</nzf_IdObiektu><nzf_WartoscPierwotna>11,07</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>11,07</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-04-10</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1443/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>508</nzf_IdObiektu><nzf_WartoscPierwotna>689</nzf_WartoscPierwotna><naleznosc>689</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>689</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-25</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1453/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>1098</nzf_IdObiektu><nzf_WartoscPierwotna>69,99</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>69,99</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-18</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1425/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2630</nzf_IdObiektu><nzf_WartoscPierwotna>127,29</nzf_WartoscPierwotna><naleznosc>127,29</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>127,29</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-25</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1427/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>514</nzf_IdObiektu><nzf_WartoscPierwotna>39,63</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>39,63</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-04-01</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1430/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2143</nzf_IdObiektu><nzf_WartoscPierwotna>309,98</nzf_WartoscPierwotna><naleznosc>309,98</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>309,98</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-25</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1431/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>528</nzf_IdObiektu><nzf_WartoscPierwotna>95,17</nzf_WartoscPierwotna><naleznosc>95,17</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>95,17</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-18</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1432/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>1035</nzf_IdObiektu><nzf_WartoscPierwotna>289,74</nzf_WartoscPierwotna><naleznosc>289,74</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>289,74</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-25</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1434/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>2452</nzf_IdObiektu><nzf_WartoscPierwotna>134,84</nzf_WartoscPierwotna><naleznosc>134,84</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>134,84</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-25</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1435/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>461</nzf_IdObiektu><nzf_WartoscPierwotna>97,58</nzf_WartoscPierwotna><naleznosc>97,58</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>97,58</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-18</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1437/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>304</nzf_IdObiektu><nzf_WartoscPierwotna>106,14</nzf_WartoscPierwotna><naleznosc>106,14</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>106,14</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-25</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1438/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>153</nzf_IdObiektu><nzf_WartoscPierwotna>386,64</nzf_WartoscPierwotna><naleznosc>386,64</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>386,64</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-25</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1439/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>1102</nzf_IdObiektu><nzf_WartoscPierwotna>41,84</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>41,84</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-25</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1440/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>43</nzf_IdObiektu><nzf_WartoscPierwotna>1044,27</nzf_WartoscPierwotna><naleznosc>1044,27</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>1044,27</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-18</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1441/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>561</nzf_IdObiektu><nzf_WartoscPierwotna>405,29</nzf_WartoscPierwotna><naleznosc>0</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>405,29</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-25</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1444/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>43</nzf_IdObiektu><nzf_WartoscPierwotna>1070,1</nzf_WartoscPierwotna><naleznosc>1070,1</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>1070,1</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-04-10</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1446/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>4</nzf_IdObiektu><nzf_WartoscPierwotna>193,39</nzf_WartoscPierwotna><naleznosc>193,39</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>193,39</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-04-10</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1447/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>4</nzf_IdObiektu><nzf_WartoscPierwotna>125,23</nzf_WartoscPierwotna><naleznosc>125,23</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>125,23</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-04-10</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1448/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>4</nzf_IdObiektu><nzf_WartoscPierwotna>597,78</nzf_WartoscPierwotna><naleznosc>597,78</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>597,78</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-03-25</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1449/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>890</nzf_IdObiektu><nzf_WartoscPierwotna>340,54</nzf_WartoscPierwotna><naleznosc>340,54</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>340,54</nalPierwotna><zobPierwotna></zobPierwotna></Payments><Payments><dok_DoDokId>11</dok_DoDokId><nzf_TerminPlatnosci>2015-04-10</nzf_TerminPlatnosci><nzf_Data>2015-03-11</nzf_Data><nzf_NumerPelny>FS 1450/JKK/03/2015</nzf_NumerPelny><nzf_IdObiektu>151</nzf_IdObiektu><nzf_WartoscPierwotna>713,4</nzf_WartoscPierwotna><naleznosc>713,4</naleznosc><zobowiazanie></zobowiazanie><nalPierwotna>713,4</nalPierwotna><zobPierwotna></zobPierwotna></Payments></Root>";
			if ( ! write_file('./uploads/subiect_payments_invoices.php', $data))
			 {
			//	 echo 'Unable to write the file';
			}
			 else
			 {
			//	 echo 'File written!';
			 }
			if($data)
			{
				$xml = preg_replace('/&[^; ]{0,6}.?/e', "((substr('\\0',-1) == ';') ? '\\0' : '&amp;'.substr('\\0',1))", $data);
				$xml = preg_replace('/&[^; ]{0,6}.?/e', "((substr('\\0',-1) == ';') ? '\\0' : '&amp;'.substr('\\0',1))", $xml);
				//$xml = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $xml);
				$xml = str_replace('> </',"></",$xml);
				if(!$id_list)
					$id_list = $this->checkImportExist(2,3);
				$deXml = simplexml_load_string($xml);
				$deJson = json_encode($deXml);
				$xml_array = json_decode($deJson,TRUE);
				if (! empty($main_heading)) {
					$returned = $xml_array[$main_heading];
					print_r($returned);
				} else {
					$return = $this->payments->setPaymentsToInvoices($xml_array,$id_list);
					echo $return;
				}	
			}
			else
				echo 0;
			
	}
	public function	subiektNumberOrders()
	{
			$data = file_get_contents("php://input");

			if ( ! write_file('./uploads/subiect_nmbs_file.php', $data))
			 {
			//echo 'Unable to write the file';
			}
			 else
			 {
				// echo 'File written!';
			 }
			if($data)
			{
				$xml = preg_replace('/&[^; ]{0,6}.?/e', "((substr('\\0',-1) == ';') ? '\\0' : '&amp;'.substr('\\0',1))", $data);
				$xml = preg_replace('/&[^; ]{0,6}.?/e', "((substr('\\0',-1) == ';') ? '\\0' : '&amp;'.substr('\\0',1))", $xml);
				//$xml = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $xml);
				$xml = str_replace('> </',"></",$xml);
				
				$deXml = simplexml_load_string($xml);
				$deJson = json_encode($deXml);
				$xml_array = json_decode($deJson,TRUE);
				if (! empty($main_heading)) {
					$returned = $xml_array[$main_heading];
				} else {
					$return = $this->orders->setOrderNbr($xml_array);
					echo $return;
				}	
			}
			else
				echo 0;
	}

	public function importClients($id_list = 0)
	{		
		$data = file_get_contents("php://input");
	//	$data = "<Root><Results_from_Query_x003A__Customers><kh_Id>1654</kh_Id><kh_Symbol>PREMONT</kh_Symbol><kh_REGON></kh_REGON><kh_PESEL></kh_PESEL><kh_WWW></kh_WWW><kh_EMail></kh_EMail><kh_Imie></kh_Imie><kh_Nazwisko></kh_Nazwisko><adr_Nazwa>PREMONT Sp. z o.o.</adr_Nazwa><adr_NazwaPelna>PREMONT Sp.z o.o.</adr_NazwaPelna><adr_Telefon>692448402</adr_Telefon><adr_Faks></adr_Faks><adr_Ulica>11 Listopada</adr_Ulica><adr_NrDomu>30</adr_NrDomu><adr_NrLokalu></adr_NrLokalu><adr_Adres>11 Listopada 30</adr_Adres><adr_Kod>40-387</adr_Kod><adr_Miejscowosc>Katowice</adr_Miejscowosc><adr_NIP>634-24-47-115</adr_NIP></Results_from_Query_x003A__Customers></Root>";
			// $url= $_SERVER['DOCUMENT_ROOT'].substr($_SERVER['REDIRECT_URL'],0,-23);
			
			
			// if ( ! write_file($url.'/uploads/file2.php', $data))
			// {
				// // echo 'Unable to write the file';
			// }
			// else
			// {
				// // echo 'File written!';
			// }
			//echo $data;
			if ( ! write_file('./uploads/c_1_file.php', $data))
			 {
				// echo 'Unable to write the file';
			}
			 else
			 {
				// echo 'File written!';
			 }
		if($data)
		{	
			$xml = preg_replace('/&[^; ]{0,6}.?/e', "((substr('\\0',-1) == ';') ? '\\0' : '&amp;'.substr('\\0',1))", $data);
			$xml = preg_replace('/&[^; ]{0,6}.?/e', "((substr('\\0',-1) == ';') ? '\\0' : '&amp;'.substr('\\0',1))", $xml);
			//$xml = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $xml);
			$xml = str_replace('xml:space="preserve"> </adr_Adres',"/",$xml);
			$xml = str_replace('> </',"></",$xml);

			if ( ! write_file('./uploads/c_file.php', $xml))
			 {
			//	 echo 'Unable to write the file';
			}
			 else
			 {
				// echo 'File written!';
			 }
			 if($id_list)
				$this->updateImportList($id_list);
			else
				{
				$id_list = $this->checkImportExist(2,1);
				if(!$id_list)
					$id_list = $this->insertImportList(2,1,$id_list);			
				}
			$deXml = simplexml_load_string($xml);
			$deJson = json_encode($deXml);
			$xml_array = json_decode($deJson,TRUE);
			
			if (! empty($main_heading)) {
				$returned = $xml_array[$main_heading];
			} else {		
				$return = $this->clients->importClients($xml_array,$id_list);
				echo $return;
			}	
		}
		else
			echo 0;

		
	}
	
	public function index(){}	
	public function importPayments($id_list = 0)
	{
		$data = file_get_contents("php://input");
		//$data = file_get_contents("uploads/faktury_1_file.php");
			// $url= $_SERVER['DOCUMENT_ROOT'].substr($_SERVER['REDIRECT_URL'],0,-23);
			
			
			// if ( ! write_file($url.'/uploads/file2.php', $data))
			// {
				// // echo 'Unable to write the file';
			// }
			// else
			// {
				// // echo 'File written!';
			// }
			//echo $data;
			// if ( ! write_file('./uploads/faktury_1_file.php', $data))
			 // {
			// //	 echo 'Unable to write the file';
			// }
			 // else
			 // {
			// //	 echo 'File written!';
			 // }
		if($data)
		{
			$xml = preg_replace('/&[^; ]{0,6}.?/e', "((substr('\\0',-1) == ';') ? '\\0' : '&amp;'.substr('\\0',1))", $data);
			$xml = preg_replace('/&[^; ]{0,6}.?/e', "((substr('\\0',-1) == ';') ? '\\0' : '&amp;'.substr('\\0',1))", $xml);
			if($id_list)
				$this->updateImportList($id_list);
			else
				$id_list = $this->insertImportList(2,3);
			
			 $deXml = simplexml_load_string($xml);
			 $deJson = json_encode($deXml);
			 $xml_array = json_decode($deJson,TRUE);
			 if (! empty($main_heading)) {
				 $returned = $xml_array[$main_heading];
				 print_r($returned);
			 } else {
				 $return=$this->payments->importPayments($xml_array,$id_list);
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
	
	public function importProducts($id_list = 0)
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
	//$data = "<Root><Results_from_Query_x003A__Products><tw_Id>15158</tw_Id><tw_Rodzaj>1</tw_Rodzaj><tw_Symbol>KF01547</tw_Symbol><tw_Nazwa>Grafity 1231 0,5 HB Q-Connect</tw_Nazwa><tw_Opis></tw_Opis><VAT>23</VAT><tw_JednMiary>szt.</tw_JednMiary><tw_IdGrupa>3</tw_IdGrupa><tw_Uwagi></tw_Uwagi><NazwaGrupy>Artykuły do pisania i korygowania</NazwaGrupy><tc_Id>15158</tc_Id><tc_IdTowar>15158</tc_IdTowar><tc_CenaNetto0>0,37</tc_CenaNetto0><tc_CenaBrutto0>0</tc_CenaBrutto0><tc_CenaNetto1>0,49</tc_CenaNetto1><tc_CenaNetto2>0,43</tc_CenaNetto2><tc_CenaNetto3>0,41</tc_CenaNetto3><tc_CenaNetto4>0</tc_CenaNetto4><tc_CenaNetto5>0</tc_CenaNetto5><tc_CenaNetto6>0</tc_CenaNetto6><tc_CenaNetto7>0</tc_CenaNetto7><tc_CenaNetto8>0</tc_CenaNetto8><tc_CenaNetto9>0</tc_CenaNetto9><tc_CenaNetto10>0</tc_CenaNetto10><tc_CenaBrutto1>0,6</tc_CenaBrutto1><tc_CenaBrutto2>0,53</tc_CenaBrutto2><tc_CenaBrutto3>0,5</tc_CenaBrutto3><tc_CenaBrutto4>0</tc_CenaBrutto4><tc_CenaBrutto5>0</tc_CenaBrutto5><tc_CenaBrutto6>0</tc_CenaBrutto6><tc_CenaBrutto7>0</tc_CenaBrutto7><tc_CenaBrutto8>0</tc_CenaBrutto8><tc_CenaBrutto9>0</tc_CenaBrutto9><tc_CenaBrutto10>0</tc_CenaBrutto10></Results_from_Query_x003A__Products><Results_from_Query_x003A__Products><tw_Id>17856</tw_Id><tw_Rodzaj>1</tw_Rodzaj><tw_Symbol>101112</tw_Symbol><tw_Nazwa>Marker Perman 2160 leviatan czerwony</tw_Nazwa><tw_Opis></tw_Opis><VAT>23</VAT><tw_JednMiary>szt.</tw_JednMiary><tw_IdGrupa>1</tw_IdGrupa><tw_Uwagi></tw_Uwagi><NazwaGrupy>Podstawowa</NazwaGrupy><tc_Id>17856</tc_Id><tc_IdTowar>17856</tc_IdTowar><tc_CenaNetto0>0,48</tc_CenaNetto0><tc_CenaBrutto0>0</tc_CenaBrutto0><tc_CenaNetto1>0,75</tc_CenaNetto1><tc_CenaNetto2>0,55</tc_CenaNetto2><tc_CenaNetto3>0,53</tc_CenaNetto3><tc_CenaNetto4>0</tc_CenaNetto4><tc_CenaNetto5>0</tc_CenaNetto5><tc_CenaNetto6>0</tc_CenaNetto6><tc_CenaNetto7>0</tc_CenaNetto7><tc_CenaNetto8>0</tc_CenaNetto8><tc_CenaNetto9>0</tc_CenaNetto9><tc_CenaNetto10>0</tc_CenaNetto10><tc_CenaBrutto1>0,92</tc_CenaBrutto1><tc_CenaBrutto2>0,68</tc_CenaBrutto2><tc_CenaBrutto3>0,65</tc_CenaBrutto3><tc_CenaBrutto4>0</tc_CenaBrutto4><tc_CenaBrutto5>0</tc_CenaBrutto5><tc_CenaBrutto6>0</tc_CenaBrutto6><tc_CenaBrutto7>0</tc_CenaBrutto7><tc_CenaBrutto8>0</tc_CenaBrutto8><tc_CenaBrutto9>0</tc_CenaBrutto9><tc_CenaBrutto10>0</tc_CenaBrutto10></Results_from_Query_x003A__Products><Results_from_Query_x003A__Products><tw_Id>17875</tw_Id><tw_Rodzaj>1</tw_Rodzaj><tw_Symbol>H-91-3</tw_Symbol><tw_Nazwa>Druk rejestracja mycia</tw_Nazwa><tw_Opis></tw_Opis><VAT>23</VAT><tw_JednMiary>szt.</tw_JednMiary><tw_IdGrupa>1</tw_IdGrupa><tw_Uwagi></tw_Uwagi><NazwaGrupy>Podstawowa</NazwaGrupy><tc_Id>17875</tc_Id><tc_IdTowar>17875</tc_IdTowar><tc_CenaNetto0>1,47</tc_CenaNetto0><tc_CenaBrutto0>0</tc_CenaBrutto0><tc_CenaNetto1>2,83</tc_CenaNetto1><tc_CenaNetto2>1,69</tc_CenaNetto2><tc_CenaNetto3>1,62</tc_CenaNetto3><tc_CenaNetto4>0</tc_CenaNetto4><tc_CenaNetto5>0</tc_CenaNetto5><tc_CenaNetto6>0</tc_CenaNetto6><tc_CenaNetto7>0</tc_CenaNetto7><tc_CenaNetto8>0</tc_CenaNetto8><tc_CenaNetto9>0</tc_CenaNetto9><tc_CenaNetto10>0</tc_CenaNetto10><tc_CenaBrutto1>3,48</tc_CenaBrutto1><tc_CenaBrutto2>2,08</tc_CenaBrutto2><tc_CenaBrutto3>1,99</tc_CenaBrutto3><tc_CenaBrutto4>0</tc_CenaBrutto4><tc_CenaBrutto5>0</tc_CenaBrutto5><tc_CenaBrutto6>0</tc_CenaBrutto6><tc_CenaBrutto7>0</tc_CenaBrutto7><tc_CenaBrutto8>0</tc_CenaBrutto8><tc_CenaBrutto9>0</tc_CenaBrutto9><tc_CenaBrutto10>0</tc_CenaBrutto10></Results_from_Query_x003A__Products><Results_from_Query_x003A__Products><tw_Id>17876</tw_Id><tw_Rodzaj>1</tw_Rodzaj><tw_Symbol>21101111-07</tw_Symbol><tw_Nazwa>Skoroszyt PP pomarańczowy Office Product a'25</tw_Nazwa><tw_Opis></tw_Opis><VAT>23</VAT><tw_JednMiary>szt.</tw_JednMiary><tw_IdGrupa>1</tw_IdGrupa><tw_Uwagi></tw_Uwagi><NazwaGrupy>Podstawowa</NazwaGrupy><tc_Id>17876</tc_Id><tc_IdTowar>17876</tc_IdTowar><tc_CenaNetto0>0,28</tc_CenaNetto0><tc_CenaBrutto0>0</tc_CenaBrutto0><tc_CenaNetto1>0,41</tc_CenaNetto1><tc_CenaNetto2>0,32</tc_CenaNetto2><tc_CenaNetto3>0,31</tc_CenaNetto3><tc_CenaNetto4>0</tc_CenaNetto4><tc_CenaNetto5>0</tc_CenaNetto5><tc_CenaNetto6>0</tc_CenaNetto6><tc_CenaNetto7>0</tc_CenaNetto7><tc_CenaNetto8>0</tc_CenaNetto8><tc_CenaNetto9>0</tc_CenaNetto9><tc_CenaNetto10>0</tc_CenaNetto10><tc_CenaBrutto1>0,5</tc_CenaBrutto1><tc_CenaBrutto2>0,39</tc_CenaBrutto2><tc_CenaBrutto3>0,38</tc_CenaBrutto3><tc_CenaBrutto4>0</tc_CenaBrutto4><tc_CenaBrutto5>0</tc_CenaBrutto5><tc_CenaBrutto6>0</tc_CenaBrutto6><tc_CenaBrutto7>0</tc_CenaBrutto7><tc_CenaBrutto8>0</tc_CenaBrutto8><tc_CenaBrutto9>0</tc_CenaBrutto9><tc_CenaBrutto10>0</tc_CenaBrutto10></Results_from_Query_x003A__Products><Results_from_Query_x003A__Products><tw_Id>17877</tw_Id><tw_Rodzaj>1</tw_Rodzaj><tw_Symbol>21101111-10</tw_Symbol><tw_Nazwa>Skoroszyt PP szary Office Product a'25</tw_Nazwa><tw_Opis></tw_Opis><VAT>23</VAT><tw_JednMiary>szt.</tw_JednMiary><tw_IdGrupa>1</tw_IdGrupa><tw_Uwagi></tw_Uwagi><NazwaGrupy>Podstawowa</NazwaGrupy><tc_Id>17877</tc_Id><tc_IdTowar>17877</tc_IdTowar><tc_CenaNetto0>0,28</tc_CenaNetto0><tc_CenaBrutto0>0</tc_CenaBrutto0><tc_CenaNetto1>0,41</tc_CenaNetto1><tc_CenaNetto2>0,32</tc_CenaNetto2><tc_CenaNetto3>0,31</tc_CenaNetto3><tc_CenaNetto4>0</tc_CenaNetto4><tc_CenaNetto5>0</tc_CenaNetto5><tc_CenaNetto6>0</tc_CenaNetto6><tc_CenaNetto7>0</tc_CenaNetto7><tc_CenaNetto8>0</tc_CenaNetto8><tc_CenaNetto9>0</tc_CenaNetto9><tc_CenaNetto10>0</tc_CenaNetto10><tc_CenaBrutto1>0,5</tc_CenaBrutto1><tc_CenaBrutto2>0,39</tc_CenaBrutto2><tc_CenaBrutto3>0,38</tc_CenaBrutto3><tc_CenaBrutto4>0</tc_CenaBrutto4><tc_CenaBrutto5>0</tc_CenaBrutto5><tc_CenaBrutto6>0</tc_CenaBrutto6><tc_CenaBrutto7>0</tc_CenaBrutto7><tc_CenaBrutto8>0</tc_CenaBrutto8><tc_CenaBrutto9>0</tc_CenaBrutto9><tc_CenaBrutto10>0</tc_CenaBrutto10></Results_from_Query_x003A__Products><Results_from_Query_x003A__Products><tw_Id>17878</tw_Id><tw_Rodzaj>1</tw_Rodzaj><tw_Symbol>530653</tw_Symbol><tw_Nazwa>Taśma 3D 9mmx3m do wytłaczarek S0720150 mix A3</tw_Nazwa><tw_Opis></tw_Opis><VAT>23</VAT><tw_JednMiary>op.</tw_JednMiary><tw_IdGrupa>1</tw_IdGrupa><tw_Uwagi></tw_Uwagi><NazwaGrupy>Podstawowa</NazwaGrupy><tc_Id>17878</tc_Id><tc_IdTowar>17878</tc_IdTowar><tc_CenaNetto0>16,66</tc_CenaNetto0><tc_CenaBrutto0>0</tc_CenaBrutto0><tc_CenaNetto1>26,03</tc_CenaNetto1><tc_CenaNetto2>19,16</tc_CenaNetto2><tc_CenaNetto3>18,33</tc_CenaNetto3><tc_CenaNetto4>0</tc_CenaNetto4><tc_CenaNetto5>0</tc_CenaNetto5><tc_CenaNetto6>0</tc_CenaNetto6><tc_CenaNetto7>0</tc_CenaNetto7><tc_CenaNetto8>0</tc_CenaNetto8><tc_CenaNetto9>0</tc_CenaNetto9><tc_CenaNetto10>0</tc_CenaNetto10><tc_CenaBrutto1>32,02</tc_CenaBrutto1><tc_CenaBrutto2>23,57</tc_CenaBrutto2><tc_CenaBrutto3>22,55</tc_CenaBrutto3><tc_CenaBrutto4>0</tc_CenaBrutto4><tc_CenaBrutto5>0</tc_CenaBrutto5><tc_CenaBrutto6>0</tc_CenaBrutto6><tc_CenaBrutto7>0</tc_CenaBrutto7><tc_CenaBrutto8>0</tc_CenaBrutto8><tc_CenaBrutto9>0</tc_CenaBrutto9><tc_CenaBrutto10>0</tc_CenaBrutto10></Results_from_Query_x003A__Products><Results_from_Query_x003A__Products><tw_Id>17879</tw_Id><tw_Rodzaj>1</tw_Rodzaj><tw_Symbol>728 PRINTER</tw_Symbol><tw_Nazwa>Toner Canon MF4450 728 Printe</tw_Nazwa><tw_Opis></tw_Opis><VAT>23</VAT><tw_JednMiary>szt.</tw_JednMiary><tw_IdGrupa>1</tw_IdGrupa><tw_Uwagi></tw_Uwagi><NazwaGrupy>Podstawowa</NazwaGrupy><tc_Id>17879</tc_Id><tc_IdTowar>17879</tc_IdTowar><tc_CenaNetto0>36,75</tc_CenaNetto0><tc_CenaBrutto0>0</tc_CenaBrutto0><tc_CenaNetto1>57,42</tc_CenaNetto1><tc_CenaNetto2>42,26</tc_CenaNetto2><tc_CenaNetto3>40,43</tc_CenaNetto3><tc_CenaNetto4>0</tc_CenaNetto4><tc_CenaNetto5>0</tc_CenaNetto5><tc_CenaNetto6>0</tc_CenaNetto6><tc_CenaNetto7>0</tc_CenaNetto7><tc_CenaNetto8>0</tc_CenaNetto8><tc_CenaNetto9>0</tc_CenaNetto9><tc_CenaNetto10>0</tc_CenaNetto10><tc_CenaBrutto1>70,63</tc_CenaBrutto1><tc_CenaBrutto2>51,98</tc_CenaBrutto2><tc_CenaBrutto3>49,73</tc_CenaBrutto3><tc_CenaBrutto4>0</tc_CenaBrutto4><tc_CenaBrutto5>0</tc_CenaBrutto5><tc_CenaBrutto6>0</tc_CenaBrutto6><tc_CenaBrutto7>0</tc_CenaBrutto7><tc_CenaBrutto8>0</tc_CenaBrutto8><tc_CenaBrutto9>0</tc_CenaBrutto9><tc_CenaBrutto10>0</tc_CenaBrutto10></Results_from_Query_x003A__Products></Root>";
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
			$xml = preg_replace('/&[^; ]{0,6}.?/e', "((substr('\\0',-1) == ';') ? '\\0' : '&amp;'.substr('\\0',1))", $data);
			$xml = preg_replace('/&[^; ]{0,6}.?/e', "((substr('\\0',-1) == ';') ? '\\0' : '&amp;'.substr('\\0',1))", $xml);
			if($id_list)
				$this->updateImportList($id_list);
			else
				$id_list = $this->insertImportList(2,2,$id_list);
				
			$deXml = simplexml_load_string($xml);
			$deJson = json_encode($deXml);
			$xml_array = json_decode($deJson,TRUE);
			if (! empty($main_heading)) {
				$returned = $xml_array[$main_heading];
				print_r($returned);
			} else {
				$return=$this->products->importProducts($xml_array,$id_list);
				echo $return;
			}	
		}
		else	
			echo "0 brak $DATA";
			
		
	}
	public function checkImportExist($type=0,$source=0){
		$this->db->select('id_import');
		$this->db->from('import_list');
		$this->db->where('type ='.$type.' and source = '.$source." and time_end > DATE_ADD(NOW(), INTERVAL -20 minute)");
	
		foreach($this->db->get()->result() as $item)
		{
			return $item->id_import;
		}
		return 0;
	}
	public function insertImportList($type = 1,$source = 1,$id_list = 0){
		//$this->db->query("DELETE FROM `import_list` il WHERE (select count(*) from import_payments where id_list = il.id_import) = 0 and (select count(*) from import_payments_true where id_import = il.id_import) = 0 and (select count(*) from import_corrections where id_list = il.id_import) = 0 and il.source = 3 and type = 2");
		$data['source']=$source;
		$data['type']=$type;
		$data['time_start']=date("Y-m-d H:i:s");
		if($type == 2)
			{
			//$data['time_start']="0000-00-00 00:00:00";
			$data['time_end']=date("Y-m-d H:i:s");
			$data['type']=2;
			}
		
		$this->db->insert('import_list',$data);	
		return $this->db->insert_id();
	}
	public function updateImportList($id_list){
		$data['time_end']=date("Y-m-d H:i:s");
		$this->db->where('id_import', $id_list);
		$this->db->update('import_list',$data);	
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