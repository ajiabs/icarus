<?php
// +----------------------------------------------------------------------+
// | File name : LOGGER  	                                         	  |
// |(HANDLES THE DATA LOGGIN IN APPLICATION)							  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: Armia Systems<info@armia.com>              |
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems &copy; 2018                                      |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// |   ICARUS is free software: you can redistribute it and/or modify
// |   it under the terms of the GNU General Public License as published by
// |   the Free Software Foundation, either version 3 of the License, or
// |   (at your option) any later version.

// |   ICARUS is distributed in the hope that it will be useful,
// |   but WITHOUT ANY WARRANTY; without even the implied warranty of
// |   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// |   GNU General Public License for more details.

// |   You should have received a copy of the GNU General Public License
// |   along with ICARUS.  If not, see <https://www.gnu.org/licenses/>.   
// |
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