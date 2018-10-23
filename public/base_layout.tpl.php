<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php if(FAVICON){?>
<link rel="icon" type="image/png" href="<?php  echo ConfigUrl::root(); ?>project/styles/images/<?php echo FAVICON; ?>">
<?php }?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title><?php echo ((PageContext::$metaTitle!='')?PageContext::$metaTitle:META_TITLE); ?></title>
<meta name="description" content="<?php echo ((PageContext::$metaDes!='')?PageContext::$metaDes:META_DES); ?>" />
<meta name="keywords" content="<?php echo ((PageContext::$metaKey!='')?PageContext::$metaKey:META_KEYWORDS); ?>" />
<!-- Style Sheets -->
<link rel="stylesheet" href="<?php echo ConfigUrl::root()?>public/styles/jquery-ui-1.8.23.custom.css" type="text/css" media="screen" title="default" />
<link rel="stylesheet" href="<?php echo ConfigUrl::root()?>public/styles/fw.css" type="text/css" media="screen" title="default" />
<!--<link rel="stylesheet" href="<?php echo ConfigUrl::root();?>project/styles/app.css" type="text/css" media="screen" title="default" /> -->
<?php if(PageContext::$enableBootStrap){?>
<!-- <link href="<?php echo ConfigUrl::root();?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">-->
<?php }?>


<!-- Add StyleSheets -->
<?php if (CONTROLLER!='cms'){?>
<!-- Bootstrap Core CSS -->
   <link href="<?php echo ConfigUrl::root();?>project/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo ConfigUrl::root();?>project/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Plugin CSS -->
    <link href="<?php echo ConfigUrl::root();?>project/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="<?php echo ConfigUrl::root();?>project/css/creative.css" rel="stylesheet">
    <link href="<?php echo ConfigUrl::root();?>project/css/fontawesome-all.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


<link media="all" type="text/css" href="<?php echo BASE_URL;?>project/assets/dashicons.css" rel="stylesheet">

<script type='text/javascript' src='<?php echo BASE_URL;?>project/assets/jquery.js'></script>
<script type='text/javascript' src='<?php  echo BASE_URL;?>project/assets/jquery-migrate.js'></script>


<!--<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
<script type='text/javascript' src='<?php echo BASE_URL;?>project/assets/gmaps.js'></script>-->
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA7IZt-36CgqSGDFK8pChUdQXFyKIhpMBY&sensor=true" type="text/javascript"></script>


<?php }?>
<?php
    if(PageContext::$styleObj  && CONTROLLER=='cms'){
foreach(PageContext::$styleObj->urls as $url){
?>
<?php if (preg_match('/http:/', $url)) {?>
<link rel="stylesheet" href="<?php echo $url;?>" type="text/css" />
<?php }else {?>
<link rel="stylesheet" href="<?php echo ConfigUrl::root();?>project/styles/<?php echo $url;?>" type="text/css" />
<?php  }
}}
?>


<?php if (CONTROLLER=='cms'){?>

<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/app/css/bootstrap.css" />
<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/app/css/bootstrap.css.map" />
<?php if (ADMIN_VIEW=='view'){?>
<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/app/css/styles.css" />
<?php }?>

<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/vendor/font-awesome/css/font-awesome.min.css" />

<?php if (ADMIN_VIEW=='view_two'){?>
<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/app/css/<?php echo ADMIN_VIEW;?>/styles.css" />
<?php }?>
<?php if (ADMIN_VIEW=='view_three'){?>
<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/app/css/<?php echo ADMIN_VIEW;?>/styles.css" />
<?php }?>

<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/vendor/animate.css/animate.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/vendor/datatables/media/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/vendor/angular-material/angular-material.css">


<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/vendor/ng-table/dist/ng-table.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/vendor/fullcalendar/dist/fullcalendar.css">
<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/vendor/angular-bootstrap-nav-tree/dist/abn_tree.css">
<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/vendor/angular-ui-select/dist/select.css">
<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/vendor/summernote/dist/summernote.css">
<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/vendor/sweetalert/dist/sweetalert.css">
<link rel="stylesheet" href="<?php echo BASE_URL;?>modules/cms/vendor/angular-ui-select/dist/select.css">

<?php }?>

