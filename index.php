<?php 
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : index.php                                                |
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
//ini_set('display_errors', 1);

error_reporting(0);
ob_start();
//session_start();  //

// If PRODUCT_INSTALLER constant (defined in project/config/setting.php) is on, which means product need an installer
//  and it will redirect to install.php page if the product is not already installed
if(PRODUCT_INSTALLER){
    include_once('project/config/config.php');
    if (!INSTALLED) {
        header("location: project/install/install.php");
        exit;
    }
}



require_once('lib/pagecontext.php');
require_once('lib/debugger.php'); 
require_once('lib/language.php');
PageContext::$request = $_REQUEST;//load request object;

/**
 Enabling Smarty Support
 **/
PageContext::enableSmarty();


//fatal error handling
register_shutdown_function('shutdownFunction');
function shutDownFunction() { 
	PageContext::handleError();
}



/**
* Base path is the directory in which 
* your index.php file is located.
**/
define('BASE_PATH', getcwd() . '/');
/**
* Load the core application file 
**/

require_once('config/application.php');




/**
* Create object of bootstrap.
**/
$bootstrap = new ConfigBootstrap;


/**
* Framework will sart when call the function run
**/



$bootstrap->run();

/*
 * Render the debugger info if Debugger is Turned ON
 */

Debugger::renderDebugger();

?>