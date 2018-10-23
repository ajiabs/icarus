<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Debugger Switch Controller			                                          |
// | File name : Debugger.php                                                 |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: ARUN SADASIVAN<arun.s@armiasystems.com>              |
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems � 2010                                      |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+


//http://localhost/prostructor/framework/debugger/on
//http://localhost/prostructor/framework/debugger/off
class ControllerDebugger extends BaseController
{
	/*
		construction function. we can initialize the models here
	*/
     public function init()
     {
        parent::init();
		$this->_common	 		= new ModelCommon();
     }

    /*
    function to load the index template
    */
    public function index(){
    	header("Location: ".BASE_URL.'framework/');
    }

    public function on(){
    	Debugger::handleDebuggerSwitch(true);
    	echo "DEBUGGER TURNED ON";
    	header("Location: ".BASE_URL.'framework/');
      exit(0);
    }

 	public function off(){
    	Debugger::handleDebuggerSwitch(false);
    	echo "DEBUGGER TURNED OFF";
    	header("Location: ".BASE_URL.'framework/');
      exit(0);
    }

}
?>
