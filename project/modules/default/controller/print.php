<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | This page is for user section management. Login checking , new user registration, user listing etc.                                      |
// | File name : index.php                                                  |
// | PHP version >= 5.2                                                   |
// | Created On	: 	Nov 17 2011                                               |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems ? 2010                                      |
// | All rights reserved                                                  |
// +------------------------------------------------------


class ControllerPrint extends BaseController {
    /*
	 * construction function. we can initialize the models here
    */

  

    public function print_preview($val) {
        
        
        PageContext::registerPostAction("header", "printmenu","index","default");
        PageContext::registerPostAction("center-main", "print_preview", "print", "default");
        $db	    = new Db();
        $getQRcode = $db->selectRecord('users','user_fname,user_lname,qrcode_bigimage',"user_id='".$val."'");
        ini_set('display_errors',0);
        PageContext::$response->user_fname = $getQRcode->user_fname;
        PageContext::$response->user_lname = $getQRcode->user_lname;
        PageContext::$response->qrcode_bigimage = $getQRcode->qrcode_bigimage;
    }
}

?>


