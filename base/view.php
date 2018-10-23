<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Basic view class			                                          |
// | File name : view.php                                                 |
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
class BaseView extends stdClass
{
    /**
    * Content to display in view
	* @var string
    **/
	private $_content = null;
    /**
    * folder name of template 
	* @var string
    **/
	private $_folder;
	/**
    * file name of template
	* @var string
    **/
	private $_file;
    /**
    * Status check for render layout
	* @var boolean
    **/
	private $_renderLayout = true;
	/**
    * Status check for render view
	* @var boolean
    **/
	private $_renderView = true;
	/**
    * layout name, default will be common
	* @var sring
    **/
	private $_layout = 'common';
	
    public $dspFlashMsg;

    public $flashMsgText;

    public $flashMsgType;
	private $_module;

    

    public function  __construct()
    {
        $this->dspFlashMsg      = '';
        $this->flash            = array();
        $this->flashMsgType     = BaseFlashmsg::SUCCESS;
        $this->flashMsgText     = '';
    }

    /**
	* Method to render view
	* @param : $folder{string}
	* @param : $file{string}
	* @return: output buffer{string}
	**/
    public function render($folder = null, $file = null)
    {

        if (!($folder && $file)) {
            $folder = $this->_folder;
            $file   = $this->_file;
        }
        
               
        ob_start();
        $filePath = 'project/modules/' . MODULE . '/' .VIEW. '/script/' . $folder . '/' . $file . '.tpl.php';
        if(file_exists($filePath)) {
        	 require $filePath;
    	}else{
       		 require 'modules/' . MODULE . '/' .VIEW. '/script/' . $folder . '/' . $file . '.tpl.php';
    	}
        return ob_get_clean();
    }
	/**
	* Method to render layout
	**/
    public function renderLayout()
    {
        if ($this->_renderView) {        	
			$this->_content = $this->render();
        }
		if ($this->_renderLayout) {
			
			
				//get the layout into buffer
				$filePath = 'project/modules/' . $this->_module . '/' .VIEW. '/layout/' . $this->_layout . '.tpl.php';
				ob_start();							
				
				if(file_exists($filePath)){
					require_once $filePath;
				}else{
					require_once 'modules/' . $this->_module . '/' .VIEW. '/layout/' . $this->_layout . '.tpl.php';
				}
				$this->_layout = ob_get_clean();
				require_once 'public/base_layout.tpl.php';
				
		}
        else
        {
        	PageContext::$full_layout_rendering = false;
            echo $this->_content;
        }
    }
	/**
	* Method to set view folder and file
	* @param : $folder{string}
	* @param : $file{string}
	**/
    public function setRender($folder, $file)
    {
        $this->_folder  = $folder;
        $this->_file    = $file;
    }
	/**
	* Method to disable layout
	**/
	public function disableLayout()
	{
		
		$this->_renderLayout = false;
	}
	/**
	* Method to disable view
	**/
	public function disableView()
	{
		$this->_renderView = false;
	}
	/**
	* Method to set layout template
	* @param : $layout{string}
	**/
	public function setLayout($layout = 'common',$module = MODULE)
	{
		$this->_layout = $layout;
		$this->_module = $module;
	}

