<?php

class Authorize_class {

   var $last_error;                 // holds the last error encountered   

   var $fields = array();           // array holds the fields to submit to paypal


   function authorize_class() {

      // initialization constructor.  Called when class is created.


       $this->authorize_url = ' https://www.sandbox.paypal.com/cgi-bin/webscr';

      $this->last_error = '';

      $this->ipn_log_file = '.ipn_results.log';
      $this->ipn_log = true;
      $this->ipn_response = '';

      // populate $fields array with a few default values.  See the paypal
      // documentation for a list of fields and their data types. These defaul
      // values can be overwritten by the calling script.

      $this->add_field('rm','2');           // Return method = POST
      $this->add_field('cmd','_xclick');

   }

   function add_field($field, $value) {

      // adds a key=>value pair to the fields array, which is what will be
      // sent to paypal as POST variables.  If the value is already in the
      // array, it will be overwritten.

      $this->fields["$field"] = $value;
   }

   function submit_authorize_post($authorizeInfo = array()) {



    $referrer =  $_SERVER["HTTP_REFERER"];
    $x_customdata = "Custom";

    $x_Login = urlencode($authorizeInfo['x_login']); // your login
    $x_tran_key = urlencode($authorizeInfo['x_tran_key']); // Tran Key

    $x_currency_code = urlencode($authorizeInfo['currency_code']);
    $x_Delim_Data = urlencode("TRUE");
    $x_Delim_Char = urlencode(",");
    $x_Encap_Char = urlencode("");
    $x_Type = urlencode("AUTH_CAPTURE");

    $x_ADC_Relay_Response = urlencode("FALSE");


    if($authorizeInfo['testMode'] == 1)
    {
        // echopre1($authorizeInfo);
	      $x_Test_Request = urlencode("TRUE"); // Remove this line of code when you are ready to go live
    }
     


    // Customer Information
    $x_Method = urlencode("CC");
    $x_Amount = $authorizeInfo['amount'];
    $x_Tax=0;
    $x_Freight=0;
    $x_First_Name = urlencode($authorizeInfo['fName']);
    $x_Last_Name = urlencode($authorizeInfo['lName']);
    $x_Card_Num = urlencode($authorizeInfo['ccno']);
    $ExpDate = ($authorizeInfo['expMonth'] . $authorizeInfo['expYear']);
    $x_Exp_Date = urlencode($ExpDate);
    $x_card_code = urlencode($authorizeInfo['cvv']);

    $x_Address = urlencode($authorizeInfo['add1']);
    $x_City = urlencode($authorizeInfo['city']);
    $x_State = urlencode($authorizeInfo['state']);
    $x_Zip = urlencode($authorizeInfo['zip']);
    $x_country = urlencode($authorizeInfo['country']);
    $x_Email = '';
    $x_Email_Customer = urlencode("TRUE");
    $x_Merchant_Email = urlencode($authorizeInfo['email']); //  Replace MERCHANT_EMAIL with the merchant email address

    // Build fields string to post

    $x_cust_ip = urlencode($Cust_ip);
    $x_company = urlencode($Company);
    $x_phone = urlencode($Phone);
    $x_cust_id = urlencode($Cust_id);
    $x_invno=urlencode($Inv_id);
    $x_description=urlencode($authorizeInfo['desc'])."  purchase ";

    $fields = "x_Version=3.1&x_Login=$x_Login&x_tran_key=$x_tran_key&x_Delim_Data=$x_Delim_Data&x_Delim_Char=$x_Delim_Char&x_Encap_Char=$x_Encap_Char";
    $fields .= "&x_Type=$x_Type&x_Test_Request=$x_Test_Request&x_Method=$x_Method&x_Amount=$x_Amount&x_First_Name=$x_First_Name";
    $fields .= "&x_Last_Name=$x_Last_Name&x_Card_Num=$x_Card_Num&x_Exp_Date=$x_Exp_Date&x_card_code=$x_card_code&x_Address=$x_Address&x_City=$x_City&x_State=$x_State&x_Zip=$x_Zip&x_country=$x_country&x_Email=$x_Email&x_Email_Customer=$x_Email_Customer&x_Merchant_Email=$x_Merchant_Email&x_ADC_Relay_Response=$x_ADC_Relay_Response&x_invid=$x_invid&x_cust_ip=$x_cust_ip&x_company=$x_company&x_phone=$x_phone&x_cust_id=$x_cust_id&x_invoice_num=$x_invno&x_description=$x_description&x_tax=$x_Tax&x_freight=$x_Freight";


    

    //echo $fields;

    // Start CURL session

    $authurl="https://secure.authorize.net/gateway/transact.dll";

    if($authorizeInfo['testMode'] == "1")
    {
            $authurl="https://test.authorize.net/gateway/transact.dll";
    }


     

    $agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)";
    $ref = $referrer;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$authurl);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_NOPROGRESS, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_REFERER, $ref);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $buffer = curl_exec($ch);
    curl_close($ch);
    // This section of the code is the change from Version 1.
    // This allows this script to process all information provided by Authorize.net...
    // and not just whether if the transaction was successful or not
    // Provided in the true spirit of giving by Chuck Carpenter (Chuck@MLSphotos.com)
    // Be sure to email him and tell him how much you appreciate his efforts for PHP coders everywhere
    $return = preg_split("/[,]+/", "$buffer"); // Splits out the buffer return into an array so . . .
    $details = $return[0]; // This can grab the Transaction ID at position 1 in the array



    return $return;

    






   }

  

   
 
}