<!-- Add Theme BasedStyleSheets -->
<?php
if(PageContext::$themeStyleObj){
foreach(PageContext::$themeStyleObj->urls as $url){
?>
<link rel="stylesheet" href="<?php PageContext::printThemePath();?>css/<?php echo $url;?>" type="text/css" />
<?php
}}
?>
<!-- IE Specific CSS  -->

 <!--[if IE 8]>
<style type="text/css">
.placeholder { color: #aaa!important; }
</style>
<![endif]-->

<!--[if IE 9]>
<style type="text/css">
.placeholder { color: #aaa!important; }
</style>
<![endif]-->


<!-- Add JS Vars -->
<script type="text/javascript">
<?php
    if(PageContext::$jsVarsObj){
        foreach(PageContext::$jsVarsObj->jsvar as $jsvar){
            echo 'var '.$jsvar->variable.' = "'.$jsvar->value.'";';
        }
    }
?>
</script>

<?php if(PageContext::$includeLatestJquery){?>
<script src="<?php echo ConfigUrl::root()?>public/js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="<?php echo ConfigUrl::root()?>public/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<?php }?>

<!-- JS Files -->

<!--<script src="<?php echo ConfigUrl::root()?>public/js/jquery-1.8.0.min.js" type="text/javascript"></script>-->
<script src="<?php echo ConfigUrl::root()?>public/js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
<script src="<?php echo ConfigUrl::root();?>public/js/jquery.blockUI.js" type="text/javascript"></script>
<script src="<?php echo ConfigUrl::root()?>public/js/fw.js" type="text/javascript"></script>
<script  src="<?php echo BASE_URL;?>project/js/jquery.metadata.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL;?>project/js/jquery.validate.js" type="text/javascript" ></script>
<script src="<?php echo ConfigUrl::root();?>project/js/app.js" type="text/javascript"></script>
<?php if(PageContext::$enableAngularJs){?>
<script src="<?php echo ConfigUrl::root();?>public/js/angular/angular.min.js"></script>
<script src="<?php echo ConfigUrl::root();?>public/js/angular/angular-animate.min.js"></script>
<script src="<?php echo ConfigUrl::root();?>public/js/angular/angular-route.min.js"></script>
<?php }?>
<?php if(PageContext::$enableListingComponent){?>
<script src="<?php echo ConfigUrl::root();?>project/js/angular/listingComponent.js" type="text/javascript"></script>
<?php }?>
<?php if(PageContext::$enableBootStrap){?>
<script src="<?php echo ConfigUrl::root();?>public/bootstrap/js/bootstrap.js"></script>
<?php }?>
   <?php if(PageContext::$enableFusionchart){?>
<script src="<?php echo ConfigUrl::root();?>public/fusioncharts/JSClass/FusionCharts.js" type="text/javascript"></script>
<?php }?>
<?php if(PageContext::$enableFCkEditor){?>
<script src="<?php echo ConfigUrl::root();?>public/fckeditor/fckeditor.js" type="text/javascript"></script>
<?php }?>
<?php if(PageContext::$enableJquerychart){?>
<script src="<?php echo ConfigUrl::root();?>public/jquerychart/chart.js" type="text/javascript"></script>
<?php }?>
<!-- Add Scripts -->
<?php
if(PageContext::$scriptObj){
foreach(PageContext::$scriptObj->urls as $url){
?>

<?php if ( (preg_match('/http:/', $url)) ||(preg_match('/https:/', $url))) {?>
<script src="<?php echo $url;?>" type="text/javascript"></script>
<?php }else {?>
<script src="<?php echo ConfigUrl::root();?>project/js/<?php echo $url;?>" type="text/javascript"></script>
<?php }
}}
?>
<!-- Head Code Snippet -->
<?php if(PageContext::$headerCodeSnippet)echo PageContext::$headerCodeSnippet;?>

<?php if (CONTROLLER=='cms'){?>
</head>

<script src="<?php echo BASE_URL;?>modules/cms/vendor/angular/angular.min.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/js/angular-idle.min.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/js/angular-material.min.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/angular-resource/angular-resource.min.js"></script>
 <script src="<?php echo BASE_URL;?>modules/cms/vendor/angular-route/angular-route.min.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/angular-ui-router/release/angular-ui-router.min.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/angular-animate/angular-animate.min.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/js/angular-aria.min.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/angular-datatables/dist/angular-datatables.min.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/bootstrap/js/tooltip.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/angular-summernote/dist/angular-summernote.min.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/angular-sanitize/angular-sanitize.min.js"></script>

<script src="<?php echo BASE_URL;?>modules/cms/vendor/angular-bootstrap/ui-bootstrap-tpls.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/summernote/dist/summernote.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/angular-paginate/dist/angular-paginate.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/angular-ui-select/dist/select.js"></script>
<!--<script src="<?php echo BASE_URL;?>modules/cms/src/js/modules/forms/ui-select.controller.js"></script>-->


<script src="<?php echo BASE_URL;?>modules/cms/vendor/flot/jquery.flot.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/flot/jquery.flot.resize.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/flot/jquery.flot.pie.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/flot/jquery.flot.time.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/flot/jquery.flot.categories.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/flot-spline/js/jquery.flot.spline.min.js"></script>

<script src="<?php echo BASE_URL;?>modules/cms/vendor/export-data/alasql.min.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/export-data/xlsx.core.min.js"></script>

<!-- define angular controllers -->
<script src="<?php echo BASE_URL;?>modules/cms/js/controllers/sectionlist.js"></script>

<!-- define angular services -->
<script src="<?php echo BASE_URL;?>modules/cms/js/services/common_service.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/js/services/sectionlist_service.js"></script>

<script src="<?php echo BASE_URL;?>modules/cms/src/js/modules/charts/flot-chart-options.services.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/src/js/modules/charts/flot-chart.controller.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/src/js/modules/charts/flot-chart.directive.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/src/js/modules/charts/pie-charts.controller.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/src/js/modules/charts/sparklines.directive.js"></script>

<script src="<?php echo BASE_URL;?>modules/cms/src/js/modules/colors/colors.constant.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/src/js/modules/colors/colors.run.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/src/js/modules/colors/colors.service.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/src/js/modules/common/directives/check-all-table.directive.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/src/js/modules/routes/routes.provider.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/src/js/modules/routes/routes.run.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/src/js/modules/routes/vendor.constants.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/src/js/modules/ripple/ripple.directive.js"></script>

<link href='<?php echo BASE_URL;?>project/js/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
<link href='<?php echo BASE_URL;?>project/js/fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='<?php echo BASE_URL;?>project/js/fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo BASE_URL;?>project/js/fullcalendar/fullcalendar.min.js'></script>
<script src="<?php echo BASE_URL;?>project/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" href="<?php echo BASE_URL;?>project/css/bootstrap-select.min.css">




<?php //$sessioncount =  array_count_values($_SESSION);
//print_r($sessioncount);?>

<!-- define angular app -->
<body ng-cloak="" ng-app="icarusApp" ng-class="{'aside-offscreen' : icarusApp.sidebar.isOffscreen}" class='layout-fixed <?php if(empty($_SESSION)) echo ADMIN_VIEW;?>' >



<?php

if(DYNAMIC_THEME_ENABLED==true &&PageContext::$isCMS==false ){
    echo PageContext::renderCurrentTheme();
}else{
    echo $this->_layout;
}

?>
<!-- Footer Code Snippet -->
<?php if(PageContext::$footerCodeSnippet) echo PageContext::$footerCodeSnippet;?>
<script type="text/javascript">
$(window).load(function() {
var arrcms = document.URL.split('=');
if(arrcms[1]!== undefined){
var pagenamecms = arrcms[arrcms.length-1];
pagenamecms = pagenamecms.substring(0, (pagenamecms.length)-2);
$('[data-sec-id = '+pagenamecms+']').addClass('active');
$('[data-sec-id = '+pagenamecms+']').closest('li.js-section').addClass('active');
}
});
</script>
</body>

<?php }else{?>
</head>
<body class='<?php if(PageContext::$body_class)  echo PageContext::$body_class; ?>' >
    <div class="se-pre-con"></div>
<?php

if(DYNAMIC_THEME_ENABLED==true &&PageContext::$isCMS==false ){
    echo PageContext::renderCurrentTheme();
}else{
    echo $this->_layout;
}

?>
<!-- Footer Code Snippet -->
<?php if(PageContext::$footerCodeSnippet) echo PageContext::$footerCodeSnippet;?>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
<script type="text/javascript">
$(window).load(function() {
// Animate loader off screen
$(".se-pre-con").fadeOut("slow");
});
</script>
</body>
<?php }?>
</html>
