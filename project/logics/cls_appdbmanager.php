<?php 

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : Appdbmanager.php                                         		  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems � 2010                                    |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

class Appdbmanager{
	
	public 	$schemaFile ;
	public 	$dataFile ;
	public  $sqlFilePath  ;
	
	public 	$dbHost;
	public 	$dbUserName ;
	public 	$dbUserPwd;
	
	 
	
  	public function  __construct() {
  	 
		$this->sqlFilePath 	= 'project/appdatabase/';
		$this->schemaFile 	= 'schema.sql';
		$this->dataFile 	= 'data.sql';
		
		$this->dbHost 		= USER_DB_HOST;
		$this->dbUserName 	= USER_DB_UNAME;
		$this->dbUserPwd 	= USER_DB_PWD;

    }
    
    
    /*
     * function to create the dataabse connection
     */
    public function createUserDbConnection($newDBName=null){
        // $con        = mysqli_connect($this->dbHost , $this->dbUserName,$this->dbUserPwd );
        if($newDBName!=null){
     	  $con 		= new PDO('mysql:host='.$this->dbHost.';dbname='.$newDBName, $this->dbUserName, $this->dbUserPwd);
        }else{
            try {
                // $dbh = new PDO("mysql:host=$host", $root, $root_password);
                $con = new PDO('mysql:host='.$this->dbHost, $this->dbUserName, $this->dbUserPwd);

               

            } catch (PDOException $e) {
                die("DB ERROR: ". $e->getMessage());
    }
        }
     	return $con;
	}
	
    
	/*
	 * function to create  
	 */
    public function createUserDataBase($dbName,$con){
      	if ($con === false) {
	        $error = true;
	        $message = " * Connection Not Successful ";
	    } else {
	    //     $dbselected = mysqli_select_db($con,$dbName);
	    //     if (!$dbselected) {
	    //        	$sql	="CREATE DATABASE ".$dbName;
 				// mysqli_query($con,$sql);
 				// $dbselected = mysqli_select_db($con,$dbName);
	    //     }
            $con->query("CREATE DATABASE `$dbName`;
                        CREATE USER '$this->dbUserName'@'$this->dbHost' IDENTIFIED BY '$this->dbUserPwd';
                        GRANT ALL ON `$db`.* TO '$user'@'localhost';
                        FLUSH PRIVILEGES;") 
            or die(print_r($con->errorInfo(), true));
 	       	return $con;
	    }
      }
  
  
     
     
   
    
    /*
     * function to create the user database for smb account
     */
	public function createUserDB($dbName){
		$schemafile 	= $this->sqlFilePath .$this->schemaFile;
		$dataFile 		= $this->sqlFilePath .$this->dataFile;
		$dbCon 			= Appdbmanager::createUserDbConnection();
		Appdbmanager::createUserDataBase($dbName,$dbCon);
		Appdbmanager::createSchema($schemafile,$dbCon);
		Appdbmanager::createData($dataFile,$dbCon);
		//echo "successfully created the database";
	}
	
	
	
	/*
	 * function to create a new staff on the new database
	 */
	
	public function createStaff($userid,$arrStaff){
		$newDBName 		= USER_DB_NAME.$userid;	
		$dbCon 			= Appdbmanager::createUserDbConnection($newDBName);
		// mysqli_select_db($dbCon,$newDBName);
		
	 
		$sqlquery = "INSERT INTO apptbl_agents(agent_email,agent_password,agent_fname,agent_lname,agent_status,agent_parent,agent_added_on,agent_master)
					VALUES('".$arrStaff['agent_email']."','".$arrStaff['agent_password']."','".$arrStaff['agent_fname']."','".$arrStaff['agent_lname']."','".$arrStaff['agent_status']."','".$arrStaff['agent_parent']."','".$arrStaff['agent_added_on']."','".$arrStaff['agent_master']."')
						";
        $pdo_query = $dbCon->prepare($sqlquery);
        $pdo_query->execute();  
		// mysqli_query($dbCon,$sqlquery);
        $staffId = $dbCon->lastInsertId();
		// $staffId = mysql_insert_id($dbCon);
		 
		return $staffId;
		
	}
	
	/*
	 * function to create the schema of the database
	 */
	public static function createSchema($schemafile,$dbCon) {
		$sqlquery = @fread(@fopen($schemafile, 'r'), @filesize($schemafile));
        $sqlquery = Appdbmanager::splitsqlfile($sqlquery, ";");
		for ($i = 0; $i < sizeof($sqlquery); $i++) {
            $pdo_query = $dbCon->prepare($sqlquery[$i]);
            $pdo_query->execute();  
            // mysqli_query($dbCon,$sqlquery[$i]);
        }		
	}
	
	
	
	
	/*
	 * function to import the content to the newly created database
	 */
	public static function createData($datafile,$dbCon){
		$sqlquery = @fread(@fopen($datafile, 'r'), @filesize($datafile));
        $sqlquery = Appdbmanager::splitsqlfile($sqlquery, ";");
		for ($i = 0; $i < sizeof($sqlquery); $i++) {
            // mysqli_query($dbCon,$sqlquery[$i]);
            $pdo_query = $dbCon->prepare($sqlquery[$i]);
            $pdo_query->execute(); 
         }
	}
	
	
    /*
     * function to return the data base credentials of the user
     */
    public static function getUserConnection($smbId='') {
    	if($smbId == '') {
    		$values 			= Utils::getUserSession();
			$smbAppId 			= $values->smb_id;
    	}
    	else 
    		$smbAppId 			= $smbId;
    		
    	$newDBName 				= USER_DB_NAME.$smbAppId;
    	
    	$objUserDb 				= new stdClass();
        $objUserDb->host 		= USER_DB_HOST;
        $objUserDb->uname 		= USER_DB_UNAME;
        $objUserDb->pwd 		= USER_DB_PWD;
      	//  $objUserDb->database 	= 'kliqbooth_jinson';
        $objUserDb->database 	=  $newDBName;
        $objUserDb->prefix 		= 'apptbl_';
        return $objUserDb;
    }
    
    
  
    
    
    
    
    
    /*
     * function to split the sql file
     */
     public static function splitSqlFile($sql, $delimiter) {
        // Split up our string into "possible" SQL statements.
        $tokens = explode($delimiter, $sql);
        // try to save mem.
        $sql = "";
        $output = array();
        // we don't actually care about the matches preg gives us.
        $matches = array();
        // this is faster than calling count($oktens) every time thru the loop.
        $token_count = count($tokens);
        for ($i = 0; $i < $token_count; $i++) {
            // Don't wanna add an empty string as the last thing in the array.
            if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0))) {
                // This is the total number of single quotes in the token.
                $total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
                // Counts single quotes that are preceded by an odd number of backslashes,
                // which means they're escaped quotes.
                $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);

