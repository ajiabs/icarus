<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : application.php                                          |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: BINU CHANDRAN.E<binu.chandran@armiasystems.com>              |
// +----------------------------------------------------------------------+
// | Modified : ARUN SADASIVAN (01/07/2012)								  |
// |----------------------------------------------------------------------+
// | Copyrights Armia Systems � 2010                                      |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+
ob_start();
spl_autoload_register('__autoload');
require_once('settings.php');
require_once('globals.php');

if(DB_BASED_SESSION){	
	require_once('dbsession.php');
	$sess = new SessionManager();
}
session_start();

/*
 * Check wether debugger should be turned On/Off.
 */
Debugger::checkDebugger();


//TODO: load static file for english from /project/resources directory

/**
* Module name
**/
$module			= 'default';
/**
* Controller name
**/
$controllerName = 'index';
/**
* Function name
**/
$method 		= 'index';

/**
* Arguments
**/
$args	 		= '';
//Full url
$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
$url = PROTOCOL  . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
define('Current_Url',$url);
if(strpos($url, '?') !== false)
{
	$url = substr($url, 0,strpos($url, '?'));	
}


//INVOKE ROUTING LOGIC
$route = Router::getRoute($url);
$url = $route;

//Extract uri from full url
$url = str_replace(BASE_URL,'', $url);
//$url = str_replace(BASE_URL,'', $url);
$urlVars = explode("/", $url);

//handle routing logic
//$urlVars = Router::handleRoutes($urlVars);

//MULTI LINGUAL SUPPORT
//TODO: need to refine this logic further
LanguageTranslator::getLocalization();
if(LANG_COMPACTABAILTY)
{
LanguageTranslator::translator_constant();
}

include_once("project/resources/en_static.php");

//The following code is 
//only for facebook app
//$te = array_shift($urlVars);

if(!empty($urlVars) && $urlVars[0] != '' && !isset($_GET['controller']))
{

	if((!(is_dir('project/modules/' . $urlVars[0])) && !(is_dir('modules/' . $urlVars[0])) ) && $urlVars[0] != '')
	{
		array_unshift($urlVars, 'default');
	}
	
	$module	= $urlVars[0];

	if(isset($urlVars[1]) && $urlVars[1] != '')
	{
		$controllerName = $urlVars[1];
	}

	//echo $controllerName;exit;
	if(isset($urlVars[2]) && $urlVars[2] != '')
	{
		$method = $urlVars[2];
	}
	
	if(isset($urlVars[3]) && $urlVars[3] != '')
	{
		$comma = '';
		for($i = 3; $i <= (count($urlVars) -1); $i++)
		{
			$args .= $comma ."'".$urlVars[$i]."'";
			$comma = ',';
		}
	}
}
else
{
	$module 		= isset($_GET['module']) 	? (trim($_GET['module']) !== '' 	? trim($_GET['module']) 	: 'default'): 'default';
	$controllerName = isset($_GET['controller'])? (trim($_GET['controller']) != '' 	? trim($_GET['controller']) : 'index') 	: 'index';
	$method 		= isset($_GET['method']) 	? (trim($_GET['method']) != ''		? trim($_GET['method']) 	: 'index')	: 'index';
}
 
if ($controllerName=='')
	$controllerName = 'index';

/**
* Defining Constants
**/
//define('VIEW', ADMIN_VIEW);
define('VIEW', "view");
PageContext::addJsVar("VIEW", ADMIN_VIEW);

define('MODULE', $module);
define('CONTROLLER', $controllerName);
define('METHOD', $method);
define('ARGS', $args);

/**
* Method to auto load classes
* Controller, Model and views 
* will Load from modules
**/
function __autoload($class)
{


 	//Split class name from camel case
	$classArray 	= preg_split('/(?<=\\w)(?=[A-Z])/', $class);
	$isValidRequest = true;
	/**
	* Controller, Model and views 
	* will Load from modules
	**/
	$nameSpace = array('Controller', 'Model', 'View');
        
	if($isValidRequest == !empty($classArray))
	{
		$module = '';
		$other_module = '';
		if(in_array($classArray[0], $nameSpace))
		{
			$module = 'project/modules/' . MODULE . '/'; //project modules path
			$other_module = 'modules/'.MODULE.'/';	//framework modules path
		}
		//for the project specific mdoules
		$classPath  		= $module . implode($classArray, '/');
		$classPath  		= strtolower($classPath)  . '.php' ;
		
		//for the framework modules
		$otherClassPath 	= $other_module.implode($classArray,'/');
		$otherClassPath 	= strtolower($otherClassPath).".php";
		
		//autoinclude project logics and framework libraries.
		$logicsClassPath  	= 'project/logics/cls_'.strtolower($classPath);
		$libraryClassPath 	= 'lib/'.strtolower($classPath);

		//Check for class file existance
		if(file_exists($classPath)) 
			include_once  $classPath;
		else if(file_exists($otherClassPath))
			include_once($otherClassPath);
		else if(file_exists($logicsClassPath))
			include_once($logicsClassPath);
		else if(file_exists($libraryClassPath)){
			include_once($libraryClassPath);
		}
		else		
		   $isValidRequest = $isValidRequest && class_exists($class);
	}
    
	if(!$isValidRequest)
	{
		
		if(ERROR_PAGE !='')
			header('location:' . BASE_URL . 'error' );
		/*
		if(ENVIRONMENT != 'LOCAL'){
	   		header('HTTP/1.x 404 Not Found'); 
	   		PageContext::printPageNotFoundMessage();	   
	  		exit;
		}
		ob_start();
        header('location:' . BASE_URL . 'error' );
        exit;
		 */
	    $debugObj		 = debug_backtrace();
        $msg = "<div><ul><li>Class File Inclusion Failed: ".$classPath."</li>";
        foreach($debugObj as $dobj){
       		 $msg .= "<li>".$dobj['file']." : Line ".$dobj['line']."</li>";
       		 break;
        }
        $msg .= "</ul></div>";
        PageContext::printErrorMessage("Logic error",$msg);

				
		if(PageContext::$debug)
		{
		// new code addded on 16 Oct 2012 by jinson to show independent error page
		 header('HTTP/1.x 404 Not Found'); 
		 PageContext::printPageNotFoundMessage();
		}
		else 
		{
		 
		 header('HTTP/1.x 404 Not Found'); 
		 PageContext::printPageNotFoundMessage();
		 
		 ob_start();
         header('location:' . BASE_URL . 'error' );
         exit;
		 
		}
    }

}

?>