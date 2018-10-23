<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
/*
 * All project settings and constant defenitions should come here
*/


if ($_SERVER['HTTP_HOST'] == 'localhost')
    define('ENVIRONMENT', 'LOCAL');
else if ($_SERVER['HTTP_HOST'] == 'DEMO_SERVER')
    define('ENVIRONMENT', 'DEMO');
else
    define('ENVIRONMENT', 'LIVE');

if (ENVIRONMENT == 'LOCAL'){
    define('MYSQL_HOST', 'localhost');
    define('MYSQL_USERNAME', 'root');
    define('MYSQL_PASSWORD', 'mysql');
    define('MYSQL_DB', 'icarus');

    define('MYSQL_TABLE_PREFIX', 'tbl_');
    define('BASE_URL', ROOT_URL . 'localhost/icarus/'); 
    define('LIB_DIR', "/usr/local/ampps/www/icarus/project/lib");
    define('FILE_UPLOAD_DIR', "/usr/local/ampps/www/icarus/project/files");
    define('PAYPAL_SANDBOX', 'Y');

}
else if (ENVIRONMENT == 'DEMO_SERVER'){
    define('MYSQL_HOST', '');
    define('MYSQL_USERNAME', '');
    define('MYSQL_PASSWORD', '');
    define('MYSQL_DB', '');
    define('MYSQL_TABLE_PREFIX', 'tbl_');
    define('BASE_URL', ROOT_URL . '');
    define('FILE_UPLOAD_DIR', "");
    define('PAYPAL_SANDBOX', 'Y');

} 
else if (ENVIRONMENT == 'LIVE'){
    define('MYSQL_HOST', '');
    define('MYSQL_USERNAME', '');
    define('MYSQL_PASSWORD', '');
    define('MYSQL_DB', '');
    define('MYSQL_TABLE_PREFIX', 'tbl_');
    define('BASE_URL', ROOT_URL . '');
    define('FILE_UPLOAD_DIR', "");
    define('PAYPAL_SANDBOX', 'Y');
}

define('APPNAME', 'ICARUS Framework');
define('SITENAME', 'ICARUS Framework');
define('ADMIN_VIEW', 'view_two');
define('PAGE_LIST_COUNT', 10);
define('SANDBOX', 'no');
define('DB_BASED_SESSION', false);
define('ADMIN_EMAILS', 'from_email_address');

define('CACHE_ENABLED', true);
define('CACHE_TYPE', 'memcache');
define('CACHE_SERVER', '<SERVER_IP_HERE>');
define('CACHE_PORT', 11211);

define('CMS_DEVELOPER_USERNAME', 'developer');
define('CMS_DEVELOPER_PASSWORD', 'developer');
define('CMS_ROLES_ENABLED', TRUE);
define('GLOBAL_DATE_FORMAT_SEPERATOR', "/");

define('SMARTY_ENABLED', false);
define('DYNAMIC_THEME_ENABLED', true);
define('HTML5_ENABLED', '1');
define('MYSQL_APPTABLE_PREFIX', 'apptbl_');
define('ENABLE_ASTERISK', true);
define('DEFAULT_CURRENCY', '$');
?>
