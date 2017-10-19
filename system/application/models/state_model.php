<?php

class State_Model extends Model {
	function state_model(){
		parent::Model();
		$this->load->database();		
	}
	function get(){
		$this->db->cache_off();
		$this->db->select('state_long','stateID');
		$this->db->where('state_long !=', "NULL");
		$this->db->order_by("state_long","ASC");
		$res = $this->db->get("state");
		return $res->result_array();
	}
}