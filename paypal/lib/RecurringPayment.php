<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * RecurringPayment library
 *
 * This file holds the methods to run and retrieve 
 * information relative to the reccurring payments
 * available via PayPal API
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

class RecurringPayment extends Service{
	
	/** Charge function container **/
	public $charge;
	
	/** ProfileInfo container **/
	public $info;
	
	/** Information for recurring **/
	
	private $failedInitAmountAction;
	
	/**
	 * (Required) Description of the recurring payment.
	 * @var string $description
	 */
	public $description;
	
	/**
	 * (Required) Number of billing periods that make up one billing cycle.
	 * The combination of billing frequency and billing period must be less than or equal to
     * one year.
	 * @var int $billingFrequency
	 */
	public $billingFrequency;
	
	/**
	 * (Required) Unit for billing during this subscription period.
	 *	One of the following values:
	 *	 Day
	 *	 Week
	 *	 SemiMonth
	 *	 Month
	 *	 Year
	 * 
	 * @var string $billingPeriod
	 */
	public $billingPeriod;
			
	/**
	 * (Optional) The number of billing cycles for payment period.
	 * 
	 * @var int $totalBillingCycles defaults to 0
	 */
	public $totalBillingCycles = 0;
	
	/** 
	 * (Optional) The number of scheduled payments that can fail before the profile is
	 * automatically suspended. An IPN message is sent to the merchant when the specified
	 * number of failed payments is reached.
	 * 
	 * @var int $maxFailedPayments defaults to 0
	 */
	public $maxFailedPayments = 0;
	
	/**
	 * The date when billing for this profile begins.
	 * Must be a valid date, in UTC/GMT format.
	 * 
	 * The date is formed within the code.
	 * 
	 * @var int $profileStartDateDay
	 * @var int $profileStartDateMonth
	 * @var int $profileStartDateYear
	 */
	public $profileStartDateDay;
	public $profileStartDateMonth;
	public $profileStartDateYear;
	
	/**
	 * (Optional) Initial non-recurring payment amount due immediately upon profile
	 * creation. Use an initial amount for enrolment or set-up fees.
	 * 
	 * @var int $initialAmount
	 * @example 3
	 */
	public $initialAmount = 0;
	
	/**
	 * (Optional) Tax amount for each billing cycle during this payment period.
	 * 
	 * @var int $taxAmount defaults to 0
	 * @example 5
	 */
	public $taxAmount = 0;
	
	/**
	 * Person’s name associated with this shipping address. Required if using a
	 * shipping address.
	 * @var string $shipName
	 */
	public $shipName;
	
	/**
	 * First street address. Required if using a shipping address.
	 * Character length and limitations: 100 single-byte characters
	 * 
	 * @var string $shipStreet
	 */
	public $shipStreet;
	
	/**
	 * (Optional) Second street address.
	 * Character length and limitations: 100 single-byte characters.
	 * 
	 * @var string $shipStreet
	 */
	public $shipStreet2;
	
	/** 
	 * Name of city. Required if using a shipping address.
	 * Character length and limitations: 40 single-byte characters.
	 * 
	 * @var string $shipCity
	 */
	public $shipCity;
	
	/** 
	 * State or province. Required if using a shipping address.
	 * Character length and limitations: 40 single-byte characters.
	 * 
	 * @var string $shipState
	 */
	public $shipState;
	
	/**
	 * U.S. ZIP code or other country-specific postal code. Required if using a U.S.
 	 * shipping address; may be required for other countries.
	 * Character length and limitations: 20 single-byte characters.
	 * 
	 * @var string $shipZip
	 */
	public $shipZip;
	
	/** Country code. Required if using a shipping address.
	* Character limit: 2 single-byte characters.
	* 
	* @var string $shipCountry
	*/
	public $shipCountry;
	
	/**
	 * (Optional) Phone number.
	 * Character length and limit: 20 single-byte characters.
	 * 
	 * @var strin $shipPhone 
	 */
	public $shipPhone;
	
