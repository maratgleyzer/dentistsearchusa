<?php

class Promotionals_Model extends Model{
	function promotionals_model(){
		parent::Model();
		$this->load->database();		
	}
	function get_promos($userid){
		$this->db->cache_off();
		$this->db->order_by('id','DESC');
		$res = $this->db->get_where('user_promotionals',array('user_id' => $userid));
		return $res->result_array();
	}
	function get_dentist_promos($sort,$userid){
		$this->db->cache_off();
		$order = 'ASC';
		if($sort == 'id'){
			$order = 'DESC';
		}
		if($userid){
			$query = "SELECT i.*, CONCAT(p.last_name,', ',p.first_name, p.post_nominal) AS owner FROM user_promotionals AS i, user_personal_info AS p WHERE i.user_id = p.user_id AND p.user_id = {$userid} ORDER BY {$sort} {$order}";
		}else{
			$query = "SELECT i.*, CONCAT(p.last_name,', ',p.first_name, p.post_nominal) AS owner FROM user_promotionals AS i, user_personal_info AS p WHERE i.user_id = p.user_id ORDER BY {$sort} {$order}";
		}
		$res = $this->db->query($query);
		return $res->result_array();
	}
	function save_promo($id){
		$edit_id = $this->input->post('promo_id');
		$data = array(
			'name' => $this->input->post('promo_name'),
			'code' => $this->input->post('code'),
			'description' => $this->input->post('content'),
			'file' => $this->input->post('file'),
			'file_path' => $this->input->post('file_path'),
			'user_id' => $id
        );
		if($edit_id){
			$this->db->update('user_promotionals',$data,array('id' => $edit_id));
			return $edit_id;
		}else{
			$this->db->insert('user_promotionals',$data);
			return $this->db->insert_id();
		}
	}
	function delete_promo($id){
		$this->db->where('id', $id);
		$this->db->delete('user_promotionals');
	}
	function get_file_details($id){
		$this->db->cache_off();
		$this->db->select('file,file_path');
		$this->db->where('id', $id);
		$res = $this->db->get('user_promotionals');
		return $res->row_array();
	}
}