    /**
     * Method to create a select drop down
     * @param : $name(string), $values(array), $selected(string), $class(string)
     */
    public function select($name, $options = array(), $selected = '', $class = '', $append = '', $id = '', $param = '')
    {
        if($id == '')   $id    =    $name;
        $selectString = '<select name="' . $name . '" class="' . $class . '" id="'. $id .'" '.$param.'>';
        if($append != ''){
            $selectString .= '<option value="0" >' . $append . '</option>';
        }
        if(!empty($options)){
            foreach($options AS $key => $option) {
                if($selected != '' && $selected == $key) {
                    $selectString .= '<option value="' . $key . '" selected = "selected" >' . $option . '</option>';
                } else {
                    $selectString .= '<option value="' . $key . '" >' . $option . '</option>';
                }
            }
        }
        $selectString .= '</select>';

        return $selectString;
    }
    /**
     * function to create multiple select
     * This function need the selected values as a numeric array
     * @param <type> $name
     * @param <type> $options
     * @param <type> $selected
     * @param <type> $class
     * @param <type> $optionClass
     * @param <type> $append
     * @param <type> $id
     * @return <type> String
     */
    public function multipleSelect($name, $options = array(), $selected = array(), $class = '', $optionClass = '', $append = '', $id = ''){
        if($id == '')   $id    =    $name;
        $selectString = '<select name="' . $name . '[]" multiple="multiple"  class="' . $class . '" id="'. $id .'">';
        if($append != ''){
            $selectString .= '<option value="0" class="'.$optionClass.'" >' . $append . '</option>';
        }
        if(!empty($options)){
            foreach($options as $key => $option){
                if(!empty($selected) && in_array($key, $selected)){
                    $selectString .= '<option value="' . $key . '" class="'.$optionClass.'" selected = "selected">' . $option . '</option>';
                }else{
                    $selectString .= '<option value="' . $key . '" class="'.$optionClass.'">' . $option . '</option>';
                }
            }
        }
        $selectString .= '</select>';
        return $selectString;
    }
    public function hrListCreation()
    {
        $list = array();
        for($count = 1; $count <= 12; $count++){
            $list[$count] = $count;
        }

        return $list;
    }
    public function hourTimeWithMeredian()
    {
        $list = array();
        for($count = 1; $count <= 12; $count++){
            $list[$count.':00:AM'] = $count.':00:AM';
        }
            for($count = 1; $count <= 12; $count++){
            $list[$count.':00:PM'] = $count.':00:PM';
        }

        return $list;
    }
    public function minListCreation($deviation = 1)
    {
        $list = array();
        for($count = 0; $count <= 60; $count += $deviation){
            $list[$count] = str_pad($count, 2, 0, STR_PAD_LEFT);
        }

        return $list;
    }
    public function numericList($countMin, $countMax, $deviation = 1)
    {
        $list = array();
        for($count = $countMin; $count <= $countMax; $count += $deviation){
            $list[$count] = str_pad($count, 2, 0, STR_PAD_LEFT);
        }

        return $list;
    }

    /**
     * Method to create a checkbox
     * @param : $name(string), $value(string), $selected(string), $class(string)
     */
    public function checkbox($name, $value, $selected = '', $class = '', $id = '')
    {
        if($value == $selected) {
            $checked = 'checked = "checked"';
        } else {
            $checked = '';
        }
        $id  = ($id != '') ? $id : $name;
        return '<input name="' . $name . '" id="'.$id.'" type="checkbox" class="' . $class . '" value="' . $value . '" ' . $checked . '>';
    }

    /**
     * Method to create a radio option
     * @param : $name(string), $value(string/array), $selected(string), $class(string)
     */
    public function radio($name, $value, $selected = '', $class = '', $seperators = '', $ids = '')
    {
        $html = '';
        if(is_array($value)) {
            $numberOfItems = count($value);
            for($loop = 0; $loop < $numberOfItems; $loop++) {
                   $seperator = $seperators[$loop];
                   if($ids[$loop] != ''){
                       $id        = $ids[$loop];
                       $idValue   = 'id="'.$id.'"';
                   }
                 
                   $itemValue = $value[$loop];
                   if($itemValue == strtolower($selected)) {
                        $checked = 'checked = checked';
                    } else {
                        $checked = '';
                    }
                   $html .= '<input name="' . $name . '" type="radio" '.$idValue.' class="' . $class . '"  value="' . $itemValue . '" ' . $checked . '>' . $seperator;

            }
        } else {
            if($value == $selected) {
                $checked = 'checked = checked';
            } else {
                $checked = '';
            }
            $html = '<input name="' . $name . '" type="radio"  id="'.$ids.'" class="' . $class .'"   value="' . $value . '" ' . $checked . '>' . $seperators;
        }
        return $html;
    }

    public function displayDate($dateInput, $format, $defaultReturn = '')
    {
        if(isset($dateInput) && BaseFunctions::isValidDateFomat($dateInput)) {
            return date($format, strtotime($dateInput));
        } else {
            return $defaultReturn;
        }
    }
    public function formatInput($input){
        return htmlentities(stripslashes($input));
    }

    public function removeSlashes($input){
        return stripslashes($input);
    }

    public function showFlashMsg()
    {
        $flash        = BaseFlashmsg::get();
        if($flash && is_array($flash)) {
            $this->dspFlashMsg  = 'style="display:block;"';
            if(isset($flash[1])) {
                $this->flashMsgType     = $flash[1];
                $this->flashMsgText     = $flash[0];
            }
        }
    }

