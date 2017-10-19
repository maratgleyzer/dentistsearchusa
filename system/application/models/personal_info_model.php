<?php

class Personal_Info_Model extends Model{
	function personal_info_model(){
		parent::Model();
		$this->load->database();		
	}
	function create_account($id){
		$data = array(
		   'first_name' => ucwords($this->input->post('fname')),
		   'last_name' => ucwords($this->input->post('lname')),
		   'user_id' => $id
        );
		$this->db->insert('user_personal_info', $data); 
	}
	function admin_create_account($id){
		$data = array(
		   'first_name' => ucwords($this->input->post('first_name')),
		   'last_name' => ucwords($this->input->post('last_name')),
		   'user_id' => $id
        );
		$this->db->insert('user_personal_info', $data); 
	}
	function get_data($id){
		$this->db->cache_off();
		$res = $this->db->query('
			SELECT a.email,a.plan_id,a.status,c.*,p.* 
			FROM user_accounts AS a, user_company_info AS c, user_personal_info AS p 
			WHERE a.id = c.user_id AND c.user_id = p.user_id AND p.user_id = ?'
			,$id
		);
		return $res->row_array();
	}
	function save_data($id){
		$data = array(
			'first_name' => ucwords($this->input->post('first_name')),
			'last_name' => ucwords($this->input->post('last_name')),
			'post_nominal' => ret_alt_echo($this->input->post('post_nominal'),''),
			'mobile_number' => ret_alt_echo($this->input->post('mobile_number'),''),
			'bio' => ret_alt_echo($this->input->post('bio'),'')
        );
		$this->db->update('user_personal_info', $data, array('user_id' => $id));
	}
	function save_picvid($file_data,$logged_id){
		$data = array(
			'prof_pic' => $file_data['file_name']
		);
		$this->db->where('id', $logged_id);
		$this->db->update('user_personal_info', $data);
	}
	function delete_by_users($user_id){
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_personal_info');
	}
	function get_all_prof_pics() {
		$res = $this->db->query("select id, user_id, prof_pic from user_personal_info order by user_id");
		return $res->result();
	}
	function get_by_name($key,$limit){
		$this->db->cache_off();
		$this->db->distinct();
		$this->db->select('user_id,first_name,last_name');
		$this->db->like('first_name',$key,'after');
		$this->db->or_like('last_name',$key,'after'); 
		$this->db->order_by("last_name","ASC");
		if($limit)$this->db->limit($limit);
		$res = $this->db->get("user_personal_info");
		return $res->result_array();		
	}
}