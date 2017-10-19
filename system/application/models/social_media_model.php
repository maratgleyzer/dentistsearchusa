<?php

class Social_Media_Model extends Model{
	function social_media_model(){
		parent::Model();
		$this->load->database();		
	}
	function save($edit){
		$data = array(
		   'link' => $this->input->post('link'),
		   'tooltip' => $this->input->post('tooltip'),
		   'icon' => $this->input->post('image')
        );
		if(!$edit){
			$this->db->insert('admin_social_media_icons', $data);
		}else{
			$this->db->update('admin_social_media_icons', $data, array('id' => $edit));
		}
	}
	function get_all(){
		$this->db->cache_off();
		$res = $this->db->get('admin_social_media_icons');
		return $res->result_array();
	}
	function get($id){
		$this->db->cache_off();
		$res = $this->db->get_where('admin_social_media_icons', array('id' => $id));
		return $res->row_array();
	}
	function delete_icon($id){
		$this->db->where('id', $id);
		$this->db->delete('admin_social_media_icons');
		print TRUE;
	}
}