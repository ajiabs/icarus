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


class ControllerUser extends BaseController {
    /*
	 * construction function. we can initialize the models here
    */
    public function init() {
        parent::init();

        PageContext::addStyle("bootstrap.css");
        PageContext::addStyle("bootstrap.min.css");

        PageContext::$response->BASE_URL  = BASE_URL;

        //PageContext::$response->currentUrl = $currentUrl  = ROOT_URL.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        //PageContext::$response->currentPage = str_replace(BASE_URL."index", "", $currentUrl);

        // Set the page panels
        PageContext::registerPostAction("header", "homepageheader","index","default");
        PageContext::registerPostAction("footer", "footerpanel","index","default");

        //  PageContext::$response = new stdClass();
        PageContext::$response->loginUserName = Utils::getLoginUserName();
    }


    /*
    function to load the index template
    */
    public function index() {
        
        PageContext::$response->topMenu = Managecmsview::renderMenu(1, 1,$alias);
        PageContext::registerPostAction("header", "topmenu","index","default");
        PageContext::registerPostAction("center-main","index","user","default");
        PageContext::$metaTitle = "Lorem ipsum dolor sit amet, consectetur adipiscing elit";
        
    }

    

}

?>


