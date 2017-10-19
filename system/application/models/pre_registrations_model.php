<?php

class Pre_Registrations_Model extends Model{
	function pre_registrations_model(){
		parent::Model();
		$this->load->database();		
	}
	function get_users($sort){
		$this->db->cache_off();
		$order = 'ASC';
		if($sort == 'id'){
			$order = 'DESC';
		}
		$query = "SELECT p.*,c.value AS interested_in_text,(SELECT COUNT(id) FROM user_accounts WHERE email = p.email) AS status FROM user_pre_registrations AS p, admin_setting_choices AS c WHERE p.interested_in = c.id ORDER BY {$sort} {$order}";
		$res = $this->db->query($query);
		return $res->result_array();
	}

	function delete_pre_registration($id){
		$this->db->where('id', $id);
		$this->db->delete('user_pre_registrations');
	}
	function save_registration(){
		$data = array(
			'name' => strip_tags($this->input->post('name')),
			'phone' => strip_tags($this->input->post('phone')),
			'email' => $this->input->post('email'),
			'interested_in' => $this->input->post('interest')
		);
		$this->db->insert('user_pre_registrations',$data);
	}
}