<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
class Cmshelper {
  const SMB_UPGRADE_BUTTON_TEXT = 'Change Plan';
  const SMB_ADD_CREDIT_TEXT = 'Add';

    public static function bindSiteLogo(){
        $content = '<img class="img-logo" alt="'.SITE_NAME.'" src="'.Cmshelper::getSiteLogo().'" />';
        return $content;
    }

    public static function getImageContent($pId){
        $db       = new Db();
        $contents = $db->selectRow('files',"file_path","file_id='$pId'");
        return $contents;
    }

    public static function getSettingsValueByName($settingsName){
        $db       = new Db();
        $contents = $db->selectRow('lookup',"vLookUp_Value","vLookUp_Name='$settingsName'");
        return $contents;
    }

    public static function getSiteLogo(){
        $dbh          = new Db();
        $logoDetails  = $dbh->selectRecord("lookup_cms", "value"," settingfield='sitelogo'");
        $siteLogo     = BASE_URL.'project/files/'.$logoDetails->value;
        if($logoDetails->value == '' && (!file_exists('project/files/'.$logoDetails->value))){
            $logoDetails  = $dbh->selectRecord("cms_settings", "cms_set_value"," cms_set_name='admin_logo'");
            $siteLogo     =  BASE_URL.$logoDetails->cms_set_value;
        }
        return $siteLogo;
    }

    public static function getCmsDataSettings(){
        $dbh 	 = new Db();
        $tableprefix    =   $dbh->tablePrefix;
        $res        = $dbh->execute("SELECT cms_set_name,cms_set_value from  ".$tableprefix."cms_settings  ");
        $settings   =   $dbh->fetchAll($res);
        $cmsSettings = array();
        foreach($settings as $setting) {
            $cmsSettings[$setting->cms_set_name] = $setting->cms_set_value;

        }
        return $cmsSettings;
    }

    public static function getStaticContent($alias){
        $db       = new Db();
        $contents = $db->selectResult('contents',"*"," cnt_alias='$alias'");
        $data     = array();
        if($contents){
            foreach ($contents as $key => $value) {
                $data['cnt_title']    = $value->cnt_title;
                $data['cnt_content']  = $value->cnt_content;
            }
        }
        return $data;
    }

    public static function getAllActiveTestimonials(){
      $db       = new Db();
      $data     = $db->selectResult("testimonials AS T LEFT JOIN tbl_files AS F ON F.	file_id = T.testi_image_1","T.*,F.file_path as testi_image"," 1=1 AND T.status = 'Y' ORDER BY T.testi_id DESC LIMIT 10");
      return $data;
    }

    public static function getBanners(){
        $db       = new Db();
        $contents = $db->selectResult('banners',"*"," banner_status=1");
        $data     = array();
        if($contents){
            foreach ($contents as $key => $value) {
                $data[] = array(
                            'banner_name'     => $value->banner_name,
                            'banner_title'    => $value->banner_title,
                            'banner_content'  => $value->banner_content,
                            'banner_image'    => self::getImageContent(round($value->banner_image_id1))
                );
            }
        }
        return $data;
    }

    public static function fetchRecentFeedback(){
        $db     = new Db();
        $loopCount = 0;
        $feedbackList  = $db->selectResult("feedbacks","*"," 1  ORDER BY feedback_id DESC LIMIT 5");
        foreach($feedbackList as $user){ //echopre($user);
            $userDetails                =   new stdClass();
            $userDetails->feedback_id   =   $user->feedback_id;
            //$userDetails->firstName   =   '<a href="'.BASE_URL.'cmshelper/popupfeedbackinfo?id='.$user->feedback_id.'" class="jqPopupLink btn btn-link" id="link_50">'.$user->firstName.'</a>';
            $userDetails->firstName     =   $user->firstName;
            $userDetails->lastName      =   $user->lastName;
            $userDetails->emailId       =   $user->emailId;
            $userDetails->phone         =   $user->phone;
            $userDetails->city          =   $user->city;
            $userDetails->subject       =   $user->subject;
            $userDetails->feedback_date =   date("m/d/Y",strtotime($user->feedback_date));
            $feedbackList[$loopCount]   =   $userDetails;
            $loopCount++;
        }
        //echopre($userDetailsList);
        return $feedbackList;
    }

    public static function fetchRecentSubscribers(){
        $db     = new Db();
        $loopCount = 0;
        $subscribersList  = $db->selectResult("newsletter_subscribers","*"," 1 AND `vStatus` = 'Y' ORDER BY vSubscriberId DESC LIMIT 5");
        foreach($subscribersList as $user){ //echopre($user);
            $userDetails                =   new stdClass();
            $userDetails->vSubscriberId =   $user->vSubscriberId;
            //$userDetails->firstName   =   '<a href="'.BASE_URL.'cmshelper/popupfeedbackinfo?id='.$user->feedback_id.'" class="jqPopupLink btn btn-link" id="link_50">'.$user->firstName.'</a>';
            $userDetails->vEmail        =   $user->vEmail;
            $userDetails->vJoinedOn     =   date("m/d/Y",strtotime($user->vJoinedOn));
            $subscribersList[$loopCount]   =   $userDetails;
            $loopCount++;
        }
        //echopre1($subscribersList);
        return $subscribersList;
    }

    public static function updateSettings($data) {
        $db = new Db();
        if (is_array($data) && !empty($data)) {
            foreach ($data as $field => $val) {
                $db->updateFields("lookup", array('vLookUp_Value' => $val), "vLookUp_Name = '$field'");
            }
        }
        return true;
    }

    public static function createTags($postedArray){
        return $postedArray;
        exit;
    }



    public static function checkIfNewsletterExistByAdmin($vSendDate,$vNewsletterId = ''){
  		if(empty($vSendDate)){
  			return 0;
  		}
  		$tableName                      = 'newsletters';
  		$db                             = new db();

  		if($vNewsletterId){
  			   $andCase  = ' AND `vNewsletterId` != "'.Utils::escapeString($vNewsletterId).'"';
  	  }else{
            $andCase = "";
      }
  		$result = $db->selectRow($tableName,'count(vNewsletterId)',"`vSendDate` = '".Utils::escapeString($vSendDate)."' ".$andCase);
  		//echopre($result); die();
  		return $result;
  	}

    public static function checkIfEmailSubscribedByUser($vEmail,$vSubscriberId = ''){
  		if(empty($vEmail)){
  			return 0;
  		}
  		$tableName                      = 'newsletter_subscribers';
  		$db                             = new db();

  		if($vSubscriberId){
  			   $andCase  = ' AND `vSubscriberId` != "'.Utils::escapeString($vSubscriberId).'"';
  	  }else{
            $andCase = "";
      }
  		$result = $db->selectRow($tableName,'count(vSubscriberId)',"LOWER(`vEmail`) = '".strtolower(Utils::escapeString($vEmail))."' ".$andCase);
  		//echopre($result); die();
  		return $result;
  	}

    // public static function checkIfNewsletterExistForDayByAdd($postedArray)
    // {
    //      $time = substr( $postedArray["vSendDate"],4,11);

    //    echo  $vSendDate = date("Y-m-d", $time);
    //    die();

       public static function checkIfNewsletterExistForDayByAdd($postedArray){
     
          $time = substr( $postedArray["vSendDate"],4,11);
          
          $vSendDate = date("Y-m-d", strtotime($time));
      


    		if(self::checkIfNewsletterExistByAdmin($vSendDate,$postedArray['vNewsletterId']) > 0){
    			$postedArray['error'] 				= 'ERROR';
    			$postedArray['errormessage'] 	= 'Newsletter is already added for the selected date!';
    		}
        
    		return $postedArray;
  	}

    public static function checkIfNewsletterExistForDayByEdit($postedArray){
        $time = strtotime("+330 minutes",strtotime($postedArray["vSendDate"]));
        $vSendDate = date("Y-m-d", $time);
    		if(self::checkIfNewsletterExistByAdmin($vSendDate,$postedArray['vNewsletterId']) > 0){
    			$postedArray['error'] 				= 'ERROR';
    			$postedArray['errormessage'] 	= 'Newsletter is already added for the selected date!';
    		}
    		return $postedArray;
  	}

    public static function checkIfEmailSubscribedByEdit($postedArray){ //echopre($postedArray);
    		if(self::checkIfEmailSubscribedByUser($postedArray['vEmail'],$postedArray['vSubscriberId']) > 0){
    			$postedArray['error'] 				= 'ERROR';
    			$postedArray['errormessage'] 	= 'Email ID is already subscribed!';
    		}
    		return $postedArray;
  	}

    public static function validateForUniqueGroupName($postedArray){
    		if(self::checkIfGroupNameExistByAdmin($postedArray['group_name'],$postedArray['id']) > 0){
    			$postedArray['error'] 				= 'ERROR';
    			$postedArray['errormessage'] 	= 'Group name is already exists!';
    		}
    		return $postedArray;
  	}

    public static function checkIfGroupNameExistByAdmin($group_name,$group_id = ''){
    		$db                             = new db();
    		if($group_id){
    			   $andCase  = ' AND `id` != "'.Utils::escapeString($group_id).'"';
    	  }else{
              $andCase = "";
        }
        $query  = "SELECT count(id) as total_count FROM `cms_groups` WHERE `group_name` = '".$group_name."' ".$andCase;
        $res    = $db->execute($query);
        $row    = $db->fetchRow($res);
        return $row->total_count;
  	}

    public static function checkIfMenuItemsExistsUnderGroup($postedArray){   //Custom delete function      
    		if(self::checkIfMenuItemsExistsUnderGroupByAdmin($postedArray["id"]) > 0){
    			$postedArray['error'] 				= 'ERROR';
    			$postedArray['errormessage'] 	= 'Menu item(s) exists under the group and can\'t be deleted!';
    		}
    		return $postedArray;
  	}

    public static function checkIfMenuItemsExistsUnderGroupByAdmin($group_id){
    		$db                             = new db();
        $query  = "SELECT count(group_id) as total_count FROM `cms_sections` WHERE `group_id` = '".$group_id."'";
        $res    = $db->execute($query);
        $row    = $db->fetchRow($res);
        return $row->total_count;
  	}

    public static function fetchRecentUsers(){
        $db     = new Db();
        $loopCount = 0;
        $userList  = $db->selectResult("users AS U LEFT JOIN tbl_smb_account AS A ON U.user_id=A.smb_owner_id","U.*,A.smb_name,A.smb_acc_id"," 1  ORDER BY U.user_id DESC LIMIT 5");
        foreach($userList as $user) {
        //   echopre($user);
            $userDetails             =   new stdClass();

            $userDetails->user_email    =   '<a href="'.BASE_URL.'cmshelper/popupUserinfo?id='.$user->user_id.'" class="jqPopupLink btn btn-link" id="link_50">'.$user->user_email.'</a>';
            $userDetails->user_fname    =   $user->user_fname ;
            $userDetails->user_lname    =   $user->user_lname;
            $userDetails->smb_name      =   '<a href="'.BASE_URL.'cmshelper/popupsmbinfo?id='.$user->smb_acc_id.'" class="jqPopupLink btn btn-link" id="link_50">'.$user->smb_name.'</a>';
            $userDetails->user_joinedon =   date("m/d/Y",strtotime($user->user_joinedon));
            $userDetailsList[$loopCount]=   $userDetails;
            $loopCount++;
        }
       // echopre($userDetailsList);
        return $userDetailsList;
    }

    public static function fetchOrders($array)
    {

     //echopre($array);

        extract($array);
        $db                    =   new Db();


        $role_id = $_SESSION['cms_role_id'];
        $condtion = '';


        $page = ($page)?$page:1;


        $perPageSize = ($perPageSize)?$perPageSize:8;

        $INDEX = 0;
        $NUMBER = 0;
        if($page)
        {
            $INDEX = ($page-1)*$perPageSize;
            $NUMBER = $perPageSize;

            $limit = "LIMIT $INDEX, $NUMBER ";
        }

        $orderby = "ORDER BY order_id DESC";
        if($orderType)
        {

            $orderby = "ORDER BY $orderField $orderType";

        }


          if($role_id==11 || $role_id==35)
        {

   $userSession = json_decode($_SESSION['default_kb_user'],TRUE);
   //echopre1($userSession);
   $salesrep_id = $userSession['salesrep_id'];


            $condtion = "AND tbl_orders.salesrep_id = '$salesrep_id'";
        }




        if($array['searchText']!='')
        {
            if($searchField == 'salesrep_id')
            {
                $condtion.= "AND external2.salesrep_email LIKE '%$searchText%' ";
            }

            if($searchField == 'campaign_name')
            {

                $condtion.= "AND tbl_orders.campaign_name LIKE '%$searchText%' ";
            }
             if($searchField == 'payment_amount')
            {

                $condtion.= "AND tbl_orders.payment_amount LIKE '%$searchText%' ";
            }


            if($searchField=='ALL')
            {

               $condtion.= "AND (external2.salesrep_email LIKE '%$searchText%' OR tbl_orders.campaign_name LIKE '%$searchText%'
                   OR tbl_orders.payment_amount LIKE '%$searchText%')";
            }





           // $condtion.= "AND $searchField = '$searchText' ";
        }





