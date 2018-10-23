<?php 

// +----------------------------------------------------------------------+
// | File name : page_context.php                                                |
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

class PageContext{
	
	private static $table_metadata 		= "fw_metadata";
	public static $debug 			  	= false;
	public static $debugObj 		  	= null; 
	public static $styleObj 		  	= null;
	public static $themeStyleObj 	  	= null;
	public static $scriptObj 		  	= null;
	public static $headerCodeSnippet 	= null;
	public static $footerCodeSnippet 	= null;
	public static $body_class		  	= "";
	public static $includes		  		= null;
	public static $loggerObj		  	= null;
	public static $response		  		= null;
	public static $request			  	= null;
	public static $jsVarsObj		  	= null;
	public static $postActionObj     	= null;
	public static $errorObject		  	= null;
	public static $enableBootStrap   	= false;
	public static $enableFusionchart 	= false;
	public static $enableJquerychart 	= false;
	public static $enableFCkEditor   	= false;
	public static $metaTitle		  	= null;
	public static $metaDes		  	  	= null;
	public static $metaKey			  	= null;
	public static $isCMS			  	= false;
	public static $layoutPostActionObj 	= null;
	public static $smarty 				= null;
	public static $smartyParsing 		= true;
	//enable or disable angular js
	public static $enableAngularJs 				= false;
	// include angular listing component
	public static $enableListingComponent 		= false;
	// include latest jquery
	public static $includeLatestJquery 			= true;
	 
	 
	 //public static $page_cache		 = false;
	 
	 
	 public static $full_layout_rendering = true; //setting this to false will turn ofd debugger renering
	 
	public static function addPostAction($method,$controller=CONTROLLER,$module=MODULE){
	 	$actionObj 									= new stdClass();
	 	$actionObj->method   						= $method;
	 	$actionObj->controller = $controller;
	 	$actionObj->module 		= $module;
	 	PageContext::$postActionObj->actions[] 		= $actionObj;
	}
	 
	public static function renderPostAction($method,$controller=CONTROLLER,$module=MODULE,$externalModule='') {
    
        if(PageContext::$postActionObj) {
            foreach(PageContext::$postActionObj->actions as $action) {
                if(($action->method == $method) && ($action->controller == $controller) && ($action->module == $module)) {
                    
                    if($externalModule)
                        $filePath = 'modules/' . strtolower($action->module). '/view/script/' . strtolower($action->controller) . '/' . strtolower($action->method) . '.tpl.php';
                    else
                        $filePath = 'project/modules/' . strtolower($action->module). '/view/script/' . strtolower($action->controller) . '/' . strtolower($action->method) . '.tpl.php';
                    if(file_exists($filePath)) {
                    	
                    	 
                    		if(SMARTY_ENABLED==1 && !$externalModule && PageContext::$smartyParsing != false)
                   				{
                   			 
                   					if(PageContext::$debug)
                   						{
                   				PageContext::$smarty->debugging=true;
                   						}
                   			 echo "<div class='post_action'>";
                   			PageContext::$smarty->setTemplateDir(str_replace(strtolower($action->method) . '.tpl.php',"",$filePath));
                   	    	PageContext::$smarty->display(strtolower($action->method) . '.tpl.php');
                   	    	echo "</div>";
                   	                	
                   		    
                   				}
                   		else
                   		{
                        echo "<div class='post_action'>";
                        require $filePath;
                        echo "</div>";
                   		}
                    }
                }
            }
        }
    }
	 
	 public static function addStyle($style_path,$isTheme=false){
	 	if($isTheme)
	 		PageContext::$themeStyleObj->urls[] = $style_path;
	 	else
	 		PageContext::$styleObj->urls[] = $style_path;
	 }
	 
	 
	
	 
	 public static function addScript($script_path,$isTheme=false){
	 	PageContext::$scriptObj->urls[] = $script_path;
	 }


	  public static function includePathPdf($dir_path){
	 	$directory = 'project/lib/'.$dir_path;
	 	include_once($directory);
	 }
	
	 
	 public static function addJsVar($key,$value){
	 	$varObj 		= new stdClass();
	 	$varObj->variable  = $key;
	 	$varObj->value  = $value;
	 	PageContext::$jsVarsObj->jsvar[] = $varObj;
	 }
	 
