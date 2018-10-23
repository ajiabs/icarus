<?php 

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : cls_mailer.php                                                   |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems                                      |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

class Mailer{
    
    public $siteName;
    public $siteLogo;
    public $siteDate;
    public $siteCopyRight;
    public $mailSignature;
     
    
    
    public function  __construct() {
        
        // common parameters
        $this->siteName         = SITENAME;
        $this->siteLogo         ='<img src="'. BASE_URL.'project/themes/default/images/saasframework_logo.png">';
        $this->siteCopyRight    = '&copy; '.$this->siteName.' 2013 All rights reserved';
        $this->siteDate         = date("F j, Y, g:i a");
        $this->mailSignature    = '<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333333">Thank You,<br>
The '.$this->siteName.' Team | '.BASE_URL.'</p>';
        
    }
    public static function getSiteLogogetSiteLogoMail() {
//      return  BASE_URL.'project/themes/default/images/saasframework_logo.png';
        $dbh = new Db();
        $logoDetails= $dbh->selectRecord("lookup", "vLookUp_Value"," vLookUp_Name='sitelogo'");
        $siteLogo =  BASE_URL.'project/files/'.$logoDetails->vLookUp_Value;
        if($logoDetails->vLookUp_Value == '' && (!file_exists('project/files/'.$logoDetails->vLookUp_Value))){
                    $logoDetails= $dbh->selectRecord("cms_settings", "cms_set_value"," cms_set_name='admin_logo'");
                    $siteLogo =  BASE_URL.$logoDetails->cms_set_value;
        } 
        return $siteLogo;
    } // End Function
    
    /*
     * function to send mail
     */
    public function sendMail($mailIds,$template,$replaceparams) {
        PageContext::includePath('phpmailer');
        $db                = new Db();
        
        // get the mail template
        $mailTemplate      = $db->selectRecord("mail_template", "*", "mail_template_name='".$template."' AND mail_template_status=1");
     
        $replaceparams['SIGNATURE']         = $this->mailSignature;
        $replaceparams['CURRENCY']          = DEFAULT_CURRENCY;
        
        if(sizeof($replaceparams) > 0) {
            foreach($replaceparams as $key=>$parms) {
                $mailTemplate->mail_template_body   = str_replace('{'.$key.'}',$parms, $mailTemplate->mail_template_body);
                $mailTemplate->mail_template_sub    = str_replace('{'.$key.'}',$parms, $mailTemplate->mail_template_sub);
            }
        }
        
        $emailBody              = $this->prepareMail($mailTemplate->mail_template_body);  
         
        $adfromemail            = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressfromemail'");
        $adfromemailname        = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressfromemailname'");
        $adreplyemail           = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressreplyemail'");
        $adreplyemailname       = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressreplyemailname'");
          
        $mailBody               = $emailBody;
        
        if($replaceparams['SHOW_MAIL'] == 1)
            echopre($emailBody);
        
        
        $mailSubject            = str_replace('{SITE_NAME}', $this->siteName, $mailTemplate->mail_template_sub);
       
       
       
        $mail                   = new PHPMailer();
        $mail->AddReplyTo($adreplyemail,$adreplyemailname);
        $mail->SetFrom($adfromemail, $adfromemailname);
       
        foreach($mailIds as $key=>$name)
            $mail->AddAddress($key, $name);
        $mail->Subject              = $mailSubject;
        $mail->AltBody              = ''; // Optional, comment out and test.
        $mail->MsgHTML($mailBody);
        if(ENVIRONMENT != 'LOCAL')
                $mailsent           = $mail->Send();
        return true;
         
         
    }
    
