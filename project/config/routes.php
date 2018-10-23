<?php
/*Router::alias(":pages", "(development)");
Router::connect(":pages", "index/pages/$1"); */

/*******************************  SECTION LINKS PREPARATION FROM MENU ITEMS TABLE  **************************/
$arrRouteSectionItems       = array();
$arrRouteSectionDetailItems = array();
PageContext::$response->routeSectionItems       = Managecmsdata::getSectionMenuAliasForRouting(); //fetching the menu items with reference type as "Section"
PageContext::$response->otherRouteSectionItems  = Managecmsdata::getSectionOtherAliasForRouting();
//echopre(PageContext::$response->routeSectionItems);
if(is_array(PageContext::$response->routeSectionItems) && count(PageContext::$response->routeSectionItems) > 0){
    foreach(PageContext::$response->routeSectionItems as $routeSectionItems){
        $arrRouteSectionItems[]       = $routeSectionItems->menu_item_alias;
        $arrRouteSectionDetailItems[] = $routeSectionItems->menu_item_alias."_details/(.*)";
    }
}
if(is_array(PageContext::$response->otherRouteSectionItems) && count(PageContext::$response->otherRouteSectionItems) > 0){
    foreach(PageContext::$response->otherRouteSectionItems as $otherRouteSectionItems){
        $arrRouteSectionItems[]       = $otherRouteSectionItems->section_alias;
        $arrRouteSectionDetailItems[] = $otherRouteSectionItems->section_alias."_details/(.*)";
    }
}
//echopre($arrRouteSectionItems);

if(is_array($arrRouteSectionItems) && count($arrRouteSectionItems) > 0){
    PageContext::$response->sectionRouteValue = implode("|",$arrRouteSectionItems);
}
if(is_array($arrRouteSectionDetailItems) && count($arrRouteSectionDetailItems) > 0){
    PageContext::$response->sectionRouteDetailsValue = implode("|",$arrRouteSectionDetailItems);
}
/*******************************  SECTION LINKS PREPARATION FROM MENU ITEMS TABLE  **************************/

/*******************************  BOTTOM MENU LINKS PREPARATION FROM CMS TABLE  **************************/
$arrExcludedList  = array("index","contact");
$excluded_arrlist = array_merge($arrExcludedList,$arrRouteSectionItems);
PageContext::$response->routeBottomMenuItems  = Managecmsdata::getMenuCmsItems("","Content",$excluded_arrlist);
//echopre(PageContext::$response->routeBottomMenuItems);

$arrBottomMenuLinks = array();
$arrBottomMenuItems = array();
$arrCmsRouteValues  = array();
PageContext::$response->cmsRouteValue = "";
if(is_array(PageContext::$response->routeBottomMenuItems) && count(PageContext::$response->routeBottomMenuItems) > 0){
     $bottom_menu_counter = 0;
     foreach(PageContext::$response->routeBottomMenuItems as $bottomMenuItem){
        $arrBottomMenuItems[] = (array)$bottomMenuItem;
     }
}
if(is_array($arrBottomMenuItems) && count($arrBottomMenuItems) > 0){
    foreach($arrBottomMenuItems as $bottomMenuItem){
        if(count($arrBottomMenuLinks) > 0){
            foreach($arrBottomMenuLinks as $bottomMenuLinkKey => $bottomMenuLinkValue){
                if(!array_key_exists($bottomMenuItem["menu_item_alias"],$arrBottomMenuLinks)){
                    $arrBottomMenuLinks[$bottomMenuItem["menu_item_alias"]] = $bottomMenuItem;
                }
            }
        }else{
            $arrBottomMenuLinks[$bottomMenuItem["menu_item_alias"]] = $bottomMenuItem;
        }
    }
}
if(is_array($arrBottomMenuLinks) && count($arrBottomMenuLinks) > 0){
    foreach($arrBottomMenuLinks as $bottomMenuLinkKey => $bottomMenuLinkValue){
        $arrCmsRouteValues[] = trim($bottomMenuLinkKey);
    }
}
if(is_array($arrBottomMenuLinks) && count($arrBottomMenuLinks) > 0){
    PageContext::$response->cmsRouteValue = implode("|",$arrCmsRouteValues);
}
//echopre(PageContext::$response->bottomMenuLinks);
/*******************************  BOTTOM MENU LINKS PREPARATION FROM CMS TABLE  **************************/

