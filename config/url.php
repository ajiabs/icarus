<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Config file for urls			                                      |
// | File name : url.php                                                  |
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