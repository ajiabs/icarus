<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : cls_user.php                                                 |
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

class User {



    /*
     * function to create the user
    */
    public static  function createUser($objUserVo) {
        $objResult                      =   new stdClass();
        $objResult->status              =   "SUCCESS";

        //Check Entered User Email Exists OR NOT then stop user sign up if email exists
        $objUserEmailCount              =   self::checkUserEmailExists($objUserVo->user_email);
        if(sizeof($objUserEmailCount) > 0 ) {
            $objResult->user_status     = $objUserEmailCount->user_status;
            $objResult->status          = "ERROR";
            $objResult->message         = USER_EMAIL_EXIST; // Email Alreday Exists
        }

        // Insert User data to to User table
        if($objResult->status=="SUCCESS") {
            $db                    =   new Db();
            $tableName             =   Utils::setTablePrefix('users');
            $customerId            =   $db->insert($tableName,
                    array(  'user_email'            =>  Utils::escapeString($objUserVo->user_email),
                    'user_company'          =>  Utils::escapeString($objUserVo->user_company),
                    'user_password'         =>  Utils::escapeString($objUserVo->user_pwd),
                    'user_fname'            =>  Utils::escapeString($objUserVo->user_fname),
                    'user_lname'            =>  Utils::escapeString($objUserVo->user_lname),
                    'user_status'           =>  Utils::escapeString($objUserVo->user_status),
                    'user_phone'            =>  Utils::escapeString($objUserVo->user_phone),
                    'user_phone_extension'  =>  Utils::escapeString($objUserVo->user_phone_extension),
                    'user_joinedon'         =>  Utils::escapeString($objUserVo->user_joinedon),
                    'user_activation_key'   =>  Utils::escapeString($objUserVo->user_activation_key)   ));
            $objUserVo->user_id    =   $customerId;

            $objResult->data       =   $objUserVo;
        }
        return $objResult;

    }

    public static  function createSalesRep($objUserVo) {
        $objResult                      =   new stdClass();
        $objResult->status              =   "SUCCESS";

        //Check Entered User Email Exists OR NOT then stop user sign up if email exists
        $objUserEmailCount              =   self::checkSalesRepEmailExists($objUserVo->salesrep_email);
        if(sizeof($objUserEmailCount) > 0 ) {
            $objResult->user_status     = $objUserEmailCount->user_status;
            $objResult->status          = "ERROR";
            $objResult->message         = USER_EMAIL_EXIST; // Email Alreday Exists
        }
//echopre1($objUserVo);
        // Insert User data to to User table
        if($objResult->status=="SUCCESS") {
            $db                    =   new Db();
            $tableName             =   Utils::setTablePrefix('salesrep');
            $customerId            =   $db->insert($tableName,
                    array(  'salesrep_email'            =>  Utils::escapeString($objUserVo->salesrep_email),
                    'salesrep_fname'            =>  Utils::escapeString($objUserVo->salesrep_fname),
                    'salesrep_lname'            =>  Utils::escapeString($objUserVo->salesrep_lname),
                    'salesrep_address'          =>  Utils::escapeString($objUserVo->salesrep_address),

                    'salesrep_country'          =>  Utils::escapeString($objUserVo->salesrep_country),
                    'salesrep_state'            =>  Utils::escapeString($objUserVo->salesrep_state),
                    'salesrep_pincode'              =>  Utils::escapeString($objUserVo->salesrep_pincode),
                        'salesrep_phone'            =>  Utils::escapeString($objUserVo->salesrep_phone),
                         'salesrep_photo_id'            =>  Utils::escapeString($objUserVo->salesrep_photo_id),
                        'salesrep_password'             =>  Utils::escapeString($objUserVo->salesrep_password),
                        'salesrep_status'           =>  Utils::escapeString($objUserVo->salesrep_status),
                    'salesrep_joinedon'  =>  Utils::escapeString($objUserVo->salesrep_joinedon)
                      ));
            $objUserVo->user_id    =   $customerId;

            if($customerId)
            {
                $tableName             =   'cms_users';

                $customerId            =   $db->insert($tableName,
                    array(  'type'          =>  Utils::escapeString('admin'),
                    'username'          =>  Utils::escapeString($objUserVo->salesrep_fname),
                    'email'         =>  Utils::escapeString($objUserVo->salesrep_email),
                    'password'          =>  Utils::escapeString($objUserVo->salesrep_password),
                    'role_id'           =>  Utils::escapeString(11),
                    'status'            =>  Utils::escapeString('active'),
                    'module'            =>  Utils::escapeString('admin'),
                        'visibility'            =>  Utils::escapeString(1)

                      ));

            }



            $objResult->data       =   $objUserVo;
        }

      //  print_r($objResult); exit;
       //
        return $objResult;

    }




