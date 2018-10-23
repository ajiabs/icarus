<div class="container-fluid" style="margin-top:100px;">
	<div class="content row-fixed span8 offset4" >
		<div class="framework_logo lfloat span5 offset3" style="padding:10">
		<img src="<?php echo BASE_URL.PageContext::$response->cmsSettings['admin_logo']?>" >
		</div>
		<form class="form-horizontal" type="POST" action="<?php echo ConfigUrl::root();?>cms">
		<legend>Admin Panel</legend>
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
		  <legend></legend>
		</form>
		<div class="footer row-fluid">
			<p class="muted"><small><?php if(PageContext::$response->cmsSettings['admin_copyright']) { echo PageContext::$response->cmsSettings['admin_copyright']; } else { ?>&copy;Armia Systems <?php  } ?></small></p>
		</div>
	</div>
</div>