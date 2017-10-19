<?php

class Blog_model extends Model {
	function Blog_model(){
		parent::Model();
		$this->load->database();		
	}
	function articles($sort,$order='ASC'){
		$this->db->cache_off();
		if($sort == 'date') $order = 'DESC';
		$query = "SELECT a.*,c.category_title FROM content_articles AS a, content_categories AS c WHERE a.category_id = c.id ORDER BY {$sort} {$order}";
		$cats = $this->db->query($query);
		return $cats->result_array();
	}
	function contents($l, $p){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->from('content_articles');
		$this->db->limit($l, $p);
		$this->db->order_by("id", "DESC"); 
		$cats = $this->db->get();
		return $cats->result_array();
	}
	
	function contents_by_cat($c, $l, $p){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->from('content_articles');
		$this->db->where("category_id", $c); 
		$this->db->limit($l, $p);
		$this->db->order_by("id", "DESC"); 
		$cats = $this->db->get();
		return $cats->result_array();
	}
	
	function count_contents(){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->from('content_articles');
		$cats = $this->db->get();
		return count($cats->result_array());
	}
	
	function count_contents_by_cat($c){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->from('content_articles');
		$this->db->where("category_id", $c); 
		$cats = $this->db->get();
		return count($cats->result_array());
	}
	
	function content_page($id){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->from('content_articles');
		$this->db->where("id", $id); 
		$cats = $this->db->get();
		return $cats->result_array();
	}
	
	function categories($type){
		$this->db->cache_off();
		$this->db->order_by("id", "DESC"); 
		$cats = $this->db->get_where('content_categories',array('type' => $type));
		return $cats->result_array();
	}
	function categories_and_count($video=FALSE){
		$this->db->cache_off();
		if($video){
			$type = 2;
			$content = 'content_videos';
		}else{
			$type = 1;
			$content = 'content_articles';
		}
		$cats = $this->db->query('SELECT c.*,(SELECT COUNT(id) FROM '.$content.' WHERE category_id = c.id) AS art_count FROM content_categories AS c WHERE c.type = ?',$type);
		return $cats->result_array();
	}
	function contents_related($c, $id){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->from('content_articles');
		$this->db->where("category_id", $c); 
		$this->db->where("id !=", $id); 
		$this->db->limit(2, 0);
		$this->db->order_by("id", "DESC"); 
		$cats = $this->db->get();
		return $cats->result_array();
	}
	function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('content_articles'); 
		print TRUE;
	}
	function save($edit){
		$data = array(
		   'title' => $this->input->post('title'),
		   'summary' => $this->input->post('summary'),
		   'tags' => $this->input->post('tags'),
		   'author' => $this->input->post('author'),
		   'content' => $this->input->post('content'),
		   'category_id' => $this->input->post('category'),
		   'image' => $this->input->post('image'),
		   'date' => date('Y-m-d')
        );
		if(!$edit){
			$this->db->insert('content_articles', $data);
		}else{
			$this->db->update('content_articles', $data, array('id' => $edit));
		}
	}
	function save_category($edit,$video){
		$data = array(
		   'category_title' => $this->input->post('category_title'),
		   'description' => $this->input->post('description'),
        );
		if($video){
			$data['type'] = 2;
		}else{
			$data['type'] = 1;
		}
		if(!$edit){
			$this->db->insert('content_categories', $data);
		}else{
			$this->db->update('content_categories', $data, array('id' => $edit));
		}
	}
	function get_category($id){
		$this->db->cache_off();
		$cats = $this->db->get_where('content_categories', array('id' => $id));
		return $cats->row_array();
	}
	function delete_category($id){
		$this->db->where('id', $id);
		$this->db->delete('content_categories'); 
		print TRUE;
	}
	function search($keyword){
		$this->db->cache_off();
		$res = $this->db->query(
"
SELECT *
FROM content_articles
WHERE (title LIKE '%{$keyword}%'
	OR summary LIKE '%{$keyword}%'
	OR content LIKE '%{$keyword}%'
	OR tags LIKE '%{$keyword}%'
)"); return $res->result_array();
	}
}