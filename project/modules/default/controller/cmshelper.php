<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ControllerCmshelper extends BaseController
{
    public function init(){
        parent::init();
      //  PageContext::addScript("login.js");

		//$this->_common	 		= new ModelCommon();
        $this->_session         = new LibSession();

     }





	/*
	 *  this section handles the settings for the application.
	 *  These datas will copy to APP database while registering.
	 *  These are the default datas and APP owner can edit the data
	 */
 	public function appsettingsdisplay() {

        PageContext::includePath('resize');
        PageContext::addScript("settingsdisplay.js");
        PageContext::addStyle("cmssettings.css");
        $message = "";
        $success = "";


        /*********************** general settings starts *****************/

        // updating the general settings
        if(isset($_POST['btnSubmitGeneral'])){
         	Cmshelper::updateUserSettings('company-name', PageContext::$request['company-name']);
        	PageContext::$response->message 		= 'Successfully updated the general settings';
        	PageContext::$response->msgClass 		= 'success';
        }
        // get the general settings
        $pageContents       = Cmshelper::getListItem("appsettings", array('*'), array(array('field' => 'settings_group' , 'value' => 'general')));
        $genSettings 		= array();
        foreach($pageContents as $items)
        	$genSettings[$items->settings_name] 	= $items;
      	PageContext::$response->genSettings 		= $genSettings;
       	/*********************** general settings ends *****************/



      	/********************** Email settings starts **************/
      	// update email settings
      	if(isset($_POST['btnSubmitEmail'])){
         	Cmshelper::updateUserSettings('smtp_enable', 	PageContext::$request['smtp_enable']);
         	Cmshelper::updateUserSettings('smtp_host', 		PageContext::$request['smtp_host']);
         	Cmshelper::updateUserSettings('smtp_port', 		PageContext::$request['smtp_port']);
         	Cmshelper::updateUserSettings('smtp_username', 	PageContext::$request['smtp_username']);
         	Cmshelper::updateUserSettings('smtp_pwd', 		PageContext::$request['smtp_pwd']);

        	PageContext::$response->message 				= 'Successfully updated the email settings';
        	PageContext::$response->msgClass 				= 'success';
        }
      	// get email settings
        $pageContents       = Cmshelper::getListItem("appsettings", array('*'), array(array('field' => 'settings_group' , 'value' => 'email')));
        $emailSettings 		= array();
        foreach($pageContents as $items)
        	$emailSettings[$items->settings_name] 			= $items;
      	PageContext::$response->emailSettings 				= $emailSettings;
      	/************************ Email settings ends *****************/



      	/************************ Call settings starts *****************/
      	// update call settings
      	if(isset($_POST['btnSubmitCall'])){
         	Cmshelper::updateUserSettings('asterisk-no', 		PageContext::$request['asterisk-no']);
         	Cmshelper::updateUserSettings('asterisk-ip', 		PageContext::$request['asterisk-ip']);
         	Cmshelper::updateUserSettings('queue-waiting-time', PageContext::$request['queue-waiting-time']);
         	Cmshelper::updateUserSettings('callforwarding', 	PageContext::$request['callforwarding']);
         	Cmshelper::updateUserSettings('restrictsingleip', 	PageContext::$request['restrictsingleip']);
         	Cmshelper::updateUserSettings('blockoutgoing', 		PageContext::$request['blockoutgoing']);

        	PageContext::$response->message 				= 'Successfully updated the call settings';
        	PageContext::$response->msgClass 				= 'success';
        }

      	// get call settings
        $pageContents       = Cmshelper::getListItem("appsettings", array('*'), array(array('field' => 'settings_group' , 'value' => 'calls')));
        $callSettings 		= array();
        foreach($pageContents as $items)
        	$callSettings[$items->settings_name] 			= $items;
      	PageContext::$response->callSettings 				= $callSettings;
      	//echopre(PageContext::$response->callSettings);

      	/************************ Call settings ends *******************/





        PageContext::$response->activeTab = PageContext::$request['tab'];

        if(PageContext::$request['page']!="") {
            $pageUrl = $pageUrl;
            $pageUrl = str_replace("page=".PageContext::$request['page'], "", $pageUrl);
            $pageUrl = $pageUrl."&";
        }
        else
            $pageUrl=$pageUrl."&";
        PageContext::addJsVar("currentURL", 	$pageUrl);
        PageContext::$response->currentURL 	= $pageUrl;
    }



	/*
	 *  This section used to update the ICARUS settings.
	 *  The main site admin have the option to update the data
	 */
	public function settingsdisplay() {
        PageContext::includePath('resize');
        PageContext::addScript("settingsdisplay.js");
        PageContext::addStyle("cmssettings.css");
        $message = "";
        $success = "";

        // General settings updation
        if(isset($_POST['submitBtn'])){
            if(is_uploaded_file($_FILES['sitelogo']['tmp_name'])) {
                $bannerParts = pathinfo($_FILES['sitelogo']['name']);
                if(move_uploaded_file($_FILES['sitelogo']['tmp_name'], BASE_PATH.'project/styles/images/'.$_FILES['sitelogo']['name'])) {

                    Cmshelper::createThumbnail($_FILES['sitelogo']['name'],'',true,283,67,IMAGE_ROOT_URL);
                    Cmshelper::createThumbnail($_FILES['sitelogo']['name'],'footer_',true,157,36,IMAGE_ROOT_URL);
                    $_POST['sitelogo'] = $_FILES['sitelogo']['name'];
                    @unlink($bannerOriginal);
                }
            }

            foreach($enableChecks as $checkBoxes){
                if($_POST[$checkBoxes] == '')
                    $_POST[$checkBoxes] = 'N';
            }

            Cmshelper::updateSettings($_POST);

            $message = "Settings updated successfully.";
            $success = "success";
        }




        if(isset($_POST['passwordSubmitBtn'])){

            if(trim($_SESSION['admin_type']) != '')
            $admin_uid 		= $_SESSION['admin_type'];  // cms doesnt support uid as of now
            else if(trim($_SESSION['cms_admin_type']) != '')
            $admin_uid 		= $_SESSION['cms_admin_type'];  // cms doesnt support uid as of now

            $adminUserName = $_SESSION['cms_cms_username'];

            $updatePassword = Cmshelper::updateAdminPassword($adminUserName, $_POST);
            if($updatePassword=='success'){
               $message 	= "Password updated successfully.";
                $success 	= "success";
            }else{
                $message 	= $updatePassword;
                $success 	= "error";
            }
        }



        //general settings
        $pageContents       = Cmshelper::getListItem("lookup", array('*'), array(array('field' => 'groupLabel' , 'value' => 'General')));
        $genSettings 		= array();
        foreach($pageContents as $items)
        	$genSettings[$items->vLookUp_Name] 	= $items;
      	PageContext::$response->genSettings 	= $genSettings;
        //echopre(PageContext::$response->genSettings);



      	// advacned settings
      	 if(isset($_POST['btnAdvSubmit'])){


      	 	 	Cmshelper::updateAdminSettings('one_credit_value', 	PageContext::$request['one_credit_value']);
      	 	 	Cmshelper::updateAdminSettings('outbound_call_rate', 	PageContext::$request['outbound_call_rate']);
      	 	 	Cmshelper::updateAdminSettings('outbound_sms_rate', 	PageContext::$request['outbound_sms_rate']);
      	 	 	Cmshelper::updateAdminSettings('outbound_number', 	PageContext::$request['outbound_number']);
      	 	 	$message = "Settings updated successfully.";
            	$success = "success";
      	 }
      	// get advanced settings
      	$advContents	= Cmshelper::getListItem("lookup", array('*'), array(array('field' => 'groupLabel' , 'value' => 'payment')));
        $advSettings 		= array();
        foreach($advContents as $items)
        	$advSettings[$items->vLookUp_Name] 	= $items;
      	PageContext::$response->advSettings 	= $advSettings;
      	//echopre(PageContext::$response->paySettings);



        PageContext::$response->message 		= $message;
        PageContext::$response->msgClass 	= $success;


      	PageContext::$response->activeTab = PageContext::$request['tab'];
        if(PageContext::$response->activeTab == '') PageContext::$response->activeTab = 'general';
        if(PageContext::$request['page']!="") {
            $pageUrl = $pageUrl;
            $pageUrl = str_replace("page=".PageContext::$request['page'], "", $pageUrl);
            $pageUrl = $pageUrl."&";
        }
        else
            $pageUrl=$pageUrl."&";
        PageContext::addJsVar("currentURL", $pageUrl);
        PageContext::$response->currentURL = $pageUrl;


    }

    public function popupfeedbackinfo(){
        PageContext::$full_layout_rendering = false;
        $this->view->disableLayout();
        $feedback_id    	= PageContext::$request['id'];
        PageContext::$response = new stdClass();
        PageContext::$response->userDetails =Cmshelper::getFeedbackInfo($feedback_id);
    }

    /*
     * function to list the phone numbers.
     * Also admin can add the phone numbers
     */
    public function phonenumbers() {
    	$action 	= PageContext::$request['action'];
        $id 		= PageContext::$request['id'];
    	if($action != '' && $id != '') {
    		if($action == 'edit') {
    			PageContext::$response->phoneInfo 	= Phonenumbers::getPhoneInfo($id);
     		}
    		else if($action == 'delete') {
    			PageContext::$response->phoneInfo 	= Phonenumbers::deletePhoneNumber($id);
     			PageContext::$response->message1 	= '<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">�</button>Phone number deleted successfully </div>';
     		}
    	}



    	// inserting the phone number to database
    	if($this->isPost('btnSubmit')){
			$phoneNumber 	= PageContext::$request['txtphonenumber'];
        	$isfancy 		= PageContext::$request['isfancy'];
        	$phoneid 		= PageContext::$request['txtphoneid'];

        	if($phoneNumber != '') {
        		 if (is_numeric($phoneNumber)) {
        		 	// check phone number exist
        		 	$checkExist = Phonenumbers::checkPhoneNumberExists($phoneNumber,$phoneid);
        		 	if($checkExist > 0) {
        		 		PageContext::$response->message =	'<div class="alert alert-error"> <button type="button" class="close" data-dismiss="alert">�</button> This phone number already exist </div>';
        		 	}
        		 	else {   // insert the phone number

        		 		if($phoneid == '') {
	        		 		$phoneInfo = array( "ph_number" 	=> $phoneNumber,
												"ph_appid" 		=> '',
	                                    		"ph_fancy" 		=> $isfancy,
	                                            "ph_status" 	=> '1'  );

	        		 		Phonenumbers::addPhoneNumber($phoneInfo);
	        		 		PageContext::$response->message = '<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">�</button>Successfully added the phone number </div>';
         		 		}
        		 		else {
        		 			$phoneInfo = array( "ph_number" 	=> $phoneNumber,
	                                    		"ph_fancy" 		=> $isfancy  );

	        		 		Phonenumbers::updatePhoneNumber($phoneid,$phoneInfo);
	        		 		PageContext::$response->message = '<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">�</button> Successfully updated the phone number </div>';
	        		 		PageContext::$response->phoneInfo = '';
        		 		}
        		 	}
        		 }
        		 else
        		 	PageContext::$response->message = '<div class="alert alert-error"> <button type="button" class="close" data-dismiss="alert">�</button>Please enter a numeric value </div>';
        	}
        	else
        	 PageContext::$response->message = '<div class="alert alert-error"> <button type="button" class="close" data-dismiss="alert">�</button>Please enter the phone number </div>';

    	}

    	$where 				= "ph_status ='1'";
    	PageContext::$response->phonenumbers = Phonenumbers::getPhoneNumbers('ph_number' , 'ASC', $pagenum,$itemperpage,$search,$searchFieldArray,$where);



    }




    //Function to load user details pop up
    public function popupuserinfo(){
        PageContext::$full_layout_rendering = false;
        $this->view->disableLayout();
        $userid    	= PageContext::$request['id'];
        PageContext::$response = new stdClass();
        PageContext::$response->userDetails =Cmshelper::getUserInfo($userid);
    }


    //Function to load smb  details pop up
    public function popupsmbinfo(){

        PageContext::$full_layout_rendering = false;
        $this->view->disableLayout();
        $userid    	= PageContext::$request['id'];
        PageContext::$response = new stdClass();
        PageContext::$response->smbDetails =Cmshelper::getSmbInfo($userid);
    }


    /*
     * function to upgrade a smb plan
     */
    public function upgradesmbaccount() {
		PageContext::$full_layout_rendering = false;
        $this->view->disableLayout();
        $smbid    	= PageContext::$request['id'];
        // get smb account details
        PageContext::$response->smbUserInfo = Smbaccount::getSmbAccount($smbid);
        PageContext::$response->planList 	= Plans::getPlanList();
        PageContext::$response->userPlan 	= Plans::getPlanInfo(PageContext::$response->smbUserInfo->smb_plan);
    }


    /*
     * function to add credit to the APPlication
     */
	public function addcredit() {
		PageContext::$full_layout_rendering = false;
        $this->view->disableLayout();
        $smbId    	= PageContext::$request['id'];
        // get smb account details
        PageContext::$response = new stdClass();
        PageContext::$response->smbUserInfo = Smbaccount::getSmbAccount($smbId);
        PageContext::$response->credtiValue = Utils::getSettings('one_credit_value');

        // get credit history
        //PageContext::$response->creditHistory = Credits::getCreditHistory($smbid);
        PageContext::$response->creditHistory	=  Credits::getCreditHistory($smbId,$orderfield,$orderby,$page,$itemperpage,$search,$searchtypeArray,$arrSearchFilter);


       //    echopre(PageContext::$response->credtiValue);
      //  PageContext::$response->planList 	= Plans::getPlanList();
      //  PageContext::$response->userPlan 	= Plans::getPlanInfo(PageContext::$response->smbUserInfo->smb_plan);
    }



    public function changepassword() {

        PageContext::addJsVar('siteUrl', BASE_URL);

    PageContext::$full_layout_rendering = false;
        $this->view->disableLayout();
        PageContext::$response->salesrep_id     = PageContext::$request['id'];
        // get smb account details
//        PageContext::$response->smbUserInfo = Smbaccount::getSmbAccount($smbid);
//        PageContext::$response->planList  = Plans::getPlanList();
//        PageContext::$response->userPlan  = Plans::getPlanInfo(PageContext::$response->smbUserInfo->smb_plan);
    }


    public function changepasswordajax()
    {
        extract($_POST);
    $paramas = array();

        $data = User::getSalerepDetails($salesre_id);


        User::changepasswordajax($salesre_id,$_POST,$data->salesrep_email);



                $paramas['NAME'] = $data->salesrep_fname.' '.$data->salesrep_lname;
                $paramas['EMAIL'] = $data->salesrep_email;
                $paramas['PASSWORD'] = $_POST['npassword'];
                $emailIds = array($data->salesrep_email);
                $mailSend = Mailer::sendUserRegistrationAdminMail($emailIds,'reset-userpassword-admin',$paramas,$files);





     echo json_encode($data);


     exit;

    }



    /*
     * function to update the smb upgradation
     */
    public function updatesmbupgrading(){
    	$appid    	= PageContext::$request['appid'];
    	$plan    	= PageContext::$request['plan'];
    	//echo $appid.':'.$plan;
    	$upgraderes = Cmshelper::updateUserPlan($appid, $plan);
    	echo $upgraderes;
    	//echopre($_REQUEST);
    	exit();
    }

    /*
     * function to add new credit to the account
     */
    public function addsmbcredit(){
    	$appid    	= PageContext::$request['appid'];
    	$credit    	= PageContext::$request['credit'];
    	//echo $appid.':'.$plan;
    	$addCredit = Cmshelper::addCreditToApp($appid, $credit);
    	echo $addCredit;
    	// echopre($_REQUEST);
    	exit();
    }




       /*
     * function to load the tooltip informations
     */

    public function tooltiploader(){


    	$action 		= PageContext::$request['action'];
    	$value 			= PageContext::$request['value'];

    	/*
    	 * we are using db connection here to avoid the dependency and time lagg
    	 */

    	$objUserDb      = Appdbmanager::getUserConnection();
        $db             = new Db();
        if($value != '') {
    		 if($action == 'getaccountfromidadmin') {	// load the profile information from account email from admin section
        		$condition      = "smb_acc_id='".$value."'";
        		$contactinfo    = $db->selectRecord("smb_account", "smb_name", $condition);
        		if(sizeof($contactinfo)>0){
        			echo '<div class="quickcont_popup">	<div class="quickcont_popup_rtblk">	<p>
									'.$contactinfo->smb_name.'	</p> <p>
								</p></div>	   </div> ';
        		}
        		else {
        			echo '<div class="quickcont_popup">	<div class="quickcont_popup_rtblk">
								<p>Account Not Exist</p><p>	</p></div><div class="clear"></div>
							<div style="float:right; width:100px; margin:0; padding:0; text-align:right;"> </div>	</div> ';
        		}

    	}
    	}

    	exit();
    }

    //Function to change group publish status
    public function ajaxGroupPublishStatusChange() {
      //print_r(PageContext::$request);
      $id     = PageContext::$request['id'];
      $value  = PageContext::$request['value'];
      if ($id > 0) {
          $updateVal = Cmshelper::updateGroupPublishStatus($id, $value);
          $data['success'] = true;
          $data['message'] = 'Record updated successfully.';
          header("Location:".BASE_URL."cms#/groups");
          //echo json_encode($data);
          exit;
      }
      exit();
    }

    //Function to change newsletter status
    public function ajaxNewsletterStatusChange() {
      //print_r(PageContext::$request);
      $id     = PageContext::$request['id'];
      $value  = PageContext::$request['value'];
      if ($id > 0) {
          $updateVal = Cmshelper::updateNewsletterStatus($id, $value);
          $data['success'] = true;
          $data['message'] = 'Record updated successfully.';
          header("Location:".BASE_URL."cms#/newsletter");
          //echo json_encode($data);
          exit;
      }
      exit();
    }

    //Function to change CMS section status
    public function ajaxCmsSectionStatusChange() {
      //print_r(PageContext::$request);
      $id = PageContext::$request['id'];
      $value = PageContext::$request['value'];
      if ($id > 0) {
          $updateVal = Cmshelper::updateCmsSectionStatus($id, $value);
          $data['success'] = true;
          $data['message'] = 'Record updated successfully.';
          header("Location:".BASE_URL."cms#/sections");
          //echo json_encode($data);
          exit;
      }
      exit();
    }

      //Function to change page section status
    public function ajaxPageSectionStatusChange() {
        //print_r(PageContext::$request);
        $id = PageContext::$request['id'];
        $value = PageContext::$request['value'];
        if ($id > 0) {
            $updateVal = Cmshelper::updatePageSectionStatus($id, $value);
            $data['success'] = true;
            $data['message'] = 'Record updated successfully.';
            header("Location:".BASE_URL."cms#/pageSection");
            //echo json_encode($data);
            exit;
        }
        exit();
    }

    //Function to change email subscription status
    public function ajaxSubscriptionStatusChange() {
        //print_r(PageContext::$request);
        $id     = PageContext::$request['id'];
        $value  = PageContext::$request['value'];
        if ($id > 0){
            $updateVal = Cmshelper::updateSubscriptionStatus($id, $value);
            $data['success'] = true;
            $data['message'] = 'Record updated successfully.';
            header("Location:".BASE_URL."cms#/email_subscribers");
            exit;
        }
        exit();
    }

    //Function to change banner status
    public function ajaxBannerStatusChange() {
        //print_r(PageContext::$request);
        $id = PageContext::$request['id'];
        $value = PageContext::$request['value'];
        if ($id > 0) {
            $updateVal = Cmshelper::updateBannerStatus($id, $value);
            $data['success'] = true;
             $data['message'] = 'Banner updated successfully!';
             header("Location:".BASE_URL."cms#/banners");
             //echo json_encode($data);
              exit;
        }
        exit();
    }

    //Function to change testimonial status
    public function ajaxTestimonialStatusChange() {
        //print_r(PageContext::$request);
        $id     = PageContext::$request['id'];
        $value  = PageContext::$request['value'];
        if ($id > 0) {
            $updateVal        = Cmshelper::updateTestimonialStatus($id, $value);
            $data['success']  = true;
            $data['message']  = 'Testimonial updated successfully!';
            header("Location:".BASE_URL."cms#/testimonials");
            //echo json_encode($data);
            exit;
        }
        exit();
    }

    //Function to change homepage cms status
    public function ajaxHomepageCmsStatusChange() {
        //print_r(PageContext::$request);
        $id     = PageContext::$request['id'];
        $value  = PageContext::$request['value'];
        if ($id > 0) {
            $updateVal        = Cmshelper::updateHomepageCmsStatus($id, $value);
            $data['success']  = true;
            $data['message']  = 'CMS updated successfully!';
            header("Location:".BASE_URL."cms#/static_content");
            //echo json_encode($data);
            exit;
        }
        exit();
    }

     public function ajaxUserStatusChange() {
        //print_r(PageContext::$request);
        $id = PageContext::$request['id'];
        $value = PageContext::$request['value'];
        if ($id > 0) {
            $updateVal = Cmshelper::updateUserStatus($id, $value);
             $data['success'] = true;
             $data['message'] = 'Record updated successfully.';
             header("Location:".BASE_URL."cms#/booster");
        }
        exit();
    }

    //Function to change content stats status
    public function ajaxContentStatusChange() {
        //print_r(PageContext::$request);
        $id = PageContext::$request['id'];
        $value = PageContext::$request['value'];
        if ($id > 0) {
             $updateVal = Cmshelper::updateContentStatus($id, $value);
             $parent_id = Cmshelper::getParentOfContentItem($id);
             $data['success'] = true;
             $data['message'] = 'Record added successfully.';
             header("Location:".BASE_URL."cms#/pageCategories/&parent_section=pageCategories&parent_id=".$parent_id."&section=pageContent");
        }
        exit();
    }

    //Function to change pagecategory status
    public function ajaxPageCategoryStatusChange() {
        //print_r(PageContext::$request);
        $id = PageContext::$request['id'];
        $value = PageContext::$request['value'];
        if ($id > 0) {
             $updateVal = Cmshelper::updatePageCategoryStatus($id, $value);
             $parent_id = Cmshelper::getParentOfCategoryItem($id);
             $data['success'] = true;
             $data['message'] = 'Record updated successfully.';
             //header("Location:".BASE_URL."cms#/pageSection");
             header("Location:".BASE_URL."cms#/pageCategories/&parent_section=pageCategories&parent_id=".$parent_id."&section=pageCategories");
        }
        exit();
    }

    //Function to change Category status
    public function ajaxCategoryStatusChange() {
        $id = PageContext::$request['id'];
        $value = PageContext::$request['value'];
        if ($id > 0) {
            $updateVal = Cmshelper::updateCategoryStatus($id, $value);
             $data['success'] = true;
             $data['message'] = 'Record added successfully.';
             header("Location:".BASE_URL."cms#/pageSection");
        }
        exit();
    }
     //Function to change menu status
    public function ajaxMenuStatusChange() {
        print_r(PageContext::$request);
        $id = PageContext::$request['id'];
        $value = PageContext::$request['value'];
        if ($id > 0) {
            $updateVal = Cmshelper::updateMenuStatus($id, $value);
            $data['success'] = true;
             $data['message'] = 'Record updated successfully.';
             header("Location:".BASE_URL."cms#/menu");
             //echo json_encode($data);
              exit;
        }
        exit();
    }

  //Function to change menuitem status
    public function ajaxMenuItemStatusChange(){
        print_r(PageContext::$request);
        $id = PageContext::$request['id'];
        $value = PageContext::$request['value'];
        if ($id > 0) {
              $updateVal  = Cmshelper::updateMenuItemStatus($id, $value);
              $parent_id  = Cmshelper::getParentOfMenuItem($id);
              $data['success'] = true;
              $data['message'] = 'Record updated successfully.';
              header("Location:".BASE_URL."cms#/menu/&parent_section=menu&parent_id=".$parent_id."&section=menu_items");
              exit;
        }
        exit();
    }

    //TokenInput sample
    public function ajaxTagTest() {
//         print_r(PageContext::$request);
        $id = PageContext::$request['id'];
        $value = PageContext::$request['q'];

        $db     = new Db();
    $getAllPlans1 = $db->selectResult('conference','*'," conference_name LIKE '%$value%' ");
    foreach($getAllPlans1 as $plan) {
        $dataArray[] = array('id' => $plan->conference_id,
            'name' => ucwords($plan->conference_name)
        );
    }
      echo json_encode($dataArray);
        exit();
    }

    /**
     * Mail Status
     */
    public function mailStatusChange(){

      $id = PageContext::$request['id'];
      $changestat=Cmshelper::markRead($id);

    }

}
?>