     public static  function createArtworks($objUserVo) {
        $objResult                      =   new stdClass();
        $objResult->status              =   "SUCCESS";

        // Insert User data to to User table
        if($objResult->status=="SUCCESS") {
            $db                    =   new Db();
            $tableName             =   Utils::setTablePrefix('artworks');
            $customerId            =   $db->insert($tableName,
                    array(  'order_id'            =>  Utils::escapeString($objUserVo->order_id),
                    'od_id'            =>  Utils::escapeString($objUserVo->od_id),
                    'url'            =>  Utils::escapeString($objUserVo->url),
                    'description'          =>  Utils::escapeString($objUserVo->description),
                    'artworks_image1_id'          =>  Utils::escapeString($objUserVo->artworkfile1),
                    'artworks_image2_id'          =>  Utils::escapeString($objUserVo->artworkfile2)
                      ));

            $objResult->data       =   $objUserVo;
        }

      //  print_r($objResult); exit;
       //
        return $objResult;

    }





       public static  function createCampaignLeads($objUserVo) {
        $objResult                      =   new stdClass();
        $objResult->status              =   "SUCCESS";
       // echopre($objUserVo);
        //Check Entered User Email Exists OR NOT then stop user sign up if email exists
        $objUserEmailCount              =   self::checkleadEmailExists($objUserVo->lead_email);
        if(sizeof($objUserEmailCount) > 0 ) {
            $objResult->lead_id     = $objUserEmailCount->lead_id;
            return $objResult;
        }

        // Insert User data to to User table
        if($objResult->status=="SUCCESS") {
            $db                    =   new Db();
            $tableName             =   Utils::setTablePrefix('campaign_leads');
            $customerId            =   $db->insert($tableName,
                    array(  'lead_fname'            =>  Utils::escapeString($objUserVo->lead_fname),
                    'lead_lname'            =>  Utils::escapeString($objUserVo->lead_lname),
                        'lead_company'          =>  Utils::escapeString($objUserVo->lead_company),
                    'lead_address'          =>  Utils::escapeString($objUserVo->lead_address),
                    'lead_email'            =>  Utils::escapeString($objUserVo->lead_email),
                    'lead_pincode'          =>  Utils::escapeString($objUserVo->lead_pincode),
                    'lead_state'            =>  Utils::escapeString($objUserVo->lead_state),
                    'lead_phoneno'              =>  Utils::escapeString($objUserVo->lead_phoneno),
                        'lead_country'              =>  Utils::escapeString('USA'),
                         'lead_address'             =>  Utils::escapeString($objUserVo->lead_address),
                        'lead_joined_on'            =>  Utils::escapeString(date('y-m-d'))

                      ));
            $objResult->lead_id    =   $customerId;





            $objResult->data       =   $objUserVo;
        }

      //  print_r($objResult); exit;
       //
        return $objResult;

    }



