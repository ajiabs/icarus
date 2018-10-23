<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Framework Main Controller			                                          |
// | File name :Index.php                                                 |
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

class ControllerIndex extends BaseController
{
	/*
		construction function. we can initialize the models here
	*/
     public function init()
     {
        parent::init();
		$this->_common	 = new ModelCommon();
		
      }

    /*
    function to load the index template
    */
    public function index(){
    	PageContext::$isCMS = true;
		if (!isset($_SERVER['PHP_AUTH_USER'])) {
		    header('WWW-Authenticate: Basic realm="My Realm"');
		    header('HTTP/1.0 401 Unauthorized');
		    echo 'Sorry! This page needs Authentication.';
		    exit;
		} else {
		    if(($_SERVER['PHP_AUTH_USER'] != 'admin') || ($_SERVER['PHP_AUTH_PW']!='admin'))exit;
		}

    	$this->view->setLayout("home");
    	
    }
    
    
    
}
?>