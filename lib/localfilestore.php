<?php

// +----------------------------------------------------------------------+
// | File name : LOCAL FILE STORE  	                                          |
// |(If the file is stored within application server) |
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