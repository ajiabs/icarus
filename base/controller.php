<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Abstract controller class                                            |
// | File name : controller.php                                           |
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
class BaseController extends BaseFunctions
{
	/**
    * view
	* @var Object
    **/
	protected $view;

    /**
     * Email template style
     * @var <type>
     */
    public $emailStyles;
	 
 


	 /*
	 
	 ===================================================================
	 Declare globally accessing variables
	 */
	 /*
	 ===================================================================
	 */
 
	/**
    * Initialize 
    **/
	public function init()
	{
            $this->view = new BaseView();

            
      
     
	}
	/**
    * Method to set view for render
    **/
	public function setRender($directory, $view = 'index')
	{
		$this->view->setRender($directory, $view);
	}
	/**
    * Method to render layout view
    **/
	public function renderLayout()
	{
		$this->view->renderLayout();
	}
	/**
    * Method to disable layout
    **/
	public function disableLayout()
	{
		$this->view->disableLayout();
	}

    
   
	public function redirect($path = '')
	{
        header("Location:".ConfigUrl::base().$path);
        exit;
    }

    

   
}
?>