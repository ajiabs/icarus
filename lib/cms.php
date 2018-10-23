<?php 
// +----------------------------------------------------------------------+
// | File name : CMS	                                          		  |
// |(AUTOMATED CUSTOM CMS LOGIC)					 	  |
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

class Cms{
	
	public static function loadMenu(){		
		$dbh	 = new ModelCommon();
		$res = $dbh->execute("SELECT cs.*,cg.group_name FROM cms_sections cs LEFT JOIN cms_groups cg ON cs.group_id=cg.id");
		$groups = $dbh->fetchAll($res);
		$menu = array();
		foreach($groups as $group){
			$menu[$group->group_id]->name = $group->group_name;
			$menu[$group->group_id]->sections[] = $group;
		}
		return $menu;
	}
	
	public static function loadSection($request){
			$section_alias  = $request['section'];
			$dbh	 		= new ModelCommon();				
			$res 			= $dbh->execute("SELECT * FROM cms_sections where section_alias='$section_alias' limit 1");
			$section_data 	= $dbh->fetchRow($res);
			if(!$section_data->section_config || $section_data->section_config=='')return $section_data;
			$listData 		= Cms::getSectionListingData($section_data,$request);
			$listRenderData = Cms::renderSectionListing($listData, $section_data->section_config,$request);
			return $section_data;	
	}	
	
	public static function getSectionListingData($section_data,$request){
			//	print_r($section_data);
		
		$dbh	 		= new ModelCommon();	
		$section_config = json_decode($section_data->section_config);

		$section_config1 = array(
							"displayAutoField" => true,
							"orderBy" 		=> array("activity_name" => "ASC"),
							"listColumns" 	=> array("id", "activity_name", "activity_description"),
							"showColumns" 	=> array("activity_name", "activity_alias", "parent_id", "other_parent_id", "level", "description", "activity_id"),
							"columns" 		=> array(
													"id" => array("name" => "ID", "editoptions" => array("hidden" => true)),
													"activity_name" 			=> array("name" => "Activity"),
													"activity_description" 		=> array("name" => "Description")
													)
							);
					
		//select
		$query = " SELECT ";
		
		//get columns to retreive
		$columns = " ";
		foreach($section_config->columns as $key => $val){
			$columns .= $key.",";
		}
		$columns = rtrim($columns,",");
		
		//from table (joins?)
		$from = " FROM $section_data->table_name ";
		
		//where condition //publish, page limit, page offset //sort 
		$where = " LIMIT 10";
		
		//combine and execute query
		$query = $query.$columns.$from.$where;

		$res = $dbh->execute($query);
		$listData = $dbh->fetchAll($res);
		Logger::info($query);
		return $listData;
	}
	
	public static function renderSectionListing($listData,$sectionConfig,$request){
		$section_config = json_decode($sectionConfig);
		
		$table  = '<table border="1" cellpadding="0" cellspacing="0" class="cms_listtable" id="tbl_'.$request['section'].'">';
		//header
		$header = '<tr>';
		foreach($section_config->listColumns as $col){
			$header.= '<th class="table-header">'.$section_config->columns->$col->name.'</th>';
		}$header .= '<th class="table-header">Operations</th></tr>'; //operations header
		$table .= $header;
		
		//data
		foreach($listData as $record){
			$data 	 = '<tr>';
			foreach($section_config->listColumns as $col) $data 	.= 	'<td>'.	$record->$col.'</td>';
			//operations column
			$key = $section_config->keyColumn;
			$operations = '<td><a class="cms_list_operation" href="/cms?section='.$request['section'].'&action=edit&id='.$record->$key.'">edit</a>&nbsp;
							<a class="cms_list_operation" href="/cms?section='.$request['section'].'&action=delete&id='.$record->$key.'">delete</a></td>';
			$data 	.= $operations.'</tr>';
			$table 	.= $data;
		}
			
		$table .= '</table>';
		PageContext::$response->section_list_table = $table; 
	}
	
}


?>