<?php
class Dentist extends Controller{

	function Dentist(){
		parent::Controller();
		$this->load->model('Specialty_Model');
		$this->load->model('Locations_Model');
		$this->load->model('Personal_Info_Model');
		$this->load->model('Company_Info_Model');
		$this->load->model('Dashboard_Info_Model');
		$this->load->model('Accounts_Model');
		$this->load->model('Reviews_Model');
		$this->load->model('Certifications_Model');
		$this->load->model('Files_Model');
		$this->load->model('Images_Model');
		$this->load->model('Appointment_model');
		$this->load->model('Statistics_Model');
		$this->load->model('Event_scheduler_model');
		$this->load->model('Social_Media_Model');
		$this->load->model('Seo_Model');
		$this->load->model('Email_Model');
		$this->load->model('Choices_Model');
		$this->load->model('Advertisements_Model');
		$this->load->model('Promotionals_Model');
		$this->load->model('Pre_Registrations_Model');
		$this->load->model('Payments_Model');
	
		$this->load->helper('form');
		$this->load->helper('string');
		$this->load->helper('security');
		$this->load->helper('my_image');
		$this->load->helper('download');
		
		$this->load->library('form_validation');
		$this->load->library('googlemaps');
	//	set_time_limit(0); 
	}
	function index(){
		$this->search(NULL);
	}
	function seo_profile(){
		$key = $this->uri->segment(2);
		$keys = explode('-',$key);
		$last_key = end($keys);
		$this->profile($last_key);
	}
	function seo_search(){
		$distance = $this->uri->segment(2);
		$distance = str_replace('-miles','',$distance);
		if(!$distance){
			$distance = 5;
		}
		
		$paging = $this->uri->segment(3);
		if($paging){
			$paging = str_replace('index-','',$paging);
			$paging = str_replace('limit-','',$paging);
			$paging = explode('-',$paging);
			$search_start = intval($paging[0]) * intval($paging[1]);
			$search_limit = $paging[1];
		}else{
			$search_start = 0;
			$search_limit = 10;
		}
		
		$key = $this->uri->segment(1);
		$key = str_replace('-dentists','',$key);
		$keys = explode('-',$key);
		$last_key = end($keys);
		$city_key = substr($key, 0, -3);
		$city_key = str_replace('-',' ',$city_key);
		$state_key = str_replace('-',' ',$key);		
		
		if(!is_numeric($last_key)){ //treat search as state or city
			$valid_state = $this->Locations_Model->valid_state($last_key);
			$valid_city = $this->Locations_Model->valid_city($city_key);
			$valid_state_name = $this->Locations_Model->valid_state_name($state_key);
			
			if($valid_state_name){//do a state search
				$this->search($valid_state_name['state_abbr'],$distance,$search_start,$search_limit);
			}else if($valid_city && $valid_state){//do a city search
				$this->search($city_key.':'.$last_key,$distance,$search_start,$search_limit);
			}else{//search is invalid but just do the search anyway
				$this->search($state_key,$distance,$search_start,$search_limit);
			}
		}else{ //treat search as zip
			$this->search($last_key,$distance,$search_start,$search_limit);
		}
	}
	function get_prof_pic($id) {
		if ($id < 100) { return 'zero/'.$id; }
		else { return round($id, -2).'/'.$id; }
	}
	function ajax_more_cities() {

		if ($this->uri->segment(3) == 'state') {
			$state = $this->uri->segment(4);
			$cities = $this->Locations_Model->get_more_cities_by_state($state);
			$city_list = $this->get_other_cities($cities);
			echo $city_list;
		} else { echo 'nothing here jack!'; }

	}
	function ajax_search($search=null,$distance=5){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$search = $this->input->post('search');
			$distance = $this->input->post('distance');
			$sort = $this->input->post('sort');
			$page_start = $this->input->post('page_start');
			$page_limit = $this->input->post('page_limit');
		}
		preg_match('/,/',$search,$comma_match);
		if(count($comma_match)){
			$search = str_replace(',',':',$search);
		}else{
			$search = $this->is_last_string_state($search);
		}
		$search = preg_replace("/\s*:\s*/",":", $search);
		
		$search_type = $this->get_search_type($search);
		if($search_type['type'] == 'city' && $distance <= 20){
			$distance = $search_type['distance'];
		}

		$dentists_featured = $this->Seo_Model->get_dentists_featured();

		$featured = $this->Company_Info_Model->featured_dentist_search($search,$distance,$sort,'0',$dentists_featured);
		$dentists = $this->Company_Info_Model->dentist_search($search,$distance,$sort,$page_start,$page_limit,$featured['id_array']);
		$total_rows = $dentists['count'];
		$dentists = $dentists['result'];
		$total_featured = $featured['count'];
		$featured = $featured['result'];

		switch($distance){
			case ($distance <= 5):
				$zoom_level = 12;
			break;
			case ($distance <= 10):
				$zoom_level = 11;
			break;
			case ($distance <= 30):
				$zoom_level = 10;
			break;
			case ($distance <= 50):
				$zoom_level = 9;
			break;
			case ($distance <= 100):
				$zoom_level = 8;
			break;
			case ($distance <= 200):
				$zoom_level = 7;
			break;
			case ($distance <= 400):
				$zoom_level = 6;
			break;
			case ($distance <= 800):
				$zoom_level = 5;
			break;
			case ($distance <= 1000):
				$zoom_level = 4;
			break;
			default:
				$zoom_level = 12;
			break;
		}
		if($search_type['type'] == 'zip'){
			$search_option = $this->Locations_Model->get_zip_city($search);
			$the_search_option = '<label ><a style="cursor:pointer;" onclick="search_option(\''.cap_first_letter($search_option['city_name']).', '.$search_option['state_abbr'].'\')">Show all dentists in '.cap_first_letter($search_option['city_name']).', '.$search_option['state_long'].'</a></label>';
		}else{
			$search_option = $this->Locations_Model->get_city_zips($search);
			$the_search_option = '<label for="lb10">by zip code:</label>
										<select onchange="search_option(this.value)" id="lb10" class="sel">
											<option>- - Select - -</option>';
			foreach($search_option AS $zip){
				$the_search_option .= '<option>'.$zip['zip_code'].'</option>';
			}
			$the_search_option .= '</select>';
		}
		if($search_type['type'] == 'state' || $search_type['type'] == 'invalid'){
			$distance = $search_type['distance'];
			$zoom_level = $search_type['zoom'];
		}
		switch($search_type['type']){
			case 'state':
				$h2label  = strtoupper($search_option[0]['state_long']).' DENTISTS';
				$h3label  = strtoupper($search_option[0]['state_long']);
				
				$other_cities_res = $this->Locations_Model->get_citypop_and_count_by_state($search);
				$other_cities = $this->get_other_cities($other_cities_res);
				$active_state = $search;
				$has_cities = $this->has_cities;
			break;
			case 'zip':
				$h2label  = $search_option['city_name'].' DENTISTS';
				$h3label  = $search_option['city_name'];
				
				$other_cities_res = $this->Locations_Model->get_citypop_and_count_by_state($search_option['state_abbr']);
				$other_cities = $this->get_other_cities($other_cities_res);
				$active_state = $search_option['state_abbr'];
				$has_cities = $this->has_cities;
			break;
			case 'city':
				$h2label = $search_option[0]['city_name'].' DENTISTS';
				$h3label = $search_option[0]['city_name'];
				
				$keys = explode(':',$search);
				$other_cities_res = $this->Locations_Model->get_citypop_and_count_by_state($keys[1]);
				$other_cities = $this->get_other_cities($other_cities_res);
				$active_state = $keys[1];
				$has_cities = $this->has_cities;
			break;
			default:
				$h2label = 'DENTISTS';
				$h3label = strtoupper($search);
				
				$other_cities = $this->get_other_cities(FALSE);
				$active_state = '';
				$has_cities = $this->has_cities;
			break;
		}
		