      public static  function createOrder($objUserVo) {
        $objResult                      =   new stdClass();
        $objResult->status              =   "SUCCESS";
       // echopre($objUserVo);
        //Check Entered User Email Exists OR NOT then stop user sign up if email exists


         $objSession                    = new LibSession();
   $cartobjects = $_SESSION['products'];

   $carInfo = Schools::getCartInfo($cartobjects);

    //echopre1($_SESSION['products']);

   $total_amount = 0;


   foreach ($carInfo as $k=>$v)
   {
       $total_amount+= ($v['ad_amount']*$v['share_of_voice']) * $v['plan_period'];
   }

   $salesrep = json_decode($objSession->get('kb_user'),TRUE);
  //echopre1($objUserVo);

        // Insert User data to to User table
        if($objResult->status=="SUCCESS") {
            $db                    =   new Db();
            $tableName             =   Utils::setTablePrefix('orders');
            $orderId            =   $db->insert($tableName,
                    array(  'salesrep_id'           =>  Utils::escapeString($salesrep['salesrep_id']),
                    'campaign_name'             =>  Utils::escapeString($objUserVo->campaign_name),
                        'order_status'          =>  Utils::escapeString(0),
                    'lead_id'           =>  Utils::escapeString($objUserVo->lead_id),
                    'order_decription'          =>  Utils::escapeString($objUserVo->order_decription),
                    'payemnt_status'            =>  Utils::escapeString(0),
                        'contract_type'             =>  Utils::escapeString($objUserVo->contract_type),
                    'payment_amount'            =>  Utils::escapeString($total_amount),
                        'purchase_date'             =>  Utils::escapeString(date('Y-m-d H:i:s'))

                      ));

            $objUserVo->payment_amount = $total_amount;

            $objResult->order_id    =   $orderId;
            $objResult->data       =   $objUserVo;

            $objUserVo->order_id = $orderId;

            if($orderId)
            {

                foreach ($carInfo as $key=>$val)
                {

                    $plantime = $val['plan_period'];
                    $time = strtotime($val['campaign_start_date']);

$campaign_end_date = date("Y-m-d", strtotime("+$plantime month", $time));
$campaign_start_date = date("Y-m-d", $time);



                    $total = ($val['ad_amount']*$val['share_of_voice']) * $val['plan_period'];

                    $tableName             =   Utils::setTablePrefix('order_details');
                      $od_id            =   $db->insert($tableName,
                    array(  'order_id'          =>  Utils::escapeString($objUserVo->order_id),
                    'od_item_amount'            =>  Utils::escapeString($total),
                        'od_share_voice'            =>  Utils::escapeString($val['share_of_voice']),
                    'od_created_by'         =>  Utils::escapeString($salesrep['salesrep_id']),
                    'school_slot_id'            =>  Utils::escapeString($val['school_slot_id']),
                    'slot_id'           =>  Utils::escapeString($val['slot_id']),
                    'plan_id'           =>  Utils::escapeString($val['plan_id']),
                        'odd_status'            =>  Utils::escapeString(0),
                        'school_id'             =>  Utils::escapeString($val['school_id']),
                        'salesrep_id'           =>  Utils::escapeString($salesrep['salesrep_id']),
                        'plan_period'           =>  Utils::escapeString($val['plan_period']),
                        'campaign_start_date'           =>  Utils::escapeString($campaign_start_date),
                        'campaign_end_date'             =>  Utils::escapeString($campaign_end_date),
                        'od_created_on'             =>  Utils::escapeString(date('Y-m-d H:i:s'))

                      ));

                }
            }


        }




      //  print_r($objResult); exit;
       //
        return $objResult;

    }




    /*
     * function to update the user information
    */
    public static function updateUserinfo($userid, $arrUser) {
        $db                     = new Db();
        $condition              = "user_id =" . $userid;
        return $db->updateFields('users', $arrUser, $condition);
    }


     /*
     * function to update the artwork information
    */
    public static function updateArtworks($od_id, $arrArt) {
       // print_r($arrArt);die();
        $db                     = new Db();
        $condition              = "od_id =" . $od_id;
        return $db->updateFields('artworks', $arrArt, $condition);
    }

    /*
     * function to get the user id from smb app id information
    */
    public static function getSmbDetails($appid) {
        $db                     =   new Db();
        $tableName = 'smb_account';
        return $db->selectRecord($tableName,'*','smb_acc_id = "'.Utils::escapeString($appid).'"' );

    }




    /*
     * function to get the user id from smb app id information
    */
    public static function getUserlogin($user_id) {
        $db                     =   new Db();
        $tableName = 'users';
        return $db->selectRecord($tableName,'*','user_id = "'.Utils::escapeString($user_id).'"' );

    }


    /*
     *Function to check  Customer email address already exists
    */
    public static function checkUserEmailExists($emailAddress,$customerId = '') {
        $tableName              =  'users';
        $db                     =   new db();
        if($customerId > 0)
            $andCase            = ' AND user_id !="'.Utils::escapeString($customerId).'"';
        return $db->selectRecord($tableName,'user_id,user_status','user_email = "'.Utils::escapeString($emailAddress).'" '.$andCase );
    }


