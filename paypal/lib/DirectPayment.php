<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Direct Payment library
 *
 * Holds members and calls for the Direct Payments
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
require_once('Service.php');

Class DirectPayment extends Service {
	
	/**
	 * The response transactions ID we get
	 * 
	 * @var string $transactionID
	 */
	public $transactionID;
	
	/** 
	 * The amount to be captured.
	 * Can not be higher than the total.
	 * 
	 * @var float $captureAmount
	 */	
	public $captureAmount;
	
	/**
	 * A short message attached to each capture
	 * 
	 * @var string $captureNote
	 */
	public $captureNote;
	
	/**
	 * Capture information holder
	 * 
	 * @var object $capture
	 */
	public $capture;
	
	/**
	 * Charge information holder
	 * 
	 * @var object $capture
	 */
	public $charge;
	
	public function __construct(){
		parent::__construct();		
	}
	/*
	 * Builds a NVP request that is sent to the sendRequest function
	 * 
	 * All the values here are urlencoded as per PayPal requests
	 * and all the date fields are padded 0.
	 * 
	 * @param null
	 * @see \Payment\Service::sendRequest();
	 * @return string $response - The PayPal request string
	 */
	private function buildNvpRequest(){
	
		/** Url encode what is needed **/
		$this->paymentType = urlencode('Authorization');
		$this->amount = urlencode($this->amount);
		$this->creditCardType = urlencode($this->creditCardType);
		$this->creditCardNumber = urlencode($this->creditCardNumber);	
		$this->cvv2Number = urlencode($this->cvv2Number);
		$this->firstName = urlencode($this->firstName);
		$this->lastName = urlencode($this->lastName);
		$this->address1 = urlencode($this->address1);
		$this->city = urlencode($this->city);
		$this->state = urlencode($this->state);
		$this->zip = urlencode($this->zip);
		$this->country = $this->country;
		$this->currencyID = urlencode('USD');
		
		/** Pad the date **/
		$paddedExpiration = urlencode(str_pad($this->expDateMonth, 2, '0', STR_PAD_LEFT));
		$paddedExpiration .= $this->expDateYear;
		
		/** Build the string **/
		$response =	"&PAYMENTACTION={$this->paymentType}";
		$response .= "&AMT={$this->amount}";
		$response .= "&CREDITCARDTYPE={$this->creditCardType}";
		$response .= "&ACCT={$this->creditCardNumber}";
		$response .= "&EXPDATE={$paddedExpiration}";
		$response .= "&CVV2={$this->cvv2Number}";
		$response .= "&FIRSTNAME={$this->firstName}";
		$response .= "&LASTNAME={$this->lastName}";
		$response .= "&STREET={$this->address1}";
		$response .= "&CITY={$this->city}";
		$response .= "&STATE={$this->state}";
		$response .= "&ZIP={$this->zip}";
		$response .= "&COUNTRYCODE={$this->country}";
		$response .= "&CURRENCYCODE={$this->currencyID}";
			
		return $response;
	}
	
	/**
	 * The charge function performs the recurring charge
	 * by calling CreateRecurringPaymentsProfile in the 
	 * PayPal API.
	 * 
	 * The function uses Service::sendRequest to create 
	 * the API request. On succes it stores the data and on
	 * failure it store the errors.
	 * 
	 * return $this containing the transaction details;
	 * 
	 * @param null;
	 * @return bool true/false
	 */
	public function charge() {
		$httpParsedResponseAr = $this->sendRequest('DoDirectPayment', $this->buildNvpRequest());	
		if($this->exceptionHandler->filter($httpParsedResponseAr)){
			$this->setDirectPaymentResponse($httpParsedResponseAr);
			return true;
		}	else	{
			$this->setErrors();
			return false;
		}		
	}
	
	/**
	 * Transforms the array got as a reponse to the request
	 * keys and values into members of the declared object	
	 * 
	 * @param array $httpParsedResponseAr
	 */
	public function setDirectPaymentResponse($httpParsedResponseAr){
				
		$this->charge->cvv2match = $httpParsedResponseAr['CVV2MATCH'];
		$this->charge->avsCode = $httpParsedResponseAr['AVSCODE'];
		$this->charge->correlationID = $httpParsedResponseAr['CORRELATIONID'];
		$this->transactionID = $httpParsedResponseAr['TRANSACTIONID'];
		$this->charge->response = $httpParsedResponseAr['ACK'];
		
	}
	
	/**
	 * Launches the request to capture with the formated
	 * string to Service::sendRequest. On error
	 * it returns falls and sets the errors using
	 * Service::setErrors and on succes it populates
	 * the $this->charge member
	 * 
	 * @param null
	 * @return bool true/false
	 */
	public function capture(){
		
		/** Set the needed members **/
		$this->transactionID = urlencode($this->transactionID);
		$this->captureAmount = urlencode($this->captureAmount);
		$this->captureNote = urlencode($this->captureNote);

		/** Set the capture type **/
		$capture = urlencode('NotComplete');
		if($this->amount == $this->captureAmount) {
			$capture = urlencode('Complete');
		}	
		
		/** Create the request string **/
		$request = "&AUTHORIZATIONID={$this->transactionID}";
		$request .= "&AMT={$this->captureAmount}";
		$request .= "&COMPLETETYPE={$capture}";
		$request .= "&CURRENCYCODE={$this->currencyID}";
		$request .= "&NOTE={$this->captureNote}";
		
		/** Send the request **/
		$httpParsedResponseAr = $this->sendRequest('DoCapture', $request);	
		
		/** Store the errors or the info **/
		if($this->exceptionHandler->filter($httpParsedResponseAr)){
			$this->setCaptureResponse($httpParsedResponseAr);
			return true;
		}	else	{
			$this->setErrors();
			return false;
		}		
	}
	
	/**
	 * Transforms the array got as a reponse to the request
	 * keys and values into members of the declared object	
	 * 
	 * @param array $httpParsedResponseAr
	 * @return an object containing:		
	 *	    [AUTHORIZATIONID]
	 *	    [TIMESTAMP]
	 *	    [CORRELATIONID]
	 *	    [ACK]
	 *	    [VERSION]
	 *	    [BUILD]
	 *	    [TRANSACTIONID]
	 *	    [PARENTTRANSACTIONID]
	 *	    [RECEIPTID]
	 *	    [TRANSACTIONTYPE]
	 *	    [PAYMENTTYPE]
	 *	    [ORDERTIME]
	 *	    [AMT]
	 *	    [FEEAMT]
	 *	    [TAXAMT]
	 *	    [CURRENCYCODE]
	 *	    [PAYMENTSTATUS]
	 *	    [PENDINGREASON]
	 *	    [REASONCODE]
	 *	    [PROTECTIONELIGIBILITY]
	 *	
     *  Set by hand for consistency 
	 */
	private function setCaptureResponse($httpParsedResponseAr){
		
		$this->capture->timestamp = $httpParsedResponseAr['TIMESTAMP'];
		$this->capture->correlationID = $httpParsedResponseAr['CORRELATIONID'];
		$this->capture->ack = $httpParsedResponseAr['ACK'];
		$this->capture->version = $httpParsedResponseAr['VERSION'];
		$this->capture->authorizationID = $httpParsedResponseAr['AUTHORIZATIONID'];
		$this->capture->build = $httpParsedResponseAr['BUILD'];
		$this->capture->parentTransactionID = $httpParsedResponseAr['PARENTTRANSACTIONID'];
		$this->capture->transactionID = $httpParsedResponseAr['TRANSACTIONID'];		
		$this->capture->receiptID = $httpParsedResponseAr['RECEIPTID'];
		$this->capture->transactionType = $httpParsedResponseAr['TRANSACTIONTYPE'];
		$this->capture->paymentType = $httpParsedResponseAr['PAYMENTTYPE'];
		$this->capture->ordertime = $httpParsedResponseAr['ORDERTIME'];
		$this->capture->amount = $httpParsedResponseAr['AMT'];
		$this->capture->feeAmount = $httpParsedResponseAr['FEEAMT'];		
		$this->capture->taxAmount = $httpParsedResponseAr['TAXAMT'];
		$this->capture->currency = $httpParsedResponseAr['CURRENCYCODE'];
		$this->capture->paymentStatus = $httpParsedResponseAr['PAYMENTSTATUS'];
		$this->capture->pendingReason = $httpParsedResponseAr['PENDINGREASON'];
		$this->capture->reasonCode = $httpParsedResponseAr['REASONCODE'];
		$this->capture->protectionEligibility = $httpParsedResponseAr['PROTECTIONELIGIBILITY'];
		
		return $this;
	}
}