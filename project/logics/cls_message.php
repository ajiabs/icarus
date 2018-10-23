<?php 

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : Utils.php                                         		  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems � 2010                                    |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

class Message{
	
	    
    public static function setPageMessage($message,$class){
       $_SESSION['page_message']    =   $message;
       $_SESSION['message_class']    =   $class;
    }
    
    public static function getPageMessage(){
       return  array('msg'=> $_SESSION['page_message'],'msgClass'=> $_SESSION['message_class']);
    }
    
    
    
    public static function getMessage(){
    	// return  array('msg'=> $_SESSION['page_message'],'msgClass'=> $_SESSION['message_class']);
    	$msg = ' <div class="'.$_SESSION['message_class'].'" > '.$_SESSION['page_message'].'</div>';
		$_SESSION['page_message']	='';
        $_SESSION['message_class']	='';
        return $msg;
    }
        
    

    
}


?>