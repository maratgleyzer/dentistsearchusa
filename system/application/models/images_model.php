<?php

class Images_Model extends Model{
	function images_model(){
		parent::Model();
		$this->load->database();		
	}
	function save_image($file,$id){
		$data = array(
			'filename' => $file['orig_name'],
			'path' => $file['file_name'],
			'user_id' => $id
        );
		$this->db->insert('user_images',$data);
		return $this->db->insert_id();
	}
	function get_images($id){
		$this->db->cache_off();
		$user = array('user_id' => $id);
		$res = $this->db->get_where("user_images",$user);
		return $res->result_array();
	}
	function get_all_images($id){
		$this->db->cache_off();
		if($id){
			$query = "SELECT i.*, CONCAT(p.last_name,', ',p.first_name, p.post_nominal) AS owner FROM user_images AS i, user_personal_info AS p WHERE i.user_id = p.user_id AND p.user_id = {$id}";
		}else{
			$query = "SELECT i.*, CONCAT(p.last_name,', ',p.first_name, p.post_nominal) AS owner FROM user_images AS i, user_personal_info AS p WHERE i.user_id = p.user_id ORDER BY p.user_id";
		}
		$res = $this->db->query($query);
		return $res->result_array();
	}
	function get_image_details($id){
		$this->db->cache_off();
		$file = array('id' => $id);
		$res = $this->db->get_where("user_images",$file);
		return $res->row_array();
	}
	function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('user_images');
	}
	function delete_by_users($user_id){
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_images');
	}
	function create_account($user_id){
		$root = $_SERVER['DOCUMENT_ROOT'];
		$dir = ($user_id < 100 ? 'zero' : round($user_id, -2));
		if (!file_exists("$root/user_assets/images/$dir"))
			mkdir("$root/user_assets/images/$dir/", 0777);
		if (!file_exists("$root/user_assets/images/$dir/$user_id"))
			mkdir("$root/user_assets/images/$dir/$user_id/", 0777);
		if (!file_exists("$root/user_assets/prof_images/$dir"))
			mkdir("$root/user_assets/prof_images/$dir/", 0777);
		if (!file_exists("$root/user_assets/prof_images/$dir/$user_id"))
			mkdir("$root/user_assets/prof_images/$dir/$user_id/", 0777);
	}
}