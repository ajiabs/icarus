<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

// +----------------------------------------------------------------------+
// | File name : cls_credits.php                                         		  |
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

class Credits {
	
    /*
     * function to add new credits
     */
    public static function addCredits($arrCredits) {
        $db						= new Db();
        $creditId               = $db->addFields('credit_tracker', $arrCredits);
        return $creditId;
    }

    
    /*
     * function to get the credit history of a user
     */
    /*
    public static function getCreditHistory($appid) {
    	
    	$db                             = new Db();
		$objSearch 						= new stdClass();
		$objSearch->table				= 'credit_tracker';
		$objSearch->orderby				= 'DESC';
	  	$objSearch->orderfield			= 'ct_created_on';
		$objSearch->key  				= 'ct_id';
 		$objSearch->where				= " smb_account_id=".$appid ;
        $commentList					= $db->getData($objSearch);
        return $commentList;
    }
    */
    
    
    
     public static function getCreditHistory($appid,$orderfield='appointment_fname',$orderby='ASC',$pagenum=1,$itemperpage=10,$search='',$searchFieldArray,$arrSearchFilter) {
      
        $db = new Db();
        $objCredits                = new stdClass();
		$objCredits->table				= 'credit_tracker';
        $objCredits->key           = 'ct_id';
        $objCredits->where	  = " smb_account_id=".$appid ;
        
 
        $objCredits->groupbyfield  = '';
        $objCredits->orderby	   = $orderby;
        $objCredits->orderfield    = $orderfield;
        $objCredits->itemperpage   = $itemperpage;
        $objCredits->page	   = $pagenum;		// by default its 1
        $objCredits->debug	   = true;
        $appointments                      = $db->getData($objCredits);
        return $appointments;
    }
    
    
    
    /*
     * function to purchase cretis
     */
    public static function purchaseCredit($appid,$credit,$transactId){
    	
    	$userid					= Utils::getLoginedUserId();
    	
    	$creditValue 			= Utils::getSettings('one_credit_value');
		$newCredit  			= $creditValue * $credit;
		$db 					= new Db();				
    	$db->customQuery("UPDATE `tbl_smb_account` SET `smb_avail_credit` = smb_avail_credit+".$newCredit." WHERE `smb_acc_id` = '" . $appid . "'");
            
   			
   		$current_user_credit 	= $db->selectRow("smb_account", "smb_avail_credit", "smb_acc_id =".$appid );
		
		$date 					= date("Y-m-d H:i:s");
   		$arrCredits 			= array(	'smb_account_id'			=> $appid,
        									'ct_credit_amount'			=> $credit,
        									'ct_credit_status'			=> '1',
        									'ct_transact_id'			=> $transactId,
        									'ct_creditvalue'			=> $newCredit,
   											'ct_current_user_credit'	=> $current_user_credit,
        									'ct_created_on'				=> $date,
        									'ct_created_by'				=> $userid  );
     	$res 					= Credits::addCredits($arrCredits);
     	
     	
     	$retVal = array('creditid'		=> $res ,
     					'creditvalue'	=> $newCredit,
     					'currentcredit' => $current_user_credit);
     	return $retVal;
    }
    
    
    
    /*
     * function to return the user credit
     */
    public static function getUserCredit($appid) {
    	$db 					= new Db();		
    	$current_user_credit 	= $db->selectRow("smb_account", "smb_avail_credit", "smb_acc_id =".$appid );
    	return $current_user_credit;
    }
    
    /*
     * function to update the debit history
    */
    public static function createUserSmsHistory($appid,$dataArr) {
    	$objUserDb          = Appdbmanager::getUserConnection($appID);
   		$db 				= new Db($objUserDb);
    	$sms				= $db->addFields('debit_history', $dataArr);
    	return $sms;
    }
    
