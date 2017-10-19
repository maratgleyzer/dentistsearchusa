<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	function load_admin_level(){
		$CI = get_instance();
		$level = NULL; 
		if($CI->session->userdata('admin_level') != 1) $level = 'sub_'; 
		return $level;
	}
	function get_admin_priveleges(){
		$CI = get_instance();
		$CI->load->model('Privileges_Model');
		$privs = $CI->Privileges_Model->get_all_settings();
		$admin_privs = $CI->Privileges_Model->get_admin_privileges($CI->session->userdata('admin_logged_id'));
		foreach($privs AS $priv){
			$allow_access = FALSE;
			foreach($admin_privs AS $admin_priv){
				if($priv['id'] == $admin_priv['privilege_id']){
					$allow_access = TRUE;
				}
			}
			$access[$priv['id']] = $allow_access;
		}
		return $access;
	}
/* End of file */