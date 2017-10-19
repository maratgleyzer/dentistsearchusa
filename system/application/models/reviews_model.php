<?php

class Reviews_Model extends Model{
	function reviews_model(){
		parent::Model();
		$this->load->database();		
	}
	function add_review(){
		$data = array(
			'user_id' => $this->input->post('user_id'),
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'website' => $this->input->post('website'),
			'message' => $this->input->post('message'),
			'rating' => $this->input->post('rate'),
			'date'	=> date('Y-m-d')
        );
		$this->db->insert('user_reviews',$data);
		return $this->db->insert_id();
	}
	function check_unique_email($email,$user){
		$this->db->cache_off();
		$res = $this->db->get_where('user_reviews', array('email' => $email,'user_id' => $user));
		return $res->num_rows();
	}
	function get_user_rating($id){
		$this->db->cache_off();
		$this->db->select('the_rating');
		$res = $this->db->get_where('bayesian_rating', array('user_id' => $id));
		if($res->num_rows()){
			$res = $res->row_array();
			return $res['the_rating'];
		}else{
			return 0;
		}
	}
	function count_reviews($id){
		$this->db->cache_off();
		$this->db->select('id');
		$res = $this->db->get_where('user_reviews', array('user_id' => $id));
		return $res->num_rows();
	}
	function get_user_testimonials($id){
		$this->db->cache_off();
		$this->db->select('message,name,rating');
		$res = $this->db->get_where('user_reviews', array('user_id' => $id));
		return $res->result_array();
	}
	function delete_by_users($user_id){
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_reviews');
	}
	function get_all_reviews($sort,$id){
		$this->db->cache_off();
		$order = 'ASC';
		if($sort == 'date' || $sort == 'rating' || $sort == 'id') $order = 'DESC';
		
		if($id){
			$query = "SELECT i.*, CONCAT(p.last_name,', ',p.first_name, p.post_nominal) AS owner FROM user_reviews AS i, user_personal_info AS p WHERE i.user_id = p.user_id AND p.user_id = {$id} ORDER BY {$sort} {$order}";
		}else{
			$query = "SELECT i.*, CONCAT(p.last_name,', ',p.first_name, p.post_nominal) AS owner FROM user_reviews AS i, user_personal_info AS p WHERE i.user_id = p.user_id ORDER BY {$sort} {$order}";
		}
		$res = $this->db->query($query);
		return $res->result_array();
	}
	function is_read($id){
		$data = array(
			'is_read' => 1
		);
		$this->db->where('id', $id);
		$this->db->update('user_reviews', $data);
	}
	function delete_testi($id){
		$this->db->where('id', $id);
		$this->db->delete('user_reviews');
	}
	function count_unread($id){
		$this->db->select('*');
		$this->db->where('user_id',$id);
		$this->db->where('is_read',0);
		$this->db->order_by("id","DESC");
		$res = $this->db->get("user_reviews");
		return $res->result_array();
	}
}