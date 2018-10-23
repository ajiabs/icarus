<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | This page is for user section management. Login checking , new user registration, user listing etc.                                      |
// | File name : index.php                                                  |
// | PHP version >= 5.2                                                   |
// | Created On :   Nov 17 2011                                               |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems ? 2010                                      |
// | All rights reserved                                                  |
// +------------------------------------------------------

class ControllerIndex extends BaseController {
    /*
   * construction function. we can initialize the models here
    */
    public function init(){
        parent::init();

        PageContext::addStyle("bootstrap.css");
        PageContext::addStyle("bootstrap.min.css");

        PageContext::$response->BASE_URL    = BASE_URL;
        PageContext::$response->currentUrl  = $currentUrl  = ROOT_URL.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        //PageContext::$response->currentPage = str_replace(BASE_URL."index", "", $currentUrl);
        PageContext::$response->bottomMenuItems       = Managecmsdata::getMenuItems(2,2);
        //echopre(PageContext::$response->bottomMenuItems);

        $settingsName                                 = "footer_links_enabled";
        PageContext::$response->footer_links_enabled  = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                 = "social_media_enabled";
        PageContext::$response->social_media_enabled  = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                 = "site_address";
        PageContext::$response->site_address          = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                 = "site_phone";
        PageContext::$response->site_phone            = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                 = "site_email";
        PageContext::$response->site_email            = Cmshelper::getSettingsValueByName($settingsName);

        $settingsName                                 = "facebook_url";
        PageContext::$response->facebook_url          = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                 = "twitter_url";
        PageContext::$response->twitter_url           = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                 = "instagram_url";
        PageContext::$response->instagram_url         = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                 = "googleplus_url";
        PageContext::$response->googleplus_url        = Cmshelper::getSettingsValueByName($settingsName);
        //echopre(PageContext::$response->bottomMenu);

        PageContext::$response->cmsSettings    = Cmshelper::getCmsDataSettings();
        PageContext::$response->site_copyright = PageContext::$response->cmsSettings['admin_copyright'];

        // Set the page panels
        PageContext::registerPostAction("header", "homepageheader","index","default");
        PageContext::registerPostAction("footer", "footerpanel","index","default");

        //  PageContext::$response = new stdClass();
        //PageContext::$response->loginUserName = Utils::getLoginUserName();

        $objSession           = new LibSession();
        //PageContext::$response->userdetails = json_decode($objSession->get('kb_user'),TRUE);
        PageContext::addJsVar('siteUrl', BASE_URL);

        //echopre1(PageContext::$response->userdetails);
        //PageContext::$response->cartobjects = json_decode($objSession->get('cart'),TRUE);
        // echopre(PageContext::$response->cartobjects);
    }
    /*
    function to load the index template
    */
    public function index(){
        if(empty($alias)){
            $alias ="home";
        }
        PageContext::$response->topMenu = Managecmsview::renderMenu(1, 2,"index");
        //PageContext::registerPostAction("header", "homepageheader","index","default");
        //PageContext::registerPostAction("header", "topmenu","index","default");
        PageContext::registerPostAction("center-main","index","index","default");


        PageContext::$response->activeMenu  = $alias;
        $metaData                           = Cmshelper::getMetaData($alias);
        PageContext::$metaTitle             = $metaData[0]->title;
        PageContext::$metaDes               = $metaData[0]->description;
        PageContext::$metaKey               = $metaData[0]->keywords;

        //$alias                                   = "homepage_text";  //Company overview CMS content
        //PageContext::$response->company_overview = Cmshelper::getStaticContent($alias);
        PageContext::$response->static_contents  = Managecmsdata::getContentDataFromAlias();
        PageContext::$response->sliding_banners  = Cmshelper::getBanners();
        PageContext::$response->testimonials     = Cmshelper::getAllActiveTestimonials();

        //echopre(PageContext::$response->static_contents);

        $settingsName                                     = "homepage_slider_enabled";
        PageContext::$response->homepage_slider_enabled   = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                     = "testimonial_enabled";
        PageContext::$response->testimonial_enabled       = Cmshelper::getSettingsValueByName($settingsName);

        PageContext::$response->random_homepage_sections  = Managecmsdata::getHomePageRandomSections();
        //echopre(PageContext::$response->random_homepage_sections);

        PageContext::$response->slider_homepage_sections  = Managecmsdata::getHomePageSliderSections();
        //echopre(PageContext::$response->slider_homepage_sections);

        $settingsName                                     = "banner_button1_label";
        PageContext::$response->banner_button1_label      = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                     = "banner_button1_alias";
        PageContext::$response->banner_button1_alias      = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                     = "banner_button2_label";
        PageContext::$response->banner_button2_label      = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                     = "banner_button2_alias";
        PageContext::$response->banner_button2_alias      = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                     = "banner_button3_label";
        PageContext::$response->banner_button3_label      = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                     = "banner_button3_alias";
        PageContext::$response->banner_button3_alias      = Cmshelper::getSettingsValueByName($settingsName);
    }

    public static function getLoginSessionType($module=""){
        $session    = new LibSession();
        $sessionPrefix = "";
        if($module =="")
            $module = $session->get("module");
        if($module=="user")
            $sessionPrefix = "UM_";
        return $sessionPrefix;
    }

