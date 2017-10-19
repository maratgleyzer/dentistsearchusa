<?php

class Company_Info_Model extends Model {
/********
//	20 miles in meters
	$range = 32186.88; //units from origin
	$limit = 100; //stores to find
//	69 miles in meters
	$max_lat = ceil($lat + ($range/111044.736)*10000000);
	$min_lat = ceil($lat - ($range/111044.736)*10000000);
	$max_lon = ceil($lon + ($range/abs(cos(deg2rad($lat/10000000))*111044.736))*10000000);
	$min_lon = ceil($lon - ($range/abs(cos(deg2rad($lat/10000000))*111044.736))*10000000);

	if (!$dis) $dis = '0';
	
$pythagoras_eq =
"
((SQRT(POWER(($lat - s.store_lat), 2) + POWER(($lon - s.store_lon), 2)) / 10000000) * 102536.7638)
";
// or maybe 0.001025367638
//63.7133912 miles for equation

$haverstine_eq =
"
(6366.564864 * 2 * ASIN(SQRT(POWER(SIN(($lat/10000000 - abs(s.store_lat/10000000)) * pi()/180 / 2), 2)
 + COS($lat/10000000 * pi()/180 ) * COS(abs(s.store_lat/10000000) * pi()/180)
 * POWER(SIN(($lon/10000000 - s.store_lon/10000000) * pi()/180 / 2), 2) )))
";
//3956 radius of earth
****************/
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
			'company_email' => $this->input->post('company_email'),
			'featured' => $this->input->post('featured'),
			'latitude' => $_POST['latitude'],
			'longitude' => $_POST['longitude']
        );
		if($this->input->post('dsusa_telephone')){
			$data['dsusa_telephone'] = $this->input->post('dsusa_telephone');
		}
		$this->db->update('user_company_info', $data, array('user_id' => $id));
		if (($data['latitude'] <> 0) && ($data['longitude'] <> 0))
			return TRUE;
		else return FALSE;
	}
	function get_dentists($sort,$start,$limit,$search=array()){
		$this->db->cache_off();
		$order = 'ASC'; $where = '';
		if (isset($search['zip'])) {
			$where .= (strlen($search['zip']) < 5 ?
			'AND c.zip LIKE "'.$search['zip'].'%"' :
			'AND c.zip = "'.$search['zip'].'"' );
		}
		if (isset($search['city'])) {
			if (isset($search['state']))
				$where .= 'AND c.city = "'.$search['city'].'"';
			else $where .= 'AND c.city LIKE "'.$search['city'].'%"';
		}
		if (isset($search['state'])) {
			$where .= 'AND c.state = "'.$search['state'].'"';
		}
		if (isset($search['first'])) {
			$where .= 'AND p.first_name = "'.$search['first'].'"';
		}
		if (isset($search['last'])) {
			$where .= 'AND p.last_name = "'.$search['last'].'"';
		}
		if (isset($search['name'])) {
			$where .= 'AND (p.first_name LIKE "'.$search['name'].'%" OR p.last_name LIKE "'.$search['name'].'%")';
		}
		if($sort == 'date' || $sort == 'the_rating') $order = 'DESC';
	/*	$query = "SELECT a.email,c.*,p.*,s.page_view,pp.name AS payment_plan,(SELECT the_rating FROM bayesian_rating WHERE user_id = p.user_id) AS the_rating
				FROM user_accounts AS a, user_company_info AS c, data_locations AS l, user_personal_info AS p, user_statistics AS s, payment_plans AS pp
				WHERE a.id = c.user_id AND c.user_id = p.user_id AND p.user_id = s.user_id AND pp.id = a.plan_id AND c.zip = l.zip_code ORDER BY {$sort} {$order}"; */
		$query = "SELECT a.email,a.status,c.*,p.*,s.page_view,pp.name AS payment_plan,(SELECT the_rating FROM bayesian_rating WHERE user_id = p.user_id) AS the_rating
				FROM user_accounts AS a, user_company_info AS c,user_personal_info AS p, user_statistics AS s, payment_plans AS pp
				WHERE a.id = c.user_id AND c.user_id = p.user_id AND p.user_id = s.user_id AND pp.id = a.plan_id {$where} ORDER BY {$sort} {$order}";
		$rescount = $this->db->query($query);
		$res = $this->db->query($query." LIMIT {$start},{$limit}");
		return array(
			'result' => $res->result_array(),
			'count' => $rescount->num_rows()
		);
	}
	function dentist_search($search,$distance,$sort='the_distance',$start,$limit,$excluded_ids=FALSE){
		$this->db->cache_on();
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
		$not_in = '';
		if(is_array($excluded_ids)){
			$not_in = "AND c.user_id NOT IN ('".implode($excluded_ids,"', '")."')";
		}
		$query =
"
SELECT a.id, a.email, c.*, p.*,
(SELECT the_rating FROM bayesian_rating WHERE user_id = p.user_id) AS the_rating,
getDistance('{$coord['latitude']}','{$coord['longitude']}', l.latitude, l.longitude) AS the_distance
FROM user_personal_info AS p, user_company_info AS c, user_accounts AS a, data_locations AS l
WHERE ({$search_query} {$distance_query}) {$not_in} AND c.user_id = p.user_id AND c.user_id = a.id AND c.zip = l.zip_code AND a.status > 0
ORDER BY {$sort} {$order} LIMIT {$start}, {$limit}
";
		$res = $this->db->query($query,$search);
	//	echo $this->db->last_query();
	//	$total_rows_count = $this->db->query('SELECT FOUND_ROWS() AS total_count');
	//	$total_rows_count = $total_rows_count->row_array();
	//	$total_rows_count = $total_rows_count['total_count'];
		$results = $res->result_array();

		$query =
"
SELECT COUNT(a.id) as total_count
FROM user_personal_info AS p, user_company_info AS c, user_accounts AS a, data_locations AS l
WHERE ({$search_query} {$distance_query}) {$not_in} AND c.user_id = p.user_id AND c.user_id = a.id AND c.zip = l.zip_code AND a.status > 0
";
		$tot = $this->db->query($query,$search);
		$total = $tot->result_array();
		$total_rows_count = $total[0]['total_count'];

	//	die('done here');
		return array(
			'result' => $results,
			'count' => $total_rows_count
		);
	}
	function featured_dentist_search($search,$distance,$sort='the_distance',$start,$limit){
		$this->db->cache_off();
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
		$query =
"
SELECT a.id, a.email, c.*, p.*,
(SELECT the_rating FROM bayesian_rating WHERE user_id = p.user_id) AS the_rating,
getDistance('{$coord['latitude']}','{$coord['longitude']}', l.latitude, l.longitude) AS the_distance
FROM user_personal_info AS p, user_company_info AS c, user_accounts AS a, data_locations AS l
WHERE c.featured > 0 AND ({$search_query} {$distance_query})
  AND c.user_id = p.user_id AND c.user_id = a.id AND c.zip = l.zip_code AND a.status > 0
ORDER BY c.featured_rand ASC
";
		$res = $this->db->query($query." LIMIT {$start},{$limit}",$search);
	//	echo $this->db->last_query();
		$results = $res->result_array();
		
		$id_array = '';
		foreach ($results as $result) {
			$this->db->update('user_company_info',
			array('featured_rand' => rand(100001, 999999)),
			array('user_id' => $result['user_id']));
			$id_array[] = $result['user_id']; 
		}
		
	//	die('done here');
		return array(
			'result' => $results,
			'count' => $limit,
			'id_array' => $id_array
		);
	}
	function delete_by_users($user_id){
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_company_info');
	}
	function filter_dentist(){
		$this->db->cache_off();
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
				WHERE a.id = c.user_id AND c.user_id = p.user_id AND p.user_id = s.user_id AND pp.id = a.plan_id AND a.status > 0 {$filters} ORDER BY p.last_name";

		$res = $this->db->query($query);
		return $res->result_array();
	}
}