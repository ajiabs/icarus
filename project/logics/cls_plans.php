<?php 

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : cls_plans.php                                         		  |
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

class Plans {

	/*
	 * function to return the list of plans
	 */
	 
	public static function getPlanList($fields = '*'){
    	$db                             = new Db();
		$objSearch 						= new stdClass();
		$objSearch->table				= 'plans';
		$objSearch->key  				= 'plan_id';
 		$objSearch->where				= " plan_status=1" ;
        $commentList					= $db->getData($objSearch);
        return $commentList->records;
	}
	
	

	/*
	 * function to get the plan amount
	 */
	public static function getPlanAmount($planId) {
		$db				= new Db();
		$planAmount  	= $db->selectRow("plans","plan_amount","plan_id=".$planId);
		return $planAmount;
		
	}

	/*
	 * function to get the information about a plan
	 */
	public static function getPlanInfo($planId){
		if($planId) {
			$db			= new Db();
 			$planInfo  	=   $db->selectRecord("plans","*","plan_id=".$planId);
 			return $planInfo;
		}
	}
    
    
	/*
	 * function to update the user plan
	 */
	public static function changeUserPlan($smbid,$arrPlanPeriod) {
		if($smbid!= '') {
			$db = new Db();
			// 	update current plan
			$db->updateFields("smb_account", $arrPlanPeriod, "smb_acc_id = '$smbid'");
			//echopre1($arrPlanPeriod);
		}
	}
	
	
	
	/*
	 * function to get user plan info
	 */
	public static function getAppPlanInfo($appid) { 
        $db                     = new Db();
        $table                  = 'smb_account AS A LEFT JOIN tbl_plans AS P ON P.plan_id=A.smb_plan';
        $fields                 = 'A.smb_plan,P.plan_name,A.smb_subscription_date,A.smb_subscription_expire_date';
        $condition              = " A.smb_acc_id= ".$appid ;
        $planInfo            	= $db->selectRecord($table, $fields, $condition);
        return $planInfo;  
	}
	
	
}
 


?>