<?php

$app_root = realpath(_FILE_);
$app_root = dirname(dirname($app_root));
$app_root = preg_replace('@\\\@', '/', $app_root);
$app_root = str_replace("config","",$app_root);
define('APPROOT', $app_root);

// define('FILE_UPLOAD_DIR', APPROOT . "/project/files");
define('RESOURCES_DIR', APPROOT . "project/resources");

//    $app_root = realpath(__FILE__);
//	$app_root = dirname($app_root);
//	$app_root = preg_replace('@\\\@', '/', $app_root);
//	$app_root = str_replace("config","",$app_root);
//	define('APPROOT', $app_root);
//
//	define('FILE_UPLOAD_DIR', dirname(APPROOT) . "/project/files");
//	define('RESOURCES_DIR', APPROOT . "project/resources");

/**
 * Protocol
 * @var string
 **/
$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
$protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) .$s . "://";
define('PROTOCOL', $protocol);
define('ROOT_URL', PROTOCOL );//. $_SERVER['HTTP_HOST'] . "/");

$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
$protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
$url = $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];

$projectSettingsFile = 'project/config/settings.php';	
if(file_exists($projectSettingsFile)) {
    include_once $projectSettingsFile;
}else {
    echo "PROJECT SETTINGS FILE (".$projectSettingsFile.") IS MISSING";
    exit;
}

// To include framework config file
$frameworkSettingsFile = 'project/config/iconfig.php';
if(file_exists($frameworkSettingsFile)) {
    include_once $frameworkSettingsFile;
}else {
    echo "FRAMEWORK SETTINGS FILE (".$frameworkSettingsFile.") IS MISSING";
    exit;
}

?>