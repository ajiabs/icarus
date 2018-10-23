<?php 
// +----------------------------------------------------------------------+
// | File name : DB AUDIT  	                                         	  |
// |(DB OPERATIONS AUDITING)											  |
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