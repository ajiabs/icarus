<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Config file for folder paths                                         |
// | File name : path.php                                                  |
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