<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : Export.php                                         		  |
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

class Export {
    
    
	
	 
	
    
	/*
	 * function to generate the excel output data
	 */
    public static function generateExcelData($arrData,$arrfields,$filename){
 
    	$header = '<tr>';
	    foreach($arrfields as $key=>$fields) {
	    	$header .= '<th>'.$fields.'</th>';
	    }
		$header .= '<tr>';
    	
    	foreach($arrData as $data) {    		 
    		$rowData .= '<tr>';
	   		foreach($arrfields as $key=>$fields) {
	    		$rowData .= '<td>'.$data->$key.'</td>';
	    	}
			$rowData .= '<tr>';
    	}
    	$excelData = ' <table   border="1">'.$header.$rowData.' </table> ';
    	
    	 
    	  
		header("Content-type: application/ms-excel");
        header("Content-Transfer-Encoding: binary");
        header("Content-Disposition: attachment; filename=\"".$filename."\"");
              
        echo $excelData  ;
        exit();
    }
    
    
    /*
     * function to generate excel data for tasks
     */
	public static function generateTaskExcelData($arrData,$arrfields,$filename){
 
    	$header = '<tr>';
	    foreach($arrfields as $key=>$fields) {
	    	$header .= '<th>'.$fields.'</th>';
	    }
		$header .= '<tr>';

		$priorityTypes    = getPriorityTypes();
		$taskStatus       = getTaskStatus();
		 
    	foreach($arrData as $data) {    		 
    		$rowData .= '<tr>';
	   		foreach($arrfields as $key=>$fields) {
	   			if($key == 'task_priority')
	   				$rowData .= '<td>'.$priorityTypes[$data->$key].'</td>';
	   			else if($key == 'task_status')
	   				$rowData .= '<td>'.$taskStatus[$data->$key].'</td>';
	   			else
	    			$rowData .= '<td>'.$data->$key.'</td>';
	    	}
			$rowData .= '<tr>';
    	}
    	$excelData = ' <table   border="1">'.$header.$rowData.' </table> ';
    	
    	 
    	  
		header("Content-type: application/ms-excel");
        header("Content-Transfer-Encoding: binary");
        header("Content-Disposition: attachment; filename=\"".$filename."\"");
              
        echo $excelData  ;
        exit();
    }
    
    
    /*
     * function to generate export excel data for appointments
     */
	public static function generateAppntmntExcelData($arrData,$arrfields,$filename){
 
    	$header = '<tr>';
	    foreach($arrfields as $key=>$fields) {
	    	$header .= '<th>'.$fields.'</th>';
	    }
		$header .= '<tr>';

		$priorityTypes    = getPriorityTypes();
		//$taskStatus       = getTaskStatus();
		$appointmentTypes    = getAppointmentTypes();
    	foreach($arrData as $data) {    		 
    		$rowData .= '<tr>';
	   		foreach($arrfields as $key=>$fields) {
	   			if($key == 'appointment_type')
	   				$rowData .= '<td>'.$appointmentTypes[$data->$key].'</td>';
	   			else if($key == 'appointment_priority')
	   				$rowData .= '<td>'.$priorityTypes[$data->$key].'</td>';
	   			else
	    			$rowData .= '<td>'.$data->$key.'</td>';
	    	}
			$rowData .= '<tr>';
    	}
    	$excelData = ' <table   border="1">'.$header.$rowData.' </table> ';
    	
    	 
    	  
		header("Content-type: application/ms-excel");
        header("Content-Transfer-Encoding: binary");
        header("Content-Disposition: attachment; filename=\"".$filename."\"");
              
        echo $excelData  ;
        exit();
    }
    
    
    
    
    
    
  	/*
     * function to generate export excel data for call
     */
	public static function generateCallExcelData($arrData,$arrfields,$filename){
 
    	$header = '<tr>';
	    foreach($arrfields as $key=>$fields) {
	    	$header .= '<th>'.$fields.'</th>';
	    }
		$header .= '<tr>';
    	foreach($arrData as $log) {    	
    	 	$callStatus = '';
            $internalCall = '';
            if($log->calltype == 1 ){	// incming
				$calltype = 'Incoming';
                if($log->voicecall == 1) {	// voice call
                	$callStatus = "Voice Mail";
                }
                else {
                	// TODO: check call between agents
                	if (array_key_exists($log->callfrom, PageContext::$response->getAgentExtensions) && array_key_exists($log->callto, PageContext::$response->getAgentExtensions)) {
    					$internalCall = 1;
					}
                    if($log->agentno == '' && $log->callstatus == 0 && $internalCall ==1 ) {	// missed call
                    	$callStatus = "Missed Call";
                    } 
                    else if($log->agentno == '' && $log->voicecall == ''){ // missed call
                    	$callStatus = "Missed Call";
                    }
                    if($log->agentno != '' && $log->callstatus == 2) {	// answered call
                    	$callStatus = "Answered";
                    }
                    else if($log->callstatus == 2  && $internalCall == 1) {	// answered call
                    	$callStatus = "Answered";
                    } 				
                }
           	}
           	else if($log->calltype == 2 ){	// outgoing
                $calltype = 'Out Going';
            if($log->callstatus == 2)
            {
            	$callStatus="Answered";
            }
            else
            {
            	$callStatus="Un Answered";
            }        			
                    			
        }
        else if($log->calltype == 3 ){	// Internal
        	$calltype = 'Internal';
        if($log->callstatus==2)
         {
                $callStatus="Answered";
         }
		else
		{
  				$callStatus="Un Answered";
       	}
        	 
        	 
        }
    		
    		
    		
    		
    		$rowData .= '<tr>';
	   		foreach($arrfields as $key=>$fields) {
	   			if($key == 'callstatus')
	   				$rowData .= '<td>'.$callStatus.'</td>';
	   			else if($key == 'calltype')
	   				$rowData .= '<td>'.$calltype.'</td>';
	   			else
	    			$rowData .= '<td>'.$log->$key.'</td>';
	    	}
			$rowData .= '<tr>';
    	}
    	$excelData = ' <table   border="1">'.$header.$rowData.' </table> ';
    	
    	 
    	  
		header("Content-type: application/ms-excel");
        header("Content-Transfer-Encoding: binary");
        header("Content-Disposition: attachment; filename=\"".$filename."\"");
              
        echo $excelData  ;
        exit();
    }
    
    
    
    
     
}

?>