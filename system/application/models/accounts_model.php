<?php

class Accounts_Model extends Model {
	function accounts_model(){
		parent::Model();
		$this->load->database();		
	}
	function create_account(){
		$salt = random_string('alnum',40);
		$data = array(
		   'email' => $this->input->post('email'),
		   'password' => dohash($salt.$this->input->post('password')),
		   'salt' => $salt,
		   'status' => 1,
		   'date'	=> date('Y-m-d'),
		   'plan_id' => $this->input->post('payment_plan')
        );
		$this->db->insert('user_accounts', $data); 
		return $this->db->insert_id();
	}
	function change_payment_plan($id){
		$data['plan_id'] = $this->input->post('payment_plan');
		$this->db->update('user_accounts', $data, array('id' => $id));
	}
	function do_login(){
		$this->db->cache_off();
		$email = $this->input->post('email');
		$salt = $this->get_salt($email);
		$login = array(
			'email' => $email,
			'password' => dohash($salt.$this->input->post('password'))
		);
		$this->db->select('id');
		$res = $this->db->get_where('user_accounts', $login);
		$res_array = $res->row_array();
		if($res->num_rows()) return $res_array['id'];
	}
	function check_unique_email($email){
		$this->db->cache_off();
		$res = $this->db->get_where('user_accounts', array('email' => $email));
		return $res->num_rows();
	}
	function get_salt($email){
		$this->db->cache_off();
		$this->db->select('salt');
		$res = $this->db->get_where('user_accounts', array('email' => $email));
		$res = $res->row_array();
		return $res['salt'];
	}
	function delete_by_users($user_id){
		$this->db->where('id', $user_id);
		$this->db->delete('user_accounts');
	}
	function check_old_password($str,$id){
		$this->db->cache_off();
		$salt = $this->get_salt_by_id($id);
		$password = dohash($salt.$str);
		$this->db->select('id');
		$res = $this->db->get_where('user_accounts', array('password' => $password));
		$res_array = $res->row_array();
		if($res->num_rows()){ 
			return TRUE;
		}else{
			return FALSE;
		}
	}
	function get_salt_by_id($id){
		$this->db->cache_off();
		$this->db->select('salt');
		$res = $this->db->get_where('user_accounts', array('id' => $id));
		$res = $res->row_array();
		if($res) return $res['salt'];
	}
	function change_password($id){
		$salt = random_string('alnum',40);
		$data['password'] = dohash($salt.$this->input->post('new_password'));
		$data['salt'] = $salt;
		$this->db->update('user_accounts', $data, array('id' => $id));
	}
	function change_status($id){
		$data['status'] = ($this->input->post('status') ? '0' : '1');
		$this->db->update('user_accounts', $data, array('id' => $id));
	}
}