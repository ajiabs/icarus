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
  
  
  $(".confirmDelete").click(function(){
    if (!confirm("Do you want to delete")){
      return false;
    }
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
                      
                      <div class="pull-right"> <a href="contact_manage_add" class="btn btn-primary">Add Contact</a></div>
                      
                  <!-- START table-responsive-->
                 <div class="contact-right">
						<h2>Contacts</h2>
						<?php if (PageContext::$response->msg){?>
						<div class="alert alert-success" id="success_message">
  								<strong>Success!</strong><?php echo PageContext::$response->msg;?>						 
						</div>
						<?php }?>
						<div class="table-responsive">
                                                    
                                                    
                                                    
						<?php  $errors = PageContext::$response->validation_errors; ?>
							<table class="table">
                                                            
                                                            
                                                            
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Company</th>
      <th scope="col">Phone</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
      <?php if(PageContext::$response->contact_list){
          
     foreach (PageContext::$response->contact_list as $k=>$v){ ?>
    <tr>
        <th scope="row"><?php echo ($k) + 1 ?></th>
                <td><?php echo $v->first_name . ' ' . $v->last_name; ?></td>
                <td><?php echo $v->email; ?></td>
                <td><?php echo $v->company; ?></td>
                <td><?php echo $v->phone_number; ?></td>
                <td> <a href="#">
          <a href="<?php echo BASE_URL?>user/contact_manage_edit/<?php echo $v->contact_id?>">Edit
        </a>           
                
                        <a href="<?php echo BASE_URL?>user/contact_manage_delete/<?php echo $v->contact_id?>" class="confirmDelete">
          Delete
        </a>
                </td>
    </tr>
      <?php } }else{ ?>
  <th scope="row" colspan="6">No Contacts</th>
   <?php   }?>
  </tbody>
</table>
                                                    
                                                    <?php 
                                                    
                                                    $url = BASE_URL.'user/contact_manage/';
                                                    
                                                    echo Pagination::customPaginate(PageContext::$response->curPage,PAGE_LIST_COUNT,PageContext::$response->pageCount,$url);?>
                                                    
                                                    
						</div>
					</div>
                  <!-- END table-responsive-->
  	   	 </div>
  	   	 </div>
  	     <div class="clearfix"> </div>
	 </div>
</div>
</div>
