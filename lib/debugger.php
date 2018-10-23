<?php
// +----------------------------------------------------------------------+
// | Main Debugger class			                                          |
// | File name : Debugger.php                                                 |
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
