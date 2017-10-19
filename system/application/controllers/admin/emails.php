<?php

class Emails extends Controller {

	function Emails(){
		parent::Controller();
		if($this->input->server('REQUEST_METHOD') != 'POST'){
			if(!$this->session->userdata('admin_logged_in')){
				header('location: '.base_url().'_admin_console/login');
			}
		}
		
		$this->load->model('Email_Model');
		$this->load->model('Seo_Model');
		
		$this->load->helper('form');
		$this->load->helper('security');
		$this->load->helper('file');
		
		$this->load->library('form_validation');
	}
	function index(){
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/'.load_admin_level().'home_view');
		$this->load->view('admin/common/footer_view');
	}
	function edit_email_template(){
		$data['email'] = $this->Email_Model->get_template(1);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/emails/edit_email_template_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function save_email_template($edit){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'subject',
						'label'   => 'Subject',
						'rules'   => 'required'
					),
					array(
						'field'   => 'content',
						'label'   => 'Content',
						'rules'   => 'required'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$this->Email_Model->save_template($edit);
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Template succesfully saved.</div>'
					);
				}else{
					$res = array('success' => FALSE,'message' => validation_errors('<div class="form_error"> - ','</div>'));
				}
			}else{
				$res = array(
					'success' => FALSE,
					'message' => '<div class="form_error">Your session has ended. Please click <a href="#" style="color:white;" onclick="location.reload();">HERE</a> to refresh your browser and log-in again.</div>'
				);
			}
			print json_encode($res);
		}
	}
}