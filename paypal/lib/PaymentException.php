<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Service library
 *
 * This class extends PHP's Exception handler and
 * uses the filter function to validate that the
 * receiveing errors do not pass thru.
 *
 * PHP version 5.3
 *  
 * @category   Exception
 * @package    Payment\PayPal
 * @author     Stelian Mocanita <stelian.mocanita@gmail.com> 
 * @copyright  2010
 * @version    1.0
 * @since      File available since Release 1.0.0 
 */
//namespace Payment;

Class PM_Exception extends Exception {

	/** Error container **/
	private $errors = array();

	/**
	 * Filter the curl parser error and reads
	 * the paypal validation. Sets the errors in the container if any gound
	 * 
	 * @param array $response
	 * @return bool true/false
	 */
	public function filter($response){
		
		/** See if we have error messages **/
		foreach($response as $key=>$value){			
			if(strpos($key, 'L_LONGMESSAGE') !== false){
				$index = str_replace('L_LONGMESSAGE', '', $key);
				$this->errors[] = array('message' => urldecode($value), 'code' => urlencode($response['L_ERRORCODE' . $index]));				
			}
		}

		/** Return true if no errors **/
		if(count($this->errors) == 0){			
			return true;
		}	else	{
			return false;
		}
	}
	
	/** Class getter
	 * Returns the contents of $this->error as an 
	 * associative array containing message and code
	 * 
	 * @return array $output The associative array
	 */
	public function getErrors(){
		$i = 0;
		foreach($this->errors as $error){
			if(count($error) != 0){
				$output[$i]['message'] = $error['message'];
				$output[$i]['code'] = $error['code'];
				
				$i++;
			}
		}
		
		return $output;
	}
}