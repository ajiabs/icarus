<?php 
// +----------------------------------------------------------------------+
// | File name : DB AUDIT  	                                         	  |
// |(DB OPERATIONS AUDITING)											  |
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

class Dbaudit{
	
	public static $auditlist = null;
	
	public static function load(){
		
	}
	
	//records the insert/update/delete operation on a record in a selected list of tables
	public static function auditRecord($table, $data = "", $where = "", $audit_type = 'insert'){
		if($table == 'tbl_audit')return;
		$dbh = new BaseModel();
		$auditdata = array(
						"audit_table"   	=> 	$table,
						"audit_data"		=>  str_replace('"',"'",json_encode($data)),
						"where_condition" 	=>  $where,
						"audit_type"		=>  $audit_type,
						"created_by"		=> 	1, // if session::Set user >> user id else default user id to 0;
						"created_on"		=> 	date('Y-m-d H:i:s')
					);
		$dbh->insert('tbl_audit', $auditdata);
		return;
	}
}

?>