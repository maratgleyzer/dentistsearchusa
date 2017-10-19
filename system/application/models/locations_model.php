<?php

class Locations_Model extends Model {
	function locations_model(){
		parent::Model();
		$this->load->database();		
	}
	function get_like_city($key,$limit){
		$this->db->cache_off();
		$this->db->distinct();
		$this->db->select('city_name,state_abbr');
		$this->db->like('city_name',$key,'after'); 
		$this->db->order_by("city_name","ASC");
		if($limit)$this->db->limit($limit);
		$res = $this->db->get("data_locations");
		return $res->result_array();
	}
	function get_like_zip($key,$limit){
		$this->db->cache_off();
		$this->db->select('zip_code,state_abbr,city_name');
		$this->db->like('zip_code',$key,'after'); 
		$this->db->order_by("zip_code","ASC");
		if($limit)$this->db->limit($limit);
		$res = $this->db->get("data_locations");
		return $res->result_array();
	}
	function get_like_state($key,$limit){
		$this->db->cache_off();
		$this->db->distinct();
		$this->db->select('state_long,state_abbr');
		$this->db->like('state_long',$key,'after'); 
		$this->db->order_by("state_long","ASC");
		if($limit)$this->db->limit($limit);
		$res = $this->db->get("data_locations");
		return $res->result_array();
	}
	function get_long_lat($zip){
		$this->db->cache_off();
		$this->db->select('longitude,latitude');
		$res = $this->db->get_where("data_locations", array('zip_code' => $zip));
		return $res->row_array();
	}
	function get_city_zips($search){
		$this->db->cache_on();
		$search = explode(':',$search);
		if(count($search) > 1){
			$search_where = array('city_name' => strtoupper($search[0]),'state_abbr' => strtoupper($search[1]));
		}else{
			if(strlen($search[0]) == 2){
				$search_where = array('state_abbr' => strtoupper($search[0]));
			}else{
				$search_where = array('city_name' => strtoupper($search[0]));
			}
		}
		$this->db->select('zip_code,city_name,state_long');
		$this->db->order_by("zip_code","ASC");
		$res = $this->db->get_where('data_locations', $search_where);
		return $res->result_array();
	}
	function get_zip_city($zipcode){
		$this->db->cache_on();
		$this->db->select('city_name,state_long,state_abbr');
		$res = $this->db->get_where('data_locations', array('zip_code' => $zipcode));
		return $res->row_array();
	}
	function get_states(){
		$this->db->cache_off();
	//	$this->db->distinct();
		$this->db->select('state_long,state_abbr');
		$this->db->order_by("state_long","ASC");
		$res = $this->db->get_where("data_states", array('disabled' => 0));
		return $res->result_array();
	}
	function check_zip($search){
		$this->db->cache_on();
		$res = $this->db->query('SELECT longitude, latitude FROM data_locations WHERE zip_code = ?',$search);
		$result = $res->row_array();
	//	print_r($this->db->last_query());
		
		if($result){
			return $result;
		}else{
			return FALSE;
		}
	}
	function check_state($search){
		$this->db->cache_on();
		$lat = $this->db->query('SELECT TRUNCATE(AVG(DISTINCT(latitude)),2) AS avg_latitude FROM data_locations WHERE state_abbr = ?', $search);
		$thelat = $lat->row_array();
		
		$long = $this->db->query('SELECT TRUNCATE(AVG(DISTINCT(longitude)),2) AS avg_longitude FROM data_locations WHERE state_abbr = ?', $search);
		$thelong = $long->row_array();
	//	print_r($this->db->last_query());
		
		$result = array(
			'avg_latitude' => $thelat['avg_latitude'],
			'avg_longitude' => $thelong['avg_longitude']
		);
		if($result){
			return $result;
		}else{
			return FALSE;
		}
	}
	function check_city($search){
		$this->db->cache_on();
		if(strlen($search[1]) == 2){
			$state = 'state_abbr';
		}else{
			$state = 'state_long';
		}
		$lat = $this->db->query('SELECT TRUNCATE(AVG(DISTINCT(latitude)),2) AS avg_latitude FROM data_locations WHERE city_name = ? AND '.$state.' = ?', array($search[0],$search[1]));
		$thelat = $lat->row_array();
		
		$long = $this->db->query('SELECT TRUNCATE(AVG(DISTINCT(longitude)),2) AS avg_longitude FROM data_locations WHERE city_name = ? AND '.$state.' = ?', array($search[0],$search[1]));
		$thelong = $long->row_array();
	
		//print_r($this->db->last_query());
		
		$result = array(
			'avg_latitude' => $thelat['avg_latitude'],
			'avg_longitude' => $thelong['avg_longitude']
		);
		
		if($thelat['avg_latitude']){
			return $result;
		}else{
			return FALSE;
		}
	}
	function get_state_abbr_by_zip($zip){
		$this->db->cache_off();
		$this->db->select('state_abbr');
		$this->db->where("zip_code = '{$zip}'");
		$res = $this->db->get('data_locations');
		return $res->row_array();
	}
	function get_citypop_and_count_by_state($state){
		$this->db->cache_on();
		$this->db->where("state_abbr = '{$state}' AND (user_count > 0 OR city_population >= 5000)");
		$this->db->order_by('user_count DESC, city_population DESC');
		$this->db->limit('24');
		$res = $this->db->get('user_count_and_city_population');
		return $res->result_array();
	}
	function get_more_cities_by_state($state){
		$this->db->cache_on();
		$this->db->where("state_abbr = '{$state}' AND (user_count > 0 OR city_population >= 5000)");
		$this->db->order_by('user_count DESC, city_population DESC');
		$this->db->limit('96','24');
		$res = $this->db->get('user_count_and_city_population');
		return $res->result_array();
	}
	function get_cities_by_population(){
		$this->db->cache_on();
		$this->db->where("(user_count > 0 OR city_population >= 5000)");
		$this->db->order_by('city_population DESC');
		$this->db->limit('32');
		$res = $this->db->get('user_count_and_city_population');
		return $res->result_array();
	}
	function valid_state($key){
		$this->db->cache_on();
		$res = $this->db->get_where('data_states',array('state_abbr' => $key));
		return $res->num_rows();
	}
	function valid_city($key){
		$this->db->cache_on();
		$res = $this->db->get_where('data_cities',array('city_name' => $key));
		return $res->num_rows();
	}
	function valid_state_name($key){
		$this->db->cache_on();
		$res = $this->db->get_where('data_states',array('REPLACE(state_long,\'.\',\'\')' => $key));
		if($res->row()){
			return $res->row_array();
		}else{
			return false;
		}
	}
}