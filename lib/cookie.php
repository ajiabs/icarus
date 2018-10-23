<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Library for Cookie                                                   |
// | File name : cookie.php                                               |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: BINU CHANDRAN.E<binu.chandran@armiasystems.com>              |
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems © 2010                                      |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

class LibCookie
{
	/**
	* Method to set cookie
 	* @param string $name
	* @param string $value
	* @param string $expire
	* @param string $path
	* @param string $domain
	* @return boolean
	**/
	public function setcookie($name = false, $value = '', $expire = false, $path = null, $domain = null) 
	{
		if($name !== false)
		{
			$name = MODULE . '_' . $name;
			$expire = $expire === false ? time()+3600 : $expire;
			return setcookie($name, $value, $expire, $path, $domain); 
		}
		return false;
	}
	/**
	* Method to get value from cookie
	* @param string $name
	**/
	public function get($name = false)
	{
		if($name !== false && isset($_COOKIE[MODULE . '_' . $name]))
		{
			return $_COOKIE[MODULE . '_' . $name];
		}
		return false;
	}
	/**
	* Method to delete cookie
	* @param string $name
	**/
	public function delete($name = false)
	{
		if($name !== false && isset($_COOKIE[MODULE . '_' . $name]))
		{
			$name = MODULE . '_' . $name;
			return setcookie($name, '', time()-3600); 
		}
		return false;
	}
}