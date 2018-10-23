<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Flash message setting			                                      |
// | File name : flashmsg.php                                                |
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

class BaseFlashmsg
{
    const SUCCESS   = 'success';
    const FAILED    = 'error';
    const WARNING   = 'warning';

    public function __construct()
    {
        
    }

    public static function set($message)
    {
        return $_SESSION[EnumsSession::FLASH_MSG] = $message;
    }

    public static function get()
    {
        if(isset($_SESSION[EnumsSession::FLASH_MSG])) {
            $msg = $_SESSION[EnumsSession::FLASH_MSG];
            $_SESSION[EnumsSession::FLASH_MSG] = '';
            return $msg;
        } else {
            return false;
        }
    }

}
?>