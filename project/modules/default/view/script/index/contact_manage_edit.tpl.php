<script>
  $(window).load(function() { 
    $('.popup-with-zoom-anim').magnificPopup({
      type: 'inline',
      fixedContentPos: false,
      fixedBgPos: true,
      overflowY: 'auto',
      closeBtnInside: true,
      preloader: false,
      midClick: true,
      removalDelay: 300,
      mainClass: 'my-mfp-zoom-in'
  });
});
</script>

<div class="main">
<div class="container">
	   <div class="features">
	   		<div class="heading"><span>My <em>Account</em></span></div>
	   		<div class="row">
  	     <div class="col-md-3">
  	   	 	<div class="contact-left">
				  <div class="myaccount_left">
		     	        <ul>
		     	        	<!--<li><a href="#">My Account</a></li>-->
		     	        	<li><a href="dashboard" <?php  if(PageContext::$response->activeMenu == 'dashboard') echo  'class="active"' ?>>Dashboard</a></li>
		     	        	<li><a href="profile" <?php  if(PageContext::$response->activeMenu == 'profile') echo  'class="active"' ?>>Edit Profile</a></li>
		     	        	<li><a href="<?php echo BASE_URL.'user/contact_manage'?>" <?php  if(PageContext::$response->activeMenu == 'contact_manage') echo  'class="active"' ?>>Contact Management</a></li>
                                        <!--<li><a href="#">My Subscriptions</a></li>
		     	        	<li><a href="#">Reports</a></li>
		     	        	<li><a href="#">My Cart</a></li>	-->			     	        
		     	        </ul>
				   </div>
				  		
             </div>
  	   	  </div>
  	   	  <div class="col-md-9">
                  <!-- START table-responsive-->
                 <div class="contact-right">
						<h2>Edit Contact</h2>
						<?php if (PageContext::$response->update){?>
						<div class="alert alert-success" id="success_message">
  								<strong>Success!</strong>Edited Contact						 
						</div>
						<?php }?>
						<div class="contact-form">
						<?php  $errors = PageContext::$response->validation_errors; ?>
							<form method="post" action="" name="edit-profile">
								<div class="row">
								<div class="col-md-6">
								<div class="form-group ">
								<label>First Name</label>
								<input type="text" class="textbox"  id="name" placeholder="First name" name="first_name" required value="<?php echo PageContext::$response->contact_details->first_name?>">
								<?php if(isset($errors['firstname']))?> <span class="errortext"><?php echo $errors['firstname'] ?></span> 
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">
								<label>Last Name</label>
								<input type="text" class="textbox"  id="name" placeholder="Last Name" name="last_name" value="<?php echo PageContext::$response->contact_details->last_name?>" required>
								</div>
								</div>
								</div>
								<div class="row">
								<div class="col-md-6">
								<div class="form-group">
								<label>Email</label>
								<input type="email" class="textbox" placeholder="Email" name="email" value="<?php echo PageContext::$response->contact_details->email?>" required>
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">
								<label>Phone</label>
								<input type="text" class="textbox"  id="phone" name="phone_number" placeholder="" value="<?php echo PageContext::$response->contact_details->phone_number?>" required>
								</div>
								</div>
								</div>
								<div class="row">
								<div class="col-md-6">
								<div class="form-group">
								<label>Company</label>
								<input type="text" class="textbox"  id="company" name="company" placeholder="" value="<?php echo PageContext::$response->contact_details->company?>" required>
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">
								<label>Address</label>
								<textarea name="address"><?php echo PageContext::$response->contact_details->address?> </textarea>
								</div>
								</div>
								</div>
								
								
								
                                                            <label class="fa-btn btn-1 btn-1e btn3"><input type="submit" value="Submit" name="Submit"></label>
							</form>
						</div>
					</div>
                  <!-- END table-responsive-->
  	   	 </div>
  	   	 </div>
  	     <div class="clearfix"> </div>
	 </div>
</div>
</div>