	/**
	 * (Optional) Shipping amount for each billing cycle during this payment period.
	 * 
	 * @var int $shipAmount
	 */
	public $shipAmount = 0;
	
	
	/**
	 * This field indicates whether you would like PayPal to 
	 * automatically bill the outstanding balance amount in 
	 * the next billing cycle.
	 * 
	 * Allowed values: NoAutoBill or AddToNextBilling
	 * 
	 * @var string
	 * @example: NoAutoBill.
	 */
	public $autoBillAmount = 'NoAutoBill';
	
	
	/** Trial periods **/
	/**
	 * Unit for billing during this subscription period; required if you specify an optional
	 * trial period.
	 * One of the following values:
	 *		Day
	 * 		Week
	 * 		SemiMonth
	 * 		Month
	 * 		Year
	 *	For SemiMonth, billing is done on the 1st and 15th of each month.
	 * @var string $trialBillingPeriod
	 * @example Month
	 */
	public $trialBillingPeriod;
	
	/**
	 * Number of billing periods that make up one billing cycle; required if you specify an
	 * optional trial period.
	 * 
	 * @var int $trialBillingFrequency
	 * @example 12
	 */
	public $trialBillingFrequency;
	
	
	/**
	 * Billing amount for each billing cycle during this payment period; required if you
	 * specify an optional trial period. This amount does not include shipping and tax
	 * amounts
	 * 
	 * @var int $trialAmount
	 * @example 50
	 */
	public $trialAmount;
	
	/**
	 * (Optional) The number of billing cycles for trial payment period.
	 * 
	 * @var int $trialTotalBillingCycles
	 * @example 5
	 */
	public $trialTotalBillingCycles;
	
	
	/**
	 * Class Construct
	 * 
	 * Calls the \Payment\Service class construct
	 */
	public function __construct(){
		parent::__construct();
	}

