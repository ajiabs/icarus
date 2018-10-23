<?php 

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : Smb_account.php                                         		  |
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

class Smbaccount
{
	/*
	 * function to add an smb account
	 */
	public static function addSmbAccount($arrSmbAccount){
		$db                    =   new Db();
        $tableName             =   Utils::setTablePrefix('smb_account');
        $smbId            =   $db->insert($tableName,$arrSmbAccount); 
        return $smbId;
	}
	
	
	
	
	/*
	 * function to get smb account details
	 */
	public static function getSmbAccount($accid){
		$db             = new Db();
        $condition      = "smb_acc_id='".$accid."'";
        $accDetails = $db->selectRecord('smb_account','*',$condition);
        
        return $accDetails;
	}
	
	/*
	 * function to return the smb name 
	 */
	public static function getSmbAccountName($accid){
		$db             = new Db();
		$condition      = "smb_acc_id='".$accid."'";
        $accName 		= $db->selectRow('smb_account','smb_name',$condition);
        return $accName;
	}
	
	
	/*
	 * function to get the app id of the user
	 */
	public static function getAppIdOfUser($userid){
		$db             = new Db();
        $condition      = "smb_owner_id='".$userid."'";
        $accDetails = $db->selectRecord('smb_account','smb_acc_id',$condition);
        return $accDetails->smb_acc_id;
	}
	
	
	
	/*
	 * function to update the smbaccount
	 */
	public static function updateSmbAccount($accid,$accinfo){
	  	$db                     = new Db();
        $condition              = "smb_acc_id =" . $accid;
        return $db->updateFields('smb_account', $accinfo, $condition);
	}
        
  
        public static function checkSmbAccountExist($accId){
            $db             = new Db();
            $condition      = "smb_acc_id='".$accId."'";
            $accDetails = $db->checkExists('smb_account','smb_acc_id',$condition);
            return $accDetails;
        }
	
}


?>