if(CUP){
    Router::connect(CUP_ROUTER_PATH, "cms/cms");
    Router::connect("cup", "cms/cms");
    Router::connect("cup/", "cms/cms");
    Router::connect("cup/:alias", "cms/$1");
    //$replace_url = str_replace("cms", "cup", Current_Url);
    //Router::redirect(Current_Url, $replace_url);
}

if(trim(PageContext::$response->cmsRouteValue) <> ""){
    Router::alias(":pages", "(".PageContext::$response->cmsRouteValue.")");
    Router::connect(":pages", "index/pages/$1");
}
if(trim(PageContext::$response->sectionRouteValue) <> ""){ //Section values
    Router::alias(":sections", "(".PageContext::$response->sectionRouteValue.")");
    Router::connect(":sections", "index/section/$1");
}
if(trim(PageContext::$response->sectionRouteDetailsValue) <> ""){ //Section details page routing
    Router::alias(":section_details", "(".PageContext::$response->sectionRouteDetailsValue.")");
    Router::connect(":section_details", "index/section_details/$1/$2");
}

//Router::alias(":section_details", "(services_details/(.*))");
//Router::connect(":section_details", "index/section_details/$1/$2");
//Router::alias(":pages", "(about|privacy-policy|terms-of-service)");
//Router::connect(":pages", "index/pages/$1");
//Router::alias(":pages", "(services|products)");
//Router::connect(":pages", "index/section/$1");

//
// redirection
// Router::redirect("login","");
//
////route configuration
//	Router::connect(":static", "framework&type=$1");
Router::connect("fw", "framework");
//	Router::connect(":alias", "");

Router::alias(":unsubscribe", "unsubscribe/(.*)");
Router::connect(":unsubscribe", "index/unsubscribe/$1");

Router::alias(":error", "error");
Router::connect(":error", "index/pagenotfound");

Router::alias(":homenav", "(contact|login|productlist|servicelist|subscribe_email|unsubscribe_email)");
Router::connect(":homenav", "index/$1");

Router::alias(":homenav", "content/(.*)");
Router::connect(":homenav", "index/static_content/$1");

Router::alias(":homenav", "service/(.*)");
Router::connect(":homenav", "index/servicedetails/$1");

Router::connect("register", "index/register");
Router::alias(":register", "register/(.*)");
Router::connect(":register", "index/register/$1");


// login routes
Router::alias(":login", "login/(.*)");
Router::connect(":login", "index/login/$1");

Router::connect("admin", "cms/cms");

// app routings
Router::alias(":app", "app/(.*)");
Router::connect("app", "smb/index/dashboard");
Router::connect("app/nopermission", "smb/index/nopermission");
Router::connect("app/dashboard", "smb/index/dashboard");
Router::connect(":app", "smb/$1");


Router::connect("admin", "cms/cms");
Router::connect("admin/", "cms/cms");
Router::connect("admin/:alias", "cms/cms");
Router::connect("cms", "cms/cms");
Router::connect("cms/", "cms/cms");

Router::connect("dashh", "cms/cms");
Router::connect("dashh/", "cms/cms");
Router::connect("dashh/:alias", "cms/cms");

//CMS
Router::connect("cms/developer/", "cms/cms/developer/");
Router::connect("cms/:alias", "cms/$1");








// API routings
Router::alias(":api", "api/(.*)");
Router::connect(":api", "api/index/$1");




?>
