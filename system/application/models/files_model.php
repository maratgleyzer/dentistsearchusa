<?php

class Files_Model extends Model{
	function files_model(){
		parent::Model();
		$this->load->database();		
	}
	function save_document_files($file,$group,$id){
		$data = array(
			'filename' => $file['orig_name'],
			'path' => $file['file_name'],
			'group' => $group,
			'type' => $file['file_ext'],
			'user_id' => $id
        );
		$this->db->insert('user_files',$data);
		return $this->db->insert_id();
	}
	function get_documents($id){
		$this->db->cache_off();
		$user = array('user_id' => $id);
		$res = $this->db->get_where("user_files",$user);
		return $res->result_array();
	}
	function get_file_details($id){
		$this->db->cache_off();
		$file = array('id' => $id);
		$res = $this->db->get_where("user_files",$file);
		return $res->row_array();
	}
	function get_groups($id){
		$this->db->cache_off();
		$user = array('user_id' => $id);
		$this->db->distinct();
		$this->db->select('group');
		$res = $this->db->get_where("user_files",$user);
		return $res->result_array();
	}
	function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('user_files');
	}
	function delete_by_users($user_id){
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_files');
	}
	function get_all_files($id){
		$this->db->cache_off();
		if($id){
			$query = "SELECT i.*, CONCAT(p.last_name,', ',p.first_name, p.post_nominal) AS owner FROM user_files AS i, user_personal_info AS p WHERE i.user_id = p.user_id AND p.user_id = {$id}";
		}else{
			$query = "SELECT i.*, CONCAT(p.last_name,', ',p.first_name, p.post_nominal) AS owner FROM user_files AS i, user_personal_info AS p WHERE i.user_id = p.user_id ORDER BY p.user_id";
		}
		$res = $this->db->query($query);
		return $res->result_array();
	}
}