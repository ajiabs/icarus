<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | file to define the global variables needed in the application        |
// | File name : globals.php                                                 |
// | PHP version >= 5.2                                                   |
// | Created On 19 Dec 2011                                               |
// +----------------------------------------------------------------------+
// | Author: Programmer <programmer@programmer.com>                    |
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems ? 2014                                      |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+



// Plans / pricing
define('SAAS', false);
PageContext::$response->SAAS = SAAS;

// Multi DB
define('DYNAMICDB', false);
PageContext::$response->dynamicdb = DYNAMICDB;

// Configurable User Panel - Front End CMS
define('CUP', false);
PageContext::$response->CUP = CUP;
define('CUP_ROUTER_PATH', "/");
define('CUP_CONSTANT', "cup");









?>
