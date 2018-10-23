
<div class="header_top">

      <div class="row">
      	<div class="col-xs-5 col-sm-3 col-md-4">
			 <div class="wow bounceInDown" data-wow-delay="0.4s">
				<a href="<?php echo BASE_URL ?>"><img src="<?php echo IMAGE_MAIN_URL ?>logo.png" alt=""/></a>
			 </div>
		 </div>

		 
		 <div class="col-xs-7 col-sm-9 col-md-8">
				<div class="menu">
					  <a class="toggleMenu" href="#"><img src="<?php echo IMAGE_MAIN_URL?>nav_inner.png" alt="" /></a>
					    <ul class="nav" id="nav">
					    	<li <?php if (PageContext::$response->activeMenu == 'home') echo 'class="active"' ?>><a href="<?php echo BASE_URL?>">Home</a></li>
					    	<li <?php if (PageContext::$response->activeMenu == 'about') echo 'class="active"' ?>><a href="<?php echo BASE_URL?>about">What’s iNetDown</a></li>
					    	<!-- <li {if PageContext::$response->activeMenu == 'device'} class="active" {/if}><a href="{php} echo BASE_URL; {/php}device">Device</a></li> -->
					    	<?php if (!PageContext::$response->user_email){ ?>
					    	<li <?php if (PageContext::$response->activeMenu == 'subscribe') echo  'class="active"' ?>><a href="<?php  echo BASE_URL?>subscribe">Subscribe</a></li>
					    	<?php }?>
					    	<li <?php if (PageContext::$response->activeMenu == 'news') echo 'class="active"' ?>><a href="<?php echo BASE_URL?>news">News</a></li>
					    	<li <?php if (PageContext::$response->activeMenu == 'support') echo 'class="active"' ?>><a href="<?php echo BASE_URL?>support">Support</a></li>

							<?php if (PageContext::$response->user_email){ ?>
	      					<li><a class="" href="profile">My Account</a></li>
	      		    		<li><a class="" href="logout" style="margin-left:40px !important;">Logout</a></li> 
	      		 			<?php }else {?>
	      					<li class="login_data"><a class="popup-with-zoom-anim" href="#small-dialog2"><i class="ph_icon"> </i> Login</a></li>

	      					<?php } ?>

						</ul>
	      		
					    	<div class="clearfix"></div>
						<script type="text/javascript" src="<?php  echo BASE_URL; ?>project/js/responsive-nav.js"></script>
			    </div>
			    <div class="clearfix"></div>
			 </div>
	      </div>
	     
	    
 