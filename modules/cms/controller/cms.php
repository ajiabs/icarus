<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Framework Main Controller			                                          |
// | File name :Index.php                                                 |
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

class ControllerCms extends BaseController {
    /*
		construction function. we can initialize the models here
    */
    public function init() {
        parent::init();
        PageContext::$isCMS = true;

        //disabling  smarty for cms
        PageContext::$smarty = false;
        PageContext::$smartyParsing = false;

        //echopre($_SESSION);

        // Added for CUP
        $replacePath = "cms";
        if(Current_Url==BASE_URL."cms" || Current_Url==BASE_URL."admin"){
            $replacePath = "cms";
        }else{
            $replacePath = (CUP)?CUP_CONSTANT:"cms";
        }
        define('CMS_PATH', $replacePath);



        $this->view->setLayout("home");
        PageContext::$body_class 	 = 'cms';
        $base_dir   =   'modules/cms/';
        $dir_path   =  "logics";
        $directory = $base_dir.$dir_path;
        if(is_dir($directory)) {
            if ($handle = opendir($directory)) {
                while (false !== ($file = readdir($handle))) {

                    if ($file == "." && $file == "..") continue;
                    if(is_dir($directory.'/'.$file))continue;
                    $path_parts = pathinfo($directory.'/'.$file);
                    if(!$path_parts || $path_parts['extension']	!=	'php')continue;
                    include_once($directory.'/'.$file);
                }
                closedir($handle);
            }
        }


        //PageContext::$response->menu =  Cms::loadMenu();
        PageContext::$response->cmsSettings    =  Cms::getCmsSettings();
        PageContext::$response->cmscolorSettings    =  Cms::getCmscolorSettings();

        if(PageContext::$response->cmsSettings['site_logo']) {
            $siteLogo         =  call_user_func_refined(PageContext::$response->cmsSettings['site_logo']);
        }



        PageContext::$response->siteLogo =  $siteLogo;
        PageContext::$enableBootStrap=true;
        $clubmember_data = json_decode($_SESSION['default_kb_user'],true);
        $clubmember_type = $clubmember_data['clubmember_id'];
        if($clubmember_type != ''){
            PageContext::$metaTitle .= " : Place Manager ";
        }else{
           PageContext::$metaTitle .= " : Admin ";
        }

        PageContext::addJsVar("formError", 0);
        $cmsLayoutSectionData= Cms::getlayoutSectionData();
        $cmsLayoutSectionConfig =   $cmsLayoutSectionData->section_config;

        $cmsLayoutSectionConfig= json_decode($cmsLayoutSectionConfig);

        foreach($cmsLayoutSectionConfig->headerLinks as $key=>$links) {

            $cmsLayoutSectionConfig->headerLinks->$key->link         =  call_user_func_refined($links->linkSource);
        }
        PageContext::$response->headerLinks =  $cmsLayoutSectionConfig->headerLinks;
        $session    =   new LibSession();
        $cmsUsername = $session->get("cms_username");
        PageContext::$response->cmsUsername =  $cmsUsername;
        $date_separator =  GLOBAL_DATE_FORMAT_SEPERATOR;
        if($date_separator!="GLOBAL_DATE_FORMAT_SEPERATOR") {

            $jsDateFormat = "mm".$date_separator."dd".$date_separator."yy";
        }
        else {
            $date_separator = "-";
            $jsDateFormat = "mm".$date_separator."dd".$date_separator."yy";
        }
        PageContext::addJsVar("date_separator", $jsDateFormat);
    }


    /*
     * License Key Check
    */
    function isValidLicense() {
        $var_domain	= strtoupper(trim($_SERVER['HTTP_HOST']));
        if($var_domain == 'LOCALHOST' || $var_domain == '127.0.0.1' ||  $var_domain == 'DOMIAN_NAME') {
            return true;
        }
        else {
            $is_valid = License::FCE74825B5A01C99B06AF231DE0BD667D($var_domain);
            return $is_valid;
        }
    }

    public function invalidlicense() {

        PageContext::$response->errorMsg = "<b>Invalid License Key!<br/> Please Enter A Valid License Key.</b>";
        if($_REQUEST['submit']) {
            $license    =   $_REQUEST['inputlicense'];
            $password   =   md5($_REQUEST['password']);
            $res    =   License::FB65FDD43B9A0C83B8499D74B1A31890A($password);
            if(count($res)>0) {
                License::F03FD063C610FFF78F127C6DCC52A6524($license);
            }
            header("location: ".BASE_URL."cms");
            exit;
        }
    }


    /*
    function to load the index template
    */
    public function index() {


        // Reset session
        //Cms::resetLoginSession();

        if( defined('PRODUCT_INSTALLER')) {
            // License check
            if(!$this->isValidLicense()) {
                PageContext::AddPostAction("invalidlicense","cms","cms");
                PageContext::$response->invalidLicense  =   1;
                return;
            }
        }

        if(CMS_ROLES_ENABLED)
            $roleEnabled    =   1;
        //PageContext::addScript("bootstrap-modal.js");

        if(!$this->checkLogin()) {
            PageContext::AddPostAction("login","cms","cms");
            return;
        }

        if($roleEnabled) {
            $session        = new LibSession();
            $sessionPrefix  = Cms::getLoginSessionType();
            $roleId         = $session->get($sessionPrefix."role_id");

            if( $session->get($sessionPrefix.'admin_type')!="developer"){
                //PageContext::$response->menu =  Cms::loadMenu();
                $parentRoleIDArray    =  Cms::getParentRoleList($roleId); //echopre1($parentRoleIDArray);
                $parentRoleIDString   =  "" ;
                for($loop=0;$loop<count($parentRoleIDArray);$loop++) {
                    $parentRoleIDString  .=  $parentRoleIDArray[$loop].",";
                }
                $parentRoleIDString   = substr($parentRoleIDString, 0, -1);
                // privileges issue fix - for roles in same level
                $roleIDStr            = Cms::getSkipRoleList($roleId,$parentRoleIDString);
                $parentRoleIDString   = $roleIDStr;
                $parentRoleIDArray    = explode(',', $parentRoleIDString);
                // privileges issue fix - for roles in same level end

                $privilegedSections   = Cms::getPrivilegedSections($parentRoleIDString);
                $privilegedSections   = $privilegedSections.",";
                $privilegedGroups     = Cms::getPrivilegedGroups($parentRoleIDString);
                $privilegedGroups     = $privilegedGroups.",";
                $menuList             = Cms::getprivilegedMenuList($roleId,$parentRoleIDArray); //echopre1($menuList);
                $sectionId            = Cms::getSectionId(PageContext::$request['section']);

                if(PageContext::$request['section']=="") {
                    $defaultMenu    =   Cms::loadDefaultMenu($roleId,$parentRoleIDArray);
                    $sectionId=  Cms::getSectionId($defaultMenu->section_alias);
                }
                $groupId =  Cms::getGroupId($sectionId);
                // echopre($sectionId);
                //  echopre($privilegedSections);
                //echo substr_count( $privilegedSections,",".$sectionId.",");
                // echo "<br/>";
                //   echo substr_count( $privilegedGroups,$groupId.",");
                //exit();
                $privilegedSectionsArray  = explode(',',$privilegedSections);
                $privilegedGroupsArray    = explode(',', $privilegedGroups);

                if(in_array($sectionId,$privilegedSectionsArray) || in_array( $groupId,$privilegedGroupsArray)){
                    //   echo substr_count( $privilegedSections,$sectionId.",");
                    //  echo "<br/>";
                    //   echo substr_count( $privilegedGroups,$groupId.",");
                    PageContext::$response->illegal =  1;
                    //echo "sfd";exit();
                    PageContext::addPostAction("permission","cms","cms");
                }
                else if(!count($menuList)) {
                    PageContext::addPostAction("permission","cms","cms");
                    PageContext::$response->illegal =  1;
                }
            }
            else {
                $menuList =  Cms::loadMenu();
            }
            //echopre($menuList);
            $menuListCount                      = count($menuList);
            PageContext::$response->menu        =  $menuList;
            PageContext::$response->menuCount   =  $menuListCount;
            //getprivilegedMenuList
            PageContext::$response->cmsSettings    =  Cms::getCmsSettings();
            if(PageContext::$request['section']=="") {
                $defaultMenu    =   Cms::loadDefaultMenu($roleId,$parentRoleIDArray);
                PageContext::$request['section']=$defaultMenu->section_alias;
                PageContext::$response->defaultSection=$defaultMenu->section_alias;
            }
        }
        else {
            $menuList =  Cms::loadMenu();
            if(PageContext::$request['section']=="") {
                $defaultMenu    =   Cms::loadDefaultMenu();

                PageContext::$request['section']=$defaultMenu->section_alias;
                PageContext::$response->defaultSection=$defaultMenu->section_alias;

            }
        }

        PageContext::$response->menu        =  $menuList;
        PageContext::$response->menuCount   =  $menuListCount;

        //
        // to find whether custom post action or not
        $sectionData    =   Cms::getSectionData(PageContext::$request);
        PageContext::addJsVar("requestHeader", PageContext::$request['section']);
        $sectionConfig  =   json_decode($sectionData->section_config);

        //including js files
        foreach($sectionConfig->includeJsFiles as $files) {

            PageContext::addScript($files);
        }
        $customCmsAction    =   0;
        if($sectionConfig->customCmsAction) {
            $customCmsAction =   1;

        }
        if($sectionConfig->customAction) {
            $isCustomAction =   1;

        }
        else
            $isCustomAction =   0;
        // if json is invalid

        if ($sectionConfig === null ) {
            $isCustomAction =   2;
            PageContext::$response->errorMessage  = "Invalid section alias or config ...";

        }
        //checking privileges
        $hasPrivileges  =   Cms::hasSectionPrivileges(PageContext::$request['section']);
        if($hasPrivileges   ==  0) {
            $isCustomAction =   2;
            PageContext::$response->errorMessage  = "Illegal access ...";
        }
        PageContext::$response->isCustomAction=$isCustomAction;
        //if no section default to first item in the section list.
        if(($isCustomAction==0 && PageContext::$request['section']) || $customCmsAction==1) {


            if($sectionConfig->siteSettings) {
                PageContext::$response->settingsTab    =   1;
                PageContext::addPostAction("settings","cms","cms");

            }
            else if($sectionConfig->dashboardPanel) {
                PageContext::$response->dashboardPanel    =   1;
                PageContext::addPostAction("dashboard","cms","cms");
            }
            else if($sectionConfig->dashboardPanel2) {
                PageContext::$response->dashboardPanel2    =   1;
                PageContext::addPostAction("dashboard","cms","cms");
            }
            else if($sectionConfig->reportPanel) {
                PageContext::$response->reportPanel    =   1;
                PageContext::addPostAction("reportlising","cms","cms");
            }
            else if($customCmsAction==1) {
                PageContext::$response->customCmsAction    =   1;
                $customActionModule         =   $sectionConfig->module;
                $customActionController     =   $sectionConfig->controller;
                $customActionMethod         =   $sectionConfig->method;
                PageContext::$response->customActionModule      =   $customActionModule;
                PageContext::$response->customActionController  =   $customActionController;
                PageContext::$response->customActionMethod      =   $customActionMethod;
                PageContext::addPostAction($customActionMethod,$customActionController,$customActionModule);
            }
            else {
                //PageContext::$request ="tier";
              //  echopre1(PageContext::$request);

                $postAction =   'sectionlisting';
                PageContext::addPostAction($postAction,"cms","cms");
                PageContext::$response->postAction=$postAction;
                // for bread crumb
                Cms::getBreadCrumb(PageContext::$request);
                $currentURL=Cms::formUrl(PageContext::$request,$sectionConfig);
                PageContext::$response->currentURL     =   $currentURL;
                if($sectionData->section_name){
                    PageContext::$response->addActionLabel = 'Add '.$sectionData->section_name;
                }
                else{
                PageContext::$response->addActionLabel = 'Add Record';
                }
                //Assign add record label if specified in config
                if(isset($sectionConfig->operationLabel->addLabel)){
                    PageContext::$response->addActionLabel = $sectionConfig->operationLabel->addLabel;
                }

                //Assign edit,view,delete titles if specified
                if(isset($sectionConfig->operationLabel->editTitle)){
                    PageContext::$response->editActionTitle = $sectionConfig->operationLabel->editTitle;
                }
                if(isset($sectionConfig->operationLabel->viewTitle)){
                    PageContext::$response->viewActionTitle = $sectionConfig->operationLabel->viewTitle;
                }
                if(isset($sectionConfig->operationLabel->deleteTitle)){
                    PageContext::$response->deleteActionTitle = $sectionConfig->operationLabel->deleteTitle;
                }

                PageContext::addJsVar("currentURL", $currentURL);
            }

        }
        else if(($isCustomAction    ==  1 )) {

            //PageContext::$response->customAction     =   $customActionArray->custom_action;
            $customActionModule         =   $sectionConfig->module;
            $customActionController     =   $sectionConfig->controller;
            $customActionMethod         =   $sectionConfig->method;
            PageContext::$response->customActionModule      =   $customActionModule;
            PageContext::$response->customActionController  =   $customActionController;
            PageContext::$response->customActionMethod      =   $customActionMethod;
            PageContext::addPostAction($customActionMethod,$customActionController,$customActionModule);
        }
        else if($isCustomAction ==  2 ) {
            $postAction =   'errordisplay';
            PageContext::addPostAction($postAction);

            PageContext::$response->postAction=$postAction;
        }

    }






    public function previlagedata(){
         $data = array();
        $roleEnabled =1;
         if($roleEnabled) {

            $session    =   new LibSession();

            $sessionPrefix = Cms::getLoginSessionType();
            $roleId = $session->get($sessionPrefix."role_id");

            if( $session->get($sessionPrefix.'admin_type')!="developer") {
                //PageContext::$response->menu =  Cms::loadMenu();
                $parentRoleIDArray=  Cms::getParentRoleList($roleId);

                $parentRoleIDString  =  "" ;
                for($loop=0;$loop<count($parentRoleIDArray);$loop++) {
                    $parentRoleIDString  .=  $parentRoleIDArray[$loop].",";
                }
                $parentRoleIDString = substr($parentRoleIDString, 0, -1);

                // privileges issue fix - for roles in same level
                $roleIDStr = Cms::getSkipRoleList($roleId,$parentRoleIDString);
                $parentRoleIDString = $roleIDStr;
                $parentRoleIDArray = explode(',', $parentRoleIDString);
                // privileges issue fix - for roles in same level end

                $privilegedSections = Cms::getPrivilegedSections($parentRoleIDString);

                $privilegedSections = $privilegedSections.",";

                $privilegedGroups = Cms::getPrivilegedGroups($parentRoleIDString);

                $privilegedGroups = $privilegedGroups.",";
            }
        }

         $data['privilegedSections'] = $privilegedSections;
         $data['privilegedGroups'] =  $privilegedGroups;
        echo json_encode($data);
        exit;

    }


    //TODO: temperory login logic need to refine this to a complete admin login functionality after first milestone
    public function login() {
        $session    =   new LibSession();

        if(CMS_ROLES_ENABLED)
            $roleEnabled    =   1;
        if($_REQUEST['submit']) {
            $username   =   $_REQUEST['username'];
            $password   =   md5($_REQUEST['password']);
            if($roleEnabled) {
                $res    =   Cms::checkLogin($username,$password,$roleEnabled);
                if(count($res)>0) {
                    if($res->module=="user"){
                        if(CUP){ Cms::setLoginSession($res,$username,$roleEnabled); }
                    }else{
                        Cms::setLoginSession($res,$username,$roleEnabled);
                    }
                    //header("location: ".BASE_URL."cms");
                    header("location: ".BASE_URL.CMS_PATH);
                    exit;
                }
                else {
                    PageContext::$response->errorMsg = "Invalid Login!";
                }
            }
            else {
                $res    =   Cms::checkLogin($username,  $password);
                if(count($res)>0) {
                    if($res->module=="user"){
                        if(CUP){ Cms::setLoginSession($res,$username); }
                    }else{
                        Cms::setLoginSession($res,$username);
                    }
                    header("location: ".BASE_URL.CMS_PATH);
                    exit;
                }
                else {
                    PageContext::$response->errorMsg = "Invalid Login!";
                }
            }
        }
    }

