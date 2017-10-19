<?php

class Event_scheduler_model extends Model {
	function Event_scheduler_model(){
		parent::Model();
		$this->load->database();		
	}
	
	function add_event(){
		$this->message = $this->input->post('event_msg');
		$this->note = $this->input->post('note');
		$this->start_date = $this->input->post('start_date');
		$this->end_date = $this->input->post('end_date');
		$this->user_id = $this->input->post('user_id');
		$this->db->insert('user_events', $this);
		return $this->db->insert_id();
	}

	function get_events($id){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->where('user_id',$id);
		$this->db->order_by("id","DESC");
		$res = $this->db->get("user_events");
		return $res->result_array();
	}
	
	function delete_event($id){
		$this->db->where('id', $id);
		$this->db->delete('user_events');
	}
	
	function add_sched($day, $login, $breakout, $breakin, $logout, $x, $id){
		$this->db->cache_off();
		$this->day = $day;
		$this->login = $login;
		$this->break_out = $breakout;
		$this->break_in = $breakin;
		$this->logout = $logout;
		$this->order = $x;
		$this->user_id = $id;
		$this->db->insert('user_schedules', $this);
		return $this->db->insert_id();
	}
	
	function delete_sched($id){
		$this->db->where('user_id', $id);
		$this->db->delete('user_schedules');
	}
	function get_scheds_by_day($id,$day){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->where('day',$day);
		$this->db->where('user_id',$id);
		$res = $this->db->get("user_schedules");
		return $res->row_array();
	}
	function get_scheds($id, $day){
		$this->db->cache_off();
		$this->db->select('*');
		$this->db->where('day',$day);
		$this->db->where('user_id',$id);
		$this->db->order_by("id","DESC");
		$res = $this->db->get("user_schedules");
		return $res->result_array();
	}
	function delete_by_users($user_id){
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_schedules');
	}
	// function is_read($id){
		// $data = array(
			// 'is_read' => 1
		// );
		// $this->db->where('id', $id);
		// $this->db->update('user_appointments', $data);
	// }
	
}