        $query = "SELECT tbl_orders.order_id, external2.salesrep_email AS salesrep_id,tbl_orders.campaign_name,tbl_orders.contract_type,
            external4.lead_email AS lead_id,tbl_orders.payment_amount,tbl_orders.purchase_date,tbl_orders.order_status,
            tbl_orders.payemnt_status,tbl_orders.order_decription FROM tbl_orders
            LEFT JOIN tbl_salesrep AS external2 ON external2.salesrep_id=tbl_orders.salesrep_id
            LEFT JOIN tbl_campaign_leads AS external4 ON external4.lead_id=tbl_orders.lead_id WHERE 1 $condtion  $orderby $limit";
       // echo $query;
        $data = $db->selectQuery($query);
        return $data;




    }

    public static function fetchOrdersCount($array)
    {
        $db                    =   new Db();


      // echopre($array);

        extract($array);
         $role_id = $_SESSION['cms_role_id'];
        $condtion = '';



          if($role_id==11 || $role_id==35)
        {

   $userSession = json_decode($_SESSION['default_kb_user'],TRUE);
   //echopre1($userSession);
   $salesrep_id = $userSession['salesrep_id'];


            $condtion = "AND tbl_orders.salesrep_id = '$salesrep_id'";
        }





          if($array['searchText']!='')
        {
            if($searchField == 'salesrep_id')
            {
                $condtion.= "AND external2.salesrep_email LIKE '%$searchText%' ";
            }

            if($searchField == 'campaign_name')
            {

                $condtion.= "AND tbl_orders.campaign_name LIKE '%$searchText%' ";
            }
             if($searchField == 'payment_amount')
            {

                $condtion.= "AND tbl_orders.payment_amount LIKE '%$searchText%' ";
            }

             if($searchField=='ALL')
            {

               $condtion.= "AND (external2.salesrep_email LIKE '%$searchText%' OR tbl_orders.campaign_name LIKE '%$searchText%'
                   OR tbl_orders.payment_amount LIKE '%$searchText%')";
            }


           // $condtion.= "AND $searchField = '$searchText' ";
        }


        $query = "SELECT tbl_orders.order_id, external2.salesrep_email AS salesrep_id,tbl_orders.campaign_name,
            external4.lead_email AS lead_id,tbl_orders.payment_amount,tbl_orders.purchase_date,tbl_orders.order_status,
            tbl_orders.payemnt_status,tbl_orders.order_decription FROM tbl_orders
            LEFT JOIN tbl_salesrep AS external2 ON external2.salesrep_id=tbl_orders.salesrep_id
            LEFT JOIN tbl_campaign_leads AS external4 ON external4.lead_id=tbl_orders.lead_id WHERE 1 $condtion";
       // echo $query;
        $data = $db->selectQuery($query);
        //echopre(count($data));
        return count($data);

    }


    public static function fetchMyProfile()
    {

          $db                    =   new Db();
         $role_id = $_SESSION['cms_role_id'];

            if($role_id==11 || $role_id==35)
        {

   $userSession = json_decode($_SESSION['default_kb_user'],TRUE);
   //echopre1($userSession);
   $salesrep_id = $userSession['salesrep_id'];


            $condtion = "AND tbl_salesrep.salesrep_id = '$salesrep_id'";
        }


         $query = "SELECT tbl_salesrep.salesrep_id,tbl_salesrep.salesrep_fname,tbl_salesrep.salesrep_lname,
             tbl_salesrep.salesrep_email,tbl_salesrep.salesrep_address,tbl_salesrep.salesrep_status,
             tbl_salesrep.salesrep_address,tbl_salesrep.salesrep_pincode, external9.state_name AS salesrep_state,
             tbl_salesrep.salesrep_joinedon, external11.file_id AS salesrep_photo_id,tbl_salesrep.salesrep_phone
             FROM tbl_salesrep LEFT JOIN tbl_us_states AS external9 ON external9.state_abbr=tbl_salesrep.salesrep_state
             LEFT JOIN tbl_files AS external11 ON external11.file_id=tbl_salesrep.salesrep_photo_id WHERE 1 $condtion";

          $data = $db->selectQuery($query);
         // echo $query;
          return $data;

    }

     public static function fetchMyProfileCount()
    {
         $db                    =   new Db();

         $role_id = $_SESSION['cms_role_id'];

            if($role_id==11 || $role_id==35)
        {

   $userSession = json_decode($_SESSION['default_kb_user'],TRUE);
   //echopre1($userSession);
   $salesrep_id = $userSession['salesrep_id'];


            $condtion = "AND tbl_salesrep.salesrep_id = '$salesrep_id'";
        }


         $query = "SELECT tbl_salesrep.salesrep_id,tbl_salesrep.salesrep_fname,tbl_salesrep.salesrep_lname,
             tbl_salesrep.salesrep_email,tbl_salesrep.salesrep_address,tbl_salesrep.salesrep_status,
             tbl_salesrep.salesrep_address,tbl_salesrep.salesrep_pincode, external9.state_name AS salesrep_state,
             tbl_salesrep.salesrep_joinedon, external11.file_id AS salesrep_photo_id,tbl_salesrep.salesrep_phone
             FROM tbl_salesrep LEFT JOIN tbl_us_states AS external9 ON external9.state_abbr=tbl_salesrep.salesrep_state
             LEFT JOIN tbl_files AS external11 ON external11.file_id=tbl_salesrep.salesrep_photo_id WHERE 1 $condtion";

          $data = $db->selectQuery($query);

          return count($data);

    }


     public static  function getOrderCount($id){

               // return  $id;

          $db  =   new Db();

          $role_id = $_SESSION['cms_role_id'];

          if($role_id==11 || $role_id==35)
          {

            $userSession = json_decode($_SESSION['default_kb_user'],TRUE);
            //echopre1($userSession);
            $salesrep_id = $userSession['salesrep_id'];


            //$condtion = "AND tbl_salesrep.salesrep_id = '$salesrep_id'";
            $query="SELECT * FROM tbl_order_details where school_id='$id' and salesrep_id= '$salesrep_id'";

          }else{

            $query="SELECT * FROM tbl_order_details where school_id='$id' ";

          }

          //$query="SELECT * FROM tbl_order_details where school_id='$id' and salesrep_id= '$salesrep_id'";
          $data = $db->selectQuery($query);

          //return count($data);
          //$param="parent_section=school&parent_id=$id&section=school_order";
          //$href = count($data). "&nbsp;<a href='".BASE_URL."cms?$param>Manage</a>";
          $href = count($data)."&nbsp;<a href='".BASE_URL."cms#/school_orders&parent_section=school&parent_id=".$id."' >Manage</a>";



           return $href;
        //  <a href="http://localhost/SalesAutomationTool/cms?parent_section=school&amp;parent_id=1&amp;section=school_orders">Manage</a>



        }

    public static function getOrderSection1(){
         $url =  BASE_URL.'cms#/recent_orders';
        return $url;
    }

    public static function getOrderSection2(){
         $url =  BASE_URL.'cms#/expiring_orders';
        return $url;
    }

    public static function getOrderSection3(){
         $url =  BASE_URL.'cms#/salerep';
        return $url;
    }

    public static function getOrderSection4(){
         $url =  BASE_URL.'cms#/orders';
        return $url;
    }

    public static function getOrderSection5(){
         $url =  BASE_URL.'cms#/school';
        return $url;
    }

    public static function getOrderSection6(){
         $url =  BASE_URL.'cms#/recent_orders';
        return $url;
    }



     public static  function fetchRecentOrders()
    {

         $db                    =   new Db();
         $role_id = $_SESSION['cms_role_id'];
        $condtion = '';

        if($role_id==11 || $role_id==35)
        {

   $userSession = json_decode($_SESSION['default_kb_user'],TRUE);
   //echopre1($userSession);
   $salesrep_id = $userSession['salesrep_id'];


            $condtion = "AND external2.salesrep_id = '$salesrep_id'";
        }

        $query =  "SELECT tbl_order_details.od_id, external2.campaign_name AS order_id, external3.plan_name AS plan_id, external4.school_name AS school_id, external5.salesrep_fname AS salesrep_id, external6.slot_name AS slot_id,DATE_FORMAT(tbl_order_details.campaign_start_date,'%m/%d/%Y') AS campaign_start_date,DATE_FORMAT(tbl_order_details.campaign_end_date,'%m/%d/%Y') AS campaign_end_date,tbl_order_details.od_item_amount,tbl_order_details.od_share_voice,DATE_FORMAT(tbl_order_details.od_created_on,'%m/%d/%Y') AS od_created_on,tbl_order_details.plan_period,tbl_order_details.odd_status
FROM tbl_order_details
LEFT JOIN tbl_orders AS external2 ON external2.order_id=tbl_order_details.order_id
LEFT JOIN tbl_plans AS external3 ON external3.plan_id=tbl_order_details.plan_id
LEFT JOIN tbl_school AS external4 ON external4.school_id=tbl_order_details.school_id
LEFT JOIN tbl_salesrep AS external5 ON external5.salesrep_id=tbl_order_details.salesrep_id
LEFT JOIN tbl_slot AS external6 ON external6.slot_id=tbl_order_details.slot_id
JOIN tbl_orders AS reference ON tbl_order_details.order_id=reference.order_id
WHERE 1 $condtion ORDER BY od_created_on DESC limit 0,10";


        $data = $db->selectQuery($query);
        return $data;


    }

 public static  function fetchRecentExpiringOrders()
    {

         $db                    =   new Db();
         $role_id = $_SESSION['cms_role_id'];
        $condtion = '';








        if($role_id==11 || $role_id==35)
        {

   $userSession = json_decode($_SESSION['default_kb_user'],TRUE);
   //echopre1($userSession);
   $salesrep_id = $userSession['salesrep_id'];


            $condtion = "AND external2.salesrep_id = '$salesrep_id'";
        }

        $query =  "SELECT tbl_order_details.od_id, external2.campaign_name AS order_id, external3.plan_name AS plan_id, external4.school_name AS school_id, external5.salesrep_fname AS salesrep_id, external6.slot_name AS slot_id,DATE_FORMAT(tbl_order_details.campaign_start_date,'%m/%d/%Y') AS campaign_start_date,DATE_FORMAT(tbl_order_details.campaign_end_date,'%m/%d/%Y') AS campaign_end_date,tbl_order_details.od_item_amount,tbl_order_details.od_share_voice,DATE_FORMAT(tbl_order_details.od_created_on,'%m/%d/%Y') AS od_created_on,tbl_order_details.plan_period,tbl_order_details.odd_status
FROM tbl_order_details
LEFT JOIN tbl_orders AS external2 ON external2.order_id=tbl_order_details.order_id
LEFT JOIN tbl_plans AS external3 ON external3.plan_id=tbl_order_details.plan_id
LEFT JOIN tbl_school AS external4 ON external4.school_id=tbl_order_details.school_id
LEFT JOIN tbl_salesrep AS external5 ON external5.salesrep_id=tbl_order_details.salesrep_id
LEFT JOIN tbl_slot AS external6 ON external6.slot_id=tbl_order_details.slot_id
JOIN tbl_orders AS reference ON tbl_order_details.order_id=reference.order_id
WHERE 1 $condtion ORDER BY campaign_end_date ASC limit 0,10";


        $data = $db->selectQuery($query);
        return $data;


    }

       public static  function fetchExpiringOrders($array)
    {

         $db                    =   new Db();
         $role_id = $_SESSION['cms_role_id'];
         extract($array);

         $condtion = '';



         $page = ($page)?$page:1;


        $perPageSize = ($perPageSize)?$perPageSize:8;

        $INDEX = 0;
        $NUMBER = 0;
        if($page)
        {
            $INDEX = ($page-1)*$perPageSize;
            $NUMBER = $perPageSize;

            $limit = "LIMIT $INDEX, $NUMBER ";
        }

        $orderby = "ORDER BY campaign_end_date ASC";
        if($orderType)
        {

            $orderby = "ORDER BY $orderField $orderType";

        }

       if($role_id==11 || $role_id==35)
        {

   $userSession = json_decode($_SESSION['default_kb_user'],TRUE);
   //echopre1($userSession);
   $salesrep_id = $userSession['salesrep_id'];


            $condtion = "AND external2.salesrep_id = '$salesrep_id'";
        }

           if($array['searchText']!='')
        {
            if($searchField == 'plan_id')
            {
                $condtion.= "AND external3.plan_name LIKE '%$searchText%' ";
            }

            if($searchField == 'school_id')
            {

                $condtion.= "AND external4.school_name LIKE '%$searchText%' ";
            }
             if($searchField == 'salesrep_id')
            {

                $condtion.= "AND (external5.salesrep_fname LIKE '%$searchText%' OR external5.salesrep_lname LIKE '%$searchText%')";
            }
             if($searchField == 'slot_id')
            {

                $condtion.= "AND external6.slot_name LIKE '%$searchText%' ";
            }

            if($searchField=='ALL')
            {

               $condtion.= "AND (external6.slot_name LIKE '%$searchText%' OR external5.salesrep_fname LIKE '%$searchText%'
                  OR external5.salesrep_lname LIKE '%$searchText%'  OR external4.school_name  LIKE '%$searchText%' OR external3.plan_name  LIKE '%$searchText%')";
            }





           // $condtion.= "AND $searchField = '$searchText' ";
        }







        $query =  "SELECT tbl_order_details.od_id, external2.campaign_name AS order_id, external3.plan_name AS plan_id, external4.school_name AS school_id, external5.salesrep_fname AS salesrep_id, external6.slot_name AS slot_id,tbl_order_details.campaign_start_date AS campaign_start_date,tbl_order_details.campaign_end_date AS campaign_end_date,tbl_order_details.od_item_amount,tbl_order_details.od_share_voice,tbl_order_details.od_created_on AS od_created_on,tbl_order_details.plan_period,tbl_order_details.odd_status
