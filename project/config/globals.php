<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | file to define the global variables needed in the application        |
// | File name : globals.php                                                 |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: JINSON MATHEW <jinson.m@armiasystems.com>                    |
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems ? 2011                                      |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

define('SITE_NAME','ICARUS Framework');
define('META_TITLE','ICARUS Framework');
define('META_DES','ICARUS Framework');
define('META_KEYWORDS','ICARUS Framework');

define('SMTPSERVER', 'SMTPSERVER_VALUE');
define('SMTPPORT', 'SMTPPORT_VALUE');
define('SMTPUSERNAME', 'SMTPUSERNAME_VALUE');
define('SMTPPASSWORD', 'SMTP_PASSWORD_VALUE');

PageContext::addJsVar("MAIN_URL", BASE_URL);
PageContext::addJsVar("APP_URL", BASE_URL.'app/');
PageContext::addJsVar("API_URL", BASE_URL.'api/');

PageContext::addJsVar("QUERY_STRING", $_SERVER['QUERY_STRING']);
define('IMAGE_URL', BASE_URL . 'project/images/');
define('IMAGE_MAIN_URL', BASE_URL . 'project/styles/images/');
define('USER_IMAGE_URL', BASE_URL . 'project/files/');

define('ERROR_PAGE', BASE_URL.'error');
define('PROJECT_URL', BASE_URL . 'project/');
define('EXTERNAL_API_URL', BASE_URL . 'project/lib/');
define('FILE_UPLOAD_TABLE', MYSQL_TABLE_PREFIX . "files");
// placeholder images
define('CART_CLASS_PLACEHOLDER', IMAGE_URL . 'noimage.jpg');
define('USER_PROFILE_PLACEHOLDER', IMAGE_URL . 'noprofilephoto.jpg');

PageContext::$response->tooltipicon = '<img src="'.IMAGE_MAIN_URL.'help_icon.png">';

define('FAVICON', 'favicon.ico');

define('TEXT_ALL_FLD_SEARCH','All Field Search');


define('EXTN_START_NO',10);
define('EXTN_END_NO',999);
define("AGENT_EXTENTION_BETWEEN","Please enter extension number between ".EXTN_START_NO." - ".EXTN_END_NO);

define('HELP_ICON','<img src="'.IMAGE_MAIN_URL.'help_icon.png">');
define('DEFAULT_COUNTRY_PH_CODE','+234');
PageContext::$metaTitle = SITE_NAME;

// Company Logo - Default
$companylogo = Utils::getSettings('sitelogo');
PageContext::$response->companyDefaultLogo = USER_IMAGE_URL.$companylogo;



$imageErrors = array(	1 => 'Invalid File Format',
                        2 => 'File size is too large',
                        3 => 'File dimension is not matching' );

//$imageTypes =   array (	"companylogo" 		=> array('prefix'=>'logo_','height'=>'50','width'=>'1000'));
$imageTypes =   array (	"companylogothumb" 		=> array('prefix'=>'companylogo_','height'=>'38','width'=>'184','maxwidth'=>'500','placeholder'=>'noimage.jpg'),
						"agentthumb" 			=> array('prefix'=>'agentthumb_','height'=>'30','width'=>'30','maxwidth'=>'70','placeholder'=>'agent_noimage.jpg') );




// DB status descriptions
/*
 tbl_user->user_status
        0 not verified or not activated
        1 active / verified
        2 diabled / expired
        3 blocked
		4 payment failed



 */
function getCountryList(){
    return $countryList = array("Nigeria","Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua &amp; Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Cape Verde","Cayman Islands","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cruise Ship","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kuwait","Kyrgyz Republic","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Mauritania","Mauritius","Mexico","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Namibia","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Norway","Oman","Pakistan","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Satellite","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","South Africa","South Korea","Spain","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","St. Lucia","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe");
}

function getPriorityTypes(){
    $type   = array(
                1=>'Critical',
                2=>'High',
                3=>'Normal',
                4=>'Low'
              );
    return $type;
}

function getTaskStatus(){
    $status = array(
            1=>'New',
            2=>'Ongoing',
            3=>'Pending',
            4=>'On Hold',
            5=>'Completed',
            6=>'Closed');
    return $status;
}
function getAppointmentTypes(){
    $status = array(
            1=>'Telephonic',
            2=>'Face To Face',
            3=>'Video Conference');
    return $status;
}


function splittext($text,$length) {
	if(strlen($text) > $length)
		echo substr($text,0,strrpos(substr($text,0,$length),' ')).'...';
	else echo $text;
}


function retsplittext($text,$length) {
	if(strlen($text) > $length)
		return substr($text,0,strrpos(substr($text,0,$length),' ')).'...';
	else return $text;
}
	// function to return transaction types
	function transactionTypes() {
		return array(	'1'	=> 'Plan Purchase',
						'2' => 'Plan Renewal Auto Payment',
						'3' => 'Subscriptions' );
	}





	// function to return message types
	function messageTypes() {
		return array(	'1'	=> 'Missed Call',
						'2' => 'Email',
						'3' => 'SMS',
						'4' => 'Voice Mail');
	}

	// function to return message priority
	function messagePriority() {
		return array(	'1'	=> 'High',
						'2' => 'Medium',
						'3' => 'Normal',
						'4' => 'Low');
	}

 	// function to return message status
	function messageStatus() {
		return array(	'1'	=> 'Read',
						'2' => 'Un Read',
						'3' => 'Acknowledged' );
	}



	// function to return lead sources
	function leadsource() {
		return array(	'1'	=> 'Direct',
						'2'	=> 'Google',
						'3' => 'Email',
						'4' => 'Website' );
	}


