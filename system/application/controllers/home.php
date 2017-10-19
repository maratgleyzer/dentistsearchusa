<?php
class Home extends Controller{

	function Home(){
		parent::Controller();
		$this->load->model('Locations_Model');
		$this->load->model('Social_Media_Model');
		$this->load->model('Seo_Model');
		$this->load->model('Choices_Model');
		$this->load->model('Advertisements_Model');
	}
	function index(){
		$this->output->cache(1500);
		$data['logged_in'] = $this->session->userdata('logged_in');
		$data['home_page'] = TRUE;
		$data['page'] = "search-page hp";
		$header['includes_section'] = $this->load->view('common/header/header_includes_view',NULL,true);
		$header['menu_section'] = $this->load->view('common/header/header_menu_view',$data,true);
		
		$data['footer_ads'] = $this->Advertisements_Model->get_footer_ads(); $allicons = $this->Social_Media_Model->get_all();
		$data['allicons'] = $allicons;
		$header['seo'] = $this->Seo_Model->get(1);
		$data['analytics_id'] =  $this->Seo_Model->get_analytics_id();
		
		$data['city_list'] = $this->city_list();
		
		$this->load->view('common/header_view',$header);
		$this->load->view('main_index_view',$data);
		$this->load->view('popup/login_popup_view');
		$data['signup_text'] =  $this->Seo_Model->get(10); $data['dropdown_choices'] = $this->Choices_Model->get_all(); $this->load->view('popup/signup_popup_view',$data);  
		$data['footer_tags'] =  $this->Seo_Model->get_footer_tags();
		$data['has_cities'] = FALSE;
		$this->load->view('popup/contact_us_view');
		$this->load->view('common/footer_view',$data);
	}
	
	function city_list(){
		$ci = "";
		$cities = $this->Locations_Model->get_cities_by_population();
		
		$part = number_format(count($cities)/4);
		$i = NULL;
		foreach($cities AS $city){
			if(!($i%$part) && $i != NULL){
				$ci .= '</ul><ul>';
			}						
			$ci .= "<li><img src=\"/assets/themes/default/images/bullet.gif\" style=\"border:0;margin-right:10px;\" alt=\"\" /><a href='".base_url().prep_seo_url($city['city_name'])."-".strtolower($city['state_abbr'])."-dentists'>{$city['city_name']}</a></li>";
			$i++; 
		}
		
		$html = '
			<div class="ttl">
				<strong><span>OR</span> Select your city below to find a dentist near you</strong>
			</div><!-- /ttl end -->
			<div class="regions-holder">
				<ul>
						'.$ci.'
				</ul>
			</div><!-- /regions-holder end -->
		';
		return $html;
	
	}
}
/* End of file */