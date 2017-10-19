<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Service library
 *
 * This file holds the methods to run and retrieve 
 * the PayPal API calls. The members attached to it
 * are both configuration and common fields on 
 * direct and recurring payments
 *
 * PHP version 5.3
 *  *
 * @category   Library
 * @package    Payment\PayPal
 * @author     Stelian Mocanita <stelian.mocanita@gmail.com> 
 * @copyright  2010
 * @version    1.0
 * @since      File available since Release 1.0.0 
 */
//namespace Payment;


Class Service {

	/** Api configuration **/
	
	/**
	 * The PayPal API Username 
	 * 
	 * @var string $apiUsername
	 * @see config/username.php
	 */
	private $apiUsername;	
	
	/**
	 * The PayPal API Password
	 * 
	 * @var string $apiPassword
	 */
	private $apiPassword;	
	
	/**
	 * The PayPal API Signature
	 * @var string $apiSignature
	 */
	private $apiSignature;
	
	/**
	 * The PayPal API EndPoint is the URL the request
	 * is made to 
	 * 
	 * @var string $apiEndPoint
	 */
	private $apiEndPoint;
	
	/** 
	 * The PayPal environment
	 * Can be sandbox, beta-sandvbox and live
	 * 
	 * @var string $environment
	 */
	private $environment;	
	
	/** 
	 * The API calls PayPal version
	 * @var float $paypalVersion
	 */
	private $paypalVersion;
	
	/** 
	 * The subject is required in the
	 * recurring payments.
	 * 
	 * @var string $subject
	 */
	private $subject;
	
	/**  
	 * For the API to work for both 
	 * Direct and Recurring, this will always
	 * be Authorization 
	 * 
	 * @var string $paymentType
	 */
	private $paymentType;
	
	/** 
	 * The handler for the Transaction Logging
	 * Class
	 * 
	 * @var object $log
	 */
	private $log;
	
	/**
	 * The handler for the Exception Class
	 * 
	 * @var object $exceptionHandler
	 */
	protected $exceptionHandler;

	/** 
	 * Common fields for both Direct and
	 * Recurring Payment 
	 * */
	
	/**
	 * The user's First Name
	 * 
	 * @var string $firstName
	 */
	public $firstName;
	
	/** 
	 * The user's Last name
	 * 
	 * @var string $lastName
	 */
    public $lastName;
    
    /** 
	 * The user's credit car type
	 * Can be one of the following:
	 * 	Visa
	 * 	MasterCard
	 * 	Discover
	 * 	Amex
	 * 	Maestro
	 * 	Solo
	 * 
	 * @var string $lastName
	 */
 	public $creditCardType;
 	
 	/**
 	 * The user's CC Nubmer
 	 * 
 	 * @var int $creditCardNumber
 	 */
	public $creditCardNumber;
	
	/** 
	 * The CC Expirate Month
	 * No leading zeros
	 * 
	 * @var int 
	 * @example 5
	 */
	public $expDateMonth;
	
	/**
	 * Padded CC expiration month
	 *  
	 * @var int $padDateMonth
	 */
	public $padDateMonth;
	
	/**
	 * CC Expiration Year
	 * 
	 * @var int $expDateYear
	 */
	public $expDateYear;
	
	/** 
	 * User's CC CVV2 Number
	 * 
	 * @var int $cvv2Number
	 */
	public $cvv2Number;
	
	/**
	 * User's Address Line 1
	 * 
	 * @var string $address1
	 */
	public $address1;
	
	/**
	 * User's Address Line 2
	 * 
	 * @var string $address1
	 */
	public $address2;
	
	/**
	 * User's City
	 * 
	 * @var string $city
	 */
	public $city;
	
	/**
	 * User's State
	 * 
	 * @var string $zip
	 */
	public $state;
	
	/**
	 * User's Zip Code
	 * 
	 * @var string $zip
	 */
	public $zip;
	
	/**
	 * User's Country
	 * 
	 * @var string $country
	 */
	public $country;

	/**
	 * The amount to be charged one time
	 * for Direct and by period in Recurring
	 * 
	 * @var float $amount
	 */
	public $amount;
	
	/**
	 * The currency ID
	 * For paypal pro to work this NEEDS to be USD
	 * 
	 * @var string $currencyID
	 */
	public $currencyID;	
	
	/**
	 * The user's phone number
	 * 
	 * @var string $phone
	 */
	public $phone;
	
	/**
	 * The user's email
	 * 
	 * @var string $email
	 */
	public $email;	
	
	/**
	 * Error holder
	 * 
	 * @var object $errors
	 */
	public $errors;
	
	/**
	 * Service::__construct()
	 * 
	 * It includes the needed files, instantiates
	 * some of the members and classes and sets 
	 * the corresponding environment
	 */
	public function __construct() {
		
		/** Set the api details from the config file **/
		require_once('paypal/config/userdetails.php');		
		require_once('PaymentException.php');
		require_once('Transaction.php');

		/** Instatantiate Exception and Transaction **/
		$this->exceptionHandler = new PM_Exception();
		$this->log = new Transaction();
		
		/** The the required API Settings **/
		$this->apiUsername = urlencode(APIUSERNAME);
		$this->apiPassword = urlencode(APIPASSWORD);
		$this->apiSignature = urlencode(APISIGNATURE);
		$this->paypalVersion = urlencode(PAYPALVERSION);
		$this->subject = urlencode(SUBJECT);
		@$this->apiCertPath = APICERTPATH;
		$this->environment = ENVIRONMENT;
		$this->apiEndPoint = APIENDPOINT;
		
		/** Set the environment **/
		if("sandbox" === $this->environment || "beta-sandbox" === $this->environment) {
			$this->apiEndPoint = "https://api-3t.$this->environment.paypal.com/nvp";
		}
	}
	
	/**
	 * Sends the request via CURL to the 
	 * API Endpoint with the proper formating 
	 * that comes from DirectPayment or RecurringPayment
	 * classes. 
	 * 
	 * 
	 * @param string $methodName ('GetRecurringPaymentsProfileDetails', 'CreateRecurringPaymentsProfile')
	 * @param string $requestString the preformated string
	 */
	protected function sendRequest($methodName, $requestString = false){
		
		$subjectMethods = array('GetRecurringPaymentsProfileDetails', 'CreateRecurringPaymentsProfile');
		
		/** Store the method name **/
		$this->methodCalled = $methodName;
		
		/** Launch the request **/
		try{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->apiEndPoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
	
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);	

		/** Add API Credentials tot the request **/
		$nvpRequest = "METHOD={$methodName}";
		$nvpRequest .= "&VERSION={$this->paypalVersion}";
		$nvpRequest .= "&PWD={$this->apiPassword}";
		$nvpRequest .= "&USER={$this->apiUsername}";
		
		/** Add a subject for Recurring **/
		if(in_array($methodName, $subjectMethods) !== false){
			$nvpRequest .= "&SUBJECT={$this->subject}";
		}
		
		$nvpRequest .= "&SIGNATURE={$this->apiSignature}{$requestString}";
	
		/** Set the fields in CURL **/
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpRequest);
	
		
		$httpResponse = curl_exec($ch);
	
		
		if (curl_errno($ch)) {
			throw new PM_Exception(curl_error($ch), curl_errno($ch));
		 } else {
			 curl_close($ch);
		}
	
		/** Format the response **/
		$response = $this->extractResponse($httpResponse);	
		
		/** And log it **/
		$this->log->logTransaction($response, $methodName);
		}	catch (PM_Exception $e) {
			//die($e->getMessage());
			$res = array(
				'success' => FALSE,
				'message' => "<div class='form_error'> - Paypal Error: {$e->getMessage()}, please try again </div>"
			);
			print json_encode($res);
			die();
		}
		return $response;
			
	}
	
	/**
	 * Extracts an array from the string ugly
	 * response we get from PayPal and return the proper
	 * error if it fails to do so 
	 * 
	 * @param string $httpResponse
	 * @return array $httpParsedResponseAr
	 */
	private function extractResponse($httpResponse) {
		// Extract the response details.
		$httpResponseAr = explode("&", $httpResponse);
	
		$httpParsedResponseAr = array();
		
		/** BUild the array with key=>value pairs **/
		foreach ($httpResponseAr as $i => $value) {
			$tmpAr = explode("=", $value);
			if(sizeof($tmpAr) > 1) {
				$httpParsedResponseAr[$tmpAr[0]] = urldecode($tmpAr[1]);
			}
		}
	
		if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
			throw new PM_Exception("Invalid HTTP Response for POST request($httpResponse) to $this->apiEndPoint.");
		}
	
		return $httpParsedResponseAr;	
	}
	
	/**
	 * Error handler callable
	 * used to interface with the exception 
	 * class and set errors locally without 
	 * ternary initialization
	 * 
	 * return true
	 */
	protected function setErrors(){
		$errors = $this->exceptionHandler->getErrors();
		$this->errors->{$this->methodCalled} = $errors;
		
		return true;
	}
	
}
