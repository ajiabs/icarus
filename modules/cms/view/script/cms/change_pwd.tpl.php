 <style>
.bg-primary,.panel-heading {
  background-color: <?php echo PageContext::$response->cmscolorSettings['bg_color'];?> ;
  color: #dce0f3;
}
.text-primary{
   color: <?php echo PageContext::$response->cmscolorSettings['bg_color'];?> ;
}
.btn-primary{
  color: #ffffff !important;
  background-color: <?php echo PageContext::$response->cmscolorSettings['bg_color'];?> ;
  border-color:  <?php echo PageContext::$response->cmscolorSettings['bg_color'];?> ;
}
.btn-primary:focus,
.btn-primary.focus,
.btn-primary:hover  {
  color: #ffffff;
  background-color:  <?php echo PageContext::$response->cmscolorSettings['bg_color'];?>;
  border-color:  <?php echo PageContext::$response->cmscolorSettings['bg_color'];?>;
}

</style>
<div class="app-view-header">Change Password</div> 

 <div class="section_list_view app">
 <?php if(!PageContext::$response->showForm) { ?>
 <div class="alert alert-info alert-block"> 
 The password for Sadmin/Developer cannot be changed.
 </div> 
 <?php }?>
<div class="alert alert-danger text-center alert-failure-div" role="alert" style="display: none">
          <p></p>
      </div>

      <div class="alert alert-success text-center alert-success-div" role="alert" style="display: none">
          <p></p>
      </div>

   <div  <?php if(!PageContext::$response->showForm) { ?> style="display: none;" <?php } ?>class="panel panel-default animated fadeInLeft2" id="addForm">


       <div class="panel-body">   
           <form name="changePwdform" id="changePwdform" class="form-horizontal">         
                    <input type="hidden" name="userid" id="userid" value="<?php echo pageContext::$response->userId;?>">

            <div class="control-group">
                <label for="vFirstName" class="control-label">Current Password <span class="mandatory">*</span></label>
                <div class="controls">
                    <input type="password" class="form-control" name="currentpwd" id="currentpwd" required ng-model="formData.currentpwd">

                </div>
            </div>
              <div class="control-group">
                <label for="vFirstName" class="control-label">New Password <span class="mandatory">*</span></label>
                <div class="controls">
                    <input type="password" class="form-control" name="newpwd" id="newpwd" required ng-model="formData.newpwd">

                </div>
            </div>
              <div class="control-group">
                <label for="vFirstName" class="control-label">Confirm Password <span class="mandatory">*</span></label>
                <div class="controls">
                    <input type="password" class="form-control"  name="confirmnewpwd" id="confirmnewpwd" required ng-model="formData.confirmnewpwd">

                </div>
            </div>


            <div class="controls"><br/>
<!--              <input type="button" name="cancel" value="Cancel" class="cancelButton btn"> -->
                <button type="submit" name="submit" ng-click="changepassword();" class="submitButton btn btn-primary">Update</button>
               </div></form>
           </div>     
    </div>
     
</div>
<script type="text/javascript">
var newpwd = document.getElementById("newpwd")
var confirmnewpwd = document.getElementById("confirmnewpwd");

function validatePassword(){
  if(newpwd.value != confirmnewpwd.value) {
    confirmnewpwd.setCustomValidity("Passwords Don't Match");
  } else {
    confirmnewpwd.setCustomValidity('');
  }
}

newpwd.onchange = validatePassword;
confirmnewpwd.onkeyup = validatePassword;

</script>