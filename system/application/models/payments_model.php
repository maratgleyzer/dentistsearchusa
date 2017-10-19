<?php

class Payments_Model extends Model{
	function payments_model(){
		parent::Model();
		$this->load->database();		
	}
	function get_plan_types(){
		$this->db->cache_off();
		$this->db->order_by('id');
		$res = $this->db->get("payment_plan_types");
		return $res->result_array();
	}
	function get_plan($id){
		$this->db->cache_off();
		$res = $this->db->get_where('payment_plans',array('id' => $id));
		return $res->row_array();
	}
	function get_plans(){
		$this->db->cache_off();
		$res = $this->db->get('payment_plans');
		return $res->result_array();
	}
	function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('payment_plans');
	}
	function save_payment_plan($edit){
		$data = array(
		   'name' => $this->input->post('name'),
		   'type' => $this->input->post('type'),
		   'description' => $this->input->post('description'),
		   'initial_payment' => $this->input->post('initial_amount'),
		   'recurring_payment' => $this->input->post('recurring_amount')
        );
		if(!$edit){
			$this->db->insert('payment_plans', $data);
		}else{
			$this->db->update('payment_plans', $data, array('id' => $edit));
		}
	}
	function get_payment_plans($sort){
		$this->db->cache_off();
		$query = "SELECT p.*,s.name AS type_name,(SELECT COUNT(id) FROM user_accounts WHERE plan_id = p.id) AS dentist_count FROM payment_plans AS p, payment_plan_types AS s WHERE p.type = s.id ORDER BY {$sort}";
		$res = $this->db->query($query);
		return $res->result_array();
	}
	function get_payment_options(){
		$options = array();
		$this->db->cache_off();
		$query = "SELECT p.*,s.name AS type_name,(SELECT COUNT(id) FROM user_accounts WHERE plan_id = p.id) AS dentist_count FROM payment_plans AS p, payment_plan_types AS s WHERE p.type = s.id ORDER BY type_name";
		$res = $this->db->query($query);
		$results = $res->result_array();
		foreach ($results as $result) {
			$options[$result['id']] = $result['name'].' ('.$result['dentist_count'].')';
		}
		return $options;
	}
	function get_payment_plan($id){
		$this->db->cache_off();
		$query = "SELECT p.name,p.initial_payment,p.recurring_payment,p.type,s.name AS type_name,s.is_recurring,s.recurring_type,s.recurring_cycles FROM payment_plans AS p, payment_plan_types AS s WHERE p.type = s.id AND p.id = {$id}";
		$res = $this->db->query($query);
		return $res->row_array();
	}
}