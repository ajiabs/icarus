<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

// +----------------------------------------------------------------------+
// | This page is for SMB agent management                                 |
// | File name : user.php                                                  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems ? 2010                                      |
// | All rights reserved                                                  |
// +------------------------------------------------------


class ControllerAgents extends BaseController {
    /*
      construction function. we can initialize the models here
     */

    public function init() {
    	
      	parent::init();
      	//Utils::checkUserLoginStatus();
      	//Subscription::checkUserSubscription();
      	PageContext::$response = new stdClass();
        PageContext::$response->activeSubMenu       = 'agents';
        PageContext::$response->baseUrl             = BASE_URL . 'app/';
        PageContext::registerPostAction("footer", "footerpanel", "index", "smb");
        PageContext::registerPostAction("smbmenu", "smbmenu", "index", "smb");
        PageContext::registerPostAction("header", "headerpanel", "index", "smb");
        
        PageContext::registerPostAction("messagebox", "messagebox","index","smb");
        PageContext::registerPostAction("searchbox", "searchbox", "index", "smb");
        //Utils::getUserAsteriskLogin();
        
       
        
    }

    /*
     * function to list the agents
     */

     public function index() {
     	Utils::checkPagePermission('agentslisting');
        $orderfield 		= PageContext::$request['sort'];
        $orderby 			= PageContext::$request['sortby'];
        $page 				= PageContext::$request['page'];
        $search 			= addslashes(trim(PageContext::$request['searchtext']));
        $searchtype 		= PageContext::$request['searchtype'];
        PageContext::$response->logged_agent_id = Utils::getLoginedUserId();
        // code to get the arrow for the sort order
        PageContext::$response->agent_fname_sortorder				= Utils::sortarrow();
        PageContext::$response->agent_extn_sortorder				= Utils::sortarrow();
        PageContext::$response->{$orderfield.'_sortorder'} = Utils::getsortorder( $orderby);
        
        // search field section
        PageContext::$response->search = array('fields' => array(	'name'=>'Name',
        															'email'=>'Email',
        															'extension'=>'Extension'),
        										'action'=>PageContext::$response->baseUrl.'agents/index');
        
        
        
        switch ($searchtype) {
            case 'all':
                $searchtypeArray = array('agent_fname', 'agent_lname','agent_email');
                break;
            case 'name':
            	
            	// $searchtypeArray = array('agent_fname', 'agent_lname');
                $searchtypeArray = array("CONCAT(agent_fname,' ',agent_lname)");
                break;
            case 'email':
                $searchtypeArray = array('agent_email');
                break;
            case 'extension':
                $searchtypeArray = array('agent_extn');
                break;
        }
        
        //echopre($searchtypeArray);
        PageContext::$response->messagebox		= Message::getPageMessage();
        
        PageContext::$response->order       	= ($orderby== 'ASC')? 'DESC' : 'ASC';
        PageContext::registerPostAction("center-main", "index", "agents", "smb");
        $itemperpage        = PAGE_LIST_COUNT;
        $targetpage=BASE_URL.'smb/agents/index?searchtext='.$search.'&searchtype='.$searchtype.'&sort='.$orderfield.'&sortby='.$orderby;
        $agents                             	= Agents::getAllAgents($orderfield,$orderby,$page,$itemperpage,$search,$searchtypeArray);
        
        if($page > 1)
        	PageContext::$response->slno		= (($itemperpage * ($page-1) ) +1)  ;
        else
        	PageContext::$response->slno		= 1;
      	//echo PageContext::$response->slno;  	
        PageContext::$response->agents      	= $agents->records;
        PageContext::$response->pagination   	= Pagination::paginate($page, $itemperpage, $agents->totalrecords,$targetpage);

        PageContext::$response->accountphno   	= Utils::getUserSettings('asterisk-no');
     	
     
     }

    /*
     * function to add the agents
     */

