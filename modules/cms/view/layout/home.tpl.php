<script type="text/javascript" src="<?php echo BASE_URL;?>modules/cms/js/cms.js"></script>
<?php if(PageContext::$response->logged_in) {


?>
<?php if($_REQUEST['parent_section']==''){$parent_section=-1;}else{$parent_section=$_REQUEST['parent_section'];}?>
<?php if($_REQUEST['parent_id']==''){$parent_id=-1;}else{$parent_id=$_REQUEST['parent_id'];}?>

<style>
.bg-primary,md-toolbar.md-default-theme:not(.md-menu-toolbar), md-toolbar:not(.md-menu-toolbar),.modal-header {
  background-color: <?php echo PageContext::$response->cmscolorSettings['bg_color'];?> ;
  color: #dce0f3;
}
.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
    z-index: 2;
    color: #ffffff;
    background-color:  <?php echo PageContext::$response->cmscolorSettings['bg_color'];?>;
    border-color:  <?php echo PageContext::$response->cmscolorSettings['bg_color'];?>;
    cursor: default;
}
.text-primary{
   color: <?php echo PageContext::$response->cmscolorSettings['bg_color'];?> ;
}
.btn-primary{
  color: #ffffff !important;
  background-color: <?php echo PageContext::$response->cmscolorSettings['bg_color'];?> ;
  border-color:  <?php echo PageContext::$response->cmscolorSettings['bg_color'];?> ;
}
.md-confirm-button{
  color: #ffffff !important;
  background-color: <?php echo PageContext::$response->cmscolorSettings['bg_color'];?>!important;
  border-color:  <?php echo PageContext::$response->cmscolorSettings['bg_color'];?>!important;
}
.btn-primary:focus,
.btn-primary.focus,
.btn-primary:hover  {
  color: #ffffff;
  background-color:  <?php echo PageContext::$response->cmscolorSettings['bg_color'];?>;
  border-color:  <?php echo PageContext::$response->cmscolorSettings['bg_color'];?>;
}
.bg-primary .nav > li:hover > a,
.bg-primary .nav > li.active > a {
   background-color:  none;
}
.btn-primary.disabled, .btn-primary[disabled], fieldset[disabled] .btn-primary, .btn-primary.disabled:hover, .btn-primary[disabled]:hover, fieldset[disabled] .btn-primary:hover, .btn-primary.disabled:focus, .btn-primary[disabled]:focus, fieldset[disabled] .btn-primary:focus, .btn-primary.disabled.focus, .btn-primary[disabled].focus, fieldset[disabled] .btn-primary.focus, .btn-primary.disabled:active, .btn-primary[disabled]:active, fieldset[disabled] .btn-primary:active, .btn-primary.disabled.active, .btn-primary[disabled].active, fieldset[disabled] .btn-primary.active {
    background-color: <?php echo PageContext::$response->cmscolorSettings['bg_color'];?>;
    border-color: <?php echo PageContext::$response->cmscolorSettings['bg_color'];?>;
}
#bg-white .sidebar-subnav > li:hover > a, .bg-white .sidebar-subnav > li:hover > a, #bg-white .sidebar-subnav > li.active > a, .bg-white .sidebar-subnav > li.active > a{
  background-color :<?php echo PageContext::$response->cmscolorSettings['bg_color'];?>;
}
#bg-white .nav > li.active, .bg-white .nav > li.active{
  background-color :<?php echo PageContext::$response->cmscolorSettings['bg_color'];?>;
}
</style>
<div class="app-container">
     <!--   <input type="text" ng-model="myColor"  ng-value="red"> -->
    <header class="ng-scope bg-primary" ng-style="{'background-color':myColor}">

        <nav class="navbar topnavbar">
            
            <div class="navbar-header">

            <a href="<?php echo BASE_URL."cms#/";?>" class="navbar-brand"><?php if(PageContext::$response->cmsSettings['site_logo']) {

                        echo  PageContext::$response->siteLogo;
                    } else { ?><img src="<?php echo BASE_URL.PageContext::$response->cmsSettings['admin_logo']?>" ><?php } ?></a>
             <div class="mobile-toggles">
                 <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                 <a href="" ng-click="icarusApp.sidebar.isOffscreen = !icarusApp.sidebar.isOffscreen" class="sidebar-toggle">
                    <em class="fa fa-navicon"></em>
                 </a>
                  <a href="" ng-click="toggleHeaderMenu();" class="menu-toggle hidden-material collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <em class="fa fa-ellipsis-v fa-fw"></em>
                 </a>
              </div>        
            </div>


    

               <!-- START Nav wrapper-->
               <div uib-collapse="headerMenuCollapsed" class="nav-wrapper collapse navbar-collapse">
                  <!-- START Left navbar-->
                  <ul class="nav navbar-nav hidden-material">
                     <li>
                        <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                        <a href="" ng-click="icarusApp.sidebar.isOffscreen = !icarusApp.sidebar.isOffscreen" class="hidden-xs">
                           <em ng-class="icarusApp.sidebar.isOffscreen ? 'fa-caret-right':'fa-caret-left'" class="fa"></em>
                        </a>
                     </li>
               

                     <!-- END lock screen-->
                  </ul>
                  <!-- END Left navbar-->
               </div>
               <!-- END Nav wrapper-->

      


          <div class="collapse navbar-collapse rightmenu" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav hidden-material">
                    <?php if(PageContext::$response->cmsUsername) { ?> <li><a href="" onclick="return false;" style="cursor: default;" class="welcomeText">Welcome <?php echo ucfirst(PageContext::$response->cmsUsername); ?></a></li><?php } ?>
                    <?php
                    if(PageContext::$response->headerLinks){
                    foreach(PageContext::$response->headerLinks as $key=>$links) { ?>
                        <li><a href="<?php echo $links->link; ?>" <?php if($links->target=="popup") { ?>class="jqHeaderPopupLink"<?php } ?>><?php echo $links->title; ?></a></li>
                <?php } } ?>
                <li>
                    <a href="<?php  echo ConfigUrl::root();?>" target="_blank" class="icon_home"><i class="fa fa-home"></i>&nbsp;&nbsp;Home</a>
                </li>
                    <?php if(PageContext::$response->logged_in) {?>
                <li><a href="<?php echo ConfigUrl::root();?>cms/cms/logout" class="icon_logout"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Log out</a></li>
                        <?php }?>
            </ul>
          </div>
  </nav>
    </header>