    public function developer() {
        $session    =   new LibSession();
        if($_REQUEST['submit']) {
            $username   =   $_REQUEST['username'];
            $password   =   $_REQUEST['password'];

            if($username==CMS_DEVELOPER_USERNAME && $password==CMS_DEVELOPER_PASSWORD) {
                $session->set("admin_type","developer");
                $session->set("admin_logged_in","1");
                $session->set("cms_username",$username);
                header("location: ".BASE_URL."cms");
                exit;
            }
            else {
                PageContext::$response->errorMsg = "Invalid Login!";
            }
        }

    }
    public function settings() {



        //to get section config values
        $sectionData = Cms::getSectionData(PageContext::$request);
        PageContext::$response->message =   PageContext::$request['message'];
        $sectionConfig=$sectionData->section_config;
        $sectionConfig=json_decode($sectionConfig);
        $currentURL=Cms::formUrl(PageContext::$request,$sectionConfig);
        PageContext::$response->settingStyle = $sectionConfig->settingStyle;

        // Field Assignment
        PageContext::$response->valueField = $valueField     = $sectionConfig->fieldAssignment->value;
        PageContext::$response->labelField = $labelField     = $sectionConfig->fieldAssignment->settingfield;


        if($sectionConfig->settingStyle=="tab") {
            // $settingsValueArray  =   Cms::getSettingsTableData();

            //echopre($sectionConfig);
            $settingstabsArray  = Cms::getSettingsTabs($sectionData->table_name,$sectionConfig->fieldAssignment);
            $hints              = $sectionConfig->hints;

            $settingsTabs   =   array ();
            $loop           =   0;
            foreach ($settingstabsArray as $tab) {
                if($tab->groupLabel) {
                    // foreach($sectionConfig->settingStyle)
                    $settingsTabs[$loop]->label             =   $tab->groupLabel;

                    $tabId                                  =   Cms::getSettingsTabId($tab->groupLabel,$sectionData->table_name);
                    $tabContent                             =   $tabId."List";
                    $tabContent                             =   Cms::getSettingsTableData($tab->groupLabel,$sectionData->table_name,$sectionConfig->fieldList);
                    $cstLoop =  0;
                    foreach($tabContent as $column) {
                        $hintText = "";
                        foreach($hints as $hintKey=>$hintValue) {
                            if($hintKey== $column->$labelField)
                                $tabContent[$cstLoop]->hint             =   $hintValue;
                        }
                        foreach($sectionConfig->customColumns as $custKey=>$custVal) {
                            if($custKey==$column->$labelField) {
                                $tabContent[$cstLoop]->customColumn = $custVal;
                            }
                        }
                        $cstLoop++;
                    }

                    $settingsTabs[$loop]->tabContent        =   $tabContent;
                    $settingsTabs[$loop]->id                =   $tabId;
                    $loop++;
                } //echopre($settingsTabs);


            }

            if($sectionConfig->customColumns) {

            }
            PageContext::$response->sectionName = $sectionData->section_name;
            PageContext::$response->settingsTabs = $settingsTabs;

             }

            //print_r(PageContext::$request);

            if(isset($_POST['submit'])) {



            $postArray = array();
             //  echopre1(PageContext::$request['settings']);
           foreach (PageContext::$request['settings'] as $settings) {
            foreach ($settings['tabContent'] as $key => $value) {
             // echopre($settings['tabContent']);
               if(isset($value['settingfield'])) {
                    $postArray[$value['settingfield']] = $value['value'];
               }
                if(isset($value['vLookUp_Name'])) {
                    $postArray[$value['vLookUp_Name']] = $value['vLookUp_Value'];
               }
            }
          }

            $postArrayc   =    PageContext::$request;
           // echopre1( PageContext::$request['logofile']);
            if( PageContext::$request['logofile']){
            $postArray['sitelogo'] = isset($postArrayc['logofile']) ? $postArrayc['logofile'] : '';
            }
            $postArray['submit'] = isset($postArrayc['submit']) ? $postArrayc['submit'] : '';
            $postArray['section'] = isset($postArrayc['section']) ? $postArrayc['section'] : '';

        // echopre($postArray);

                if($sectionConfig->beforeEditRecord) {
                    $postArray    = call_user_func_refined($sectionConfig->beforeEditRecord,$postArray);
                    if($postArray['error']!="" && is_array($postArray)) {
                        $errorFlag  =   1;
                        pageContext::$response->errorMessage = $postArray['errormessage'];
                        PageContext::$response->message = "";
                    }
                }

                foreach ($settingsTabs as $column) {
                    foreach($column as $groups) {
                        /*foreach($groups as $group) {
                            if($group->type=="checkbox") {
                                if(key_exists($group->$labelField, PageContext::$request)) {
                                    $postArray[$group->$labelField]=1;
                                }
                                else {
                                    $postArray[$group->$labelField]=0;
                                }
                            }
                        }*/
                    }

                }
                //echopre1($postArray);
                if($errorFlag==0) {

                   // echopre($postArray);

                 if(!Cms::saveSettings($postArray,$sectionData->table_name,$sectionConfig->fieldAssignment)){

                    if($sectionConfig->afterEditRecord) {
                        $params    = call_user_func_refined($sectionConfig->afterEditRecord,$postArray);
                    }
                  //  $sucessMessage    =   "Settings edited successfully";
                   // header("Location:$currentURL&message=$sucessMessage");
                     $data['success'] = true;
                    $data['message'] =   "Record updated successfully.";
                     echo json_encode($data);
                    exit;
                 }else{
                      $data['error'] = true;
                  $data['message'] = 'Record cannot be updated.';
                  echo json_encode($data);
                  exit;
                   // throw new Exception( 'Error');
                }


                }
            }





       // $data =  Cms::getSettingsTabs($sectionData->table_name,$sectionConfig->fieldAssignment);
        echo json_encode($settingsTabs);
        exit;

    }

    public function dashboard() {
        //to get section config values
        $sectionData= Cms::getSectionData(PageContext::$request);
        PageContext::$response->message =   PageContext::$request['message'];
        $sectionConfig=$sectionData->section_config;
        $sectionConfig=json_decode($sectionConfig);
        //echopre($sectionConfig);

        if(CMS_GRAPH_TYPE=="JQUERY") {
            PageContext::$enableJquerychart=true;
        }
        else {
            PageContext::$enableFusionchart=true;
            include('public/fusioncharts/Class/FusionCharts_Gen.php');
        }
        //if listing panel enabled
        if($sectionConfig->dashboardPanel2) {


            PageContext::$response->sectionName = $sectionData->section_name;
            PageContext::$response->dashboardStyle2 = 1;

            $rowCount   =   $sectionConfig->rows;
            PageContext::$response->dashboardRowCount = $rowCount;
            for($rowLoop=1;$rowLoop<=$rowCount;++$rowLoop) {

                $rowsId =   "row".$rowLoop;
                $panelConfig =   $sectionConfig->$rowsId;


                $columnCount =   $panelConfig->columns;
                $row->columnCount    =   $columnCount;

                $rowArray[$rowLoop]->columnCount  =  $columnCount;


                for($columnLoop=1;$columnLoop<=$columnCount;$columnLoop++) {
                    $panelId                =   "column".$columnLoop;
                    $rowConfig     =   $panelConfig->$panelId;
                    if($rowConfig->display=="listing") {
                        $columnData[$rowLoop][$columnLoop]      =  call_user_func_refined($rowConfig->fetchValue);
                        $columnTitleLink[$rowLoop][$columnLoop] =  call_user_func_refined($rowConfig->titlelinkSection);

                        $columnConfig[$rowLoop][$columnLoop]      =   $rowConfig;
                    }
                    if($rowConfig->display=="graph") {
                        $graphConfig = new stdClass();
                        $grpahId        =   "column".$columnLoop;
                        $graphConfig    =   $panelConfig->$grpahId;
                        $startDate   = date('Y-m-d',strtotime("-1 week"));
                        $endDate     = date('Y-m-d');
                        $graphObj  = Graph::plotGraph($startDate,$endDate,$graphConfig,$grpahId);
                        $columnData[$rowLoop][$columnLoop]=$graphObj;

                        $columnConfig[$rowLoop][$columnLoop]  = $graphConfig;

                    }
                }
            }
            if($sectionConfig->customPanel) {
            	$customActionModule         =   $sectionConfig->customPanelRow->module;
            	$customActionController     =   $sectionConfig->customPanelRow->controller;
            	$customActionMethod         =   $sectionConfig->customPanelRow->method;
            	PageContext::$response->customActionModule      =   $customActionModule;
            	PageContext::$response->customActionController  =   $customActionController;
            	PageContext::$response->customActionMethod      =   $customActionMethod;
            	PageContext::addPostAction($customActionMethod,$customActionController,$customActionModule);

            }
            PageContext::$response->rowArray =     $rowArray;
            PageContext::$response->columnTitleLink =     $columnTitleLink;
            PageContext::$response->columnData =     $columnData;
            PageContext::$response->columnConfig =     $columnConfig;


        }
        else if($sectionConfig->dashboardPanel) {
            if($sectionConfig->listingPanel) {
                $listPanelRowCount   =   $sectionConfig->listinPanelRow;
                PageContext::$response->listinPanelRow   =   $listPanelRowCount;
                for($rowLoop=1;$rowLoop<=$listPanelRowCount;++$rowLoop) {

                    $listingId =   "listingPanel".$rowLoop;
                    $panelConfig =   $sectionConfig->$listingId;


                    $columnCount =   $panelConfig->columns;
                    $listingPanel->columnCount    =   $columnCount;

                    $listingPanelArray[$rowLoop]->columnCount  =  $columnCount;

                    //echopre( $graphPanelArray[$rowLoop]);
                    for($columnLoop=1;$columnLoop<=$columnCount;$columnLoop++) {
                        $panelId                =   "column".$columnLoop;
                        $listingPanelConfig     =   $panelConfig->$panelId;

                        $listData[$rowLoop][$columnLoop]      =  call_user_func_refined($listingPanelConfig->fetchValue);
                        $listTitleLink[$rowLoop][$columnLoop] =  call_user_func_refined($listingPanelConfig->titlelinkSection);

                        $listingDataColumns[$rowLoop][$columnLoop]      =   $listingPanelConfig;

                    }
                }

                PageContext::$response->listDataArray =     $listData;
                PageContext::$response->listTitleLink =     $listTitleLink;
                PageContext::$response->panelConfig =     $listingDataColumns;
                PageContext::$response->listingPanels =       $listingPanelArray;
            }
            //if graph panel enabled
            PageContext::$response->sectionName = $sectionData->section_name;
            PageContext::$metaTitle .= " | ".$sectionData->section_name;
            if($sectionConfig->graphPanel) {


                $graphRowCount   =   $sectionConfig->graphpanelRow;
                PageContext::$response->graphRowCount   =   $graphRowCount;
                for($rowLoop=1;$rowLoop<=$graphRowCount;++$rowLoop) {
                    $panelId =   "graphPanel".$rowLoop;
                    $panelConfig =   $sectionConfig->$panelId;
                    //echopre($panelConfig);
                    $columnCount =   $panelConfig->columns;
                    $graphPanel->columnCount    =   $columnCount;

                    $graphPanelArray[$rowLoop]->columnCount  =  $columnCount;
                    //echopre( $graphPanelArray[$rowLoop]);
                    for($columnLoop=1;$columnLoop<=$columnCount;$columnLoop++) {
                        $graphConfig = new stdClass();
                        $grpahId        =   "graph".$columnLoop;
                        $graphConfig    =   $panelConfig->$grpahId;
                        $startDate   = date('Y-m-d',strtotime("-1 week"));
                        $endDate     = date('Y-m-d');
                        $graphObj  = Graph::plotGraph($startDate,$endDate,$graphConfig,$grpahId);
                        $graphObjArray[$rowLoop][$columnLoop]=$graphObj;
                        $graphPanelConfigArray[$rowLoop][$columnLoop]  = $graphConfig;

                    }


                }
                PageContext::$response->graphPanelsConfig =     $graphPanelConfigArray;
                PageContext::$response->graphObjArray =     $graphObjArray;
                PageContext::$response->graphPanels =       $graphPanelArray;
                //echopre($graphPanelConfigArray);
                //echopre($graphPanelArray);

            }

             //if aggregateboxes
            if($sectionConfig->aggregatePanel) {
                $aggregatePanelRowCount   =   $sectionConfig->aggregatePanelRow;
                PageContext::$response->aggregatePanelRow   =   $aggregatePanelRowCount;


                for($rowLoop=1;$rowLoop<=$aggregatePanelRowCount;++$rowLoop) {

                    $aggregateId =   "aggregatePanel".$rowLoop;
                    $panelConfig =   $sectionConfig->$aggregateId;


                    $columnCount =   $panelConfig->columns;
                    $aggregatePanel->columnCount    =   $columnCount;

                    $aggregatePanelArray[$rowLoop]->columnCount  =  $columnCount;

                    //echopre( $aggregatePanelArray[$rowLoop]);
                    for($columnLoop=1;$columnLoop<=$columnCount;$columnLoop++) {
                        $panelId                =   "column".$columnLoop;
                        $aggregatePanelConfig     =   $panelConfig->$panelId;

                        $aggregateData[$rowLoop][$columnLoop]      =  call_user_func_refined($aggregatePanelConfig->fetchValue);
                        $aggregateTitleLink[$rowLoop][$columnLoop] =  call_user_func_refined($aggregatePanelConfig->titlelinkSection);

                        $aggregateDataColumns[$rowLoop][$columnLoop]      =   $aggregatePanelConfig;

                    }
                }



                PageContext::$response->aggregateDataArray =     $aggregateData;
                PageContext::$response->aggregateTitleLink =     $aggregateTitleLink;
                PageContext::$response->aggregatepanelConfig =     $aggregateDataColumns;
                PageContext::$response->aggregatePanels =       $aggregatePanelArray;
            }



            if($sectionConfig->customPanel) {
            	$customActionModule         =   $sectionConfig->customPanelRow->module;
            	$customActionController     =   $sectionConfig->customPanelRow->controller;
            	$customActionMethod         =   $sectionConfig->customPanelRow->method;
            	PageContext::$response->customActionModule      =   $customActionModule;
            	PageContext::$response->customActionController  =   $customActionController;
            	PageContext::$response->customActionMethod      =   $customActionMethod;
            	PageContext::addPostAction($customActionMethod,$customActionController,$customActionModule);

            }
        }

        $currentURL=Cms::formUrl(PageContext::$request,$sectionConfig);


    }
     public function logout() {
        $session    =   new LibSession();

        $sessionPrefix = Cms::getLoginSessionType();

        //echopre1($_SESSION); die();

        $role = $_SESSION['cms_role_id'];


        $session->set($sessionPrefix."admin_logged_in","");
        $session->set($sessionPrefix."admin_type","");
        $session->set($sessionPrefix."cms_username","");
        $session->set($sessionPrefix."user_id","");
        $session->set("module","");

        if(CMS_ROLES_ENABLED)
            $roleEnabled    =   1;
        if($roleEnabled){
            $session->set($sessionPrefix."role_id","");
        }


        session_destroy();
        header("location: ".BASE_URL.'cms');
        exit(0);

        /*if($role==1 || $role==0)
        header("location: ".BASE_URL.'cms');
        else
        header("location: ".BASE_URL); */
    }

    //check wether the admin is logged in or not
    public function checkLogin() {
        $session    =   new LibSession();

        $sessionPrefix = Cms::getLoginSessionType();

        if(!$session->get($sessionPrefix."admin_logged_in"))
            PageContext::$response->logged_in = 0;
        else
            PageContext::$response->logged_in = true;

        return PageContext::$response->logged_in;
    }
    // function for displaying invalid json format

    public function errordisplay() {

    }
    /*
      function to display deatils page
    */
    public function detailpage() {
        $perPageSize  =   PageContext::$response->cmsSettings['admin_page_count'];
        $sectionData= Cms::getSectionData(PageContext::$request);
        $sectionConfig=$sectionData->section_config;
        $sectionConfig=json_decode($sectionConfig);
        PageContext::$response->columns         =   $sectionConfig->columns;

        PageContext::$response->detail_section_config  =   $sectionConfig;
        $currentId = PageContext::$request['key'];


        $listDataResults= Cms::getRecordDetails($sectionData,PageContext::$request,$perPageSize);
        PageContext::$response->listDataResults =   $listDataResults;

        $this->view->disableLayout();

    }