    public function contact(){
        $session        = new LibSession();
        $sessionPrefix  = self::getLoginSessionType($res->module);

        $alias                              = "contact";
        PageContext::$response->content     = Cmshelper::getStaticContent($alias);
        PageContext::$response->activeMenu  = $alias;
        $metaData                           = Cmshelper::getMetaData($alias);
        PageContext::$metaTitle             = $metaData[0]->title;
        PageContext::$metaDes               = $metaData[0]->description;
        PageContext::$metaKey               = $metaData[0]->keywords;

        PageContext::$response->countries   = Cmshelper::getAllCountries();

        PageContext::$response->activeMenu  = $alias;
        PageContext::$response->content     = Managecmsview::renderPageFromUrl($alias, true);
        PageContext::$response->topMenu     = Managecmsview::renderMenu(1, 2,$alias);
        PageContext::registerPostAction("header", "topmenu","index","default");
        PageContext::registerPostAction("center-main","contact","index","default");

        $settingsName                                 = "contact_last_name";
        PageContext::$response->contact_last_name     = Cmshelper::getSettingsValueByName($settingsName);

        $settingsName                                 = "contact_address";
        PageContext::$response->contact_address       = Cmshelper::getSettingsValueByName($settingsName);

        $settingsName                                 = "contact_phone_number";
        PageContext::$response->contact_phone_number  = Cmshelper::getSettingsValueByName($settingsName);

        $settingsName                                 = "contact_city";
        PageContext::$response->contact_city          = Cmshelper::getSettingsValueByName($settingsName);

        $settingsName                                 = "contact_country";
        PageContext::$response->contact_country       = Cmshelper::getSettingsValueByName($settingsName);

        if(trim($session->get($sessionPrefix."success_message")) <> ""){
            PageContext::$response->message = $session->get($sessionPrefix."success_message");
            $session->delete($sessionPrefix."success_message");
        }
        if(trim($session->get($sessionPrefix."error_message")) <> ""){
            PageContext::$response->message = $session->get($sessionPrefix."error_message");
            $session->delete($sessionPrefix."error_message");
        }

      //  echopre($_POST);
        if($_POST['btnSubmit']){
            //$recaptcha = $_POST['g-recaptcha-response'];
            //if(!empty($recaptcha)){
                /*include(LIB_DIR.'/getCurlData.php');
                $google_url="https://www.google.com/recaptcha/api/siteverify";
                $secret='6LfHBA8UAAAAANfLkIlpSfAF_pg4BCMAfckR0YSw';
                //$secret='6LfWwBkTAAAAAC57JsT2TRm9PN7ZqvMhFUfg6_r_';
                $ip=$_SERVER['REMOTE_ADDR'];
                $url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
                $res=getCurlData($url);
                $res= json_decode($res, true);
                print_r($res);exit;
                if($res['success'])
                {*/
                $obj = Cmshelper::createObjectFromPost($_POST,array('btnGo'));
                //echopre($reumeFileDetails);
                // echopre($_POST);
                //$objResult = Cmshelper::insertCallBack($obj);
                // echopre($objResult);
                if(isset($_POST['btnSubmit'])){
                    $data = $obj; //echopre($data);
                    PageContext::$response->message = 'Your message has been sent to administrator. Thank you for contacting us.';
                    $paramas              = array();
                    $paramas['NAME']      = $data->firstName." ".$data->lastName;
                    $paramas['PHONE']     = $data->phone;
                    $paramas['EMAIL']     = $data->emailId;
                    $paramas['COMMENTS']  = $data->message;

                    $feedback_id = Cmshelper::saveFeedback($data);
                    if($feedback_id){
                        $message  = '<div class="success_div">We have received your message, we will contact you soon.</div><div class="clear">&nbsp;</div>';
                        $session->set($sessionPrefix."success_message",$message);
                    }else{
                        $message  = '<div class="error_div">Some error occurred, Please try again later!</div>';
                        $session->set($sessionPrefix."error_message",$message);
                    }
                    //Lead hubspot lead capture
                    //$hubspotLeadCapture = Cmshelper::createHubspotLead($_POST);
                    //$mailSend           = Mailer::sendCallbackMail($emailIds,'contact',$paramas);
                    $mailSend = 1;
                    if($mailSend){
                        /************************ SEND EMAIL TO USER  **********************/
                        PageContext::includePath('phpmailer');
                        $from_name        = SITE_NAME;
                        $user_email       = array($data->emailId);
                        $settingsName     = "admin_email";
                        $admin_email      = Cmshelper::getSettingsValueByName($settingsName);
                        $settingsName     = "addressreplyemail";
                        $reply_email      = Cmshelper::getSettingsValueByName($settingsName);

                        $reply_name       = 'Auto-Responder';
                        $subject          = 'Thank you for contacting us - '.SITE_NAME;
                        if(trim($data->firstName) <> ""){
                            $user_name = trim($data->firstName)." ".trim($data->lastName);
                        }else{
                            $user_name = "User";
                        }
                        $body    = '<table width="100%" cellspacing="0" cellpadding="0" border="0">';
                        $body   .= '<tr><td style="font-family: arial, sans-serif; margin: 0px;font-size:12px;">Dear '.$user_name.',</td></tr>';
                        $body   .= '<tr><td style="font-family: arial, sans-serif; margin: 0px;font-size:12px;">Thank you for contacting us. Our sales team will get back to you soon over the phone !!!.</td></tr>';
                        $body   .= '<tr><td style="font-family: arial, sans-serif; margin: 0px;font-size:12px;">&nbsp;</td></tr>';
                        $body   .= '<tr><td><p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333333">Regards,<br>
                        Team '.SITE_NAME.'</p></td></tr>';
                        //$mailSent     = Mailer::sendusermail($arrMailInfo,$confirmEmailIds);

                				$mail             = new PHPMailer();
                				$mail->IsSMTP();
                				$mail->Host       = SMTPSERVER;
                        $mail->SMTPAuth   = true;
                        $mail->Port       = SMTPPORT;
                        $mail->Username   = SMTPUSERNAME;
                        $mail->Password   = SMTPPASSWORD;

                				$mail->SMTPSecure = 'ssl';
                				//$mail->AddReplyTo($reply_email,$from_name);
                				$mail->SetFrom($admin_email,$from_name);
                				if($mail->validateAddress($data->emailId)){
                						$mail->AddAddress($data->emailId, $user_name);
                				}
                				$mail->Subject     = $subject;
                				$mail->AltBody     = ''; // Optional, comment out and test.
                				$mail->MsgHTML($body);
                				$mail->Send();
                        /************************ SEND EMAIL TO USER  **********************/

                        /************************ SEND EMAIL TO ADMINISTRATOR  **********************/
                				$subject			= "Notification for new feedback - ".SITE_NAME;
                				$emailBody 		= '<table border="0" cellpadding="1" cellspacing="1" class="maintext2" style="width:100%">
                													<tbody>
                														<tr>
                															<td colspan="2">
                																	<p>Dear Administrator,</p>
                																	<p>We have received a new feedback at&nbsp;{SITE_NAME}. The details are as follows:</p>
                															</td>
                														</tr>';
                                            if(trim($data->firstName) <> ""){
                                                $emailBody .= '<tr>
                                                  <td>
                                                  <p>Name:</p>
                                                  </td>
                                                  <td>
                                                  <p>'.trim($data->firstName).' '.trim($data->lastName).'</p>
                                                  </td>
                                                </tr>';
                                            }
                                            if(trim($data->address) <> ""){
                                                $emailBody .= '<tr>
                                                  <td>
                                                  <p>Address:</p>
                                                  </td>
                                                  <td>
                                                  <p>'.trim($data->address).'</p>
                                                  </td>
                                                </tr>';
                                            }
                                            if(trim($data->phone) <> ""){
                                                $emailBody .= '<tr>
                                                  <td>
                                                  <p>Phone:</p>
                                                  </td>
                                                  <td>
                                                  <p>'.trim($data->phone).'</p>
                                                  </td>
                                                </tr>';
                                            }
                                            if(trim($data->emailId) <> ""){
                                                $emailBody .= '<tr>
                                                  <td>
                                                  <p>Email:</p>
                                                  </td>
                                                  <td>
                                                  <p>'.trim($data->emailId).'</p>
                                                  </td>
                                                </tr>';
                                            }
                                            if(trim($data->country) <> ""){
                                                $emailBody .= '<tr>
                                                  <td>
                                                  <p>Country:</p>
                                                  </td>
                                                  <td>
                                                  <p>'.trim($data->country).'</p>
                                                  </td>
                                                </tr>';
                                            }
                                            if(trim($data->city) <> ""){
                                                $emailBody .= '<tr>
                                                  <td>
                                                  <p>City:</p>
                                                  </td>
                                                  <td>
                                                  <p>'.trim($data->city).'</p>
                                                  </td>
                                                </tr>';
                                            }
                                            if(trim($data->subject) <> ""){
                                                $emailBody .= '<tr>
                                                  <td>
                                                  <p>Subject:</p>
                                                  </td>
                                                  <td>
                                                  <p>'.trim($data->subject).'</p>
                                                  </td>
                                                </tr>';
                                            }
                                            if(trim($data->message) <> ""){
                                                $emailBody .= '<tr>
                                                  <td>
                                                  <p>Message:</p>
                                                  </td>
                                                  <td>
                                                  <p>'.trim($data->message).'</p>
                                                  </td>
                                                </tr>';
                                            }
                														$emailBody .= '<tr>
                															<td colspan="2">&nbsp;</td>
                														</tr>
                														<tr>
                															<td colspan="2"><strong>Regards,<br/>Team {SITE_NAME}</strong></td>
                														</tr>
                													</tbody>
                												</table>';

                        $arrTSearch     = array("{SITE_NAME}");
                				$arrTReplace    = array(SITE_NAME);
                				$emailBody      = str_replace($arrTSearch, $arrTReplace, $emailBody);
                        //echo $emailBody; die();

                				$mail             = new PHPMailer();
                				$mail->IsSMTP();
                				$mail->Host       = SMTPSERVER;      // SMTP server example
                        $mail->SMTPAuth   = true;                       // enable SMTP authentication
                        $mail->Port       = SMTPPORT;       // set the SMTP port for the GMAIL server
                        $mail->Username   = SMTPUSERNAME;  // SMTP account username example
                        $mail->Password   = SMTPPASSWORD;   // SMTP account password example

                				$mail->SMTPSecure = 'ssl';
                				//$mail->AddReplyTo($from_email,$from_name);
                				$mail->SetFrom($admin_email,$from_name);
                				if($mail->validateAddress($admin_email)){
                						$mail->AddAddress($admin_email, $from_name);
                				}
                				$mail->Subject     = $subject;
                				$mail->AltBody     = ''; // Optional, comment out and test.
                				$mail->MsgHTML($emailBody);
                			  $mail->Send();
                        /************************ SEND EMAIL TO ADMINISTRATOR  **********************/
                    }

                    header("location:".BASE_URL."contact");
                    exit(0);
                }
            //}else{
              //  PageContext::$response->message = "<span style='color:red'>Incorrect verification code!</span>";
            //}
        }

        /********************************* LOOK_UP TABLE ENTRIES ****************************************/
        $settingsName                                 = "contact_address";
        PageContext::$response->contact_address       = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                 = "contact_phone";
        PageContext::$response->contact_phone         = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                 = "contact_email";
        PageContext::$response->contact_email         = Cmshelper::getSettingsValueByName($settingsName);
        $settingsName                                 = "skype_address";
        PageContext::$response->skype_address         = Cmshelper::getSettingsValueByName($settingsName);
        if(trim(PageContext::$response->contact_address) <> "" || trim(PageContext::$response->contact_phone) <> ""
        || trim(PageContext::$response->contact_email) <> "" || trim(PageContext::$response->skype_address)){
            PageContext::$response->show_contact_details = 1;
        }else{
            PageContext::$response->show_contact_details = 0;
        }
        /********************************* LOOK_UP TABLE ENTRIES ****************************************/

    }

