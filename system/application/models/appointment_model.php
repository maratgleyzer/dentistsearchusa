<?php

class Appointment_model extends Model {
	function Appointment_model(){
		parent::Model();
		$this->load->database();		
	}
	
	function save_appointment(){
		$this->appointment = $this->input->post('appointment');
		$this->name = $this->input->post('name');
		$this->age = $this->input->post('age');
		$this->oral_health = $this->input->post('oral_health');
		$this->last_visit = $this->input->post('last_visit');
		$this->app_date = $this->input->post('app_date');
		$this->app_time = $this->input->post('app_time');
		$this->email = $this->input->post('email');
		$this->telephone = $this->input->post('telephone');
		$this->mobile = $this->input->post('mobile');
		$this->comments = $this->input->post('comments');
		$this->pid = $this->input->post('pid');
		$this->db->insert('user_appointments', $this);
	}
	
	function get_apps($id){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->where('pid',$id);
		$this->db->order_by("id","DESC");
		$res = $this->db->get("user_appointments");
		return $res->result_array();
	}
	
	function count_unread($id){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->where('pid',$id);
		$this->db->where('is_read',0);
		$this->db->order_by("id","DESC");
		$res = $this->db->get("user_appointments");
		return $res->result_array();
	}
	
	function delete_app($id){
		$this->db->where('id', $id);
		$this->db->delete('user_appointments');
	}
	
	function is_read($id){
		$data = array(
			'is_read' => 1
		);
		$this->db->where('id', $id);
		$this->db->update('user_appointments', $data);
	}
	function delete_by_users($user_id){
		$this->db->where('pid', $user_id);
		$this->db->delete('user_appointments');
	}
	
}