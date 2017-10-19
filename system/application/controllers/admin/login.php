<?php

class Login extends Controller{
	function Login(){
		parent::Controller();
		session_start();
		$this->load->model('Admin_model');
		$this->load->helper('security');		
	}
	function index(){
		$data['message'] = '';
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id = $this->Admin_model->do_login();
			if($id['id']){			
				$user = array(
					'admin_logged_in' => TRUE,
					'admin_logged_id' => $id['id'],
					'admin_level' => $id['level'],
					'logged_id' => '',
					'logged_in' => ''
				);
				$this->session->set_userdata($user);
				header('location: '.base_url().'_admin_console/home');
			}else{
				$data['admin_logged_in'] = FALSE;
				$data['message'] = 'Invalid Login';
			}
		}
		$this->load->view('admin/login_view',$data);
	}
	function logout(){
		$user = array('admin_logged_in' => '', 'admin_logged_id' => '', 'admin_level' => '', 'logged_id' => '', 'logged_in' => '');
		$this->session->unset_userdata($user);
		header('location: '.base_url().'_admin_console/login');
	}
}