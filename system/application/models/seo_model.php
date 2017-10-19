<?php

class Seo_Model extends Model{
	function seo_model(){
		parent::Model();
		$this->load->database();		
	}
	function purge_mysql_cache(){
		$this->db->cache_delete_all();		
	}
	function purge_php_cache(){
		foreach (glob('/home/dentists/php_cache/*') as $v) unlink($v);
	}
	function save($edit){
		if(!$this->input->post('content_only')){
			$data = array(
			   'title' => $this->input->post('title'),
			   'description' => $this->input->post('description'),
			   'keywords' => $this->input->post('keywords')
			);
			if($this->input->post('editable_content')){
				$data['content'] = $this->input->post('content');
			}
		}else{
			$data['content'] = $this->input->post('content');
		}
		if(!$edit){
			$this->db->insert('admin_seo_tags', $data);
		}else{
			$this->db->update('admin_seo_tags', $data, array('id' => $edit));
		}
	}
	function get_all(){
		$this->db->cache_off();
		$this->db->order_by('editable_content');
		$this->db->order_by("content_only");
		$res = $this->db->get('admin_seo_tags');
		return $res->result_array();
	}
	function get($id){
		$this->db->cache_off();
		$res = $this->db->get_where('admin_seo_tags', array('id' => $id));
		return $res->row_array();
	}
	function get_analytics_id(){
		$this->db->cache_off();
		$res = $this->db->get_where('admin_settings', array('id' => 1));
		$res = $res->row_array();
		return $res['analytics_id'];
	}
	function save_analytics_id(){
		$data['analytics_id'] = $this->input->post('id');
		$this->db->update('admin_settings', $data, array('id' => 1));
	}
	function get_footer_tags(){
		$this->db->cache_off();
		$res = $this->db->get_where('admin_settings', array('id' => 1));
		$res = $res->row_array();
		return $res['footer_tags'];
	}
	function save_footer_tags(){
		$data['footer_tags'] = $this->input->post('footer_tags');
		$this->db->update('admin_settings', $data, array('id' => 1));
	}
	function get_dentists_featured(){
		$this->db->cache_off();
		$res = $this->db->get_where('admin_settings', array('id' => 1));
		$res = $res->row_array();
		return $res['dentists_featured'];
	}
	function save_dentists_featured(){
		$data['dentists_featured'] = $this->input->post('dentists_featured');
		$this->db->update('admin_settings', $data, array('id' => 1));
	}
	function get_search_result_text(){
		$this->db->cache_off();
		$res = $this->db->get_where('admin_settings', array('id' => 1));
		return $res->row_array();
	}
	function save_search_result_text(){
		$this->db->cache_off();
		$data['search_result_title'] = $this->input->post('title');
		$data['search_result_text'] = $this->input->post('text');
		$this->db->update('admin_settings', $data, array('id' => 1));
	}
}