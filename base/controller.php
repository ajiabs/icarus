<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Abstract controller class                                            |
// | File name : controller.php                                           |
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