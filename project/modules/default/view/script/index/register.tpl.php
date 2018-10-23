<script src="<?php  echo BASE_URL; ?>project/js/validations.js"></script>
    <section id="services" style="margin-top:30px;">
        
        <div class="container">
    
            <div class="row">
<div class="col-md-6 signup-box">
    <?php if(PageContext::$response->type == 'success'){ ?>
         
           <div class="alert alert-success">
   <?php echo PageContext::$response->message ?>
</div>
        <?php } ?>
          
          
                  <?php if(PageContext::$response->type == 'error'){ ?>
           <div class="alert alert-danger">
   <?php echo PageContext::$response->message ?>
</div>
          <?php } ?>
    <form class="form-horizontal" method="post" enctype="multipart/form-data">
        <h3 class="map-head no-mrg text-center btm-pad-new">Register</h3>
  <div class="form-group">
   
    <div class="col-sm-12">
        <input type="text" class="form-control" id="inputEmail3" placeholder="First Name *" required name="salesrep_fname" value="<?php echo @$_POST['salesrep_fname']?>">
    </div>
  </div>
    <div class="form-group">
   
    <div class="col-sm-12">
        <input type="text" class="form-control" id="inputEmail3" placeholder="Last Name *" required name="salesrep_lname" value="<?php echo @$_POST['salesrep_lname']?>">
    </div>
  </div>

     <div class="form-group">
   
    <div class="col-sm-12">
        <input type="email" class="form-control" id="inputEmail3" placeholder="Email *" required name="salesrep_email" value="<?php echo @$_POST['salesrep_email']?>">
    </div>
  </div>
    <div class="form-group">
   
    <div class="col-sm-12">
        <input type="text" class="form-control" id="inputEmail3" placeholder="Address *" required name="salesrep_address" value="<?php echo @$_POST['salesrep_address']?>">
    </div>
  </div>
     <div class="form-group">
   
    <div class="col-sm-12">
        
        <select class="form-control" id="inputEmail3" placeholder="State *" required name="salesrep_state"> 
    
     <?php foreach(PageContext::$response->states as $k=>$result){ ?>
       <option value="<?php echo $result->value ?>" <?php if($result->value==$_POST['salesrep_state']){echo "selected";}?>><?php echo $result->text ?></option>
<?php } ?>
        </select>
        
    </div>
  </div>
     <div class="form-group">
   
    <div class="col-sm-12">
        <input type="text" class="form-control" id="inputEmail3" placeholder="Zip Code *" required name="salesrep_pincode" value="<?php echo @$_POST['salesrep_pincode']?>">
    </div>
  </div>
    
 
     <div class="form-group">
   
    <div class="col-sm-12">
        <input type="password" class="form-control" id="password" placeholder="Password *" required name="salesrep_password">
    </div>
  </div>


     <div class="form-group">
   
    <div class="col-sm-12">
        <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password *" required name="salesrep_cpassword">
    </div>
  </div>


    <div class="form-group">
   
    <div class="col-sm-12">
        <input type="text" class="form-control" id="inputEmail3" placeholder="Phone *" required name="salesrep_phone" value="<?php echo @$_POST['salesrep_phone']?>">
    </div>
  </div>
<div class="form-group">
  <div class="col-sm-12">
  
    <input type="file" id="exampleInputFile" name="salesrep_photo_id" accept="image/gif, image/png, image/jpeg"  required>
    <p class="help-block">Please upload a proof of Identification in following formats(*jpg/.png/.gif).</p>
      </div>
  </div>


  <div class="form-group">
    <div class="col-sm-12 text-right">
        <button type="submit" class="modal-btn" name="btnRegister" value="Submit">Register</button>
    </div>
  </div>
</form>
</div>
               
            </div>
        </div>
    </section>




 


<?php if(PageContext::$response->paymentFailedUser == 1){ ?> 

	
<script>
    $(function () {
        $.colorbox({width:"60%",height:"40%", inline:true, href:"#userexistpopup"});
        $('.btnCloseColorBox').live("click",function(){
            $.colorbox.close();
        });
    });
</script>
	
<div style='display:none; width:300px;'>
    <div id='userexistpopup' class="date_popup">
        <div style="padding:10px; ">
            <h4 id="myModalLabel">Confirm Email</h4>
            <div class="modal-body">

                <div id="jqMessage"></div>
                <p>Hi User, </p>
                <p>Your last payment was failed due to some unexpected reason. Please confirm your email and we will send a confirmation mail to your email.</p>

   	  Email <input type="textbox" name="confirmuseremail" id="confirmuseremail">
                <input type="hidden" id="userplan" name="userplan" value="{php} echo PageContext::$response->planId;{/php}">
                <div id="jqError"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="col_pop_cancelbtn btnCloseColorBox"  >Close</button>
            <button class="col_pop_sendbtn" id="jqsendconfirmation" >Send</button>
        </div>
    </div>
</div>
<?php } ?>
<script>
    $(function ()
    { $(".jqpoptooltip").popover();
    });


var password = document.getElementById("password")
var confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

var fl = document.getElementById('exampleInputFile');

fl.onchange = function(e){ 
    var ext = this.value.match(/\.(.+)$/)[1];
    switch(ext)
    {
        case 'jpg':
        case 'JPG':
        case 'jpeg':
        case 'JPEG':
        case 'png':
        case 'PNG':
        case 'gif':
        case 'GIF':
            break;
        default:
            alert('file type not allowed');
            this.value='';
    }
};


</script>








<style>
#mainNav{
    background:#0074bd;
    border-color: rgba(34, 34, 34, 0.05);
    height:79px;
    
}
</style>