      public function resetPasswordMail($mailIds,$template,$replaceparams,$files=array()) {
        PageContext::includePath('phpmailer');
        $db                = new Db();
         $mail                  = new PHPMailer();
        //print_r($mailIds);
        // get the mail template
        $arrMailInfo= array();
               $smtp            = $db->selectRow("lookup_cms","value","settingfield='EnableSMTP'");
        $host       = $db->selectRow("lookup_cms","value","settingfield='SMTPHost'");
        $username           = $db->selectRow("lookup_cms","value","settingfield='SMTPUsername'");
        $password       = $db->selectRow("lookup_cms","value","settingfield='SMTPPassword'");
         $port      = $db->selectRow("lookup_cms","value","settingfield='SMTPPort'");
         $enabled       = $db->selectRow("lookup_cms","value","settingfield='SSLEnabled'");
          $this->siteName       = $db->selectRow("lookup_cms","value","settingfield='sitename'");
          $admin_email      = $db->selectRow("lookup_cms","value","settingfield='admin_email'");
          $addressfromemailname = $db->selectRow("lookup_cms","value","settingfield='addressfromemailname'");
          
         
        //echo $host;
        if($smtp) {
            $mail->IsSMTP();
            $mail->Host       =$host;       // SMTP server example
            $mail->SMTPDebug  = 1;      // enables SMTP debug information (for testing)
            $mail->SMTPAuth   = true;                       // enable SMTP authentication
            $mail->Port       = $port;       // set the SMTP port for the GMAIL server
            $mail->Username   = $username;  // SMTP account username example
            $mail->Password   = $password;   // SMTP account password example
            $mail->SMTPSecure = ($enabled)?'ssl':'';
        }
        
        
        
        
        
        
        $mailTemplate      = $db->selectRecord("mail_template", "*", "mail_template_name='".$template."' AND mail_template_status=1");
     
        $replaceparams['SIGNATURE']         = $this->mailSignature;
        $replaceparams['CURRENCY']          = DEFAULT_CURRENCY;
        
        if(sizeof($replaceparams) > 0) {
            foreach($replaceparams as $key=>$parms) {
                $mailTemplate->mail_template_body   = str_replace('{'.$key.'}',$parms, $mailTemplate->mail_template_body);
                //$mailTemplate->mail_template_sub  = str_replace('{'.$key.'}',$parms, $mailTemplate->mail_template_sub);
            }
        }
        
        $emailBody              = self::prepareMail($mailTemplate->mail_template_body);  
         
//        $adfromemail              = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressfromemail'");
//        $adfromemailname          = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressfromemailname'");
//        $adreplyemail             = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressreplyemail'");
//        $adreplyemailname         = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressreplyemailname'");
          
        $mailBody               = $emailBody;
        
        if($replaceparams['SHOW_MAIL'] == 1)
            echopre($emailBody);
        
        
        $mailSubject            = str_replace('{SITE_NAME}', $this->siteName, $mailTemplate->mail_template_sub);
       
       
              // echopre($username);
       
        $mail->AddReplyTo($admin_email,$addressfromemailname);
        $mail->SetFrom($admin_email, $addressfromemailname);
       
        foreach($mailIds as $key=>$name)
            $mail->AddAddress($name, $key);
        $mail->Subject              = $mailSubject;
        $mail->AltBody              = ''; // Optional, comment out and test.
        $mail->MsgHTML($mailBody);
        //echo $mailBody;
        if ($files) {
            foreach ($files as $v) {

                $filerow = $db->selectRecord("files", "*", "file_id='$v'");
                if ($filerow) {

                    $path = ConfigPath::base() . 'project/files/' . $filerow->file_path;
                    $name = $filerow->file_orig_name;

                    $mail->AddAttachment($path, $name);
                }
            }
        }
       
    
                $mailsent           = $mail->Send();
                
             //  print_r($mailsent); exit;
              
        return true;
         
         
    }
    
    
    
    
    
    
    
    
    
