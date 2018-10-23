<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

// +----------------------------------------------------------------------+
// | This page is for SMB account management                                 |
// | File name : user.php                                                  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems ? 2010                                      |
// | All rights reserved                                                  |
// +------------------------------------------------------


class ControllerIndex extends BaseController {
    /*
      construction function. we can initialize the models here
     */

    public function init() {
        parent::init();
        PageContext::$response 			= new stdClass();
        PageContext::$response->siteUrl = BASE_URL;
        PageContext::$response->baseUrl = BASE_URL . 'app/';
    
        PageContext::registerPostAction("footer", "footerpanel", "index", "smb");
        PageContext::registerPostAction("smbmenu", "smbmenu", "index", "smb");
        PageContext::registerPostAction("header", "headerpanel", "index", "smb");
        
         
    }

    
    public function index() {
    	 $this->redirect('index/dashboard');
    }
    
   
    /*
      function to load the dashboard template
     */


    public function dashboard() {
   
     
         
	
		
        // tool tip show code ends
         
        
        PageContext::registerPostAction("center-main", "index", "index", "smb");
        	 
    }

    public function logout() {
    	// update user login status
    	Agents::markAgentLogout();
    	
        session_destroy();
        session_unset($_SESSION['user']);
        Utils::redirecttohome();
        $this->view->disableView();
        exit();
    }


     
     
    

}

?>