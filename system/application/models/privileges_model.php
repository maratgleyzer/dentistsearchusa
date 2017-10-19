<?php

class Privileges_Model extends Model{
	function privileges_model(){
		parent::Model();
		$this->load->database();		
	}
	function get_all_settings(){
		$this->db->cache_off();
		$this->db->order_by('id');
		$res = $this->db->get('admin_setting_privileges');
		return $res->result_array();
	}
	function add_privileges($adminid){
		foreach($this->input->post('privileges') AS $priv){
			$data = array(
				'admin_id' => $adminid,
				'privilege_id' => $priv
			);
			$this->db->insert('admin_privileges',$data);
		}
	}
	function get_admin_privileges($admin){
		$this->db->cache_off();
		$query = "SELECT s.name,p.privilege_id FROM admin_privileges AS p, admin_setting_privileges AS s WHERE p.privilege_id = s.id AND p.admin_id = {$admin}";
		$res = $this->db->query($query);
		return $res->result_array();
	}
	function delete_sub_admin_privileges($id){
		$this->db->where('admin_id',$id);
		$this->db->delete('admin_privileges');
	}
}