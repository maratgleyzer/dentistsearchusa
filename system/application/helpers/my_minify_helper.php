<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	function min_file($file){
		echo $file = base_url().'min/?f='.$file; //output minified file with base_url attached.
	}
/* End of file */