	 //includes all files of the directory into the project 
	 public static function includePath($dir_path){
	 	$directory = 'project/lib/'.$dir_path;
	 	if(!is_dir($directory))return;
	 	if ($handle = opendir($directory)) {
	 	 	while (false !== ($file = readdir($handle))) {
	 	 		
	 	 		if ($file == "." && $file == "..") continue;	 	 		    		 
		       	if(is_dir($directory.'/'.$file))continue;
				$path_parts = pathinfo($directory.'/'.$file);
				if(!$path_parts || $path_parts['extension']	!=	'php')continue;
				include_once($directory.'/'.$file);				
		    }
		  	closedir($handle);
	 	}
	 }
	 
	 public static function handleError(){
	 		 	
	 	//TODO: need to implement a switch which will determine whether to display original error or send error mailt o admin based on environment
	 	if (!function_exists('error_get_last'))return;
	 	$error = error_get_last();
	 	if(ENVIRONMENT == 'LOCAL' && $error['type'] !=8 ){
			print_r($error);exit;	 		
	 	}
    	if ($error['type'] ==1 || $error['type']==4 ) {
		        
				$errormsgblock ='<div>
									  <ul>
					                    <li><b>Line</b> '.$error['line'].'</li>
			                            <li><b>Message</b> '.$error['message'].'</li>
			                            <li><b>File</b> '.$error['file'].'</li>                             
			                          </ul>
			                     </div>';
				PageContext::printErrorMessage("Fatal Error",$errormsgblock);		
    	}
	 }
	 
	 public static function printErrorMessage($title,$message_block){
			 				
	 		$message='<html><header><title>'.$title.'</title></header>
		                    <style>                 
		                    .error_content{                     
		                        background: ghostwhite;
		                        vertical-align: middle;
		                        margin:0 auto;
		                        padding:10px;
		                        width:50%;                              
		                     } 
		                     .error_content label{color: red;font-family: Georgia;font-size: 16pt;font-style: italic;}
		                     .error_content ul li{ background: none repeat scroll 0 0 FloralWhite;                   
		                                border: 1px solid AliceBlue;
		                                display: block;
		                                font-family: monospace;
		                                padding: 2%;
		                                text-align: left;
		                      }
		                    </style>
		                    <body style="text-align: center;">  
		                      <div class="error_content">
		                          <label >'.$title.'</label>'.
		                          $message_block
		                          .'<a href="javascript:history.back()"> Back </a>                          
		                      </div>
		                    </body></html>';
	 		
		    if(ERROR_REPORTING_TO_ISCRIPTS == true){
		    	//send error mail to iscripts
		    }
		    
		    if(ENVIRONMENT != 'LOCAL'){			 		
			 	include_once(BASE_URL."project/error.html");
			 	exit;
			}
		    echo $message;
		    exit;
	 }
	 
	public static function printPageNotFoundMessage(){
	 		$message='<html><header><title>Page Not Found</title></header>
		                    <style>                 
		                     .error_content{                     
		                        background: #f1f1f1;
		                        vertical-align: middle;
		                        margin:0 auto;
		                        padding:20px;
		                        margin-top:100px;
		                        width:50%;      
		                        border: 1px solid #DDD;
								color: #333;                        
		                     } 
		                     .error_content label{color: red;font-family: Georgia;font-size: 16pt;font-style: italic;}
		                     .error_content ul li{ background: none repeat scroll 0 0 FloralWhite;                   
		                                border: 1px solid AliceBlue;
		                                display: block;
		                                font-family: monospace;
		                                padding: 2%;
		                                text-align: left;
		                      }
		                      
		                     .error_content h1 {
									font-family: "trebuchet MS";
									font-size: 26px;
									color: #707070;
									text-align: middle;				
									background-repeat: no-repeat;
									background-position: 10% 50%;
									
							 }
								
							 .error_content a{
								 	color:#c00000;
							 }								
		                    </style>
		                    <body style="text-align: center;">  
		                      <div class="error_content">
		                          <h1>Page Not Found</h1>
		                          <p>Sorry, the page you have been looking for appears to have been moved, deleted or simply does not exist.<br />Click on the link below to go back to the previous page.</p>
		                          <a href="javascript:history.back()"> Back </a>                          
		                      </div>
		                    </body></html>';
		
		        echo $message;
		        exit;
	 }
	 
	 //register a post action from code
	 public static function registerPostAction($position,$method,$controller=CONTROLLER,$module=MODULE){
	 	$actionObj 											= new stdClass();
	 	$actionObj->position								= $position;
	 	$actionObj->method   								= $method;
	 	$actionObj->controller 								= $controller;
	 	$actionObj->module 									= $module;
	 	PageContext::$layoutPostActionObj->actions[] 		= $actionObj;
	 }
	 
