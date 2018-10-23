<?php 
//echopre( PageContext::$response->smbUserInfo );
//echopre(PageContext::$response->planList);
//echopre(PageContext::$response->userPlan);

?>

<script>
    
    var siteUrl = '<?php echo BASE_URL;?>'
    
    $("#btnsmbupgrade").click(function(){
       
        var salesre_id = $("#salesrep_id").val();

        var npassword = $("#npassword").val();
        var cpassword = $("#cpassword").val();
        //alert(npassword)
        if(npassword=='')
            {
                alert("Please Enter a new pssword");
                return false;
            }
        if(npassword!=cpassword)
            {
                alert("Conform Password is not matching");
                return false;
            }
               var sendInfo = {
           salesre_id: salesre_id,
           npassword: npassword,
           cpassword: cpassword
       };
            $.ajax({
           type: "POST",
           url: siteUrl+'cmshelper/changepasswordajax',
           dataType: "json",
           success: function (msg) {
               if (msg) {
                 alert("Password Changed Successfully");
                   location.reload(true);
               } else {
                   alert("Failed");
               }
           },

           data: sendInfo
       });
            
            
       
    });
    
    
</script> 



<div class="alert alert-success text-center alert-success-div" style="display:none">
    <div id="successMessage"></div>
</div>
<a id="jqFocus" href="javascript:void(0)">  <div class="alert alert-danger text-center alert-failure-div" style="display:none">
        <!-- <button class="close" data-dismiss="alert" type="button">x</button> -->
        <label id="jqError"></label>
    </div></a>
    
    
<form name="frmupgradesmb">

    <input type="hidden" name="salesrep_id" value="<?php echo PageContext::$response->salesrep_id;?>" id="salesrep_id">
        

            <label>New Password </label>
                <input type="password" class="form-control" name="npassword" id="npassword">
        


            <label>Confirm Password </label>

                <input type="password" class="form-control" name="cpassword" id="cpassword">
        
<br/>
<input type="button" name="btnsmbupgrade" class="btn btn-primary" id="btnsmbupgrade" value="Update">


</form>