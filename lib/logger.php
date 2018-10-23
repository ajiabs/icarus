<?php
// +----------------------------------------------------------------------+
// | File name : LOGGER  	                                         	  |
// |(HANDLES THE DATA LOGGIN IN APPLICATION)							  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: ARUN SADASIVAN<arun.s@armiasystems.com>              		  |
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems � 2010                                    |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

class Logger{
	
	public static $level = 'INFO';
	
	
	//turn the debugger on/off
	public static function handleLoggerSwitch($status){

		if($status)
		  $_SESSION['logger_active'] = 1;
		else 
		  $_SESSION['logger_active'] = 0;
	}
	
	
	//initiate the debugger if debugger switch is turned on
	public static function checkLoggerStatus(){
		if(!isset($_SESSION['logger_active']) || $_SESSION['logger_active'] == 0) return 0;	
		return 1;
	}
	
	public static function info($msgObject){
		$debugObj		 = debug_backtrace();	
		Logger::doLog($msgObject,$debugObj,'INFO');
	}
	
	public static function error($errorObject){
		$debugObj		 = debug_backtrace();		
		Logger::doLog($msgObject,$debugObj,'ERROR');	
	}
	
	public static function doLog($msgObject,$debugObj,$type='INFO'){
		if(!Logger::checkLoggerStatus())return;
		$loggerObj 		 = new stdClass();
       	$loggerObj->data = $msgObject;
       	$loggerObj->type = $type;
        $loggerObj->trace 	 = $debugObj[0];
       	PageContext::$loggerObj->log[] = $loggerObj;
	}

}



?>