FROM tbl_order_details
LEFT JOIN tbl_orders AS external2 ON external2.order_id=tbl_order_details.order_id
LEFT JOIN tbl_plans AS external3 ON external3.plan_id=tbl_order_details.plan_id
LEFT JOIN tbl_school AS external4 ON external4.school_id=tbl_order_details.school_id
LEFT JOIN tbl_salesrep AS external5 ON external5.salesrep_id=tbl_order_details.salesrep_id
LEFT JOIN tbl_slot AS external6 ON external6.slot_id=tbl_order_details.slot_id
JOIN tbl_orders AS reference ON tbl_order_details.order_id=reference.order_id
WHERE 1 $condtion $orderby $limit";

     // echo $query;
        $data = $db->selectQuery($query);
        return $data;


    }

       public static  function fetchExpiringOrdersCount($array)
    {

         $db                    =   new Db();
         $role_id = $_SESSION['cms_role_id'];
        $condtion = '';



        extract($array);



         $orderby = "ORDER BY campaign_end_date ASC";
        if($orderType)
        {

            $orderby = "ORDER BY $orderField $orderType";

        }





        if($role_id==11 || $role_id==35)
        {

   $userSession = json_decode($_SESSION['default_kb_user'],TRUE);
   //echopre1($userSession);
   $salesrep_id = $userSession['salesrep_id'];


            $condtion = "AND external2.salesrep_id = '$salesrep_id'";
        }




             if($array['searchText']!='')
        {
            if($searchField == 'plan_id')
            {
                $condtion.= "AND external3.plan_name LIKE '%$searchText%' ";
            }

            if($searchField == 'school_id')
            {

                $condtion.= "AND external4.school_name LIKE '%$searchText%' ";
            }
             if($searchField == 'salesrep_id')
            {

                $condtion.= "AND (external5.salesrep_fname LIKE '%$searchText%' OR external5.salesrep_lname LIKE '%$searchText%')";
            }
             if($searchField == 'slot_id')
            {

                $condtion.= "AND external6.slot_name LIKE '%$searchText%' ";
            }

            if($searchField=='ALL')
            {

               $condtion.= "AND (external6.slot_name LIKE '%$searchText%' OR external5.salesrep_fname LIKE '%$searchText%'
                  OR external5.salesrep_lname LIKE '%$searchText%'  OR external4.school_name  LIKE '%$searchText%' OR external3.plan_name  LIKE '%$searchText%')";
            }





           // $condtion.= "AND $searchField = '$searchText' ";
        }







        $query =  "SELECT tbl_order_details.od_id, external2.campaign_name AS order_id, external3.plan_name AS plan_id, external4.school_name AS school_id, external5.salesrep_fname AS salesrep_id, external6.slot_name AS slot_id,DATE_FORMAT(tbl_order_details.campaign_start_date,'%m/%d/%Y') AS campaign_start_date,DATE_FORMAT(tbl_order_details.campaign_end_date,'%m/%d/%Y') AS campaign_end_date,tbl_order_details.od_item_amount,tbl_order_details.od_share_voice,DATE_FORMAT(tbl_order_details.od_created_on,'%m/%d/%Y') AS od_created_on,tbl_order_details.plan_period,tbl_order_details.odd_status
FROM tbl_order_details
LEFT JOIN tbl_orders AS external2 ON external2.order_id=tbl_order_details.order_id
LEFT JOIN tbl_plans AS external3 ON external3.plan_id=tbl_order_details.plan_id
LEFT JOIN tbl_school AS external4 ON external4.school_id=tbl_order_details.school_id
LEFT JOIN tbl_salesrep AS external5 ON external5.salesrep_id=tbl_order_details.salesrep_id
LEFT JOIN tbl_slot AS external6 ON external6.slot_id=tbl_order_details.slot_id
JOIN tbl_orders AS reference ON tbl_order_details.order_id=reference.order_id
WHERE 1 $condtion $orderby ";


        $data = $db->selectQuery($query);
        return count($data);


    }





     public static  function fetchRecentAllOrders($array)
    {

         $db                    =   new Db();
         $role_id = $_SESSION['cms_role_id'];
         extract($array);

         $condtion = '';



         $page = ($page)?$page:1;


        $perPageSize = ($perPageSize)?$perPageSize:8;

        $INDEX = 0;
        $NUMBER = 0;
        if($page)
        {
            $INDEX = ($page-1)*$perPageSize;
            $NUMBER = $perPageSize;

            $limit = "LIMIT $INDEX, $NUMBER ";
        }

        $orderby = "ORDER BY od_created_on DESC";
        if($orderType)
        {

            $orderby = "ORDER BY $orderField $orderType";

        }

         if($role_id==11 || $role_id==35)
        {

   $userSession = json_decode($_SESSION['default_kb_user'],TRUE);
   //echopre1($userSession);
   $salesrep_id = $userSession['salesrep_id'];


            $condtion = "AND external2.salesrep_id = '$salesrep_id'";
        }

           if($array['searchText']!='')
        {
            if($searchField == 'plan_id')
            {
                $condtion.= "AND external3.plan_name LIKE '%$searchText%' ";
            }

            if($searchField == 'school_id')
            {

                $condtion.= "AND external4.school_name LIKE '%$searchText%' ";
            }
             if($searchField == 'salesrep_id')
            {

                $condtion.= "AND (external5.salesrep_fname LIKE '%$searchText%' OR external5.salesrep_lname LIKE '%$searchText%')";
            }
             if($searchField == 'slot_id')
            {

                $condtion.= "AND external6.slot_name LIKE '%$searchText%' ";
            }

            if($searchField=='ALL')
            {

               $condtion.= "AND (external6.slot_name LIKE '%$searchText%' OR external5.salesrep_fname LIKE '%$searchText%'
                  OR external5.salesrep_lname LIKE '%$searchText%'  OR external4.school_name  LIKE '%$searchText%' OR external3.plan_name  LIKE '%$searchText%')";
            }





           // $condtion.= "AND $searchField = '$searchText' ";
        }







        $query =  "SELECT tbl_order_details.od_id, external2.campaign_name AS order_id, external3.plan_name AS plan_id, external4.school_name AS school_id, external5.salesrep_fname AS salesrep_id, external6.slot_name AS slot_id,tbl_order_details.campaign_start_date AS campaign_start_date,tbl_order_details.campaign_end_date AS campaign_end_date,tbl_order_details.od_item_amount,tbl_order_details.od_share_voice,tbl_order_details.od_created_on AS od_created_on,tbl_order_details.plan_period,tbl_order_details.odd_status
FROM tbl_order_details
LEFT JOIN tbl_orders AS external2 ON external2.order_id=tbl_order_details.order_id
LEFT JOIN tbl_plans AS external3 ON external3.plan_id=tbl_order_details.plan_id
LEFT JOIN tbl_school AS external4 ON external4.school_id=tbl_order_details.school_id
LEFT JOIN tbl_salesrep AS external5 ON external5.salesrep_id=tbl_order_details.salesrep_id
LEFT JOIN tbl_slot AS external6 ON external6.slot_id=tbl_order_details.slot_id
JOIN tbl_orders AS reference ON tbl_order_details.order_id=reference.order_id
WHERE 1 $condtion $orderby $limit";

     // echo $query;
        $data = $db->selectQuery($query);
        return $data;


    }

       public static  function fetchRecentAllOrdersCount($array)
    {

         $db                    =   new Db();
         $role_id = $_SESSION['cms_role_id'];
        $condtion = '';



        extract($array);



         $orderby = "ORDER BY od_created_on ASC";
        if($orderType)
        {

            $orderby = "ORDER BY $orderField $orderType";

        }





        if($role_id==11 || $role_id==35)
        {

   $userSession = json_decode($_SESSION['default_kb_user'],TRUE);
   //echopre1($userSession);
   $salesrep_id = $userSession['salesrep_id'];


            $condtion = "AND external2.salesrep_id = '$salesrep_id'";
        }




             if($array['searchText']!='')
        {
            if($searchField == 'plan_id')
            {
                $condtion.= "AND external3.plan_name LIKE '%$searchText%' ";
            }

            if($searchField == 'school_id')
            {

                $condtion.= "AND external4.school_name LIKE '%$searchText%' ";
            }
             if($searchField == 'salesrep_id')
            {

                $condtion.= "AND (external5.salesrep_fname LIKE '%$searchText%' OR external5.salesrep_lname LIKE '%$searchText%')";
            }
             if($searchField == 'slot_id')
            {

                $condtion.= "AND external6.slot_name LIKE '%$searchText%' ";
            }

            if($searchField=='ALL')
            {

               $condtion.= "AND (external6.slot_name LIKE '%$searchText%' OR external5.salesrep_fname LIKE '%$searchText%'
                  OR external5.salesrep_lname LIKE '%$searchText%'  OR external4.school_name  LIKE '%$searchText%' OR external3.plan_name  LIKE '%$searchText%')";
            }





           // $condtion.= "AND $searchField = '$searchText' ";
        }







        $query =  "SELECT tbl_order_details.od_id, external2.campaign_name AS order_id, external3.plan_name AS plan_id, external4.school_name AS school_id, external5.salesrep_fname AS salesrep_id, external6.slot_name AS slot_id,DATE_FORMAT(tbl_order_details.campaign_start_date,'%m/%d/%Y') AS campaign_start_date,DATE_FORMAT(tbl_order_details.campaign_end_date,'%m/%d/%Y') AS campaign_end_date,tbl_order_details.od_item_amount,tbl_order_details.od_share_voice,DATE_FORMAT(tbl_order_details.od_created_on,'%m/%d/%Y') AS od_created_on,tbl_order_details.plan_period,tbl_order_details.odd_status