    public  function save_ajax_form() {

        $sectionArray['section'] = $_POST['sectionName'];

        $sectionData= Cms::getSectionData($sectionArray);

        $sectionConfig=$sectionData->section_config;
        $sectionConfig=json_decode($sectionConfig);
        PageContext::$response->parent_section  =   $_POST['sectionName'];
        $currentURL=Cms::formUrl($sectionArray,$sectionConfig);
        PageContext::$response->currentURL     =   $currentURL;
        PageContext::$response->detail_section_config  =   $sectionConfig;
        PageContext::$response->listColumns     =   $sectionConfig->listColumns;
        PageContext::$response->columns         =   $sectionConfig->columns;
        PageContext::$response->combineTables  =    $sectionConfig->combineTables;
        PageContext::$response->relations       =   $sectionConfig->relations;

        PageContext::$response->sectionData     =   $sectionData;
        PageContext::$response->section_config->keyColumn   =   $sectionConfig->keyColumn;

        $session    =   new LibSession();
        if($roleEnabled && $session->get('admin_type')!="developer") {
            //opertaions allowed

            $session    =   new LibSession();
            $roleId = $session->get("role_id");


            $sectionId=  Cms::getSectionId(PageContext::$request['section']);
            $sectionRoles   =   Cms::getSectionRoles($sectionId);

            $parentRoleIDArray  =  Cms::getParentRoleList($roleId);

            if(!in_array($sectionRoles->view_role_id, $parentRoleIDArray)) {
                $viewPermission = 1;

            }
            if(!in_array($sectionRoles->add_role_id, $parentRoleIDArray)) {
                $addPermission = 1;

            }
            if(!in_array($sectionRoles->edit_role_id, $parentRoleIDArray)) {
                $editPermission = 1;

            }
            if(!in_array($sectionRoles->delete_role_id, $parentRoleIDArray)) {
                $deletePermission = 1;

            }
            if(!in_array($sectionRoles->publish_role_id, $parentRoleIDArray)) {
                $publishPermission = 1;

            }
        }
        else {
            $viewPermission = 1;
            $addPermission = 1;
            $editPermission = 1;
            $deletePermission = 1;
            $publishPermission = 1;

        }
        foreach($sectionConfig->opertations  as $operations) {
            if($operations=="add" && $addPermission)
                PageContext::$response->addAction   =   true;
            if($operations=="edit" && $editPermission)
                PageContext::$response->editAction   =   true;
            if($operations=="delete" && $deletePermission)
                PageContext::$response->deleteAction   =   true;
            if($operations=="customdelete" && $deletePermission) {
                PageContext::$response->deleteAction   =   true;
                $customDeleteOperation  =   1;
            }
            if($operations=="view" && $viewPermission)
                PageContext::$response->viewAction   =   true;
            if($operations=="publish" && $publishPermission)
                PageContext::$response->publishAction   =   true;


        }
        $primaryKeyvalue = $_POST['primary_key_value'];
        if($primaryKeyvalue=="")
            $action = "add";
        else
            $action = "edit";
        $response = Cms::formValidation($sectionConfig,$_POST,$_FILES,$action);
        PageContext::$response->action = $request['action'] ;
        if($response!=  "" ) {

            echo "formerror_".$response;
            exit;
        }
        else {
            $request['action'] = $_POST['jqFormMethodType'];
            $status=  Cms::saveForm($sectionData,$_POST,$request);
            if($status['error']=="") {
                $resArray['key']=$status;
                $listDataResults= Cms::getRecordDetails($sectionData,$resArray,$perPageSize);

                PageContext::$response->newrecord =   $listDataResults;
            }
            else {
                echo "error";
            }
        }

        $this->view->disableLayout();
    }



    public function menuData(){
        $menuList =  Cms::loadMenu();

         $data = array('records' => $menuList);
         $datas =  json_encode($data);

     //$this->view->disableView();

        echo $datas; exit;
    }

     public function titleData(){
        $sectiontype        =   PageContext::$request['sectiontype'];
        $titleList =  Cms::loadTitle($sectiontype);

         $data = array('records' => $titleList);
         $datas =  json_encode($data);

     //$this->view->disableView();

        echo $datas; exit;
    }


     public function tablename(){
        $sectiontype        =   PageContext::$request['sectiontype'];
        $titleList =  Cms::loadTable($sectiontype);

         $data = array('records' => $titleList);
         $datas =  json_encode($data);

     //$this->view->disableView();

        echo $datas; exit;
    }


    public function createBarDiaData() {

        $funcName   = $_GET["source"];
        $barColor   = $_GET["color"];
        $barLabel   = $_GET["label"];
        $date =  date("Y-m-d");
        $data = array();
        for ($i=7; $i>=1; $i--){
            $startDate =  date("Y-m-d", strtotime($i." days ago"));
            $endDate   =  date("Y-m-d", strtotime(($i-1)." days ago"));

            
            $day =   date("D (m/d)", strtotime($i." days ago"));

            $iCount    =  call_user_func($funcName, $startDate,$endDate,true);
            if($iCount > 0) {$iCount;} else { $iCount = 0;}
            $data[] =  array($day,$iCount);

        }
        //echopre1($data);

        $barJson   =  array("label" =>  $barLabel ,"color" => $barColor,"data" => $data);

        $file_dir  =  FILE_UPLOAD_DIR.'/diaJsonArr';
        if(!file_exists($file_dir)) {
            mkdir($file_dir);
        } else {
            self::delinkJsonfiles($file_dir);
        }
        chmod($file_dir,0777);
        $barJson =  json_encode(array($barJson));
        $fileName = 'bar-1'.time().'.json';
        $file_path = $file_dir.'/'.$fileName;
        file_put_contents($file_path, $barJson);
        chmod($file_path,0777);

        $file_url = BASE_URL.'project/files/diaJsonArr/'.$fileName;
        $result = array("file_url" =>  $file_url,'file_path' => $file_path);


        $result = json_encode($result);

        echo $result; exit;

    }
//line diagram
     public function createLineDiaData() {

        $funcName    = $_GET["source"];
        $lineColor   = $_GET["color"];
        $lineLabel   = $_GET["label"];
        $date =  date("Y-m-d");
        $data = array();
     for ($i=7; $i>=1; $i--){
            $startDate =   date("Y-m-d", strtotime($i." days ago"));
            $endDate   =  date("Y-m-d", strtotime(($i-1)." days ago"));
          
            $day =   date("D (m/d)", strtotime($i." days ago"));
            //source
           // $iCount    =   Cmshelper::getTransactionCount($startDate,'',true);
            $iCount    =  call_user_func($funcName, $startDate,$endDate,true);
            ($iCount > 0 ? $iCount : $iCount = 0 );
            $data[] =  array($day,$iCount);
        }

        $lineJson   =  array("label" =>  $lineLabel ,"color" => $lineColor,"data" => $data);
        $file_dir  =  FILE_UPLOAD_DIR.'/diaJsonArr';
        if(!file_exists($file_dir)) {
            mkdir($file_dir);
        } else {
            self::delinkJsonfiles($file_dir);
        }
        chmod($file_dir,0777);

        $lineJson =  json_encode(array($lineJson));
        $fileName = 'line-1'.time().'.json';
        $file_path = $file_dir.'/'.$fileName;
        file_put_contents($file_path, $lineJson);
        chmod($file_path,0777);

        $file_url = BASE_URL.'project/files/diaJsonArr/'.$fileName;
        $result = array("file_url" =>  $file_url,'file_path' => $file_path);


        $result = json_encode($result);

        echo $result; exit;

    }






    //pie diagram
     public function createPieDiaData() {
        $funcName    = $_GET["genre"];
        $key   = $_GET["key"];
        $dcount   = $_GET["dcount"];
        $genre = trim($_GET["genre"]);
        $genreArr = json_decode($genre);
        //print_r($genre);
        $output  = array();
        for( $d_i = 1 ; $d_i<=$dcount;$d_i++){
           $b = 'dataset'.$d_i;
           $a1 = $genreArr->dataSets->$b;
           $lineUrl = $a1->fetchValue;
           $color = $a1->color;
           $label = $a1->name;
           $count = self::pieDia($lineUrl,$color,$label);
           $output[] = array('color' => $color, 'data' => $count, 'label' => $label);

        }
       // print_r($output);

       // die("gner");

        $pieJson   =  $output;
        $file_dir  =  FILE_UPLOAD_DIR.'/diaJsonArr';
        if(!file_exists($file_dir)) {
            mkdir($file_dir);
        } else {
            self::delinkJsonfiles($file_dir);
        }


        $pieJson =  json_encode($pieJson);


        $fileName = 'pie-1'.time().'.json';
        $file_path = $file_dir.'/'.$fileName;
        file_put_contents($file_path, $pieJson);

        $file_url = BASE_URL.'project/files/diaJsonArr/'.$fileName;
        $result = array("file_url" =>  $file_url,'file_path' => $file_path,'pieJson' => $pieJson);


        $result = json_encode($result);

        echo $result; exit;

    }

     public function pieDia($lineUrl,$color,$label)
     {
        $funcName    = $lineUrl;
        $lineColor   = $color;
        $lineLabel   = $label;
        $date =  date("Y-m-d");
       // $data = array();
       // for ($i=0; $i<7; $i++){
            $startDate =   date("Y-m-d", strtotime("1000 days ago"));
            $endDate =   date("Y-m-d", strtotime("1 days ago"));
          
            $iCount    =  call_user_func($funcName, $startDate,$endDate,true);
            ($iCount > 0 ? $iCount : $iCount = 0 );
           // $data[] =  array($day,$iCount);
            $data =  $iCount;
          
        return $data;

     }

    public function delinkJsonfiles($file_dir) {
        $files= scandir($file_dir); // get all file names
        foreach($files as $file){ // iterate files
            if($file != '.' && $file != '..') {
               $fileCreationTime = date("Y-m-d H:i:s", filemtime($file_dir.'/'.$file));
               $timelimit =   date("Y-m-d H:i:s", strtotime("-10 minutes"));
               if(strtotime($fileCreationTime)  < strtotime($timelimit)) {
                    chmod($file_dir.'/'.$file, 0644);
                    unlink($file_dir.'/'.$file);
               }
            }
        }
    }

    public function formangularimgData(){
        $random = PageContext::$request['random_key'];
      /*  $image1 = PageContext::$request['image1'];
        $image2 = PageContext::$request['image2'];
          if($random && $image1 == ''){*/
             $result = Cms::saveImageForm($random);
         /*   }else{
             $result = Cms::updateImageForm($random,$image1);
             $result = Cms::updateImageForm($random,$image2);
            }*/
        echo $result; exit;
    }

    public function formangularlogoData(){
        $result = Cms::saveLogoForm();
        echo $result; exit;
    }

     public function formangularData(){
     	//print_r($_FILES);




        //echopre1($_POST);
        $headers =  getallheaders();
      //echopre($headers); die();
        //if($_POST['deviceType']!="webUI"){

         if($headers['accessToken'] != "" ){
        //$headers =  getallheaders();


        $accessToken=$headers['accessToken'];
        $res=Cms::authAccessToken($accessToken);
        if(count($res)>0){
            $auth=TRUE;

        }else{
            $auth=FALSE;
            $returnData=array();
            $returnData['status']="0";
            $returnData['status_msg']="Authentication failure.";
            //echo "Generating token";
            $accessToken=$this->json($returnData);
            echo $accessToken;
            exit();


        }




        /* }else{

            $returnData=array();
            $returnData['status']="0";
            $returnData['status_msg']="Invalid credentials.";
            //echo "Generating token";
            $accessToken=$this->json($returnData);
            echo $accessToken;
            exit();
        } */

    }   elseif(strtolower($_POST['deviceType']) == "webui"){

        $auth=TRUE;
    }else{
        self::invalidRequest();

    }

        // Validating using section data config
        PageContext::$request['section'] = $_POST['sectionName'];
        $sectionData= Cms::getSectionData(PageContext::$request);
        $sectionConfig=$sectionData->section_config;
        $sectionConfig=json_decode($sectionConfig);
        //echopre1($sectionConfig);



        if ($sectionConfig === null ) {
            echo "<br>Error: Incorrect JSON Format<br><br>";

        }
        //Cms::formValidation($sectionConfig,$post,$files,$action)

        $type = $_POST['type'];
        $keyColumnName = $_POST['keyname'];
   /* if($_POST['user']!=''){*/

        if($auth== TRUE){


      switch ($type) {
        case "save_form":

        	//echopre1($_POST);
        	if($_POST['deviceType']=="webUI"){

        	if ($_FILES) {
        		// print_r($_FILES);

        		$fileHandler = new Filehandler();

        		if ($_FILES['file']['name']) {

        			//echopre1($_POST['user']['random_key']);
        			$fileDetails = $fileHandler->handleUpload($_FILES['file'],$_POST['user']['random_key']);
        			$file_id = $fileDetails->file_id;
        			//echopre1($file_id);
        			//$position = 'header';
        			// print_r($fileDetails);

        		}
        	}
        }

            PageContext::$request['user'] = '';
           // PageContext::$request['section'] = $_POST['sectionName'];
            PageContext::$request[$keyColumnName] = $_POST['keyvalue'];
            $sectionArray['section'] = $_POST['sectionName'];

            foreach ($_POST['user'] as $key => $value) {
                PageContext::$request[$key] = $value;
                $_POST[$key] = $value;
            }



            $_POST['user']='';

            //$sectionData= Cms::getSectionData($sectionArray);



           if(PageContext::$request['action']  ==   "edit") {

           	/**
           	 * Image Change
           	 *
           	 */


             if(Cms::saveForm($sectionData,$_POST,PageContext::$request)){
                $data['success'] = true;
                $data['message'] =   "Record updated successfully.";
                 echo json_encode($data);
                 exit;
               // PageContext::$response->showForm    =   FALSE;
                 }else{
                      $data['error'] = true;
                  $data['message'] = 'Record cannot be updated.';
                  echo json_encode($data);
                  exit;
                   // throw new Exception( 'Error');
                }
            }else{

                $action=PageContext::$request['action'];

                $response = Cms::formValidation($sectionConfig,$_POST,$_FILES,$action);
               // echopre1($response);
                if($response != ""){

                    $data['error'] = true;
                    $data['message'] = 'Record cannot be added.';
                    echo json_encode($data);
                    exit;

                }

                else{
                    //echopre($sectionData);
                    //echopre($_POST);
                    //echopre(PageContext::$request);
                $return_params = Cms::saveForm($sectionData,$_POST,PageContext::$request);  //echopre1($return_params);
                    if(is_numeric($return_params)){
                        $data['success'] = true;
                        $data['message'] = 'Record added successfully.';
                        echo json_encode($data);
                        exit;
                    }else if($return_params['error']){
                        $data['error'] = true;
                        $data['message'] = $return_params['errormessage'].', Record cannot be added.';
                        echo json_encode($data);
                        exit;
                    }

                    /*if(Cms::saveForm($sectionData,$_POST,PageContext::$request)){

                        $data['success'] = true;
                        $data['message'] = 'Record added successfully.';
                        echo json_encode($data);
                        exit;
                    } */


                }

                /* if(Cms::saveForm($sectionData,$_POST,PageContext::$request)){
                     $data['success'] = true;
                      $data['message'] = 'Record added successfully.';
                      echo json_encode($data);
                      exit;
                }else{
                    $data['error'] = true;
                  $data['message'] = 'Record cannot be added.';
                  echo json_encode($data);
                  exit;
                    //throw new Exception( 'Error');
                }*/
            }
          break;
        case "delete_data":
          //delete_user($mysqli, $_POST['id']);
           PageContext::$request = array();
            PageContext::$request['section'] = $_POST['sectionName'];
            PageContext::$request['action'] = 'delete';
            PageContext::$request[$keyColumnName] = $_POST['keyvalue'];
            $sectionArray['section'] = $_POST['sectionName'];
            $sectionData= Cms::getSectionData($sectionArray);
            $return1 = Cms::deleteEntry($sectionData,PageContext::$request);
            //echopre($return);
            if(isset($return1['error']) && $return1['error']!=''){
                  $data['error']   = true;
                  if(trim($return1['errormessage']) <> "")
                      $data['message'] = $return1['errormessage'];
                  else
                      $data['message'] = 'Record cannot be deleted.';//$return1['errormessage'];
                  echo json_encode($data);
                  exit;

            }else{
                  $data['success'] = true;
                  $data['message'] = 'Record deleted successfully.';
                  echo json_encode($data);
                  exit;
                //throw new Exception( 'Error');
            }
          break;

        case "publish_data":
          //publish_data($mysqli, $_POST['id']);
          //  echopre1(PageContext::$request);
           PageContext::$request = array();


            PageContext::$request['section'] = $_POST['sectionName'];
            PageContext::$request['action'] = 'publish';
            PageContext::$request[$keyColumnName] = $_POST['keyvalue'];

            $sectionArray['section'] = $_POST['sectionName'];

            $sectionData= Cms::getSectionData($sectionArray);

           //  echopre1(PageContext::$request);
            if(Cms::changePublishStatus($sectionData,PageContext::$request)){
                 $data['success'] = true;
                  $data['message'] = 'Record published successfully.';
                  echo json_encode($data);
                  exit;
            }else{
                 $data['error'] = true;
                  $data['message'] = 'Record cannot be published.';
                  echo json_encode($data);
                  exit;
                //throw new Exception( 'Error');
            }
          break;

          case "view_data":
          //publish_data($mysqli, $_POST['id']);
          //  echopre1(PageContext::$request);
           PageContext::$request = array();


            PageContext::$request['section'] = $_POST['sectionName'];
            PageContext::$request['action'] = $_POST['action'];
            PageContext::$request['searchField'] = $_POST['keyname'];
            PageContext::$request['searchText'] = $_POST['keyvalue'];

            $sectionArray['section'] = $_POST['sectionName'];
            $perPageSize = 10;
            $sectionData= Cms::getSectionData($sectionArray);
            $listDataResults= Cms::listData($sectionData,PageContext::$request,$perPageSize);
           // echopre1(PageContext::$request);
            if(!empty($listDataResults)){
                  $data["status"] = 1;
                  $data["data"] = $listDataResults;
                  $data['error'] = NULL;
                  echo json_encode($data);
                  exit;
            }else{

                  $data['status'] = 0;
                  $data['data'] = 0;
                  $data['error'] = 'No data found.';
                  echo json_encode($data);
                  exit;
                //throw new Exception( 'Error');
            }
          break;

        default:
          self::invalidRequest();
      }


    }  else{
        self::invalidRequest();

    }
      /*}else{
         $data['error'] = true;
          $data['message'] = 'Record not added successfully.';
          echo json_encode($data);
          exit;
      }*/
    }