    public function subscribe_email(){
        $session          = new LibSession();
        $subscribe_email  = $_POST['subscribe_email'];
        $return_values    = array();
        if(!empty($subscribe_email)){
            if(User::checkEmailSubscribed($subscribe_email) > 0){
                $return_values["message"]  = "Email already subscribed!";
                $return_values["msgclass"] = "subscribe_error";

                //$session->set('subscribe_error_msg','Email already subscribed!');
            }else{
                $vSubscriberId      = User::subscribeEmail($subscribe_email);
                if($vSubscriberId){
                    $return_values["message"]   = "Email subscribed successfully!";
                    $return_values["msgclass"]  = "subscribe_success";

                    //$session->set('subscribe_succ_msg','Email subscribed successfully!');
                }else{
                    $return_values["message"]   = "Something went wrong, Please try again later!";
                    $return_values["msgclass"]  = "subscribe_error";

                    //$session->set('subscribe_error_msg','Something went wrong, Please try again later!');
                }
            }
        }
        echo json_encode($return_values);
        exit(0);
    }

    public function unsubscribe($subscribe_email){
        $session          = new LibSession();
        if(User::unsubscribeEmail($subscribe_email) > 0){
            $session->set('success_msg','Email unsubscribed successfully!');
            header("location:".BASE_URL."unsubscribe_email");
            exit(0);
        }else{
            $session->set('error_msg','Email already unsubscribed!');
            header("location:".BASE_URL."unsubscribe_email");
            exit(0);
        }
    }

    public function pages($alias){
        if(empty($alias)){
          $alias ="home";
          //PageContext::registerPostAction("header", "homepageheader","index","default");
        }

        PageContext::$response->activeMenu  = $alias;
        $metaData                           = Cmshelper::getMetaData($alias);
        PageContext::$metaTitle             = $metaData[0]->title;
        PageContext::$metaDes               = $metaData[0]->description;
        PageContext::$metaKey               = $metaData[0]->keywords;

        //else PageContext::registerPostAction("header", "headerpanel","index","default");
        PageContext::registerPostAction("center-main", "pages", "index", "default");
        //PageContext::$response->content     = Cmshelper::getStaticContent($alias);
        PageContext::$response->content     = Managecmsview::renderPageFromUrl($alias, true);
        //echopre(PageContext::$response->content); die();
        if(empty(PageContext::$response->content[0]->description)){
            header("Location:error"); exit(0);
        }
        PageContext::$response->topMenu     = Managecmsview::renderMenu(1, 2,$alias);
        PageContext::registerPostAction("header", "topmenu","index","default");
    }

