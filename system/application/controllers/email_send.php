<?php
class Email_Send extends Controller{

	function Email_Send(){
		parent::Controller();
	}
	
	function index(){				
		$emailconf = array('mailtype' => 'html');
		$this->email->initialize($emailconf);
		$this->email->from('no-reply@dsusa.com');
		$this->email->to('peladorralph@gmail.com'); 
		$this->email->subject('TEST CI EMAIL');
		$this->email->message('what the <b>fudge</b>');	
		$this->email->send();
		echo $this->email->print_debugger();
	}
}
/* End of file */