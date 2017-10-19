<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Transaction library
 *
 * This file holds the methods to store and retrieve
 * transaction details for the database along with
 * a persistent mysql connection
 *
 * PHP version 5.3
 * 
 *
 * @category   Library
 * @package    Payment\PayPal
 * @author     Stelian Mocanita <stelian.mocanita@gmail.com> 
 * @copyright  2010
 * @version    1.0
 * @since      File available since Release 1.0.0 
 */
//namespace Payment;

class Transaction {
	
	/** Database link identifier **/
	private $link = NULL;
	
	/**
	 * Transaction::__construct()
	 *
	 * Creates a persistent database connection 
	 * if none exists.
	 * 
	 * @access public
	 * @see Payment\Exception
	 */
	public function __construct() {
				
		if( is_null($this->link) ) {
			/** No link connection, create one **/
			require_once ('paypal/config/database.php');
			require_once ('paypal/lib/PaymentException.php');

			try {
				$this->link = mysql_pconnect(DBHOST, DBUSERNAME, DBPASSWORD) OR 
					$this->handleException('Unnable to connext to the database.');	
				mysql_select_db(DBNAME, $this->link) or
						$this->handleException('Unnable to select database ' . DBNAME);				
			} catch (Exception $e)	 {
				echo $e->getMessage();
			}
		}
	}
	
	/**
	 * Transaction::logTransaction();
	 * 
	 * @param array $dataSet - the result of the transaction
	 * @param string $type the transaction type
	 * 		  defaults to DoDirectPayment
	 * 	 	  supported: DoDirectPayment - stored as serialised
	 * 					 DoCapture - stored as serialised
	 * 					 CreateRecurringPaymentsProfile - stored as serialised
	 * @access public 
	 * @return bool true/false on succes/failure
	 */
	public function logTransaction($dataSet, $type = 'DoDirectPayment') {
		
		$resultSet = serialize($dataSet);
		$timeStamp = time();
		
		/** insert query **/
		$sql = "INSERT INTO `paypal_transactions` (`type`, `results`, `timestamp`) VALUES ('{$type}', '{$resultSet}', '{$timeStamp}');";
		return mysql_query($sql);
		
	}
	
	/**
	 * Transaction::handleException()
	 * 
	 * Throws an exception error via the Payment
	 * Error Handler
	 * 
	 * @access private
	 * @see \Payment\Exception
	 * @param string $message The error message
	 */
	private function handleException($message = false){
		throw new Exception($message);
	}
}

?>