FROM tbl_order_details
LEFT JOIN tbl_orders AS external2 ON external2.order_id=tbl_order_details.order_id
LEFT JOIN tbl_plans AS external3 ON external3.plan_id=tbl_order_details.plan_id
LEFT JOIN tbl_school AS external4 ON external4.school_id=tbl_order_details.school_id
LEFT JOIN tbl_salesrep AS external5 ON external5.salesrep_id=tbl_order_details.salesrep_id
LEFT JOIN tbl_slot AS external6 ON external6.slot_id=tbl_order_details.slot_id
JOIN tbl_orders AS reference ON tbl_order_details.order_id=reference.order_id
WHERE 1 $condtion $orderby ";


        $data = $db->selectQuery($query);
        return count($data);


    }



    public static function getFlyerUrl($id)
    {



           $db                    =   new Db();





        $checkrow = $db->selectQuery("SELECT * FROM tbl_flyer WHERE  school_id = '$id'");


        if($checkrow){
        $href = "<a href='".BASE_URL."cms?section=flyer_management&school_id=$id' target='new'>Manage Flyer</a>";
        }else{
         $href = "<a href='".BASE_URL."cms?section=flyer_management&school_id=$id' target='new'>Create Flyer</a>";
        }
        return $href;

    }

        public function insertFlyercontents($obj)
    {
          $objResult                      =   new stdClass();
          $objResult->status              =   "SUCCESS";

           $db                    =   new Db();



           $school_id = $obj->school_id;
           $position = $obj->position;

        $checkrow = $db->selectQuery("SELECT * FROM tbl_flyer WHERE position = '$position' AND school_id = '$school_id'");

        //echopre($checkrow);
   //      Insert User data to to User table
        if(!$checkrow) {

            $tableName             =   Utils::setTablePrefix('flyer');
            $customerId            =   $db->insert($tableName,
                    array(  'school_id'         =>  Utils::escapeString($obj->school_id),
                    'position'        =>  Utils::escapeString($obj->position),
                    'flyer_image_id'        =>  Utils::escapeString($obj->flyer_image_id) ));

            $objUserVo->flyer_id    =   $customerId;

            $objResult->data       =   $obj;
        }else{
            $flyer_image_id = $checkrow[0]->flyer_image_id;
             $tableName             =   Utils::setTablePrefix('flyer');
            $customerId            =   $db->update($tableName,
                    array(
                    'flyer_image_id'        =>  Utils::escapeString($obj->flyer_image_id) ),"flyer_image_id = '$flyer_image_id'");

            $objUserVo->flyer_id    =   $customerId;

            $objResult->data       =   $obj;
        }
        return $objResult;

    }



    public static function fetchRecentTransactions() {

        $db     = new Db();
        $loopCount = 0;
        $join1 = " LEFT JOIN tbl_smb_account AS A ON A.smb_owner_id=T.tr_created_by";
        $transactions  = $db->selectResult("transactions AS T LEFT JOIN tbl_users AS U ON T.tr_created_by=U.user_id ".$join1,"T.*,A.smb_name,A.smb_acc_id,U.user_email"," 1   ORDER BY T.tr_id DESC LIMIT 5");
        foreach($transactions as $transact) {
            $transactDetails             =   new stdClass();
            // echopre($transact);
            // <button value="http://localhost/reservelogic/cmshelper/inquiryuserdetailspopup?id=50" class="jqPopupLink btn btn-link" id="link_50">erwe</button>
            $transactDetails->tr_details  =   $transact->tr_details;
            //$transactDetails->smb_name  =   $transact->smb_name;
            $transactDetails->smb_name      =   '<a href="'.BASE_URL.'cmshelper/popupsmbinfo?id='.$transact->smb_acc_id.'" class="jqPopupLink btn btn-link" id="link_50">'.$transact->smb_name.'</a>';
            $transactDetails->user_email      =   '<a href="'.BASE_URL.'cmshelper/popupUserinfo?id='.$transact->tr_created_by.'" class="jqPopupLink btn btn-link" id="link_50">'.$transact->user_email.'</a>';

           // $transactDetails->user_email  =   $transact->user_email;
            //$transactDetails->tr_uemail      =   '<a href="'.BASE_URL.'cmshelper/inquiryuserdetailspopup?id='.$enquiry->nEnq_Id.'" class="jqPopupLink btn btn-link" id="link_50">'.$transact->user_email.'</a>';
            $transactDetails->tr_amount     =   $transact->tr_amount;
            $transactDetails->tr_created_on =   date("m/d/Y",strtotime($transact->tr_created_on));
            $transactList[$loopCount]   =   $transactDetails;
            $loopCount++;
        }
        return $transactList;

    }



  public static function getUserNameFromSmb($smbAccid){
    $db     = new Db();
    $smbUserInfo= $db->selectRecord("users AS U LEFT JOIN tbl_smb_account AS S ON U.user_id=S.smb_owner_id", "U.user_fname,U.user_lname"," S.smb_acc_id=".$smbAccid);
    $uname = $smbUserInfo->user_fname. ' ' .$smbUserInfo->user_lname;
    //echopre($smbUserInfo);
    return  $uname;
  }


  public static function fetchSMBFromUserid($userid){
    $db     = new Db();
    $smbDetails = $db->selectRecord("smb_account", "smb_name"," smb_owner_id=".$userid);
      return $smbDetails->smb_name;
    //return addslashes('<a rel="link_'.$smbid.'" class="jqPopupLink btn btn-link" href='.BASE_URL.'cmshelper/upgradesmbaccount?id='.$smbid.'>'.$smbDetails->smb_name.'</a>');

    //  return '22 <a class="jqPopupLink" href="http://localhost/kliqbooth/cmshelper/popupUserinfo?id=13"  >111</a>';
    // return '<a href="http://localhost/kliqbooth/cmshelper/popupUserinfo?id=13" class="jqPopupLink btn btn-link" id="link_17">gdfg gdfgfd</a>';
    // return '<a rel="link_'.$userid.'" class="jqPopupLink btn btn-link" href='.BASE_URL.'cmshelper/addcredit?id='.$userid.'>123</a>';

  }

  public static function fetchSMBPlanFromId($planid){
    //return $planid;
    $db     = new Db();
    $planDetails = $db->selectRecord("plans AS P LEFT JOIN tbl_smb_account AS A ON P.plan_id=A.smb_plan", "P.plan_name,P.plan_id"," A.smb_owner_id=".$planid);
    // echo  $planDetails->plan_name;die;
        return $planDetails->plan_name;

  }


  //Fetches plans
    public static function getAllPlans($id='',$fields='plan_id,plan_name') {
        $db     = new Db();
        $getAllPlans = $db->selectResult('plans',$fields," plan_status='1'");
        $var=0;
        foreach($getAllPlans as $plan) {
            $result[$var] = new StdClass;
            $result[$var]->value = $plan->plan_id;
            $result[$var]->text = $plan->plan_name;
            $var++;
        }
        return $result;
    }

    public static function getDestinationPopupUrlLocationLink($params){
        $userPopupUrl =  BASE_URL.'cmshelper/destinationdetailspopup?id='.$locationId;
        return $userPopupUrl;
    }

    public static function getFeedbackLink(){
        $feedbackLinkUrl =  BASE_URL.'cms#/feedback';
        return $feedbackLinkUrl;
    }
    public static function getBannersLink(){
        $feedbackLinkUrl =  BASE_URL.'cms#/banners';
        return $feedbackLinkUrl;
    }
    public static function getTestimonialsLink(){
        $feedbackLinkUrl =  BASE_URL.'cms#/testimonials';
        return $feedbackLinkUrl;
    }
    public static function getSubscribersLink(){
        $feedbackLinkUrl =  BASE_URL.'cms#/email_subscribers';
        return $feedbackLinkUrl;
    }


    public static function getUserInfo($userid){
        $dbh = new Db();
        return $dbh->selectRecord("users", "user_id,user_email,user_fname,user_lname,user_joinedon AS joineddate", "user_id =".$userid );
    }

    public static function getFeedbackInfo($feedback_id) {
        $dbh = new Db();
        return $dbh->selectRecord("feedbacks", "*", "feedback_id =".$feedback_id);
    }

    public static function getSmbInfo($smbid){
        $dbh = new Db();
        return $dbh->selectRecord("smb_account", "*", "smb_acc_id =".$smbid );
    }

  public static function getUser() {

        $url =  BASE_URL.'cms?section=users';
        return $url;
    }

  public static function getTransaction() {

        $url =  BASE_URL.'cms?section=subscriptions';
        return $url;
    }

  public static function getUserPopupUrl($id) {

    $dbh = new Db();
        $userid =  $dbh->selectRow("subscription_tracker", "user_id", "st_id =".$id['id'] );

        $url =  BASE_URL.'cmshelper/popupUserinfo?id='.$userid;
        return $url;
    }
       public static function changePassword($salesrep_id, $postAarray,$cms_id) {

       // echo $id; exit;
      $dbh    =   new Db();
      if(!empty($postAarray)) {
        if($id > 0) {
          $updateQuery = "UPDATE  cms_users set  password ='".md5($postAarray['newpassword'])."' WHERE id=$cms_id";
          //echo $updateQuery; exit;
                        $res = $dbh->execute($updateQuery);
                        if($salesrep_id){
                        $updateQuery = "UPDATE  tbl_salesrep set  salesrep_password ='".md5($postAarray['newpassword'])."' WHERE salesrep_id=$salesrep_id";

                      //  echo $updateQuery; exit;
                        $res = $dbh->execute($updateQuery);
                        }

          return $res;
        }
      }

    }

    public static function getEmailSubscribersCount($startDate,$endDate,$barType = false) {
        //echo $startDate.'***'.$endDate; exit;
        //$startDate = "2018-09-06";
        //$endDate = "2018-09-13";
        $db     = new Db();
        $count  = $db->getDataCount("newsletter_subscribers","vSubscriberId"," where vStatus = 'Y' AND DATE_FORMAT(vJoinedOn,'%Y-%m-%d')>= '".$startDate."' AND DATE_FORMAT(vJoinedOn,'%Y-%m-%d') < '".$endDate."'");
        //echopre($count);
        return $count;
    }

    public static function getFeedbackCount($startDate,$endDate,$barType = false) {
     //  echo $startDate.'***'.$endDate; exit;
        $db     = new Db();
        $count  = $db->getDataCount("feedbacks","feedback_id"," where DATE_FORMAT(feedback_date,'%Y-%m-%d')>= '".$startDate."' AND DATE_FORMAT(feedback_date,'%Y-%m-%d') < '".$endDate."'");
        //echopre1($count);
        return $count;
    }

  //Fetches user registering Count
    public static function getRegisteringCount($startDate,$endDate,$barType = false) {
     //  echo $startDate.'***'.$endDate; exit;
        $db     = new Db();
        if($barType) {
            $count  = $db->getDataCount("campaign_leads","lead_id"," where DATE_FORMAT(lead_joined_on,'%Y-%m-%d') = '".$startDate."' ");
        } else {
            $count  = $db->getDataCount("users","user_id"," where user_status=1 AND DATE_FORMAT(user_joinedon,'%Y-%m-%d')>= '".$startDate."' AND DATE_FORMAT(user_joinedon,'%Y-%m-%d')< '".$endDate."'");
        }
       // echopre1($count);
        return $count;
    }

    public static function getTransactionCount($startDate,$endDate,$barType = false) {
        $db     = new Db();
        if($barType) {
             $count  = $db->getDataCount("order_details","od_id"," where DATE_FORMAT(od_created_on,'%Y-%m-%d') = '".$startDate."'");
        } else {
            $count  = $db->getDataCount("order_details","od_id"," where od_created_on BETWEEN '".$startDate."' AND  '".$endDate."'");
        }
        return $count;
    }

    public static function getTotalEmailSubscribers() {
        $db     = new Db();
        $count  = $db->getDataCount("newsletter_subscribers","vSubscriberId","WHERE `vStatus` = 'Y'");
        return $count;
    }

    public static function getTotalTestimonials() {
        $db     = new Db();
        $count  = $db->getDataCount("testimonials","testi_id","");
        return $count;
    }

    public static function getTotalBanners() {
        $db     = new Db();
        $count  = $db->getDataCount("banners","banner_id","");
        return $count;
    }

    public static function getTotalFeedbacks() {
        $db     = new Db();
        $count  = $db->getDataCount("feedbacks","feedback_id","");
        return $count;
    }

    public static function getTotalOrders() {
        $db     = new Db();
        $count  = $db->getDataCount("orders","order_id","");
        return $count;
    }

    public static function getTotalSales() {
        $db     = new Db();
        $count  = $db->getDataCount("order_details","od_id","");
        return $count;
    }

    public static function getTotalSchool() {
        $db     = new Db();
        $count  = $db->getDataCount("school","school_id","");
        return $count;
    }


      public static function getTotalLeads() {
        $db     = new Db();
        $count  = $db->getDataCount("campaign_leads","lead_id","");
        return $count;
    }


    //Fetches user registering Count
    public static function getTotalRegisteringCount($startDate,$endDate) {
     //  echo $startDate.'***'.$endDate; exit;

        $db     = new Db();
        $count  = $db->getDataCount("campaign_leads","lead_id","where lead_joined_on BETWEEN '".$startDate."' AND  '".$endDate."'");
       // echopre1($count);

        return $count;
    }


     public static function getTotalTransactionCount($startDate,$endDate) {
        $db     = new Db();
        //$count  = $db->getDataCount("transactions","tr_id"," where DATE_FORMAT(tr_created_on,'%Y-%m-%d')>= '".$startDate."' AND DATE_FORMAT(tr_created_on,'%Y-%m-%d')< '".$endDate."'");
        //echo $count.'<br>';

       // echo $startDate;
       $count  = $db->getDataCount("order_details","od_id"," where od_created_on BETWEEN '".$startDate."' AND  '".$endDate."'");
         //echo $transAmt.'<br>';

        return $count;
    }



    /*
     * Function : getListItem
     * Input : @table <table name to select>
     * Input : @fieldArr <field names as an array to select, eg : array('a', 'b', 'c')>
     * Input : @filterArr <field names as an array to supply in WHERE clause, eg : array('a', 'b', 'c')>
     * Input : @orderArr <array input 1 : sort order, array input 2: sort fields as an array eg : array('sort' => 'ASC', 'fields' => array('a', 'b', 'c'))>
     * Input : @limit <base,indent eg : 0,5 -> generate the query as LIMIT 0,5))>
    */
    public static function getListItem($table = NULL, $fieldArr = NULL, $filterArr = NULL, $orderArr = NULL, $limit = NULL, $searchArr = NULL, $join = NULL) {
        $dbObj = new Db();
        $filter = $fieldList = $order = $searchCode = $searchList = NULL;

        $data = array();
        // FIELD LIST generation like a, b, c
        if(!empty($fieldArr)) {
            foreach($fieldArr as $field) {
                $fieldList .= (!empty($fieldList)) ? ', ' : '';
                $fieldList .= (!empty($field)) ? $field : '';
            }

            // FILTER fields for where condition generation like a='xx' AND b='xx' AND c='xx'
            if(!empty($filterArr)) {
                foreach($filterArr as $filterItem) {
                    $filterCondition = (isset($filterItem['condition'])) ? $filterItem['condition'] : '=';
                    $filterInputQuotes = (isset($filterItem['inputQuotes']) && $filterItem['inputQuotes']=='N') ? $filterItem['value'] : "'".$filterItem['value']."'";
                    $filter .= (!empty($filter)) ? ' AND ' : '';
                    $filter .= (!empty($filterItem)) ? $filterItem['field']." ".$filterCondition." ".$filterInputQuotes : NULL;
                } // End Foreach
            } // End If

            // FILTER fields for where condition generation like a LIKE 'xx%' AND b LIKE 'xx%' AND c LIKE 'xx%' generally for search cases
            if(!empty($searchArr)) {
                $filter .= (!empty($filter)) ? ' AND (' : ' (';
                foreach($searchArr as $searchItem) {
                    $searchList .= (!empty($searchList)) ? ' OR ' : '';
                    $searchList .= (!empty($searchItem)) ? $searchItem['field']." LIKE '".addslashes($searchItem['value'])."%'" : NULL;
                } // End Foreach
                $filter .= $searchList;
                $filter .= (!empty($filter)) ? ' )' : '';
            } // End If

            // FILTER WITH WHERE 1 for blank entries
            $filter .= (!empty($filter)) ? "" : " 1";

            // FILTER WITH ORDER BY
            if(!empty($orderArr)) {
                $sortBy = (!empty($orderArr['sort'])) ? $orderArr['sort'] : 'ASC';
                foreach($orderArr['fields'] as $orderItem) {
                    $order .= (!empty($order)) ? ', ' : '';
                    $order .= (!empty($orderItem)) ? $orderItem : '';
                } // End Foreach
                $filter .= (!empty($order)) ? " ORDER BY ".$order." ".$sortBy : NULL;
            } // End If

            // FILTER WITH LIMIT WHERE 1
            $filter .= (!empty($limit)) ? " LIMIT ".$limit : NULL;

            $data = $dbObj->selectResult($table,$fieldList,$filter);

        } // End FieldArr


        return $data;
    } // End Function


    public static function createObjectFromPost($post,$excempt=array())
   {

       $obj = new stdClass();

       if($post)
       {

           foreach ($post  as $k=>$v)
           {
               if(!in_array($k,$excempt))
               $obj->$k = $v;

           }
       }

       return $obj;
   }

      /*
     * Function : getListItem based on the user db connection
     * Input : @table <table name to select>
     * Input : @fieldArr <field names as an array to select, eg : array('a', 'b', 'c')>
     * Input : @filterArr <field names as an array to supply in WHERE clause, eg : array('a', 'b', 'c')>
     * Input : @orderArr <array input 1 : sort order, array input 2: sort fields as an array eg : array('sort' => 'ASC', 'fields' => array('a', 'b', 'c'))>
     * Input : @limit <base,indent eg : 0,5 -> generate the query as LIMIT 0,5))>
    */
    public static function getListItemForApp($dbObj,$table = NULL, $fieldArr = NULL, $filterArr = NULL, $orderArr = NULL, $limit = NULL, $searchArr = NULL, $join = NULL) {
        $dbObj = new Db($dbObj);
        $filter = $fieldList = $order = $searchCode = $searchList = NULL;

        $data = array();
        // FIELD LIST generation like a, b, c
        if(!empty($fieldArr)) {
            foreach($fieldArr as $field) {
                $fieldList .= (!empty($fieldList)) ? ', ' : '';
                $fieldList .= (!empty($field)) ? $field : '';
            }

            // FILTER fields for where condition generation like a='xx' AND b='xx' AND c='xx'
            if(!empty($filterArr)) {
                foreach($filterArr as $filterItem) {
                    $filterCondition = (isset($filterItem['condition'])) ? $filterItem['condition'] : '=';
                    $filterInputQuotes = (isset($filterItem['inputQuotes']) && $filterItem['inputQuotes']=='N') ? $filterItem['value'] : "'".$filterItem['value']."'";
                    $filter .= (!empty($filter)) ? ' AND ' : '';
                    $filter .= (!empty($filterItem)) ? $filterItem['field']." ".$filterCondition." ".$filterInputQuotes : NULL;
                } // End Foreach
            } // End If

            // FILTER fields for where condition generation like a LIKE 'xx%' AND b LIKE 'xx%' AND c LIKE 'xx%' generally for search cases
            if(!empty($searchArr)) {
                $filter .= (!empty($filter)) ? ' AND (' : ' (';
                foreach($searchArr as $searchItem) {
                    $searchList .= (!empty($searchList)) ? ' OR ' : '';
                    $searchList .= (!empty($searchItem)) ? $searchItem['field']." LIKE '".addslashes($searchItem['value'])."%'" : NULL;
                } // End Foreach
                $filter .= $searchList;
                $filter .= (!empty($filter)) ? ' )' : '';
            } // End If

            // FILTER WITH WHERE 1 for blank entries
            $filter .= (!empty($filter)) ? "" : " 1";

            // FILTER WITH ORDER BY
            if(!empty($orderArr)) {
                $sortBy = (!empty($orderArr['sort'])) ? $orderArr['sort'] : 'ASC';
                foreach($orderArr['fields'] as $orderItem) {
                    $order .= (!empty($order)) ? ', ' : '';
                    $order .= (!empty($orderItem)) ? $orderItem : '';
                } // End Foreach
                $filter .= (!empty($order)) ? " ORDER BY ".$order." ".$sortBy : NULL;
            } // End If

            // FILTER WITH LIMIT WHERE 1
            $filter .= (!empty($limit)) ? " LIMIT ".$limit : NULL;

            $data = $dbObj->selectResult($table,$fieldList,$filter);

        } // End FieldArr


        return $data;
    } // End Function






    /*
     * function to update the admin password
     */
     public static function updateAdminPassword($userName, $postValues) {
        $db = new Db();
        $current_pass = $db->selectQuery("SELECT password FROM cms_users WHERE username ='$userName' ");
        if (trim($current_pass[0]->password) == MD5(trim($postValues['current_password']))) {
            if ($postValues['new_password'] == $postValues['retype_password']) {
                $password = $postValues['new_password'];
                $db->customQuery("UPDATE `cms_users` SET `password` = MD5('" . $password . "') WHERE `username` = '" . $userName . "'");
                // $db->customQuery("UPDATE `cms_users` SET `password` = MD5('" . mysql_real_escape_string($password) . "') WHERE `username` = '" . $userName . "'");
                $message = "success";
            } else {
                $message = "New Password and Re-Type Password do not match!";
            }
        } else {
            $message = "Incorrect Current Password!";
        }
        return $message;
    }

    public static function getUserUpgradeUrl($smbid) {
      return '<a rel="link_'.$smbid.'" class="jqPopupLink btn btn-link" href='.BASE_URL.'cmshelper/upgradesmbaccount?id='.$smbid.'>'.self::SMB_UPGRADE_BUTTON_TEXT.'</a>';


      }
  /*
   * function to show the add credit url
   */
  public static function getSmbAddCreditUrl($smbid) {
    $dbh  = new Db();
        $userCredit =  $dbh->selectRow("smb_account", "smb_avail_credit", "smb_acc_id =".$smbid );
      if($userCredit=='')
        $creditVal = '<div class="avcrditbox1">0 | </div> ';
      else
        $creditVal = '<div class="avcrditbox1">'.$userCredit.' | </div>';

    return $creditVal.'<div class="avcrditbox2"><a rel="link_'.$smbid.'" class="jqPopupLink btn btn-link" href='.BASE_URL.'cmshelper/addcredit?id='.$smbid.'>'.self::SMB_ADD_CREDIT_TEXT.'</a></div>';
    }





    /*
     * function to add new credit to the application
     */
    public static function addCreditToApp($appid,$credit){
      if($appid != '' && $credit != ''){
        $db = new Db();

      // update current credit

      $creditValue = Utils::getSettings('one_credit_value');
      $newCredit  = $creditValue * $credit;
        $db->customQuery("UPDATE `tbl_smb_account` SET `smb_avail_credit` = smb_avail_credit+".$newCredit." WHERE `smb_acc_id` = '" . $appid . "'");


        $current_user_credit =  $db->selectRow("smb_account", "smb_avail_credit", "smb_acc_id =".$appid );

        //$creditvalue = '';
        //$current_user_credit = '';

        // add new entry to credit tracker
        $date     = date("Y-m-d H:i:s");
        $arrCredits = array(  'smb_account_id'    => $appid,
                      'ct_credit_amount'    => $credit,
                      'ct_credit_status'    => '1',
                      'ct_transact_id'    => '0',
                      'ct_creditvalue'    => $newCredit,
                    'ct_current_user_credit'    => $current_user_credit,
                      'ct_created_on'     => $date,
                      'ct_created_by'     => 'admin'  );
        $res = Credits::addCredits($arrCredits);
      if($res > 0)
        echo "1";
        //addCredits
      }
    }




  /*
   * function to update a user plan
   */
  public static function updateUserPlan($smbid,$planid) {
    if($smbid!= '' && $planid != '') {
      $db = new Db();


      // add the details to subscription tracker
      $planInfo   = Plans::getPlanInfo($planid);

      $appDetails = Smbaccount::getSmbAccount($smbid);


      $planPeriod = $planInfo->plan_period;
      $date = date("Y-m-d H:i:s");
      $planEndDate =  date("Y-m-d H:i:s",strtotime($date. ' + '.$planPeriod.' days'));

      // update current plan
      $db->updateFields("smb_account", array('smb_plan' => $planid,'smb_subscription_date'=>$date,'smb_subscription_expire_date'=>$planEndDate), "smb_acc_id = '$smbid'");

    //  echopre($appDetails);
    //  echopre($planInfo);
    //  exit();
          $arrSubscription = array( 'smb_account_id'      => $smbid,
                    'st_type'         => '1',
                        'user_id'         => $appDetails->smb_owner_id,
                        'plan_id'         => $planid,
                        'st_subscription_amount'  => $planInfo->plan_amount,
                        'st_start_date'       => $date,
                        'st_expiry_date'      => $planEndDate,
                        'st_transact_id'      => '',
                        'st_status'         => '1',
                        'st_created_on'       => $date,
                        'st_created_by'       => 0  );
        $res = Subscription::addSubscription($arrSubscription);
      if($res > 0)
        echo "1";
    }
  }

  /*
   * function to load the login in url
   */
  public static function getSmbLoggedInUrl($smbid) {
        $userUrl = BASE_URL.'index/getUserLoggedInSession/'.$smbid;
        return $userUrl ;
    }


    /*
     * function invokes when admin try to add a new user
     */
    public static function createNewApp($userid){
      if($userid !='') {
        $db = new Db();
        $planId             = $_POST['smb_plan'];
        $planInfo   = Plans::getPlanInfo($planId);


        // update the user table with joined date
        $joinedDate =  date("Y-m-d H:i:s");
      $db->updateFields("users", array('user_joinedon' => $joinedDate), "user_id = '$userid'");

            if(DYNAMICDB){

          // select the APP ID of the user
          $appId    = Smbaccount::getAppIdOfUser($userid);


          // update smb account
          $planPeriod   = $planInfo->plan_period;
          $paymentAmt   = $planInfo->plan_amount;
          $planEndDate  = date("Y-m-d H:i:s",strtotime($joinedDate. ' + '.$planPeriod.' days'));

          $smbDetails = array('smb_subscription_date'     => $joinedDate,
                    'smb_subscription_expire_date'  => $planEndDate,
                    'smb_avail_credit'        => DEFAULT_CREDIT,
                    'smb_createdon'         => $joinedDate,
                    'smb_plan'            => $planId,
                    'smb_createdby'         => 'admin' );
          $db->updateFields("smb_account",$smbDetails , "smb_acc_id = '$appId'");

          // add entry to subscription tracker
              $arrSubscription = array( 'smb_account_id'      => $appId,
                        'st_type'         => '1',
                            'user_id'         => $userid,
                            'plan_id'         => $planId,
                            'st_subscription_amount'  => $paymentAmt,
                            'st_start_date'       => $joinedDate,
                            'st_expiry_date'      => $planEndDate,
                            'st_transact_id'      => '',
                            'st_status'         => '1',
                            'st_created_on'       => $joinedDate,
                            'st_created_by'       => '0'  );
            Subscription::addSubscription($arrSubscription);

            // create new database
            $objDb    = new Appdbmanager();
            $newDBName  = USER_DB_NAME.$appId;
            $objDb->createUserDB($newDBName);
            // call function to create a staff on the newly created databse
            $arrStaff = array(  'agent_email'     => $_POST['user_email'],
                        'agent_password'    => md5($_POST['user_password']),
                        'agent_fname'     => $_POST['user_fname'],
                        'agent_lname'     => $_POST['user_lname'],
                        'agent_status'      => 1,
                      'agent_master'      => 1,
                        'agent_photo_id'    => '',
                        'agent_parent'      => $appId,
                        'agent_added_on'    => $joinedDate  );
            $staffId = $objDb->createStaff($appId,$arrStaff);
            }else{
                // create a smb account for this user
                    $arrSmb                                     = array();
                    $arrSmb['smb_owner_id']             = $userid;
                    $arrSmb['smb_avail_credit']         = DEFAULT_CREDIT;
                    $arrSmb['smb_subscription_date']        = $joinedDate;
                    $arrSmb['smb_subscription_expire_date'] = $planEndDate;
                    $arrSmb['smb_createdon']            = $joinedDate;
                    $arrSmb['smb_plan']             = $planId;
                    $arrSmb['smb_name']             = $_POST['smb_name'];
                    $smbId = Smbaccount::addSmbAccount($arrSmb);

                    // update the status of the user - activate the user
                    User::changeUserStatus($userid, 1);
            }

      }


    }

     public static function getPasswordChangeLink($id)
     {
        return '<a rel="link_'.$id.'" class="jqPopupLink btn btn-link" href='.BASE_URL.'cmshelper/changepassword?id='.$id.'>Change Password</a>';

     }

    /*
     * functions to return pooup urls
     */
  public static function getUserInfoPopupSMB($id) {

     $dbh = new Db();
         $userid =  $dbh->selectRow("smb_account", "smb_owner_id", "smb_acc_id =".$id['id'] );

         $url =  BASE_URL.'cmshelper/popupUserinfo?id='.$userid;
        return $url;
    }

  public static function getSmbPopupUrl($id) {
    $url =  BASE_URL.'cmshelper/popupsmbinfo?id='.$id['id'] ;
    return $url;
 /*
     $dbh = new Db();
         $userid =  $dbh->selectRow("smb_account", "smb_owner_id", "smb_acc_id =".$id['id'] );

         $url =  BASE_URL.'cmshelper/popupUserinfo?id='.$userid;
        return $url;
        */
    }


    public static function getSmbPopupUrlFromSubs($id) {
      $dbh  = new Db();
        $userid =  $dbh->selectRow("subscription_tracker", "smb_account_id", "st_id =".$id['id'] );
    $url  =  BASE_URL.'cmshelper/popupsmbinfo?id='.$userid ;
    return $url;
    }

  public static function getSmbPopupUrlFromCredits($id) {
      $dbh  = new Db();
        $userid =  $dbh->selectRow("credit_tracker", "smb_account_id", "ct_id =".$id['id'] );
    $url  =  BASE_URL.'cmshelper/popupsmbinfo?id='.$userid ;
    return $url;
    }



    /*
     * function to update user settings individualy
     */
    public static function updateUserSettings($field,$value){
      if($field !=''  ) {
          $db           = new Db();
          $db->updateFields("appsettings", array('settings_value' => $value), "settings_name = '$field'");
      }
    }


    /*
     * function to return the user settings
     */
    public static function getUserSettings($alias){
      $db           = new Db();
        $settingsValue      = $db->selectRow("appsettings","settings_value","settings_name='".$alias."'");
    return $settingsValue;
    }



    /*
     * function to update main admin settings individualy
     */
    public static function updateAdminSettings($field,$value){
      if($field !=''  ) {
          $db           = new Db();
          $db->updateFields("lookup", array('vLookUp_Value' => $value), "vLookUp_Name = '$field'");
      }
    }

    //function to get bookdate of inbound numbers
    public static function getBookedDate($id) {
      $db     = new Db();
      $getDate = $db->selectRow('phonenumbers',"DATE_FORMAT(ph_bookdate,'%m/%d/%Y') as bookdate"," ph_id=$id");
      if($getDate == ""){
        return " - ";
      }
      return $getDate;
    }

    public static function getNumberStatus($id)
    {



      $db     = new Db();
      $status= $db->selectRecord('phonenumbers',"ph_appid,ph_status,ph_number"," ph_id=$id");

      if($status->ph_status==0 )
      {
        $objAsterisk  = new Asterisk();
        $inboundNumberStatus=$objAsterisk->setInboundNumber($status->ph_appid,$status->ph_number,0);
      }
      else if ($status->ph_status==1 || $status->ph_status==2)
      {
        $objAsterisk  = new Asterisk();
        $inboundNumberStatus=$objAsterisk->setInboundNumber($status->ph_appid,$status->ph_number,1);

      }

    }

    /**
     * Function to get page metadata
     * @param type $alias
     * @return type array
     */
    public static function getMetaData($alias) {
        $db             = new Db();
        $tableName      = $db->tablePrefix.'metatags';
        $fileds         = " title, keywords, description ";
        $where          = " pageurl = '".$alias."'";
        $result         = $db->selectQuery("SELECT $fileds FROM $tableName WHERE $where");
        return $result;
    }

    /**
     * Function to get page metadata
     * @param type $alias
     * @return type array
     */
    public static function getAllCountries(){
        $db             = new Db();
        $tableName      = $db->tablePrefix.'countries';
        $fileds         = " country_name ";
        $where          = " country_name != '' ";
        $result         = $db->selectQuery("SELECT $fileds FROM $tableName WHERE $where");
        return $result;
    }

    /******************************  Function to update Menu items ****************************/
    public static function getParentOfMenuItem($id){
        $db = new Db();
        $contentDetails = $db->selectQuery("SELECT `menus_id` FROM `cms_menu_items` WHERE `menu_item_id` ='$id'");
        return $contentDetails[0]->menus_id;
    }
    public static function updateMenuItemStatus($id, $value) {
        $db = new Db();
        $defaultVal = ($value == 'Y') ? 'N' : 'Y';
        $db->customQuery("UPDATE cms_menu_items SET enabled = '" . $defaultVal . "' WHERE menu_item_id = '" . $id . "'");
    }

     public static function updateMenuStatus($id, $value) {
        $db = new Db();
        $defaultVal = ($value == 'Y') ? 'N' : 'Y';
        $db->customQuery("UPDATE cms_menus SET enabled = '" . $defaultVal . "' WHERE menus_id = '" . $id . "'");
    }
    /******************************  Function to update Menu items ****************************/

    /******************************  Function to update User status ****************************/
    public static function changeGroupPublishStatus($values) {
        $id             = $values['id'];
        $value          = $values['value'];
        $userStatusUrl  = BASE_URL . 'cmshelper/ajaxGroupPublishStatusChange?id='.$id.'&value='.$value;
        return $userStatusUrl;
    }

    public static function changeNewsletterStatus($values) {
        $id             = $values['id'];
        $value          = $values['value'];
        $userStatusUrl  = BASE_URL . 'cmshelper/ajaxNewsletterStatusChange?id=' . $id . '&value=' . $value;
        return $userStatusUrl;
    }

    public static function changeCmsSectionStatus($values) {
        $id             = $values['id'];
        $value          = $values['value'];
        $userStatusUrl  = BASE_URL . 'cmshelper/ajaxCmsSectionStatusChange?id=' . $id . '&value=' . $value;
        return $userStatusUrl;
    }

    public static function changePageSectionStatus($values) {
        $id             = $values['id'];
        $value          = $values['value'];
        $userStatusUrl  = BASE_URL . 'cmshelper/ajaxPageSectionStatusChange?id=' . $id . '&value=' . $value;
        return $userStatusUrl;
    }

    public static function changeSubscriptionStatus($values) {
        $id             = $values['id'];
        $value          = $values['value'];
        $userStatusUrl  = BASE_URL . 'cmshelper/ajaxSubscriptionStatusChange?id=' . $id . '&value=' . $value;
        return $userStatusUrl;
    }

    public static function changeBannerStatus($values) {
        $id             = $values['id'];
        $value          = $values['value'];
        $userStatusUrl  = BASE_URL . 'cmshelper/ajaxBannerStatusChange?id=' . $id . '&value=' . $value;
        return $userStatusUrl;
    }

    public static function changeTestimonialStatus($values) {
        $id             = $values['id'];
        $value          = $values['value'];
        $userStatusUrl  = BASE_URL . 'cmshelper/ajaxTestimonialStatusChange?id=' . $id . '&value=' . $value;
        return $userStatusUrl;
    }

    public static function changeHomepageCmsStatus($values) {
        $id             = $values['id'];
        $value          = $values['value'];
        $userStatusUrl  = BASE_URL . 'cmshelper/ajaxHomepageCmsStatusChange?id=' . $id . '&value=' . $value;
        return $userStatusUrl;
    }

    public static function changeUserStatus($values) {
        $id             = $values['id'];
        $value          = $values['value'];
        $userStatusUrl  = BASE_URL . 'cmshelper/ajaxUserStatusChange?id=' . $id . '&value=' . $value;
        return $userStatusUrl;
    }

    public static function changeSalesStatus($values) {
        $id             = $values['id'];
        $value          = $values['value'];
        $userStatusUrl  = BASE_URL . 'cmshelper/ajaxSalesrepStatusChange?id=' . $id . '&value=' . $value;
        return $userStatusUrl;
    }

    public static function changePageCategoryStatus($values) {
        $id = $values['id'];
        $value = $values['value'];
        $userStatusUrl = BASE_URL . 'cmshelper/ajaxPageCategoryStatusChange?id=' . $id . '&value=' . $value;
        return $userStatusUrl;
    }

    public static function changeContentStatus($values) {
        $id = $values['id'];
        $value = $values['value'];
        $userStatusUrl = BASE_URL . 'cmshelper/ajaxContentStatusChange?id=' . $id . '&value=' . $value;
        return $userStatusUrl;
    }
    /******************************  Function to update User status ****************************/

    /******************************  Function to update User status ****************************/
    public static function updateGroupPublishStatus($id, $value){
        $db = new Db();
        $tablePrefix  = $db->tablePrefix;
        $defaultVal = ($value == 'Y') ? 'N' : 'Y';
        $db->customQuery("UPDATE `cms_groups` SET `published` = '".$defaultVal."' WHERE `id` = '".$id."'");
    }

    public static function updateNewsletterStatus($id, $value){
        $db = new Db();
        $tablePrefix  = $db->tablePrefix;
        $defaultVal = ($value == 'Y') ? 'N' : 'Y';
        $db->customQuery("UPDATE `".$tablePrefix."newsletters` SET `vStatus` = '" . $defaultVal . "' WHERE `vNewsletterId` = '".$id."'");
    }

    public static function updateCmsSectionStatus($id, $value){
        $db = new Db();
        $defaultVal = ($value == '1') ? '0' : '1';
        $db->customQuery("UPDATE `cms_sections` SET `visibilty` = '" . $defaultVal . "' WHERE `id` = '" . $id . "'");
    }

    public static function updatePageSectionStatus($id, $value){
        $db = new Db();
        $defaultVal = ($value == 'Y') ? 'N' : 'Y';
        $db->customQuery("UPDATE cms_page_sections SET enabled = '" . $defaultVal . "' WHERE section_id = '" . $id . "'");
    }

    public static function updateBannerStatus($id, $value){
        $db = new Db();
        $defaultVal = ($value == 'Y') ? 'N' : 'Y';
        $db->customQuery("UPDATE tbl_banners SET `banner_status` = '" . $defaultVal . "' WHERE `banner_id` = '" . $id . "'");
    }

    public static function updateTestimonialStatus($id, $value){
        $db = new Db();
        $tablePrefix             = $db->tablePrefix;
        $defaultVal = ($value == 'Y') ? 'N' : 'Y';
        $db->customQuery("UPDATE `".$tablePrefix."testimonials` SET `status` = '".$defaultVal."' WHERE `testi_id` = '" . $id . "'");
    }

    public static function updateHomepageCmsStatus($id, $value){
        $db           = new Db();
        $tablePrefix  = $db->tablePrefix;
        $defaultVal   = ($value == 'Y') ? 'N' : 'Y';
        $db->customQuery("UPDATE `".$tablePrefix."contents` SET `cnt_status` = '".$defaultVal."' WHERE `cnt_id` = '".$id."'");
    }

    public static function updatePageCategoryStatus($id, $value) {
        $db = new Db();
        $defaultVal = ($value == 'Y') ? 'N' : 'Y';
        $db->customQuery("UPDATE cms_category SET enabled = '".$defaultVal."' WHERE category_id = '" . $id . "'");
    }

    public static function updateContentStatus($id, $value) {
        $db = new Db();
        $defaultVal = ($value == 'Y') ? 'N' : 'Y';
        $db->customQuery("UPDATE cms_content SET enabled = '" . $defaultVal . "' WHERE content_id = '" . $id . "'");
    }

    public static function getParentOfContentItem($id){
        $db = new Db();
        $contentDetails = $db->selectQuery("SELECT `category_id` FROM `cms_content` WHERE `content_id` ='$id'");
        return $contentDetails[0]->category_id;
    }

    public static function getParentOfCategoryItem($id){
        $db = new Db();
        $contentDetails = $db->selectQuery("SELECT `section_id` FROM `cms_category` WHERE `category_id` ='$id'");
        return $contentDetails[0]->section_id;
    }

    public static function updateSubscriptionStatus($id, $value) {
        $db = new Db();
        $tablePrefix             = $db->tablePrefix;
        $defaultVal = ($value == 'Y') ? 'N' : 'Y';
        $db->customQuery("UPDATE `".$tablePrefix."newsletter_subscribers` SET `vStatus` = '" . $defaultVal . "' WHERE `vSubscriberId` = '".$id."'");
    }
    /******************************  Function to update User status ****************************/


    public static function newsletterCreatedInfo($vNewsletterId) {
        $datefield = date("Y-m-d");
        // $datefield = date("Y-m-d H:i:s");
        $db = new Db();
        // $db->updateFields("newsletters", array('vSendStatus' => 'No',                        'vCreatedOn' =>$datefield,'vLastUpdatedOn'=>$datefield), "vNewsletterId = $vNewsletterId");
        $db->updateFields("newsletters", array('vSendStatus' => 'No',                        'vSendDate' => $datefield, 'vCreatedOn' =>$datefield,'vLastUpdatedOn'=>$datefield), "vNewsletterId = $vNewsletterId");
       
       
    }

    public static function newsletterUpdatedInfo($vNewsletterId) {
        $datefield = date("Y-m-d H:i:s");
        $db = new Db();
        $db->updateFields("newsletters", array('vCreatedOn' => $datefield,'vLastUpdatedOn'=>$datefield), "vNewsletterId = $vNewsletterId");
    }

    //unique email validation
    public static function updateInfo($postedArray) {

        global $allowedVideoFileTypes, $allowedImageFileTypes, $allowedDocumentFileTypes;
        $postedArray['last_updated_on'] = $_SESSION['user'];
        $fileExtesionArray = explode('.', $_FILES['content_file_id']['name']);
        $filePartLength = count($fileExtesionArray);
        $fileExtesion = $fileExtesionArray[$filePartLength - 1];

        if ($postedArray['content_type'] == 'Video' && in_array($fileExtesion, $allowedVideoFileTypes) == false) {
            $allowedVideoFileTypesString = implode(',', $allowedVideoFileTypes);
            $postedArray['error'] = 'ERROR';
            $postedArray['errormessage'] = 'Allowed video file types are ' . $allowedVideoFileTypesString . '.';
        } else if ($postedArray['content_type'] == 'Images' && in_array($fileExtesion, $allowedImageFileTypes) == false) {
            $allowedImageFileTypesString = implode(',', $allowedImageFileTypes);
            $postedArray['error'] = 'ERROR';
            $postedArray['errormessage'] = 'Allowed image file types are ' . $allowedImageFileTypesString . '.';
        } else if ($postedArray['content_type'] == 'Documents' && in_array($fileExtesion, $allowedDocumentFileTypes) == false) {
            $allowedDocumentFileTypesString = implode(',', $allowedDocumentFileTypes);
            $postedArray['error'] = 'ERROR';
            $postedArray['errormessage'] = 'Allowed document file types are ' . $allowedDocumentFileTypesString . '.';
        }


        return $postedArray;
    }
 public static function getAllParentCategory($id=''){
        $db = new Db();
        $q = "";

        if ($id)
            $q = " AND category_id != $id";
        $getAllStates = $db->selectQuery("SELECT category_id,title FROM cms_category WHERE enabled = 'Y' $q ORDER BY `title` ASC");
        $var = 0;
        foreach ($getAllStates as $state) {
            $result[$var]         = new StdClass;
            $result[$var]->value  = $state->category_id;
            $result[$var]->text   = $state->title;
            $var++;
        }
        return $result;
    }

     public static function updateContentSection($id) {
        $db = new Db();

        $contentDetails = $db->selectQuery("SELECT category_id FROM cms_content WHERE content_id='$id'");
        if ($contentDetails[0]->category_id)
            $sectionDetails = $db->selectQuery("SELECT section_id FROM cms_category WHERE category_id='{$contentDetails[0]->category_id}'");
        if ($sectionDetails[0]->section_id)
            $db->customQuery("UPDATE cms_content  categories SET section_id = '{$sectionDetails[0]->section_id}' WHERE content_id  = '$id'");
    }

     // Function to update User status
    public static function changeMenuStatus($values) {
        $id = $values['id'];
        $value = $values['value'];
        $userStatusUrl = BASE_URL . 'cmshelper/ajaxMenuStatusChange?id=' . $id . '&value=' . $value;
        return $userStatusUrl;
    }
    public static function getAllMenuItems($id=''){
        $db = new Db();
        $q = "";

        if ($id)
            $q = " AND menu_item_id!=$id";
        $getAllStates = $db->selectQuery("SELECT menu_item_id,title FROM cms_menu_items WHERE enabled = 'Y' AND `menu_parent_id` = '0' AND `menus_id` = '1' AND `reference_type` = 'Section' $q");
        $var = 0;
        foreach ($getAllStates as $state) {
             $result[$var] = new StdClass;
            $result[$var]->value = $state->menu_item_id;
            $result[$var]->text = $state->title;
            $var++;
        }
        return $result;
    }
      // Function to update User status
    public static function changeMenuItemStatus($values) {
        $id = $values['id'];
        $value = $values['value'];
        $userStatusUrl = BASE_URL . 'cmshelper/ajaxMenuItemStatusChange?id=' . $id . '&value=' . $value;
        return $userStatusUrl;
    }

    //settings section
    public static function changeSettings($postedArray) {
      //echopre($postedArray); exit;
      $flag = 0;
        $fileHandler = new Filehandler();
      //  print_r($_FILES); //exit;

      if($postedArray['EnableSMTP'] != ''){
        if($postedArray['SMTPHost'] == '' || $postedArray['SMTPUsername'] == '' || $postedArray['SMTPPassword'] == '' || $postedArray['SMTPPort'] == ''){
          $postedArray['error'] = 'ERROR';
          $postedArray['errormessage'] = 'Please enter the SMTP details.';
          return $postedArray;
        }
        if($postedArray['SMTPUsername'] != '' && verify_email($postedArray['SMTPUsername']) == false){
          $postedArray['error'] = 'ERROR';
          $postedArray['errormessage'] = 'Please enter valid SMTP Username.';
          return $postedArray;
        }
      }
      if($postedArray['admin_email'] == '' || verify_email($postedArray['admin_email']) == false){
        $postedArray['error'] = 'ERROR';
        $postedArray['errormessage'] = 'Invalid Admin Email.';
        return $postedArray;
      }
      /*if($postedArray['banner_button1_label'] <> '' && $postedArray['banner_button1_alias'] == ''){
        $postedArray['error'] = 'ERROR';
        $postedArray['errormessage'] = 'Invalid details for button-1.';
        return $postedArray;
      }*/

          $fileHandler->file_upload_dir = FILE_UPLOAD_DIR."/logo/";
          if($_FILES['sitelogo']['name'] !='')
            {
            $type = $_FILES['sitelogo']['type'];
            $type1 = @explode('/', $type);
            if($type1[0] != 'image' || !in_array($type1[1], array("gif", "jpeg", "jpg", "png"))){
              $postedArray['error'] = 'ERROR';
              $postedArray['errormessage'] = "File format not supported.";
              return $postedArray;
            }
            try{
              $siteLogoFileDetails = $fileHandler->handleUpload($_FILES['sitelogo']);
              $postedArray['sitelogo'] = $siteLogoFileDetails->file_path;
            }
            catch (Exception $e){
              $postedArray['error'] = 'ERROR';
              $postedArray['errormessage'] = $e->getMessage();
              return $postedArray;
            }
          }
      //    echopre($postedArray);
      //    exit;
      return $postedArray;
    }

    public static function getReportQuery() {
    //the query can have sub-queries
    // if sub-queries have where condition, main-query should have where
  //     condition (atleast ' Where 1 ')
    // main-query cannot have order by, group by & having
    //  order by, group by of main-query should be mentioned in subquery
    // sub-queries can have order by, group by & having
    // avoid Union
    // table join supported, give join in query

      $dbh                     = new db();
      $tablePrefix             = $dbh->tablePrefix;
      //sample query

        $query = "SELECT tbl_order_details.od_id,tbl_order_details.order_id, external3.plan_name AS plan_id, external4.school_name AS school_id,external7.lead_fname,external7.lead_lname,external8.salesrep_email,external6.campaign_name,external6.order_id,"
                . "external5.slot_name AS slot_id,tbl_order_details.campaign_start_date,tbl_order_details.campaign_end_date,"
                . "tbl_order_details.od_item_amount,tbl_order_details.od_share_voice,tbl_order_details.od_created_on,tbl_order_details.plan_period,"
                . "tbl_order_details.odd_status FROM tbl_order_details LEFT JOIN tbl_plans AS external3 ON external3.plan_id=tbl_order_details.plan_id "
                . "LEFT JOIN tbl_school AS external4 ON external4.school_id=tbl_order_details.school_id "
                . " INNER JOIN tbl_orders AS external6 ON external6.order_id = tbl_order_details.order_id"
                . " INNER JOIN tbl_campaign_leads AS external7 ON external7.lead_id = external6.lead_id"
                . " INNER JOIN tbl_salesrep AS external8 ON external8.salesrep_id = tbl_order_details.salesrep_id"
                . " LEFT JOIN tbl_slot AS external5 ON external5.slot_id=tbl_order_details.slot_id "
                . " JOIN tbl_school AS reference ON tbl_order_details.school_id=reference.school_id WHERE 1 $where";


      return $query;
    }

     public static function fetchTagDetail($id){
      $db     = new Db();
      $getAllPlans = $db->selectResult('school','*'," status='1' and school_id=$id");
      $tagIds = $getAllPlans[0]->conference_id;
      $tagArray = explode(',', $tagIds);
      $result = '';
      foreach($tagArray as $plan) {
        $getAllPlans1 = $db->selectResult('conference','*'," conference_id='$plan'");
        if($getAllPlans1[0]->conference_id){
         $dataArray[] = array('id' => $getAllPlans1[0]->conference_id,
            'name' => ucwords($getAllPlans1[0]->conference_name)
        );
        }
      //  $result .= $getAllPlans1[0]->conference_id.",";
      }
     // $result = trim($result,',');
     // print_r($dataArray);
      return $dataArray;
     }

  public static function fetchUserUrl(){
     // return BASE_URL . 'cmshelper/ajaxTagTest';
     $db     = new Db();
    $getAllPlans1 = $db->selectResult('conference','*'," conference_status=1");
    foreach($getAllPlans1 as $plan) {
        $dataArray[] = array('id' => $plan->conference_id,
            'name' => ucwords($plan->conference_name)
        );
    }
      echo json_encode($dataArray);
        exit();
     }

     public static function fetchTagedUsers($id=''){
        $db     = new Db();
        if($id){
      $getAllPlans = $db->selectResult('school','*'," status='1' and school_id=$id");
      $tagIds = $getAllPlans[0]->conference_id;
      if($tagIds){
      $tagArray = explode(',', $tagIds);
      foreach($tagArray as $plan) {
        $getAllPlans1 = $db->selectResult('conference','*'," conference_id=$plan");
        $dataArray[] = array('id' => $getAllPlans1[0]->conference_id,
            'name' => ucwords($getAllPlans1[0]->conference_name)
        );
      }
      }
        }
        return json_encode($dataArray);
     }


     public static function getUsStates()
     {
        $db = new Db();
        $getAllStates = $db->selectQuery("SELECT state_name,state_abbr FROM tbl_us_states");
        $var = 0;
        $result = array();

        foreach ($getAllStates as $state) {
             $result[$var] = new StdClass;
            $result[$var]->value = $state->state_abbr;
            $result[$var]->text = $state->state_name;
            $var++;
        }


        //echopre($result);
        return $result;
     }


      public static function sendUserStatusMail($array)
     {
         // echopre1($array);
           $db      = new Db();
      $id =  $array['primary_key_value'];
      $getrecord = $db->selectResult('salesrep','*'," salesrep_id=$id");
          //echopre1($getrecord[0]);

         $mail = new Mailer();
          $emailIds = array($array['salesrep_email']);


          if($getrecord[0]->salesrep_status != $array['salesrep_status']){

             // echopre1($array['salesrep_status']);


              $paramas['NAME'] = $array['salesrep_fname'].' '.$array['salesrep_lname'];
           if($array['salesrep_status']==1)
           $mailSend = $mail->sendUserRegistrationAdminMail($emailIds,'user_status_active',$paramas,$files);
           elseif($array['salesrep_status']==0)
           $mailSend = $mail->sendUserRegistrationAdminMail($emailIds,'user_status_inactive',$paramas,$files);


          }

          return $array;

     }



       public static function sendUserStatusAjaxMail($array)
     {
         // echopre1($array);
           $db      = new Db();
      $id =  $array['primary_key_value'];
      $getrecord = $db->selectResult('salesrep','*'," salesrep_id=$id");
          //echopre1($getrecord[0]);

         $mail = new Mailer();
          $emailIds = array($array['salesrep_email']);




             // echopre1($array['salesrep_status']);


           $paramas['NAME'] = $array['salesrep_fname'].' '.$array['salesrep_lname'];


           if($array['salesrep_status']==1)
           $mailSend = $mail->sendUserRegistrationAdminMail($emailIds,'user_status_active',$paramas,$files);
           elseif($array['salesrep_status']==0)
           $mailSend = $mail->sendUserRegistrationAdminMail($emailIds,'user_status_inactive',$paramas,$files);




         // return $array;

     }

     public static function sendOrderStatusMail($array)
     {

      //echopre1($array);

           $db      = new Db();
      $id =  $array['order_id'];
      $getrecord = $db->selectResult('orders','*'," order_id=$id");
         // echopre1($getrecord[0]);

          $lead_id = $getrecord[0]->lead_id;

          $getleads = $db->selectResult('campaign_leads','*'," lead_id=$lead_id");

        //echopre1($getleads);
         $mail = new Mailer();
          $emailIds = array($getleads[0]->lead_email);


          if($getrecord[0]->order_status != $array['order_status']){

           //  echopre1($array['salesrep_status']);










           $paramas['NAME'] = $getleads[0]->lead_fname.' '.$getleads[0]->lead_lname;


           if($array['order_status']==1)
           $order_status = 'Confirmed';
           elseif($array['order_status']==2)
           $order_status = 'Cancelled';
           else
           $order_status = 'Pending';


           if($array['payemnt_status']==1)
           $payment_status = 'Confirmed';
           elseif($array['payemnt_status']==2)
           $payment_status = 'Cancelled';
           else
           $payment_status = 'Pending';



                     $paramas['CAMPAIGN_NAME'] = $getrecord[0]->campaign_name;
                     $paramas['ORDER_NUMBER'] = $getrecord[0]->order_id;
                     $paramas['ORDER_STATUS'] = $order_status;
                     $paramas['PAYMENT_STATUS'] = $payment_status;
                     $paramas['PHONE_NO'] = $getleads[0]->lead_phoneno;
                     $paramas['COMPANY'] = $getleads[0]->lead_company;
                     $paramas['TOTAL'] = $array['payment_amount'];
                     $paramas['CONTRACT'] = $getrecord[0]->contract_type;
                     $paramas['ADDRESS'] = $getleads[0]->lead_address.','.$getleads[0]->lead_pincode.','.$getleads[0]->lead_state;









           if($array['order_status']==1){
           $paramas['SUBJECT'] = 'Your Order has been Confirmed by Admin';
           $paramas['STATUS_MESSAGE'] = 'Your Order has been Confirmed by Admin';
           $mailSend = $mail->sendUserOrderMail($emailIds,'order_status_change',$paramas,$files);
           }elseif($array['order_status']==0){
           $paramas['SUBJECT'] = 'Your Order is in pending Status';
           $paramas['STATUS_MESSAGE'] = 'Admin has yet to approve your Order';
           $mailSend = $mail->sendUserOrderMail($emailIds,'order_status_change',$paramas,$files);
           }elseif ($array['order_status']==2) {
           $paramas['SUBJECT'] = 'Your Order has been Cancelled by Admin';
           $paramas['STATUS_MESSAGE'] = 'Your Order has been Cancelled by Admin';
           $mailSend = $mail->sendUserOrderMail($emailIds,'order_status_change',$paramas,$files);
            }

          }

          return $array;

     }


     public static function changeOrderStatus($id)
     {


        $db     = new Db();
         $getrecord = $db->selectResult('orders','*'," order_id=$id");

         $order_status = $getrecord[0]->order_status;

      //   $db->updateFields("order_details", array('odd_status' => $order_status), "order_id = '$id'");



     }

     public static function saveFeedback($obj){
        //echopre($obj);
        $db             = new Db();
        $time           = date('Y-m-d H:i:s');
        $tableName      = $db->tablePrefix.'feedbacks';
        $save           =  $db->insert($tableName,
          array(
              'firstName'         =>  Utils::escapeString($obj->firstName),
              'lastName'          =>  Utils::escapeString($obj->lastName),
              'address'           =>  Utils::escapeString($obj->address),
              'emailId'           =>  Utils::escapeString($obj->emailId),
              'phone'             =>  Utils::escapeString($obj->phone),
              'country'           =>  Utils::escapeString($obj->country),
              'city'              =>  Utils::escapeString($obj->city),
              'subject'           =>  Utils::escapeString($obj->subject),
              'message'           =>  Utils::escapeString($obj->message),
              'feedback_date'     =>  $time
          ));
        //echopre($save);
        return $save;
     }

     public static function saveMail($obj){
      //echopre1($array);
      $db     = new Db();
      $time=date('Y-m-d H:i:s');
      $tableName="tbl_mailbox";
      $save           =   $db->insert($tableName,
          array(  'mail_subject'           =>  Utils::escapeString($obj->mail_subject),
              'mail_receiverid'        =>  Utils::escapeString($obj->mail_receiverid),
              'mail_msg'               =>  Utils::escapeString($obj->mail_msg),
              'mail_senderid'      =>  Utils::escapeString($_SESSION['cms_user_id']),
              'mail_userroll'      =>  Utils::escapeString($_SESSION['cms_role_id']),
              'mail_status'      =>  '0',
              'mail_allstatus'       =>  '',
              'mail_sendtime'      =>  $time,


          ));
      //echopre1($save);
      self::sendMailToUser($save);
      return $save;
     }

     public static function sendMailToUser ($id){
      $db     = new Db();
      $tableName          =  'mailbox';
      $user_id = $_SESSION['cms_user_id'];

      //$query            = "SELECT * FROM ".$tableName." WHERE mail_id='$id' ";

      //echo $query;exit();
      //$details      = $db->selectQuery($query);
      $details = $db->selectRecord($tableName, "*"," mail_id=".$id);
      //echopre1($details);
      //echo $details->mail_receiverid;exit();
      $table2="cms_users";
      $user  = "SELECT * FROM ".$table2." WHERE id='$user_id' ";
      $user_name=$db->selectQuery($user);
      //echopre1($user_name[0]->username);
      //$pm=;
      //echo $pm;exit();
      //echopre1($user_name);
      $query  = "SELECT * FROM ".$table2." WHERE id='$details->mail_receiverid' ";
      $email=$db->selectQuery($query);
      $array = json_decode(json_encode($email), True);
      ///echopre1($array);
      // Fetch mail id for Admin from loopupcms
      if ($array[0]['email']==""){
        $tableName2         =  'lookup_cms';

        $adminmail = $db->selectRecord($tableName2, "*"," settingfield='admin_email'" );
        //echopre1($adminmail);
        $to_mailid=$adminmail->value;
      }else{


      $to_mailid= $array[0]['email'];

      }
      //$details      = $db->selectQuery($query);
      $mailer = new Mailer();
      $emailIds[] = $to_mailid;
      //echo $emailIds;exit();
      $paramas['NAME']=$array[0]['username'];
      $paramas['SUBJECT']=$details->mail_subject ." -- Private message from ". $user_name[0]->username;
     // echo $paramas['SUBJECT'];exit();
      $paramas['MESSAGE']=$details->mail_msg;
      $mailSend = $mailer->sendUserRegistrationAdminMail($emailIds,'mailbox_mail',$paramas,$files);

     }

     public static  function save_image($img,$fullpath='basename'){
      if($fullpath=='basename'){
        $fullpath = basename($img);
      }
      $ch = curl_init ($img);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
      $rawdata=curl_exec($ch);
      curl_close ($ch);
      $fullpath=FILE_UPLOAD_DIR."/".$fullpath;

      //echo "full path:".$fullpath. "<br/>";
    //  exit();
      if(file_exists($fullpath)){
        unlink($fullpath);
      }
      $fp = fopen($fullpath,'x');
      fwrite($fp, $rawdata);
      fclose($fp);
     }
}
?>
