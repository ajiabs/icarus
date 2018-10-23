<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Flash message setting			                                      |
// | File name : flashmsg.php                                                |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: Jose Dibine<jose.d@armiasystems.com>              |
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems � 2010                                      |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
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