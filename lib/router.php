<?php

// +----------------------------------------------------------------------+
// | File name : Router.php  	                                          |
// |(Handles the entire routing as defined in  project/config/routes.php) |
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

 class Router {

  public static $loaded = false;
  public static $rules;
  public static $currentCond = array();
  public static $aliases = array();

  public static function load() {
    if(!self::$loaded) {
      include_once   "project/config/routes.php";
      self::$loaded = true;
    }
  }

  public static function alias($name, $value) {
    self::$aliases[$name] = $value;
  }


  private static function addRule(RouteRule $rule) {
    if(self::$aliases) {
      $rule->url = str_replace(array_keys(self::$aliases), array_values(self::$aliases), $rule->url);
    }
    $rule->url = preg_replace('/\^?\/?(.*)\/?\$?/', "$1", $rule->url);
    // Escape all other slashes
    $rule->url = addcslashes($rule->url, "/");
    // Add ^, $ to the final expr
    $rule->url = '^' . $rule->url . '$';

    self::$rules[$condKey][] = $rule;
  }

   public static function connect($url, $target) {
     
    $rule = new RouteRule($url, $target, false);
    self::addRule($rule);
  }

   public static function redirect($url, $target, $status_code=301) {
       
    $rule = new RouteRule($url, $target, true, $status_code);
    self::addRule($rule);
  }


  // This function decides the routing
  public static function getRoute($url = "") {
  	
  	//TODO: Add a cache to the router so that if same url is pinged it can bypass the routing process
  	
    self::load();
    if (!$url) {
    	$url = preg_replace('/(.*)?\?.*/', "$1", $_SERVER['REQUEST_URI'] ); // remove the query string
		$url = str_replace(BASE_URL, '', BASE_URL . trim($url, "/") . "/");    // remove any prefixes e.g, beta, alpha etc.
    	$url = trim($url, "/") ; 
    	$url = urldecode($url);
    }
    
    
    $url = trim($url);   
    $url = str_replace(BASE_URL, '',$url); //new line 
    $url = rtrim($url, "/");
   
    if(self::$rules){
    foreach(self::$rules as $condKey => $rules) {
    	
      $match = false;
      foreach($rules as $rule) {
      
      	$rule->url = str_replace("\/$","$",$rule->url);
      	//echo $rule->url."++++++";
      	
        $expr = "/" . $rule->url . "/i";            
        if(preg_match($expr, $url)){
        	
           // Check for redirect
           if($rule->redirect_flag) {
              $rule->target = preg_replace($expr, $rule->target, $url);
              if (preg_match('/^https?:\/\//i', $rule->target)) {
              	$redirect_url = $rule->target;
              }
              else {
              	$redirect_url = rtrim(BASE_URL, '/') . '/' . ltrim($rule->target, '/');
              }
            //  Logger::info("Redirecting [$redirect_url]");
              if ($rule->status_code == 301) {
              //	Logger::info("Performing 301 redirect for [$redirect_url]");
              	header("HTTP/1.0 301 Moved Permanently");
              }
              header("Location: $redirect_url");
              exit;
           }
           
          $url = preg_replace($expr, $rule->target, $url);
          $match = true;
        }
        if($match) break;
      }
      if($match) break;
    }
    }
    
    $arr = explode("&", $url);
    $action = array_shift($arr);
    
    unset($_REQUEST['_url']);
    unset($_REQUEST['PHPSESSID']);
    unset($_REQUEST['__openid_selector_openid']);
    $args = array_map("trim", $_REQUEST);
    $args = array();
    foreach($_REQUEST as $key => $value) {
        $args[$key] = $value;
        //unset($_REQUEST[$key]);
    }
    $args = $_REQUEST;
    foreach($arr as $arg){
      list($name, $value) = explode("=", $arg);
      $args[$name] = $value;
    }
   // $_REQUEST = PageContext::$request;
    if($args){PageContext::$request = $args;}//$_REQUEST = $args;}
    return BASE_URL.$action;
  }
 }

 class RouteRule {
    public $url;
    public $target;
    public $redirect_flag = false;
    public $status_code = 200;
    public function RouteRule($url, $target, $redirect_flag=false, $status_code=200) {
        $this->url = $url;
        $this->target = $target;
        $this->redirect_flag = $redirect_flag;
        $this->status_code = $status_code;
    }
 }


?>
