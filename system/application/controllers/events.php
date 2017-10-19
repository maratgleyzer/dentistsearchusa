<?php
class Events extends Controller{

	function Events(){
		parent::Controller();
		$this->load->model('Events_model');
		$this->load->library('form_validation');
	}
	
	function index(){
	
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			if($this->input->server('REQUEST_METHOD') === 'POST'){
			$email =$this->input->post('email');
			$config = array(
				array(
                    'field'   => 'event_msg',
                    'label'   => 'Event Message',
                    'rules'   => 'required'
                ),
				array(
                    'field'   => 'start_date',
                    'label'   => 'Start Date',
                    'rules'   => 'required'
                ),
				array(
                    'field'   => 'end_date',
                    'label'   => 'End Date',
                    'rules'   => 'required'
                ),
            );
			
			$this->form_validation->set_rules($config);
			if($this->form_validation->run()){

					$last_id = $this->Events_model->add_event($this->input->post('user_id'));
					if($last_id==""){
						$res = array('success' => FALSE,'message' => '<div class="form_error">There was an error in saving data. Please try again</div>');
					}else{
						$file_data['last_id'] = $last_id;
						$res = array(
							'success' => TRUE,
							'message' => '<div class="form_success">New event has been successfully send.</div>',
							'file' => $file_data
						);
					}
					
			}else{
				$res = array('success' => FALSE,'message' => validation_errors('<div class="form_error"> - ','</div>'));
			}
			print json_encode($res);
		}
		}
	
	}
	
	function delete_event($id){
		$this->Events_model->delete_event($id);
	}
	
	
}
/* End of file */