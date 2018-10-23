<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Config file for urls			                                      |
// | File name : entityBase.php                                                  |
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

class BaseFunctions
{
    /**
     * array defining the number of rows that need to be shown on each listing page
     * @var type Array
     */
    public  $contentsPerPage = array('25' => 'View 25 Per Page' , '50' => 'View 50 Per Page', '100' => 'View 100 Per Page', 'all' => 'All');

    /**
     * array defining the number of constant sections and their section name
     * @var <type>  Array
     */
    public  $constantSections = array('home','events');

    /**
     * Member request type
     * @var <type> Array
     */
    public  $memberRequestType = array('1' => 'Website');

    /**
     * Resource Phone contacts
     * @var <type> Array
     */


    public $resourcePhoneContactTypes = array('1' => 'Additional', '2' => 'After Hours', '3' => 'Fax', '4' => 'Mobile', '5' => 'Toll-Free');
   
    
    public function __construct()
    {
        
    }

    final public function post($key, $default = '')
    {
        return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
    }
    final public function postArray($key, $default = '')
    {
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

   final public function get($key, $default = '')
   {
        return isset($_GET[$key]) ? trim($_GET[$key]) : $default;
   }

    final public function isPost()
    {
 
 	        return isset($_POST) && !empty($_POST) ;
     }

    final public function printResults($data, $stop = '')
    {
        echo '***************************** <br />';
        echo '<pre>';
        print_r($data);
        echo '***************************** <br />';
        if($stop != '')
        {
                exit;
        }
    }
    final public function files($file)
    {
        $fileInfo = array();
        $fileName       =   isset($_FILES[$file]['name']) ? trim($_FILES[$file]['name']): '';
        $fileType       =   isset($_FILES[$file]['type']) ? trim($_FILES[$file]['type']): '';
        $fileTempName   =   isset($_FILES[$file]['tmp_name']) ? trim($_FILES[$file]['tmp_name']): '';
        $fileError      =   isset($_FILES[$file]['error']) ? trim($_FILES[$file]['error']): '';
        $fileSize       =   isset($_FILES[$file]['size']) ? trim($_FILES[$file]['size']): '';
        $fileInfo = array('Name' => $fileName, 'Type' => $fileType, 'TemporaryName' => $fileTempName, 'ErrorCode' => $fileError, 'Size'=> $fileSize);
        return $fileInfo;
    }

    final public function isFilePosted($fileName)
    {
        return isset($_FILES[$fileName]['name']) && $_FILES[$fileName]['name'] != '' ? true : false;
    }
    
    public function returnApiResults($returnData)
    {
            $string     =   $this->_addSlashes($returnData);
            $string     =   json_encode($string);
            $string     =   str_replace('null','""', $string);
            echo $string;
            exit;
    }
    
    private function _addSlashes($array)
    {
        if(is_array($array))
        {
            foreach ($array as $key => $val){
                if(is_string($val)){
                    $val = str_replace('&quot;','', $val);
                    $val = str_replace('"','', $val);
                    $array[$key]    = addslashes($val);
                }
                if(is_array($val)){
                    $array[$key]    =   $this->_addSlashes($val);
                }
            }
        }
        return $array;
    }
    
    
}
?>