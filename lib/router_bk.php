<?php

 class RouterBK{

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

//  public static function cond($name, $value, $or = false) {
//    self::$currentCond[] = array("name"=> $name, "value" => addcslashes($value, "/"), "or" => $or);
//  }
//  public static function endcond() {
//    self::$currentCond = array();
//  }

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

//    $condKey = serialize(self::$currentCond);
//    if(!self::$currentCond) $condKey = "DEFAULT";
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
    self::load();
    if (!$url) {
    	$url = preg_replace('/(.*)?\?.*/', "$1", $_SERVER['REQUEST_URI'] ); // remove the query string
		$url = str_replace(BASE_URL, '', BASE_URL . trim($url, "/") . "/");    // remove any prefixes e.g, beta, alpha etc.
    	$url = trim($url, "/") ; 
    	$url = urldecode($url);
    }
    $url = trim($url);
    $url = trim($url, "/");
    $url = str_replace(BASE_URL, '',$url); //new line 
    foreach(self::$rules as $condKey => $rules) {
    	
//    	// If the condition is there then continue only if condition matches
//      if($condKey != "DEFAULT") {
//        $conds = unserialize($condKey);
//        $orgroupflag = false;
//        foreach($conds as $cond) {
//          $match = true;
//          $expr = "/" . $cond['value'] . "/";
//          if(!preg_match($expr, $_SERVER[$cond['name']] )) {
//              $match = false;
//          }
//          // If match found then set the ongroupflag and continue
//          if($match && $cond['or']) {
//              $orgroupflag = true;
//              continue;
//          }
//          if(!$cond['or']) {
//              if($orgroupflag) {
//                  $match = true;
//                  $orgroupflag = false;
//                  continue;
//              }
//          }
//          if(!$match && !$cond['or'] && !$orgroupflag) {
//            break;
//          }
//        }
//        if(!$match)  continue;
//      }

      $match = false;
      foreach($rules as $rule) {
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
    
    $arr = explode("&", $url);
    $action = array_shift($arr);
    
    unset($_REQUEST['_url']);
    unset($_REQUEST['PHPSESSID']);
    unset($_REQUEST['__openid_selector_openid']);
//    $args = array_map("trim", $_REQUEST);
    $args = array();
    foreach($_REQUEST as $key => $value) {
        $args[$key] = $value;
       // unset($_REQUEST[$key]);
    }
    //$args = $_REQUEST;
    foreach($arr as $arg){
      list($name, $value) = explode("=", $arg);
      $args[$name] = $value;
    }
    //return array("action" => $action, "args" => $args);
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
