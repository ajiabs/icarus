<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Config file for urls			                                      |
// | File name : url.php                                                  |
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

class ConfigUrl
{
	/**
    * Full url to the base
	* @var string
    **/
	private static $rootUrl	= BASE_URL;
	/**
	* Method to get root url
	* @return string $rootUrl
	**/
	public static function root()
	{
		return self::$rootUrl;	
	}
	/**
	* Method to get base url of each module
	* @return string $rootUrl
	**/
	public static function base($module = MODULE)
	{
	
		//if(PageContext::$client_type)
		//	return $module == 'default' ? self::root().PageContext::$client_type.'/' : self::root() . $module . '/';
		//else
			return $module == 'default' ? self::root() : self::root() . $module . '/';
	}
	
	
	/**
	* Method to get style sheet url of each module
	* @return string $rootUrl
	**/
	public static function style($module = MODULE)
	{
		return self::root() . 'public/styles/'. $module . '/';
	}
	/**
	* Method to get javascript url of each module
	* @return string $rootUrl
	**/
	public static function js($module = MODULE)
	{
		return self::root() . 'public/js/'. $module .'/';
	}
   	/**
	* Method to get url to images folder of each module
	* @return string $rootUrl
	**/
	public static function images($module = MODULE)
	{
		return self::root() . 'public/images/'. $module . '/';
	}
    /**
	* Method to get url to uploads folder of each module
	* @return string $rootUrl
	**/
	public static function uploads($module = MODULE)
	{
		return self::root() . 'public/uploads/'. $module . '/';
	}

   
    
}
?>