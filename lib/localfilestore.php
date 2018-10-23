<?php

// +----------------------------------------------------------------------+
// | File name : LOCAL FILE STORE  	                                          |
// |(If the file is stored within application server) |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: ARUN SADASIVAN<arun.s@armiasystems.com>              		  |
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems � 2010                                    |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+


class Localfilestore extends Filestore{

	public $base_dir = "";
	public function Localfilestore($config=array()) {
	  foreach($config as $name => $value) {
      if(isset($this->$name)) $this->$name = $value;
    }
    if(!$this->base_dir) {
    	throw new Exception("Base directory (base_dir) need to be set for LocalFileStore");
    }	
	}
	
	function storeFile($file_path, $tmp_file){
	
      $file_path = rtrim($this->base_dir, "/") . '/' . $file_path;
      $dir = dirname($file_path);
      if(!file_exists($dir)) {
        if(!mkdir($dir, 0777, true)) {
          throw new Exception("Could not create directory [$dir] to save file");
        }
      }
      if(is_uploaded_file($tmp_file)) {
        if(!move_uploaded_file($tmp_file, $file_path)) {
          throw new Exception("Could not save the file in file directory [" . $this->base_dir . "]. Make sure the directory exists and is writable.");
        }
      }
      else {
        if(!copy($tmp_file, $file_path)) {
          throw new Exception("Could not save the file in file directory [" . $this->base_dir . "]. Make sure the directory exists and is writable.");
        }
      }
	}
	
}

?>