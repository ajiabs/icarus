<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : bootstrap.php                                            |
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
class ConfigBootstrap
{
	/**
	* Execution will start here
	**/

	
	public function run()
	{
	
       
        //Controller class name
        $controllerClassName = 'Controller' . ucfirst(CONTROLLER);
     
        //Create controller object
        $controller = new $controllerClassName;
      
        //Initialize controller
        $controller->init();
        
        //Set view folder and file name
        $controller->setRender(strtolower(CONTROLLER), strtolower(METHOD));
        //Function name
        $method = METHOD;
        
        
        //Call function from action
        $evalString = '$controller->' . $method . '('.ARGS.');';

       
        if(method_exists($controller, $method)) {
            eval($evalString);
        } else {
            ob_start();
            header('location:' . BASE_URL . 'error' );
            exit;
        }

        //execute post actions
        if(PageContext::$postActionObj){
			foreach(PageContext::$postActionObj->actions as $action){ 
				if($action->controller == CONTROLLER && $action->module == MODULE) { //if method is in same controller
				 	$evalpoststring =  '$controller->' . $action->method . '('.ARGS.');';	
				 	if(method_exists($controller, $action->method)) eval($evalpoststring);				
				}else{
					//include the file
					$postactionfilePath = 'project/modules/' . $action->module . '/controller/' . strtolower($action->controller) . '.php';
					if(file_exists($postactionfilePath)) require $postactionfilePath; 
					//instantiate post action controller and execute init
					 $postcontrollerClassName = 'Controller' . ucfirst($action->controller);
					 $postcontroller = new $postcontrollerClassName;					
					// $postcontroller->init();
					 $evalpoststring =  '$postcontroller->' . $action->method . '('.ARGS.');';
					//execute method			

					 if(method_exists($postcontroller, $action->method)) eval($evalpoststring);
				}
				
				
			}
        }
        
        PageContext::registerMetaData();
        //if dynamic theme enabled then set base layout to be rendered 
		if(PageContext::$full_layout_rendering && DYNAMIC_THEME_ENABLED==true && PageContext::$isCMS==false){
			require_once 'public/base_layout.tpl.php';
		}else{
        	//Render Layout and action view
        	$controller->renderLayout();
		}
	}
	
	
}