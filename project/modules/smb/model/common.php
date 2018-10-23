<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Common database model class. It use for common functions             |
// | File name : common.php                                               |
// | PHP version >= 5.2                                                   |
// | Created On 4 January 2012                                                   |
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


class ModelCommon extends BaseModel
{
	public function __construct()
	{
		parent::__construct();
	}
 
 

 	
 	
 
	 
	/*
	Common function to check the existance of an item
	*/
	function checkExists($table,$field,$where)
    {
		if($where!='')
			$where= ' WHERE '.$where;
    	$query = "SELECT count(".$field.") as cnt
    	          FROM ".$this->tablePrefix .$table.$where ;
				  
				  
        $res = $this->execute($query);
    	return $this->fetchOne($res);
    }
	/*
	Function to insert the values to table
	*/
	function addFields($table,$postedArray)
	{
		return $this->insert($this->tablePrefix.$table, $postedArray);
	}
	
	/*
	Function to update the table details
	*/
	function updateFields($table,$postedArray,$condition)
	{
		return $this->update($this->tablePrefix.$table, $postedArray,$condition);
	}
	

	
	/*
	Common function to return the row fields
	*/
	function selectRow($table,$field,$where)
    {
		if($where!='')
			$where= ' WHERE '.$where;
    	 $query = "SELECT ".$field."
    	          FROM ".$this->tablePrefix .$table.$where ;
        $res = $this->execute($query);
    	return $this->fetchOne($res);
    }

	/*
	Common function to return the row fields
	*/
	function selectRecord($table,$field,$where)
    {
		if($where!='')
			$where= ' WHERE '.$where;
    	$query = "SELECT ".$field."
    	          FROM ".$this->tablePrefix .$table.$where ;
	
        $res = $this->execute($query);
    	return $this->fetchRow($res);
    }

	/*
 	Common function to return the resultset details
	*/
	function selectResult($table,$field,$where)
    {
		if($where!='')
			$where= ' WHERE '.$where;
    	$query = "SELECT ".$field."
    	          FROM ".$this->tablePrefix .$table.$where ;
        $res = $this->execute($query);
    	return $this->fetchAll($res);
    }

	/*
	Function to delete the  keywords of a Brands
	*/
	function deleteRecord($table,$where)
	{
		$query = "DELETE FROM ".$this->tablePrefix  .$table.'  WHERE '.$where ;
        $res = $this->execute($query);

	}
	
	/*
	Function to execute a query to delete a records
	*/
	function customQuery($query)
	{
         $res = $this->execute($query);

	}
	

	/*
	Function to delete the  keywords of a Brands
	*/
	function selectQuery($query)
	{
		if($query != '')
		{
	        $res = $this->execute($query);
			return $this->fetchAll($res);
			 
		}
	}


	/*
	function to get the count of records 
	*/


	function getDataCount($table='',$selFields = '*',$where='')
	{
		$query 	= 'SELECT COUNT('.$selFields.') AS cnt FROM ' . $this->tablePrefix . $table .' ' .$where;				 
  		 // echo $query;
 		return $this->fetchOne($this->execute($query));
	}

	/*
	function to get the data for the page
	*/
	function getPageData($table='',$groupby = '',$sort_filed='',$sort_order='DESC',$selFields = '*',$where='',$join)
	{
 	
  		$query 	= 'SELECT '.$selFields.' FROM '.$this->tablePrefix. $table .'  ' . $join.'  ' .$where;				 
 
		if($groupby		!='')
			$query.=' GROUP BY '.$groupby;
		if($sort_filed		!='')
			$query.=' ORDER BY '.$sort_filed.' '.$sort_order.' ';
 			
			 //echo $query;
			 
  		$paging_qr		= 	$this->dopaging($query,'',PAGE_LIST_COUNT);
		$res			=	$this->execute($paging_qr);
		return $this->fetchAll($res);
	}

	
	
		/*
	function to get the data for the page
	*/
	function getPagingData($selFields = '*',$table='',$join ,$where='', $groupby = '',$sort_order='DESC',$sort_filed='',$limit='')
	{
	
	
  		$query 	= 'SELECT '.$selFields.' FROM '.$this->tablePrefix. $table .'  ' . $join .' '.$where;				 
 
 

		if($groupby		!='')
                    $query.=' GROUP BY '.$groupby;
		if($sort_filed		!='')
                    $query.=' ORDER BY '.$sort_filed.' '.$sort_order.' ';
					
		 //echo '<br>'.$query;
                if($limit!="")
                {
                   $query.=' LIMIT '.$limit;
                    $res    =	$this->execute($query);
                }
                else
                {
                    $paging_qr	= 	$this->dopaging($query,'',PAGE_LIST_COUNT);
                    $res	=	$this->execute($paging_qr);
                }
                return $this->fetchAll($res);

	}


		/*
	function to get the data for the page
	*/
	function getPagingCount($selFields = '*',$table='',$join ,$where='', $groupby = '',$sort_order='DESC',$sort_filed='')
	{
	
	
  		$query 	= 'SELECT COUNT('.$selFields.') AS cnt FROM '.$this->tablePrefix. $table .'  ' . $join .' '.$where;				 
 
 

		if($groupby		!='')
			$query.=' GROUP BY '.$groupby;
		if($sort_filed		!='')
			$query.=' ORDER BY '.$sort_filed.' '.$sort_order.' ';
		//   echo $query.'<br>';	
			
  		$paging_qr		= 	$this->dopaging($query,'',PAGE_LIST_COUNT);
		$res			=	$this->execute($paging_qr);
		return $this->fetchAll($res);
	}





		/*
	function to get all the datas without pagination
	*/
	function getAllData($selFields = '*',$table='',$join ,$where='', $groupby = '',$sort_order='DESC',$sort_filed='')
	{
	
   		$query 	= 'SELECT '.$selFields.' FROM '.$this->tablePrefix. $table .'  ' . $join .' '.$where;				 
 		if($groupby		!='')
                    $query.=' GROUP BY '.$groupby;
		if($sort_filed		!='')
                    $query.=' ORDER BY '.$sort_filed.' '.$sort_order.' ';
					
					
		 //echo  $query;		
         $res    =	$this->execute($query);
         return $this->fetchAll($res);
 	}








}
?>