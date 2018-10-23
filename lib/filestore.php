<?php
// +----------------------------------------------------------------------+
// | File name : FILE STORE : ABSTRACT CLASS  	                                          |
// |(SETS TEMPLATE FOR FILE STORES) |
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

abstract class Filestore {
	abstract function storeFile($file_path, $tmp_file);
}

?>