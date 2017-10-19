<?php

class CMS_model extends Model {
	function CMS_model(){
		parent::Model();
		$this->load->database();		
	}
	function save_cms_user($id){
		$data = array(
		   'login' => $this->input->post('email'),
		   'name' => ucwords($this->input->post('name'))
        );
		if($this->input->post('change_pass')){
			$salt = random_string('alnum',40);
			$data['password'] = dohash($salt.$this->input->post('password'));
			$data['salt'] = $salt;
		}
		$this->db->update('cms_users', $data, array('id' => $id));
	}
	function add_cms_user(){
		$salt = random_string('alnum',40);
		$data = array(
			'login' => $this->input->post('email'),
			'name' => ucwords($this->input->post('name')),
			'password' => dohash($salt.$this->input->post('password')),
			'salt' => $salt
		);
		$this->db->insert('cms_users',$data);
		return $this->db->insert_id();
	}
	function get_all_cms_users(){
		$this->db->cache_off();
		$res = $this->db->get('cms_users');
		return $res->result_array();
	}
	function delete_cms_user($id){
		$this->db->where(array('id' => $id));
		$this->db->delete('cms_users');
	}
	function check_unique_email($email){
		$this->db->cache_off();
		$res = $this->db->get_where('cms_users', array('login' => $email));
		return $res->num_rows();
	}
	function get_details($id){
		$this->db->cache_off();
		$res = $this->db->get_where('cms_users',array('id' => $id));
		return $res->row_array();
	}
	function do_login(){
		$this->db->cache_off();
		$login = $this->input->post('login');
		$salt = $this->get_salt($login);
		$login = array(
			'login' => $login,
			'password' => dohash($salt.$this->input->post('password'))
		);
		$this->db->cache_off();
		$this->db->select('id');
		$res = $this->db->get_where('cms_users', $login);
		$res_array = $res->row_array();
		if($res->num_rows()) return $res_array;
	}
	function get_salt($login){
		$this->db->cache_off();
		$this->db->select('salt');
		$res = $this->db->get_where('cms_users', array('login' => $login));
		$res = $res->row_array();
		if($res) return $res['salt'];
	}
}