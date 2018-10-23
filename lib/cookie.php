<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Library for Cookie                                                   |
// | File name : cookie.php                                               |
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