 public static function checkArtworkExists($order_id,$od_id) {
        $tableName              =  'artworks';
        $db                     =   new db();
        if($order_id > 0)
            $andCase = ' AND od_id ="'.$od_id.'"';
        return $db->selectRecord($tableName,'order_id,od_id','order_id = "'.$order_id.'" '.$andCase );
    }


 public static function checkSalesRepEmailExists($emailAddress,$customerId = '') {
        $tableName              =  'salesrep';
        $db                     =   new db();
        if($customerId > 0)
            $andCase            = ' AND salesrep_id !="'.Utils::escapeString($customerId).'"';
        return $db->selectRecord($tableName,'salesrep_id,salesrep_status','salesrep_email = "'.Utils::escapeString($emailAddress).'" '.$andCase );
    }
 public static function checkleadEmailExists($emailAddress,$customerId = '') {
        $tableName              =  'campaign_leads';
        $db                     =   new db();
        if($customerId > 0)
            $andCase            = ' AND salesrep_id !="'.Utils::escapeString($customerId).'"';
        return $db->selectRecord($tableName,'*','lead_email = "'.Utils::escapeString($emailAddress).'" '.$andCase );
    }



    /*
     * function to check the user login credentials
    */


    public static function salesrepLogin($arrLoginInfo)
    {

        $username                   = trim($arrLoginInfo['user_email']);
        $password                   = trim($arrLoginInfo['user_pwd']);

        $validationStatus           = TRUE;


         if(empty($username) && empty($password)) {
            $arrLogResult['valMessage']             = CUSTOMER_LOGIN_USERNAME_AND_PASSWORD_MISSING;
            $arrLogResult['status']      = FALSE;
        }
        else if(empty($username)) {
            $arrLogResult['valMessage']             = CUSTOMER_LOGIN_USERNAME_MISSING;
            $arrLogResult['status']      = FALSE;
        }
        else if(empty($password)) {
            $arrLogResult['valMessage']             = CUSTOMER_LOGIN_PASSWORD_MISSING;
            $arrLogResult['status']      = FALSE;
        }


         if($validationStatus) {
              $db                       =   new db();
            //  echo 'salesrep_email = "'.Utils::escapeString($username).'"  AND `salesrep_password` = "'.md5($password).'"';
                $loginInfo = $db->selectRecord('salesrep','*','salesrep_email = "'.Utils::escapeString($username).'"  AND `salesrep_password` = "'.md5($password).'"');

               // echo sizeof($loginInfo);die();

                if(sizeof($loginInfo) > 0) {        // login success
                    $customer               = new Userobject();
                    $customer->salesrep_id       =  $loginInfo->salesrep_id;
                    $customer->email       =  $loginInfo->salesrep_email;
                    $customer->first_name       =  $loginInfo->salesrep_fname;
                    $customer->last_name       =  $loginInfo->salesrep_lname;
                    $customer->state       =  $loginInfo->salesrep_state;
                    $customer->user_type       =  'salesrep';

                    if(!$loginInfo->salesrep_status)
                    {
                        $arrLogResult['valMessage']             = CUSTOMER_LOGIN_ACTIVATION;
                        $arrLogResult['status']      = FALSE;
                        return $arrLogResult;

                    }





                    $loginInfo = $db->selectRecord('salesrep','*','salesrep_email = "'.Utils::escapeString($username).'"  AND `salesrep_password` = "'.md5($password).'"');

                    $query = "select * from cms_users where email = '".$loginInfo->salesrep_email."'";


                    $cmsData = $db->selectQuery($query);






                    $objSession                     = new LibSession();
                    $objSession->set('kb_user',json_encode($customer));





                    $_SESSION['cms_admin_type'] = 'admin';
                    $_SESSION['cms_admin_logged_in'] = 1;
                    $_SESSION['cms_admin_logged_in'] = 1;
                    $_SESSION['cms_cms_username'] = $cmsData[0]->username;
                    $_SESSION['cms_user_id'] = $cmsData[0]->id;
                    $_SESSION['cms_module'] = 'admin';
                    $_SESSION['cms_role_id'] = $cmsData[0]->role_id;
                    $_SESSION['chartcount'] = 7;

                    $arrLogResult['valMessage']     = 'success';
                    $arrLogResult['status']         = TRUE ;
                }
                else {          // login failed
                    $arrLogResult['valMessage']     = INVALID_USER_LOGIN_MSG;
                    $arrLogResult['status']         = FALSE;
                }



         }
         return $arrLogResult;
    }