                $unescaped_quotes = $total_quotes - $escaped_quotes;
                // If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
                if (($unescaped_quotes % 2) == 0) {
                    // It's a complete sql statement.
                    $output[] = $tokens[$i];
                    // save memory.
                    $tokens[$i] = "";
                } else {
                    // incomplete sql statement. keep adding tokens until we have a complete one.
                    // $temp will hold what we have so far.
                    $temp = $tokens[$i] . $delimiter;
                    // save memory..
                    $tokens[$i] = "";
                    // Do we have a complete statement yet?
                    $complete_stmt = false;

                    for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++) {
                        // This is the total number of single quotes in the token.
                        $total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
                        // Counts single quotes that are preceded by an odd number of backslashes,
                        // which means they're escaped quotes.
                        $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);

                        $unescaped_quotes = $total_quotes - $escaped_quotes;

                        if (($unescaped_quotes % 2) == 1) {
                            // odd number of unescaped quotes. In combination with the previous incomplete
                            // statement(s), we now have a complete statement. (2 odds always make an even)
                            $output[] = $temp . $tokens[$j];
                            // save memory.
                            $tokens[$j] = "";
                            $temp = "";
                            // exit the loop.
                            $complete_stmt = true;
                            // make sure the outer loop continues at the right point.
                            $i = $j;
                        } else {
                            // even number of unescaped quotes. We still don't have a complete statement.
                            // (1 odd and 1 even always make an odd)
                            $temp .= $tokens[$j] . $delimiter;
                            // save memory.
                            $tokens[$j] = "";
                        }
                    } // for..
                } // else
            }
        }
        return $output;
    }
    
    
    /*
     * function to move the initial data to the new user table
     */
    public static function moveCrunchDataToUserTable($appId,$staffId) {
    	
    	
    	$objUserDb          		= Appdbmanager::getUserConnection($appId);
        $db 						= new Db($objUserDb);

        
        // initiate the crunch data
        $arrCrunch['leads'] 		= '0';
        $arrCrunch['tasks'] 		= '0';
        $arrCrunch['accounts'] 		= '0';
        $arrCrunch['appointments'] 	= '0';
        $arrCrunch['voicemails'] 	= '0';
        $serCrunchArr 				= serialize($arrCrunch);
        $arrCrunch 					= array();
        $arrCrunch['crunchid'] 		= $staffId;
        $arrCrunch['crunchdata']	= $serCrunchArr;
        $arrCrunch['ctype']			= '1';
        $leadId               		= $db->addFields('crunchdata', $arrCrunch);	
        			
  
        //TODO: load the settings data
        /*
        $newDBName 		= USER_DB_NAME.$appId;	
		$dbCon 			= Appdbmanager::createUserDbConnection();
		mysqli_select_db($dbCon,$newDBName);
		
	 
		$sqlquerys = " ";
		mysqli_query($dbCon,$sqlquerys);
		 */
		return $staffId;
    	
    	
    }
    
    
    /*
     * function to move the settings data to user table
     */
    public function moveSettingsDataToUserTable($appId,$arrReplace){
    	$arrReplace['asterisk-ip'] 				= Cmshelper::getUserSettings('asterisk-ip');
    	$arrReplace['admin_mail'] 				= Cmshelper::getUserSettings('admin_mail');
    	$arrReplace['admin_email_from_name'] 	= Cmshelper::getUserSettings('admin_email_from_name');
    	$arrReplace['smtp_host'] 				= Cmshelper::getUserSettings('smtp_host');
    	$arrReplace['smtp_enable'] 				= Cmshelper::getUserSettings('smtp_enable');
    	$arrReplace['smtp_port'] 				= Cmshelper::getUserSettings('smtp_port');
    	$arrReplace['smtp_username'] 			= Cmshelper::getUserSettings('smtp_username');
    	$arrReplace['smtp_pwd'] 				= Cmshelper::getUserSettings('smtp_pwd');
    	$arrReplace['queue-waiting-time'] 		= Cmshelper::getUserSettings('queue-waiting-time');
    	$arrReplace['searchtype'] 				= Cmshelper::getUserSettings('searchtype');
    	$arrReplace['callforwarding'] 			= Cmshelper::getUserSettings('callforwarding');
    	$arrReplace['restrictsingleip'] 		= Cmshelper::getUserSettings('restrictsingleip');
    	$arrReplace['blockoutgoing'] 			= Cmshelper::getUserSettings('blockoutgoing');
    	
    	$importSql = "
INSERT INTO `apptbl_settings` (`settings_id`, `settings_order`, `settings_name`, `settings_value`, `settings_label`, `settings_group`, `settings_field`, `settings_helptext`) VALUES
	(1, 1, 'admin_mail', '".$arrReplace['admin_mail']."', 'Admin Email', 'email', 'textbox', NULL),
	(2, 2, 'admin_email_from_name', '".$arrReplace['admin_email_from_name']."', 'Admin Email Name', 'email', 'textbox', NULL),
	(4, 4, 'smtp_host', '".$arrReplace['smtp_host']."', 'SMTP Host', 'email', 'textbox', NULL),
	(3, 3, 'smtp_enable', '".$arrReplace['smtp_enable']."', 'Enable SMTP', 'email', 'textbox', NULL),
	(5, 5, 'smtp_port', '".$arrReplace['smtp_port']."', 'SMTP Port', 'email', 'textbox', NULL),
	(6, 6, 'smtp_username', '".$arrReplace['smtp_username']."', 'SMTP Username', 'email', 'textbox', NULL),
	(7, 7, 'smtp_pwd', '".$arrReplace['smtp_pwd']."', 'SMTP Password', 'email', 'textbox', NULL),
	(8, 8, 'company-name', '".$arrReplace['company-name']."', 'Company Name', 'general', 'textbox', NULL),
	(9, 9, 'asterisk-no', '".$arrReplace['asterisk-no']."', 'Asterisk Number', 'calls', 'textbox', 'The asterisk number that you purchased'),
	(10, 10, 'asterisk-ip', '".$arrReplace['asterisk-ip']."', 'Asterisk IP', 'calls', 'textbox', 'The outgoing ip address'),
	(11, 11, 'queue-waiting-time', '".$arrReplace['queue-waiting-time']."', 'Queue Waiting Time', 'calls', 'textbox', 'Seconds wait in the queue'),
	(12, 12, 'companylogo', '', 'Company Logo', 'general', 'textbox', NULL),
	(18, 18, 'searchtype', '".$arrReplace['searchtype']."', 'Enable All Field Search', 'general', 'options', 'Search type in listing pages'),
	(13, 13, 'welcomemsgivr', 'mwz2imh56t8.wav', 'Welcome Message IVR', 'calls', 'file', 'Welcome message IVR'),
	(14, 14, 'periodicannouncement', 'mw526yjgtv8.wav', 'Periodic Announcement', 'calls', 'file', 'Periodic announcement message'),
	(15, 15, 'callforwarding', '".$arrReplace['callforwarding']."', 'Call Forwarding', 'calls', 'options', 'Call forwarding'),
	(16, 16, 'restrictsingleip', '".$arrReplace['restrictsingleip']."', 'Restrict To Single Ip', 'calls', 'options', 'Restrict to single ip'),
	(17, 17, 'blockoutgoing', '".$arrReplace['blockoutgoing']."', 'Block Outgoing', 'calls', 'options', 'Block Outgoing'),
	(19, 17, 'showitemsmode', '1', 'Listing Mode', 'general', NULL, NULL); ";
    	
    	 
		
	 	$newDBName 		= USER_DB_NAME.$appId;	
		$dbCon 			= Appdbmanager::createUserDbConnection($newDBName);
		// mysqli_select_db($dbCon,$newDBName);
		
        // mysqli_query($dbCon,$importSql);
        $pdo_query = $dbCon->prepare($importSql);
        $pdo_query->execute();
		 
    }
    
    
	
}


?>