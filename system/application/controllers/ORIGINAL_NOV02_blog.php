<?php
class Blog extends Controller{

	function Blog(){
		parent::Controller();
		$this->load->model('Locations_Model');
		$this->load->model('Blog_model');
		$this->load->model('Video_model');
		$this->load->model('Social_Media_Model');
		$this->load->model('Seo_Model');
		$this->load->model('Advertisements_Model');
	}
	
	function index(){
	
		$limit = 6;
	
		$data['contents'] = $this->Blog_model->contents($limit, 0);
		$data['categories'] = $this->Blog_model->categories();
		
		//Paging-----------------------------------------------
		$pge_total = $this->Blog_model->count_contents();
		$data['num_pge'] = ceil($pge_total/$limit);
		
		$data['p'] = 1;
		$data['cat'] = 0;
		//End Paging-------------------------------------------
		
		$data['recent_video'] = $this->Video_model->get_recent_video();
		$data['video_page'] = TRUE;
		$data['states'] = $this->Locations_Model->get_states();
		$data['logged_in'] = $this->session->userdata('logged_in');
		$data['page'] = "";
		$header['includes_section'] = $this->load->view('common/header/header_includes_view',$data,TRUE);
		$header['menu_section'] = $this->load->view('common/header/header_menu_view',$data,TRUE);
		$header['search_section'] = $this->load->view('common/header/searchbar/header_blog_search_view',NULL,TRUE);
		
		$data['footer_ads'] = $this->Advertisements_Model->get_footer_ads(); $allicons = $this->Social_Media_Model->get_all();
		$data['allicons'] = $allicons;
		$data['analytics_id'] =  $this->Seo_Model->get_analytics_id();
		
		$header['seo'] = $this->Seo_Model->get(3);
		$this->load->view('common/header_view',$header);
		
		$this->load->view('blog/blog_view', $data);
		$this->load->view('popup/login_popup_view');
		$this->load->view('popup/signup_popup_view');
		$this->load->view('popup/contact_us_view');
		$this->load->view('common/footer_view',$data);
	}
	
	function category($cat){
	
		$limit = 6;
	
		$data['contents'] = $this->Blog_model->contents_by_cat($cat, $limit, 0);
		$data['categories'] = $this->Blog_model->categories();
		
		//Paging-----------------------------------------------
		$pge_total = $this->Blog_model->count_contents_by_cat($cat);
		$data['num_pge'] = ceil($pge_total/$limit);
		
		$data['p'] = 1;
		$data['cat'] = $cat;
		//End Paging-------------------------------------------
		
		$data['states'] = $this->Locations_Model->get_states();
		$data['logged_in'] = $this->session->userdata('logged_in');
		$data['page'] = "";
		
		$header['includes_section'] = $this->load->view('common/header/header_includes_view',NULL,TRUE);
		$header['menu_section'] = $this->load->view('common/header/header_menu_view',$data,TRUE);
		$header['search_section'] = $this->load->view('common/header/searchbar/header_blog_search_view',NULL,TRUE);
		
		$header['seo'] = $this->Seo_Model->get(3);
		$this->load->view('common/header_view',$header);
		
		$data['recent_video'] = $this->Video_model->get_recent_video();
		$data['video_page'] = TRUE;
		
		$data['footer_ads'] = $this->Advertisements_Model->get_footer_ads(); $allicons = $this->Social_Media_Model->get_all();
		$data['allicons'] = $allicons;
		$data['analytics_id'] =  $this->Seo_Model->get_analytics_id();
		
		$this->load->view('blog/blog_view', $data);
		$this->load->view('popup/login_popup_view');
		$this->load->view('popup/signup_popup_view');
		$this->load->view('popup/contact_us_view');
		$this->load->view('common/footer_view',$data);
	
	}
	
