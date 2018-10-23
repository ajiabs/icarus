<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Library for Session                                                  |
// | File name : session.php                                              |
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

class LibSession
{
	/**
	* Method to set session
	* @param string $name
	* @param string $value
	* @return boolean
	**/
	public function set($name = false, $value = '', $prepend = MODULE)
	{
		if($name !== false)
		{
			return $_SESSION[$prepend . '_' . $name] = $value;
		}
		return false;
	}
	/**
	* Method to get value from session
	* @param string $name
	* @return boolean
	**/
	public function get($name = false, $prepend = MODULE)
	{
		if($name !== false && isset($_SESSION[$prepend . '_' . $name]))
		{
			return $_SESSION[$prepend . '_' . $name];
		}
		return false;
	}
	/**
	* Method to delete session
	* @param string $name
	* @return boolean
	**/
	public function delete($name = false, $prepend = MODULE)
	{
		if($name !== false && isset($_SESSION[$prepend . '_' . $name]))
		{
			unset($_SESSION[$prepend . '_' . $name]);
		}
		return false;
	}
	/**
	* Method to destroysession
	* @return boolean
	**/
	public function destroy()
	{
		return session_destroy();
	}
}