    public function static_content($alias){
        $meta_alias                         = "home";
        PageContext::$response->activeMenu  = $alias;
        $metaData                           = Cmshelper::getMetaData($meta_alias);
        PageContext::$metaTitle             = $metaData[0]->title;
        PageContext::$metaDes               = $metaData[0]->description;
        PageContext::$metaKey               = $metaData[0]->keywords;

        //else PageContext::registerPostAction("header", "headerpanel","index","default");
        PageContext::registerPostAction("center-main", "static_content", "index", "default");
        PageContext::$response->content     = Cmshelper::getStaticContent($alias);
        //PageContext::$response->content     = Managecmsview::renderPageFromUrl($alias, true);
        //echopre(PageContext::$response->content);
        if(empty(PageContext::$response->content["cnt_content"])){
            header("Location:error");
            exit(0);
        }
        if(!empty(PageContext::$response->content["cnt_title"])){
            PageContext::$metaTitle             = PageContext::$response->content["cnt_title"]." - ".SITE_NAME;
        }
        PageContext::$response->topMenu     = Managecmsview::renderMenu(1, 2,$alias);
        PageContext::registerPostAction("header", "topmenu","index","default");
    }

    public function section($alias){
        if(empty($alias)){
            $alias ="home";
        }
        PageContext::$response->activeMenu  = $alias;
        $metaData                           = Cmshelper::getMetaData($alias);
        PageContext::$metaTitle             = $metaData[0]->title;
        PageContext::$metaDes               = $metaData[0]->description;
        PageContext::$metaKey               = $metaData[0]->keywords;
        PageContext::$response->topMenu     = Managecmsview::renderMenu(1, 2, $alias);
        //echopre(PageContext::$response->topMenu);

        PageContext::registerPostAction("center-main", "section", "index", "default");
        PageContext::$response->content     = Managecmsdata::getSectionFullDataByAlias($alias);
        //echopre(PageContext::$response->content); echo "--------------------------------------";
        $pageUrl = Managecmsview::formPagingUrl($alias,PageContext::$request);
        if(PageContext::$request['page'] != ""){
            $pageUrl  = $pageUrl;
            $pageUrl  = str_replace("page=".PageContext::$request['page'], "", $pageUrl);
            $pageUrl  = $pageUrl."?";
        }
        else{
            $pageUrl = $pageUrl."?";
        }

        $settingsName                                     = "frontend_perpagesize";
        PageContext::$response->frontend_perpagesize      = Cmshelper::getSettingsValueByName($settingsName);
        if(PageContext::$response->frontend_perpagesize){ //Per page size from settings table
            $perPageSize        = trim(PageContext::$response->frontend_perpagesize);
        }else{
            $perPageSize        = 12;
        }
        $page               = PageContext::$request['page'];
        $page               = (($page == 0 || $page == "") ? 1 : $page);
        $start              = ($page - 1) * $perPageSize;
        $pageEnd            = $start + $perPageSize;

        PageContext::$response->pageStart   = $start;
        PageContext::$response->perPageSize = $perPageSize;
        PageContext::$response->pageEnd     = $pageEnd;
        $allCategories                      = PageContext::$response->content[0]->child;
        $numRowsListData                    = count($allCategories);
        PageContext::$response->pagination  = Managecmsview::section_pagination($numRowsListData,$perPageSize,$pageUrl,PageContext::$request['page']);
    }

    public function section_details($section_name,$slug){
        if(trim($slug) == "") return "";
        PageContext::$response->content     = Managecmsdata::getContentDetailsByAlias($slug);
        //echopre(PageContext::$response->content);

        PageContext::$response->activeMenu  = $alias = PageContext::$response->content[0]->section_alias;
        $metaData                           = Cmshelper::getMetaData($alias);

        if(trim(PageContext::$response->content[0]->title) <> ""){
            PageContext::$metaTitle             = trim(PageContext::$response->content[0]->title);
            if(trim(PageContext::$response->content[0]->section_title) <> ""){
                PageContext::$metaTitle .= " - ".trim(PageContext::$response->content[0]->section_title);
            }
            PageContext::$metaTitle .= " - ".SITE_NAME;
        }else{
            PageContext::$metaTitle             = $metaData[0]->title;
        }
        PageContext::$metaDes               = $metaData[0]->description;
        PageContext::$metaKey               = $metaData[0]->keywords;
        PageContext::$response->topMenu     = Managecmsview::renderMenu(1, 2,$alias);

        PageContext::registerPostAction("header", "topmenu","index","default");
        PageContext::registerPostAction("center-main","section_details","index","default");
    }


    public function login($appid=""){
        PageContext::addScript("bootstrap-tooltip.js");
        PageContext::addScript("bootstrap-popover.js");

        PageContext::$response->activeMenu    = $alias = "login";
        PageContext::$response->topMenu       = Managecmsview::renderMenu(1, 1,$alias);
        PageContext::registerPostAction("header", "topmenu","index","default");
        PageContext::$metaTitle = "Login to your ".SITENAME." account";

        // Pricing Enabled
        PageContext::$response->registerUrl = (SAAS == true)?"plans":"register";

        // get the application id

        // make custom logo and title
        if($appid != '') {
            // check that the APP id is a valid one
            $smbAccInfo = Smbaccount::getSmbAccount($appid);
            if($smbAccInfo->smb_acc_id == '') {
                $errorMessage = 'Invalid Application ID';
                PageContext::$response->message = ' <div class="error_div">'.$errorMessage.' </div>';
            }
            else {
                PageContext::$response->appid  = $appid;
                PageContext::$response->companyName = Settings::getCustomSettingsInfo($appid,'company-name');
                $companyLogo = Settings::getCustomSettingsInfo($appid,'companylogo');
                if($companyLogo != '') {
                    global $imageTypes;
                    PageContext::$response->companylogo =  '<img   src="'.USER_IMAGE_URL .$imageTypes['companylogothumb']['prefix']. $companyLogo.'">';
                }
            }
        }
        // custom home page section ends

        if($this->isPost('btnSubmit')) {
            $arrUser                = array();
            $arrUser['user_email']              = $this->post('txtemail');
            $arrUser['user_pwd']          = $this->post('txtpwd');
            $arrUser['appid']             = $this->post('txtAppId');


            // login verification
            $logResult = User::doLogin($arrUser);

            if($logResult['status'] == true) {
                header("location:".BASE_URL.'user');
            }
            else {
                //PageContext::$response->message  = "Invalid login details";
                $errorMessage = $logResult['valMessage'];
                PageContext::$response->message = ' <div class="error_div">'.$errorMessage.' </div>';
            }
        }
        PageContext::registerPostAction("center-main","login","index","default");
    }