   public function sendUserRegistrationMail($mailIds,$template,$replaceparams,$files=array()) {
        PageContext::includePath('phpmailer');
        $db                = new Db();
         $mail                  = new PHPMailer();
        //print_r($mailIds);
        // get the mail template
        $arrMailInfo= array();
               $smtp            = $db->selectRow("lookup_cms","value","settingfield='EnableSMTP'");
        $host       = $db->selectRow("lookup_cms","value","settingfield='SMTPHost'");
        $username           = $db->selectRow("lookup_cms","value","settingfield='SMTPUsername'");
        $password       = $db->selectRow("lookup_cms","value","settingfield='SMTPPassword'");
         $port      = $db->selectRow("lookup_cms","value","settingfield='SMTPPort'");
         $enabled       = $db->selectRow("lookup_cms","value","settingfield='SSLEnabled'");
          $this->siteName       = $db->selectRow("lookup_cms","value","settingfield='sitename'");
          $admin_email      = $db->selectRow("lookup_cms","value","settingfield='admin_email'");
          $addressfromemailname = $db->selectRow("lookup_cms","value","settingfield='addressfromemailname'");
          
         
        //echo $host;
        if($smtp) {
            $mail->IsSMTP();
            $mail->Host       =$host;       // SMTP server example
            $mail->SMTPDebug  = 1;      // enables SMTP debug information (for testing)
            $mail->SMTPAuth   = true;                       // enable SMTP authentication
            $mail->Port       = $port;       // set the SMTP port for the GMAIL server
            $mail->Username   = $username;  // SMTP account username example
            $mail->Password   = $password;   // SMTP account password example
            $mail->SMTPSecure = ($enabled)?'ssl':'';
        }
        
        
        
        
        
        
        $mailTemplate      = $db->selectRecord("mail_template", "*", "mail_template_name='".$template."' AND mail_template_status=1");
     
        $replaceparams['SIGNATURE']         = $this->mailSignature;
        $replaceparams['CURRENCY']          = DEFAULT_CURRENCY;
        
        if(sizeof($replaceparams) > 0) {
            foreach($replaceparams as $key=>$parms) {
                $mailTemplate->mail_template_body   = str_replace('{'.$key.'}',$parms, $mailTemplate->mail_template_body);
                //$mailTemplate->mail_template_sub  = str_replace('{'.$key.'}',$parms, $mailTemplate->mail_template_sub);
            }
        }
        
        $emailBody              = self::prepareMail($mailTemplate->mail_template_body);  
         
//        $adfromemail              = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressfromemail'");
//        $adfromemailname          = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressfromemailname'");
//        $adreplyemail             = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressreplyemail'");
//        $adreplyemailname         = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressreplyemailname'");
          
        $mailBody               = $emailBody;
        
        if($replaceparams['SHOW_MAIL'] == 1)
            echopre($emailBody);
        
        
        $mailSubject            = str_replace('{SITE_NAME}', $this->siteName, $mailTemplate->mail_template_sub);
       
       
              // echopre($username);
       
        $mail->AddReplyTo($admin_email,$addressfromemailname);
        $mail->SetFrom($admin_email, $addressfromemailname);
       
        foreach($mailIds as $key=>$name)
            $mail->AddAddress($name, '');
        $mail->Subject              = $mailSubject;
        $mail->AltBody              = ''; // Optional, comment out and test.
        $mail->MsgHTML($mailBody);
        //echo $mailBody;
        if ($files) {
            foreach ($files as $v) {

                $filerow = $db->selectRecord("files", "*", "file_id='$v'");
                if ($filerow) {

                    $path = ConfigPath::base() . 'project/files/' . $filerow->file_path;
                    $name = $filerow->file_orig_name;

                    $mail->AddAttachment($path, $name);
                }
            }
        }
       
    
                $mailsent           = $mail->Send();
                
             //  print_r($mailsent); exit;
              
        return true;
         
         
    }
   
    
    public static function getSiteSettings()
    {
        $db                = new Db();
        $data           = $db->selectResult("lookup_cms","*");
      //  echopre($data);
        $array = array();
        foreach ($data as $k=>$v)
        {
            $array[$v->settingfield] = $v->value;
        }
        return $array;
    }
    
    
    
