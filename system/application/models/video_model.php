<?php

class Video_model extends Model {
	function Video_model(){
		parent::Model();
		$this->load->database();		
	}
	function get_recent_video(){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->order_by('date', 'DESC'); 
		$cats = $this->db->get('content_videos',1);
		return $cats->row_array();
	}
	function videos($sort,$order='ASC'){
		$this->db->cache_off();
		if($sort == 'date') $order = 'DESC';
		$query = "SELECT v.*,c.category_title FROM content_videos AS v, content_categories AS c WHERE v.category_id = c.id ORDER BY {$sort} {$order}";
		$cats = $this->db->query($query);
		return $cats->result_array();
	}
	function contents($l, $p){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->from('content_videos');
		$this->db->limit($l, $p);
		$this->db->order_by("id", "DESC"); 
		$cats = $this->db->get();
		return $cats->result_array();
	}
	function contents_by_cat($c, $l, $p){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->from('content_videos');
		$this->db->where("category_id", $c); 
		$this->db->limit($l, $p);
		$this->db->order_by("id", "DESC"); 
		$cats = $this->db->get();
		return $cats->result_array();
	}
	function count_contents_by_cat($c){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->from('content_videos');
		$this->db->where("category_id", $c); 
		$cats = $this->db->get();
		return count($cats->result_array());
	}
	function count_contents(){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->from('content_videos');
		$cats = $this->db->get();
		return count($cats->result_array());
	}
	
	function content_page($id){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->from('content_videos');
		$this->db->where("id", $id); 
		$cats = $this->db->get();
		return $cats->result_array();
	}
	
	function categories(){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->from('content_categories');
		$this->db->order_by("id", "DESC"); 
		$cats = $this->db->get();
		return $cats->result_array();
	}
	function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('content_videos'); 
		print TRUE;
	}
	function save($edit){
		$type = $this->input->post('video_type');
		$data = array(
		   'title' => $this->input->post('title'),
		   'summary' => $this->input->post('summary'),
		   'category_id' => $this->input->post('category'),
		   'tags' => $this->input->post('tags'),
		   'image' => $this->input->post($type.'_preview'),
		   'filename' => $this->input->post($type.'_video'),
		   'date' => date('Y-m-d'),
		   'type' => $type
        );
		if(!$edit){
			$this->db->insert('content_videos', $data);
		}else{
			$this->db->update('content_videos', $data, array('id' => $edit));
		}
	}
	function search($keyword){
		$this->db->cache_off();
		$res = $this->db->query(
"
SELECT *
FROM content_videos
WHERE (title LIKE '%{$keyword}%'
	OR summary LIKE '%{$keyword}%'
	OR tags LIKE '%{$keyword}%'
)"); return $res->result_array();
	}
}