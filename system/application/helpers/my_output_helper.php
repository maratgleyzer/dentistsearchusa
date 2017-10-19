<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	function alt_echo($str,$alt=NULL,$pre=NULL,$post=NULL){
		if($str){
			if($pre) $str = $pre.$str;
			if($post) $str = $str.$post;
			echo $str;
		}else{
			echo $alt;
		}
	}
	function ret_alt_echo($str,$alt=NULL,$pre=NULL,$post=NULL){
		if($str){
			if($pre) $str = $pre.$str;
			if($post) $str = $str.$post;
			return $str;
		}else{
			return $alt;
		}
	}
	function cap_first_letter($str){
		return ucwords(strtolower($str));
	}
	function echo_yes_no($str){
		if($str == '1'){
			echo 'YES';
		}else if($str == '0'){
			echo 'NO';
		}else{
			echo '';
		}
	}
	function company_output($first,$last,$company){
		if($first){
			$pos = strpos($company,$first);
			if($pos === FALSE){
				return $company;
			}else{
				$pos2 = strpos($company,$last);
				if($pos2 === FALSE){
					return $company;
				}else{
					return '';
				}
			}
		}
	}
	function date_output($date){
		if($date == '0000-00-00'){
			return '';
		}else{
			return $date;
		}
	}
	function prep_seo_url($key){
		$key = strtolower($key);
		$key = preg_replace("/[^a-zA-Z0-9\s]/", "", $key);
		$key = str_replace(' ','-',$key);
		return $key;
	}
	function get_youtube_id($code){
		preg_match('/youtube\.com\/watch\?v\=([\w\-]+)/', $code, $match);
		if(isset($match[1])){
			return $match[1];
		}else{
			return FALSE;
		}
	}
	function my_character_limiter($str,$max){
		$newstr = substr($str,0,$max);
		if(strlen($str) > $max){
			$newstr = $newstr.'...';
		}
		return $newstr;
	}
/* End of file */