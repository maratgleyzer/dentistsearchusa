<?php

class Email_Model extends Model{
	function Email_model(){
		parent::Model();
		$this->load->database();		
	}
	function save_template($edit){
		$data = array(
		   'subject' => $this->input->post('subject'),
		   'content' => $this->input->post('content')
		);		
		if(!$edit){
			$this->db->insert('admin_email_templates', $data);
		}else{
			$this->db->update('admin_email_templates', $data, array('id' => $edit));
		}
	}
	function get_template($id){
		$this->db->cache_off();
		$res = $this->db->get_where('admin_email_templates', array('id' => $id));
		return $res->row_array();
	}
}