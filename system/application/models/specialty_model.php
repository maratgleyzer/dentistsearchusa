<?php

class Specialty_model extends Model {
	function Specialty_model(){
		parent::Model();
		$this->load->database();		
	}
	function specialties(){
		$this->db->cache_off();
		$cats = $this->db->get('user_specialty_categories');
		return $cats->result_array();
	}
	function user_specialties($id){
		$this->db->cache_off();
		$cats = $this->db->get_where('user_specialties',array('user_id' => $id));
		return $cats->result_array();
	}
	function get_user_specialties($id){
		$this->db->cache_off();
		$cats = $this->db->query('SELECT * FROM user_specialties AS u, user_specialty_categories AS c WHERE u.user_id = ? AND u.specialty_id = c.id',$id);
		return $cats->result_array();
	}
	function specialties_and_count(){
		$this->db->cache_off();
		$cats = $this->db->query('SELECT s.*,(SELECT COUNT(id) FROM user_specialties WHERE specialty_id = s.id) AS dent_count FROM user_specialty_categories AS s');
		return $cats->result_array();
	}
	function save_specialty($edit){
		$data = array(
		   'specialty_title' => $this->input->post('specialty_title'),
		   'description' => $this->input->post('description')
        );
		if(!$edit){
			$this->db->insert('user_specialty_categories', $data);
		}else{
			$this->db->update('user_specialty_categories', $data, array('id' => $edit));
		}
	}
	function get_specialty($id){
		$this->db->cache_off();
		$cats = $this->db->get_where('user_specialty_categories', array('id' => $id));
		return $cats->row_array();
	}
	function delete_specialty($id){
		$this->db->where('id', $id);
		$this->db->delete('user_specialty_categories'); 
		print TRUE;
	}
	function save_user_specialties(){
		$logged_id = $this->session->userdata('logged_id');
		$this->db->where('user_id', $logged_id);
		$this->db->delete('user_specialties'); //clear user specialties
		
		if($this->input->post('specialties')){
			$texts = $this->input->post('specialty_text');
			foreach($this->input->post('specialties') AS $check){
				$vals = explode(':',$check);
				if($texts[$vals[1]] == 'Please enter information about your qualifications in this category here'){
					$texts[$vals[1]] = NULL;
				}
				$data = array(
					'user_id' => $logged_id,
					'specialty_id' => $vals[0],
					'specialty_text' => $texts[$vals[1]]
				);
				$this->db->insert('user_specialties', $data);
			}
		}
	}
}