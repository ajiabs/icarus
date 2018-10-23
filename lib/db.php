<?php
class Db extends BaseModel{



	public function __construct($objSecondaryDb=null)
	{

		// code for connect to multipl databases
		if($objSecondaryDb){
			$host 		=  $objSecondaryDb->host ;
	        $uname		=  $objSecondaryDb->uname  ;
	        $pwd 		=  $objSecondaryDb->pwd  ;
	        $database 	=  $objSecondaryDb->database ;
	        $prefix		=  $objSecondaryDb->prefix  ;
		}
		else{
			$host 		=  MYSQL_HOST;
	        $uname		=  MYSQL_USERNAME  ;
	        $pwd 		=  MYSQL_PASSWORD ;
	        $database 	=  MYSQL_DB ;
	        $prefix		=  MYSQL_TABLE_PREFIX  ;


		}

		parent::__construct($host,$uname,$pwd,$database,$prefix);
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
		foreach($postedArray as $key=>$val){
			//$postedArray[$key] = mysql_real_escape_string($postedArray[$key]);
			$postedArray[$key] = $postedArray[$key];
		}
		return $this->insert($this->tablePrefix.$table, $postedArray);
	}

	/*
	Function to update the table details
	*/
	function updateFields($table,$postedArray,$condition)
	{

		foreach($postedArray as $key=>$val){
			//$postedArray[$key] = mysql_real_escape_string($postedArray[$key]);
			$postedArray[$key] = $postedArray[$key];
		}

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
		//echo $query.'<br>';
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


	/**
	 * Method to prepare custom Sql query ,Dont Use this for HTML TAGS BASED INSERTION
	 * @param  Query String with data field replaced with ?
	 * @param Array of data to be replaced in order
	 * @param Status of PDO 0 if disabled 1 if enabled default 0
	 * @param Type of database default mysql
	 * @return Sql Query
	 * @example
	 * For Sql query <br>
	 * Select * from data where user ='username' AND ID=1<br>
	 * <br>
	 * $query="Select * from data where user='?' AND ID=?";<br>
	 * $dataArray=array("username");<br>
	 * $result= prepareQuery($query,$dataArray);<br>
	 *
	 *
	 **/

	function prepareQuery($query,$dataArray,$pdo=0,$databaseType="mysql")
	{
		$databaseType=strtolower($databaseType);

		switch ($databaseType)
		{
			case "mysql":
					{
						$count=preg_match_all('/\?/',$query,$matches);
						if($count==count($dataArray))
						{
							if($pdo==0)
							{
							for($i=0;$i<$count;$i++)
							{
									$dataArray[$i]=strip_tags($dataArray[$i]);
									//$dataArray[$i]=mysql_real_escape_string($dataArray[$i]);
									$dataArray[$i]=$dataArray[$i];

									$query=preg_replace("/\?/",$dataArray[$i],$query,1);

								}
							}

						}
						else
						{
							return "Data Insufficient";
						}
						break;
					}
			default:
				{
					return "Unknown Database";
					break;
				}

		}

		return  $query;

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
	Function to fetch single row from result set after executing a query
	*/
	function fetchSingleRow($query)
	{
		if($query != '')
		{
	        $res = $this->execute($query);
	        $data = $this->fetchAll($res);
	        if($data) return $data[0];
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



	 /*
 	 * function to get the data with pagination. Pass the following parameters to the function.
 	 *  If don't have the values, no need to pass the values
 	 *
 	 * 	$objSearch 					= new stdClass();
	 *	$objSearch->table			= 'products';
	 *	$objSearch->key  			= 'product_id';
	 *	$objSearch->fields			= '*';
	 *	$objSearch->join			= 'LEFT JOIN USER';
	 *	$objSearch->where			= 'USERID = 2';
	 *	$objSearch->groupbyfield	= 'last_update';
	 *	$objSearch->orderby			= 'ASC';
	 *	$objSearch->orderfield		= 'last_update';
	 *	$objSearch->itemperpage		= '2';
	 *	$objSearch->page			= '1';		// by default its 1
	 *	$objSearch->debug			= true;
 	 *
 	 */
 	function getData($objData) {
 		$start 	= 'SELECT ';

 		// field validation
 		if($objData->fields) 		$fieldPart 	= $objData->fields;
 		else 						$fieldPart 	= ' * ';

 		// table specification
 		if($objData->table)			$tablepart 	= ' FROM '.$this->tablePrefix . $objData->table;
 		else						return false;

 		// join section
 		if($objData->join)			$joinPart	= ' '.$objData->join;

 		// where condition
 		if($objData->where)			$wherePart	= ' WHERE '.$objData->where;

 		// group by section
 		if($objData->groupbyfield)	$groupBy	=' GROUP BY '.$objData->groupbyfield;

 		// sort by section
 		if($objData->orderby)		$orderBy 	=' ORDER BY '.$objData->orderfield.' '.$objData->orderby.' ';


 		// section to get the count of records
 		if($objData->key)			$countOf	= ' COUNT('.$objData->key.')';
 		$sqlGetCount = $start.$countOf.$tablepart.$joinPart.$wherePart.$groupBy.$orderBy;

 		//$totRecords = $this->fetchOne($this->execute($sqlGetCount));
 		// $totRecords = mysql_num_rows($this->execute($sqlGetCount));
 		//$objRes->totalrecords = $totRecords;


 		$resCount 		= $this->execute($sqlGetCount);
		/*if(mysql_num_rows($resCount) > 1)
			$totRecords = mysql_num_rows($resCount);
		else
			$totRecords = $this->fetchOne($resCount);*/
		if($resCount->rowCount() > 1){
			// $totRecords = mysql_num_rows($resCount);
			$totRecords = $resCount->rowCount();
		}
		else{
			$totRecords = $this->fetchOne($resCount);
		}
		$objRes->totalrecords = $totRecords;



 		if($objData->itemperpage) 	$itemPerPage 	= $objData->itemperpage;
 		else 						$itemPerPage 	= PAGE_LIST_COUNT;

 		if($objData->page) 			$currentPage 	= $objData->page;
 		else 						$currentPage 	= '1';
 		$totPages 					= ceil($totRecords/$itemPerPage);
 		$objRes->totpages 			= $totPages;
 		$objRes->currentpage 		= $currentPage;

 		// get the limit of the query
 		$limitStart = ($currentPage * $itemPerPage) - $itemPerPage;
 		$limitEnd 	= $itemPerPage;
 		$limitVal 	= ' LIMIT '.$limitStart.','.$limitEnd;

  		// get the records
 		$selectQuery = $start.$fieldPart.$tablepart.$joinPart.$wherePart.$groupBy.$orderBy.$limitVal;
 		//	 echo $selectQuery;
 		// debug the query
 		if($objData->debug)	$objRes->query = $selectQuery;

 		$res    			=	$this->execute($selectQuery);
        $objRes->records 	= $this->fetchAll($res);
 		return $objRes;
 	}


}
?>