    public function sendUserOrderMail($mailIds,$template,$replaceparams,$files=array()) {
        PageContext::includePath('phpmailer');
        $db                = new Db();
         $mail                  = new PHPMailer();
        //print_r($mailIds);
        // get the mail template
        $arrMailInfo= array();
               $smtp            = $db->selectRow("lookup_cms","value","settingfield='EnableSMTP'");
        $host       = $db->selectRow("lookup_cms","value","settingfield='SMTPHost'");
        $username           = $db->selectRow("lookup_cms","value","settingfield='SMTPUsername'");
        $password       = $db->selectRow("lookup_cms","value","settingfield='SMTPPassword'");
         $port      = $db->selectRow("lookup_cms","value","settingfield='SMTPPort'");
         $enabled       = $db->selectRow("lookup_cms","value","settingfield='SSLEnabled'");
          $this->siteName       = $db->selectRow("lookup_cms","value","settingfield='sitename'");
          $admin_email      = $db->selectRow("lookup_cms","value","settingfield='admin_email'");
          $addressfromemailname = $db->selectRow("lookup_cms","value","settingfield='addressfromemailname'");
          
         
        //echo $host;
        if($smtp) {
            $mail->IsSMTP();
            $mail->Host       =$host;       // SMTP server example
            $mail->SMTPDebug  = 1;      // enables SMTP debug information (for testing)
            $mail->SMTPAuth   = true;                       // enable SMTP authentication
            $mail->Port       = $port;       // set the SMTP port for the GMAIL server
            $mail->Username   = $username;  // SMTP account username example
            $mail->Password   = $password;   // SMTP account password example
            $mail->SMTPSecure = ($enabled)?'ssl':'';
        }
        
        
        $order_id = $replaceparams['ORDER_NUMBER'];
       
        $query = "SELECT tbl_order_details.od_id,tbl_order_details.order_id , external3.plan_name AS plan_id, external4.school_name AS school_id, external5.slot_name AS slot_id,tbl_order_details.campaign_start_date,tbl_order_details.campaign_end_date,tbl_order_details.od_item_amount,tbl_order_details.od_share_voice,tbl_order_details.od_created_on,tbl_order_details.plan_period,tbl_order_details.odd_status FROM tbl_order_details 
            LEFT JOIN tbl_plans AS external3 ON external3.plan_id=tbl_order_details.plan_id 
            LEFT JOIN tbl_school AS external4 ON external4.school_id=tbl_order_details.school_id 
            LEFT JOIN tbl_slot AS external5 ON external5.slot_id=tbl_order_details.slot_id 
            JOIN tbl_orders AS reference ON tbl_order_details.order_id=reference.order_id WHERE 1
            AND tbl_order_details.order_id='$order_id' AND tbl_order_details.odd_status != '2'";
      //  echo $query;
        
        $order_details = $db->selectQuery($query);
        
        
     //   echopre1($order_details);
        
        





        
        
        $mailTemplate      = $db->selectRecord("mail_template", "*", "mail_template_name='".$template."' AND mail_template_status=1");
     
        $replaceparams['SIGNATURE']         = $this->mailSignature;
        $replaceparams['CURRENCY']          = DEFAULT_CURRENCY;
        
        $html_content = $mailTemplate->mail_template_body;
        
        preg_match('/<!--row_statrt-->(.*?)<!--row_end-->/s', $html_content, $matches);

//HTML array in $matches[1]
       // echopre1($matches);

        $row1 = $matches[1];
     //  echopre($order_details);
     //echopre1($matches);
        
        $html = '';
        $total = 0;
       foreach ($order_details as $k=>$v)
       {
           
            $row = $row1;
            $row= str_replace('{SLOT_NAME}', $v->slot_id, $row);
            $row = str_replace('{CAMPAIGN_START}', $v->campaign_start_date, $row);
            $row = str_replace('{CAMPAIGN_END}', $v->campaign_end_date, $row);
            $row = str_replace('{PLAN}', $v->plan_id, $row);
            $row = str_replace('{SCHOOL}', $v->school_id, $row);
            $row = str_replace('{DURATION}', $v->plan_period, $row);
            $row = str_replace('{SHARE}', $v->od_share_voice, $row);
            $row = str_replace('{AMOUNT}', $v->od_item_amount, $row);
            $row = str_replace('{ORDER_ID}', base64_encode($v->order_id), $row);
            $row = str_replace('{OD_ID}', base64_encode($v->od_id), $row);
            $row = str_replace('{BASE_URL}', BASE_URL, $row);
            $total+=$v->od_item_amount;
            $html.=$row;
       }
      //  echo $html; exit;
       
       
      //$html_content =  str_replace('{TOTAL}', $total, $html_content);
        
     
        
       
 $html_content = preg_replace('/<!--row_statrt-->(.*?)<!--row_end-->/s', $html,$html_content);
 
 
 
       
        if(sizeof($replaceparams) > 0) {
            foreach($replaceparams as $key=>$parms) {
                $html_content   = str_replace('{'.$key.'}',$parms, $html_content);
                //$mailTemplate->mail_template_sub  = str_replace('{'.$key.'}',$parms, $mailTemplate->mail_template_sub);
            }
        }
  // echo $html_content; exit; 
         
         
        $emailBody              = self::prepareMail($html_content);  
         
//        $adfromemail              = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressfromemail'");
//        $adfromemailname          = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressfromemailname'");
//        $adreplyemail             = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressreplyemail'");
//        $adreplyemailname         = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressreplyemailname'");
          
        $mailBody               = $emailBody;
                
               // echo $mailBody; exit;
                
        //echopre1($mailBody); exit;
        if($replaceparams['SHOW_MAIL'] == 1)
            echopre($emailBody);
        
        
        $mailSubject            = str_replace('{SITE_NAME}', $this->siteName, $mailTemplate->mail_template_sub);
        if(sizeof($replaceparams) > 0) {
            foreach($replaceparams as $key=>$parms) {
                $mailSubject    = str_replace('{'.$key.'}',$parms, $mailSubject);
                //$mailTemplate->mail_template_sub  = str_replace('{'.$key.'}',$parms, $mailTemplate->mail_template_sub);
            }
        }
       
              // echopre($username);
       
        $mail->AddReplyTo($admin_email,$addressfromemailname);
        $mail->SetFrom($admin_email, $addressfromemailname);
       
        foreach($mailIds as $key=>$name)
            $mail->AddAddress($name, '');
        $mail->Subject              = $mailSubject;
        $mail->AltBody              = ''; // Optional, comment out and test.
        $mail->MsgHTML($mailBody);
        //echo $mailBody;
        if ($files) {
            foreach ($files as $v) {

                $filerow = $db->selectRecord("files", "*", "file_id='$v'");
                if ($filerow) {

                    $path = ConfigPath::base() . 'project/files/' . $filerow->file_path;
                    $name = $filerow->file_orig_name;

                    $mail->AddAttachment($path, $name);
                }
            }
        }
       
    
                $mailsent           = $mail->Send();
                
           //   print_r($mailsent); exit;
              
        return true;
         
         
    }  
    
    
    public function sendUserRegistrationAdminMail($mailIds,$template,$replaceparams,$files=array()) {
        PageContext::includePath('phpmailer');
        $db                = new Db();
         $mail                  = new PHPMailer();
        //print_r($mailIds);
        // get the mail template
        $arrMailInfo= array();
               $smtp            = $db->selectRow("lookup_cms","value","settingfield='EnableSMTP'");
        $host       = $db->selectRow("lookup_cms","value","settingfield='SMTPHost'");
        $username           = $db->selectRow("lookup_cms","value","settingfield='SMTPUsername'");
        $password       = $db->selectRow("lookup_cms","value","settingfield='SMTPPassword'");
         $port      = $db->selectRow("lookup_cms","value","settingfield='SMTPPort'");
         $enabled       = $db->selectRow("lookup_cms","value","settingfield='SSLEnabled'");
          $this->siteName       = $db->selectRow("lookup_cms","value","settingfield='sitename'");
          $admin_email      = $db->selectRow("lookup_cms","value","settingfield='admin_email'");
          $addressfromemailname = $db->selectRow("lookup_cms","value","settingfield='addressfromemailname'");
          
         
        //echo $host;
        if($smtp) {
            $mail->IsSMTP();
            $mail->Host       =$host;       // SMTP server example
            $mail->SMTPDebug  = 1;      // enables SMTP debug information (for testing)
            $mail->SMTPAuth   = true;                       // enable SMTP authentication
            $mail->Port       = $port;       // set the SMTP port for the GMAIL server
            $mail->Username   = $username;  // SMTP account username example
            $mail->Password   = $password;   // SMTP account password example
            $mail->SMTPSecure = ($enabled)?'ssl':'';
        }
        
        
        
        
        
        
        $mailTemplate      = $db->selectRecord("mail_template", "*", "mail_template_name='".$template."' AND mail_template_status=1");
     
        $replaceparams['SIGNATURE']         = $this->mailSignature;
        $replaceparams['CURRENCY']          = DEFAULT_CURRENCY;
        
        if(sizeof($replaceparams) > 0) {
            foreach($replaceparams as $key=>$parms) {
                $mailTemplate->mail_template_body   = str_replace('{'.$key.'}',$parms, $mailTemplate->mail_template_body);
                //$mailTemplate->mail_template_sub  = str_replace('{'.$key.'}',$parms, $mailTemplate->mail_template_sub);
            }
        }
        
        $emailBody              = self::prepareMail($mailTemplate->mail_template_body);  
         
//        $adfromemail              = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressfromemail'");
//        $adfromemailname          = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressfromemailname'");
//        $adreplyemail             = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressreplyemail'");
//        $adreplyemailname         = $db->selectRow("lookup","vLookUp_Value","vLookUp_Name='addressreplyemailname'");
          
        $mailBody               = $emailBody;
        
        if($replaceparams['SHOW_MAIL'] == 1)
            echopre($emailBody);
        
        
            $mailSubject            = str_replace('{SITE_NAME}', $this->siteName, $mailTemplate->mail_template_sub);
        
        if(isset($replaceparams['SUBJECT'])){
            $mailSubject            = str_replace('{SUBJECT}', $replaceparams['SUBJECT'],   $mailSubject );
        }
      //    $mailSubject            = str_replace('{SUBJECT}', $this->siteName, $mailTemplate->mail_template_sub);
         
              // echopre($username);
       
        $mail->AddReplyTo($admin_email,$addressfromemailname);
        $mail->SetFrom($admin_email, $addressfromemailname);
        if(empty($mailIds))
        $mailIds[] = $admin_email;
        
       
        foreach($mailIds as $key=>$name)
            $mail->AddAddress($name, '');
        $mail->Subject              = $mailSubject;
        $mail->AltBody              = ''; // Optional, comment out and test.
        $mail->MsgHTML($mailBody);
        //echo $mailBody;
        if ($files) {
            foreach ($files as $v) {

                $filerow = $db->selectRecord("files", "*", "file_id='$v'");
                if ($filerow) {

                    $path = ConfigPath::base() . 'project/files/' . $filerow->file_path;
                    $name = $filerow->file_orig_name;

                    $mail->AddAttachment($path, $name);
                }
            }
        }
       
    
                $mailsent           = $mail->Send();
                
             //  print_r($mailsent); exit;
              
        return true;
         
         
    } 
    /*
     * function to add the mail template with mail body
     */
    public function prepareMail($mailBody) {
        $db                     = new Db();
        // get the mail body
        $mailContainer          = $db->selectRecord("mail_template", "*", "mail_template_name='mailcontainer' AND mail_template_status=1");
        $arrTSearch             = array("{SITE_LOGO}", "{COPYRIGHT}", "{DATE}");
                 $this->siteLogo = "<img src = '".self::getSiteLogogetSiteLogoMail()."'/>";
               $this->siteDate      = date("F j, Y, g:i a");
        $this->siteName         = SITENAME;
        
        $this->siteCopyRight    = '&copy; '.$this->siteName.' 2013 All rights reserved';
                
                
        $arrTReplace            = array($this->siteLogo ,$this->siteCopyRight, $this->siteDate  );  
       //  echopre1($mailContainer->mail_template_body);
        
                
        foreach($arrTSearch as $tempkey =>$tempValue) {
            $mailContainer->mail_template_body = str_replace($tempValue, $arrTReplace[$tempkey], $mailContainer->mail_template_body);
        }
        
        
      
        
        $emailBody              = str_replace('{MAIL_BODY}', $mailBody, $mailContainer->mail_template_body);
        
        // echo $emailBody; exit;
        return $emailBody;
    }
    
    
    
    
    
    
    /*
     * function to send user emails
     */
    public static function sendusermail($arrMailInfo,$emailIds){

        // send mail using smtp
        PageContext::includePath('phpmailer');
        $mail                   = new PHPMailer();
        if($arrMailInfo['smtp']) {
            $mail->IsSMTP();
            $mail->Host       = $arrMailInfo['host'];       // SMTP server example
            $mail->SMTPDebug  = $arrMailInfo['debug'];      // enables SMTP debug information (for testing)
            $mail->SMTPAuth   = true;                       // enable SMTP authentication
            $mail->Port       = $arrMailInfo['port'];       // set the SMTP port for the GMAIL server
            $mail->Username   = $arrMailInfo['username'];   // SMTP account username example
            $mail->Password   = $arrMailInfo['password'];   // SMTP account password example
            $mail->SMTPSecure = 'ssl';
        }


        $mail->AddReplyTo($arrMailInfo['replymail'],$arrMailInfo['replyname']);
        $mail->SetFrom($arrMailInfo['replymail'], $arrMailInfo['replyname']);
        foreach($emailIds as $emailid) {
        //$mail->AddAddress($arrMailInfo['mailto'], $arrMailInfo['mailtoname']);
         $mail->AddAddress($emailid, '');
        }
        $mail->Subject              = $arrMailInfo['mailsubject'];
        $mail->AltBody              = ''; // Optional, comment out and test.
        $mail->MsgHTML($arrMailInfo['mailbody']);
        if(ENVIRONMENT != 'LOCAL')
                $mailsent           = $mail->Send();
        return true;
    }
    
    
    
    
        
}


?>