		$search_result_text = $this->Seo_Model->get_search_result_text();
		$search_result_title = str_replace('%searchname%',ucwords(strtolower($h2label)),$search_result_text['search_result_title']);
		$search_result_text = $search_result_text['search_result_text'];

		$content = '';
		$markers = NULL;

		if($dentists_featured > 0){
		$content .= '<div id="featured_dentists_header">FEATURED DENTISTS</div><ul class="offices-list" style="min-height:30px;">';
		$i = 1;
		if($featured){
			foreach($featured AS $dentist){
				$markers[] = array(
					'icon' => base_url().'assets/images/red_marker/'.$i.'.png',
					'position' => (is_numeric($dentist['latitude']) && is_numeric($dentist['longitude']) ? array($dentist['latitude'], $dentist['longitude']) : $this->googlemaps->get_lat_long_from_address("{$dentist['address']}, {$dentist['city']}, {$dentist['state']} {$dentist['zip']}, USA")),
				$this->googlemaps->get_lat_long_from_address("{$dentist['address']}, {$dentist['city']}, {$dentist['state']} {$dentist['zip']}, USA"),
					'details' => "
								".ret_alt_echo(company_output($dentist['first_name'],$dentist['last_name'],$dentist['company_name']),'','',' :')."<br/>
								{$dentist['first_name']} {$dentist['last_name']} {$dentist['post_nominal']} <br/>
								{$dentist['address']},<br/>{$dentist['city']}, {$dentist['state']} {$dentist['zip']}, USA <br>
								<a href='/".prep_seo_url($dentist['city']).'-'.prep_seo_url($dentist['state'])."-dentists/".prep_seo_url($dentist['first_name'])."-".prep_seo_url($dentist['last_name'])."-".$dentist['id']."' class='marker_details' ><img style='display:inline;margin-bottom:-4px;' src='".base_url()."assets/images/admin/vcard.png'>&nbsp; View Profile</a>"
				);
				$prof_pic = $dentist['prof_pic'];
				if($prof_pic){
					$dir = ($dentist['user_id'] < 100 ? 'zero' : round($dentist['user_id'], -2));
					$picvid = explode(".",$prof_pic);
					if($picvid[count($picvid)-1]=="flv"){
						$photo = '<a class="flv_player" href="/user_assets/prof_images/'.$dir.'/'.$dentist['user_id'].'/flash.flv" rel="shadowbox;width=600;height=450"><img src="'.base_url().'user_assets/prof_images/playvid_small.gif" alt="image" width="85" height="85" /></a>';
					}else{
						$photo = '<a href="/'.prep_seo_url($dentist['city']).'-'.prep_seo_url($dentist['state']).'-dentists/'.prep_seo_url($dentist['first_name']).'-'.prep_seo_url($dentist['last_name']).'-'.$dentist['id'].'"><img src="'.base_url().'user_assets/prof_images/'.$dir.'/'.$dentist['user_id'].'/thumb.jpg" alt="image" /></a>';
					}
				}else{
					$photo = '<a href="/'.prep_seo_url($dentist['city']).'-'.prep_seo_url($dentist['state']).'-dentists/'.prep_seo_url($dentist['first_name']).'-'.prep_seo_url($dentist['last_name']).'-'.$dentist['id'].'"><img src="'.base_url().'assets/themes/default/images/no_photo_small.png" alt="image" width="85" height="85" /></a>';
				}
				$content .= '<li>
								<div class="photo">
								<div class="featured_flag">&nbsp;</div>
									'.$photo.'
								</div>
								<div class="info-holder">
									<div class="text-hold">
										<span class="number"><img alt="'.$i.'" src="'.base_url().'assets/images/red_marker/'.$i.'.png" /></span>
										<div class="text">
											<h3 class="ttl"><a href="/'.prep_seo_url($dentist['city']).'-'.prep_seo_url($dentist['state']).'-dentists/'.prep_seo_url($dentist['first_name']).'-'.prep_seo_url($dentist['last_name']).'-'.$dentist['id'].'">'.ret_alt_echo(company_output($dentist['first_name'],$dentist['last_name'],$dentist['company_name']),'','',' :').' '.$dentist['first_name'].' '.$dentist['last_name'].' '.$dentist['post_nominal'].'</a></h3>
											<address>
												<span>'.$dentist['address'].'</span>
												<span>'.$dentist['city'].', '.$dentist['state'].' '.$dentist['zip'].'</span>
											</address>
											<div class="rate"><span class="stars">'.get_star_rating($dentist['the_rating'],true).'</span></div>
										</div>
									</div>
									<div class="info-b">
										<ul class="menu">
											<li><a onclick="center_location(\''.$dentist['address'].', '.$dentist['city'].', '.$dentist['state'].' '.$dentist['zip'].'\')" style="cursor:pointer;">view on map</a></li>
											<li><a href="/'.prep_seo_url($dentist['city']).'-'.prep_seo_url($dentist['state']).'-dentists/'.prep_seo_url($dentist['first_name']).'-'.prep_seo_url($dentist['last_name']).'-'.$dentist['id'].'">view profile</a></li>
										</ul>
										<dl>
											<dt>Tel:</dt>
											<dd>'.ret_alt_echo($dentist['dsusa_telephone'],$dentist['telephone']).'</dd>
										</dl>
									</div>
								</div>
							</li>';
				$i++;
			}
		}else{
			$search = str_replace(':',', ',$search);
			$content .= "<div id='no_results'>No Results Found for \"<label>{$search}</label>\"</div>";
		}
		$content .= '</ul>';
		$content .= '<div id="other_dentists_header">OTHER DENTISTS</div>';
		}
		$content .= '<ul class="offices-list">';
		$i = 1;
		if($dentists){
			foreach($dentists AS $dentist){
				$markers[] = array(
					'icon' => base_url().'assets/images/green_marker/'.$i.'.png',
					'position' => (is_numeric($dentist['latitude']) && is_numeric($dentist['longitude']) ? array($dentist['latitude'], $dentist['longitude']) : $this->googlemaps->get_lat_long_from_address("{$dentist['address']}, {$dentist['city']}, {$dentist['state']} {$dentist['zip']}, USA")),
					'details' => "
								".ret_alt_echo(company_output($dentist['first_name'],$dentist['last_name'],$dentist['company_name']),'','',' :')."<br/>
								{$dentist['first_name']} {$dentist['last_name']} {$dentist['post_nominal']} <br/>
								{$dentist['address']},<br/>{$dentist['city']}, {$dentist['state']} {$dentist['zip']}, USA <br>
								<a href='/".prep_seo_url($dentist['city']).'-'.prep_seo_url($dentist['state'])."-dentists/".prep_seo_url($dentist['first_name'])."-".prep_seo_url($dentist['last_name'])."-".$dentist['id']."' class='marker_details' ><img style='display:inline;margin-bottom:-4px;' src='".base_url()."assets/images/admin/vcard.png'>&nbsp; View Profile</a>"
				);
				$prof_pic = $dentist['prof_pic'];
				if($prof_pic){
					$dir = ($dentist['user_id'] < 100 ? 'zero' : round($dentist['user_id'], -2));
					$picvid = explode(".",$prof_pic);
					if($picvid[count($picvid)-1]=="flv"){
						$photo = '<a class="flv_player" href="/user_assets/prof_images/'.$dir.'/'.$dentist['user_id'].'/flash.flv" rel="shadowbox;width=600;height=450"><img src="'.base_url().'user_assets/prof_images/playvid_small.gif" alt="image" width="85" height="85" /></a>';
					}else{
						$photo = '<a href="/'.prep_seo_url($dentist['city']).'-'.prep_seo_url($dentist['state']).'-dentists/'.prep_seo_url($dentist['first_name']).'-'.prep_seo_url($dentist['last_name']).'-'.$dentist['id'].'"><img src="'.base_url().'user_assets/prof_images/'.$dir.'/'.$dentist['user_id'].'/thumb.jpg" alt="image" /></a>';
					}
				}else{
					$photo = '<a href="/'.prep_seo_url($dentist['city']).'-'.prep_seo_url($dentist['state']).'-dentists/'.prep_seo_url($dentist['first_name']).'-'.prep_seo_url($dentist['last_name']).'-'.$dentist['id'].'"><img src="'.base_url().'assets/themes/default/images/no_photo_small.png" alt="image" width="85" height="85" /></a>';
				}
				$content .= '<li>
								<div class="photo">
									'.$photo.'
								</div>
								<div class="info-holder">
									<div class="text-hold">
										<span class="number"><img alt="'.$i.'" src="'.base_url().'assets/images/green_marker/'.$i.'.png" /></span>
										<div class="text">
											<h3 class="ttl"><a href="/'.prep_seo_url($dentist['city']).'-'.prep_seo_url($dentist['state']).'-dentists/'.prep_seo_url($dentist['first_name']).'-'.prep_seo_url($dentist['last_name']).'-'.$dentist['id'].'">'.ret_alt_echo(company_output($dentist['first_name'],$dentist['last_name'],$dentist['company_name']),'','',' :').' '.$dentist['first_name'].' '.$dentist['last_name'].' '.$dentist['post_nominal'].'</a></h3>
											<address>
												<span>'.$dentist['address'].'</span>
												<span>'.$dentist['city'].', '.$dentist['state'].' '.$dentist['zip'].'</span>
											</address>
											<div class="rate"><span class="stars">'.get_star_rating($dentist['the_rating'],true).'</span></div>
										</div>
									</div>
									<div class="info-b">
										<ul class="menu">
											<li><a onclick="center_location(\''.$dentist['address'].', '.$dentist['city'].', '.$dentist['state'].' '.$dentist['zip'].'\')" style="cursor:pointer;">view on map</a></li>
											<li><a href="/'.prep_seo_url($dentist['city']).'-'.prep_seo_url($dentist['state']).'-dentists/'.prep_seo_url($dentist['first_name']).'-'.prep_seo_url($dentist['last_name']).'-'.$dentist['id'].'">view profile</a></li>
										</ul>
										<dl>
											<dt>Tel:</dt>
											<dd>'.ret_alt_echo($dentist['dsusa_telephone'],$dentist['telephone']).'</dd>
										</dl>
									</div>
								</div>
							</li>';
				$i++;
			}
		}else{
			$search = str_replace(':',', ',$search);
			$content .= "<div id='no_results'>No Results Found for \"<label>{$search}</label>\"</div>";
		}
		$content .= '</ul>';
		$res = array(
			'success' => TRUE,
			'content' => $content,
			'markers' => $markers,
			'total_featured' => $total_featured,
			'type'	=> $search_type['type'],
			'long'	=> $search_type['long'],
			'lat'	=> $search_type['lat'],
			'distance' => $distance,
			'zoom'	=> $zoom_level,
			'search_option' => $the_search_option,
			'h2_label' => $h2label,
			'search_result_title' => $search_result_title,
			'search_result_text' => $search_result_text,
			'other_cities' => $other_cities,
			'active_state' => $active_state,
			'has_cities' => $has_cities,
			'total_rows_count' => $total_rows
		);
		print json_encode($res);
	}
	function geolocate() {
		//$sql = 'select id, address, city, state, zip, latitude, longitude from user_company_info where (latitude = NULL OR latitude = 0) order by id ASC';
		$sql = 'select id, address, city, state, zip, latitude, longitude from user_company_info where id IN (411, 763, 800) order by id ASC';
		$res = $this->db->query($sql);
		$results = $res->result_array();
		foreach ($results as $result) {
			if (is_null($result['latitude']) || ($result['latitude'] == '0') || ($result['latitude'] == '')) {
				$lat_lon = $this->googlemaps->get_lat_long_from_address("{$result['address']}, {$result['city']}, {$result['state']} {$result['zip']}, USA");
				if (($lat_lon[0] != '0') && ($lat_lon[0] != 0)) {
					$sql = 'update user_company_info set latitude = "'.$lat_lon[0].'", longitude = "'.$lat_lon[1].'" where id = '.$result['id'];
					$this->db->query($sql);
				}
				time_sleep_until(microtime(true)+2);
			}
		}
	}
	function search($search=null,$distance=5,$search_start=0,$limit_per_page =10){
		$post_search = 0;//FALSE
		if(!$search){
			$post_search = 1;//TRUE
			$search = $this->input->post('search_value');
			preg_match('/,/',$search,$comma_match);
			if(count($comma_match)){
				$search = str_replace(',',':',$search);
			}else{
				$search = $this->is_last_string_state($search);
			}
			$search = preg_replace("/\s*:\s*/",":", $search);
			if($this->input->post('search_distance')){
				$distance = $this->input->post('search_distance');
			}
		}
		if(!is_numeric($distance)) $distance = 5;
		if($distance > 150) redirect("/dentist/search/{$search}/150");
		$search = str_replace('_',' ',$search);
		
		$search_type = $this->get_search_type($search);
		if($search_type['type'] == 'city' && $distance <= 20){
			$distance = $search_type['distance'];
		}
		
		$dentists_featured = $this->Seo_Model->get_dentists_featured();

		$featured = $this->Company_Info_Model->featured_dentist_search($search,$distance,'the_distance','0',$dentists_featured);
		$dentists = $this->Company_Info_Model->dentist_search($search,$distance,'the_distance',$search_start,$limit_per_page,$featured['id_array']);
		$total_rows = $dentists['count'];
		$dentists = $dentists['result'];
		$featured = $featured['result'];

		switch($distance){
			case ($distance <= 5):
				$zoom_level = 12;
			break;
			case ($distance <= 10):
				$zoom_level = 11;
			break;
			case ($distance <= 30):
				$zoom_level = 10;
			break;
			case ($distance <= 50):
				$zoom_level = 9;
			break;
			case ($distance <= 100):
				$zoom_level = 8;
			break;
			case ($distance <= 200):
				$zoom_level = 7;
			break;
			case ($distance <= 400):
				$zoom_level = 6;
			break;
			case ($distance <= 800):
				$zoom_level = 5;
			break;
			case ($distance <= 1000):
				$zoom_level = 4;
			break;
			default:
				$zoom_level = 12;
			break;
		}
		
		$coord_lat = $search_type['lat'];
		$coord_long = $search_type['long'];
		
		if($search_type['type'] == 'state' || $search_type['type'] == 'invalid'){
			$distance = $search_type['distance'];
			$zoom_level = $search_type['zoom'];
		}
		if(!$featured){
			$featured = array();
		}
		if(!$dentists){
			$dentists = array();
		}
		$config = array(
			'map_div_id' => 'map_container',
			'region'	 => 'US',
			'center'	 =>	"{$coord_lat},{$coord_long}",
			'zoom'		 => $zoom_level
		);
		$this->googlemaps->initialize($config);
		$i=1;
		foreach($dentists AS $dentist){
			$marker = array(); 
			$marker['icon'] = base_url().'assets/images/green_marker/'.$i.'.png';
			if (is_numeric($dentist['latitude']) && is_numeric($dentist['longitude']))
				$marker['position'] = "{$dentist['latitude']}, {$dentist['longitude']}";
			else $marker['position'] = "{$dentist['address']}, {$dentist['city']}, {$dentist['state']} {$dentist['zip']}, USA";  
			$marker['infowindow_content'] = ret_alt_echo(company_output($dentist['first_name'],$dentist['last_name'],$dentist['company_name']),'','',' :')."<br/>{$dentist['first_name']} {$dentist['last_name']} {$dentist['post_nominal']} <br/>{$dentist['address']},<br/>{$dentist['city']}, {$dentist['state']} {$dentist['zip']}, USA<br/><a href='".base_url().prep_seo_url($dentist['city'])."-".prep_seo_url($dentist['state'])."-dentists/".prep_seo_url($dentist['first_name'])."-".prep_seo_url($dentist['last_name'])."-".$dentist['id']."' class='marker_details' ><img style='display:inline;margin-bottom:-4px;' src='".base_url()."assets/images/admin/vcard.png'>&nbsp; View Profile</a>";  
			$this->googlemaps->add_marker($marker);       
			$i++;
		}  
		$i=1;
		foreach($featured AS $dentist){
			$marker = array(); 
			$marker['icon'] = base_url().'assets/images/red_marker/'.$i.'.png';
			if (is_numeric($dentist['latitude']) && is_numeric($dentist['longitude']))
				$marker['position'] = "{$dentist['latitude']}, {$dentist['longitude']}";
			else $marker['position'] = "{$dentist['address']}, {$dentist['city']}, {$dentist['state']} {$dentist['zip']}, USA";  
			$marker['infowindow_content'] = ret_alt_echo(company_output($dentist['first_name'],$dentist['last_name'],$dentist['company_name']),'','',' :')."<br/>{$dentist['first_name']} {$dentist['last_name']} {$dentist['post_nominal']} <br/>{$dentist['address']},<br/>{$dentist['city']}, {$dentist['state']} {$dentist['zip']}, USA<br/><a href='".base_url().prep_seo_url($dentist['city'])."-".prep_seo_url($dentist['state'])."-dentists/".prep_seo_url($dentist['first_name'])."-".prep_seo_url($dentist['last_name'])."-".$dentist['id']."' class='marker_details' ><img style='display:inline;margin-bottom:-4px;' src='".base_url()."assets/images/admin/vcard.png'>&nbsp; View Profile</a>";  
			$this->googlemaps->add_marker($marker);       
			$i++;
		}
		if(is_numeric($search)){
			$search_option = $this->Locations_Model->get_zip_city($search);
		}else{
			$search_option = $this->Locations_Model->get_city_zips($search);
		}
		$head_data['video_page'] = TRUE;
		$data['limit_per_page'] = $limit_per_page;
		$data['current_page'] = $search_start / $limit_per_page;
		$data['total_rows'] = $total_rows;
		$data['search_page'] = TRUE;
		$data['post_search'] = $post_search;
		$data['seo_search_key'] = $this->uri->segment(1);
		$data['search_type'] = $search_type['type'];
		$data['search_option'] = $search_option;
		$data['dentists'] = $dentists;
		$data['featured'] = $featured;
		$data['dentists_featured'] = $dentists_featured;
		$data['map'] = $this->googlemaps->create_map($distance);
		$data['search'] = str_replace(':',', ',$search);
		$data['distance'] = $distance;
		$data['logged_in'] = $this->session->userdata('logged_in');
		$header['includes_section'] = $this->load->view('common/header/header_includes_view',$head_data,true);
		$header['menu_section'] = $this->load->view('common/header/header_menu_view',$data,true);
		$header['search_section'] = $this->load->view('common/header/searchbar/header_search_view',NULL,true);
		
		switch($search_type['type']){
			case 'state':
				$h2label  = strtoupper($search_option[0]['state_long']);
				$other_cities_res = $this->Locations_Model->get_citypop_and_count_by_state($search);
				$data['other_cities'] = $this->get_other_cities($other_cities_res);
				$data['active_state'] = $search;
				$data['has_cities'] = $this->has_cities;
			break;
			case 'zip':
				$h2label  = $search_option['city_name'];
				$other_cities_res = $this->Locations_Model->get_citypop_and_count_by_state($search_option['state_abbr']);
				$data['other_cities'] = $this->get_other_cities($other_cities_res);
				$data['active_state'] = $search_option['state_abbr'];
				$data['has_cities'] = $this->has_cities;
			break;
			case 'city':
				$h2label = $search_option[0]['city_name'];
				$keys = explode(':',$search);
				$other_cities_res = $this->Locations_Model->get_citypop_and_count_by_state($keys[1]);
				$data['other_cities'] = $this->get_other_cities($other_cities_res);
				$data['active_state'] = $keys[1];
				$data['has_cities'] = $this->has_cities;
			break;
			default:
				$h2label = strtoupper($search);
				$data['other_cities'] = $this->get_other_cities(FALSE);
				$data['active_state'] = '';
				$data['has_cities'] = FALSE;
			break;
		}
		
		$data['footer_ads'] = $this->Advertisements_Model->get_footer_ads();
		$allicons = $this->Social_Media_Model->get_all();
		$data['allicons'] = $allicons;
		$data['analytics_id'] =  $this->Seo_Model->get_analytics_id();
		$search_result_text = $this->Seo_Model->get_search_result_text();
		$data['search_result_title'] = str_replace('%searchname%',ucwords(strtolower($h2label)),$search_result_text['search_result_title']);
		$data['search_result_text'] = $search_result_text['search_result_text'];
		
		$header['seo'] = array(
			'title' => ucwords(strtolower('FIND A DENTIST IN '.$h2label.' - '.$h2label.' DENTISTS')),
			'keywords' => '',
			'description' => 'Dentist Search USA'
		);
		$this->load->view('common/header_view',$header);
		
		$this->load->view('search/dentist_search_view',$data);
		$this->load->view('popup/login_popup_view');
		$data['signup_text'] =  $this->Seo_Model->get(10);
		$data['dropdown_choices'] = $this->Choices_Model->get_all(); 
		$this->load->view('popup/signup_popup_view',$data);  
		$this->load->view('popup/contact_us_view');
		$this->load->view('common/footer_view',$data);
	}
	function get_other_cities($cities){
		if($cities){
			$this->has_cities = TRUE;
			$other_cities = '<div id="other_city_dentist"><ul>';
			if(count($cities) > 6){
				$part = number_format(count($cities)/6);
			}else{
				$part = 1;
			}
			$i = NULL;
			foreach($cities AS $city){
				if(!($i%$part) && $i != NULL){
					$other_cities .= '</ul><ul>';
				}
				$other_cities .='<li><a href="/'.prep_seo_url($city['city_name']).'-'.prep_seo_url($city['state_abbr']).'-dentists" onclick="" title="">'.ucwords(strtolower($city['city_name'])).' Dentist</a></li>';
				$i++; 
			}
			$other_cities .= '</ul></div>';
		}else{
			$this->has_cities = FALSE;
			$other_cities = '<p>'.$this->Seo_Model->get_footer_tags().'</p>';
		}
		return $other_cities;
	}
	function get_search_type($search){
		preg_match('/:/',$search,$has_state);
		
		if(is_numeric($search)) $check_zip = $this->Locations_Model->check_zip($search);
		if(strlen($search) == 2) $check_state = $this->Locations_Model->check_state($search);
		if(count($has_state)){
			$keys = explode(':',$search);
			$check_city = $this->Locations_Model->check_city($keys);
		}
		
		if(is_numeric($search) && $check_zip){
			$type = array(
				'type' => 'zip',
				'long' => $check_zip['longitude'],
				'lat' => $check_zip['latitude'],
				'zoom' => 12,
				'distance' => 5
			);
		}else if(strlen($search) == 2 && $check_state){
			$type = array(
				'type' => 'state',
				'long' => $check_state['avg_longitude'],
				'lat' => $check_state['avg_latitude'],
				'zoom' => 6,
				'distance' => 250
			);
		}else if(count($has_state) && $check_city){
			$type = array(
				'type' => 'city',
				'long' => $check_city['avg_longitude'],
				'lat' => $check_city['avg_latitude'],
				'zoom' => 10,
				'distance' => 20
			);
		}else{
			$type = array(
				'type' => 'invalid',
				'long' => '-88.51',
				'lat' => '42.45',
				'zoom' => 3,
				'distance' => 0.01
			);
		}
		return $type;
	//	die(print_r($type));
	}
	function is_last_string_state($search){
		$search_arr = explode(' ',$search);
		if(strlen(end($search_arr)) == 2 && count($search_arr) > 1){
			$search = substr($search,0,-2);
			return $search .= ':'.end($search_arr);
		}else{
			return $search;
		}
	}
	function marker_label($text){

		image_add_text(base_url().'assets/themes/default/images/green_marker.png',$text);
	}
	function featured_marker_label($text){

		image_add_text(base_url().'assets/themes/default/images/red_marker.png',$text);
	}
	function create_marker_labels() {
		for ($i = 1; $i < 101; ++$i) {
			create_image_add_text(base_url().'assets/themes/default/images/green_marker.png',$i,'green_marker');
		}
		for ($i = 1; $i < 101; ++$i) {
			create_image_add_text(base_url().'assets/themes/default/images/red_marker.png',$i,'red_marker');
		}
	}
	function create_profile_thumbs() {
		$root = $_SERVER['DOCUMENT_ROOT'];
		$pics = $this->Personal_Info_Model->get_all_prof_pics();
		
		foreach ($pics as $pic) {
			if (strlen(ltrim(rtrim($pic->prof_pic))) > 0) {
				$dir = ($pic->user_id < 100 ? 'zero' : round($pic->user_id, -2));
				$picvid = explode(".", $pic->prof_pic);
				if($picvid[count($picvid)-1] != "flv") {
					if (!file_exists("$root/user_assets/prof_images/$dir"))
						mkdir("$root/user_assets/prof_images/$dir/", 0777);
					if (!file_exists("$root/user_assets/prof_images/$dir/{$pic->user_id}"))
						mkdir("$root/user_assets/prof_images/$dir/$pic->user_id/", 0777);
					fopen(base_url()."assets/phpthumb/save_thumb.php?src=".base_url()."user_assets/prof_images/{$pic->prof_pic}&width=85&height=85&path=$root/user_assets/prof_images/$dir/{$pic->user_id}/thumb.jpg", 'r');
					fopen(base_url()."assets/phpthumb/save_thumb.php?src=".base_url()."user_assets/prof_images/{$pic->prof_pic}&width=540&height=540&path=$root/user_assets/prof_images/$dir/{$pic->user_id}/photo.jpg", 'r');
					$file_id = $this->Personal_Info_Model->save_picvid(array('file_name' => 'photo.jpg'), $pic->user_id);
				} else {
					copy("$root/user_assets/prof_images/{$pic->prof_pic}", "$root/user_assets/prof_images/$dir/{$pic->user_id}/flash.flv");
					$file_id = $this->Personal_Info_Model->save_picvid(array('file_name' => 'flash.flv'), $pic->user_id);
				}
			}
		}
	}

	function profile($id){
		$this->output->cache(1500);
		if($this->session->userdata('hit_counter') != $id){
			$hit= array(
				'hit_counter' => $id
			);
			$this->session->set_userdata($hit);
			$this->Statistics_Model->add_hit($id);
		}
		$dentist = $this->Personal_Info_Model->get_data($id);
		$data = $dentist;
		$data['certifications'] = $this->Certifications_Model->get_certifications($id);
		$data['images'] = $this->Images_Model->get_images($id);
		$data['dashboard'] = $this->Dashboard_Info_Model->get_dashboard_info($id);
		$data['promotionals'] = $this->Promotionals_Model->get_promos($id);
		$data['files'] = $this->Files_Model->get_documents($id);
		$data['file_groups'] = $this->Files_Model->get_groups($id);
		$data['rating'] =  $this->Reviews_Model->get_user_rating($id);
		$data['testimonials'] = $this->Reviews_Model->get_user_testimonials($id);
		$data['specialties'] = $this->Specialty_Model->get_user_specialties($id);
		$config = array(
			'map_div_id' => 'map_container_profile',
			'region'	 => 'US',
			'center'	 =>	"{$dentist['address']}, {$dentist['city']}, {$dentist['state']} {$dentist['zip']}, USA",
			'zoom'		 => 16,
			'initializeFunction' => 'addDirections();'
		);
		$this->googlemaps->initialize($config);
		$marker = array(); 
		$marker['icon'] = base_url().'dentist/marker_label/x';
		$marker['position'] = "{$dentist['address']}, {$dentist['city']}, {$dentist['state']} {$dentist['zip']}, USA";  
		$marker['infowindow_content'] = ret_alt_echo(company_output($dentist['first_name'],$dentist['last_name'],$dentist['company_name']),'','',' :')."<br/>{$dentist['first_name']} {$dentist['last_name']} {$dentist['post_nominal']} <br/>{$dentist['address']},<br/>{$dentist['city']}, {$dentist['state']} {$dentist['zip']}, USA";  
		$this->googlemaps->add_marker($marker);       	
		$data['map'] = $this->googlemaps->create_map();
		$data['logged_in'] = $this->session->userdata('logged_in');
		$head_data['video_page'] = TRUE;
		$header['includes_section'] = $this->load->view('common/header/header_includes_view',$head_data,true);
		$header['menu_section'] = $this->load->view('common/header/header_menu_view',$data,true);
		$header['search_section'] = $this->load->view('common/header/searchbar/header_search_view',NULL,true);
		$data['pid'] = $id;
		
		$data['footer_ads'] = $this->Advertisements_Model->get_footer_ads(); $allicons = $this->Social_Media_Model->get_all();
		$data['allicons'] = $allicons;
		$data['analytics_id'] =  $this->Seo_Model->get_analytics_id();
		
		$header['seo'] = array(
			'title' => 'DSUSA ',
			'keywords' => '',
			'description' => 'Dentist Search USA'
		);
		$this->load->view('common/header_view',$header);
		
		$this->load->view('profile/profile_view',$data);
		$this->load->view('popup/login_popup_view');
		$data['signup_text'] =  $this->Seo_Model->get(10); 
		$data['dropdown_choices'] = $this->Choices_Model->get_all(); 
		$this->load->view('popup/signup_popup_view',$data);  
		$this->load->view('popup/contact_us_view');
		$this->load->view('popup/appoinment_view',$data);
		$data['footer_tags'] = $this->Seo_Model->get_footer_tags();
		$data['has_cities'] = FALSE;
		$this->load->view('common/footer_view',$data);
	}
	function review(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$config = array(
				array(
					'field'   => 'user_id',
					'label'   => 'User',
					'rules'   => 'required'
				),
				array(
					'field'   => 'name',
					'label'   => 'Name',
					'rules'   => 'required'
				),
				array(
                    'field'   => 'email',
                    'label'   => 'Email Address',
                    'rules'   => 'required|valid_email|callback_check_unique_review_email'
                ),
				array(
					'field'   => 'message',
					'label'   => 'Message',
					'rules'   => 'required'
				),
				array(
					'field'   => 'rate',
					'label'   => 'Rating',
					'rules'   => 'required'
				)
            );
			$this->form_validation->set_rules($config);
			if($this->form_validation->run()){
				$this->Reviews_Model->add_review();
				$res = array(
					'success' => TRUE,
					'message' => '<div class="form_success">You have successfully added a review for this dentist</div>',
					'name' => $this->input->post('name'),
					'website' => $this->input->post('website'),
					'comment' => $this->input->post('message'),
					'stars' => get_star_rating($this->input->post('rate'),true),
					'rating' => $this->input->post('rate'),
					'new_rating' => get_star_rating($this->Reviews_Model->get_user_rating($this->input->post('user_id')),true,'white')
				);
			}else{
				$res = array('success' => FALSE,'message' => validation_errors('<div class="form_error"> - ','</div>'));
			}
			print json_encode($res);
		}
	}
	function login(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$email =$this->input->post('email');
			$config = array(
				array(
                    'field'   => 'email',
                    'label'   => 'Email Address',
                    'rules'   => 'required|valid_email'
                ),
				array(
                    'field'   => 'password',
                    'label'   => 'Password',
                    'rules'   => 'required'
                )
            );
			$this->form_validation->set_rules($config);
			if($this->form_validation->run()){
				if($this->Accounts_Model->check_unique_email($email)){
					$logged_id = $this->Accounts_Model->do_login();
					if(!$logged_id){
						$res = array('success' => FALSE,'message' => '<div class="form_error">The e-mail address or password is incorrect. Please enter the correct combination.</div>');
					}else{
						$this->set_session($logged_id);
						$this->session->cookie_monster($this->input->post('remember_me') ? FALSE : TRUE);
						$res = array(
							'success' => TRUE,
							'message' => '<div class="form_success">You will be redirected in a few seconds.<br/>
										If your browser does not automatically redirect you, please click 
										<a style="color:white;" href="'.base_url().'dashboard/">HERE</a></div>'
						);
					}
				}else{
					$res = array('success' => FALSE,'message' => '<div class="form_error">The e-mail address or password is incorrect. Please enter the correct combination.</div>');
				}
			}else{
				$res = array('success' => FALSE,'message' => validation_errors('<div class="form_error"> - ','</div>'));
			}
			print json_encode($res);
		}
	}
	function forgot_password(){
		if($this->Accounts_Model->check_unique_email($this->input->post('email'))){
			$res = array(
				'success' => TRUE,
				'message' => '<div class="form_success">An email is sent to the email address that you provided</div>'
			);
		}else{
			$res = array('success' => FALSE,'message' => '<div class="form_error">The e-mail address you provided is not in use.</div>');
		}
		print json_encode($res);
	}
	function no_results($search){
		$this->output->cache(1500);
		$data['search'] = str_replace('_',' ',$search);
		$data['logged_in'] = $this->session->userdata('logged_in');
		$header['includes_section'] = $this->load->view('common/header/header_includes_view',NULL,true);
		$header['menu_section'] = $this->load->view('common/header/header_menu_view',$data,true);
		$header['search_section'] = $this->load->view('common/header/searchbar/header_search_view',NULL,true);
		
		$data['footer_ads'] = $this->Advertisements_Model->get_footer_ads(); $allicons = $this->Social_Media_Model->get_all();
		$data['allicons'] = $allicons;
		$data['analytics_id'] =  $this->Seo_Model->get_analytics_id();
		
		$header['seo'] = array(
			'title' => 'DSUSA ',
			'keywords' => '',
			'description' => 'Dentist Search USA'
		);
		$this->load->view('common/header_view',$header);
		
		$this->load->view('search/no_result_view',$data);
		$this->load->view('popup/login_popup_view');
		$data['signup_text'] =  $this->Seo_Model->get(10); $data['dropdown_choices'] = $this->Choices_Model->get_all(); $this->load->view('popup/signup_popup_view',$data);  
		$this->load->view('popup/contact_us_view');
		$data['footer_tags'] = $this->Seo_Model->get_footer_tags();
		$data['has_cities'] = FALSE;
		$this->load->view('common/footer_view',$data);
	}
	function set_session($id){
		$user = array(
			'logged_in' => TRUE,
			'logged_id' => $id
		);
		$this->session->set_userdata($user);
	}
	function logout(){
		$user = array('logged_in' => '', 'logged_id' => '');
		$this->session->unset_userdata($user);
		 redirect('/');
	}
	function paypal_recurring_payment($rec_amount,$init_amount,$period,$cycles){
		include_once('paypal/lib/RecurringPayment.php');
		$transaction = new RecurringPayment();

		/** Client information **/
		$transaction->firstName = $this->input->post('fname');
		$transaction->lastName = $this->input->post('lname');
		$transaction->creditCardNumber = $this->input->post('card_no');
		$transaction->creditCardType = $this->input->post('card_type');
		$transaction->expDateMonth = $this->input->post('exp_month');
		$transaction->expDateYear = $this->input->post('exp_year');
		$transaction->cvv2Number = $this->input->post('ccv');
		$transaction->address1 = $this->input->post('address');
		$transaction->city = $this->input->post('city');
		$transaction->state = $this->input->post('state');
		$transaction->zip = $this->input->post('zip');
		$transaction->country = 'US';
		$transaction->amount = $rec_amount;
		$transaction->phone = $this->input->post('phone');
		$transaction->email = $this->input->post('email');

		/** Recurring Information **/
		$transaction->description = 'Test description body';
		$transaction->billingPeriod = $period;
		$transaction->billingFrequency = 1;
		$transaction->totalBillingCycles = $cycles;
		$transaction->profileStartDateDay = date('d');
		$transaction->profileStartDateMonth = date('m');
		$transaction->profileStartDateYear = date('Y');
		$transaction->shippingAmount = '5';
		$transaction->taxAmount = '3';
		$transaction->maxFailedPayments = 3;

		/** Initial amount **/
		$transaction->initialAmount = $init_amount;

		/** Shipping **/
		$transaction->shipName = $this->input->post('fname').' '.$this->input->post('lname');
		$transaction->shipStreet = $transaction->address1;
	//	$transaction->shipStreet2 = $transaction->address2;
		$transaction->shipCity = $transaction->city;
		$transaction->shipState = $transaction->state;
		$transaction->shipZip = $transaction->zip;
		$transaction->shipCountry = $transaction->country;
		$transaction->shipPhone = $transaction->phone;

		/** Call the charge function **/
		if($transaction->charge()){
			$transaction->info($transaction->transactionID);
			return true;
		}else{
			$errors = NULL;
			$tran_errors = $transaction->errors->CreateRecurringPaymentsProfile;
			foreach($tran_errors AS $tran_error){
				$errors .= "- {$tran_error['message']}<br>";
			}
			$res = array(
				'success' => FALSE,
				'message' => "<div class='form_error'>{$errors}</div>"
			);
			print json_encode($res);
			die();
		}
	}
	function paypal_direct_payment($amount){
		include_once('paypal/lib/DirectPayment.php');
		$transaction = new DirectPayment();

		$transaction->firstName = $this->input->post('fname');
		$transaction->lastName = $this->input->post('lname');
		$transaction->creditCardNumber = $this->input->post('card_no');
		$transaction->creditCardType = $this->input->post('card_type');
		$transaction->expDateMonth = $this->input->post('exp_month');
		$transaction->expDateYear = $this->input->post('exp_year');
		$transaction->cvv2Number = $this->input->post('ccv');
		$transaction->address1 = $this->input->post('address');
		$transaction->city = $this->input->post('city');
		$transaction->state = $this->input->post('state');
		$transaction->zip = $this->input->post('zip');
		$transaction->country = 'US';
		$transaction->amount = $amount;

		if($transaction->charge()){
			$transaction->capture();
			return true;
		}else{
			$errors = NULL;
			$tran_errors = $transaction->errors->DoDirectPayment;
			foreach($tran_errors AS $tran_error){
				$errors .= "- {$tran_error['message']}<br>";
			}
			$res = array(
				'success' => FALSE,
				'message' => "<div class='form_error'>{$errors}</div>"
			);
			print json_encode($res);
			die();
		}
	}
	function pre_registration(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$config = array(
				array(
					'field'   => 'name',
					'label'   => 'Name',
					'rules'   => 'required'
				),
				array(
					'field'   => 'phone',
					'label'   => 'Phone',
					'rules'   => 'required'
				),
				array(
					'field'   => 'email',
					'label'   => 'Email Address',
					'rules'   => 'required|valid_email'
				),
				array(
					'field'   => 'interest',
					'label'   => 'Interested In',
					'rules'   => 'required'
				)
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run()){
				
				$this->Pre_Registrations_Model->save_registration();
				$email = $this->Email_Model->get_template(1);
				$subject = $email['subject'];
				$message = str_replace('%recipient_name%',$this->input->post('name'),$email['content']);
				$message = str_replace('%registration_link%',base_url().'registration_details',$message);
				
				$emailconf = array('mailtype' => 'html');
				$this->email->initialize($emailconf);
				$this->email->from('no-reply@dentistsearchusa.com', 'NO REPLY - DSUSA');
				$this->email->to($this->input->post('email')); 
				$this->email->bcc('preregister@dentistsearchusa.com');
				$this->email->subject($subject);
				$this->email->message($message);	
				$this->email->send();
				
				$res = array(
					'success' => TRUE,
					'message' => '<div class="form_success">An email is sent to the email address that you provided.</div>'
				);
			}else{
				$res = array('success' => FALSE,'message' => validation_errors('<div class="form_error"> - ','</div>'));
			}
			print json_encode($res);
		}
	}
	function registration(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$email =$this->input->post('email');
			$payment_plan_det = $this->Payments_Model->get_payment_plan($this->input->post('payment_plan'));
			$config = array(
				array(
					'field'   => 'fname',
					'label'   => 'First Name',
					'rules'   => 'required'
				),
				array(
					'field'   => 'lname',
					'label'   => 'Last Name',
					'rules'   => 'required'
				),
				array(
					'field'   => 'phone',
					'label'   => 'Phone',
					'rules'   => 'required'
				),
				array(
                    'field'   => 'email',
                    'label'   => 'Email Address',
                    'rules'   => 'required|valid_email|callback_check_unique_email'
                ),
				array(
                    'field'   => 'emailconf',
                    'label'   => 'Email Confirmation',
                    'rules'   => 'required|matches[email]'
                ),
				array(
                    'field'   => 'password',
                    'label'   => 'Password',
                    'rules'   => 'required'
                ),   
				array(
					'field'   => 'passconf',
                    'label'   => 'Password Confirmation',
					'rules'   => 'required|matches[password]'
				),
				array(
					'field'   => 'payment_plan',
					'label'   => 'Payment Plan',
					'rules'   => 'required'
				)
            );
			if($payment_plan_det['type'] != 1){
				$add_conf = array(
					array(
						'field'   => 'card_type',
						'label'   => 'Payment Method',
						'rules'   => 'required'
					),
					array(
						'field'   => 'card_no',
						'label'   => 'Card Number',
						'rules'   => 'required'
					),
					array(
						'field'   => 'exp_month',
						'label'   => 'Expiry Month',
						'rules'   => 'required'
					),
					array(
						'field'   => 'exp_year',
						'label'   => 'Expiry Year',
						'rules'   => 'required'
					),
					array(
						'field'   => 'ccv',
						'label'   => 'Security Code',
						'rules'   => 'required'
					)
				);
				$config = array_merge($config,$add_conf); 
			}
			$this->form_validation->set_rules($config);
			if($this->form_validation->run()){
				if($payment_plan_det['type'] == 1){
					$payment_proc = TRUE;
				}else{
					if($payment_plan_det['is_recurring']){
						//$payment_proc = $this->paypal_recurring_payment($payment_plan_det['recurring_payment'],$payment_plan_det['initial_payment'],$payment_plan_det['recurring_type'],$payment_plan_det['recurring_cycles']);
					}else{
						//$payment_proc = $this->paypal_direct_payment($payment_plan_det['initial_payment']);
					}
				}
				/*
				switch($this->input->post('payment_plan')){
					case 1:
						$payment_proc = $this->paypal_direct_payment(1000);
					break;
					case 2:
						$payment_proc = $this->paypal_recurring_payment(50,500,'Month',25);
					break;
					case 3:
						$payment_proc =  $this->paypal_recurring_payment(300,700,'Year',2);
					break;
					case 4:
						$payment_proc = $this->paypal_recurring_payment(200,200,'Month',25);
					break;
					case 5:
						$payment_proc = $this->paypal_recurring_payment(500,500,'Year',2);
					break;
				}
				*/
				if($payment_proc){
					$user_id = $this->Accounts_Model->create_account();
					$this->Personal_Info_Model->create_account($user_id);
					$this->Company_Info_Model->create_account($user_id);
					$this->Dashboard_Info_Model->create_account($user_id);
					$this->Statistics_Model->create_account($user_id);
					$this->Images_Model->create_account($user_id);
					$this->set_session($user_id);

					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Congratulations, you have successfully created an account!<br/>
									You will be redirected in a few seconds.<br/>
									If your browser does not automatically redirect you, please click 
									<a style="color:white;" href="'.base_url().'dashboard/">HERE</a></div>'
					);
				}

			}else{
				$res = array('success' => FALSE,'message' => validation_errors('<div class="form_error">go fuck yourself - ','</div>'));
			}
			print json_encode($res);
		}
	}
	function check_unique_email($str){
		if($this->Accounts_Model->check_unique_email($str)){
			$this->form_validation->set_message('check_unique_email', "$str is already used");
			return FALSE;
		}
	}
	function check_unique_review_email($str){
		if($this->Reviews_Model->check_unique_email($str,$this->input->post('user_id'))){
			$this->form_validation->set_message('check_unique_review_email', "$str already made a review for this dentist");
			return FALSE;
		}
	}
	function appointment(){	
		require_once('recaptcha/recaptcha.php');
		$resp = recaptcha_check_answer($privatekey,
		$_SERVER["REMOTE_ADDR"],
		$_POST["recaptcha_challenge_field"],
		$_POST["recaptcha_response_field"]);
		
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$email =$this->input->post('email');
			$config = array(
				array(
                    'field'   => 'name',
                    'label'   => 'Patient\'s Name',
                    'rules'   => 'required'
                ),
				array(
                    'field'   => 'age',
                    'label'   => 'Patient\'s Age',
                    'rules'   => 'required'
                ),
				array(
                    'field'   => 'email',
                    'label'   => 'Email Address',
                    'rules'   => 'required|valid_email'
                ),
				array(
                    'field'   => 'telephone',
                    'label'   => 'Telephone',
                    'rules'   => 'callback_allow_one'
                )
            );
			$this->form_validation->set_rules($config);
			if($this->form_validation->run()){
			//	if(false) {
				if(!$resp->is_valid) {
					$res = array('success' => FALSE,'message' => '<div class="form_error">Invalid Captcha. Please try again</div>');
				}else{
					$this->Appointment_model->save_appointment();	
					$message = '<b>I would like to schedule an appointment for:</b> '.$this->input->post('appointment').'<br/>';
					$message .= '<b>Patient\'s Name:</b> '.$this->input->post('name').'<br/>';
					$message .= '<b>Patient\'s Age:</b> '.$this->input->post('age').'<br/>';
					$message .= '<b>Patient\'s Oral Health:</b> '.$this->input->post('oral_health').'<br/>';
					$message .= '<b>Patient\'s last visit to a dentist:</b> '.$this->input->post('last_visit').'<br/>';
					$message .= '<b>Preferred appointement date:</b> '.$this->input->post('app_date').'<br/>';
					$message .= '<b>Preferred appointement time:</b> '.$this->input->post('app_time').'<br/>';
					$message .= '<b>Email Address:</b> '.$this->input->post('email').'<br/>';
					$message .= '<b>Telephone:</b> '.$this->input->post('telephone').'<br/>';
					$message .= '<b>Mobile Number:</b> '.$this->input->post('mobile').'<br/>';
					$message .= '<b>Additional comments:</b> '.$this->input->post('comments');
					
				/*	$emailconf = array('mailtype' => 'html');
					$this->email->clear();
					$this->email->initialize($emailconf);
					$this->email->from('no-reply@dsusa.com', 'NO REPLY - DSUSA');
					$this->email->to('appointments@dentistsearchusa.com'); 
					$this->email->to('peladorralph@gmail.com'); 
					$this->email->subject(ucwords($this->input->post('name')).' - DSUSA - Appointment Copy');
					$this->email->message($message);	
					$this->email->send(); 
				*/	
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Your request for an appointment has been successfully sent.</div>'
					);
				}
			}else{
				$res = array('success' => FALSE,'message' => validation_errors('<div class="form_error"> - ','</div>'));
			}
			print json_encode($res);
		}
	
	}
	function allow_one($str){
		if(!$this->input->post('telephone') && !$this->input->post('mobile')){
			$this->form_validation->set_message('allow_one', "At least one contact number is required");
			return FALSE;
		}
	}
	function download_document_file($id){
		$file = $this->Files_Model->get_file_details($id);
		$data = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/user_assets/files/'.$file['path']);
		$name = $file['filename'];
		force_download($name, $data); 
	}
	
}
/* End of file */