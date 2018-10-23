<div class="container-fluid" style="margin-top:100px;">
	<div class="content row-fixed span8 offset4" >
		<div class="framework_logo lfloat span5 offset3" style="padding:10">
		<img src="<?php echo BASE_URL.PageContext::$response->cmsSettings['admin_logo']?>" >
		</div>
		<form class="form-horizontal" type="POST" action="">
		<span class="legend">Admin Panel</span>
			<?php if(PageContext::$response->errorMsg){ ?>
						<div class="alert alert-error"><?php echo PageContext::$response->errorMsg;?> </div> 
			<?php }?>
		  <div class="control-group">
		    <label class="control-label" for="inputEmail">Admin Password</label>
		    <div class="controls">
		      <input type="password" name="password" id="inputPassword" placeholder="Admin Password">
		    </div>
		  </div>
		  <div class="control-group">
		    <label class="control-label" for="inputPassword">License Key</label>
		    <div class="controls">
		      <input type="text" name="inputlicense" id="inputLicense" placeholder="License Key">
		    </div>
		  </div>
		  <div class="control-group">
		    <div class="controls">
		      <button type="submit" name="submit" value="submit" class="btn">Update</button>
		    </div>
		  </div>
		  <span class="legend"></span>
		</form>
		<div class="footer row-fluid">
			<p class="muted"><small><?php if(PageContext::$response->cmsSettings['admin_copyright']) { echo PageContext::$response->cmsSettings['admin_copyright']; } else { ?>&copy;Armia Systems <?php  } ?></small></p>
		</div>
	</div>
</div>