	function p($c, $p){
	
		$limit = 6;
		$pge = ($p - 1) * $limit;
		
		if($c > 0){
			$data['contents'] = $this->Blog_model->contents_by_cat($c, $limit, $pge);
			$data['categories'] = $this->Blog_model->categories();
			
			//Paging-----------------------------------------------
			$pge_total = $this->Blog_model->count_contents_by_cat($c);
			$data['num_pge'] = ceil($pge_total/$limit);
			
			$data['p'] = $p;
			$data['cat'] = $c;
			//End Paging-------------------------------------------
		}else{
			$data['contents'] = $this->Blog_model->contents($limit, $pge);
			$data['categories'] = $this->Blog_model->categories();
			
			//Paging-----------------------------------------------

			$pge_total = $this->Blog_model->count_contents();
			$data['num_pge'] = ceil($pge_total/$limit);
			
			$data['p'] = $p;
			$data['cat'] = 0;
			//End Paging-------------------------------------------
		}

		$data['states'] = $this->Locations_Model->get_states();
		$data['logged_in'] = $this->session->userdata('logged_in');
		$data['page'] = "";
		$data['recent_video'] = $this->Video_model->get_recent_video();
		$data['video_page'] = TRUE;
		$header['includes_section'] = $this->load->view('common/header/header_includes_view',$data,TRUE);
		$header['menu_section'] = $this->load->view('common/header/header_menu_view',$data,TRUE);
		$header['search_section'] = $this->load->view('common/header/searchbar/header_blog_search_view',NULL,TRUE);
		
		$header['seo'] = $this->Seo_Model->get(3);
		$this->load->view('common/header_view',$header);
		
		$data['footer_ads'] = $this->Advertisements_Model->get_footer_ads(); $allicons = $this->Social_Media_Model->get_all();
		$data['allicons'] = $allicons;
		$data['analytics_id'] =  $this->Seo_Model->get_analytics_id();
		
		$this->load->view('blog/blog_view', $data);
		$this->load->view('popup/login_popup_view');
		$this->load->view('popup/signup_popup_view');
		$this->load->view('popup/contact_us_view');
		$this->load->view('common/footer_view',$data);
	
	}
	
	function blogpage($id=0){
	
		$data['categories'] = $this->Blog_model->categories();
	
		$content = $this->Blog_model->content_page($id);
		$data['title'] = $content[0]['title'];
		$data['author'] = $content[0]['author'];
		$data['summary'] = $content[0]['summary'];
		$data['content'] = $content[0]['content'];
		$data['image'] = $content[0]['image'];
		$data['date'] = $content[0]['date'];
		
		$data['contents'] = $this->Blog_model->contents_related($content[0]['category_id'], $id);
		
		$data['states'] = $this->Locations_Model->get_states();
		$data['logged_in'] = $this->session->userdata('logged_in');
		$data['page'] = "";
		$data['recent_video'] = $this->Video_model->get_recent_video();
		$data['video_page'] = TRUE;
		
		$header['includes_section'] = $this->load->view('common/header/header_includes_view',$data,TRUE);
		$header['menu_section'] = $this->load->view('common/header/header_menu_view',$data,TRUE);
		$header['search_section'] = $this->load->view('common/header/searchbar/header_blog_search_view',NULL,TRUE);
		
		$header['seo'] = array(
			'title' => $content[0]['title'],
			'keywords' => $content[0]['tags'],
			'description' => $content[0]['summary']
		);
		$this->load->view('common/header_view',$header);
		
		$data['footer_ads'] = $this->Advertisements_Model->get_footer_ads(); $allicons = $this->Social_Media_Model->get_all();
		$data['allicons'] = $allicons;
		$data['analytics_id'] =  $this->Seo_Model->get_analytics_id();
		
		$this->load->view('blog/blogpage_view', $data);
		$this->load->view('popup/login_popup_view');
		$this->load->view('popup/signup_popup_view');
		$this->load->view('popup/contact_us_view');
		$this->load->view('common/footer_view',$data);

	}
	function search(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$keyword = $this->input->post('keyword');
			$data['keyword'] = $keyword;
			$data['logged_in'] = $this->session->userdata('logged_in');
			$data['video_page'] = TRUE;
			$data['page'] = "video-page";
			
			$data['contents'] = $this->Blog_model->search($keyword);
			$data['videos'] =  $this->Video_model->search($keyword);
			
			$header['includes_section'] = $this->load->view('common/header/header_includes_view',$data,NULL,TRUE);
			$header['menu_section'] = $this->load->view('common/header/header_menu_view',$data,TRUE);
			$header['search_section'] = $this->load->view('common/header/searchbar/header_blog_search_view',NULL,TRUE);
			
			$header['seo'] = $this->Seo_Model->get(3);
			$this->load->view('common/header_view',$header);
			
			$data['footer_ads'] = $this->Advertisements_Model->get_footer_ads(); $allicons = $this->Social_Media_Model->get_all();
			$data['allicons'] = $allicons;
			$data['analytics_id'] =  $this->Seo_Model->get_analytics_id();
			
			$this->load->view('blog/blog_search_view', $data);
			$this->load->view('popup/login_popup_view');
			$this->load->view('popup/signup_popup_view');
			$this->load->view('popup/contact_us_view');
			$this->load->view('common/footer_view',$data);
		}
	}
}
/* End of file */