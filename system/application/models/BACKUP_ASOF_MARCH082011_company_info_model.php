<?php

class Company_Info_Model extends Model {
	function company_info_model(){
		parent::Model();
		$this->load->database();		
	}
	function create_account($id){
		$data = array(
		   'user_id' => $id
        );
		$this->db->insert('user_company_info', $data); 
	}
	function save_data($id){
		$data = array(
			'company_name' => $this->input->post('company_name'),
			'address' => $this->input->post('address'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'zip' => $this->input->post('zip'),
			'telephone' => $this->input->post('telephone'),
			'website' => ret_alt_echo($this->input->post('website'),''),
			'company_email' => $this->input->post('company_email')
        );
		if($this->input->post('dsusa_telephone')){
			$data['dsusa_telephone'] = $this->input->post('dsusa_telephone');
		}
		$this->db->update('user_company_info', $data, array('user_id' => $id));
	}
	function get_dentists($sort,$order='ASC'){
		if($sort == 'date' || $sort == 'the_rating') $order = 'DESC';
	/*	$query = "SELECT a.email,c.*,p.*,s.page_view,pp.name AS payment_plan,(SELECT the_rating FROM bayesian_rating WHERE user_id = p.user_id) AS the_rating
				FROM user_accounts AS a, user_company_info AS c, data_locations AS l, user_personal_info AS p, user_statistics AS s, payment_plans AS pp
				WHERE a.id = c.user_id AND c.user_id = p.user_id AND p.user_id = s.user_id AND pp.id = a.plan_id AND c.zip = l.zip_code ORDER BY {$sort} {$order}"; */
		$query = "SELECT a.email,c.*,p.*,s.page_view,pp.name AS payment_plan,(SELECT the_rating FROM bayesian_rating WHERE user_id = p.user_id) AS the_rating
				FROM user_accounts AS a, user_company_info AS c,user_personal_info AS p, user_statistics AS s, payment_plans AS pp
				WHERE a.id = c.user_id AND c.user_id = p.user_id AND p.user_id = s.user_id AND pp.id = a.plan_id ORDER BY {$sort} {$order}";
		$res = $this->db->query($query);
		return $res->result_array();
	}
	function dentist_search($search,$distance,$sort='the_distance'){
		$order = 'ASC';
		if($sort == 'the_rating') $order = 'DESC';
		
		if(is_numeric($search)){
			$search_query = 'c.zip = ?';
			$coord_search_zip = $search;
		}else{
			$search = explode(':',$search);
			if(count($search) > 1){
				if(strlen($search[1]) > 2){
					$search_where = array('city_name' => strtoupper($search[0]),'state_long' => $search[1]);
				}else{
					$search_where = array('city_name' => strtoupper($search[0]),'state_abbr' => strtoupper($search[1]));
				}
			}else{
				if(strlen($search[0]) == 2){
					$search_where = array('state_abbr' => strtoupper($search[0]));
				}else{
					$search_where = array('city_name' => strtoupper($search[0]));
				}
			}
			$this->db->select('zip_code');
			$res = $this->db->get_where('data_locations', $search_where);
		//	print_r($this->db->last_query());
			$zips = $res->result_array();
			if(!$zips){
				return FALSE;
			}else{
				$coord_search_zip = $zips[0]['zip_code'];
				$search_query = 'c.zip IN(';
				foreach($zips AS $zip){
					$search_query .= "{$zip['zip_code']},";
				}
				$search_query = substr($search_query,0,-1).')';
			}
		}
		$distance_query = NULL;
		$distance_select = NULL;
		if($distance){
			$this->db->select('longitude,latitude');
			$res = $this->db->get_where('data_locations', array('zip_code' => $coord_search_zip));
			$coord = $res->row_array();
			if(!$coord){
				return FALSE;
			}else{
				$distance_query = "OR (getDistance('{$coord['latitude']}','{$coord['longitude']}', l.latitude, l.longitude) >= 0 AND getDistance('{$coord['latitude']}','{$coord['longitude']}', l.latitude, l.longitude) <= {$distance})";
			}
		}
		$query = "SELECT a.email,c.*,p.*,(SELECT the_rating FROM bayesian_rating WHERE user_id = p.user_id) AS the_rating, getDistance('{$coord['latitude']}','{$coord['longitude']}', l.latitude, l.longitude) AS the_distance
				FROM user_accounts AS a, user_company_info AS c, data_locations AS l, user_personal_info AS p
				WHERE a.id = c.user_id AND c.user_id = p.user_id AND c.zip = l.zip_code AND ({$search_query} {$distance_query})
				ORDER BY {$sort} {$order}";
		$res = $this->db->query($query,$search);
		return $res->result_array();
	}
	function delete_by_users($user_id){
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_company_info');
	}
	function filter_dentist(){
		$filters = NULL;
		if($this->input->post('last_name')){
			$filters .= "AND p.last_name LIKE '".$this->input->post('last_name')."%'";
		}
		if($this->input->post('first_name')){
			$filters .= "AND p.first_name LIKE '".$this->input->post('first_name')."%'";
		}
		if($this->input->post('city')){
			$filters .= "AND c.city = '".$this->input->post('city')."'";
		}
		if($this->input->post('state')){
			$filters .= "AND c.state = '".$this->input->post('state')."'";
		}
		if($this->input->post('zip')){
			$filters .= "AND c.zip = '".$this->input->post('zip')."'";
		}
	//	echo $filters;
		
		$query = "SELECT a.email,c.*,p.*,s.page_view,pp.name AS payment_plan,(SELECT the_rating FROM bayesian_rating WHERE user_id = p.user_id) AS the_rating
				FROM user_accounts AS a, user_company_info AS c,user_personal_info AS p, user_statistics AS s, payment_plans AS pp
				WHERE a.id = c.user_id AND c.user_id = p.user_id AND p.user_id = s.user_id AND pp.id = a.plan_id {$filters} ORDER BY p.last_name";
		$res = $this->db->query($query);
		return $res->result_array();
	}
}