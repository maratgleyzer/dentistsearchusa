<?php
class Locations extends Controller{

	function Locations(){
		parent::Controller();
	}
	function index(){
		$this->auto_complete();
	}
	function auto_complete($type=NULL){
		$this->load->model('Locations_Model');
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$key = $this->input->post('key');
			$limit = $this->input->post('limit');
			switch($type){
				case 'zip':
					$results = $this->Locations_Model->get_like_zip($key,$limit);
				break;
				case 'city':
				case 'city_name':
					$results = $this->Locations_Model->get_like_city($key,$limit);
				break;
				case 'state':
					$results = $this->Locations_Model->get_like_state($key,$limit);
				break;
				default:
					if(is_numeric($key)){
						$results = $this->Locations_Model->get_like_zip($key,$limit);
					}else{
						$results = $this->Locations_Model->get_like_city($key,$limit);
					}
				break;
			}
			$i = NULL;
			foreach($results as $match){
				if($i%2){
					$class = 'class="ui_auto_match_gray"';
				}else{
					$class = NULL;
				}
				if(is_numeric($key)){
					$city_name = cap_first_letter($match['city_name']);
					$matches[] = array(
						'label' => "<label {$class}>{$match['zip_code']}</label><label class='match_label'>{$city_name}, {$match['state_abbr']}"."</label>",
						'value' => $match['zip_code']
					);
				}else{
					switch($type){
						case 'state':
							$loc_name = cap_first_letter($match['state_long']);
							$value = $match['state_abbr'];
						break;
						case 'city_name':
							$loc_name = cap_first_letter($match['city_name']);
							$value = cap_first_letter($match['city_name']);
						break;
						case 'city':
						default:
							$loc_name = cap_first_letter($match['city_name']);
							$value = cap_first_letter($match['city_name']).', '.$match['state_abbr'];
						break;
					}
					$matches[] = array(
						'label' => "<label {$class}>{$loc_name}</label><label class='match_label'>{$match['state_abbr']}</label>",
						'value' => $value
					);
				}
				$i++;	
			}
			if($results) print json_encode($matches);
		}
	}
	
	function results($type){
		$this->load->model('Company_Info_Model');
		//if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$key = $this->input->post('key');
				$type = str_replace('_',' ',$type);
				$results = $this->Company_Info_Model->dentist_search($key,5);
				$i = NULL;
				foreach($results as $match){
					if($i%2){
						$class = 'class="ui_auto_match_gray"';
					}else{
						$class = NULL;
					}
					
					$name = $match['first_name']." ".$match['last_name'];
					$matches[] = array(
						'label' => "<label {$class}>".$name."</label><label class='match_label'>".$name."</label>",
						'value' => $name
					);
					
					$i++;	
				}
				
				if($results) print json_encode($matches);
		//}
	}
	
	function get_by_name(){
		$this->load->model('Personal_Info_Model');
		//if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$key = $this->input->post('key');
		$limit = $this->input->post('limit');
		$results = $this->Personal_Info_Model->get_by_name($key,$limit);
		$i = NULL;
		foreach($results as $match){
			if($i%2){
				$class = 'class="ui_auto_match_gray"';
			}else{
				$class = NULL;
			}
			
			$name = $match['first_name']." ".$match['last_name'];
			$matches[] = array(
				'label' => "<label {$class}>".$name."</label>",
				'value' => $name,
				'user' => $match['user_id']
			);
					
			$i++;	
		}
				
		if($results) print json_encode($matches);
		//}
	}
}
/* End of file */