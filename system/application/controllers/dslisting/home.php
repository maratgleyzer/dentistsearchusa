<?php
class Home extends Controller {
	function Home()
	{
		parent::Controller();
		if($this->input->server('REQUEST_METHOD') != 'POST'){
			if(!$this->session->userdata('cmsuser_logged_in')){
				header('location: '.base_url().'dslisting/login');
			}
		}
		$this->load->model('CMS_Model');
		
		$this->load->library('form_validation');
		
		$this->load->helper('form');
		$this->load->helper('security');
		$this->load->helper('file');
		$this->load->helper('text');
	}
	function index()
	{
		$this->load->view('dslisting/common/header_view');
		$this->load->view('dslisting/common/menu_view');
		$this->load->view('dslisting/home_view');
		$this->load->view('dslisting/common/footer_view');
	}
}