    public function deletealldata()
    {
            PageContext::$request['tableName'] = $_POST['tableName'];

            if(Cms::deleteallDatas(PageContext::$request)){
                 $data['success'] = true;
                  $data['message'] = 'All Records deleted successfully.';
                  echo json_encode($data);
                  exit;
            }else{
                 $data['error'] = true;
                  $data['message'] = 'All Records cannot be deleted.';
                  echo json_encode($data);
                  exit;
                //throw new Exception( 'Error');
            }
    }


    public function invalidRequest()
    {
      $data = array();
      $data['success'] = false;
      $data['message'] = "Invalid request.";
      echo json_encode($data);
      exit;
    }

     public  function sectionconfig(){
         $data = array();
        $data = Cms::sectionconfig(PageContext::$request);
         echo json_encode($data);
        exit;
     }


     public  function externalconfig(){
         $data = array();
         $data = call_user_func_refined(PageContext::$request['source']);
        // var_dump($data);die('sad');
         echo json_encode($data);
        exit;
     }


      public  function cmsettings(){
         $data = array();
        $data = Cms::getCmsSettings();
         echo json_encode($data);
        exit;
     }

      public  function listangularData(){
//$this->view->disableLayout();

        if(CMS_ROLES_ENABLED)
            $roleEnabled    =   1;
        $perPageSize  =   PageContext::$response->cmsSettings['admin_page_count'];
        //$perPageSize  =   '500000';
        $date_separator =    GLOBAL_DATE_FORMAT_SEPERATOR;
        if($date_separator!="GLOBAL_DATE_FORMAT_SEPERATOR")
            $date_separator =  GLOBAL_DATE_FORMAT_SEPERATOR;
        else {
            $date_separator = "-";
        }
        $currentDate    =   date("m".$date_separator."d".$date_separator."Y");
        $monthStartDate    =   date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),1,date("Y")));
        PageContext::$response->currentDate =   $currentDate;
        PageContext::$response->monthStartDate =   $monthStartDate;
        PageContext::addJsVar("formError", 0);
        PageContext::addJsVar("action",  PageContext::$request['action']);

        PageContext::$enableFCkEditor=true;
        PageContext::$response->enableTokenInput = false;

        $errormessage = PageContext::$request['errormessage'];
        pageContext::$response->errorMessage          =   $errormessage;
        //to get section config values

        $sectionData= Cms::getSectionData(PageContext::$request);
       // echopre($sectionData);
        if(isset(PageContext::$request['parent_id'])) {
            $parentSectionData  = Cms::getParentSectionData(PageContext::$request);
            PageContext::$response->parentSectionName = $parentSectionData->section_name;
            PageContext::$metaTitle .= " | ".$parentSectionData->section_name;
            $parentSectionItem  =Cms::listParentItem($parentSectionData,PageContext::$request);
            PageContext::$response->parentBreadCrumbName = $parentSectionItem;

            $parentURL=Cms::formParentUrl(PageContext::$request);
            PageContext::$response->parentURL = $parentURL;

        }
        PageContext::$response->sectionName = $sectionData->section_name;
        PageContext::addJsVar("sectionName", $sectionData->section_alias);
        PageContext::$metaTitle .= " | ".$sectionData->section_name;
        $sectionConfig=$sectionData->section_config;
        $sectionConfig=json_decode($sectionConfig);
        if ($sectionConfig === null ) {
            echo "<br>Error: Incorrect JSON Format<br><br>";

        }

// echopre1($sectionConfig->dataSource);

        //to get list data for a particular section
        //external data source
        if($sectionConfig->dataSource) {
            $requestParams = PageContext::$request;
            $requestParams['perPageSize'] = $perPageSize;

            $listDataResults      =  call_user_func_refined($sectionConfig->dataSourceFunction,$requestParams);
        }
        else



        $listDataResults= Cms::listData($sectionData,PageContext::$request,$perPageSize);



        $loopVar=0;
        $listData= array();
        foreach($listDataResults  as $record) {

            //  echopre($sectionConfig->detailColumns);

            foreach($sectionConfig->detailColumns as $col) {



                foreach($sectionConfig->columns as $key =>  $val) {

                    if($col==$key) {



                        if($val->editoptions->type   ==   "file") {
                            $record->$col   =   Cms::getThumbImage($record->$col,60,60);
                        }

                        // if it is date, then convert it into a standard format
                        if($val->editoptions->type   ==   "datepicker") {
                            $record->$col   =   Cms::getTimeFormat($record->$col,$val->dbFormat,$val->displayFormat);
                        }
                        else  if($val->dbFormat) {

                            $record->$col   =   Cms::getTimeFormat($record->$col,$val->dbFormat,$val->displayFormat);
                        }
                        else if($val->editoptions->type   ==   "htmlEditor") {

                            $record->$col   =   htmlspecialchars_decode($record->$col);
                            $record->$col = str_replace("&#160;", "", $record->$col);
                        }

                        else if($val->customColumn) {

                            $columnName     =   $sectionConfig->keyColumn;
                            $primaryKeyValue =   $record->$columnName;

                            $record->$col      =  call_user_func_refined($val->customaction,$primaryKeyValue);

                            if($val->popupoptions) {
                                $functionName   =   $val->popupoptions->customaction;
                                $columnName     =   $sectionConfig->keyColumn;
                                $params['id']         =   $record->$columnName;
                                $params['value']         =   $record->$col;

                                $externalLink   =   call_user_func_refined($functionName,$params);

                                $colValue=  substr($record->$col,0,30);

                                $record->$col =  "<a href='".$externalLink."' class='jqPopupLink btn btn-link' rel='link_".$params['id']."' >".$colValue."</a>";
                            }

                        }
                        else {
                            if(trim($record->$col)!=   "" ) {

                                if($val->externalNavigation) {
                                    $functionName   =   $val->externalNavigationOptions->source;
                                    if($val->external)
                                        $columnName     =   "external_".$key;
                                    else
                                        $columnName     =   $sectionConfig->keyColumn;
                                    $params         =   $record->$columnName;

                                    $externalLink   =  call_user_func_refined($functionName,$params);

                                    $colValue=  substr($record->$col,0,30);

                                    $record->$col =   "<a  href='".$externalLink."' target='_blank'>".$colValue."</a>";
                                }
                                else if($val->listoptions) {
                                    $functionName   =   $val->listoptions->customaction;
                                    $columnName     =   $sectionConfig->keyColumn;
                                    $params['id']   =   $record->$columnName;
                                    $params['value']=   $record->$col;

                                    $externalLink   =  call_user_func_refined($functionName,$params);

                                    $colValue=  substr($record->$col,0,30);



                                    foreach($val->listoptions->enumvalues as $enumKey  => $enumValue) {

                                        $buttonColor  =   $val->listoptions->buttonColors->$enumKey;
                                        if($buttonColor=="green")
                                            $buttonClass  =   "btn-success";
                                        else if($buttonColor=="red")
                                            $buttonClass  =   "btn-danger";

                                        if($enumKey==$record->$col) {
                                            //$record->$col =  $enumKey.'{cms_separator}<a href="'.$externalLink.'" id="button_'.$key.':'.$enumKey.':'.$params.'" class=" jqCustom btn btn-sm '.$buttonClass.'" >'.$enumValue.'</a>';

                                            $record->$col =  '<a  href="'.$externalLink.'" rel="button_'.$key.':'.$enumKey.':'.$params.'"  class=" jqCustom btn btn-sm '.$buttonClass.'" >'.$enumValue.'</a>';
                                        }
                                    }
                                }
                                else if($val->popupoptions) {
                                    $functionName   =   $val->popupoptions->customaction;
                                    $columnName     =   $sectionConfig->keyColumn;
                                    $params['id']         =   $record->$columnName;
                                    $params['value']         =   $record->$col;

                                    $externalLink   =  call_user_func_refined($functionName,$params);

                                    $colValue=  substr($record->$col,0,30);

                                    $record->$col =  "<a href='".$externalLink."' class='jqPopupLink btn btn-link' id='link_".$params['id']."' >".$colValue."</a>";


                                }
                                else if($val->decimalPoint) {
                                    $record->$col =  $val->prefix.number_format($record->$col,$val->decimalPoint).$val->postfix;
                                }
                                else
                                    $record->$col =  $val->prefix.html_entity_decode($record->$col).$val->postfix;
                            }
                            else {

                                if($val->editoptions->defaulttext) {


                                    $record->$col = ''.$val->editoptions->defaulttext.'';

                                }
                                else
                                    $record->$col = '-';
                            }
                        }
                        break;

                    }

                }
                foreach($sectionConfig->combineColumns as $key) {
                    if($col==$key) {
                        if(trim($record->$col)!=   "" )
                            $record->$col =   $record->$col;
                        else {

                            if($val->defaulttext) {


                                $record->$col = ''.$val->defaulttext.'';

                            }
                            else
                                $record->$col = '-';
                        }
                    }

                }


                foreach ($val->editoptions->enumvalues as $sourcekey => $sourcevalue) {
                   // echopre($val->editoptions);
                            if($col==$sourcekey) {
                               if($sourcekey=="1"){
                                $record->$col = "Active";
                                }
                               elseif($sourcekey=="0"){
                                $record->$col = "Inactive";
                                }else{}
                               // echopre($record->$col);
                         }
                     }




            }

            $listData[]=$record;

            if($sectionConfig->relations){
                foreach($sectionConfig->relations  as $key => $val) {

                    $joinCount  =   Cms::getJoinResult($sectionData,$val,$record);
                    $listData[$loopVar]->$key   =   $joinCount;
                }
            }

            $loopVar++;
        }


        $session    =   new LibSession();
        if($roleEnabled && $session->get('admin_type')!="developer") {
            //opertaions allowed

            $session    =   new LibSession();

            $sessionPrefix = Cms::getLoginSessionType();
            $roleId = $session->get($sessionPrefix."role_id");

            $sectionId     =  Cms::getSectionId(PageContext::$request['section']);

            if(!$sectionId){
                $this->redirect("");
            }

            $sectionRoles   =   Cms::getSectionRoles($sectionId);

            $parentRoleIDArray  =  Cms::getParentRoleList($roleId);

            if(!in_array($sectionRoles->view_role_id, $parentRoleIDArray)) {
                $viewPermission = 1;

            }
            if(!in_array($sectionRoles->add_role_id, $parentRoleIDArray)) {
                $addPermission = 1;

            }
            if(!in_array($sectionRoles->edit_role_id, $parentRoleIDArray)) {
                $editPermission = 1;

            }
            if(!in_array($sectionRoles->delete_role_id, $parentRoleIDArray)) {
                $deletePermission = 1;

            }
            if(!in_array($sectionRoles->publish_role_id, $parentRoleIDArray)) {
                $publishPermission = 1;

            }
        }
        else {
            $viewPermission = 1;
            $addPermission = 1;
            $editPermission = 1;
            $deletePermission = 1;
            $publishPermission = 1;

        }
        foreach($sectionConfig->opertations  as $operations) {
            if($operations=="add" && $addPermission)
                PageContext::$response->addAction   =   true;
            if($operations=="edit" && $editPermission)
                PageContext::$response->editAction   =   true;
            if($operations=="delete" && $deletePermission)
                PageContext::$response->deleteAction   =   true;
            if($operations=="customdelete" && $deletePermission) {
                PageContext::$response->deleteAction   =   true;
                $customDeleteOperation  =   1;
            }
            if($operations=="view" && $viewPermission)
                PageContext::$response->viewAction   =   true;
            if($operations=="publish" && $publishPermission)
                PageContext::$response->publishAction   =   true;


        }
//        //custom operations
        //$customOperationsList= new stdClass();
        //$customOpLoop=0;

        $customOperationsList = array();

        foreach($listDataResults  as $dt) {

            $customOperations = array();

            foreach( $sectionConfig->customOperations as $key=>$val) {
                $opt = new stdClass();
                $columnName     =   $sectionConfig->keyColumn;
                $params         =   $dt->$columnName;

                $link           =   call_user_func_refined($val->options->linkSource,$params);

                $opt->name      =   $val->options->name;
                if($val->options->target=="newtab")
                    $target =   "target='_blank'";
                else
                    $target = "";

                $opt->link      =   "<a href='".$link."' $target class='cms_list_operation ".$val->options->class."' title='".$val->options->title."'>".$opt->name."</a>";

                $customOperations[$key]     =  $opt;

            }

            //echopre($customOperations);


            $customOperationsList[]         =   $customOperations;





        }//echopre($customOperationsList);

        // echo '<br><br><br><br><br>before: ';echopre($customOperationsList);
        //echopre1($customOperationsList);
        PageContext::$response->customOperationsList  =   $customOperationsList;

