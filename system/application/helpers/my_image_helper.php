<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	function image_add_text($image,$text){
		header('Content-type: image/png');
		$image = imagecreatefrompng($image);
		$textCol = imagecolorallocate($image, 255, 255, 255);
		if ((integer) $text > 9) $textX = 10;
		if ((integer) $text > 99) $textX = 6;
		if ((integer) $text < 10) $textX = 14;
		$textY = 22; 
		$font = 'assets/fonts/arial.ttf';
		imagettftext($image, 11, 0, $textX, $textY, $textCol, $font, $text);
		imagealphablending($image, false); 
		imagesavealpha($image, true);
		imagepng($image);
		imagedestroy($image);
	}
	function create_image_add_text($image,$text,$dir){
		//header('Content-type: image/png');
		$image = imagecreatefrompng($image);
		$textCol = imagecolorallocate($image, 255, 255, 255);
		if ((integer) $text > 9) $textX = 10;
		if ((integer) $text > 99) $textX = 6;
		if ((integer) $text < 10) $textX = 14;
		$textY = 22; 
		$font = 'assets/fonts/arial.ttf';
		imagettftext($image, 11, 0, $textX, $textY, $textCol, $font, $text);
		imagealphablending($image, false); 
		imagesavealpha($image, true);
		imagepng($image, '/home/dentists/public_html/assets/images/'.$dir.'/'.$text.'.png');
		imagedestroy($image);
	}
/* End of file */