    public function listingStatusUpdate($startDateTime, $endDateTime, $Status, $displayAlways = 0)
    {
        $startDate  = BaseFunctions::formatDate(EnumsDate::MYSQL_DATE, $startDateTime);
        $endDate    = BaseFunctions::formatDate(EnumsDate::MYSQL_DATE, $endDateTime);
        $now        = date(EnumsDate::MYSQL_DATE);
        if($Status == EnumsStatus::CANCEL){
            return 'Cancelled';
        }else if($Status != EnumsStatus::ACTIVE) {
            return 'Draft';
        } else if($displayAlways == 1){
            return 'Scheduled';
        } else if($startDate > $now){
            return 'Scheduled';
        } else if ($startDate <= $now && $endDate >= $now) {
            return 'Current';
        } else if ($endDate < $now) {
            return 'Expired';
        } else {
            return '';
        }
    }

    public function getFontFamilies()
    {
        return array('Arial' => 'Arial', 'Times New Roman' => 'Times New Roman',
                     'Courier, monospace' => 'Courier, monospace', 'Garamond, serif' => 'Garamond, serif',
                     'Times New Roman, Times, serif' => 'Times New Roman, Times, serif', 'MS Sans Serif, Geneva, sans-serif' => 'MS Sans Serif, Geneva, sans-serif',
                     'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif', 'Arial Black, Gadget, sans-serif' => 'Arial Black, Gadget, sans-serif',
                     'Tahoma, Geneva, sans-serif' => 'Tahoma, Geneva, sans-serif', 'Trebuchet MS, Helvetica, sans-serif' => 'Trebuchet MS, Helvetica, sans-serif',
                     'Verdana, Geneva, sans-serif' => 'Verdana, Geneva, sans-serif'
                    );
    }
    public function usPhoneNumberFormat($no)
    {
        $first		=	substr($no,0,3);
        $second		=	substr($no,3,3);
        $remaining	=	substr($no,6);
        return('('.$first.') '.$second.'-'.$remaining);
    }
    public function createMonthDropDown($name, $selection = '', $class = '' ){
        $month = '<select name="'.$name.'" id="'.$name.'" class="'.$class.'">';
        $selection = is_null($selection) ? date('n', time()) : $selection;
        for ($i = 1; $i <= 12; $i++){
                $month .= '<option value="'.$i.'"';
                if ($i == $selection){
                        $month .= ' selected';
                }
                $mon = date("F", mktime(0, 0, 0, $i+1, 0, 0, 0));
                $month .= '>'.$mon.'</option>';
        }
        $month .= '</select>';
        return  $month;
    }
    public function createDayDropDown($name, $selection = '', $class = '' ){
        $day = '<select name="'.$name.'" id="'.$name.'" class="'.$class.'">';
        $selection = is_null($selection) ? date('d', time()) : $selection;
        for ($i = 1; $i <= 31; $i++){
                $day .= '<option value="'.$i.'"';
                if ($i == $selection){
                        $day .= ' selected';
                }
                $day .= '>'.$i.'</option>';
        }
        $day .= '</select>';
        return  $day;
    }
    public function createYearDropDown($name, $start, $end, $selection = '', $class = ''){
        $year = '<select name="'.$name.'" id="'.$name.'" class="'.$class.'">';
        $selection = is_null($selection) ? date('Y', time()) : $selection;
        for ($i = $start; $i <= $end; $i++){
                $year .= '<option value="'.$i.'"';
                if ($i == $selection){
                        $year .= ' selected';
                }
                $year .= '>'.$i.'</option>';
        }
        $year .= '</select>';
        return  $year;
    }
     /**
     *
     * @param string $name
     * @param array $options
     * @param array $selected
     * @param string $class
     * @param string $append
     * @return string
     */
    public function createStateDropDown($name, $options = array(), $selected = '', $class = '', $append = '')
    {
        $selectString = '<select name="' . $name . '" class="' . $class . '" id="'. $name .'">';
        if($append != ''){
            $selectString .= '<option value="0" >' . $append . '</option>';
        }
        if(!empty($options)){
            foreach($options as $key => $option) {
                if($selected != '' && $selected == $key) {
                    $selectString .= '<option value="' . $key . '" selected = "selected" >' . $option . '</option>';
                } else {
                    $selectString .= '<option value="' . $key . '" >' . $option . '</option>';
                }
            }
        }
        $selectString .= '</select>';

        return $selectString;
    }


    
    
}
?>