///echopre/($sectionConfig->customOperations);
        //to get total number of results in each section
        if($sectionConfig->dataSource) {

            $numResListData = call_user_func_refined($sectionConfig->dataSourceCountFunction,PageContext::$request);
        }
        else
            $numResListData=Cms::listDataNumRows($sectionData,PageContext::$request);


        $numRowsListData=$numResListData;
        //to get total number of result pages
        $totalResulPages=ceil($numRowsListData/$perPageSize);
        PageContext::addJsVar("totalResulPages", $totalResulPages);
        //to form url using GET params
        $currentURL=Cms::formUrl(PageContext::$request,$sectionConfig);
        $searchURL=Cms::formSearchUrl(PageContext::$request);
        $pageUrl=Cms::formPagingUrl(PageContext::$request);
        PageContext::addJsVar("searchURL", $searchURL);
        if(PageContext::$request['page']!="") {
            $pageUrl=$pageUrl;
            $pageUrl    =   str_replace("page=".PageContext::$request['page'], "", $pageUrl);
            $pageUrl=$pageUrl."&";
        }
        else
            $pageUrl=$pageUrl."&";
        PageContext::$response->pagination      =   Cms::pagination($numRowsListData,$perPageSize,$pageUrl,PageContext::$request['page']);
        PageContext::$response->columnNum       =   count($sectionConfig->detailColumns)+4;
        PageContext::$response->currentURL      =   $currentURL;
        PageContext::$response->totalResultsNum =   $numRowsListData;
        PageContext::$response->resultsPerPage  =   $perPageSize;
        PageContext::$response->resultPageCount =   $totalResulPages;
        PageContext::$response->request         =   PageContext::$request;
        PageContext::$response->section_config  =   $sectionConfig;
        PageContext::$response->listColumns     =   $sectionConfig->listColumns;
        PageContext::$response->columns         =   $sectionConfig->columns;
        PageContext::$response->combineTables  =    $sectionConfig->combineTables;
        PageContext::$response->relations       =   $sectionConfig->relations;
        PageContext::$response->listData        =   $listData;
        PageContext::$response->sectionData     =   $sectionData;

        PageContext::$response->section_config->keyColumn   =   $sectionConfig->keyColumn;

        PageContext::$response->multiselectActions =  $sectionConfig->multiselectActions;

        $editURL=Cms::formUrl(PageContext::$request,$sectionConfig,1);
        pageContext::$response->editURL          =   $editURL;

        $searchableCoumnsList    =   Cms::getSearchableColumns($sectionData);
        PageContext::$response->searchableCoumnsList   =   $searchableCoumnsList;
        // if action is add
        if( PageContext::$request['action']=="add" || $sectionConfig->displayForm=="popup" )
            PageContext::$response->showForm=TRUE;
        // if action is edit
        if(PageContext::$request['action']=="edit"  || $sectionConfig->displayForm=="popup") {
            PageContext::$response->showForm=TRUE;
            //to get list data for a particular section

            $listItem= Cms::listItem($sectionData,PageContext::$request);
        }
        // diffrent methods for displaying form displayForm
        //

        if($sectionConfig->displayForm=="popup")
            $displayFormMethod = "popup";
        else
            $displayFormMethod = "currentpage";
        PageContext::$response->displayFormMethod = $displayFormMethod;

        // if multiselect action is delete
        if(PageContext::$request['multiselectaction']!='') {
            $multiselectaction = PageContext::$request['multiselectaction'];
            //         echopre1(PageContext::$request);
            if(PageContext::$request['actionColumnList']==''){
                $message = "Please select atleast one record.";
                $currentURL =   $currentURL."&errormessage=$message";
                header("Location:$currentURL");
                exit;
            }
            else{
                $statusArray = call_user_func_refined($sectionConfig->multiselectActions->$multiselectaction->actionOperationSource,PageContext::$request['actionColumnList']);

                if($statusArray['status']=="error") {
                    $message = $statusArray['message'];
                    $currentURL =   $currentURL."&errormessage=$message";
                    header("Location:$currentURL");
                    exit;
                }
                else {
                    if($statusArray['status']=="success") {
                        $message = $statusArray['message'];
                        if($message=="") {
                            $message = 'Action '.$sectionConfig->multiselectActions->$multiselectaction->name.' performed for the selected records.';
                            $currentURL =   $currentURL."&message=$message";
                            header("Location:$currentURL");
                            exit;
                        }
                        else {
                            $currentURL =   $currentURL."&message=$message";
                            header("Location:$currentURL");
                            exit;
                        }
                    }
                }


            }
        }

        // if action is delete
        if(PageContext::$request['action']=="delete") {
            if($customDeleteOperation) {

                $statusArray = call_user_func_refined($sectionConfig->customDeleteOperation,PageContext::$request[$sectionConfig->keyColumn]);

                if($statusArray['status']=="error") {
                    $message = $statusArray['message'];
                    $currentURL =   $currentURL."&errormessage=$message";
                    header("Location:$currentURL");
                    exit;
                }
                else {
                    if($statusArray['status']=="success") {
                        $message = $statusArray['message'];
                        if($message=="") {
                            $currentURL =   $currentURL."&msgFlag=1";
                            header("Location:$currentURL");
                            exit;
                        }
                        else {
                            $currentURL =   $currentURL."&errormessage=$message";
                            header("Location:$currentURL");
                            exit;
                        }
                    }
                }



            }
            else {


                $status = Cms::deleteEntry($sectionData,PageContext::$request);
                if($status['error']!="" && is_array($status)) {
                    $objForm->form_error_message        =   $status['errormessage'];
                    $errorFlag  =   1;

                }
                else {
                    $currentURL =   $currentURL."&msgFlag=1";
                    header("Location:$currentURL");
                exit;
                }
            }
        }

        // if action is publish
        if((PageContext::$request['action']=="publish") || (PageContext::$request['action']=="unpublish")) {
            Cms::changePublishStatus($sectionData,PageContext::$request);
            if(PageContext::$request['action']=="publish")
                $currentURL =   $currentURL."&msgFlag=2";
            if(PageContext::$request['action']=="unpublish")
                $currentURL =   $currentURL."&msgFlag=3";
            header("Location:$currentURL");
            exit;
        }

        // logic for creating form
        $objForm = new Htmlform();
        $errorFlag = 0;
        $objForm->method    = "POST";
        $objForm->action    = $currentURL;
        if($sectionConfig->handleFile) {
            $objForm->handleFile    =   true;
        }
        $objForm->name      = "form_".PageContext::$response->section_alias;
        if(PageContext::$request['action']=="edit")
            $objForm->form_title  = "Edit ".PageContext::$response->sectionName ;
        else
            $objForm->form_title  = "Add ".PageContext::$response->sectionName ;

        $objForm->displayMethod     = $sectionConfig->displayForm;

        foreach($sectionConfig->detailColumns as  $col) {
            $val = $sectionConfig->columns->$col;

            if($val->editoptions) {

                $objFormElement                     =   new Formelement();
                $objFormElement->type               =   $val->editoptions->type;
                $objFormElement->name               =   $col;
                $objFormElement->id                 =   $col;
                $objFormElement->placeholder        =   $val->editoptions->placeholder;

                $objFormElement->label              =   $val->editoptions->label;
                $objFormElement->width              =   $val->editoptions->width;
                if(PageContext::$request['action']  ==    "edit") {
                    if( $objFormElement->type=="hidden") {
                        if($listItem[0]->$col)
                            $objFormElement->value          =   $listItem[0]->$col;
                        else
                            $objFormElement->value          =   $val->editoptions->value;
                    } else
                        $objFormElement->value          =   $listItem[0]->$col;
                    ////$val->editoptions->value;

                    //disable field on edit option for textbox, checkbox,radiobutton, selectbox, textarea, datepicker
                    $objFormElement->onEdit             =   $val->editoptions->onEdit;

                }
                else if(PageContext::$request['action']  ==    "add") {
                    if( $objFormElement->type=="hidden")
                        $objFormElement->value          =   $val->editoptions->value;
                    else
                        $objFormElement->value          =   $_POST[$col];//$val->editoptions->value;
                }else {
                    $objFormElement->value          =   $val->editoptions->value;
                }
                $objFormElement->default            =   $val->editoptions->default;
                $objFormElement->class              =   $val->editoptions->class;
                $objFormElement->prehtml            =   $val->editoptions->prehtml;
                $objFormElement->posthtml           =   $val->editoptions->posthtml;
                $objFormElement->source             =   $val->editoptions->source;
                $objFormElement->sourceType         =   $val->editoptions->source_type;
                $objFormElement->validations        =   $val->editoptions->validations;
                $objFormElement->hint               =   $val->editoptions->hint;
                $objFormElement->dbFormat           =   $val->dbFormat;
                $objFormElement->displayFormat      =   $val->displayFormat;
                $objFormElement->enumvalues         =   $val->editoptions->enumvalues;
                $objFormElement->options            =   $val->editoptions->options;
                $objFormElement->editorType         =   $val->editoptions->editorType;

                $objFormElement->defaultOptionLabel =   $val->editoptions->defaulttext;
                if( $objFormElement->type=="file"){
                    $objFormElement->fileType = $listItem[0]->file_mime_type;

                }

                //tokenInput
                if( $objFormElement->type=="tags"){
                    $objFormElement->tagDetails          =   $val->editoptions->tagDetails;
                    PageContext::$response->enableTokenInput = true;
                }

                $objFormElement->primaryKeyValue         =  PageContext::$request[$sectionConfig->keyColumn];
                PageContext::addJsVar("primaryKeyValue", $objFormElement->primaryKeyValue);

                $objForm->addElement($objFormElement);
                if(isset($_POST['submit'])) {

                    $objFormValidation                      =   new Formvalidation();
                    if($val->editoptions->type  ==   "file") {
                        // if($val->editoptions->value=="")
                        if(PageContext::$request['action']  ==    "add") {
                            $response   =   $objFormValidation->validateForm($_FILES[$col]['name'],$objFormElement->label,$objFormElement);
                        }
                        else if(PageContext::$request['action']  ==    "edit" && $_FILES[$col]['name']) {
                            $response   =   $objFormValidation->validateForm($_FILES[$col]['name'],$objFormElement->label,$objFormElement);
                        }
                    }
                    else if($val->editoptions->type  ==   "password") {
                        if(PageContext::$request['action']  ==    "add") {
                            $response   =   $objFormValidation->validateForm($_POST[$objFormElement->name],$objFormElement->label,$objFormElement);
                        }
                    }
                    else
                        $response   =   $objFormValidation->validateForm($_POST[$objFormElement->name],$objFormElement->label,$objFormElement);
                    if($response!=  "" ) {

                        if($errorFlag==0)
                            $objForm->form_error_message        =   $response;
                        PageContext::$response->showForm    =   TRUE;
                        PageContext::addJsVar("formError", 1);
                        $errorFlag  =   1;
                    }



                }

            }
        }



       PageContext::$response->addform = $objForm;
        // Form submit
        if(isset($_POST['submit']) && $errorFlag==0) {
//             echopre(PageContext::$request);exit;
            if(PageContext::$request['action']  ==   "edit") {
                $sucessMessage  =   "Record updated successfully";
                PageContext::$response->showForm    =   FALSE;
            }
            else
                $sucessMessage  =   "Record added successfully";

            $status=  Cms::saveForm($sectionData,$_POST,PageContext::$request);

            if($status['error']!="" && is_array($status)) {
                $objForm->form_error_message        =   $status['errormessage'];
                PageContext::$response->showForm    =   TRUE;
                PageContext::addJsVar("formError", 1);
                $errorFlag  =   1;

            }
            else {
                header("Location:$currentURL&message=$sucessMessage");
                exit;
            }

        }
        if(isset(PageContext::$request['message'])) {
            PageContext::$response->message =   PageContext::$request['message'];
            PageContext::$response->showForm=FALSE;
        }
        if(PageContext::$request['msgFlag']  ==   "1") {
            $message  =   "Record deleted successfully";
            PageContext::$response->message =   $message;
        }
        if(PageContext::$request['msgFlag']  ==   "2") {
            $message  =   "Record published successfully";
            PageContext::$response->message =   $message;
        }
        if(PageContext::$request['msgFlag']  ==   "3") {
            $message  =   "Record unpublished successfully";
            PageContext::$response->message =   $message;
        }




       // $listDataResults = Cms::listangularData();
        $data = array('records' => $listDataResults);
        $datas =  json_encode($data);
     //  print_r($datas);
     //$this->view->disableView();

 echo $datas; exit;
     }


    public static function getreport() {

        $section                =   $_GET['requestHeader'];
        $request['section']     =   $section;
        if((GLOBAL_DATE_FORMAT_SEPERATOR))
            $date_separator =  GLOBAL_DATE_FORMAT_SEPERATOR;
        else {
            $date_separator = "-";
        }

        $reportStartDate        =    $_GET['reportStartDate'];
        $reportStartDateArray   =    explode($date_separator,$reportStartDate);
        $reportStartDate1        =   $reportStartDateArray[2]."-". $reportStartDateArray[0]."-". $reportStartDateArray[1];
        $reportEndDate          =    $_GET['reportEndDate'];
        $reportEndDateArray   =    explode($date_separator,$reportEndDate);
        $reportEndDate1        =   $reportEndDateArray[2]."-". $reportEndDateArray[0]."-". $reportEndDateArray[1];
        $sectionData            =   Cms::getSectionData($request);

        $sectionConfig          =   json_decode($sectionData->section_config);
        $reportColumnCount      =    count($sectionConfig->report->columns);

        if($sectionConfig->report) {
            // excel header
            $excelData  .=  "<table border='1'><tr>";

            $excelData  .=  "<td colspan=$reportColumnCount>Report: ".$sectionConfig->report->reportTitle." From $reportStartDate To $reportEndDate</td>";
            $excelData  .=  "</tr></table>";
            $excelData  .=  "<table border='1'><tr>";
            foreach($sectionConfig->report->columns as $col) {
                foreach($sectionConfig->columns as $key =>  $val) {
                    if($col==$key) {

                        $excelData  .=   "<td>".$val->name."</td>";
                    }

                }
            }
            $excelData  .=  "</tr></table>";
            $excelData  .=   "<table border='1'><tr>";
            //to get list data for a particular section
            if($sectionConfig->dataSource) {
                $listDataResults  =  call_user_func_refined($sectionConfig->reportSourceFunction,PageContext::$request);
            }
            else
                $listDataResults= Cms::getReport($sectionData,$request,$reportStartDate1,$reportEndDate1);
            foreach($listDataResults  as $record) {
                $excelData  .=   "<tr>";
                foreach($sectionConfig->report->columns as $col) {
                    foreach($sectionConfig->columns as $key =>  $val) {
                        if($col==$key) {
                            if($val->dbFormat) {
                                $record->$col   =   Cms::getTimeFormat($record->$col,$val->dbFormat,$val->displayFormat);
                            }
                            $excelData  .=   "<td width='100px'>".$record->$col."</td>";
                        }

                    }
                }
                $excelData  .=   "</tr>";
            }
            header("Content-type: application/ms-excel");
            header("Content-Transfer-Encoding: binary");
            header("Content-Disposition: attachment; filename=\"".$sectionConfig->report->reportTitle.".xls\"");
            echo $excelData  .=   "</tr></table>";
            exit;
            exit;
        }

    }

    public function permission() {


    }

    public function manageroles() {
    	  if(CMS_ROLES_ENABLED)
    		    $roleEnabled    = 1;
        $roleId         = PageContext::$request['keyname'];
        if($roleId)
            $rolesDetails  = Cms::getRoleDetails($roleId);
        pageContext::$response->rolesDetails          =   $rolesDetails;
        if( PageContext::$request['action']=="add")
            PageContext::$response->showForm = TRUE;
        PageContext::$response->form_title = "Add Role";
        // if action is edit
        if(PageContext::$request['action']=="edit" ) {
            PageContext::$response->form_title  = "Edit Role";
            PageContext::$response->showForm    = TRUE;
            //to get list data for a particular section
        }
        $message                                  = PageContext::$request['message'];
        pageContext::$response->message           = $message;
        $errormessage                             = PageContext::$request['errormessage'];
        pageContext::$response->errorMessage      = $errormessage;
        $perPageSize                              = PageContext::$response->cmsSettings['admin_page_count'];
        //$perPageSize  = 100;
        pageContext::$response->previlegeDetails  = $previlegeDetails;
        $currentURL   = Cms::formUrl(PageContext::$request,$sectionConfig);
        pageContext::$response->currentURL        =   $currentURL;
        PageContext::addJsVar("currentURL", $currentURL);
        $editURL      = Cms::formUrl(PageContext::$request,$sectionConfig,1);

        if(PageContext::$request['action'] == "delete"){
            $error    = Cms::deleteRole($roleId);
            if($error){
                if($error == "roleExist")
                    $errorMessage  =   "You cannot delete this role, it contains leaf roles.";
                else
                    $errorMessage  =   "You cannot delete this role, it contains users.";
                $data   = array('message' => $errorMessage);
                $datas  = json_encode($data);
                echo $datas;
                exit;
            }
            $sucessMessage  = "Record deleted successfully.";
            $is_deleted     = 1;
            /* $data = array('message' => $sucessMessage);
            $datas =  json_encode($data);
            echo $datas; exit; */
        }
        if(isset($_POST['submit'])){
            $postArray['role_id']         = $_POST['role_id'];
            $postArray['role_name']       = $_POST['role_name'];
            $postArray['parent_role_id']  = $_POST['parent_role_id'];
            $privilegeId = Cms::saveRoles($postArray['role_id'] ,$postArray);
            if($postArray['role_id'])
                $sucessMessage  =   "Record updated successfully.";
            else
                $sucessMessage  =   "Record added successfully.";
            $is_added = 1;
            /* $data['success'] = true;
            //  $data['records'] = $rolesList;
            $data['message'] = $sucessMessage;
            $datas =  json_encode($data);
            echo $datas; exit; */
        }
        $rolesArray    = Cms::getAllRolesArray(PageContext::$request['page'],$perPageSize);
        foreach($rolesArray as $role){
            $roles = new stdClass();
            $roles->role_id           = $role->role_id;
            $roles->role_name         = $role->role_name;
            $roles->parent_role_id    = $role->parent_role_id;
            $roles->parent_role_name  = Cms::getRoleName($role->parent_role_id);
            $rolesList[]              = $roles;
        }
        $roles          = Cms::getAllRoles();
        $totalresult    = count($roles);
        $totalResulPages=ceil($totalresult/$perPageSize);
        PageContext::addJsVar("totalResulPages", $totalResulPages);
        PageContext::$response->totalResultsNum =   $totalresult;
        PageContext::$response->resultsPerPage  =   $perPageSize;
        $pageUrl=Cms::formPagingUrl(PageContext::$request);
        if(PageContext::$request['page']!="") {
            $pageUrl=$pageUrl;
            $pageUrl    =   str_replace("page=".PageContext::$request['page'], "", $pageUrl);
            $pageUrl=$pageUrl."&";
        }
        else
            $pageUrl=$pageUrl."&";
        PageContext::$response->pagination = Cms::pagination($totalresult,$perPageSize,$pageUrl,PageContext::$request['page']);
        $session    =   new LibSession();
        if($roleEnabled && $session->get('admin_type')!="developer"){
          	$roleId              = $session->get("role_id");
          	$sectionId           = Cms::getSectionId(PageContext::$request['section']);
          	$sectionRoles        = Cms::getSectionRoles($sectionId);
          	$parentRoleIDArray   = Cms::getParentRoleList($roleId);

          	if(!in_array($sectionRoles->view_role_id, $parentRoleIDArray)){
          		$viewPermission = 1;
          	}
          	if(!in_array($sectionRoles->add_role_id, $parentRoleIDArray)){
          		$addPermission = 1;
          	}
          	if(!in_array($sectionRoles->edit_role_id, $parentRoleIDArray)){
          		$editPermission = 1;
          	}
          	if(!in_array($sectionRoles->delete_role_id, $parentRoleIDArray)){
          		$deletePermission = 1;
          	}
            /*	if(!in_array($sectionRoles->publish_role_id, $parentRoleIDArray)) {
          		$publishPermission = 1;
          	}*/
        }
        else{
        	$viewPermission    = 1;
        	$addPermission     = 1;
        	$editPermission    = 1;
        	$deletePermission  = 1;
        	$publishPermission = 1;
        }
        if($addPermission == 1){
        	PageContext::$response->addAction   =   true;
        }
        else{
        	PageContext::$response->addAction   =   false;
        }
        if($editPermission == 1){
        	PageContext::$response->editAction   =   true;
        }
        else{
        	PageContext::$response->editAction   =   false;
            }
        if($deletePermission == 1){
        	PageContext::$response->deleteAction   =   true;
        }
        else{
        	PageContext::$response->deleteAction   =   false;
        }
        if($viewPermission == 1){
        	PageContext::$response->viewAction   =   true;
        }
        else{
        	PageContext::$response->viewAction   =   false;
        }
        if($publishPermission == 1){
        	PageContext::$response->publishAction   =   true;
        }
        else{
        	PageContext::$response->publishAction   =   false;
        }
        //pageContext::$response->roles           =   $rolesList;

        if($is_added == 1 || $is_deleted == 1){
            $data   = array('success' => true,'message' => $sucessMessage,'records' => $rolesList,'roles' => $roles,'groups' => $groups,'sections' => $sections);
            $datas =  json_encode($data);
            echo $datas;
            exit;
        }else{
            $data   = array('records' => $rolesList,'roles' => $roles,'groups' => $groups,'sections' => $sections);
            $datas  = json_encode($data);
            //$this->view->disableView();
            echo $datas;
            exit;
        }
    }

    public function manageusers(){
        if(CMS_ROLES_ENABLED)
            $roleEnabled    =   1;

        $userId        =   PageContext::$request['keyname'];
        if($userId)
            $userDetails   =   Cms::getUserDetails($userId);
        pageContext::$response->userDetails          =   $userDetails;
        if( PageContext::$request['action']=="add")
            PageContext::$response->showForm=TRUE;
        PageContext::$response->form_title="Add User";
        // if action is edit
        if(PageContext::$request['action']=="edit" ) {
            PageContext::$response->showForm=TRUE;
            PageContext::$response->form_title="Edit User";
            //to get list data for a particular section
        }
        if(PageContext::$request['action']=="changepw"){
            PageContext::$response->showPasswordForm=TRUE;
        }
        //search & sort option
        PageContext::$response->request['searchField'] = PageContext::$request['searchField'];
        PageContext::$response->request['searchText'] = PageContext::$request['searchText'];
        PageContext::$response->request['orderField'] = PageContext::$request['orderField'];
        PageContext::$response->request['orderType'] = PageContext::$request['orderType'];


        $message = PageContext::$request['message'];
        pageContext::$response->message          =   $message;
        $errormessage = PageContext::$request['errormessage'];
        pageContext::$response->errorMessage          =   $errormessage;
        $perPageSize  = PageContext::$response->cmsSettings['admin_page_count'];
        //$perPageSize  =  100;
        pageContext::$response->previlegeDetails          =   $previlegeDetails;
        $currentURL=Cms::formUrl(PageContext::$request,$sectionConfig);
        pageContext::$response->currentURL          =   $currentURL;
        PageContext::addJsVar("currentURL", $currentURL);

        if(PageContext::$request['action']=="delete") {
            $error          = Cms::deleteUser($userId);
            $sucessMessage  = "Record deleted successfully.";
            $is_deleted     = 1;

            /*$data   = array('success' => true,'message' => $sucessMessage);
            $datas  =  json_encode($data);
            echo $datas; exit; */
        }
        if((PageContext::$request['submit']=="Save")){
            // adding new user
            $postArray['id']            = PageContext::$request['id'];
            $postArray['username']      = PageContext::$request['username'];
            $postArray['password']      = PageContext::$request['password'];
            $postArray['email']         = PageContext::$request['email'];

            $postArray['user_fname']    = PageContext::$request['user_fname'];
            $postArray['user_lname']    = PageContext::$request['user_lname'];
            $postArray['user_address1'] = PageContext::$request['user_address1'];
            $postArray['user_city']     = PageContext::$request['user_city'];
            $postArray['user_zipcode']  = PageContext::$request['user_zipcode'];
            $postArray['user_phone']    = PageContext::$request['user_phone'];
            $postArray['role_id']       = PageContext::$request['role_id'];
            $postArray['type']          = 'admin';
            //echopre1($postArray);
            $userExist         =   Cms::checkUserExist(PageContext::$request['username'],$postArray['id']);
            if(!$userExist){
                $privilegeId = Cms::saveUser($postArray['id'] ,$postArray);
                //Cms::saveUserDetails($privilegeId,$postArray);

                if($postArray['id'])
                $sucessMessage  =   "Record updated successfully.";
                else
                $sucessMessage  =   "Record added successfully.";
                $is_added = 1;

                /*$data = array('success' => true,'message' => $sucessMessage);
                $datas =  json_encode($data);
                echo $datas; exit; */
            }
            else {
                $errorMessage  =   "Username already exist.";
                $data   = array('message' => $errorMessage);
                $datas  =  json_encode($data);
                echo $datas; exit;
            }
        }
        if((PageContext::$request['submit'] == "Update")){
            $postArray['id']            = PageContext::$request['id'];
            $postArray['cpassword']     = PageContext::$request['cpassword'];
            $currentuserId              = PageContext::$request['id'];
            $postArray['newpassword']   = PageContext::$request['newpassword'];
            $postArray['cnewpassword']  = PageContext::$request['cnewpassword'];
            $checkOldpassword           = Cms::checkPassword($postArray['cpassword'],$currentuserId);
            $checkNewpassword           = Cms::checkPassword($postArray['cnewpassword'],$currentuserId);

            if($checkOldpassword != md5($postArray['cpassword'])){
                $errorMessage   = "Current password is wrong.";
                $data           = array('message' => $errorMessage);
                $datas          = json_encode($data);
                echo $datas; exit;
            }elseif($checkNewpassword != md5($postArray['cnewpassword'])) {
                $errorMessage   = "Old password and new password cannot be same.";
                $data           = array('message' => $errorMessage);
                $datas          = json_encode($data);
                echo $datas; exit;
            }
            else{
                $privilegeId    = Cms::changePassword($postArray['id'] ,$postArray);
                $sucessMessage  = "Password updated successfully.";
                $is_pwd_update  = 1;

                /*$data           = array('message' => $sucessMessage);
                $datas          = json_encode($data);
                echo $datas; exit; */
            }
        }

        $usersArray                                  =   Cms::getAllUserArray(PageContext::$request['page'],$perPageSize,PageContext::$request);
        foreach($usersArray as $user){
            $users              = new stdClass();
            $users->id          = $user->id;
            $users->username    = $user->username;
            $users->email       = $user->email;
            $users->role_id     = $user->role_id;
            $users->role_name   = Cms::getRoleName($user->role_id);
            $usersList[]        = $users;
        }
        $roles    = Cms::getAllRoles();
        PageContext::$response->roles   = $roles;
        $allUsers                       = Cms::getAllUsers(PageContext::$request);
        $totalresult                    = count($allUsers);
        $totalResulPages                = ceil($totalresult/$perPageSize);

        PageContext::addJsVar("totalResulPages", $totalResulPages);
        PageContext::$response->totalResultsNum =   $totalresult;
        PageContext::$response->resultsPerPage  =   $perPageSize;
        $pageUrl    = Cms::formPagingUrl(PageContext::$request);
        $session    = new LibSession();

        if($roleEnabled && $session->get('admin_type') != "developer"){
            //opertaions allowed
            $roleId             = $session->get("role_id");
            $sectionId          = Cms::getSectionId(PageContext::$request['section']);
            $sectionRoles       = Cms::getSectionRoles($sectionId);
            $parentRoleIDArray  = Cms::getParentRoleList($roleId);
            if(!in_array($sectionRoles->view_role_id, $parentRoleIDArray)) {
                $viewPermission = 1;
            }
            if(!in_array($sectionRoles->add_role_id, $parentRoleIDArray)) {
                $addPermission = 1;
            }
            if(!in_array($sectionRoles->edit_role_id, $parentRoleIDArray)) {
                $editPermission = 1;
            }
            if(!in_array($sectionRoles->delete_role_id, $parentRoleIDArray)) {
                $deletePermission = 1;
            }
            if(!in_array($sectionRoles->publish_role_id, $parentRoleIDArray)) {
                $publishPermission = 1;
            }
        }
        else{
            $viewPermission = 1;
            $addPermission = 1;
            $editPermission = 1;
            $deletePermission = 1;
            $publishPermission = 1;
        }
        if($addPermission == 1)
        PageContext::$response->addAction   =   true;
        else
        PageContext::$response->addAction   =   false;
        if($editPermission == 1)
        PageContext::$response->editAction   =   true;
        else
        PageContext::$response->editAction   =   false;
        if($deletePermission == 1)
        PageContext::$response->deleteAction   =   true;
        else
        PageContext::$response->deleteAction   =   false;
        if($viewPermission == 1)
        PageContext::$response->viewAction   =   true;
        else
        PageContext::$response->viewAction   =   false;
        if($publishPermission == 1)
        PageContext::$response->publishAction   =   true;
        else
        PageContext::$response->publishAction   =   false;

        if(PageContext::$request['page']!="") {
            $pageUrl=$pageUrl;
            $pageUrl    =   str_replace("page=".PageContext::$request['page'], "", $pageUrl);
            $pageUrl=$pageUrl."&";
        }
        else
            $pageUrl=$pageUrl."&";
        PageContext::$response->pagination      =   Cms::pagination($totalresult,$perPageSize,$pageUrl,PageContext::$request['page']);

        pageContext::$response->errorMessage          = $errormessage;
        pageContext::$response->users                 = $usersList;

        if($is_added == 1 || $is_deleted == 1 || $is_pwd_update == 1){
            $data   = array('success' => true,'message' => $sucessMessage,'records' => $usersList,'roles' => $roles,'groups' => $groups,'sections' => $sections);
            $datas =  json_encode($data);
            echo $datas;
            exit;
        }else{
            $data   = array('records' => $usersList,'roles' => $roles,'groups' => $groups,'sections' => $sections);
            $datas  = json_encode($data);
            //$this->view->disableView();
            echo $datas;
            exit;
        }

        /*$data   = array('records' => $usersList,'roles' => $roles);
        $datas  = json_encode($data);
        echo $datas; exit;*/
    }

    public function manageprivilege(){
        if(CMS_ROLES_ENABLED)
          $roleEnabled    =   1;
        $privilegeId        =   PageContext::$request['privilege_id'];

        pageContext::$response->privilegeId          =   $privilegeId;
        if($privilegeId)
            $previlegeDetails = Cms::getPrivilegeDetails($privilegeId);
        if( PageContext::$request['action'] == "add"){
            PageContext::$response->form_title  = "Add Privilege" ;
            PageContext::$response->showForm    = TRUE;
        }
        if(PageContext::$request['action'] == "edit"){
            PageContext::$response->showForm    = TRUE;
            PageContext::$response->form_title  = "Edit Privilege";
        }
        $message                                  = PageContext::$request['message'];
        pageContext::$response->message           = $message;
        $perPageSize                              = PageContext::$response->cmsSettings['admin_page_count'];
        pageContext::$response->previlegeDetails  = $previlegeDetails;
        $currentURL                               = Cms::formUrl(PageContext::$request,$sectionConfig);
        pageContext::$response->currentURL        = $currentURL;
        PageContext::addJsVar("currentURL", $currentURL);

        if(PageContext::$request['action']=="delete"){
            $privilegeId = $_POST['keyname'];
            Cms::deleteprivilege($privilegeId);

            $is_deleted = 1;
            $sucessMessage  = "Record deleted successfully.";
        }
        if(isset($_POST['submit'])) {
            $postArray['privilege_id']    = $_POST['privilege_id'];
            $postArray['entity_type']     = $_POST['entity_type'];
            if(PageContext::$request['section_entity_id'])
                $postArray['entity_id']   = Cms::getEntityId($_POST['section_entity_id']);
            if(PageContext::$request['group_entity_id'])
                $postArray['entity_id']   = $_POST['group_entity_id'];
            $postArray['view_role_id']    = Cms::getRoleId($_POST['view_role_id']);
            $postArray['add_role_id']     = Cms::getRoleId($_POST['add_role_id']);
            $postArray['edit_role_id']    = Cms::getRoleId($_POST['edit_role_id']);
            $postArray['delete_role_id']  = Cms::getRoleId($_POST['delete_role_id']);
            $postArray['publish_role_id'] = $_POST['publish_role_id'];
            //echopre1($postArray);
            $privilegeId                  = Cms::savePrivileges($postArray['privilege_id'] ,$postArray);
            if($postArray['privilege_id'])
                $sucessMessage  =   "Record updated successfully.";
            else
                $sucessMessage  =   "Record added successfully.";
            $pageUrl = Cms::formPagingUrl(PageContext::$request);
            PageContext::$response->showForm    =   FALSE;

            $is_added = 1;
        }

        $privilegesList   = Cms::getprivilege();
        $privileges       = Cms::getprivilegeList(PageContext::$request['page'],$perPageSize);
        $privilegeList    = array();
        $loop             = 0;
        $addedSections    = "";
        $addedGroups      = "";

        foreach($privileges as $privilege ){
            $privilegeArray = new stdClass();
            $privilegeArray->privilege_id       = $privilege->privilege_id;
            $privilegeArray->entity_type        = $privilege->entity_type;

            if($privilege->entity_type=="section")
                $addedSections .= $privilege->entity_id.",";
            if($privilege->entity_type=="group")
                $addedGroups .= $privilege->entity_id.",";
            $privilegeArray->entity_id          =   $privilege->entity_id;
            $privilegeArray->enity_name         =   Cms::getEntityName($privilege->entity_id,$privilege->entity_type);
            $privilegeArray->view_role_id       =   Cms::getRoleName($privilege->view_role_id);
            $privilegeArray->add_role_id        =   Cms::getRoleName($privilege->add_role_id);
            $privilegeArray->edit_role_id       =   Cms::getRoleName($privilege->edit_role_id);
            $privilegeArray->delete_role_id     =   Cms::getRoleName($privilege->delete_role_id);
            $privilegeArray->publish_role_id    =   Cms::getRoleName($privilege->publish_role_id);
            $privilegeList[] = $privilegeArray;
            $loop++;
        }
        //echopre($privilegeList);

        if(PageContext::$request['action']=="add") {
            $addedGroups = substr($addedGroups, 0,-1);
            $addedSections = substr($addedSections, 0,-1);
        }
        else{
            $addedGroups = "";
            $addedSections = "";
        }
        $roles           = Cms::getAllPrivileges();
        $totalresult     = count($roles);
        $totalResulPages = ceil($totalresult/$perPageSize);
        PageContext::addJsVar("totalResulPages", $totalResulPages);
        PageContext::$response->totalResultsNum =   $totalresult;
        PageContext::$response->resultsPerPage  =   $perPageSize;
        //$pageUrl=Cms::formPagingUrl(PageContext::$request);
        if(PageContext::$request['page']!="") {
            $pageUrl=$pageUrl;
            $pageUrl    =   str_replace("page=".PageContext::$request['page'], "", $pageUrl);
            $pageUrl=$pageUrl."&";
        }
        else
            $pageUrl=$pageUrl."&";

        PageContext::$response->pagination      = Cms::pagination($totalresult,$perPageSize,$pageUrl,PageContext::$request['page']);
        pageContext::$response->privilegList    = $privilegeList; //echopre(pageContext::$response->privilegList);
        $sections                               = Cms::getNewSections($addedSections);
        $groups                                 = Cms::getNewGroups($addedGroups);
        pageContext::$response->sections        = $sections;
        pageContext::$response->groups          = $groups;
        $roles                                  = Cms::getAllRoles();
        pageContext::$response->roles           = $roles;
        $session                                = new LibSession();

        if($roleEnabled && $session->get('admin_type') != "developer"){
            $roleId             = $session->get("role_id");
            $sectionId          = Cms::getSectionId(PageContext::$request['section']);
            $sectionRoles       = Cms::getSectionRoles($sectionId);
            $parentRoleIDArray  = Cms::getParentRoleList($roleId);
            if(!in_array($sectionRoles->view_role_id, $parentRoleIDArray)) {
                $viewPermission = 1;
            }
            if(!in_array($sectionRoles->add_role_id, $parentRoleIDArray)) {
                $addPermission = 1;
            }
            if(!in_array($sectionRoles->edit_role_id, $parentRoleIDArray)) {
                $editPermission = 1;
            }
            if(!in_array($sectionRoles->delete_role_id, $parentRoleIDArray)) {
                $deletePermission = 1;
            }
            /*if(!in_array($sectionRoles->publish_role_id, $parentRoleIDArray)) {
                $publishPermission = 1;
            }*/
        }
        else{
            $viewPermission     = 1;
            $addPermission      = 1;
            $editPermission     = 1;
            $deletePermission   = 1;
            $publishPermission  = 1;
        }
        if($addPermission == 1)
            PageContext::$response->addAction   =   true;
        else
            PageContext::$response->addAction   =   false;

        if($editPermission == 1)
            PageContext::$response->editAction   =   true;
        else
            PageContext::$response->editAction   =   false;

        if($deletePermission == 1)
            PageContext::$response->deleteAction   =   true;
        else
            PageContext::$response->deleteAction   =   false;

        if($viewPermission == 1)
            PageContext::$response->viewAction   =   true;
        else
            PageContext::$response->viewAction   =   false;

        if($publishPermission == 1)
            PageContext::$response->publishAction   =   true;
        else
            PageContext::$response->publishAction   =   false;

        if($is_added == 1 || $is_deleted == 1){
            $data   = array('success' => true,'message' => $sucessMessage,'records' => $privilegeList,'roles' => $roles,'groups' => $groups,'sections' => $sections);
            $datas =  json_encode($data);
            echo $datas;
            exit;
        }else{
            $data   = array('records' => $privilegeList,'roles' => $roles,'groups' => $groups,'sections' => $sections);
            $datas  = json_encode($data);
            //$this->view->disableView();
            echo $datas;
            exit;
        }
    }

    

    //reports panel
    public function reportlising() {
        if(CMS_ROLES_ENABLED)
            $roleEnabled    =   1;
        $perPageSize  =   PageContext::$response->cmsSettings['admin_page_count'];
        $date_separator =    GLOBAL_DATE_FORMAT_SEPERATOR;
        if($date_separator!="GLOBAL_DATE_FORMAT_SEPERATOR")
            $date_separator =  GLOBAL_DATE_FORMAT_SEPERATOR;
        else {
            $date_separator = "-";
        }
        $currentDate    =   date("m".$date_separator."d".$date_separator."Y");
        $monthStartDate    =   date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),1,date("Y")));
        PageContext::$response->currentDate =   $currentDate;
        PageContext::$response->monthStartDate =   $monthStartDate;

        PageContext::addJsVar("action",  PageContext::$request['action']);

        $errormessage = PageContext::$request['errormessage'];
        pageContext::$response->errorMessage          =   $errormessage;
        PageContext::$response->message =   PageContext::$request['message'];
        //to get section config values
        $sectionData= Cms::getSectionData(PageContext::$request);
        PageContext::$response->sectionName = $sectionData->section_name;
        PageContext::addJsVar("sectionName", $sectionData->section_alias);
        PageContext::$metaTitle .= " | ".$sectionData->section_name;
        $sectionConfig=$sectionData->section_config;
        $sectionConfig=json_decode($sectionConfig);
        if ($sectionConfig === null ) {
            echo "<br>Error: Incorrect JSON Format<br><br>";

        }

        //to get list data for a particular section
        //external data source
        $requestParams = PageContext::$request;
        $requestParams['perPageSize'] = $perPageSize;

        $listDataResults= Cms::listDataReport($sectionData,PageContext::$request,$perPageSize,$date_separator);

        //process listData for displaying in tpl
        $loopVar=0;
        $listData= array();

        foreach($listDataResults  as $record) {
            foreach($sectionConfig->detailColumns as $col) {
                foreach($sectionConfig->columns as $key =>  $val) {

                    if($col==$key) {

                        // if it is date, then convert it into a standard format
                        if($val->dbFormat) {

                            $record->$col   =   Cms::getTimeFormat($record->$col,$val->dbFormat,$val->displayFormat);
                        }
                        else if($val->type   ==   "amount") {

                            $record->$col   =   $val->prefix.number_format($record->$col,$val->decimalPoint).$val->postfix;
                        }

                        else if($val->customColumn) {

                            $columnName     =   $sectionConfig->keyColumn;
                            $primaryKeyValue =   $record->$columnName;

                            $record->$col      =  call_user_func_refined($val->customaction,$primaryKeyValue);

                            if($val->popupoptions) {
                                $functionName   =   $val->popupoptions->customaction;
                                $columnName     =   $sectionConfig->keyColumn;
                                $params['id']         =   $record->$columnName;
                                $params['value']         =   $record->$col;

                                $externalLink   =   call_user_func_refined($functionName,$params);

                                $colValue=  substr($record->$col,0,30);

                                $record->$col =  "<a href='".$externalLink."' class='jqPopupLink btn btn-link' rel='link_".$params['id']."' >".$colValue."</button>";
                            }
                        }

                        else {
                            if(trim($record->$col)!=   "" ) {

                                $record->$col =  $val->prefix.html_entity_decode($record->$col).$val->postfix;
                            }
                            else {
                                if($val->defaultText) {
                                    $record->$col = '<small class="muted">'.$val->defaultText.'</small>';
                                }
                                else {
                                    $record->$col = '<small class="muted">-</small>';
                                }
                            }
                        }
                        break;

                    }

                }



            }
            $listData[]=$record;


            $loopVar++;
        }

        $session    =   new LibSession();
        if($roleEnabled && $session->get('admin_type')!="developer") {
            //opertaions allowed

            $session    =   new LibSession();
            $roleId = $session->get("role_id");


            $sectionId=  Cms::getSectionId(PageContext::$request['section']);
            $sectionRoles   =   Cms::getSectionRoles($sectionId);

            $parentRoleIDArray  =  Cms::getParentRoleList($roleId);

            if(!in_array($sectionRoles->view_role_id, $parentRoleIDArray)) {
                $viewPermission = 1;

            }
            if(!in_array($sectionRoles->add_role_id, $parentRoleIDArray)) {
                $addPermission = 1;

            }
            if(!in_array($sectionRoles->edit_role_id, $parentRoleIDArray)) {
                $editPermission = 1;

            }
            if(!in_array($sectionRoles->delete_role_id, $parentRoleIDArray)) {
                $deletePermission = 1;

            }
            if(!in_array($sectionRoles->publish_role_id, $parentRoleIDArray)) {
                $publishPermission = 1;

            }
        }
        else {
            $viewPermission = 1;
            $addPermission = 1;
            $editPermission = 1;
            $deletePermission = 1;
            $publishPermission = 1;

        }
        foreach($sectionConfig->opertations  as $operations) {
            if($operations=="add" && $addPermission)
                PageContext::$response->addAction   =   true;
            if($operations=="edit" && $editPermission)
                PageContext::$response->editAction   =   true;
            if($operations=="delete" && $deletePermission)
                PageContext::$response->deleteAction   =   true;
            if($operations=="customdelete" && $deletePermission) {
                PageContext::$response->deleteAction   =   true;
                $customDeleteOperation  =   1;
            }
            if($operations=="view" && $viewPermission)
                PageContext::$response->viewAction   =   true;
            if($operations=="publish" && $publishPermission)
                PageContext::$response->publishAction   =   true;

        pageContext::$response->viewAction   =   true;

        }
