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
		     	        	<li><a href="contact_manage" <?php  if(PageContext::$response->activeMenu == 'contact_manage') echo  'class="active"' ?>>Contact Management</a></li>
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
						<h2>Edit Profile</h2>
						<?php if (PageContext::$response->update){?>
						<div class="alert alert-success" id="success_message">
  								<strong>Success!</strong>Updated profile						 
						</div>
						<?php }?>
						<div class="contact-form">
						<?php  $errors = PageContext::$response->validation_errors; ?>
							<form method="post" action="profile" name="edit-profile">
								<div class="row">
								<div class="col-md-6">
								<div class="form-group ">
								<label>First Name</label>
								<input type="text" class="textbox"  id="name" placeholder="First name" name="firstname" value="<?php echo PageContext::$response->user_details->user_fname ?>" required>
								<?php if(isset($errors['firstname']))?> <span class="errortext"><?php echo $errors['firstname'] ?></span> 
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">
								<label>Last Name</label>
								<input type="text" class="textbox"  id="name" placeholder="Last Name" name="lastname" value="<?php echo PageContext::$response->user_details->user_lname ?>" required>
								</div>
								</div>
								</div>
								<div class="row">
								<div class="col-md-6">
								<div class="form-group">
								<label>Email</label>
								<input type="text" class="textbox" placeholder="Email" name="email" value="<?php echo PageContext::$response->user_details->user_email ?>" required>
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">
								<label>Password</label>
								<input type="text" class="textbox" placeholder="Password" name="password">
								</div>
								</div>
								</div>
								<div class="row">
								<div class="col-md-6">
								<div class="form-group">
								<label>Company</label>
								<input type="text" class="textbox"  id="company" name="company" placeholder="" value="<?php echo PageContext::$response->user_details->user_company ?>" required>
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">
								<label>Address</label>
								<input type="text" class="textbox"  id="address" name="address" placeholder="" value="<?php echo PageContext::$response->user_details->address ?>" required>
								</div>
								</div>
								</div>
								<div class="row">
								<div class="col-md-6">
								<div class="form-group">
								<label>City</label>
								<input type="text" class="textbox"  id="city" name="city" placeholder="" value="<?php echo PageContext::$response->user_details->city ?>" required>
								
								</div>
								</div>

								<div class="col-md-6">
								<div class="form-group">
								<label>Country</label>
								<!--<input type="text" class="textbox"  id="city" name="city" placeholder="" value="<?php echo PageContext::$response->user_details->city ?>" required>-->
								<select class="form-control" name="country" id="country" required>
														    <?php foreach(PageContext::$response->countriesList as $key=>$row):?>
														    <option value="<?php echo $row->id?>" <?php echo (PageContext::$response->user_details->country==$row->id)?'selected="selected"':''?>><?php echo $row->country_name?></option>
														    <?php endforeach;?>
														  </select>
								</div>
								</div>
								</div>
								<div class="row">
								<div class="col-md-6">
								<div class="form-group">
								<label>State</label>
								<!--<input type="text" class="textbox"  id="state" name="state" placeholder="" value="<?php echo PageContext::$response->user_details->state ?>" required>-->
								<select class="form-control" name="state" id="state" required>
														    <?php foreach(PageContext::$response->stateList as $key=>$state):?>
														    <option value="<?php echo $state->state_code?>" <?php echo (PageContext::$response->user_details->state==$state->state_code)?'selected="selected"':""?>><?php echo $state->state?></option>
														    <?php endforeach;?>
														  </select>
								
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">
								<label>Zipcode</label>
								<input type="text" class="textbox"  id="pin_code" minlength="5"> name="pin_code" placeholder="" value="<?php echo PageContext::$response->user_details->pin_code ?>" required>
								</div>
								</div>
								</div>
								<div class="row">
								
								<div class="col-md-6">
								<div class="form-group">
								<label>Phone</label>
								<input type="text" class="textbox"  id="phone" name="phone" placeholder="" value=" <?php echo PageContext::$response->user_details->user_phone ?>" required>
								</div>
								</div>
								</div>
								
								<label class="fa-btn btn-1 btn-1e btn3"><input type="submit" value="Submit"></label>
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
