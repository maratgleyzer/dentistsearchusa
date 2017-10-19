<?php
class Terms_And_Conditions extends Controller{

	function Terms_And_Conditions(){
		parent::Controller();
		$this->load->model('Social_Media_Model');
		$this->load->model('Seo_Model');
		$this->load->model('Choices_Model');
		$this->load->model('Advertisements_Model');
	}
	
	function index(){
		$this->output->cache(1500);				
		$data['logged_in'] = $this->session->userdata('logged_in');
		$data['page'] = "";
		
		$header['includes_section'] = $this->load->view('common/header/header_includes_view',NULL,TRUE);
		$header['menu_section'] = $this->load->view('common/header/header_menu_view',$data,TRUE);
		$header['search_section'] = $this->load->view('common/header/searchbar/header_search_view',NULL,TRUE);
		
		$header['seo'] = $this->Seo_Model->get(7);
		$this->load->view('common/header_view',$header);
		
		$data['footer_ads'] = $this->Advertisements_Model->get_footer_ads(); $allicons = $this->Social_Media_Model->get_all();
		$data['allicons'] = $allicons;
		$data['analytics_id'] =  $this->Seo_Model->get_analytics_id();
		$data['sidebar_ads'] = $this->Advertisements_Model->get_page_sidebar_ads('terms_and_conditions');
		
		$this->load->view('terms_and_conditions_view', $data);
		$this->load->view('popup/login_popup_view');
		$data['signup_text'] =  $this->Seo_Model->get(10); $data['dropdown_choices'] = $this->Choices_Model->get_all(); $this->load->view('popup/signup_popup_view',$data);  
		$this->load->view('popup/contact_us_view');
		$data['footer_tags'] = $this->Seo_Model->get_footer_tags();
		$data['has_cities'] = FALSE;
		$this->load->view('common/footer_view',$data);
	}
}
/* End of file */