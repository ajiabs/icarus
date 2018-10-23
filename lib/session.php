<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Library for Session                                                  |
// | File name : session.php                                              |
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