    /*
     * function to update the debit history
    */
    public static function createUserCallHistory($appid,$dataArr) {
    	$objUserDb          = Appdbmanager::getUserConnection($appID);
    	$db 				= new Db($objUserDb);
    	$call				= $db->addFields('debit_history', $dataArr);
    	return $call;
    }
    /**
     * Check User Balance available or not if available reduce the credit amount else return false
     * @param unknown $appid
     * @param unknown $fromNumber
     * @param unknown $type 1 for call and 2 for SMS
     * @param unknown SMS Count
     * @return Ambigous <boolean, unknown>
     */
    public static function checkUserBalance($appid,$fromNumber,$type=1,$smsCount=0)
    {
    	if($type==1)
    	{
    		$credit=self::getUserCredit($appid);
    		$creditRequired=self::CreditRequired($fromNumber,$type);
    			if($credit>=$creditRequired)
    				{
    					self::reduceUserCredit($appid,$creditRequired);
    					$balance['success']=true;
    					$balance['balancereserved']=$creditRequired;
    					$balance['balanceRequiredPerMin']=$creditRequired;
    		
    			   	}
    			else
    				{
    					$balance['success']=false;
    				}
    		return $balance;
    	}
    	else if ($type==2)
    	{
    		
    		$credit=self::getUserCredit($appid);
    		$creditRequiredPerSms=self::CreditRequired($fromNumber,$type);
    		if($smsCount>0)
    		{
    			$creditRequired=$creditRequiredPerSms*$smsCount;
    		}
    		
    		if($credit>=$creditRequired)
    		{
    			self::reduceUserCredit($appid,$creditRequired);
    			$balance['success']=true;
    			$balance['balancereserved']=$creditRequired;
    			$balance['balanceRequiredPerSMS']=$creditRequired;
    			
    		
    		}
    		else
    		{
    			$balance['success']=false;
    		}
    		return $balance;
    		
    	}
    	
    }
    
    
    /*
     * function to return the credits required for call
     * $type=1 for call 2 for sms
     */
   	public static function CreditRequired($number,$type=1)	{
   		//Assuming ONe Credit Need to change to number based
   		if($type==1)
   		{
   			return Utils::getSettings('outbound_call_rate');
   		}
   		else if ($type==2)
   		{
   			return Utils::getSettings('outbound_sms_rate');
   		}
   		//return "1";
   	}
    
   	public static function reduceUserCredit($appid,$credit)
   	{
   		$db 					= new Db();
   		$db->customQuery("UPDATE `tbl_smb_account` SET `smb_avail_credit` = smb_avail_credit-".$credit." WHERE `smb_acc_id` = '" . $appid . "'");
   		$credit=self::getUserCredit($appid);
   		node::UpdateCredit($appid, $credit);
   	}
   	
   	public static function updateUserCredit($appid,$credit)
   	{
   		$db 					= new Db();
   		$db->customQuery("UPDATE `tbl_smb_account` SET `smb_avail_credit` = smb_avail_credit+".$credit." WHERE `smb_acc_id` = '" . $appid . "'");
   		$credit=self::getUserCredit($appid);
   		node::UpdateCredit($appid, $credit);
   	}
   	
   	
   	public static function callBilling($key,$appID) 
   	{
   		
   		$objUserDb          = Appdbmanager::getUserConnection($appID);
   		$db 				= new Db($objUserDb);
   		$condition          = "qkey='".$key."'";
   		$amt	    = $db->selectRecord('callqueue', 'amountpermin', $condition);
   		
   		
   		$credit=self::getUserCredit($appID);
   		if($credit>=$amt->amountpermin)
   		{
   			$objUserDb          = Appdbmanager::getUserConnection($appID);
   			$db 				= new Db($objUserDb);
   			$db->customQuery("UPDATE `apptbl_callqueue` SET `balancereserved` = balancereserved+".$amt->amountpermin." WHERE `qkey` = '" . $key . "'");
   			self::reduceUserCredit($appID,$amt->amountpermin);
   			return true;
   			//$db->
   		}
   		else
   			return false;
   	}

   	/**
   	 * Function to calculate exact call charge on haung up
   	 */
   	public static function UpdateCallCharge($appID,$key,$billingSec)
   	{
   		$objUserDb          = Appdbmanager::getUserConnection($appID);
   		$db 				= new Db($objUserDb);
   		$condition          = "qkey='".$key."'";
   		$amt	    = $db->selectRecord('callqueue','balancereserved,amountpermin', $condition);
   		
   		//For min Based calculation
   		$billmin=0;
   		
   		if(($billingSec%60)>0 && $billingSec!=0)
   		{
   			$billmin=floor($billingSec/60)+1;
   		}
   		else
   		{
   			$billmin=floor($billingSec/60);
   		}
   		
   		
   		
   		$totalamount=$billmin*($amt->amountpermin);
   		
   		if($amt->balancereserved>$totalamount)
   		{
   			$credit=$amt->balancereserved-$totalamount;
   			Credits::updateUserCredit($appID, $credit);
   		}
   		
   		return array("amountpermin" => $amt->amountpermin,
   					 "totalcredit"  => $totalamount );
   		
   	}
}

?>