<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	function get_star_rating($score,$round=false,$type='red'){
		if($round){
			$score = number_format(($score * 2),0) / 2; 
		}
		$i = 1;
		$pos = intval($score);
		$star = null;
		while ($i <= 5) {
			if($i == $pos){
				$star .= '<img src="'.base_url().'assets/images/'.$type.'_star_full.png">';
			}else if($i > $pos){
				if(get_decimals($score) && $i == ($pos+1)){
					$star .= '<img src="'.base_url().'assets/images/'.$type.'_star_half.png">';
				}else{
					$star .= '<img src="'.base_url().'assets/images/'.$type.'_star_empty.png">';
				}
			}else if($i < $pos){
				$star .= '<img src="'.base_url().'assets/images/'.$type.'_star_full.png">';
			}
			$i++;  
		}
		return $star;
	}
	function get_decimals($value){
		if ((int)$value == $value){
			return 0;
		}
		return strlen($value) - strrpos($value, '.') - 1;
	}
	function get_round_rating($score){
		$score = number_format(($score * 2),0) / 2; 
		return $score;
	}
	function select_star($score,$field){
		$score = number_format(($score * 2),0) / 2; 
		if($score == $field){
			echo 'selected="selected"';
		}
	}
/* End of file */