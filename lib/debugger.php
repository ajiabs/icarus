<?php
// +----------------------------------------------------------------------+
// | Main Debugger class			                                          |
// | File name : Debugger.php                                                 |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: ARUN SADASIVAN<arun.s@armiasystems.com>              |
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems ï¿½ 2010                                      |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

class Debugger{

	//turn the debugger on/off
	public static function handleDebuggerSwitch($status){
		//die("Status = ".$status);
		if($status)
		  $_SESSION['debug'] = 1;
		else
		  $_SESSION['debug'] = 0;		
	}

	//initiate the debugger if debugger switch is turned on
	public static function checkDebugger(){
		//return;
		if(!isset($_SESSION['debug']) || $_SESSION['debug'] == 0) return;
		//TURN ON THE SESSION
		PageContext::$debug = true; //setting debugger true by default
	 	PageContext::$debugObj 			= new stdClass();
	 	PageContext::$debugObj->request 	= $_REQUEST;
	 	PageContext::$debugObj->globals  	= $_SERVER;

	}

	//render debugger in the page tail;
	public static function renderDebugger(){
		//if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')return;
		//if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']))return; //this will disable debugger in local

		if(!PageContext::$full_layout_rendering)return;

		if(PageContext::$debug){
			require_once("lib/debug_info.php");
		}
	}

}

?>
