<?php
class Contact extends Controller{

	function Contact(){
		parent::Controller();
		$this->load->model('Contact_model');
		$this->load->library('form_validation');
	}
	
	function index(){

		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$email =$this->input->post('email');
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
                    'field'   => 'email',
                    'label'   => 'Email Address',
                    'rules'   => 'required|valid_email'
                ),
				array(
                    'field'   => 'msg',
                    'label'   => 'Message',
                    'rules'   => 'required'
                ),
            );
			
			$this->form_validation->set_rules($config);
			if($this->form_validation->run()){

					if($this->Contact_model->add_contact($this->input->post('type_c'))){
					$res = array('success' => FALSE,'message' => '<div class="form_error">We`re sorry, but there appears to be a problem processing your request. Please try again.</div>');
					}else{
						$res = array(
							'success' => TRUE,
							'message' => '<div class="form_success">Thank you for your enquiry. We will be in touch soon.</div>'
						);
					}
					
			}else{
				$res = array('success' => FALSE,'message' => validation_errors('<div class="form_error"> - ','</div>'));
			}
			print json_encode($res);
		}
	
	}
	
	
}
/* End of file */