<?php

class Statistics_Model extends Model{
	function statistics_model(){
		parent::Model();
		$this->load->database();		
	}
	function add_hit($id){
		$this->db->cache_off();
		$this->db->select('id');
		$res = $this->db->get_where('user_statistics', array('user_id' => $id));
		if(!$res->num_rows()){
			$data = array(
				'user_id' => $id,
				'page_view' => 1,
			);
			$this->db->insert('user_statistics',$data);
		}else{
			$this->db->where('user_id', $id);
			$this->db->set('page_view','page_view + 1',false);
			$this->db->update('user_statistics');  
		}
	}
	function create_account($id){
		$data = array(
			'user_id' => $id,
			'page_view' => 0,
		);
		$this->db->insert('user_statistics',$data);
	}
	function get_page_view($id){
		$this->db->cache_off();
		$this->db->select('page_view');
		$res = $this->db->get_where('user_statistics', array('user_id' => $id));
		if($res->num_rows()){
			$res = $res->row_array();
			return $res['page_view'];
		}else{
			return 0;
		}
	}
	function delete_by_users($user_id){
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_statistics');
	}
}