<div class="container-fluid" style="margin-top:100px;">
	<div class="content row-fixed span8 offset4" >
		<div class="framework_logo lfloat span5 offset3 cmslogo" style="padding:10">
		<?php if(PageContext::$response->cmsSettings['site_logo']) { 
			echo  PageContext::$response->siteLogo;
			} 
			else { ?>
		<img src="<?php echo BASE_URL.PageContext::$response->cmsSettings['admin_logo']?>" >
		<?php } ?>
		</div>
		<form class="form-horizontal" method="POST" action="<?php echo ConfigUrl::root();?>cms/developer/">
		<span class="legend">Developer Login</span>
			<?php if(PageContext::$response->errorMsg){ ?>
						<div class="alert alert-error"><?php echo PageContext::$response->errorMsg;?> </div> 
			<?php }?>
		  <div class="control-group">
		    <label class="control-label" for="inputEmail">Username</label>
		    <div class="controls">
		      <input type="text" id="username" name="username"  placeholder="Username">
		    </div>
		  </div>
		  <div class="control-group">
		    <label class="control-label" for="inputPassword">Password</label>
		    <div class="controls">
		      <input type="password" name="password" id="inputPassword" placeholder="Password">
		    </div>
		  </div>
		  <div class="control-group">
		    <div class="controls">
		      <button type="submit" name="submit" value="submit" class="btn">Sign in</button>
		    </div>
		  </div>
		  <span class="legend"></span>
		</form>
		<div class="footer row-fluid">
			<p class="muted"><small><?php if(PageContext::$response->cmsSettings['admin_copyright']) { echo PageContext::$response->cmsSettings['admin_copyright']; } else { ?>&copy;Armia Systems <?php  } ?></small></p>
		</div>
	</div>
</div>