    public function logout() {
        session_destroy();
        session_unset($_SESSION['user']);
        Utils::redirecttohome();
        header("location:".ConfigUrl::base());
        $this->view->disableView();
        exit();
    }

    public function plans() {
        PageContext::$metaTitle = "Pick a plan & sign up ";
        PageContext::$response->activeMenu  = $alias =  'plans';
        PageContext::$response->topMenu = Managecmsview::renderMenu(1, 1,$alias);
        PageContext::registerPostAction("header", "topmenu","index","default");
        PageContext::$response->planlist = Plans::getPlanList();
        PageContext::registerPostAction("center-main","plans","index","default");
    }

    public function register($planid=""){
        PageContext::$response->activeMenu  = $alias =  'register';
        PageContext::$response->topMenu     = Managecmsview::renderMenu(1, 1,$alias);
        PageContext::$response->states      = Cmshelper::getUsStates();
        //echopre(PageContext::$response->states);
        PageContext::registerPostAction("header", "topmenu","index","default");
        $showPage           = 'mainpage';

        if(SAAS){
            PageContext::$response->planId  = $planid;
            PageContext::$response->planInfo  = Plans::getPlanInfo($planid);
            PageContext::$response->planlist  = Plans::getPlanList();
        }
        if(PageContext::$response->planInfo->plan_amount <=0){
            PageContext::$response->hideplan = 'hide';
        }else{
            PageContext::$response->hideplan = '';
        }
        /**** user checking when he is a retured user*******/
        $action   = PageContext::$request['action'];

       // echopre(PageContext::$response->states);
        if($action == 'returnuser') {
            $key    = PageContext::$request['key'];
            if($key != '') {
                $keyinfo = Utils::checkVerificationCode($key);
                if(sizeof($keyinfo) > 0) {
                    if($keyinfo->vstatus == '1') {
                        $userinfo = User::getUserInfo($keyinfo->vuserid);
                        PageContext::$response->user_email  = $userinfo->user_email;
                        PageContext::$response->user_fname  = $userinfo->user_fname;
                        PageContext::$response->user_lname  = $userinfo->user_lname;
                        PageContext::$response->company   = $userinfo->user_company;
                        PageContext::$response->user_phone  = $userinfo->user_phone;
                        PageContext::$response->user_phone_extension = $userinfo->user_phone_extension;
                        PageContext::$response->user_type = 'returnuser';
                        PageContext::$response->user_id   = $keyinfo->vuserid;
                    }
                    else
                        echo "Inactive key";
                }
                else {
                    echo "invalid key";
                }
            }
        }

        /***** returned user checking ends ******/

        //if($this->isPost('btnRegister')){
        if(isset($_POST['btnRegister'])) {  //echopre1($_POST);

            // If plan/pricing enabled
            if(SAAS){
                // get the plan amount
                PageContext::$response->txtplan     = $planId     = $this->post('txtuserplan');
                PageContext::$response->planPeriod    = $planPeriod = PageContext::$request['txtplanperiod'];
                $planAmount                                     = $planAmt    = Plans::getPlanAmount($planId);

                if($planPeriod != '' && $planPeriod <= 0) $planPeriod = 1;
                $paymentAmt = $planAmount * $planPeriod;
            }


            $objUser            = new stdClass();
            PageContext::$response->salesrep_fname    = $objUser->salesrep_fname              = $this->post('salesrep_fname');
            PageContext::$response->salesrep_lname    = $objUser->salesrep_lname            = $this->post('salesrep_lname');
            PageContext::$response->salesrep_address    = $objUser->salesrep_address              = $this->post('salesrep_address');
            $objUser->salesrep_password               = md5($this->post('salesrep_password'));
            PageContext::$response->salesrep_state    = $objUser->salesrep_state      = $this->post('salesrep_state');
            PageContext::$response->salesrep_phone    = $objUser->salesrep_phone      = $this->post('salesrep_phone');

            $objUser->salesrep_status               = '0';  // not activated
            PageContext::$response->salesrep_pincode    = $objUser->salesrep_pincode              = $this->post('salesrep_pincode');
            $fileHandler = new Filehandler();
            $reumeFileDetails = $fileHandler->handleUpload($_FILES['salesrep_photo_id']);
            PageContext::$response->salesrep_email= $objUser->salesrep_email        = $this->post('salesrep_email');
            PageContext::$response->salesrep_photo_id= $objUser->salesrep_photo_id        = $reumeFileDetails->file_id;
            PageContext::$response->salesrep_country= $objUser->salesrep_country        = 'USA';
            //  echo PageContext::$response->user_phone_extension;exit;
            $objUser->salesrep_joinedon             = date("Y-m-d H:i:s");
         //   $objUser->user_activation_key       = '';

            $uName      = $objUser->user_fname.' '.$objUser->user_lname;
            $userType     = PageContext::$request['user_type'];
            $userid     = PageContext::$request['user_id'];


            if($userType == 'returnuser' && $userid != '') {
                // updating the user
                $arrUser['user_email']        = PageContext::$request['txtemail'];
                $arrUser['user_fname']        = PageContext::$request['txtfname'];
                $arrUser['user_lname']        = PageContext::$request['txtlastname'];
                $arrUser['user_company']      = PageContext::$request['txtcompany'];
                $arrUser['user_phone_extension']                = PageContext::$request['ccmobile'];
                $arrUser['user_phone']        = PageContext::$request['txtphone'];
                $arrUser['user_password']       = PageContext::$request['txtpassword'];
                $user_id          = $userid;

                User::updateUserinfo($user_id,$arrUser);
                $objUserRes->status     = 'SUCCESS';
                $objUserRes->data->user_id  = $user_id;
            }
            else {
                // creating user
                //echo"user";echopre($objUser);exit;
                $objUserRes   = User::createSalesRep($objUser);
                 $emailIds = array($objUser->salesrep_email);

                 $paramas = array();
                 $paramasadmin =array();


                 $paramasadmin['FNAME'] = $objUser->salesrep_fname;
                 $paramasadmin['LNAME'] = $objUser->salesrep_lname;
                 $paramasadmin['EMAIL'] = $objUser->salesrep_email;
                 $paramasadmin['ADDRESS'] = $objUser->salesrep_address.','.$objUser->salesrep_pincode.','.$objUser->salesrep_state;
                 $paramasadmin['PHONE_NO'] = $objUser->salesrep_phone;



                $paramas['NAME'] = $objUser->salesrep_fname.' '.$objUser->salesrep_lname;



                $mailSend = Mailer::sendUserRegistrationMail($emailIds,'user_registration',$paramas,$files);
                $paramasadmin['NAME'] = 'Admin';
                 $emailIds = array();
                $mailSend = Mailer::sendUserRegistrationAdminMail($emailIds,'user_registration_admin',$paramasadmin,$files);

            }
            $usermail = PageContext::$request['txtemail'];


             if($objUserRes->status == ERROR) {
                  PageContext::$response->type = 'error';
                    PageContext::$response->message = USER_EMAIL_EXIST;

             }


            if($objUserRes->status == SUCCESS) {


                    PageContext::$response->type = 'success';
                    PageContext::$response->message = 'Thank you for registering,Admin will verify your request';

                    //redirect the user to the dashboard
                   //$this->redirect("index/register/");


//                if(SAAS){
//
//                    if($paymentAmt>0){
//                        // gt bank payment section ends
//                        $cardNo   = PageContext::$request['txtcard'];
//                        $cardCode   = PageContext::$request['txtcardcode'];
//                        $cardMonth  = PageContext::$request['txtcardmonth'];
//                        $cardYear   = PageContext::$request['txtcardyear'];
//
//                        // payment section for registerd user
//                        $authorizePaymentDetails =  array(
//                                'desc'  => 'Payment for Registration',
//                                'amount'  => $paymentAmt,
//                                'expMonth'  => $cardMonth,
//                                'expYear'   => $cardYear,
//                                'cvv'   => $cardCode,
//                                'ccno'      => $cardNo,
//                                'fName'   => $this->post('txtfname'),
//                                'lName'   => $this->post('txtlastname'),
//                                'add1'  => 'Address 1',
//                                'city'  => 'Address 2',
//                                'state'   => 'AL',
//                                'country'   => 'US',
//                                'zip'     => '60001'    );
//                        $status     = Payments::authorize($authorizePaymentDetails, TRUE);
//                        $transactionId  = $status['TransactionId'];
//                    }else{
//                        $status['success'] = 1;
//                    }
//                }
//
//                // Set status val
//                $statusVal    = (SAAS == true)?$status['success']:"1";
//
//                if($statusVal == 1) {   // the payment is success. Update DB
//
//                    $planPeriodMonth  = PageContext::$response->planInfo->plan_period;
//                    $planPeriod   = $planPeriodMonth * $planPeriod;
//                    $date     = date("Y-m-d H:i:s");
//                    $planEndDate  = date("Y-m-d H:i:s",strtotime($date. ' + '.$planPeriod.' days'));
//                    $phoneNoPeriod  = Utils::getSettings('inboundphnoperiod');
//                    $phoneNoEndDate   = date("Y-m-d H:i:s",strtotime($date. ' + '.$phoneNoPeriod.' days'));
//
//                    // create a smb account for this user
//                    $arrSmb                                     = array();
//                    $arrSmb['smb_owner_id']       = $objUserRes->data->user_id;
//                    $arrSmb['smb_avail_credit']     = DEFAULT_CREDIT;
//                    $arrSmb['smb_subscription_date']    = $date;
//                    $arrSmb['smb_subscription_expire_date'] = $planEndDate;
//                    $arrSmb['smb_createdon']      = $date;
//                    $arrSmb['smb_plan']       = $planId;
//                    $arrSmb['smb_name']       = $this->post('txtcompany');
//                    $smbId = Smbaccount::addSmbAccount($arrSmb);
//
//                    // update the status of the user - activate the user
//                    User::changeUserStatus($objUserRes->data->user_id, 1);
//
//                    //send mail to user for success message
//                    if(ENVIRONMENT != ENV_LOCAL) {
//
//                        if(SAAS){
//                            $planInfo      = Plans::getPlanInfo($planId);
//                            // prepare mail details
//                            $mailPlanStartDate = date("m/d/Y",strtotime($date));
//                            $mailPhoneEndDate  = date("m/d/Y",strtotime($phoneNoEndDate));
//                            $mailPlanEndDate   = date("m/d/Y",strtotime($planEndDate));
//                            $fancyInvoice      = '';
//
//                            $planInvoice = ' <tr>
//                                            <td>&nbsp;</td>
//                                            <td><span style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333; line-height:21px; text-align:justify; ">'.$planInfo->plan_name.' Plan<br>
//                                              Purchase from '.$mailPlanStartDate.' to '.$mailPlanEndDate.'  </span></td>
//                                            <td valign="top"><span style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333; line-height:21px; text-align:justify; "><strong>'.DEFAULT_CURRENCY.$planAmt.'</strong></span></td>
//                                          </tr>';
//
//                            // replacement section
//
//                            // Plan related section
//                            $replaceParameters['TRANSACT_ID']     = $transactionId;
//                            $replaceParameters['PLAN_NAME']     = $planInfo->plan_name;
//                            $replaceParameters['PAYMENT_AMT']     = $paymentAmt;
//                            $replaceParameters['PLAN_EXP_DATE']   = $mailPlanEndDate;
//                            //$replaceParameters['SHOW_MAIL']     = '1';
//                            $replaceParameters['TOTAL_AMT']     = $paymentAmt;
//                            $replaceParameters['PLAN_INVOICE']    = $planInvoice;
//                            $replaceParameters['FANCYNO_INVOICE']   = $fancyInvoice;
//                        }
//
//                        // Basic section
//                        $replaceParameters['ACTIVATION_LINK']     = "Click here";
//                        $name                                           = ucfirst($this->post('txtfname')).' '.ucfirst($this->post('txtlastname'));
//                        $emailAddress[$usermail]      = $name;
//                        $replaceParameters['NAME']      = $name;
//                        $replaceParameters['APPID']       = $smbId;
//                        //$replaceParameters['SHOW_MAIL']     = 1;
//
//                        // send login details to user
//                        $objMailer    = new Mailer();
//                        $objMailer->sendMail($emailAddress, 'smbloginmail', $replaceParameters);
//
//                        if(SAAS){
//                            // send invoice details to user
//                            $objMailer    = new Mailer();
//                            $objMailer->sendMail($emailAddress, 'smb-register-invoice', $replaceParameters);
//
//                            // send email to admin about the invoice details
//                            $adminEmail     = Utils::getSettings('admin_email');
//                            $adminEmailAddress    = array($adminEmail=>'Admin');
//                            $objMailer      = new Mailer();
//                            $objMailer->sendMail($adminEmailAddress, 'smb-register-invoice-admin', $replaceParameters);
//                        }
//                    }
//                    // mail sending section ends
//
//                    if(SAAS){
//                        // add to transaction table
//                        $arrTransaction = array(
//                                'tr_status'   => $status['success'],
//                                'tr_amount'         => $paymentAmt,
//                                'tr_mode'     => '1',   // authorize payament
//                                'tr_type'     => '1',   // registration
//                                'tr_details'  => 'Plan Purchase',
//                                'tr_created_on'     => $date,
//                                'tr_created_by'     => $objUserRes->data->user_id,
//                                'tr_transact_id'    => $transactionId,
//                                'tr_account_id' => $smbId  );
//                        $transactId = Payments::addTransaction($arrTransaction);
//
//
//
//                        if(DYNAMICDB) {
//
//                            // new database creation section starts
//                            $objDb    = new Appdbmanager();
//                            $newDBName  = USER_DB_NAME.$smbId;
//                            $objDb->createUserDB($newDBName);
//
//                            // call function to create a staff on the newly created databse
//                            $arrStaff   = array(
//                                    'agent_email'     => $objUser->user_email,
//                                    'agent_password'    => $objUser->user_pwd,
//                                    'agent_fname'     => $this->post('txtfname'),
//                                    'agent_lname'     => $this->post('txtlastname'),
//                                    'agent_status'      => 1,
//                                    'agent_master'      => 1,
//                                    'agent_photo_id'    => '',
//                                    'agent_parent'      => $smbId,
//                                    'agent_added_on'    => $date  );
//                            $staffId  = $objDb->createStaff($smbId,$arrStaff);
//                            $staffId = '1';
//                            // move the settings data to new table
//                            Appdbmanager::moveCrunchDataToUserTable($smbId,$staffId);
//
//
//                            // transfer the site settings to user table
//                            $arrReplace         = array();
//                            $arrReplace['company-name'] = PageContext::$response->company;
//                            $arrReplace['asterisk-no']  = $smbId;
//                            $appDbManager = new Appdbmanager();
//                            $appDbManager->moveSettingsDataToUserTable($smbId,$arrReplace);
//                            // site settings data transfer ends
//                        }
//                    }
//
//                    // creating session for smb
//                    $customer       = $objUser;
//                    $customer->user_id    = $objUserRes->data->user_id ;
//                    $customer->agentinfo  = $arrStaff ;
//                    $customer->agent_master = '1' ;
//                    $customer->smb_id           = $smbId;
//                    $userid       = $objUserRes->data->user_id;
//                    $customer->agent_id   = $staffId;
//                    $db       = new Db();
//                    $smbDetails     = $db->selectRecord("smb_account","*","smb_owner_id=".$userid);
//                    $customer->smbaccount   = $smbDetails;
//
//                    $objSession     = new LibSession();
//                    $objSession->set('kb_user',serialize($customer));
//                    $objSession->set('kb_user',json_encode($customer));
//
//
//                    $showPage     = 'success';
//                    PageContext::$response->message = 'Successfuly registerd';
//
//                    // redirect the user to the dashboard
//                    $this->redirect("index/success/".$smbId);
//
//                }
//                else {  // the payment is failed.
//
//                    // update the status of the user - activate the user
//                    User::changeUserStatus($objUserRes->data->user_id,'4');
//                    //User::removeUser($objUserRes->data->user_id);
//
//                    if(SAAS){
//                        // add the transaction details to db
//                        $arrTransaction = array(
//                                'tr_status'   => 0,
//                                'tr_amount'     => $paymentAmt,
//                                'tr_type'   => '1',   // authorize payament
//                                'tr_details'  => 'Plan Purchase',
//                                'tr_created_on' => date("Y-m-d H:i:s"),
//                                'tr_created_by' => $objUserRes->data->user_id );
//                        Payments::addTransaction($arrTransaction);
//
//                        // TODO: sent mail to user for payment fails
//                        if(ENVIRONMENT != ENV_LOCAL) {
//
//                        }
//
//                        //PageContext::$response->message ='Payment Fails';
//                        $errorMessage = "Invalid credit card details";
//                        PageContext::$response->message = ' <div class="error_div">'.$errorMessage.' </div>';
//                    }
//                }

            }
            else {  // user inserion fails

                // the previous registration payment status was failed.
                // add a popup option for payment
                if($objUserRes->user_status == 4) {
                    PageContext::$response->paymentFailedUser = '1';
                }

                $errorMessage = $objUserRes->message;
                PageContext::$response->message = ' <div class="error_div">'.$errorMessage.' </div>';
            }
        }


        if($showPage == 'success')
            PageContext::registerPostAction("center-main","success","index","default");
        else
            PageContext::registerPostAction("center-main","register","index","default");

        // tool tip js files
        PageContext::addScript("bootstrap-tooltip.js");
        PageContext::addScript("bootstrap-popover.js");
        PageContext::$response->messagebox= Message::getPageMessage();
    }
    /*
     * function to show the register success message
    */
    public function success($appid) {

        PageContext::$response->appid = $appid;
        PageContext::$response->topMenu = Managecmsview::renderMenu(1, 1);
        PageContext::registerPostAction("header", "topmenu","index","default");
        PageContext::registerPostAction("center-main","success","index","default");

    }

