<?php
class Video extends Controller{

	function Video(){
		parent::Controller();
		$this->load->model('Locations_Model');
		$this->load->model('Video_model');
		$this->load->model('Blog_model');
		$this->load->model('Social_Media_Model');
		$this->load->model('Seo_Model');
		$this->load->model('Choices_Model');
		$this->load->model('Advertisements_Model');
		
		$this->load->helper('text');
	}

	function index(){
		$this->output->cache(1500);
		$limit = 6;
	
		$data['videos'] = $this->Video_model->contents($limit, 0);
		$data['categories'] = $this->Blog_model->categories(2);
		
		//Paging-----------------------------------------------
		$pge_total = $this->Video_model->count_contents();
		$data['num_pge'] = ceil($pge_total/$limit);
		
		$data['p'] = 1;
		$data['cat'] = 0;
		//End Paging-------------------------------------------
		
	//	$data['states'] = $this->Locations_Model->get_states();
		$data['video_page'] = TRUE;
		$data['logged_in'] = $this->session->userdata('logged_in');
		$data['page'] = "video-page";
		
		$header['includes_section'] = $this->load->view('common/header/header_includes_view',$data,TRUE);
		$header['menu_section'] = $this->load->view('common/header/header_menu_view',$data,TRUE);
		$header['search_section'] = $this->load->view('common/header/searchbar/header_blog_search_view',NULL,TRUE);
		
		$data['footer_ads'] = $this->Advertisements_Model->get_footer_ads(); 
		$allicons = $this->Social_Media_Model->get_all();
		$data['allicons'] = $allicons;
		$data['analytics_id'] =  $this->Seo_Model->get_analytics_id();
		$data['sidebar_ads'] = $this->Advertisements_Model->get_page_sidebar_ads('video');
		
		$header['seo'] = $this->Seo_Model->get(4);
		$this->load->view('common/header_view',$header);
		
		$this->load->view('video/video_view', $data);
		$this->load->view('popup/login_popup_view');
		$data['signup_text'] =  $this->Seo_Model->get(10);
		$data['dropdown_choices'] = $this->Choices_Model->get_all();
		$this->load->view('popup/signup_popup_view',$data);  
		$data['footer_tags'] = $this->Seo_Model->get_footer_tags();
		$data['has_cities'] = FALSE;
		$this->load->view('popup/contact_us_view');
		$this->load->view('common/footer_view',$data);
	}
	function category($cat){
		$this->output->cache(1500);
		$limit = 6;
	
		$data['videos'] = $this->Video_model->contents_by_cat($cat, $limit, 0);
		$data['categories'] = $this->Blog_model->categories(2);
		
		//Paging-----------------------------------------------
		$pge_total = $this->Video_model->count_contents_by_cat($cat);
		$data['num_pge'] = ceil($pge_total/$limit);
		
		$data['p'] = 1;
		$data['cat'] = $cat;
		//End Paging-------------------------------------------
		
	//	$data['states'] = $this->Locations_Model->get_states();
		$data['logged_in'] = $this->session->userdata('logged_in');
		$data['video_page'] = TRUE;
		$data['page'] = "video-page";
		
		$header['includes_section'] = $this->load->view('common/header/header_includes_view',$data,NULL,TRUE);
		$header['menu_section'] = $this->load->view('common/header/header_menu_view',$data,TRUE);
		$header['search_section'] = $this->load->view('common/header/searchbar/header_blog_search_view',NULL,TRUE);
		
		$header['seo'] = $this->Seo_Model->get(4);
		$this->load->view('common/header_view',$header);
		
		$data['footer_ads'] = $this->Advertisements_Model->get_footer_ads();
		$allicons = $this->Social_Media_Model->get_all();
		$data['allicons'] = $allicons;
		$data['analytics_id'] =  $this->Seo_Model->get_analytics_id();
		$data['sidebar_ads'] = $this->Advertisements_Model->get_page_sidebar_ads('video');
		
		$this->load->view('video/video_view', $data);
		$this->load->view('popup/login_popup_view');
		$data['signup_text'] =  $this->Seo_Model->get(10); $data['dropdown_choices'] = $this->Choices_Model->get_all(); $this->load->view('popup/signup_popup_view',$data);  
		$this->load->view('popup/contact_us_view');
		$data['footer_tags'] = $this->Seo_Model->get_footer_tags();
		$data['has_cities'] = FALSE;
		$this->load->view('common/footer_view',$data);
	
	}
	
	function p($c, $p){
		$this->output->cache(1500);
		$limit = 6;
		$pge = ($p - 1) * $limit;
		
		if($c > 0){
			$data['videos'] = $this->Video_model->contents_by_cat($c, $limit, $pge);
			$data['categories'] = $this->Blog_model->categories(2);
			
			//Paging-----------------------------------------------

			$pge_total = $this->Video_model->count_contents_by_cat($c);
			$data['num_pge'] = ceil($pge_total/$limit);
			
			$data['p'] = $p;
			$data['cat'] = $c;
			//End Paging-------------------------------------------
		}else{
			$data['videos'] = $this->Video_model->contents($limit, $pge);
			$data['categories'] = $this->Blog_model->categories(2);
			
			//Paging-----------------------------------------------

			$pge_total = $this->Video_model->count_contents();
			$data['num_pge'] = ceil($pge_total/$limit);
			
			$data['p'] = $p;
			$data['cat'] = 0;
			//End Paging-------------------------------------------
		}
		
		
		
	//	$data['states'] = $this->Locations_Model->get_states();
		$data['logged_in'] = $this->session->userdata('logged_in');
		$data['video_page'] = TRUE;
		$data['page'] = "video-page";
		
		$header['includes_section'] = $this->load->view('common/header/header_includes_view',$data,NULL,TRUE);
		$header['menu_section'] = $this->load->view('common/header/header_menu_view',$data,TRUE);
		$header['search_section'] = $this->load->view('common/header/searchbar/header_blog_search_view',NULL,TRUE);
		
		$header['seo'] = $this->Seo_Model->get(4);
		$this->load->view('common/header_view',$header);
		
		$data['footer_ads'] = $this->Advertisements_Model->get_footer_ads(); 
		$allicons = $this->Social_Media_Model->get_all();
		$data['allicons'] = $allicons;
		$data['analytics_id'] =  $this->Seo_Model->get_analytics_id();
		$data['sidebar_ads'] = $this->Advertisements_Model->get_page_sidebar_ads('video');
		
		$this->load->view('video/video_view', $data);
		$this->load->view('popup/login_popup_view');
		$data['signup_text'] =  $this->Seo_Model->get(10); $data['dropdown_choices'] = $this->Choices_Model->get_all(); $this->load->view('popup/signup_popup_view',$data);  
		$this->load->view('popup/contact_us_view');
		$data['footer_tags'] = $this->Seo_Model->get_footer_tags();
		$data['has_cities'] = FALSE;
		$this->load->view('common/footer_view',$data);
	
	}
}
/* End of file */