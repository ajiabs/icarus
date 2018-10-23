<?php 

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : Payment.php                                         		  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems � 2010                                    |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

class Payments{
	
	 

	/*
	 * function to make the authorize payment
	 */
 	public static function authorize($arrPaymentInfo, $overrideAuthorizeTransMode = FALSE) 	{
 
  		// Including the authorize payment file.

	   	PageContext::includePath('paymentgateways/authorize');
	   	$authorizeObj   = new  Authorize_class();
        
  		// Get the authorize payment settings.

	   	$paySettings 	= Payments::getAuthorizeSettings();  
	   	$authorizeInfo 	= array();

	  	// Assign the authorize payment settings values.

   		$authorizeInfo['x_login'] 			= $paySettings['authorizeLoginId'];
   		$authorizeInfo['x_tran_key'] 		= $paySettings['authorizeTransKey'];
		$authorizeInfo['email'] 			= $paySettings['authorizeEmail'];
		$authorizeInfo['testMode'] 			= $paySettings['authorizeTestMode'];
        
		// Assign the user information and card details.

   		$authorizeInfo['desc'] 				= $arrPaymentInfo['desc'];
   		$authorizeInfo['currency_code'] 	= $arrPaymentInfo['Currency'];
  		$authorizeInfo['amount'] 			= $arrPaymentInfo['amount'];
   		$authorizeInfo['expMonth'] 			= $arrPaymentInfo['expMonth'];
   		$authorizeInfo['expYear'] 			= $arrPaymentInfo['expYear'];
   		$authorizeInfo['cvv'] 				= $arrPaymentInfo['cvv'];
   		$authorizeInfo['ccno'] 				= $arrPaymentInfo['ccno'];
   		$authorizeInfo['fName'] 			= $arrPaymentInfo['fName'];
   		$authorizeInfo['lName'] 			= $arrPaymentInfo['lName'];
   		$authorizeInfo['add1'] 				= $arrPaymentInfo['add1'];
   		$authorizeInfo['city'] 				= $arrPaymentInfo['city'];
   		$authorizeInfo['state'] 			= $arrPaymentInfo['state'];
   		$authorizeInfo['country'] 			= $arrPaymentInfo['country'];
   		$authorizeInfo['zip'] 				= $arrPaymentInfo['zip'];

 
   		if($overrideAuthorizeTransMode){
        	$return 	= $authorizeObj->submit_authorize_post($authorizeInfo);
   		}else{
        	if($settings['AuthorizeTransMode'] == 'AUTH_ONLY')  // If auth only , we should capture the amount at a later point
            	$return 	= self::authoriseFutureCaptureFromAuthorizeNet($authorizeInfo);   
        	else
            	$return 	= $authorizeObj->submit_authorize_post($authorizeInfo);
   		}


   		$details 	                                = $return[0];
   		$transaction_id                             = $return[1];
   		switch ($details)	{
       		case "1": // Credit card successfully charged.
	       		$paymentsuccessful 	                = 1;
	       		$transactionid 		                = $return[6];
       		break;

       		case "2":// Invalid credit card.
	       		$paymentsuccessful 	                = 0;
	       		$paymenterror 		                = 'The card has been declined <br />' . $return[3];
	       		$transactionid 		                = NULL;
       		break;

	       	case "4":
	       		$paymentsuccessful 	                = 0;
	       		$paymenterror 		                = 'The card has been held for review<br /> ' . $return[3];
	       		$transactionid 		                = NULL;
	       	break;
	
	       	default: // Credit card not successfully charged.
	       		$paymentsuccessful 	               = 0;
	       		$paymenterror 		               = 'Error <br />' . $return[3];
	       		$transactionid 		               = NULL;
	       	break;
	    }
        
    	$paymentResult['Amount'] 		= $dataArr['amount'];
    	$paymentResult['success'] 		= $paymentsuccessful;
    	$paymentResult['Message'] 		= $paymenterror;
    	$paymentResult['TransactionId'] = $transactionid;

    	return $paymentResult;
 }
 
 
	/*
	 * function to get the authorize settings
	 */
	public static function getAuthorizeSettings() 	{
   		$dbObj 			= new Db();
   		$paySettings 	= array();
   		$paySettings['authorizeEnable']     =   $dbObj->selectRow("lookup","vLookUp_Value","vLookUp_Name='cenable_authorize'");
   		$paySettings['authorizeLoginId']    =   $dbObj->selectRow("lookup","vLookUp_Value","vLookUp_Name='vauthorize_loginid'");
   		$paySettings['authorizeTransKey']   =   $dbObj->selectRow("lookup","vLookUp_Value","vLookUp_Name='vauthorize_transkey'");
   		$paySettings['authorizeEmail']      =   $dbObj->selectRow("lookup","vLookUp_Value","vLookUp_Name='vauthorize_email'");
   		$paySettings['authorizeTestMode']   =   $dbObj->selectRow("lookup","vLookUp_Value","vLookUp_Name='vauthorize_test_mode'");
   		return $paySettings;
	}
	
	
	/*
	 * public function to add data into transcations table
	 */
	public static function addTransaction($arrTransact){
		$db                    =   new Db();
        $tableName             =   Utils::setTablePrefix('transactions');
        $transactId            =   $db->insert($tableName,$arrTransact); 
		return $transactId;
	}
    
	
	