    /*
     * function to get forgot password
    */


    public static function salesrepForgot($arrLoginInfo)
    {

        $username                   = trim($arrLoginInfo['user_email']);

        $validationStatus           = TRUE;


        if(empty($username)) {
            $arrLogResult['valMessage']             = CUSTOMER_LOGIN_USERNAME_MISSING;
            $arrLogResult['status']      = FALSE;
        }


         if($validationStatus) {
              $db                       =   new db();
            //  echo 'salesrep_email = "'.Utils::escapeString($username).'"  AND `salesrep_password` = "'.md5($password).'"';
                $loginInfo = $db->selectRecord('salesrep','*','salesrep_email = "'.Utils::escapeString($username).'"');

               // echo sizeof($loginInfo);die();

                if(sizeof($loginInfo) > 0) {


                    $loginInfo = $db->selectRecord('salesrep','*','salesrep_email = "'.Utils::escapeString($username).'"');
                    $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                                     .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                                     .'0123456789!@#$%^&*()'); // and any other characters
                    shuffle($seed); // probably optional since array_is randomized; this may be redundant
                    $rand = '';
                    foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];
                    $password = md5($rand);
                    $query = "UPDATE tbl_salesrep SET `salesrep_password`='".$password."' where salesrep_email = '".Utils::escapeString($username)."'";


                    $cmsData = $db->execute($query);

                   // $password = $cmsData[0]->salesrep_password;
                    $password = md5($password);

                    $replaceParameters =  array(
                            "email"        => trim($username),
                            "loginLink"    => BASE_URL.'',
                            "password" => $password
                    );
                    if(ENVIRONMENT!='LOCAL')
                        Utils::sendUserMail($username, 'forgotPassword', $replaceParameters);

                  $arrLogResult['valMessage']     = 'success';
                    $arrLogResult['status']         = TRUE ;
                }
                else {          // login failed
                    $arrLogResult['valMessage']     = INVALID_USER_LOGIN_MSG;
                    $arrLogResult['status']         = FALSE;
                }



         }
         return $arrLogResult;
    }





    public static function doLogin($arrLoginInfo) {

        $smbAppId           = trim($arrLoginInfo['appid']);
        $username                   = trim($arrLoginInfo['user_email']);
        $password                   = trim($arrLoginInfo['user_pwd']);
        $rememberMe                 = trim($arrLoginInfo['login_remember_me']);
        $validationStatus           = TRUE;

        if(empty($username) && empty($password)) {
            $arrLogResult['valMessage']             = CUSTOMER_LOGIN_USERNAME_AND_PASSWORD_MISSING;
            $arrLogResult['status']      = FALSE;
        }
        else if(empty($username)) {
            $arrLogResult['valMessage']             = CUSTOMER_LOGIN_USERNAME_MISSING;
            $arrLogResult['status']      = FALSE;
        }
        else if(empty($password)) {
            $arrLogResult['valMessage']             = CUSTOMER_LOGIN_PASSWORD_MISSING;
            $arrLogResult['status']      = FALSE;
        }

        // check the db
        if($validationStatus) {

            if((SAAS  == true) && (DYNAMICDB == true)) {

                // $dbh1               = mysql_connect(USER_DB_HOST, USER_DB_UNAME,USER_DB_PWD);
                // $newDBName           = USER_DB_NAME.$smbAppId;
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
                $resData = "SELECT * FROM apptbl_agents WHERE ( `agent_email` = '".$username."' ) AND `agent_password` = '".md5($password)."'";
                $pdo_query = $dbh1->prepare($resData);
                $pdo_query->execute();

                // $resData = mysql_query("SELECT * FROM apptbl_agents WHERE ( `agent_email` = '".mysql_real_escape_string($username)."' ) AND `agent_password` = '".md5($password)."'",$dbh1);
                if($pdo_query -> rowCount() > 0) {
                    $customer               = new Userobject();
                    // $row=mysql_fetch_assoc($resData);
                    $row  = $resData->fetch(PDO::FETCH_ASSOC);
                    $customer->smb_id       =  $smbAppId;
                    $customer->user_id      = $row['agent_parent'];
                    foreach($row as $key => $value) {
                        $customer->$key = $value;
                    }

                    $customer->agentinfo            =  $row;

                    $objSession                     = new LibSession();
                    $objSession->set('kb_user',serialize($customer));
                    $objSession->set('kb_user',json_encode($customer));
                    $arrLogResult['valMessage']     = 'success';
                    $arrLogResult['status']         = TRUE ;

                    // update the last login
                    $agentid    = $row['agent_id'];
                    $lastlogin  = date("Y-m-d H:i:s");
                    $resData = "UPDATE apptbl_agents SET agent_lastlogin='".$lastlogin."',agent_login_status=1 WHERE agent_id = ".$agentid;
                    $pdo_query = $dbh1->prepare($resData);
                    $pdo_query->execute();
                    // mysql_query("UPDATE apptbl_agents SET agent_lastlogin='".$lastlogin."',agent_login_status=1 WHERE agent_id = ".$agentid."",$dbh1);
                }
                else {
                    $arrLogResult['valMessage']     = INVALID_USER_LOGIN_MSG;
                    $arrLogResult['status']         = FALSE;
                }

            }
            else {

                $db                     =   new db();
                $loginInfo = $db->selectRecord('users','user_id,user_status,user_fname,user_lname,user_email','user_email = "'.Utils::escapeString($username).'"  AND `user_password` = "'.md5($password).'"' );
                if(sizeof($loginInfo) > 0) {        // login success
                    $customer               = new Userobject();
                    $customer->smb_id       =  $loginInfo->user_id;
                    $customer->email       =  $loginInfo->user_email;
                    $customer->first_name       =  $loginInfo->user_fname;
                    $customer->last_name       =  $loginInfo->user_lname;
                    $objSession                     = new LibSession();
                    $objSession->set('kb_user',json_encode($customer));
                    $arrLogResult['valMessage']     = 'success';
                    $arrLogResult['status']         = TRUE ;
                }
                else {          // login failed
                    $arrLogResult['valMessage']     = INVALID_USER_LOGIN_MSG;
                    $arrLogResult['status']         = FALSE;
                }
            }

        }
        return $arrLogResult;
    }




    /*
     * function to generate the activation link
    */
    public static function generateActivationLink($emailAddress) {

        $table                 = 'user';
        $db                    = new Db();
        $tempQuery             =  "
                                   SELECT user_id,user_activation_key
                                   FROM ".MYSQL_TABLE_PREFIX."user
                                   WHERE user_email` ='".mysql_real_escape_string($emailAddress)."' LIMIT 1
                                  ";
        $customerDetails       = $db->selectQuery($tempQuery);
        $customerDetails       = $customerDetails[0];
        if($customerDetails->nCust_Id>0) {
            if(trim($customerDetails->activation_key)=='') {
                $activationkey = Utils::generateResetPasswordActivationKey();
                $db->update(MYSQL_TABLE_PREFIX.$table, array('user_activation_key'=>$activationkey),'user_id="'.mysql_real_escape_string($customerDetails->nCust_Id).'" and vActive="active"');

            }
            else {
                $activationkey = $customerDetails->activation_key;
            }
            $resetPasswordLink = "Click <a href='".BASE_URL."resetpassword/".$activationkey."'> Here</a> to activate your account";
            $replaceParameters =  array(
                    "email"        => trim($emailAddress),
                    "loginLink"    => BASE_URL.'',
                    "passwordLink" => $resetPasswordLink
            );
            if(ENVIRONMENT!='LOCAL')
                Utils::sendUserMail($emailAddress, 'activateAccount', $replaceParameters);
            return 1;

        }
        else {
            return 0;
        }
    }




    /*
     * function to check the user activation link is valid or not
    */
    public static function isValidActivationLink($activationKey) {

        $table                 = 'user';
        $db                    = new Db();
        $activationKey          = trim($activationKey);

        if($activationKey!='') {

            $tempQuery            = "
                                      SELECT `nCust_Id`,`activation_key`,`vActive`
                                      FROM `".MYSQL_TABLE_PREFIX."customers`
                                      WHERE `activation_key` ='".mysql_real_escape_string($activationKey)."'
                                    ";

            $customerDetails      = $db->selectQuery($tempQuery);
            $customerDetails      = $customerDetails[0];

        }



        if($customerDetails->nCust_Id>0) {
            return true;
        }
        else {
            return false;
        }


    }

    /*
     * function to check the user login
    */
    public static function userLoginCheck() {
        $objSession = new LibSession();
        Logger::info(unserialize($objSession->get('user')));
        return $objSession->get('user')? TRUE : FALSE;
    }


    /*
     * function to email subscription
    */
    public static function unsubscribeEmail($subscribe_email){
        if(trim($subscribe_email) == "") return false;

        $db                 = new Db();
        $tableName          = 'newsletter_subscribers';
        $where              = "vEmail = '".Utils::escapeString($subscribe_email)."' ";
        $db->deleteRecord($tableName,$where);
        return true;
    }

    public static function subscribeEmail($subscribe_email){
        $db                 = new Db();
        $tableName          = Utils::setTablePrefix('newsletter_subscribers');
        $vStatus            = "Y";
        $vJoinedOn          = date("Y-m-d H:i:s");
        $vSubscriberId      = $db->insert($tableName,
                                  array(
                                    'vEmail'            =>  Utils::escapeString($subscribe_email),
                                    'vStatus'           =>  Utils::escapeString($vStatus),
                                    'vJoinedOn'         =>  Utils::escapeString($vJoinedOn)
                                  ));
        return $vSubscriberId;
    }

    public static function checkEmailSubscribed($emailAddress){
        $tableName              = trim('newsletter_subscribers');
        $db                     = new db();
        return $db->getDataCount($tableName,'vSubscriberId','WHERE `vEmail` = "'.Utils::escapeString($emailAddress).'"');
    }

    /*
     * function to change the user status
    */

    public static function changeUserStatus($userid,$status) {
        $db                 =   new Db();
        $tableName          =   Utils::setTablePrefix('users');
        $where              =   "user_id = ".Utils::escapeString($userid)." ";
        $ObjResultRow       =   $db->update($tableName, array(  'user_status'   =>  Utils::escapeString($status)),$where);
        return $ObjResultRow;
    }

    /*
     * function to reset the user password
    */

    public static function resetPassword($user_email) {
        $db                 =   new Db();
        $tableName          =   Utils::setTablePrefix('users');

        $query            = "SELECT * FROM ".$tableName." WHERE user_email ='".$user_email."'";

        $userDetails      = $db->selectQuery($query);
        if($userDetails[0]->user_id!='' && $userDetails[0]->user_id>0){
            // $password = rand();
            $password = Utils::generateStrongPassword();
            $where              =   "user_email = '".Utils::escapeString($user_email)."' ";
            $ObjResultRow       =   $db->update($tableName, array(  'user_password' =>  md5($password)),$where);
            $passwordArray['username'] = $userDetails[0]->user_fname.' '.$userDetails[0]->user_lname;
            $passwordArray['newpassword'] = $password;
        }else{
            $passwordArray = '';
        }
        return $passwordArray;

    }


    public static function getSalerepDetails($id)
    {
         $db                 =   new Db();
        $tableName          =   Utils::setTablePrefix('salesrep');

        $query            = "SELECT * FROM ".$tableName." WHERE salesrep_id ='".$id."'";
         $userDetails      = $db->selectQuery($query);
         return $userDetails[0];

    }
public static function changepasswordajax($id, $postAarray,$cms_email) {
        $dbh    =   new Db();
        if(!empty($postAarray)) {
            if($id > 0) {



                $updateQuery = "UPDATE  cms_users set  password ='".md5($postAarray['npassword'])."' WHERE email='$cms_email'";
                $res = $dbh->execute($updateQuery);





                $updateQuery = "UPDATE  tbl_salesrep set  salesrep_password ='".md5($postAarray['npassword'])."' WHERE salesrep_id = '$id'";
                $dbh->execute($updateQuery);



            //    $updateQuery = "UPDATE  tbl_salesrep set  salesrep_password ='".md5($postAarray['newpassword'])."' WHERE salesrep_id=$salesrep_id";
              //  $res = $dbh->execute($updateQuery);


                return $res;
            }
        }

    }


    public static function resetsalesPassword($salesrep_email) {
        $db                 =   new Db();
        $tableName          =   Utils::setTablePrefix('salesrep');

        $query            = "SELECT * FROM ".$tableName." WHERE salesrep_email ='".$salesrep_email."'";

        $userDetails      = $db->selectQuery($query);
        if($userDetails[0]->salesrep_id!='' && $userDetails[0]->salesrep_id>0){
            // $password = rand();
            $password = Utils::generateStrongPassword();
            $where              =   "salesrep_email = '".Utils::escapeString($salesrep_email)."' ";
            $ObjResultRow       =   $db->update($tableName, array(  'salesrep_password' =>  md5($password)),$where);
            $passwordArray['username'] = $userDetails[0]->salesrep_fname.' '.$userDetails[0]->salesrep_lname;
            $passwordArray['newpassword'] = $password;

             $updateQuery = "UPDATE  cms_users set  password ='".md5($password)."' WHERE email='".Utils::escapeString($salesrep_email)."'";
                //echo $updateQuery; exit;
                         $db->execute($updateQuery);


        }else{
            $passwordArray = '';
        }
        return $passwordArray;

    }


    /*
     * function to remove the user
    */

    public static function removeUser($userid) {
        $db                 =   new Db();
        $tableName          =   'users';
        $where              =   "user_id = ".Utils::escapeString($userid)." ";
        $delRes             = $db->deleteRecord($tableName,$where);
        // $ObjResultRow        =   $db->update($tableName, array(  'user_status'   =>  Utils::escapeString($status)),$where);
        return $ObjResultRow;
    }




    /*
     * function to update the admin password
    */
    public static function updateUserPassword($userid, $postValues) {

        $objUserDb = Appdbmanager::getUserConnection();
        $db = new Db($objUserDb);
        $current_pass = $db->selectQuery("SELECT staff_password FROM apptbl_staff WHERE staff_id ='$userid' ");
        if (trim($current_pass[0]->password) == MD5(trim($postValues['current_password']))) {
            if ($postValues['new_password'] == $postValues['retype_password']) {
                $password = $postValues['new_password'];
                $db->customQuery("UPDATE `cms_users` SET `password` = MD5('" . mysql_real_escape_string($password) . "') WHERE `username` = '" . $userName . "'");
                $message = "success";
            } else {
                $message = "New Password and Re-Type Password do not match!";
            }
        } else {
            $message = "Incorrect Current Password!";
        }
        return $message;
    }



    public static function getUserNameFromSmb($smbAccid) {
        $db     = new Db();
        $smbUserInfo= $db->selectRecord("users AS U LEFT JOIN tbl_smb_account AS S ON U.user_id=S.smb_owner_id", "U.user_id,U.user_email,U.user_fname,U.user_lname"," S.smb_acc_id=".$smbAccid);


        return  $smbUserInfo;
    }

    /*
     * function to get user information
    */
    public static function getUserInfo($userid) {
        if($userid) {
            $db                     = new Db();
            $condition              = "user_id='".$userid."'";
            $userDetails           = $db->selectRecord("users", "*", $condition);
            return $userDetails;
        }
    }


     public static function getPromotions(){
        $db                     = new Db();
        $today=date("Y/m/d");
        $condition              = "'$today' BETWEEN pro_startdate and pro_enddate and pro_status='1'";


        $discount          = $db->selectRecord("promotion", "*", $condition);
        //$dis="SELECT * from tbl_promotion WHERE '$today'  BETWEEN pro_startdate and pro_enddate and pro_status='1'";
       // $discount=$db->selectQuery($dis);
        //echopre1($discount);
       return $discount;

    }

}


class Userobject {
    public $id;
    public $email;
    public $first_name;
    public $last_name;
    public $photos;
}


?>
