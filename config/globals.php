<?php 
	
	// All framework globals can be defenied here

	class ENVIRONMENT{
		 	const LOCAL = "local";
		    const DEV   = "dev";
		    const BETA  = "beta";
		    const PRD   = "prd";
		    const QA    = "qa";
	}
	
	define('FB_CLIENT','fb');
	define('MOBILE_CLIENT','mb');
	
	//Include application globals
	$projectGlobalFile = 'project/config/globals.php';
	if(file_exists($projectGlobalFile)) 
	{
		include_once $projectGlobalFile;
	}
	
	
	
	
?>