    public function addagent($agentId) {
    	
    		 
    	PageContext::$response->isMaster     = Utils::checkMaster();
    	//var_dump(PageContext::$response->isMaster );
		 if(!Utils::checkUserPermission('agentedit')) {
     	 	 if($agentId != Utils::getLoginedUserId())
     	 	 	$agentId = Utils::getLoginedUserId();
		 }
		 
    	if($agentId == Utils::getLoginedUserId())
     	 	PageContext::$response->pageTitle	= 'Profile';
     	else
    		PageContext::$response->pageTitle	= 'Agent';
		 
    	
    	global $imageTypes;
		$imgHeight 	= $imageTypes['agentthumb']['height'];
        $imgWidth 	= $imageTypes['agentthumb']['width'];
        
		PageContext::$response->deptList     =Departments::getAllDepartmentNames();
		 
        $user=Utils::getUserSession();
        $proceedFlag  =0;
        if($agentId>0){//Edit
           	PageContext::$response->agentDetails           			= Agents::getAgentDetails($agentId);
            
           	if(PageContext::$response->agentDetails->agent_photo != '')
            	PageContext::$response->agent_photo  				= '<img   src="'.USER_IMAGE_URL .$imageTypes['agentthumb']['prefix'].PageContext::$response->agentDetails->agent_photo.'">';
            else
            	PageContext::$response->agent_photo  				= '<img  src="'.USER_IMAGE_URL .'noimage.jpg">'; 
            PageContext::$response->buttonTitle              		= 'Update';
            PageContext::$response->headingContent           		= 'Edit';
        }
        else{
        	
	    	/****** allowed number of agents checking ************/
	    	$agentsAllowed 		= Agents::allowedAgentsCount();
	    	$agentCount    		= Agents::getAgentCount();
	    	if($agentCount >= $agentsAllowed) {
	    		$message = "Your plan allows you to add only $agentsAllowed agents. <a href='".PageContext::$response->baseUrl."subscriptions/upgradeplan'>Upgrade</a> your plan to add more agents.";
				Message::setPageMessage($message, 'error_message');
	            $this->redirect('agents/index');
	    	}
	    	/****** allowed number of agents checking ends ************/
        	
        	
        	
           	PageContext::$response->buttonTitle              = 'Add Agent';
           	PageContext::$response->headingContent           = 'New';
        }
        
        
        
        if ($this->isPost('btnAddagent')) {
            $data_array             = array();
            
            
            
            $extNo = PageContext::$request['txtextn'];
            
            
            if(PageContext::$request['hidAgentId']>0){ //Edit agent details
            	$agent = PageContext::$request['hidAgentId'];
            	if(Calls::checkExtension($extNo,$agent))          	{
	                if(!Agents::checkEmailExist(PageContext::$request['txtemail'],$agentId)){
	                      if($_FILES['txtphoto']['tmp_name']!=""){ //Photo upload
	                      	
	                      	$res = Kliqboothfilehandler::checkUserImageUpload($_FILES['txtphoto'],$imgHeight,$imgWidth,'temp');
	                       	if($res == 0) {
				 	
				 				$fileUpres 	= Kliqboothfilehandler::uploadfile($_FILES['txtphoto']);
				 	
				 				$thumbRes =  Kliqboothfilehandler::createThumbnail($fileUpres->file_id,'agentthumb',false);
					 
				 	 
								 $proceedFlag = 1; 
	                            $data_array['agent_photo']=$fileUpres->file_path;
				 			}
							else{
								global $imageErrors;
                    	 
                    			$message        = $imageErrors[$res];
            					Message::setPageMessage($message, "error_message");  
            					//redirect('app/age');
							}
	                     }
	                     else{
	                        $proceedFlag = 1; 
	                     }
	                }
	                else{
	                   $proceedFlag = 0; 
	                   $uploadArray['message']  		=   "This email already exists";
	                   $uploadArray['message_class']    ='error_message';
	                }
            	}
            	else {
            		$proceedFlag = 0; 
            		$uploadArray['message']  			=   $_SESSION['page_message'];
	                $uploadArray['message_class']    	= 'error_message';
            	}
                if($proceedFlag ==0){ //Display error message
                   	$message        = $uploadArray['message'];
                   	$msg_class      = $uploadArray['message_class'];
                   	Message::setPageMessage($message, $msg_class);
                    $messageArray                       = Message::getPageMessage();
                    PageContext::$response->message     = $messageArray['msg'];
                    PageContext::$response->class       = $messageArray['msgClass'];
                    PageContext::$response->agentDetails->agent_fname   = PageContext::$request['txtfname'];
                    PageContext::$response->agentDetails->agent_lname   = PageContext::$request['txtlname'];
                    PageContext::$response->agentDetails->agent_email   = PageContext::$request['txtemail'];
                   	PageContext::$response->agentDetails->agent_dept   = PageContext::$request['agent_dept'];
                   	PageContext::$response->agentDetails->agent_extn   = PageContext::$request['txtextn'];
                 }
                 else{
                    $data_array['agent_email'] =PageContext::$request['txtemail'];
                    $data_array['agent_fname'] =PageContext::$request['txtfname'];
                    $data_array['agent_lname'] =PageContext::$request['txtlname'];
                    
                    $data_array['agent_dept'] =PageContext::$request['txtdepartment'];
                    
                    
                    if(PageContext::$response->isMaster) {
                   		$data_array['agent_extn'] =PageContext::$request['txtextn'];
                   		
                    }
                    
                    Agents::updateAgentDetails($agentId, $data_array);
                     
                    
                    //Call to asterisk
                    $appId 			= Utils::getLoginedUserApp();
                    $arrExtDetails['extsmbid']=$appId;
                    $arrExtDetails['extno']=PageContext::$request['txtextn'];
                    $arrExtDetails['extpwd']="";
                    $arrExtDetails['agentId']=$agentId;
                   
                 
                    
                    Asterisk::createExtention($arrExtDetails);
                    
                    if(PageContext::$response->isMaster) {
                    	$objSession 					= new LibSession();
	                    $_SESSION['logged_master_extension'] = PageContext::$request['txtextn'];
	                     
	                    $smbAppId 			= Utils::getLoginedUserApp();

	                    // $dbh1 				= mysql_connect(USER_DB_HOST, USER_DB_UNAME,USER_DB_PWD);
	                    // $newDBName 			= USER_DB_NAME.$smbAppId;
	                    // mysql_select_db($newDBName, $dbh1);
                        try {
                           $dbh1                = new PDO('mysql:host='.USER_DB_HOST.';dbname='.USER_DB_NAME.$appid, USER_DB_UNAME, USER_DB_PWD);
                            $options = array(
                                        PDO::ATTR_PERSISTENT => true, 
                                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                                    );
                        } catch (PDOException $e) {
                            header("location:".BASE_URL.'error');
                            exit();
                            echo 'Connection failed: ' . $e->getMessage();die;
                        }
                        // $resData = mysql_query('SELECT settings_value FROM apptbl_settings where settings_name="company-name"');
	                    $resData = 'SELECT settings_value FROM apptbl_settings where settings_name="company-name"';
                        $pdo_query = $dbh1->prepare($resData);
                        $pdo_query->execute();
	                    if($pdo_query -> rowCount() > 0) {
	                    	// $row=mysql_fetch_assoc($resData);
	                    	$row  = $resData->fetch(PDO::FETCH_ASSOC);
	                    	$companyname=str_replace(" ","-",$row['settings_value']);
	                    	$companyname=strtolower($companyname);
	                    	 
	                    }
	                     
                        // $resData = mysql_query('SELECT settings_value FROM apptbl_settings where settings_name="asterisk-ip"');
	                    $resData = 'SELECT settings_value FROM apptbl_settings where settings_name="asterisk-ip"';
                        $pdo_query = $dbh1->prepare($resData);
                        $pdo_query->execute();
	                    if($pdo_query -> rowCount() > 0) {
                            $row  = $resData->fetch(PDO::FETCH_ASSOC);
	                    	// $row=mysql_fetch_assoc($resData);
	                    	$server=$row['settings_value'];
	                    	 
	                    }
	                     
	                     
	                    $asterisk['userName']=$companyname."_".$smbAppId."-".PageContext::$request['txtextn'];
	                    $asterisk['Password']=trim(utf8_decode(Asterisk::getPassword($smbAppId,PageContext::$request['txtextn'])));
	                    $asterisk['Password']=str_replace("?", "", $asterisk['Password']);
	                    $asterisk['Password']=str_replace("\n", "", $asterisk['Password']);
	                    $asterisk['Password']=str_replace(" ", "", $asterisk['Password']);
	                    $asterisk['Server']=$server;
	                     
	                    
	                    $objSession->set('asterisk',json_encode($asterisk),'default');
                     
                    }
                    
                 	if($agentId == Utils::getLoginedUserId()){
     	 	 			  	$message        = "Successfully updated your profile"; 
                     		$msg_class      = "success_message";
                     		Message::setPageMessage($message, $msg_class);
                     		$this->redirect('agents/view');
					}
		 
                     
                     $message        = "Agent edited successfully"; 
                     $msg_class      = "success_message";
                     Message::setPageMessage($message, $msg_class);
                     $this->redirect('agents/index');
                     exit;
                 }
            }
            else{ //Add new agent
            	
            	if(Calls::checkExtension($extNo))
            	{
            		
	            	 
	                if(!Agents::checkEmailExist(PageContext::$request['txtemail'])){ //Email check

	                	
	                	if($_FILES['txtphoto']['tmp_name']!=""){ //Photo upload
	                		/*
	                     $imgArray['name']      = $_FILES['txtphoto']['name'];
	                     $imgArray['tmp_name']  = $_FILES['txtphoto']['tmp_name'];
	                     $imgArray['width1']    = '200';
	                     $imgArray['width2']    = '30';
	                     
	                     $uploadArray           = Utils::imageUpload($imgArray);
	                     //echopre($uploadArray);
	                    if($uploadArray['message_class']=='error_message'){
	                         $proceedFlag = 0;
	                     }
	                     else{
	                        $proceedFlag = 1; 
	                     }
	                     */
	                		$res = Kliqboothfilehandler::checkUserImageUpload($_FILES['txtphoto'],$imgHeight,$imgWidth,'temp');
	                       	if($res == 0) {
				 	
				 				$fileUpres 	= Kliqboothfilehandler::uploadfile($_FILES['txtphoto']);
				 	
				 				$thumbRes 	=  Kliqboothfilehandler::createThumbnail($fileUpres->file_id,'agentthumb',false);
					 
				 	 
								$proceedFlag = 1; 
	                            $uploadArray['agent_photo']=$fileUpres->file_path;
				 			}
							else{
								global $imageErrors;
                    	 
                    			$message        = $imageErrors[$res];
            					Message::setPageMessage($message, "error_message");  
            					//redirect('app/age');
							}
	                		
	                		
	                		
	                 }
	                 else{
	                    $proceedFlag = 1; 
	                 }
	                }
	                else{
	                   $proceedFlag = 0; 
	                   $uploadArray['message']  =   "This email already exists";
	                   $uploadArray['message_class']    ='error_message';
	                }
            	}
            else {
            		$proceedFlag = 0; 
            		//$uploadArray['message']  =   "Please enter a valid extention";
            		$uploadArray['message']  = $_SESSION['page_message'];
	                $uploadArray['message_class']    ='error_message';
            	}
                 
                 if($proceedFlag ==0){ //Display error message
                   	$message        = $uploadArray['message'];
                   	$msg_class      = $uploadArray['message_class'];
                   	Message::setPageMessage($message, $msg_class);
                    $messageArray                       = Message::getPageMessage();
                    PageContext::$response->message     = $messageArray['msg'];
                    PageContext::$response->class       = $messageArray['msgClass'];
                    PageContext::$response->agentDetails->agent_fname   = PageContext::$request['txtfname'];
                    PageContext::$response->agentDetails->agent_lname   = PageContext::$request['txtlname'];
                    PageContext::$response->agentDetails->agent_email   = PageContext::$request['txtemail'];
                    PageContext::$response->agentDetails->agent_dept   = PageContext::$request['txtdepartment'];
                    PageContext::$response->agentDetails->agent_extn   = PageContext::$request['txtextn'];
                 }
                 else{ //Add details to DB
                        $data_array             = array(
                            'agent_email'          => PageContext::$request['txtemail'],
                            'agent_password'       => md5(PageContext::$request['txtpassword']),
                            'agent_fname'          => PageContext::$request['txtfname'],
                            'agent_lname'          => PageContext::$request['txtlname'],
                        	'agent_dept'          	=> PageContext::$request['txtdepartment'],
                            'agent_photo'          => $uploadArray['image_name'],
                            'agent_status'         => 1,
                            'agent_parent'         => $user->user_id,
                            'agent_added_on'       => date('Y-m-d h:i:s'),
                        	'agent_extn'          => PageContext::$request['txtextn'],
                        );
                        
                        $agentid = Agents::createAgent($data_array);
                        
                        
                        //create a row at crucnh table
                        $arrCrunch 		= array('voicemails' => '0','appointments' => '0','leads' => '0','accounts' => '0','tasks' => '0');
						$serialCrunch 	= serialize($arrCrunch);
                        $crunchInfo		= array('crunchid'		=> $agentid,
                     							'crunchdata'	=> $serialCrunch,
                     							'ctype' 		=> '1');
                        Crunchdata::addCrunchData($crunchInfo);
                        
                        // create extention at asterisk
                        $appId 			= Utils::getLoginedUserApp();
                     	$extNo 			= PageContext::$request['txtextn'];
                     	$arrExtinfo		= array('extsmbid'	=> $appId,
                     							'extno'		=> $extNo,
                     							'extpwd' 	=> PageContext::$request['txtpassword'],
                     							'agentId'   => $agentid);
                     	Asterisk::createExtention($arrExtinfo);
                     
                     
                        $message        = "Agent added successfully";
                        $msg_class      = "success_message";
                        Message::setPageMessage($message, $msg_class);
                        $this->redirect('agents/index');
                        exit;
                 }
            }
         }
		PageContext::$response->msgagentbetween = AGENT_EXTENTION_BETWEEN;
 		
		
		
		if(PageContext::$response->agentDetails->agent_dept == '' && PageContext::$request['dept'] != '')
			PageContext::$response->agentDetails->agent_dept	= PageContext::$request['dept'];
		 
		PageContext::$response->APPno = Utils::getLoginedUserApp();
        PageContext::registerPostAction("center-main", "addagent", "agents", "smb");
    }

