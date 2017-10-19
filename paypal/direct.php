<?php

/** Include the file **/
include_once('lib/DirectPayment.php');

/** Instantiate the class **/
$transaction = new DirectPayment();

/** Set some user details **/
$transaction->firstName = 'Stelian';
$transaction->lastName = 'Mocanita';
$transaction->creditCardNumber = '4429244859451311';
$transaction->creditCardType = 'Visa';
$transaction->expDateMonth = '01';
$transaction->expDateYear = '2012';
$transaction->cvv2Number = '962';
$transaction->address1 = '1 Main St';
$transaction->city = 'San Jose';
$transaction->state = 'CA';
$transaction->zip = '95131';
$transaction->country = 'US';
$transaction->amount = '500';

/** Try to chatge **/
if($transaction->charge()){
	/** We did it **/
	echo "The transaction finished off as {$transaction->charge->response} with the id: $transaction->transactionID <br/>";
	
	/** We can even capture here **/
	$transaction->transactionID = $transaction->transactionID;
	$transaction->captureAmount = $transaction->amount;
	$transaction->captureNote = 'We bought dresses';
	if (! $transaction->capture() ) {
		/** Capture failed, see why **/
		echo '<pre>';
		print_r($transaction->errors);
	}	else	{
		/** Capture was ok, let's see home much PayPal took **/
		echo "Capture was done and it only took:" . $transaction->capture->feeAmount . " " . $transaction->currencyID;
	}
} else	{
	/** Charge failed, be sad **/
	echo '<pre>';
	print_r($transaction->errors);
}