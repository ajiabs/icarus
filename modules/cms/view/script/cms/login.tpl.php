<style>
.bg-primary,.panel-heading {
  background-color: <?php echo PageContext::$response->cmscolorSettings['bg_color'];?> !important;
  color: #dce0f3;
}
.text-primary{
   color: <?php echo PageContext::$response->cmscolorSettings['bg_color'];?> !important;
}
.btn-primary{
  color: #ffffff !important;
  background-color: <?php echo PageContext::$response->cmscolorSettings['bg_color'];?> !important;
  border-color:  <?php echo PageContext::$response->cmscolorSettings['bg_color'];?> !important;
}
.btn-primary:focus,
.btn-primary.focus,
.btn-primary:hover  {
  color: #ffffff;
  background-color:  <?php echo PageContext::$response->cmscolorSettings['bg_color'];?>!important;
  border-color:  <?php echo PageContext::$response->cmscolorSettings['bg_color'];?>!important;
}

</style>
<div class="container col-md-4 col-md-offset-4 animated fadeInDown">
   <div class="center-block mt-xxl">
      <!-- START panel-->
      	<div class="text-center mt-lg mb-lg">
		<?php if(PageContext::$response->cmsSettings['site_logo']) { 
			echo  PageContext::$response->siteLogo;
			} 
			else { ?>
				<img src="<?php echo BASE_URL.PageContext::$response->cmsSettings['admin_logo']?>" alt="Image" class="center-block img-rounded" >
		<?php } ?>
		</div>
		 <div class="panel loginpanel">
		 <div class="panel-heading">
          <div ng-class="'bg-' + app.theme.name" class="panel-title bg-primary">
             <em class="icon-clock fa-lg pull-right text-muted"></em>Sign in to continue</div>
       </div>
         <div class="panel-body">
		<form role="form" class="mb-lg" method="POST" action="<?php echo ConfigUrl::root();?>cms">
			<?php if(PageContext::$response->errorMsg){ ?>
						<div class="alert alert-danger text-center alert-failure-div"><?php echo PageContext::$response->errorMsg;?> </div> 
			<?php }?>



		  <div class="form-group has-feedback mb">
            <input type="text" id="username" name="username"  placeholder="Username/Email" autocomplete="off" class="form-control" />
            <span class="fa fa-user form-control-feedback text-muted"></span>
            <!-- <span class="fa fa-envelope form-control-feedback text-muted"></span> -->
          </div>

           <div class="form-group has-feedback mb">
            <input type="password" name="password" id="inputPassword"placeholder="Password" autocomplete="off" class="form-control" />
            <span class="fa fa-lock form-control-feedback text-muted"></span>
          </div>

		  <div class="control-group">
		    <div class="controls">
		      <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary mb">Sign in</button>
		    </div>
		  </div>
		</form>
		</div>
		</div>
		<div class="login_footer row-fluid">
			<p class="muted text-center"><small><?php if(PageContext::$response->cmsSettings['admin_copyright']) { echo PageContext::$response->cmsSettings['admin_copyright']; } else { ?>&copy;Armia Systems <?php  } ?></small></p>
		</div>
	</div>
</div>