$calendarMonths		 = array( 	"1" => "January",
							 	"2" => "February",
							 	"3" => "March",
							 	"4" => "April",
							 	"5" => "May",
							 	"6" => "June",
 								"7" => "July",
 								"8" => "August",
 								"9" => "September",
 								"10" => "October",
 								"11" => "November",
 								"12" => "December" );


$taskMins		 = array( 	"00" => "00",
							"15" => "15",
							"30" => "30",
							"45" => "45"  );



	// function to return plan period
	function planperiod() {
		return 	array (	"1" 	=> array('type'=>'monthly','period'=>'1','title'=>'One Month','status' => '1'),
                        "2" 	=> array('type'=>'monthly','period'=>'3','title'=>'Three Month','status' => '1'),
                        "3" 	=> array('type'=>'monthly','period'=>'6','title'=>'Six Month','status' => '1'),
                        "4" 	=> array('type'=>'monthly','period'=>'12','title'=>'One Year','status' => '1'),
						"5" 	=> array('type'=>'monthly','period'=>'24','title'=>'Two Year','status' => '1'),
                        "6"	 	=> array('type'=>'monthly','period'=>'36','title'=>'Three Year','status' => '1'));
	}




// db status descriptions ends
define('CURRENT_THEME','default');


$transactType		 = array( 	"1" => "Registration",
							 	"2" => "Credit" );



/*

Function to print the array
*/
function echopre($printArray)
{
	echo "<pre>";
	print_r($printArray);
	echo "</pre>";
}
function echopre1($printArray)
{
	echo "<pre>";
	print_r($printArray);
	echo "</pre>";
	exit();
}


/*
 * function to return the formatted date
 */
function fdate($dateval) {
	if($dateval != '')
		return date('m-d-Y',strtotime($dateval));
}

function getFDate($dateval){
	if($dateval != '')
		return date('m/d/Y',strtotime($dateval));
}
function getToday(){
		return date('m/d/Y',time());
}

function mysqldate($dateval) {
	if($dateval != '')
		return date('Y-m-d',strtotime($dateval));
}


function getFDateTime($dateval){
	if($dateval != '')
		return date('m/d/Y h:i:s',strtotime($dateval));
}

/*
 * function to validate an input is a date or not
 */
function validateDate($date, $format = 'Y-m-d H:i:s'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}


	/*Email validation*/
	function is_valid_email( $address )
	{
		$rx = "^[a-z0-9\\_\\.\\-]+\\@[a-z0-9\\-]+\\.[a-z0-9\\_\\.\\-]+\\.?[a-z]{1,4}$";
		return (preg_match("~".$rx."~i", $address));
	}


	/*
	function to calculate the age. It shows how old our details with the current time

	*/
	function time_elapsed_string($ptime) {

		$secCheck 	= '432000';// its 4 days time
		//echo time().'<br>';
		//$user_joinedon         = date("Y-m-d H:i:s");
		//$curTime = time();
		//echo date($user_joinedon,$curTime).'<br>';
		$etime 		= time() - $ptime;

		if($etime >= $secCheck) {
			return date('M d',$ptime);
		}
		else {
			if ($etime < 1) {
				return '0 seconds';
			}

			$a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
						30 * 24 * 60 * 60       =>  'month',
						24 * 60 * 60            =>  'day',
						60 * 60                 =>  'hour',
						60                      =>  'minute',
						1                       =>  'second'
						);

			foreach ($a as $secs => $str) {
				$d = $etime / $secs;
				if ($d >= 1) {
					$r = round($d);
					return $r . ' ' . $str . ($r > 1 ? 's' : '').' ago';
				}
			}
		}
	}




function verify_email($email){

  if(!preg_match('/^[_A-z0-9-]+((\.|\+)[_A-z0-9-]+)*@[A-z0-9-]+(\.[A-z0-9-]+)*(\.[A-z]{2,4})$/',$email)){
    return false;
   } else {
    return true;
   }
}


	// Function to refine call_user_func() [php compatibility fix]
	function call_user_func_refined($functionName,$params1=null,$params2=null) {

//echopre($functionName);

		if(phpversion() < '5.2'){
		$dataVal = explode("::",$functionName);
		if($params1!='' && $params2!='')
		$functionVal = call_user_func(array($dataVal[0],$dataVal[1]),$params1,$params2);
		else if($params1!='')
		$functionVal = call_user_func(array($dataVal[0],$dataVal[1]),$params1);
		else
		$functionVal = call_user_func(array($dataVal[0],$dataVal[1]));
		}else{
		if($params1!='' && $params2!='')
		$functionVal = call_user_func($functionName,$params1,$params2);
		else if($params1!='')
		$functionVal = call_user_func($functionName,$params1);
		else
		$functionVal = call_user_func($functionName);
		}
		return $functionVal;
	}


	/*
	 * function to generate the tool tip
	 */
	function generateToolTip($id){
		echo '<a href="#"  class="jqpoptooltip" rel="popover" data-content="'.$id.'"  >
                              	'.PageContext::$response->tooltipicon.'</a>';
	}

	/*
	 * function to redirect the page
	 */
	function redirect($page){
		ob_start();
        header('location:' . BASE_URL . $page );
        exit;
	}

?>
