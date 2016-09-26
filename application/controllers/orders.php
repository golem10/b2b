<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Orders extends CI_Controller
{	
	private $path = 'site/';

	function __construct()
  	{
		parent::__construct();
		$this->load->model('access');
		$this->load->model('clientsmodel','client');
		$this->load->model('contractsmodel','contracts');
		$this->load->model('productsmodel','products');
		$this->load->model('ordersmodel','orders');
		$this->load->model('settingsmodel','settings');
		$this->load->model('loyaltymodel','loyalty');
		$this->load->model('inquiriesmodel','inquiries');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('email');
		$this->load->helper('url');	
		if(!$this->access->isLogIn())
			redirect(base_url("login"),'refresh');
		elseif($this->session->userdata('id_profile') < 3)
			redirect(base_url("login"), 'refresh');
	}
		
	private function display($site=NULL,$vars=array())
	{	
		$vars['loyalty_points']=$this->loyalty->getLoyaltyPointsForClient($this->session->userdata('id_client'));
		$vars['css']=array("bootstrap.css",$this->path."main.css","jquery-ui.css");
		$vars['js']=array("jquery-2-1-1.min.js","jquery-ui.js","bootstrap.min.js","general.js","modalDialogAction.js","orders.js");
		$vars['path']=$this->path;
		$vars['contact']=$this->access->getFooterContact();
		$vars['traders']=$this->access->getFooterTraders();
		$vars['to_pay']=$this->payments->sumPaymentsToPay($this->session->userdata('id_client'));
		$this->load->view($this->path.'header',$vars);
		if($site!=NULL)
			$this->load->view($site,$vars);
		$this->load->view($this->path.'footer',$vars);
	}
	
	public function index()
	{ 	
			$vars['sum_cart']=$this->orders->sumCartByUser($this->session->userdata('id_user'));			
			$vars['favorite_list']=$this->products->getFavoriteList($this->session->userdata('id_user'));
			$vars['client']=$this->client->getById($this->session->userdata('id_client'));
			$vars['adviser']=$this->access->getUserByIdShort($vars['client']['id_user_system']);
			$vars['path']=$this->path;
			$vars['breadcrumbs']=$this->load->view($this->path."breadcrumbs", $vars, true);	
			
			$vars['id_user']=$this->session->userdata('id_user');
			$vars['orders2']=$this->orders->getOrdersByStatusSite($this->session->userdata('id_client'),2,$this->session->userdata('id_profile'));
			$vars['orders2_products']=$this->orders->getProductsToOrders($vars['orders2']);
			$vars['orders3']=$this->orders->getOrdersByStatusSite($this->session->userdata('id_client'),3,$this->session->userdata('id_profile'));
			$vars['orders3_products']=$this->orders->getProductsToOrders($vars['orders3']);
			$vars['orders99']=$this->orders->getOrdersByStatusSite($this->session->userdata('id_client'),99,$this->session->userdata('id_profile'));
			$vars['orders99_products']=$this->orders->getProductsToOrders($vars['orders99']);
			$vars['carts_canceled']=$this->orders->getCartsOrderCanceled($this->session->userdata('id_client'),$this->session->userdata('id_profile'));	
			$vars['cart_products_canceled']=$this->orders->getCartProductsToAccept($vars['carts_canceled']);	
			$vars['carts']=$this->orders->getCartsOrderSite($this->session->userdata('id_client'),$this->session->userdata('id_profile'));	
			$vars['contracts']=$this->contracts->getByStatus(1,$this->session->userdata('id_client'));	
			$vars['cart_products']=$this->orders->getCartProductsToAccept($vars['carts']);	
			$this->display($this->path."orders_to_accept",$vars);
		
	}
	
	public function summary($id_contract=0)
	{ 	if($this->session->userdata('id_profile') != 4)
			redirect(base_url('orders/'),'refresh');	
			
			$id_cart=$_GET['id_cart'];
			$vars['sum_cart']=$this->orders->sumCartByUser($this->session->userdata('id_user'));			
			$vars['favorite_list']=$this->products->getFavoriteList($this->session->userdata('id_user'));
			$vars['client']=$this->client->getById($this->session->userdata('id_client'));
			$vars['adviser']=$this->access->getUserByIdShort($vars['client']['id_user_system']);
			$vars['path']=$this->path;
			$vars['statuses']=$this->products->getStatusList();
			$vars['breadcrumbs']=$this->load->view($this->path."breadcrumbs", $vars, true);		
			//$carts=$this->orders->getCartsOrder($this->session->userdata('id_client'));
			$carts=$this->orders->getCartOrder($id_cart);
			if(count($carts) == 0)
				redirect(base_url('orders'),'refresh');	
			$vars['settigs_loyalty']=$this->settings->getLoyalty();
			$contracts_products=$this->contracts->getProductsList($id_contract);			
			$vars['cart_products']=$this->orders->getSummaryProductsToOrder($carts,$contracts_products,$vars['settigs_loyalty'],$this->session->userdata('id_client'));			
			
			
			if(isset($_POST['delivery_date']))
				{
					$r=$this->orders->acceptOrder($carts,$_POST,$this->session->userdata('id_client'),$this->session->userdata('id_user'),	$vars['settigs_loyalty'],$contracts_products);
					$order_text=$r[0];
					$user=$this->access->getUserById($this->session->userdata('id_user'));
					$email[0]=$user['email'];					
					$client_t=$this->client->getById($this->session->userdata('id_client'));
					$user=$this->access->getUserById($client_t['id_user_system']);
					$email[1]=$user['email'];
					$email[2]='jkk@partnerjkk.pl';
					$l=2;
					$temp=explode(",",$client_t['accpeted_orders_emails']);
						foreach($temp as $k=>$v)
						{
							$l++;
							$email[$l]=$v;
						}
									
					//$email[2]=$client_t['email'];
					
					if($r[1]['val']!=3)
						$info_text = "<h3 style='color:#900'>".$r[1]['txt']."</h3>";
					else
						$info_text = "";
					$order_text = $info_text."<strong>Potwierdzenie złożenia zamówienia z dnia ".date("Y-m-d")."</strong><br/><br/><strong>Klient:</strong> ".$client_t['name']."<br/>".$order_text."<strong>Adres dostawy:<br/></strong>".$client_t['delivery_street']."<br/>".$client_t['delivery_post_code']." ".$client_t['delivery_city']." ";
					foreach($email as $id=>$address)
					{				
					 $this->email->to($address);
					 $this->email->from('jkk@partnerjkk.pl', 'JKK PARTER');
					 $this->email->subject('Zamówienie JKK PARTNER ');
					 $this->email->message($order_text);			
					 $this->email->send();
					}

					$vars['order_result']=$r[1];
					$this->display($this->path."orders_result",$vars);
					
				}		
			if(!isset($vars['order_result']))
				$this->display($this->path."orders_summary",$vars);
	}
	public function deleteProductCart()
	{	if(isset($_GET['orders']))
			$is_order = 1;
		else
			$is_order = 0;
		$this->orders->deleteProductCart($_POST['idToDel'],$is_order);
		if(isset($_GET['orders']))
				redirect(base_url("orders/"),'refresh');
		redirect(base_url("orders/cart/1"),'refresh');
	}
	public function createCartFromOrder($id_order=0){
		$products=$this->orders->getProductsToOrder($id_order);
		foreach($products as $k=>$v)
			{
				$vars['id_user']=$this->session->userdata('id_user');
				$vars['id_client']=$this->session->userdata('id_client');
				$product=$this->products->getProductById($v['id_product']);
				$this->orders->addProductToOrder($v['id_product'],$vars,$v['amount'],$product,0);
			}
		redirect(base_url("orders/cart/?id_cart=1"),'refresh');	
	}
	public function cart()
	{ 
		if(isset($_GET['id_cart']))
			{
				$this->orders->activeCart($_GET['id_cart']);
				$vars['is_edited'] = 1;
			}
			
		$vars['sum_cart']=$this->orders->sumCartByUser($this->session->userdata('id_user'));	
		$vars['cart_products']=$this->orders->getCartProducts($this->session->userdata('id_user'));	
		$vars['favorite_list']=$this->products->getFavoriteList($this->session->userdata('id_user'));
		$vars['client']=$this->client->getById($this->session->userdata('id_client'));
		$vars['adviser']=$this->access->getUserByIdShort($vars['client']['id_user_system']);
		$vars['path']=$this->path;
		$vars['id_category']=0;
		//$vars['categories']=$this->products->getCategoriesListGroupByParent();		
		$vars['breadcrumbs']=$this->load->view($this->path."breadcrumbs", $vars, true);		
		$this->display($this->path."cart",$vars);
	}
	public function createCartFromHistory($id_cart=0)
	{ 
		$this->orders->createCartFromHistory($id_cart,$this->session->userdata('id_user'),$this->session->userdata('id_client'));	
		redirect(base_url('orders/cart'),'refresh');	
	}
	public function history($page_start=0)
	{ 	redirect(base_url("orders/"),'refresh');
		$vars['sum_cart']=$this->orders->sumCartByUser($this->session->userdata('id_user'));	
		$vars['cart_products']=$this->orders->getCartProducts($this->session->userdata('id_user'));	
		$vars['favorite_list']=$this->products->getFavoriteList($this->session->userdata('id_user'));
		$vars['client']=$this->client->getById($this->session->userdata('id_client'));
		$vars['adviser']=$this->access->getUserByIdShort($vars['client']['id_user_system']);
		$vars['path']=$this->path;
		
		$vars['carts']=$this->orders->getCartsForHistory($this->session->userdata('id_user'),$page_start);	
		$vars['cart_products']=$this->orders->getCartProductsToAccept($vars['carts']);
		$config['base_url'] = base_url('orders/history/');
		$config['total_rows'] = $this->orders->countCartsForHistory($this->session->userdata('id_user'));
		$config['uri_segment']=3;	
		$this->pagination->initialize($config); 
		$vars['pagination_links']=$this->pagination->create_links();
		$vars['page']=$page_start;
			
		
		$vars['breadcrumbs']=$this->load->view($this->path."breadcrumbs", $vars, true);		
		$this->display($this->path."carts_list_history",$vars);
	}
	public function addProductToOrder($id_product=0)
	{ 	
		$vars['id_user']=$this->session->userdata('id_user');
		$vars['id_client']=$this->session->userdata('id_client');
		$product=$this->products->getProductById($id_product);
		$this->orders->addProductToOrder($id_product,$vars,$_POST['amount'],$product,$_POST['id_contract']);
	}
	public function updateProductAmount()
	{ 	
		$this->orders->updateProductAmount($_POST['amount'],$_POST['id']);
	}
	public function cancelCart()
	{ 	
		$user_now=$this->access->getUserById($this->session->userdata('id_user'));
		$order=$this->orders->getOrderById($_POST['idToCancel']);
		$user=$this->access->getUserById($order['id_user']);
		$email[1]=$user['email'];
		
		$order_text = "<strong>Zamówienie odrzucone</strong><br/><br/>
			<strong>Data odrzucenia: </strong>".date("Y-m-d")."
			<br/><br/>Twoje zamówienie zostało odrzucone przez osobę akceptującą - <strong>".$user_now['firstname']." ".$user_now['lastname']."</strong>";
			
		foreach($email as $id=>$address)
		{				
		 $this->email->to($address);
		 $this->email->from('jkk@partnerjkk.pl', 'JKK PARTER');
		 $this->email->subject('Zamówienie JKK PARTNER - zamówienie odrzucone');
		 $this->email->message($order_text);			
		 $this->email->send();
		}
		$this->orders->cancelCart($_POST['idToCancel']);
		redirect(base_url("orders"),'refresh');
	}
	
	public function sendInquiry()
	{	
		$this->inquiries->sendInquiry($this->session->userdata('id_user'),$this->session->userdata('id_client'));
		$this->orders->clearCart($this->session->userdata('id_user'));
		redirect(base_url("inquiries?created=1"),'refresh');	
	}
	public function acceptCart()
	{	$user_now=$this->access->getUserById($this->session->userdata('id_user'));
		$client_t=$this->client->getById($this->session->userdata('id_client'));
		$user=$this->access->getUserById($client_t['id_user_accept']);
		$email[1]=$user['email'];
		if($user_now['id_user'] != $user['id_user'])
			$email[0]=$user_now['email'];
	
		$order_text = "<strong>Nowe zamówienie</strong><br/><br/>
			<strong>Data złożenia:</strong>".date("Y-m-d")."
			<br/><strong>Składający zamówienie:</strong> ".$user_now['firstname']." ".$user_now['lastname']."<br/><strong>Status:</strong>Oczekujące na akceptację";
		$l=2;
		$temp=explode(",",$client_t['accpeted_orders_emails']);
			foreach($temp as $k=>$v)
			{
				$l++;
				$email[$l]=$v;
			}
	
		foreach($email as $id=>$address)
		{				
		 $this->email->to($address);
		 $this->email->from('jkk@partnerjkk.pl', 'JKK PARTER');
		 $this->email->subject('Zamówienie JKK PARTNER - oczekiwanie na akceptację');
		 $this->email->message($order_text);			
		 $this->email->send();
		}
		$this->orders->acceptCart($this->session->userdata('id_user'));
		redirect(base_url("orders"),'refresh');	
	}
	public function clearCart()
	{
		$this->orders->clearCart($this->session->userdata('id_user'));
		redirect(base_url("orders/cart/"),'refresh');	
	}
	public function subtotalCart()
	{
		$this->orders->subtotalCart($this->session->userdata('id_user'),$_POST);
		redirect(base_url('orders/cart'),'refresh');	
	}
	
	public function getOrdersJSON()
	{
		echo $this->orders->getOrdersJSON();
	}
}
?>