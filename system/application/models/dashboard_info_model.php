<?php

class Dashboard_Info_Model extends Model {
	function dashboard_info_model(){
		parent::Model();
		$this->load->database();		
	}
	function create_account($id){
		$data = array(
		   'user_id' => $id
        );
		$this->db->insert('user_dashboard_info', $data); 
	}
	function save_dashboard_info($id){
		$data = array(
			$this->input->post('field') => $this->input->post('content'),
        );
		$this->db->update('user_dashboard_info', $data, array('user_id' => $id));
	}
	function get_dashboard_info($id){
		$this->db->cache_off();
		$user = array('user_id' => $id);
		$res = $this->db->get_where("user_dashboard_info",$user);
		return $res->row_array();
	}
	function delete_by_users($user_id){
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_dashboard_info');
	}
}