//        //custom operations
        //$customOperationsList= new stdClass();
        //$customOpLoop=0;

        $customOperationsList = array();

        foreach($listDataResults  as $dt) {

            $customOperations = array();

            foreach( $sectionConfig->customOperations as $key=>$val) {
                $opt = new stdClass();
                $columnName     =   $sectionConfig->keyColumn;
                $params         =   $dt->$columnName;

                $link           =   call_user_func_refined($val->options->linkSource,$params);

                $opt->name      =   $val->options->name;
                if($val->options->target=="newtab")
                    $target =   "target='_blank'";
                else
                    $target = "";

                $opt->link      =   "<a href='".$link."' $target class='cms_list_operation ".$val->options->class."' title='".$val->options->title."'>".$opt->name."</a>";

                $customOperations[$key]     =  $opt;

            }

            //echopre($customOperations);


            $customOperationsList[]         =   $customOperations;





        }//echopre($customOperationsList);

        // echo '<br><br><br><br><br>before: ';echopre($customOperationsList);
        //echopre1($customOperationsList);
        PageContext::$response->customOperationsList  =   $customOperationsList;

///echopre/($sectionConfig->customOperations);
        //to get total number of results in each section
        $numResListData=Cms::listDataReportCount($sectionData,PageContext::$request,$date_separator);


        $numRowsListData=$numResListData;
        //to get total number of result pages
        $totalResulPages=ceil($numRowsListData/$perPageSize);
        PageContext::addJsVar("totalResulPages", $totalResulPages);
        //to form url using GET params
        $section_path = BASE_URL."cms#/".PageContext::$request['section'];
        $currentURL=Cms::formUrl(PageContext::$request,$sectionConfig);
        $searchURL=Cms::formSearchUrl(PageContext::$request);
        $pageUrl=Cms::formPagingUrl(PageContext::$request);
        if(PageContext::$request['dateRange']){
            $dateRangeParams = '&dateRange='.PageContext::$request['dateRange'];
            if(PageContext::$request['dateRange'] == 'custom'){
                $dateRangeParams .= '&reportStartDate='.PageContext::$request['reportStartDate']
                .'&reportEndDate='.PageContext::$request['reportEndDate'];
            }
            $currentURL  = $currentURL.$dateRangeParams;
            $searchURL  = $searchURL.$dateRangeParams;
            $pageUrl  = $pageUrl.$dateRangeParams;
        }
        PageContext::addJsVar("searchURL", $searchURL);
        if(PageContext::$request['page']!="") {
            $pageUrl=$pageUrl;
            $pageUrl    =   str_replace("page=".PageContext::$request['page'], "", $pageUrl);
            $pageUrl=$pageUrl."&";
        }
        else
            $pageUrl=$pageUrl."&";
        PageContext::$response->pagination      =   Cms::pagination($numRowsListData,$perPageSize,$pageUrl,PageContext::$request['page']);
        PageContext::$response->columnNum       =   count($sectionConfig->detailColumns)+4;
        PageContext::$response->currentURL      =   $currentURL;
        PageContext::$response->totalResultsNum =   $numRowsListData;
        PageContext::$response->resultsPerPage  =   $perPageSize;
        PageContext::$response->resultPageCount =   $totalResulPages;
        PageContext::$response->request         =   PageContext::$request;
        PageContext::$response->section_config  =   $sectionConfig;
        PageContext::$response->listColumns     =   $sectionConfig->listColumns;
        PageContext::$response->columns         =   $sectionConfig->columns;
        PageContext::$response->combineTables   =    $sectionConfig->combineTables;
        PageContext::$response->relations       =   $sectionConfig->relations;
        PageContext::$response->listData        =   $listData;
        PageContext::$response->sectionData     =   $sectionData;
        PageContext::$response->section_config->keyColumn   =   $sectionConfig->keyColumn;
        PageContext::$response->multiselectActions =  $sectionConfig->multiselectActions;

        $editURL=Cms::formUrl(PageContext::$request,$sectionConfig,1);
        pageContext::$response->editURL          =   $editURL;

        pageContext::$response->sectionPath          =   $section_path;
        if(empty(PageContext::$response->request['dateRange'])){
            if($sectionConfig->defaultDateRange && $sectionConfig->defaultDateRange != 'custom'){
                PageContext::$response->request['dateRange'] = $sectionConfig->defaultDateRange;
            }
            else if(!empty($sectionConfig->dateRange) && $sectionConfig->dateRange[0] != 'custom') {
                PageContext::$response->request['dateRange'] = $sectionConfig->dateRange[0];
            }
        }
        $searchableCoumnsList    =   Cms::getSearchableColumns($sectionData);
        PageContext::$response->searchableCoumnsList   =   $searchableCoumnsList;
        PageContext::addJsVar("currentURL", $currentURL);
        PageContext::addJsVar("sectionPath", $section_path);

        // if action is add
        if( PageContext::$request['action']=="add" || $sectionConfig->displayForm=="popup" )
            PageContext::$response->showForm=TRUE;
        // if action is edit
        if(PageContext::$request['action']=="edit"  || $sectionConfig->displayForm=="popup") {
            PageContext::$response->showForm=TRUE;
            //to get list data for a particular section

            $listItem= Cms::listItem($sectionData,PageContext::$request);
        }
        // diffrent methods for displaying form displayForm
        //

        if($sectionConfig->displayForm=="popup")
            $displayFormMethod = "popup";
        else
            $displayFormMethod = "currentpage";
        PageContext::$response->displayFormMethod = $displayFormMethod;

        // if multiselect action is delete
        if(PageContext::$request['multiselectaction']!='') {
            $multiselectaction = PageContext::$request['multiselectaction'];
            //         echopre1(PageContext::$request);
            if(PageContext::$request['actionColumnList']==''){
                $message = "Please select atleast one record.";
                $currentURL =   $currentURL."&errormessage=$message";
                header("Location:$currentURL");
                exit;
            }
            else{
                $statusArray = call_user_func_refined($sectionConfig->multiselectActions->$multiselectaction->actionOperationSource,PageContext::$request['actionColumnList']);


                if($statusArray['status']=="error") {
                    $message = $statusArray['message'];
                    $currentURL =   $currentURL."&errormessage=$message";
                    header("Location:$currentURL");
                    exit;
                }
                else {
                    if($statusArray['status']=="success") {
                        $message = $statusArray['message'];
                        if($message=="") {
                            $message = 'Action '.$sectionConfig->multiselectActions->$multiselectaction->name.' performed for the selected records.';
                            $currentURL =   $currentURL."&message=$message";
                            header("Location:$currentURL");
                            exit;
                        }
                        else {
                            $currentURL =   $currentURL."&message=$message";
                            header("Location:$currentURL");
                            exit;
                        }
                    }
                }


            }
        }

        // if action is delete
        if(PageContext::$request['action']=="delete") {
            if($customDeleteOperation) {

                $statusArray = call_user_func_refined($sectionConfig->customDeleteOperation,PageContext::$request[$sectionConfig->keyColumn]);

                if($statusArray['status']=="error") {
                    $message = $statusArray['message'];
                    $currentURL =   $currentURL."&errormessage=$message";
                    header("Location:$currentURL");
                    exit;
                }
                else {
                    if($statusArray['status']=="success") {
                        $message = $statusArray['message'];
                        if($message=="") {
                            $currentURL =   $currentURL."&msgFlag=1";
                            header("Location:$currentURL");
                            exit;
                        }
                        else {
                            $currentURL =   $currentURL."&errormessage=$message";
                            header("Location:$currentURL");
                            exit;
                        }
                    }
                }



            }
            else {

                $status = Cms::deleteEntry($sectionData,PageContext::$request);
                if($status['error']!="" && is_array($status)) {
                    $objForm->form_error_message        =   $status['errormessage'];
                    $errorFlag  =   1;

                }
                else {
                    $currentURL =   $currentURL."&msgFlag=1";
                    header("Location:$currentURL");
                exit;
                }
            }
        }

        // if action is publish
        if((PageContext::$request['action']=="publish") || (PageContext::$request['action']=="unpublish")) {
            Cms::changePublishStatus($sectionData,PageContext::$request);
            if(PageContext::$request['action']=="publish")
                $currentURL =   $currentURL."&msgFlag=2";
            if(PageContext::$request['action']=="unpublish")
                $currentURL =   $currentURL."&msgFlag=3";
            header("Location:$currentURL");
            exit;
        }

        // logic for creating form
        $objForm = new Htmlform();
        $errorFlag = 0;
        $objForm->method    = "POST";
        $objForm->action    = $currentURL;
        if($sectionConfig->handleFile) {
            $objForm->handleFile    =   true;
        }
        $objForm->name      = "form_".PageContext::$response->section_alias;
        if(PageContext::$request['action']=="edit")
            $objForm->form_title  = "Edit ".PageContext::$response->sectionName ;
        else
            $objForm->form_title  = "Add ".PageContext::$response->sectionName ;

        $objForm->displayMethod     = $sectionConfig->displayForm;

        foreach($sectionConfig->detailColumns as  $col) {
            $val = $sectionConfig->columns->$col;
            if($val->editoptions) {

                $objFormElement                     =   new Formelement();
                $objFormElement->type               =   $val->editoptions->type;
                $objFormElement->name               =   $col;
                $objFormElement->id                 =   $col;
                $objFormElement->placeholder        =   $val->editoptions->placeholder;

                $objFormElement->label              =   $val->editoptions->label;
                $objFormElement->width              =   $val->editoptions->width;
                if(PageContext::$request['action']  ==    "edit") {
                    if( $objFormElement->type=="hidden") {
                        if($listItem[0]->$col)
                            $objFormElement->value          =   $listItem[0]->$col;
                        else
                            $objFormElement->value          =   $val->editoptions->value;
                    } else
                        $objFormElement->value          =   $listItem[0]->$col;
                    ////$val->editoptions->value;

                    //disable field on edit option for textbox, checkbox,radiobutton, selectbox, textarea, datepicker
                    $objFormElement->onEdit             =   $val->editoptions->onEdit;

                }
                else if(PageContext::$request['action']  ==    "add") {
                    if( $objFormElement->type=="hidden")
                        $objFormElement->value          =   $val->editoptions->value;
                    else
                        $objFormElement->value          =   $_POST[$col];//$val->editoptions->value;
                }else {
                    $objFormElement->value          =   $val->editoptions->value;
                }
                $objFormElement->default            =   $val->editoptions->default;
                $objFormElement->class              =   $val->editoptions->class;
                $objFormElement->prehtml            =   $val->editoptions->prehtml;
                $objFormElement->posthtml           =   $val->editoptions->posthtml;
                $objFormElement->source             =   $val->editoptions->source;
                $objFormElement->sourceType         =   $val->editoptions->source_type;
                $objFormElement->validations        =   $val->editoptions->validations;
                $objFormElement->hint               =   $val->editoptions->hint;
                $objFormElement->dbFormat           =   $val->dbFormat;
                $objFormElement->displayFormat      =   $val->displayFormat;
                $objFormElement->enumvalues         =   $val->editoptions->enumvalues;
                $objFormElement->options            =   $val->editoptions->options;
                $objFormElement->editorType         =   $val->editoptions->editorType;

                $objFormElement->defaultOptionLabel =   $val->editoptions->defaulttext;
                if( $objFormElement->type=="file"){
                    $objFormElement->fileType = $listItem[0]->file_mime_type;

                }

                //tokenInput
                if( $objFormElement->type=="tags"){
                    $objFormElement->tagDetails          =   $val->editoptions->tagDetails;
                    PageContext::$response->enableTokenInput = true;
                }

                $objFormElement->primaryKeyValue         =  PageContext::$request[$sectionConfig->keyColumn];
                PageContext::addJsVar("primaryKeyValue", $objFormElement->primaryKeyValue);

                $objForm->addElement($objFormElement);
                if(isset($_POST['submit'])) {

                    $objFormValidation                      =   new Formvalidation();
                    if($val->editoptions->type  ==   "file") {
                        // if($val->editoptions->value=="")
                        if(PageContext::$request['action']  ==    "add") {
                            $response   =   $objFormValidation->validateForm($_FILES[$col]['name'],$objFormElement->label,$objFormElement);
                        }
                        else if(PageContext::$request['action']  ==    "edit" && $_FILES[$col]['name']) {
                            $response   =   $objFormValidation->validateForm($_FILES[$col]['name'],$objFormElement->label,$objFormElement);
                        }
                    }
                    else if($val->editoptions->type  ==   "password") {
                        if(PageContext::$request['action']  ==    "add") {
                            $response   =   $objFormValidation->validateForm($_POST[$objFormElement->name],$objFormElement->label,$objFormElement);
                        }
                    }
                    else
                        $response   =   $objFormValidation->validateForm($_POST[$objFormElement->name],$objFormElement->label,$objFormElement);
                    if($response!=  "" ) {

                        if($errorFlag==0)
                            $objForm->form_error_message        =   $response;
                        PageContext::$response->showForm    =   TRUE;
                        PageContext::addJsVar("formError", 1);
                        $errorFlag  =   1;
                    }



                }

            }
        }
        PageContext::$response->addform = $objForm;
        // Form submit
        if(isset($_POST['submit']) && $errorFlag==0) {
//             echopre(PageContext::$request);exit;
            if(PageContext::$request['action']  ==   "edit") {
                $sucessMessage  =   "Record updated successfully";
                PageContext::$response->showForm    =   FALSE;
            }
            else
                $sucessMessage  =   "Record added successfully";

            $status=  Cms::saveForm($sectionData,$_POST,PageContext::$request);

            if($status['error']!="" && is_array($status)) {
                $objForm->form_error_message        =   $status['errormessage'];
                PageContext::$response->showForm    =   TRUE;
                PageContext::addJsVar("formError", 1);
                $errorFlag  =   1;

            }
            else {
                header("Location:$currentURL&message=$sucessMessage");
                exit;
            }

        }
        if(isset(PageContext::$request['message'])) {
            PageContext::$response->message =   PageContext::$request['message'];
            PageContext::$response->showForm=FALSE;
        }
        if(PageContext::$request['msgFlag']  ==   "1") {
            $message  =   "Record deleted successfully";
            PageContext::$response->message =   $message;
        }
        if(PageContext::$request['msgFlag']  ==   "2") {
            $message  =   "Record published successfully";
            PageContext::$response->message =   $message;
        }
        if(PageContext::$request['msgFlag']  ==   "3") {
            $message  =   "Record unpublished successfully";
            PageContext::$response->message =   $message;
        }

    }

    //reports panel - export
    public static function getreportExport() {
    	$section                =   $_GET['requestHeader'];
    	$request['section']     =   $section;
    	if((GLOBAL_DATE_FORMAT_SEPERATOR))
    		$date_separator =  GLOBAL_DATE_FORMAT_SEPERATOR;
    	else {
    		$date_separator = "-";
    	}

    	$currentDate    =   date("m".$date_separator."d".$date_separator."Y");

    	$sectionData            =   Cms::getSectionData($request);
    	$sectionConfig          =   json_decode($sectionData->section_config);

    	$reportType = $_GET['dateRange'];
    	if($reportType == ''){
    		if($sectionConfig->defaultDateRange && $sectionConfig->defaultDateRange != 'custom'){
    			$reportType = $sectionConfig->defaultDateRange;
    		}
    		else if(!empty($sectionConfig->dateRange) && $sectionConfig->dateRange[0] != 'custom') {
    			$reportType = $sectionConfig->dateRange[0];
    		}
    	}
    	$reportStartDate        =    $_GET['reportStartDate'];
    	
    	$reportEndDate          =    $_GET['reportEndDate'];
    	//     	$reportEndDateArray   =    explode($date_separator,$reportEndDate);
    	//     	$reportEndDate1        =   $reportEndDateArray[2]."-". $reportEndDateArray[0]."-". $reportEndDateArray[1];


    	$dateRangeTitle = '';
    	if($reportType == 'custom'){
    		$dateRangeTitle = " From $reportStartDate To $reportEndDate";
    	}
    	else if($reportType == 'monthly'){
    			$reportStartDate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),1,date("Y")));
    			$reportEndDate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),date("t"),date("Y")));
    			//$reportEndDate = date("m".$date_separator."d".$date_separator."Y", strtotime('last day of this month', strtotime($currentDate)));
    			$dateRangeTitle = " From $reportStartDate To $reportEndDate";
    	}
    	else if($reportType == 'weekly'){
		    	$dotw = $dotw = date('w', strtotime($currentDate));
		    	$reportStartDate = ($dotw == 1 /* monday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('last monday', strtotime($currentDate)));
		    	$reportEndDate = ($dotw == 0 /* sunday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('next sunday', strtotime($currentDate)));
		    	$dateRangeTitle = " From $reportStartDate To $reportEndDate";
    	}


    	if($sectionConfig->export) {
    		if($sectionConfig->exportColumns && !empty($sectionConfig->exportColumns)){
    			$columns =   $sectionConfig->exportColumns;
    		}
    		else{
    			$columns =   $sectionConfig->detailColumns;
    		}
    		$reportColumnCount      =    count($columns);

    	// excel header
    	$excelData  .=  "<table border='1'><tr>";

    		$excelData  .=  "<td colspan=$reportColumnCount>Report: ".$sectionConfig->reportTitle.$dateRangeTitle."</td>";
    		$excelData  .=  "</tr><tr>";
    		$excelData  .=  "<td colspan=$reportColumnCount> </td>";
    				$excelData  .=  "</tr></table>";
    				$excelData  .=  "<table border='1'><tr>";
    				foreach($columns as $col) {
    				foreach($sectionConfig->columns as $key =>  $val) {
    				if($col==$key) {

    				$excelData  .=   "<td>".$val->name."</td>";
    				}

    				}
    	}
    	$excelData  .=  "</tr></table>";
    		$excelData  .=   "<table border='1'><tr>";
    		//to get list data for a particular section
    		$listDataResults= Cms::getReportExport($sectionData,PageContext::$request,$date_separator);

    	foreach($listDataResults  as $record) {
    	$excelData  .=   "<tr>";
    	foreach($columns as $col) {
    	foreach($sectionConfig->columns as $key =>  $val) {
    	if($col==$key) {
    	// if it is date, then convert it into a standard format
    	if($val->dbFormat) {

    		$record->$col   =   Cms::getTimeFormat($record->$col,$val->dbFormat,$val->displayFormat);
    		}
    		else if($val->type   ==   "amount") {

    		$record->$col   =   $val->prefix.number_format($record->$col,$val->decimalPoint).$val->postfix;

    		}

    		else {
    		if(trim($record->$col)!=   "" ) {

    		$record->$col =  $val->prefix.html_entity_decode($record->$col).$val->postfix;
    		}
    			else {
    			if($val->defaultText) {
    			$record->$col = $val->defaultText;
    			}
    			else {
    			$record->$col = '-';
    		}
    		}
    		}

    		$excelData  .=   "<td width='100px'>".$record->$col."</td>";
    		}

    		}
    		}
    			$excelData  .=   "</tr>";
    		}
    		if(empty($listDataResults)){
    		$excelData  .=   "<td colspan=$reportColumnCount>No Data !! </td>";
    			}
    			header("Content-type: application/ms-excel");
    			header("Content-Transfer-Encoding: binary");
    				header("Content-Disposition: attachment; filename=\"".trim($sectionConfig->reportTitle).".xls\"");
    				echo $excelData  .=   "</tr></table>";
    				exit;
    				exit;
    		}

    		}

    		public function change_pwd(){


//     			PageContext::addJsVar('BASE_URL', BASE_URL);
    			if(CMS_ROLES_ENABLED)
    				$roleEnabled    =   1;
    			PageContext::$response->showForm = TRUE;
    			PageContext::$response->form_title = " Change Password ";
    			//page heading
    			$sectionData= Cms::getSectionData(PageContext::$request);



    			PageContext::$response->sectionName = $sectionData->section_name;
    			PageContext::addJsVar("sectionName", $sectionData->section_alias);
    			PageContext::$metaTitle .= " | ".$sectionData->section_name;
    			PageContext::$response->sectionData     =   $sectionData;

    			/*if($_SESSION['cms_admin_type']=="developer") {
    				PageContext::$response->showForm = FALSE;
    			}
    			if($_SESSION['cms_cms_username'] == 'sadmin'){
    				PageContext::$response->showForm = FALSE;
    			} */

    			$currentURL=Cms::formUrl(PageContext::$request,$sectionConfig);

    			pageContext::$response->currentURL          =   $currentURL;
    			PageContext::addJsVar("currentURL", $currentURL);

    			pageContext::$response->userId = $_SESSION['cms_user_id'];

    			if(isset(PageContext::$request['submit'])){

    				$postArray['id'] = $_SESSION['cms_user_id'];
    				$postArray['cpassword'] = PageContext::$request['currentpwd'];
    				//     		$currentuserId = PageContext::$request['userid'];
    				$currentuserId = $_SESSION['cms_user_id'];
    				$postArray['newpassword'] = PageContext::$request['newpwd'];
    				$postArray['cnewpassword'] = PageContext::$request['confirmnewpwd'];

                   // echopre1($postArray);
    				$checkOldpassword   =   Cms::checkCurrentPassword($postArray['cpassword'],$currentuserId);
                    $checkNewpassword   =   Cms::checkCurrentPassword($postArray['cnewpassword'],$currentuserId);
                    // echopre($checkOldpassword);
                    //  echopre1(md5($postArray['cpassword']));
                    $newpass =  md5($postArray['cpassword']);
    				if(($postArray['newpassword']) != ($postArray['cnewpassword'])) {
                      $data['error'] = true;
                      $data['message'] = 'New passwords are not matching.';
                      echo json_encode($data);
                        //$errorMessage  =   "Current password is wrong ";
                        //header("Location:$currentURL&errormessage=$errorMessage");
                        exit;
                    }
                    elseif($checkNewpassword==md5($postArray['cnewpassword'])) {
                        $data['error'] = true;
                        $data['message'] =  "Old password and new password cannot be same.";
                          echo json_encode($data);
                          exit;
                    }
                    else if(($checkOldpassword) != ($newpass)) {
                      $data['error'] = true;
                      $data['message'] = 'Current password is wrong.';
                      echo json_encode($data);
    					//$errorMessage  =   "Current password is wrong ";
    					//header("Location:$currentURL&errormessage=$errorMessage");
    					exit;
    				}
    				else {

    					$privilegeId = Cms::changePassword($postArray['id'] ,$postArray);

                    $data['success'] = true;
                    $data['message'] = 'Password updated successfully.';
                  echo json_encode($data);

    					//$sucessMessage  =   "Password updated successfully";
    					//header("Location:$currentURL&message=$sucessMessage");
    					exit;
    				}
    			}
    			//$message = PageContext::$request['message'];
    			//pageContext::$response->message          =   $message;
    			//$errormessage = PageContext::$request['errormessage'];
    			//pageContext::$response->errorMessage          =   $errormessage;

            //    $data = array('records' => $sectionData);
             //   $datas =  json_encode($data);
               // $this->view->disableView();

             //   echo $datas; exit;

    		}



            public function apilogin() {
                $headers =  getallheaders();
                /*echopre1($headers);
                foreach($headers as $key=>$val){
                    echo $key . ': ' . $val . '<br>';
                }
                echopre1($_POST);
                echo "HI";exit();*/
                //$session    =   new LibSession();

                if(CMS_ROLES_ENABLED)
                    $roleEnabled    =   1;
                    if((strtolower($headers['deviceType']) == "ios" || strtolower($headers['deviceType']) == "android" || strtolower($headers['deviceType']) == "webui") && ($headers['deviceID']!='')){
                    //if(($headers['deviceType']== "ios" || $headers['deviceType'] == "android") && ($headers['deviceID']!='')){
                        $username   =   $_REQUEST['username'];
                        $password   =   md5($_REQUEST['password']);
                        if($roleEnabled) {
                            $res    =   Cms::checkLogin($username,  $password,$roleEnabled);
                            if(count($res)>0) {
                                // generate token
                                //echopre1($res);
                                $returnData=array();
                                $data=array();
                                $returnData['user_id']=$res->id;
                                $returnData['accesToken']=$this->randomPassword();
                                $returnData['status']="1";
                                $returnData['status_msg']="Login success.";
                                //Save to table
                                $data['user_id']=$returnData['user_id'];
                                $data['accesToken']=$returnData['accesToken'];
                                $data['deviceType']=$headers['deviceType'];
                                $data['deviceID']=$headers['deviceID'];
                                $data['status']=$returnData['status'];
                                $data['created_at']=date("Y-m-d H:i:s");
                                $data['updated_at']="";
                                $insert=Cms::saveAccessToken($data);
                                //echo "Generating token";
                                $accessToken=$this->json($returnData);
                                echo $accessToken;
                                exit();
                                //echo $this->randomPassword();
                                //header("location: ".BASE_URL."cms");
                                //header("location: ".BASE_URL.CMS_PATH);
                                //exit;
                            }
                            else {
                                //PageContext::$response->errorMsg = "Invalid Login!";
                                $returnData=array();
                                $returnData['status']="0";
                                $returnData['status_msg']="Login failure";
                                //echo "Generating token";
                                $accessToken=$this->json($returnData);
                                echo $accessToken;
                                exit();
                            }
                        }

                    }else{

                        $returnData=array();
                        $returnData['status']="0";
                        $returnData['status_msg']="Invalid credentials supplied";
                        //echo "Generating token";
                        $accessToken=$this->json($returnData);
                        echo $accessToken;
                        exit();



                    }


            }

            public function randomPassword() {
                $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
                $pass = array(); //remember to declare $pass as an array
                $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                for ($i = 0; $i < 8; $i++) {
                    $n = rand(0, $alphaLength);
                    $pass[] = $alphabet[$n];
                }
                $pass=implode($pass);
                $pass=md5($pass.time());
                return $pass; //turn the array into a string
            }

            /*
             *  Encode array into JSON
             */
            public function json($data){
                if(is_array($data)){
                    return json_encode($data);
                }
            }

            /**
             *
             * Logout API call.
             */
            public function apilogout(){
            	$headers =  getallheaders();

            	//if(($headers['deviceType']== "ios" || $headers['deviceType'] == "android")){
              if((strtolower($headers['deviceType']) == "ios" ||
                  strtolower($headers['deviceType']) == "android" ||
                  strtolower($headers['deviceType']) == "webui")){
            		$token=$headers['accessToken'];
            		$res=Cms::removeAccessToken($token);



            			$returnData=array();
            			$returnData['status']="1";
            			$returnData['status_msg']="Logout successful";
            			//echo "Generating token";
            			$data=$this->json($returnData);
            			echo $data;
            			exit();




            	}

            }






}

?>
