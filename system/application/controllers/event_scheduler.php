<?php
class Event_scheduler extends Controller{

	function Event_scheduler(){
		parent::Controller();
		$this->load->model('Event_scheduler_model');
		$this->load->library('form_validation');
	}
	
	function index(){
	
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$email =$this->input->post('email');
			$config = array(
				array(
                    'field'   => 'event_msg',
                    'label'   => 'Event Message',
                    'rules'   => 'required'
                ),
				array(
                    'field'   => 'note',
                    'label'   => 'Event/Note Subject',
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

					$last_id = $this->Event_scheduler_model->add_event();
					if($last_id==""){
						$res = array('success' => FALSE,'message' => '<div class="form_error">There was an error in saving data. Please try again</div>');
					}else{
						$file_data['last_id'] = $last_id;
						$res = array(
							'success' => TRUE,
							'message' => '<div class="form_success">Event has been successfully saved.</div>',
							'file' => $file_data
						);
					}
					
			}else{
				$res = array('success' => FALSE,'message' => validation_errors('<div class="form_error"> - ','</div>'));
			}
			print json_encode($res);
		}
	
	}
	
	function delete_event($id){
		$this->Event_scheduler_model->delete_event($id);
	}
	
	function add_sched(){
	
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$user_id = $this->input->post('user_id');
			$this->Event_scheduler_model->delete_sched($user_id);
			
			$days = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
			$x=1;
			foreach($days as $day){
				$ary = $this->input->post($day);
				if($ary[0] != '' OR $ary[1] != '' OR $ary[2] != '' OR $ary[3] != ''){
				
					if($ary[0]==""){
						$login = "- - - - - -";
					}else{
						$login = $ary[0];
					}
					
					if($ary[1]==""){
						$breakout = "- - - - - -";
					}else{
						$breakout = $ary[1];
					}
					
					if($ary[2]==""){
						$breakin = "- - - - - -";
					}else{
						$breakin = $ary[2];
					}
					
					if($ary[3]==""){
						$logout = "- - - - - -";
					}else{
						$logout = $ary[3];
					}
					
					$last_id = $this->Event_scheduler_model->add_sched($day, $login, $breakout, $breakin, $logout, $x, $user_id);
				}
				$x++;
			}
			
			if($last_id==""){
				$res = array('success' => FALSE,'message' => '<div class="form_error">There was an error in saving data. Please try again</div>');
			}else{
				$file_data['last_id'] = $last_id;
				$res = array(
					'success' => TRUE,
					'message' => '<div class="form_success">Schedule has been successfully saved.</div>',
					'file' => $file_data
				);
			}
			
			print json_encode($res);
		}
	
	}
	
}
/* End of file */