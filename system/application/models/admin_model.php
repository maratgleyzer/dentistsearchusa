<?php

class Admin_model extends Model {
	function Admin_model(){
		parent::Model();
		$this->load->database();		
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
		$this->db->select('id,level');
		$res = $this->db->get_where('admin', $login);
		$res_array = $res->row_array();
		if($res->num_rows()) return $res_array;
	}
	function get_salt($login){
		$this->db->cache_off();
		$this->db->select('salt');
		$res = $this->db->get_where('admin', array('login' => $login));
		$res = $res->row_array();
		if($res) return $res['salt'];
	}
	function get_salt_by_id($id){
		$this->db->cache_off();
		$this->db->select('salt');
		$res = $this->db->get_where('admin', array('id' => $id));
		$res = $res->row_array();
		if($res) return $res['salt'];
	}
	function get_details($id){
		$this->db->cache_off();
		$res = $this->db->get_where('admin',array('id' => $id));
		return $res->row_array();
	}
	function check_old_password($str){
		$this->db->cache_off();
		$salt = $this->get_salt_by_id(1);
		$password = dohash($salt.$str);
		$this->db->cache_off();
		$this->db->select('id');
		$res = $this->db->get_where('admin', array('password' => $password));
		$res_array = $res->row_array();
		if($res->num_rows()){ 
			return TRUE;
		}else{
			return FALSE;
		}
	}
	function save_admin(){
		$data = array(
		   'login' => $this->input->post('partner_email')
        );
		if($this->input->post('change_pass')){
			$salt = random_string('alnum',40);
			$data['password'] = dohash($salt.$this->input->post('password'));
			$data['salt'] = $salt;
		}
		$this->db->update('admin', $data, array('id' => 1));
	}
	function save_sub_admin($id){
		$data = array(
		   'login' => $this->input->post('email')
        );
		if($this->input->post('change_pass')){
			$salt = random_string('alnum',40);
			$data['password'] = dohash($salt.$this->input->post('password'));
			$data['salt'] = $salt;
		}
		$this->db->update('admin', $data, array('id' => $id,'level' => 2));
	}
	function add_sub_admin(){
		$salt = random_string('alnum',40);
		$data = array(
			'login' => $this->input->post('email'),
			'level' => 2,
			'password' => dohash($salt.$this->input->post('password')),
			'salt' => $salt
		);
		$this->db->insert('admin',$data);
		return $this->db->insert_id();
	}
	function get_all_sub_admin(){
		$this->db->cache_off();
		$res = $this->db->get_where('admin',array('level' => 2));
		return $res->result_array();
	}
	function delete_sub_admin($id){
		$this->db->where(array('id' => $id, 'level' => 2));
		$this->db->delete('admin');
	}
	function check_unique_email($email){
		$this->db->cache_off();
		$res = $this->db->get_where('admin', array('login' => $email));
		return $res->num_rows();
	}
}