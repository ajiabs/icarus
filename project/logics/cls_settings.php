<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : Settings.php                                         		  |
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

class Settings {
    

    public static function getUserPlan($userid) {
        if ($userid) {
            $db 		= new Db();
            $pageData 	= $db->selectRecord('smb_account AS A LEFT JOIN tbl_plans AS P ON P.plan_id=A.smb_plan', 'P.plan_name', " A.smb_acc_id='" . $userid . "'");
            return $pageData->plan_name;
        }
    }

    
    
    /*
     * function to update the settings
     */
	public static function updateSettings($dbObj,$data) {
        $db = new Db($dbObj);
        if (is_array($data) && !empty($data)) {
            foreach ($data as $field => $val) 
                $db->updateFields("settings", array('settings_value' => $val), "settings_name = '$field'");
        }
        
       
        return true;
    }
    
    
    /*
     * function to update user settings individualy
     */
    public static function updateUserSettings($field,$value){
    	if($field !='' ) {
    		$objUserDb 				= Appdbmanager::getUserConnection();
        	$db 					= new Db($objUserDb);
        	$db->updateFields("settings", array('settings_value' => $value), "settings_name = '$field'");
    	}
    }
    
    
    /* 
     * function to get the user logo and site title 
     */
    public static function getCustomSettingsInfo($appid,$field){
    	if($appid != '' && $field != '') {
	    	$objUserDb 			= Appdbmanager::getUserConnection($appid);
	        $db 				= new Db($objUserDb);
	        $condition      	= "settings_name ='".$field."'";
	        $setDetails 		= $db->selectRow('settings','settings_value',$condition);
	        
	        return $setDetails;
    	}
    }
     
}

?>