<aside class="ng-scope bg-white"  ng-controller="sectionlistController"  ><!-- START Sidebar-->
    <div class="sidebar-wrapper ng-scope" >
        <div class="sidebar" data-ui-sidebar="">

            
            <div class="sidebar-nav" nav-menu>
              

                <ul class="nav nav-side" >


                  
                    <?php 
                     $i=0;
                     $null = 0;
                     $pLength =  count(PageContext::$response->menu);
                    foreach(PageContext::$response->menu as $menu) {
                      $j = $j+1;
                        echo '<li id="'.$j.'" ng-click="getActive('.$j.','.$null.','.$pLength.')" class="js-section"> <a href=""><i class="fa fa-list"></i><em class="sidebar-item-caret fa pull-right fa-angle-right"></em> '.$menu->name.'</a>';
                      
                        ?>
                     
                        <ul class="nav sidebar-subnav">

                        <?php
                        $k=1;
                        foreach($menu->sections as $section) {

                            if(PageContext::$request['section'] == $section->section_alias || PageContext::$request['parent_section'] == $section->section_alias )$listatus=' class="active" ';else $listatus= ' ';
                           // echo '<li'.$listatus.' ><a href="'.ConfigUrl::root().CMS_PATH.'?section='.$section->section_alias.'"> <i class="fa fa-circle-o"></i>&nbsp;&nbsp; '.$section->section_name.'</a></li>';
                           //  id="<?php echo $section->section_alias."_id";
                            ?>
                            <li data-sec-id="<?php echo $section->section_alias;?>" id ="<?php echo $j."-".$k?>" ng-click="getActive('<?php echo $j ?>','<?php echo $k ?>','<?php echo $pLength ?>','<?php echo count($menu->sections); ?>')" class="js-sub-section" >

                              <a href="<?php echo BASE_URL ?>cms#/<?php echo $section->section_alias;?>"><span class="ripple"><span ng-class="getClassa('/<?php echo $section->section_alias;?>')"><i class="fa fa-circle-o"></i>&nbsp;&nbsp;<?php echo $section->section_name;?></a></span></span></li>
                            <?php
                            $k = $k+1;
                        }
                         echo "</ul></li>";
                    }
                    
                    ?>

            </ul>
            </div>
        </div>
        </div>
</aside>
<section class="ng-scope"  ng-init="init('<?php echo $_REQUEST['section'];?>','<?php echo $parent_section;?>',<?php echo $parent_id;?>)"; >
        <div ng-view>Loading....</div>
        <!--<div  ui-view='detail' data-autoscroll="false">-->
        <script type="text/ng-template" id="/dashboard.html">
 
         <?php echo $this->_content; ?>
     
          <div id="popup" class="modal"  style="display:none;background-color: rgba(0,0,0,0.5);">
            <div class="ng-isolate-scope in animated fadeInRight" >
              <div  class="modal-dialog">
                <div  class="modal-content">
                <div class="modal-header" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-title"><h4></h4>
                      <span  data-dismiss="modal" aria-hidden="true" class="close jqCloseButton"><i class="fa fa-times"></i></span>
                    </div>
                </div>
                    <div class="modal-body" id="popupBody">
                    </div>
                    <div class="modal-footer">
                    </div>

                </div>
               </div>
             </div>
            </div>
        </script>

       
    
<script type="text/ng-template" id="warning-dialog.html">
  <div class="modal-header">
   <h3>You're Idle. Do Something!</h3>
  </div>
  <div idle-countdown="countdown" ng-init="countdown=5" class="modal-body">
   <uib-progressbar max="5" value="5" animate="false" class="progress-striped active">You'll be logged out in {{countdown}} second(s).</uib-progressbar>
  </div>

</script>


<script type="text/ng-template" id="timedout-dialog.html">
  <div class="modal-header">
   <h3>You've Timed Out!</h3>
  </div>
  <div class="modal-body">
   <p>
      You were idle too long. Normally you'd be logged out.
   </p>
 </div>
</script>



</section>
  <!--  <ng-include src="'detail.php'"></ng-include>
    -->

    <footer class="ng-scope">
        <span><?php if(PageContext::$response->cmsSettings['admin_copyright']) {
                        echo PageContext::$response->cmsSettings['admin_copyright'];
                    } else { ?>&copy;Armia Systems <?php  } ?></span>
    </footer>
</div>
    <?php }else {
    echo $this->_content;
}?>

