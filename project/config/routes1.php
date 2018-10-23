<?php

// CMS - front end config
if(CUP){
    Router::connect(CUP_ROUTER_PATH, "cms/cms");

    Router::connect("cup", "cms/cms");
    Router::connect("cup/", "cms/cms");
    Router::connect("cup/:alias", "cms/$1");

    //$replace_url = str_replace("cms", "cup", Current_Url);
    //Router::redirect(Current_Url, $replace_url);

}
//alias definition
//
Router::alias(":pages", "(about|features|services|services1|services2|privacy|contact|terms-of-service|who_we_are|why_8to_18)");
Router::connect(":pages", "index/pages/$1");
//
// redirection
// Router::redirect("login","");
//
////route configuration
//	Router::connect(":static", "framework&type=$1");
Router::connect("fw", "framework");
//	Router::connect(":alias", "");

Router::alias(":error", "error");
Router::connect(":error", "index/pagenotfound");

Router::alias(":homenav", "(plans|schools|schoolspage|schoolsearch|bulk_order|login|orders|load_list|load_campaign|loadcampdetails)");
Router::connect(":homenav", "index/$1");

Router::connect("register", "index/register");
Router::alias(":register", "register/(.*)");
Router::connect(":register", "index/register/$1");
Router::connect("school_detail", "index/school_detail");
Router::alias(":school_detail", "school_detail/(.*)");
Router::connect(":school_detail", "index/school_detail/$1");

Router::connect("uploadartworks", "index/upload_artworks");
Router::alias(":uploadartworks", "upload_artworks/(.*)");
Router::connect(":uploadartworks", "index/upload_artworks/$1");


Router::connect("school_detail", "index/school_slots");
Router::alias(":school_detail", "school_slots/(.*)");
Router::connect(":school_detail", "index/school_slots/$1");


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
