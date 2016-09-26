<?php 

class Access extends CI_Model {

	private $userTable=array('id_profile', 'firstname', 'lastname', 'login', 'password',  'email','id_client');
	private $userTableFull=array('id_profile','mpk', 'firstname', 'lastname', 'login', 'email','phone_number', 'password', 'active','id_client');
    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
    }
	
	public function logIn($login,$pass,$is_admin)
	{
		$this->db->select('active');
		$this->db->from('users');
		$this->db->where('login',strtolower($login));
		$this->db->where('password',$this->hashPass($pass));
		$this->db->where('id_status', 1);
		if($is_admin == false)
			$this->db->where_in('id_profile',array(3,4));
		else if($is_admin == true)
			$this->db->where_in('id_profile',array(1,2));
		$return = 0;
		foreach($this->db->get()->result() as $item)
		{
			$return = $item->active;
			$data = array(
               'last_login' => date("Y-m-d H:i:s")
            
            );

			$this->db->where('login',strtolower($login));
			$this->db->update('users',$data);
		}
		if ($return==1)
		{	$user_id=$this->getUserByLogin($login);
			$newdata = array(
			   'logged_in' => TRUE,
			   'id_user' => $user_id['id_user'],
			    'mpk' => $user_id['mpk'],
			   'firstname' => $user_id['firstname'],
			   'lastname' => $user_id['lastname'],
			   'id_profile' => $user_id['id_profile'],
			   'id_client' => $user_id['id_client'],
			   'per_page' => 12
		    );
			
			$this->session->set_userdata($newdata);
		}
		
		return $return;
	}

	public function logOut()
	{	
			$this->session->unset_userdata('logged_in');
	}
	
	public function isLogIn()
	{			 
		return $this->session->userdata('logged_in');
	}

	private function hashPass($pass)
	{
		return md5($pass.KEY_CODE);
	}
	
	public function loginExist($login)
	{
		$this->db->where('login', strtolower($login));
		$this->db->from('users');
		$this->db->where('id_status !=', 0);
		if(!$this->db->count_all_results())
		return 0;
		
		return 1;
	}
	

	public function emailExist($email)
	{
		$this->db->where('email', strtolower($email));
		$this->db->from('users');
		$this->db->where('id_status !=', 0);
		if(!$this->db->count_all_results())
		return 0;
		
		return 1;
	}
	
	
	public function getUsersList()
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id_status !=', 0);
		$usersList = array();
		foreach($this->db->get()->result() as $item)
		{	
			$usersList[$item->id_user]=array(
											'login' => $item->login,
											'email'=>$item->email,
											'mpk'=>$item->mpk,
											'id_profile'=>$item->id_profile,
											'firstname'=>$item->firstname,
											'lastname'=>$item->lastname,
											'active'=>$item->active,
											'date_add'=>$item->date_add,
											'date_upd'=>$item->date_upd,
											'last_login'=>$item->last_login,
											'profilename'=>$this->access->getProfileName($item->id_profile)
			);			
		}
		
		return $usersList;
	}
	public function getUsersListByRole($data=array())
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id_status !=', 0);
		$this->db->where_in('id_profile', $data);
		$list = array();
		$fields = $this->db->list_fields('users');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_user][$field]=$item->$field;
							}
		}	
		return $list;		
	}
	public function getUsersListByRoleActive($data=array())
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id_status !=', 0);
		$this->db->where('active', 1);
		$this->db->where_in('id_profile', $data);
		$list = array();
		$fields = $this->db->list_fields('users');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_user][$field]=$item->$field;
							}
		}	
		return $list;		
	}
	public function getUsersListByProfile($id_profile,$id_client)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_profile', $id_profile);
		$this->db->where('id_client', $id_client);
		$usersList = array();
		foreach($this->db->get()->result() as $item)
		{	
			$usersList[$item->id_user]=array(
											'login' => $item->login,
											'email'=>$item->email,
											'mpk'=>$item->mpk,
											'id_profile'=>$item->id_profile,
											'firstname'=>$item->firstname,
											'lastname'=>$item->lastname,
											'active'=>$item->active,
											'date_add'=>$item->date_add,
											'date_upd'=>$item->date_upd,
											'last_login'=>$item->last_login,
											'profilename'=>$this->access->getProfileName($item->id_profile)
			);			
		}
		
		return $usersList;
	}
	public function getUsersById($data=array())
	{
		$this->db->select('*');		
		$this->db->from('users');
		$this->db->where('id_status !=', 0);
		$this->db->where_in('id_user',$data);
		$list = array();
		$fields = $this->db->list_fields('users');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_user][$field]=$item->$field;
							}
		}	
		return $list;
	}
	public function getUserById($id)
	{
		$this->db->select('*');		
		$this->db->from('users');
		$this->db->where('id_status !=', 0);
		$this->db->where('id_user',$id);
		$return = 0;
		foreach($this->db->get()->result() as $item)
		{	
			$return=array(
											'id_user'=>$item->id_user,
											'id_client'=>$item->id_client,
											'mpk'=>$item->mpk,
											'login' => $item->login,
											'email'=>$item->email,
											'phone_number'=>$item->phone_number,
											'id_profile'=>$item->id_profile,
											'firstname'=>$item->firstname,
											'lastname'=>$item->lastname,
											'active'=>$item->active,
											'date_add'=>$item->date_add,
											'date_upd'=>$item->date_upd,
											'last_login'=>$item->last_login,
											
			);
					}
		
		return $return;
	}
	public function getUserByIdShort($id)
	{
		$this->db->select('*');		
		$this->db->from('users');
		$this->db->where('id_user',$id);
		$return = 0;
		foreach($this->db->get()->result() as $item)
		{	
			$return=array(
											'email'=>$item->email,
											'id_profile'=>$item->id_profile,
											'firstname'=>$item->firstname,
											'lastname'=>$item->lastname,
											'phone_number'=>$item->phone_number,
											'active'=>$item->active,
											'last_login'=>$item->last_login,
											
			);
		}
		
		return $return;
	}
	public function getUserByLogin($login,$admin=false)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('login',strtolower($login));
		$return = 0;
		foreach($this->db->get()->result() as $item)
		{	
			$return=array(
											'id_user'=>$item->id_user,
											'id_client'=>$item->id_client,
											'mpk'=>$item->mpk,
											'login' => $item->login,
											'email'=>$item->email,
											'id_profile'=>$item->id_profile,
											'firstname'=>$item->firstname,
											'lastname'=>$item->lastname,
											'active'=>$item->active,
											'date_add'=>$item->date_add,
											'date_upd'=>$item->date_upd,
											'last_login'=>$item->last_login
			);
			
		}
		
		return $return;
	}
	
		public function getUserByEmail($email,$admin=false)
	{
		$this->db->select('*'); 
		$this->db->from('users');
		$this->db->where('email',strtolower($email));
		$return = 0;
		foreach($this->db->get()->result() as $item)
		{	
			$return=array(
											'id_user'=>$item->id_user,
											'login' => $item->login,
											'email'=>$item->email,
											'id_profile'=>$item->id_profile,
											'firstname'=>$item->firstname,
											'lastname'=>$item->lastname,
											'active'=>$item->active,
											'date_add'=>$item->date_add,
											'date_upd'=>$item->date_upd,
											'last_login'=>$item->last_login
			);
			
		}
		
		return $return;
	}
	
	
	 public function addUser($user)
	 {
	 		
	 	$need_keys= $this->userTable;
		foreach ($need_keys as  $key) {
			if(!array_key_exists($key, $user))
			return 0;
		}
	 	if($this->loginExist($user['login']))
			return 0;
		if($this->emailExist($user['email']))
			return 0;
		
	 	$table='users';
		
		$data = array(
					   'id_profile' => (int) $user['id_profile'] ,
					   'id_client' => $user['id_client'],
					   'mpk'=>$user['mpk'],
					   'firstname' =>  $user['firstname'] ,
					   'lastname' => $user['lastname'],
					   'login'=> strtolower($user['login']),
					   'password' => $this->hashPass($user['password']), 
					   'email'=> strtolower($user['email']),
					   'active'=> 0,
					   'date_add' => date("Y-m-d H:i:s"),
					   'date_upd' => date("Y-m-d H:i:s"),					   
					);
					
		return $this->db->insert($table, $data); 
	 }
	
	public function updUser($id_user, $user)
	 {
	 		
	 	$need_keys= $this->userTableFull;
		$data=array();		
		
		foreach ($need_keys as  $key) {
			if(array_key_exists($key, $user))
			{	if($key=='login')
					{if(!$this->loginExist($user['login']))
						{$data[$key]=$user[$key];}}
			else if($key=='email')
					{if(!$this->emailExist($user['email']))
						$data[$key]=$user[$key];}
			else if($key=='password' && $user[$key]!='')
					{
						$data[$key]=$this->hashPass($user[$key]);}
			else		
				{
				 if($key!='password')				 
					$data[$key]=$user[$key];
				 
				 }
			}
		}
	 			
	 	$table='users';	
		
		$data['date_upd'] = date("Y-m-d H:i:s");
		$this->db->where('id_user',$id_user);
		return $this->db->update($table, $data); 

	 }
	
	public function delUser($id_user)
	{
		$data['date_upd'] = date("Y-m-d H:i:s");
		$data['id_status'] = 0;
		$this->db->where('id_user',$id_user);			
		return $this->db->update("users",$data); 
		
	}
	
	public function delCategory($id_category){
		$data['date_upd'] = date("Y-m-d H:i:s");
		$data['id_status'] = 0;
		$this->db->where('id_category',$id_category);			
		return $this->db->update("products_categories",$data); 
	}
	
	public function delColor($id_color){
		$data['date_upd'] = date("Y-m-d H:i:s");
		$data['id_status'] = 0;
		$this->db->where('id_color',$id_color);			
		return $this->db->update("colors",$data); 
	}
	
	public function delProducer($id_producer){
		$data['date_upd'] = date("Y-m-d H:i:s");
		$data['id_status'] = 0;
		$this->db->where('id_producer',$id_producer);			
		return $this->db->update("producers",$data); 
	}

	public function getSessionData($var)
	{
		return $this->session->userdata($var);
		
	}
	
	public function getProfileName($id_profile)
	{
		$this->db->select('name');
		$this->db->from('users_profiles');
		$this->db->where('id_profile',$id_profile);
		$return='';
		foreach($this->db->get()->result() as $item)
		{$return=$item->name;}
		return $return;
	}
	
	public function activeUser($id_user)
	{
		$this->db->select('active');
		$table='users';
		$this->db->from($table);
		$this->db->where('id_user',$id_user);
		$active=0;
		foreach($this->db->get()->result() as $item)
		{$active=$item->active;}
		$dane=array('active'=>(int) !$active);
		$this->db->where('id_user',$id_user);
		$this->db->update($table,$dane);
	}
	
	public function getProfiles($id_lang=1)
	{
		$this->db->select('*');
		$this->db->from('users_profiles');
		$profile=array();
		foreach($this->db->get()->result_array() as $item)
		{$profile[$item['id_profile']]=$item;}
		
		return $profile;
		
	}
	public function resetPassword($email="",$password)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email',$email);
		foreach($this->db->get()->result_array() as $item)
		{
			$dane['password'] = $this->hashPass($password);
			$this->db->where('email',$email);
			$this->db->update('users',$dane);
			return 1;
		}
		return 0;
	}	
	public function setPassword($id_user=0,$password)
	{		if($password)
			{
			$dane['password'] = $this->hashPass($password);
			$this->db->where('id_user',$id_user);
			$this->db->update('users',$dane);
			}

	}	
	public function getPermissions($id_profile=0)
	{		
			$this->db->select('*');
			$this->db->from('users_profiles_permissions');
			$this->db->where('id_profile', $id_profile);
			$list = array();
			foreach($this->db->get()->result() as $item)
			{	
				$list[$item->id]['name']=$item->name_position;
				$list[$item->id]['access']=$item->access;
			}	
			return $list;

	}
	public function updatePermissions($id_profile=0,$array=array())
	{		
			foreach($array['access'] as $id => $is_access)
			{	
				$data[$id]['id'] = $id;
				$data[$id]['access'] = $is_access;
			}
			$this->db->update_batch('users_profiles_permissions', $data, 'id'); 
	}
	public function checkPermissions($id_profile = 0,$id_position = 0)
	{		
			$this->db->select('access');
			$this->db->from('users_profiles_permissions');
			$this->db->where('id_profile', $id_profile);
			$this->db->where('id_position', $id_position);
			$list = array();
			foreach($this->db->get()->result() as $item)
			{	
				return $item->access;
			}	
	}
	public function getPermissionsForMenu($id_profile=0)
	{		
			$this->db->select('*');
			$this->db->from('users_profiles_permissions');
			$this->db->where('id_profile', $id_profile);
			$this->db->where('access', 1);
			$list = array();
			foreach($this->db->get()->result() as $item)
			{	
				$list[$item->id]['name']=$item->name_position;
			}	
			return $list;

	}
	
	public function getFooterContact()
	{		
			$this->db->select('*');
			$this->db->from('contact');
			$this->db->where('id', 1);
			$list = array();
			$fields = $this->db->list_fields('contact');
			foreach($this->db->get()->result() as $item)
			{			
				foreach($fields as $field)
					{
					$list[$field]=$item->$field;
					}
			}	
			return $list;
	}
	public function getFooterTraders()
	{		
			$this->db->select('*');
			$this->db->from('traders');
			$this->db->where('id_status !=', 0);
			$list = array();
			$fields = $this->db->list_fields('traders');
			foreach($this->db->get()->result() as $item)
			{			
				foreach($fields as $field)
					{
					$list[$item->id_trader][$field]=$item->$field;
					}
			}	
			return $list;
	}
	
}