	/*
	 * public function for gt payment
	 */
	public static function gtPayment($paymentParams){
		return '<html>
				<body onload="document.submit2gtpay_form.submit()">
				<form name="submit2gtpay_form" action="https://ibank.gtbank.com/GTPay/Tranx.aspx" target="_self" method="post">
				<input type="hidden" name="gtpay_mert_id" value="'.$paymentParams['gtpay_mert_id'].'" />
				<input type="hidden" name="gtpay_tranx_id" value="'.$paymentParams['gtpay_tranx_id'].'" />
				<input type="hidden" name="gtpay_tranx_amt" value="'.$paymentParams['gtpay_tranx_amt'].'" />
				<input type="hidden" name="gtpay_tranx_curr" value="'.$paymentParams['gtpay_tranx_curr'].'" />
				<input type="hidden" name="gtpay_cust_id" value="'.$paymentParams['gtpay_cust_id'].'" />
				<input type="hidden" name="gtpay_cust_name" value="'.$paymentParams['gtpay_cust_name'].'" />
				<input type="hidden" name="gtpay_tranx_memo" value="'.$paymentParams['gtpay_tranx_memo'].'" />
				<input type="hidden" name="gtpay_no_show_gtbank" value="'.$paymentParams['gtpay_no_show_gtbank'].'" />
				<input type="hidden" name="gtpay_echo_data" value="'.$paymentParams['gtpay_echo_data'].'" />
				<input type="hidden" name="gtpay_gway_name" value="'.$paymentParams['gtpay_gway_name'].'" />
				<input type="hidden" name="gtpay_tranx_noti_url" value="'.$paymentParams['gtpay_tranx_noti_url'].'" />
				<input type="submit" value="Click here if you do not redirect automatically" name="btnSubmit"/>
				</form>
				</body>
				</html>';
		
	}
	
	
	
	/*
	 * function to get the GTPay settings
	 */
	public static function gtPaySettings(){
		
		$dbObj 			= new Db();
   		$gtPaySettings 	= array();
   		$gtPaySettings['gtpay_mert_id']     	=   $dbObj->selectRow("lookup","vLookUp_Value","vLookUp_Name='gtpay_mert_id'");
   		$gtPaySettings['gtpay_tranx_curr']    	=   $dbObj->selectRow("lookup","vLookUp_Value","vLookUp_Name='gtpay_tranx_curr'");
   		$gtPaySettings['gtpay_no_show_gtbank']  =   $dbObj->selectRow("lookup","vLookUp_Value","vLookUp_Name='gtpay_no_show_gtbank'");
   		//$gtPaySettings['authorizeEmail']      =   $dbObj->selectRow("lookup","vLookUp_Value","vLookUp_Name='vauthorize_email'");
   		//$gtPaySettings['authorizeTestMode']   =   $dbObj->selectRow("lookup","vLookUp_Value","vLookUp_Name='vauthorize_test_mode'");
   		return $gtPaySettings;
		
	}
	
	/*
	 * function to convert the dollor into nigerian amount
	 */
	public static function convertDollorToNaira($amt){
		return '6000';
	}
    
}


?>