	 //render all post actions in a position
	 public static function renderRegisteredPostActions($position){
		 if(PageContext::$layoutPostActionObj) {
            foreach(PageContext::$layoutPostActionObj->actions as $action) {
                if($action->position == $position) {
                    
                   $filePath = 'project/modules/' . strtolower($action->module). '/' .VIEW. '/script/' . strtolower($action->controller) . '/' . strtolower($action->method) . '.tpl.php';
                   if(file_exists($filePath)) {
                   
                   		if(SMARTY_ENABLED==1 && PageContext::$smartyParsing != false)
                   		{
                   			 
                   			if(PageContext::$debug)
                   			{
                   				PageContext::$smarty->debugging=true;
                   			}
                   			//echo "<div class='post_action_'.$position.'>";
                   			PageContext::$smarty->setTemplateDir('project/modules/' . strtolower($action->module). '/' .VIEW. '/script/' . strtolower($action->controller) . '/');
                   	    	PageContext::$smarty->display($action->method. '.tpl.php');
                   	    	//echo "</div>";
                   	                	
                   		    
                   		}
                   		else
                   		{
                   		//echo "<div class='post_action_'.$position.'>";                    
                        require $filePath;
                        //echo "</div>";
                   		}
                   }
                }
            }
        }
      
	 }
	 
	 
	 public static function renderCurrentTheme(){
	 		ob_start();							
			$filePath = 'project/themes/' . CURRENT_THEME . '/layout.tpl.php';
			
				require_once $filePath;
                   	//	}
			//}
			return ob_get_clean();
	 }
	 
	 public static function printThemePath(){
	 	echo  ConfigUrl::root()."/project/themes/".CURRENT_THEME."/";
	 }
	 public static function registerMetaData()
	 {
	 	$db = new BaseModel();
	 	$url=$_SERVER['PATH_INFO'];
	 	if(!($url[strlen($url)-1]=='/'))
	 		$url=$url."/";
	 	if($db->checkTableExist(PageContext::$table_metadata))
	 	{
	 
	 		//Initial Value
	 
	 		if($result=$db->selectResultFrom(PageContext::$table_metadata,"keyword,description,title","url = '*'"))
	 		{
	 			PageContext::$metaKey=$result[0]->keyword;
	 			PageContext::$metaDes=$result[0]->description;
	 			PageContext::$metaTitle=SITE_NAME . " : " . $result[0]->title;
	 		}
	 	 	
	 	 	
	 	 	
	 		$count=substr_count($url,"/");
	 		$metaTagUrls=$db->selectResultFrom(PageContext::$table_metadata, url, "1=1");
	 
	 		for($i=0;$i<$count;$i++)
	 		{
	 		if($i==0)
	 			$url=$url;
	 			else
	 			{
	 			$url=strrev($url);
	 			$url=preg_replace('/\/.*?\//',"*/", $url,1);
	 	 			$url=strrev($url);
	 	 			$url=str_replace("**","*",$url);
	 	 					$url=$url."/";
	 			}
	 
	 				
	 	 			foreach ($metaTagUrls as $metaTagUrl)
	 	 			{
	 
	 	 			//For Appending / at end
	 	 				if(!( $metaTagUrl->url[strlen( $metaTagUrl->url)-1]=='/'))
	 	 				$metaTagUrlref->url= $metaTagUrl->url."/";
	 	 				else
	 	 					$metaTagUrlref->url= $metaTagUrl->url;
	 
	 	 					//For Appending / at Begining
	 	 				if(!($metaTagUrlref->url[0]=='/'))
	 	 				$metaTagUrlref->url= "/".$metaTagUrlref->url;
	 	 				else
	 	 					$metaTagUrlref->url= $metaTagUrlref->url;
	 
	 	 					//echo "<br>".$metaTagUrlref->url."==".$url;
	 	 				if($metaTagUrlref->url==$url)
	 	 				{
	 	 				$result=$db->selectResultFrom(PageContext::$table_metadata,"keyword,description,title","url = '".$metaTagUrl->url."'");
	 	 				PageContext::$metaKey=$result[0]->keyword;
	 	 				PageContext::$metaDes=$result[0]->description;
	 	 				PageContext::$metaTitle=$result[0]->title;
	 	 				return;
	 	 				}
	 	 				}
	 	 				}
	 	 				}
	 
	 	 				}
	 
	 	 				
	 public static function enableSmarty()
	 {

        		require_once('lib/smartylayout.php');
                PageContext::$smarty=new Smartylayout();
                
                

	 	
	 }
	 
}


?>