<div class="main">
<div class="container">
	   <div class="features">
	   		<div class="heading"><span>My <em>Dashboard</em></span></div>
	   		<div class="row">
  	     <div class="col-md-3">
  	   	 	<div class="contact-left">
				  <div class="myaccount_left">
		     	        <ul>
		     	        
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
  	   	  <?php $plans = PageContext::$response->plans;

  	   	  ?>
  	   	  	
	  	   	  <div class="col-md-9">
	  	   	  <?php if(PageContext::$response->success):?>
	  	   	  <div class="alert alert-success" id="success-sub" style="width:100%;">
  				 You have successfully subscribed the following plans
			</div>
		<?php endif;?>
	  	   	  		<div class="edit_profile_dashboard">
						<h1><?php echo $plans[0]->plan_name;?>
							<span><?php echo $plans[0]->plan_amount?> <?php echo PageContext::$response->interval ?></span>
							<div class="clearfix"></div>
						</h1>
						<?php 

							  $desc = explode('>',$plans[0]->plan_desc);

							  $desc2 = explode('>',$plans[0]->plan_desc2);

						?>
						<h3><?php echo $desc[0]?></h3>
						<ul>
						<?php foreach($desc as $key=>$row):?>
							<li><i class="fa fa-chevron-right" aria-hidden="true"></i> <?php echo $row ?></li>
							<?php endforeach;?>
						</ul>
						<div class="clearfix">&nbsp;</div>
						<h3><?php echo (isset($desc2[0]))? $desc2[0] :''?></h3>
						<?php if(isset($desc2[0]) && $desc2[0]!=''):?>
						<ul>
						
						<?php foreach($desc2 as $key=>$row2):?>
							<li><i class="fa fa-chevron-right" aria-hidden="true"></i> <?php echo $row2?></li>
						<?php endforeach;?>
							
						</ul>
						<?php endif;?>
						<div class="clearfix">&nbsp;</div>
						<h3>iNetDown Internet Module</h3>
						<div class="clearfix"></div>
					</div>
	  	   	  		
	  	   	  </div>
  	   	 </div>
  	     <div class="clearfix"> </div>
	 </div>
</div>
</div>