    public function pagenotfound() {
        PageContext::$response->activeMenu  = 'error';
        PageContext::$response->topMenu = Managecmsview::renderMenu(1, 1);
        PageContext::registerPostAction("header", "topmenu","index","default");
        //PageContext::$response->planlist = Plans::getPlanList();
        PageContext::registerPostAction("center-main","pagenotfound","index","default");

    }

    public function unsubscribe_email(){
        $session  = new LibSession();
        if(trim($session->get('success_msg')) <> ""){
            PageContext::$response->success_msg = trim($session->get('success_msg'));
        }
        else if(trim($session->get('error_msg')) <> ""){
            PageContext::$response->error_msg = trim($session->get('error_msg'));
        }

        PageContext::$response->activeMenu  = 'home';
        PageContext::$response->topMenu = Managecmsview::renderMenu(1, 1);
        PageContext::registerPostAction("header", "topmenu","index","default");
        //PageContext::$response->planlist = Plans::getPlanList();
        PageContext::registerPostAction("center-main","unsubscribe_email","index","default");
    }

    public function forgotpassword(){
        PageContext::$response->activeMenu  = 'forgotpassword';
        PageContext::$response->topMenu = Managecmsview::renderMenu(1, 1);
        PageContext::registerPostAction("header", "topmenu","index","default");

        if($this->isPost('btnSubmit')) {
            // $appid  = PageContext::$request['txtappid'];
            $user_email          = PageContext::$request['txtemail'];
            // if(Smbaccount::checkSmbAccountExist($appid)) {//smb acount check
                $passwordArray   =   User::resetPassword($user_email);


                if(sizeof($passwordArray)>0) {//mail new password

                    $name       = ucfirst( $passwordArray['username']) ;
                    $emailAddress[$user_email]        = $name;

                    $replaceParameters['NAME']          = $name;
                    // $replaceParameters['APPID']        = $appid;
                    $replaceParameters['LOGEMAIL']        = $user_email;
                    $replaceParameters['NEWPASSWORD']       = $passwordArray['newpassword'];

                    //  $replaceParameters['SHOW_MAIL']       = '1';

                    $logurl           = BASE_URL.'login/';
                    $logtext          = '<a href="'.$logurl.'">here</a>';
                    $replaceParameters['HERE']  = $logtext;



                    // send login details to user
                    $objMailer    = new Mailer();
                    $objMailer->sendMail($emailAddress, 'smb-agent-reset-password', $replaceParameters);



                    /*
                    $subject    =   "Password reset request";
                    $msg.="<p>Dear  ".$passwordArray['agent_name'].",</p>Your password has been reset on request.
                    <p>The following are your new login details.</p>
                    <p>User Name:      ".$user_email."</p>
                    <p>Password:       ".$passwordArray['newpassword']." </p>
                    If you have any issues please contact us at ".$this->siteSettings['adminEmail']."";
                    mail($user_email,$subject,$mesaage);
                    */
                    $message      = "We have sent the reset password message to your e-mail - ".$user_email.". <br>Please check your  inbox";
                    $msg_class      = "success_message";
                }
                else {//Invalid email
                    $message    = 'The email id you entered doesnt exist';
                    $msg_class      = "error_message";
                }
            // }
            // else {//Invalid App Id
            //     $message= 'The app id you entered doesnt exist';
            //     $msg_class          = "error_message";
            // }
            Message::setPageMessage($message, $msg_class);
            $messageArray                       = Message::getPageMessage();
            PageContext::$response->message1     = $messageArray['msg'];
            PageContext::$response->class       = $messageArray['msgClass'];
        }
        PageContext::registerPostAction("center-main","forgotpasword","index","default");
    }
    /*
   * function give the option to login into user app
    */
    public function getUserLoggedInSession($appid='') {
        $session = new LibSession();
        if($session->get('admin_logged_in','cms') == 1 ) {
            if(DYNAMICDB){
                // $dbh1               = mysql_connect(USER_DB_HOST, USER_DB_UNAME,USER_DB_PWD);
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

                // $newDBName       = USER_DB_NAME.$appid;
                // mysql_select_db($newDBName, $dbh1);
                // $resData = mysql_query("SELECT * FROM apptbl_agents WHERE agent_master=1",$dbh1);
                $resData = "SELECT * FROM apptbl_agents WHERE agent_master=1";
                $pdo_query = $dbh1->prepare($resData);
                $result = $pdo_query->execute();


                // if(mysql_num_rows($resData) > 0) {
                if($pdo_query -> rowCount() > 0) {
                    $customer           = new stdClass();
                    // $row                    = mysql_fetch_assoc($resData);
                    $row          = $result->fetch(PDO::FETCH_ASSOC);

                    $customer->smb_id       = $appid;
                    $customer->user_id    = $row['agent_parent'];
                    foreach($row as $key => $value) {
                        $customer->$key = $value;
                    }
                    $customer->agentinfo      =  $row;
                    $objSession           = new LibSession();
                    $objSession->set('kb_user',serialize($customer));
                    $objSession->set('kb_user',json_encode($customer));
                    $arrLogResult['valMessage']   = 'success';
                    $arrLogResult['status']       = TRUE ;
                }


                if($arrLogResult['status'] == 1) {
                    header("location:".BASE_URL.'smb/index/dashboard');
                    exit();
                }
                else {
                    header("location:".BASE_URL.'error');
                    exit();
                }
            }else{
                $smb_details = User::getSmbDetails($appid);
                $loginInfo = User::getUserlogin($smb_details->smb_owner_id);

                // $loginInfo = $db->selectRecord('users','user_id,user_status,user_fname,user_lname,user_email','user_id = "'.Utils::escapeString($smb_details->smb_owner_id).'"' );

                if($loginInfo->user_id > 0) {        // login success

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
                // echopre1($arrLogResult);
                if($arrLogResult['status'] == 1) {
                    header("location:".BASE_URL.'user/');
                    exit();
                }else {
                    header("location:".BASE_URL.'error');
                    exit();
                }
            }
        }
        header("location:".BASE_URL.'error');
        exit();
    }
    /**
     * Fucntion to call API to get the list of schools.
     *
     */
    public function getApiCall(){
      PageContext::$full_layout_rendering  = false;
      $this->view->disableLayout();


      $array = array('Content-Type: application/json', 'Authorization:Token token=eEpxrP4gXA3Jkb2gxLsw','Accept: application/json');
      $service_url = 'https://api-prod.8to18.com/v1/schools?limit=1000';
      $curl = curl_init($service_url);
      curl_setopt($curl, CURLOPT_HTTPHEADER, $array);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


      // Optional Authentication:
      //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      //curl_setopt($curl, CURLOPT_USERPWD, "8to18:apidocs");

      curl_setopt($curl, CURLOPT_URL, $service_url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      $curl_response = curl_exec($curl);
      if ($curl_response === false) {
        $info = curl_getinfo($curl);
        curl_close($curl);
        die('error occured during curl exec. Additioanl info: ' . var_export($info));
      }
      curl_close($curl);
      $decoded = json_decode($curl_response);
      //echopre1($decoded);
      if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
        die('error occured: ' . $decoded->response->errormessage);
      }
      //echo $decoded->objects[0]->school_id;
      foreach ($decoded as $key => $value) {
        # code...
        foreach ($value as $key => $sc) {
          # code...
          //echo $sc->school_id;exit();
          $url= $sc->url;
          echo $url."<br/>";
          $check=Cmshelper::chkSchoolsExists($url);
          if($check == FALSE){
            //if school is not listed in db fetch banner using the url

            //include ('simple_html_dom.php');
            //Include Simple HTML DOM Parser file
            include(LIB_DIR.'/simplehtml/simple_html_dom.php');
            $html = new simple_html_dom();
            $html = file_get_html($url);
            //$content = $html->find('div[class=txt]');


            foreach ($html->find('div[id=header] img') as $img)
              echo  $img->src . '<br>';

              $img1[]=$img->src ;

              foreach($img1 as $i){
                Cmshelper::save_image($i);
                if(getimagesize(basename($i))){
                  echo 'Image ' . basename($i) . ' Downloaded OK';
                }else{
                  echo 'Image ' . basename($i) . ' Download Failed';
                }
              }


            //exit();

          }else{
            echo "Missing";
          }
          exit();

        }

        echo '<pre>';
        print_r($value);
        exit();
      }
      echo '<pre>';
      //print_r($decoded);
      //var_dump($curl_response);



    }
}
?>
