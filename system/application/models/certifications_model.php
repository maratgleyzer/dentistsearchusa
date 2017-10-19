<?php

class Certifications_Model extends Model{
	function certifications_model(){
		parent::Model();
		$this->load->database();		
	}
	function save_certification($file,$id){
		$data = array(
			'filename' => $file['orig_name'],
			'path' => $file['file_name'],
			'user_id' => $id
        );
		$this->db->insert('user_certifications',$data);
		return $this->db->insert_id();
	}
	function get_certifications($id){
		$this->db->cache_off();
		$user = array('user_id' => $id);
		$res = $this->db->get_where("user_certifications",$user);
		return $res->result_array();
	}
	function get_certification_details($id){
		$this->db->cache_off();
		$file = array('id' => $id);
		$res = $this->db->get_where("user_certifications",$file);
		return $res->row_array();
	}
	function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('user_certifications');
	}
	function delete_by_users($user_id){
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_certifications');
	}
	function get_all_images($id){
		$this->db->cache_off();
		if($id){
			$query = "SELECT i.*, CONCAT(p.last_name,', ',p.first_name, p.post_nominal) AS owner FROM user_certifications AS i, user_personal_info AS p WHERE i.user_id = p.user_id AND p.user_id = {$id}";
		}else{
			$query = "SELECT i.*, CONCAT(p.last_name,', ',p.first_name, p.post_nominal) AS owner FROM user_certifications AS i, user_personal_info AS p WHERE i.user_id = p.user_id ORDER BY p.user_id";
		}
		$res = $this->db->query($query);
		return $res->result_array();
	}
}