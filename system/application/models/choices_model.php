<?php

class Choices_Model extends Model{
	function choices_model(){
		parent::Model();
		$this->load->database();		
	}
	function save($edit){
		$data = array(
		   'value' => $this->input->post('value')
        );
		if(!$edit){
			$this->db->insert('admin_setting_choices', $data);
		}else{
			$this->db->update('admin_setting_choices', $data, array('id' => $edit));
		}
	}
	function get_all(){
		$this->db->cache_off();
		$res = $this->db->get('admin_setting_choices');
		return $res->result_array();
	}
	function get_choice($id){
		$this->db->cache_off();
		$res = $this->db->get_where('admin_setting_choices', array('id' => $id));
		return $res->row_array();
	}
	function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('admin_setting_choices');
		print TRUE;
	}
}