	/**
	 * Builds a NVP request that is sent to the sendRequest function
	 * 
	 * All the values here are urlencoded as per PayPal requests
	 * and all the date fields are padded 0.
	 * 
	 * @param null
	 * @see \Payment\Service::sendRequest();
	 * @return string $request - The PayPal request string
	 */
	private function buildNvpRecurringRequest(){
		
		
		/** URL encoding members **/
		$this->paymentType = urlencode('Authorization');
		$this->amount = urlencode($this->amount);
		$this->creditCardType = urlencode($this->creditCardType);
		$this->creditCardNumber = urlencode($this->creditCardNumber);	
		$this->cvv2Number = urlencode($this->cvv2Number);
		$this->firstName = urlencode($this->firstName);
		$this->lastName = urlencode($this->lastName);
		$this->address1 = urlencode($this->address1);
		$this->address2 = urlencode($this->address2);
		$this->city = urlencode($this->city);
		$this->state = urlencode($this->state);
		$this->zip = urlencode($this->zip);
		$this->country = $this->country;
		$this->currencyID = urlencode('USD');
		$this->description = urlencode($this->description);
		$this->billingPeriod = urlencode($this->billingPeriod);
		$this->billingFrequency = urlencode($this->billingFrequency);
		$this->totalBillingCycles = urlencode($this->totalBillingCycles);
		$this->phone = urlencode($this->phone);
		$this->shipName = urlencode($this->shipName);
		$this->shipStreet = urlencode($this->shipName);
		$this->shipStreet2 = urlencode($this->shipName);
		$this->shipCity = urlencode($this->shipCity);
		$this->shipState = urlencode($this->shipState);
		$this->shipZip = urlencode($this->shipZip);
		$this->shipCountry = urlencode($this->shipCountry);
		$this->shipPhone = urlencode($this->shipPhone);

		/** Padding date/time formats **/
		$paddedProfileStartDateDay = str_pad($this->profileStartDateDay, 2, '0', STR_PAD_LEFT);				
		$paddedProfileStartDateMonth = str_pad($this->profileStartDateMonth, 2, '0', STR_PAD_LEFT);		
		$paddedExpiration = urlencode(str_pad($this->expDateMonth, 2, '0', STR_PAD_LEFT));
		$paddedExpiration .= $this->expDateYear;
		
		$profileStartDate = urlencode($this->profileStartDateYear . '-' . $paddedProfileStartDateMonth . '-' . $paddedProfileStartDateDay . 'T00:00:00Z'); 
		
		
		/** Building the request string **/
		$request = "&AMT={$this->amount}";
		$request .= "&CREDITCARDTYPE={$this->creditCardType}";
		$request .= "&ACCT={$this->creditCardNumber}";
		$request .= "&EXPDATE={$paddedExpiration}";
		$request .= "&CVV2={$this->cvv2Number}";
		$request .= "&FIRSTNAME={$this->firstName}";
		$request .= "&LASTNAME={$this->lastName}";
		$request .= "&STREET={$this->address1}";
		$request .= "&STREET2={$this->address2}";
		$request .= "&CITY={$this->city}";
		$request .= "&STATE={$this->state}";
		$request .= "&ZIP={$this->zip}";
		$request .= "&COUNTRYCODE=US";
		$request .= "&PHONENUM={$this->phone}";
		$request .= "&CURRENCYCODE={$this->currencyID}";
		$request .= "&PROFILESTARTDATE=$profileStartDate";
		$request .= "&DESC={$this->description}";
		
		$request .= "&BILLINGPERIOD={$this->billingPeriod}";
		$request .= "&BILLINGFREQUENCY={$this->billingFrequency}";
		$request .= "&TOTALBILLINGCYCLES={$this->totalBillingCycles}";
		$request .= "&MAXFAILEDPAYMENTS={$this->maxFailedPayments}";
		$request .= "&AUTOBILLOUTAMT={$this->autoBillAmount}";
		
		$request .= "&SHIPPINGAMT={$this->shipAmount}";
		$request .= "&TAXAMT={$this->taxAmount}";
		$request .= "&EMAIL={$this->email}";
		
		/** Shipping details **/
		$request .= "&SHIPTONAME={$this->shipName}";
		$request .= "&SHIPTOSTREET={$this->shipStreet}";
		$request .= "&SHIPTOSTREET2={$this->shipStreet2}";
		$request .= "&SHIPTOCITY={$this->shipCity}";
		$request .= "&SHIPTOSTATE={$this->shipState}";
		$request .= "&SHIPTOZIP={$this->shipZip}";
		$request .= "&SHIPTOCOUNTRY={$this->shipCountry}";
		$request .= "&SHIPTOPHONENUM={$this->shipPhone}";
		
		/** Trial details **/
		$request .= "&TRIALBILLINGPERIOD={$this->trialBillingPeriod}";
		$request .= "&TRIALAMT={$this->trialAmount}";
		$request .= "&TRIALBILLINGFREQUENCY={$this->trialBillingFrequency}";
		$request .= "&TRIALTOTALBILLINGCYCLES={$this->trialTotalBillingCycles}";
		
		if($this->initialAmount) {
			$request .= "&INITAMT={$this->initialAmount}"; 
		}
		
		return $request;
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
	public function charge(){
		$httpParsedResponseAr = $this->sendRequest('CreateRecurringPaymentsProfile', $this->buildNvpRecurringRequest());	
		
		if($this->exceptionHandler->filter($httpParsedResponseAr)){
			$this->setChargeResponse($httpParsedResponseAr, 'charge');
			return true;
		}	else	{
			$this->setErrors();
			return false;
		}		
	}
	
	
	
	/**
	 * Transforms the response of the request
	 * into the single instantiate object, on a second
	 * tier under $this->charge
	 * 
	 * @param array $httpParsedResponseAr the response array
	 * @param string $primaryKey can be info or charge
	 * @return object $this
	 */
	private function setChargeResponse($httpParsedResponseAr, $primaryKey){
		foreach($httpParsedResponseAr as $key=>$value){
			$key = strtolower($key);
			if($key != "profileid") {				
				$this->{$primaryKey}->{$key} = $value;
			}	else	{
				$this->transactionID = $value;
			}
		}
		
		return $this;
	}
	
	/** 
	 * Makes a call to the Service::sendRequest
	 * with the transactionID in order to get
	 * the profile information
	 * 
	 * @param string $profileID[optional]
	 */
	public function info($profileID = false){
		try{
			if(! $profileID && ! $this->transactionID) {
				throw new Exception('A valid transactionID must be passed along as a paramter');
			}	else	{
				if(! $profileID) {
					$profileID = $this->transactionID;
				}
				$request = "&PROFILEID=$profileID";
				
				$httpParsedResponseAr = $this->sendRequest('GetRecurringPaymentsProfileDetails', $request);					
				if($this->exceptionHandler->filter($httpParsedResponseAr)){
					$this->setChargeResponse($httpParsedResponseAr, 'info');
					return true;
				}	else	{
					$this->setErrors();
					return false;
				}					
			}
		}	catch (Exception $e)	{
			$e->getMessage();
		}
	}
}