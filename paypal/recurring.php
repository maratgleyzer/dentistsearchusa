<?php

/** We include the file **/
include_once('lib/RecurringPayment.php');

/** Create the object and set the data **/
$transaction = new Payment\RecurringPayment();

/** Client information **/
$transaction->firstName = 'Stelian';
$transaction->lastName = 'Mocanita';
$transaction->creditCardNumber = '4199760256295108';
$transaction->creditCardType = 'Visa';
$transaction->expDateMonth = '4';
$transaction->expDateYear = '2015';
$transaction->cvv2Number = '962';
$transaction->address1 = '1 Main St';
$transaction->address2 = '1 Main St';
$transaction->city = 'San Jose';
$transaction->state = 'CA';
$transaction->zip = '95131';
$transaction->country = 'US';
$transaction->amount = '300';
$transaction->phone = '0770202429';
$transaction->email = 'Stelian.mocanita@gmail.com';

/** Recurring Information **/
$transaction->description = 'Test description body';
$transaction->billingPeriod = 'Month';
$transaction->billingFrequency = 1;
$transaction->totalBillingCycles = 25;
$transaction->profileStartDateDay = 7;
$transaction->profileStartDateMonth = '09';
$transaction->profileStartDateYear = '2010';
$transaction->shippingAmount = '5';
$transaction->taxAmount = '3';
$transaction->maxFailedPayments = 3;

/** Initial amount **/
$transaction->initialAmount = '500';

/** Shipping **/
$transaction->shipName = 'Stelian Mocanita';
$transaction->shipStreet = $transaction->address1;
$transaction->shipStreet2 = $transaction->address2;
$transaction->shipCity = $transaction->city;
$transaction->shipState = $transaction->state;
$transaction->shipZip = $transaction->zip;
$transaction->shipCountry = $transaction->country;
$transaction->shipPhone = $transaction->phone;

/** Call the charge function **/
if($transaction->charge()){
	/** all is well, print the output **/
	echo '<pre>Done with the charge<br/>';
	print_r($transaction->charge);
	/** Try to get some info **/
	if(! $transaction->info($transaction->transactionID)){
		echo 'Errors in info<br/>';
		/** Print the errors **/
		print_r($transaction->errors);
	}	else	{
		/** Print the info **/
		print_r($transaction->info);
		
		/** And even more, let's output the next billing date for example **/
		echo "next biilinb date at " . $transaction->info->nextbillingdate;
	}
	
	
}	else {
	echo '<pre>';
	print_r($transaction->errors);
}
	