    /*
     * function to delete a agent
     */

    public function deleteAgent($agentId) {
    	Utils::checkPagePermission('agents');
        $rowsAffected       = Agents::deleteAgent($agentId);
        if ($rowsAffected > 0) {
        	//Asterisk Call
        	$appId 			= Utils::getLoginedUserApp();
        	Asterisk::deleteExtension($appId,$agentId);
            $message        = "Agent deleted successfully";
            $msg_class      = "success_message";
        } else {
            $message        = "There was some problem..Please try again";
            $msg_class      = "error_message";
        }
        Message::setPageMessage($message, $msg_class);
        $this->redirect('agents/index');
    }

    /*
     * function to view the agentdetails
     */

    public function view($agentId) {

    	
    	//PageContext::$response->isMaster     = Utils::checkMaster();
    	 
    	if($agentId == '')
    		$agentId = Utils::getLoginedUserId();
    		
		 if(!Utils::checkUserPermission('agentview')) {
     	 	 if($agentId != Utils::getLoginedUserId())
     	 	 	header("Location:".BASE_URL.'app/nopermission');
		 }
    	if($agentId == Utils::getLoginedUserId())
     	 	PageContext::$response->pageTitle	= 'Profile Details';
     	else
    		PageContext::$response->pageTitle	= 'Agent Details';
		 
		
		 
    	PageContext::$response->returnUrl 				= $_SERVER['HTTP_REFERER'];
    	PageContext::$response->editUrl 				= PageContext::$response->baseUrl.'agents/addagent/'.$agentId;
        
    	//PageContext::$response->agentDetails            = Agents::getAgentDetails($agentId);
    	
        if(PageContext::$response->agentDetails->agent_photo != '')
           	PageContext::$response->agent_photo  = '<img height="50" src="'.USER_IMAGE_URL .PageContext::$response->agentDetails->agent_photo.'">';
        else
           	PageContext::$response->agent_photo  = '<img  src="'.USER_IMAGE_URL .'noimage.jpg">'; 
        PageContext::registerPostAction("center-main", "view", "agents", "smb");
        PageContext::$response->messagebox		= Message::getPageMessage();
    }
}
   
?>