<?php 

class Articlesmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('access');
    }
	public function getListTraders(){
		$this->db->select('*');
		$this->db->from('traders');
		$this->db->where('id_status !=', 0);
		$list = array();
		$fields = $this->db->list_fields('traders');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_trader][$field]=$item->$field;
							}
		}
		return $list;
		
	}
	public function getNewsList(){
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where('id_status !=', 0);
		$this->db->where('news', 1);
		$list = array();
		$fields = $this->db->list_fields('articles');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_article][$field]=$item->$field;
							}
		}
		return $list;
		
	}
	public function getList(){
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where('id_status !=', 0);
		$this->db->where('news', 0);
		$list = array();
		$fields = $this->db->list_fields('articles');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$item->id_article][$field]=$item->$field;
							}
		}
		return $list;
		
	}
	public function getArticleById($id=0){
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where('id_article', $id);
		$this->db->where('id_status !=', 0);
		$list = array();
		$fields = $this->db->list_fields('articles');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
		}
		return $list;
		
	}
	public function getTraderById($id=0){
		$this->db->select('*');
		$this->db->from('traders');
		$this->db->where('id_trader', $id);
		$this->db->where('id_status !=', 0);
		$list = array();
		$fields = $this->db->list_fields('traders');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
		}
		return $list;
		
	}
	public function getContact($id=0){
		$this->db->select('*');
		$this->db->from('contact');
		$list = array();
		$fields = $this->db->list_fields('contact');
		foreach($this->db->get()->result() as $item)
		{	
				foreach ($fields as $field)
							{
							$list[$field]=$item->$field;
							}
		}
		return $list;
		
	}
	public function updateContact($post){
		$this->db->where('id', 1);
		return $this->db->update('contact',$post);		
	}
	public function updateArticle($post,$id=0){
		$this->db->where('id_article', $id);
		return $this->db->update('articles',$post);		
	}
	public function insertArticle($post,$news=0){
		$post['news']=$news;
		return $this->db->insert('articles',$post);		
	}
	public function insertTrader($post){
		return $this->db->insert('traders',$post);		
	}
	public function updateTrader($post,$id=0){
		$this->db->where('id_trader', $id);
		return $this->db->update('traders',$post);		
	}
	public function delete($id){
		$this->db->where('id_article', $id);
		$post['id_status']=0;
		return $this->db->update('articles',$post);		
	}
	public function deleteTrader($id){
		$this->db->where('id_trader', $id);
		$post['id_status']=0;
		return $this->db->update('traders',$post);		
	}
	
}