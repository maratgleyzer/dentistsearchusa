<?php

class Contact_model extends Model {
	function Contact_model(){
		parent::Model();
		$this->load->database();		
	}
	
	function add_contact($is_dentist){
		$this->name = $this->input->post('fname')." ".$this->input->post('lname');
		$this->email = $this->input->post('email');
		$this->message = $this->input->post('msg');
		$this->date = date('M j, Y g:i A');
		$this->is_dentist = $is_dentist;
		$this->db->insert('admin_inquiries', $this);
	}
	function get_messages($sort){
		$this->db->cache_off();
		$order = 'ASC';
		if($sort == 'date'){
			$order = 'DESC';
		}
		$this->db->order_by($sort,$order);
		$res = $this->db->get('admin_inquiries');
		return $res->result_array();
	}
	function delete_message($id){
		$this->db->where('id', $id);
		$this->db->delete('admin_inquiries');
	}
}