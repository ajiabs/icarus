<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Config file for folder paths                                         |
// | File name : path.php                                                  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: BINU CHANDRAN.E<binu.chandran@armiasystems.com>              |
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems � 2010                                      |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

class ConfigPath
{
	/**
	* Method to get base path
	* Base path is the directory in which 
	* your index.php file is located.
	* @return string BASE_PATH
	**/
	public static function base()
	{
		return BASE_PATH;	
	}
	/**
	* Method to get url to images folder of each module
	* @return string $rootUrl
	**/
	public static function images()
	{
		return self::base() . 'images/'.MODULE . '/';
	}
    
	public static function base1()
	{
		return BASE_PATH;	
	}

}
?>