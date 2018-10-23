<?php 

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : cls_subscription.php                                         		  |
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

class Subscription{
	
	 
  
	/*
	 * public function to add subscription
	 */
	public static function addSubscription($arrSuscriptions){
		$db                    =   new Db();
        $tableName             =   Utils::setTablePrefix('subscription_tracker');
        $subscriptId           =   $db->insert($tableName,$arrSuscriptions); 
		return $subscriptId;
	}
	
	/*
	 * function to get all the subscriptions of the user
	 */
	public static function getAllSubscriptions($smbId,$orderfield='st_id',$orderby='DESC',$pagenum=1) {
		
        $db 					= new Db();
        $objData                = new stdClass();
		$objData->table         = 'subscription_tracker AS ST';
        $objData->key           = 'st_id';
        $objData->fields	    = 'ST.*,P.plan_name';
        $objData->join	    	= 'LEFT JOIN tbl_plans AS P ON P.plan_id=ST.plan_id';
        $objData->where	    	= "ST.smb_account_id=".$smbId;
        $objData->groupbyfield  = '';
        $objData->orderby	    = $orderby;
        $objData->orderfield    = $orderfield;
        $objData->itemperpage   = PAGE_LIST_COUNT;
        $objData->page	    	= $pagenum;		// by default its 1
        $objData->debug	    	= true;
        $subscriptions         	= $db->getData($objData);
        return $subscriptions;
    }
    
    
    /*
     * function to check the user subscription is expired or not
     */
    public static function checkUserSubscription($appId=''){
    	if($appId == '')
    		$appId = Utils::getLoginedUserApp();
    		
    	$date 			= date("Y-m-d");
		//$date 			= '2014-10-03';
 		
 
	    	$db			 	= new Db();
			$planExpire  	= $db->selectRow("smb_account","smb_subscription_expire_date","smb_acc_id=".$appId);
			
			$expDate 		= date('Y-m-d',strtotime($planExpire));
			if($date >= $expDate) { // subscription expired. redirect to subscription page
				if(Utils::checkUserPermission($section)) 
					redirect('app/subscriptions/upgradeplan');
				else
     	 	  		header("Location:".BASE_URL.'app/nopermission');
			}
 		}
 		 
 		
     
    
}


?>