<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Framework Main Controller			                                          |
// | File name :Index.php                                                 |
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