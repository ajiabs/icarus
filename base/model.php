<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Singleton Database Class                                             |
// | File name : database.php                                             |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: BINU CHANDRAN.E<binu.chandran@armiasystems.com>              |
// +----------------------------------------------------------------------+
// | Modified : ARUN SADASIVAN (01/07/2012)                 |
// |----------------------------------------------------------------------+
// | Copyrights Armia Systems � 2010                                    |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+
class BaseModel
{
    /**
    * db instance 
    * @var instance of AbstractDatabase
    **/
  protected $_db;
  protected $_pdocon;
  /**
  * Table prefix
  * @var string 
  **/
  public $tablePrefix;
    /**
    * Constructor
    **/
  public function __construct($host='',$uname='',$pwd='',$database='',$prefix='')
    {
       
        $this->_db = BaseDatabase::getInstance();
        if($prefix)
          $this->tablePrefix = $prefix;
        else
          $this->tablePrefix = MYSQL_TABLE_PREFIX;
        $this->_db->_connect($host,$uname,$pwd,$database);
        $this->_pdocon = $this->_db->getDb();
    }
    /**
    * Method to execute mysql queries
    * @param string $query
    **/
  final public function execute($query)
    {
   //echo $query.'</br>';
       if(PageContext::$debug){
           $sqlObj = new stdClass();
           $sqlObj->query = $query;
           $sqlObj->start = microtime(true);
           PageContext::$debugObj->sqls[] = $sqlObj;
       }
       
        //echo $query.'<br>';
        $pdo_query = $this->_pdocon->prepare($query);
        $pdo_query->execute();
       // $res = mysql_query($query) or die(mysql_error());

       if (PageContext::$debug) {
        $sqlObj->timetaken = microtime(true) - $sqlObj->start;
       }
       
       return $pdo_query;
    }
    /**
    * Method to return the id of last  executed query
    * @param string $query
    * return integer
    **/
  final public function lastInsertId()
    {

        $res = $this->_pdocon->lastInsertId();
        return $res;
    }
    /**
    * Method to fetch all rows from a result set
    * @param resource $resultSet
    * @return array $resultArray
    **/
  final public function fetchAll($resultSet)
  {
    $resultArray = array();
    $results = $resultSet->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $value) {
      # code...
        $resultArray[] = $value;
    }
    if(empty($resultArray)) {
          return array();
      }
    return $resultArray;
  }
     /**
    * Method to fetch result as pair from a result set
    * @param resource $resultSet
    * @return array $resultArray
    **/
  final public function fetchPair($resultSet)
  {
    // $resultArray = array();
    // while($obj = mysql_fetch_array($resultSet, MYSQL_NUM))
    // {
    //  $resultArray[$obj[0]] = $obj[1];
    // }
    // return $resultArray;


  //   $resultArray = array();
    $results = $resultSet->fetch(PDO::FETCH_ASSOC);
    foreach ($results as $value) {
      # code...
        $resultArray[$value[0]] = $value[1];
    }
    if(empty($resultArray)) {
          return array();
      }
    return $resultArray;
  }
  /**
    * Method to fetch one item from a result set
    * @param resource $resultSet
    * @return array $resultArray
    **/
  final public function fetchOne($resultSet)
  {

    // $result = mysql_fetch_array($resultSet, MYSQL_NUM);
    // return isset($result[0]) ? $result[0] : false;

    $result = $resultSet->fetch(PDO::FETCH_NUM);

    return isset($result[0]) ? $result[0] : false;

  }
    /**
     * Method to get result set as an enumerated array
     * @param <type> $resultSet
     * @return <type> Enumerated array containing the query result
     */
    final public function fetchNumeric($resultSet){
        $resultArray  = array();
        // while($obj = mysql_fetch_row($resultSet)){        
        while($obj = $resultSet->fetch(PDO::FETCH_NUM)){
            $resultArray[] = $obj[0];
        }
        return $resultArray;
    }
    /**
    * Method to fetch single row from a result set
    * @param resource $resultSet
    * @return array $resultArray
    **/
  final public function fetchRow($resultSet)
  {
    $resultArray = array();
    // while($obj = mysql_fetch_object($resultSet))
    while($obj = $resultSet->fetch(PDO::FETCH_OBJ))
    {
      // print_r($obj) ;
      $resultArray[] = $obj;
    }
        if(isset($resultArray[0])) {
            return $resultArray[0];
        }
    return $resultArray;

    
  }
  /**
  * Method to insert rows 
  * @param string $table
  * @param array $data
  **/
    final public function insert($table, array $data,$doAudit=false)
    {
         $query = 'INSERT INTO ' . $table . ' SET ';
        $query .= $this->_buildQueryString($data);
        
       // echo "<br>".$query;

       if(PageContext::$debug){
           $sqlObj = new stdClass();
           $sqlObj->query = $query;
           $sqlObj->start = microtime(true);
           PageContext::$debugObj->sqls[] = $sqlObj;
       }
       
       $this->execute($query);
        
       if (PageContext::$debug) {
        $sqlObj->timetaken = microtime(true) - $sqlObj->start;
       }

       $insert_id = self::lastInsertId();
       
       //add to audit table
       if($doAudit) Dbaudit::auditRecord($table,$data,$insert_id,'insert');
       
     return $insert_id;
    }
  /**
  * Method to update table
  * @param string $table
  * @param array $data
  * @param string $where
  **/
    final public function update($table, array $data, $where,$doAudit=false)
    {
       $query = 'UPDATE ' . $table . ' SET ';
       $query .= $this->_buildQueryString($data);
        $query .= ' WHERE '.$where;
      
       if(PageContext::$debug){
           $sqlObj = new stdClass();
           $sqlObj->query = $query;
           $sqlObj->start = microtime(true);
           PageContext::$debugObj->sqls[] = $sqlObj;
       }

       $this->execute($query);
        
       if (PageContext::$debug) {
        $sqlObj->timetaken = microtime(true) - $sqlObj->start;
       }
        
       if($doAudit)Dbaudit::auditRecord($table,$data,$where,'update');
        
       return $this->hasAffected();
    }
    /**
     * function to print the query
     * @param <type> $type
     * @param <type> $table
     * @param array $data
     * @param <type> $where
     * @param <type> $stop
     */
    final public function printQuery($type, $table, array $data = array(), $where = '', $stop = '' ){
        if(strtolower($type) == 'insert'){
            $query = 'INSERT INTO ' . $table . ' SET ';
            $query .= $this->_buildQueryString($data);
        }else if(strtolower($type) == 'update'){
            $query = 'UPDATE ' . $table . ' SET ';
            $query .= $this->_buildQueryString($data);
            $query .= ' WHERE ' . $where;
        }else if(strtolower($type) == 'delete'){
            $query = 'DELETE FROM ' . $table;
            $query .= ' WHERE ' . $where;
        }
         echo $query;
         if($stop != ''){
             exit;
         }
    }
  /**
  * Method to delete rows from table
  * @param string $table
  * @param array $data
  * @param string $where
  **/
    final public function delete($table, $where,$doAudit)
    {
        $query = 'DELETE FROM ' . $table;
        $query .= ' WHERE ' . $where;
        
       if(PageContext::$debug){
           $sqlObj = new stdClass();
           $sqlObj->query = $query;
           $sqlObj->start = microtime(true);
           PageContext::$debugObj->sqls[] = $sqlObj;
       } 
       
       $this->execute($query);
        
       if($doAudit)Dbaudit::auditRecord($table,"",$where,'delete');
        
       if (PageContext::$debug) {
        $sqlObj->timetaken = microtime(true) - $sqlObj->start;
       }
        return $this->hasAffected();
    }
  /**
  * Method to get status has affected 
  **/
    final public function hasAffected()
    {
        // return mysql_affected_rows() > 0;
        return $this->_pdocon->rowCount > 0;
    }
  /**
  * Method to get number of rows affected
  **/
    final public function affectedRows()
    {
        return $this->_pdocon->rowCount;
    }
  /**
  * Method to build mysql query string from an array 
  * @param array $data
  **/
    private function _buildQueryString(array $data)
    {
        $columnCount    = count($data);
        $currentColumn  = 1;
    $query = '';
        foreach ($data as $column => $value) {
            $query .= $column . ' = "' . $value.'"';
            if ($currentColumn++ <  $columnCount) {
                $query .= ', ';
            }
        }
        return $query;
    }
    /**
     *
     * Method to escape the string input by the user
     * @param string $data
     * @return $data
     */
    final public function escapeString($data)
    {
       // return "'" . mysql_real_escape_string($data) . "'" ;
      return $this->_pdocon->quote($data);
    }

     
 
    
    public  function dopaging($sql,$numrecords=0,$limit=15,$pagestart=1)
  {
    $pdo_query = $this->_pdocon->prepare($sql);
    $pdo_query->execute();       
    // $temp = mysql_query($sql) or die(mysql_error());
    // $numrows = mysql_num_rows($temp);
    $numrows = $pdo_query -> rowCount();
  
   //$start = LibPager::findStart($limit,$numrows); 
   //* new code added by jinson to pass the page number
   
  $start = LibPager::findStart($limit,$numrows,''); 
      
  if ($numrecords == 0)
    LibPager::$pages = LibPager::findPages($numrows, $limit);
  else{
  if ($numrows > $numrecords)   
    LibPager::$pages = LibPager::findPages($numrecords, $limit);
  else
   LibPager:: $pages = LibPager::findPages($numrows, $limit);
  }
  if ($numrecords == 0)
    $sql1 = $sql . " LIMIT " . $start. ", ". $limit ;
  else{
   if (($start + $limit) > $numrecords) 
     $sql1 = $sql . " LIMIT " . $start. ", ". ($numrecords - $start);
   else
     $sql1 = $sql . " LIMIT " . $start. ", ". $limit ;
  }
        //echo "<br>".$sql1;
    return $sql1;
    
  }

  function checkTableExist($table)
  {
    $query="SHOW TABLES LIKE '".$table."'" ;
    $pdo_query = $this->_pdocon->prepare($query);
    $pdo_query->execute();
    if($pdo_query->rowCount()>0) 
      return true;
    else
      return false;
  
  
  }
  function selectResultFrom($table,$field,$where)
  {
    if($where!='')
      $where= ' WHERE '.$where;
    $query = "SELECT ".$field."
                FROM ".$table.$where ;
  
    $res = $this->execute($query);
    return $this->fetchAll($res);
  }
  
}
?>