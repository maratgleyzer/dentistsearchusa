<?php

class Login extends Controller{
	function Login(){
		parent::Controller();
		session_start();
		$this->load->model('CMS_Model');
		$this->load->helper('security');		
	}
	function index(){
		$data['message'] = '';
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id = $this->CMS_Model->do_login();
			if($id['id']){			
				$user = array(
					'cmsuser_logged_in' => TRUE,
					'cmsuser_logged_id' => $id['id'],
					'logged_id' => '',
					'logged_in' => ''
				);
				$this->session->set_userdata($user);
				header('location: '.base_url().'dslisting/home');
			}else{
				$data['cmsuser_logged_in'] = FALSE;
				$data['message'] = 'Invalid Login';
			}
		}
		$this->load->view('dslisting/login_view',$data);
	}
	function logout(){
		$user = array('cmsuser_logged_in' => '', 'cmsuser_logged_id' => '', 'logged_id' => '', 'logged_in' => '');
		$this->session->unset_userdata($user);
		header('location: '.base_url().'dslisting/login');
	}
}