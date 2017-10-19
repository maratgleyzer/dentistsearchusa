<?php
/**
 * PhpThumb Library Example File
 * 
 * This file contains example usage for the PHP Thumb Library
 * 
 * PHP Version 5 with GD 2.0+
 * PhpThumb : PHP Thumb Library <http://phpthumb.gxdlabs.com>
 * Copyright (c) 2009, Ian Selby/Gen X Design
 * 
 * Author(s): Ian Selby <ian@gen-x-design.com>
 * 
 * Licensed under the MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author Ian Selby <ian@gen-x-design.com>
 * @copyright Copyright (c) 2009 Gen X Design
 * @link http://phpthumb.gxdlabs.com
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 3.0
 * @package PhpThumb
 * @subpackage Examples
 * @filesource
 */
header("Cache-Control: private, max-age=15000, pre-check=15000");
header("Pragma: private");
header("Expires: " . date(DATE_RFC822,strtotime(" 1 day")));
$img = $_GET['src']; 
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && 
	(strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == filemtime($img))) {
  // send the last mod time of the file back
  header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($img)).' GMT', 
  true, 304);
  exit;
}
ini_set("memory_limit","64M");
require_once 'ThumbLib.inc.php';
$thumb = PhpThumbFactory::create($_GET['src']);
$thumb->resize($_GET['width'], $_GET['height']);
$thumb->show();
?>