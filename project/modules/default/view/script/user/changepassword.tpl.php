<script src="{php} echo BASE_URL; {/php}project/js/validations.js"></script>

<div class="container container-div">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form class="" method="post" id="frmchngpass" name="frmchngpass" novalidate="novalidate">
            <div class="usersignform forgotpassform">
                <h3 class="bhimqr"><span>Change Password</span></h3>
                <div class="clearfix"></div>
                <div class="{php}echo PageContext::$response->class;{/php}" id="jpmessage">
                {php} echo PageContext::$response->message1;
                    $_SESSION['page_message']='';
                    $_SESSION['message_class']='';
                {/php}
                {PageContext::$response->message}
                </div>
                
                <div class="clearfix"></div>
                <div class="form-group row">
                    
                    <div class="col-md-12"><h5></h5></div>
                    <div class="clearfix"></div>
                    <label class="col-md-1 col-form-label"><i class="fa fa-key" aria-hidden="true"></i></label>
                    <div class="col-md-11">
                        <input id="oldpassword" name="oldpassword" type="password" placeholder="Old Password*" class="form-control {literal} {validate:{required:true, messages:{required:'Please enter old password',}}} {/literal}" >
<!--                        <input type="password" class="form-control {literal}{validate:{required:true,email:true, messages:{required:&quot;Please enter the email&quot;,email:'Please enter valid email'}}}{/literal}" id="txtemail" name="txtemail" placeholder="Old Password*">-->
                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtemail"> </label></p>
                        <div class="clearfix"></div>
                    </div>
                    
                    <label class="col-md-1 col-form-label"><i class="fa fa-key" aria-hidden="true"></i></label>
                    <div class="col-md-11">
                        <input id="newpassword" name="newpassword" type="password" placeholder="New Password*" class="form-control {literal} {validate:{required:true, messages:{required:'Please enter new password',}}} {/literal}" >
                        
<!--                        <input type="password" class="form-control {literal}{validate:{required:true,email:true, messages:{required:&quot;Please enter the email&quot;,email:'Please enter valid email'}}}{/literal}" id="txtemail" name="txtemail" placeholder="New Pasword*">-->
                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtemail"> </label></p>
                        <div class="clearfix"></div>
                    </div>
                    
                    <label class="col-md-1 col-form-label"><i class="fa fa-key" aria-hidden="true"></i></label>
                    <div class="col-md-11">
                        <input id="cnfrmpassword" name="cnfrmpassword" type="password" placeholder="Confirm Password*" class="form-control {literal} {validate:{required:true,equalTo : '#newpassword', messages:{required:'Please confirm password',equalTo:'Password mismatch'}}} {/literal}" >
                        
<!--                        <input type="password" class="form-control {literal}{validate:{required:true,email:true, messages:{required:&quot;Please enter the email&quot;,email:'Please enter valid email'}}}{/literal}" id="txtemail" name="txtemail" placeholder="Confirm Password*">-->
                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtemail"> </label></p>
                        <div class="clearfix"></div>
                    </div>
                    
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <button name="btnchngpass" id="btnchngpass" type="submit" class="btn btn-default">Change Password</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="clearfix"></div>
<!-- 
        <div class="col-lg-6">
            <form class="" method="post" id="frmlogin" name="frmlogin" novalidate="novalidate">
                <h3>Forgot Password</h3>
                <hr><br/>

                <div class="{php}echo PageContext::$response->class;{/php}" id="jpmessage">
                {php} echo PageContext::$response->message1;
                    $_SESSION['page_message']='';
                    $_SESSION['message_class']='';
                {/php}
                </div>
                {PageContext::$response->message}

                <div class="clearfix"></div>
                <div class="margin-style">
                    <p class="textstyle6">
                    <em>Please enter the email address you signed up with to receive a password reset request.</em></p>
                </div>

                <div class="clearfix"></div>
                <div class="form-group">
                    <label class="form-label pull-left label-wid">Email<span class="required">*</span></label>
                    <div class="controls pull-left">
                        <input type="text" class="control-field-width form-control {literal}{validate:{required:true,email:true, messages:{required:&quot;Please enter the email&quot;,email:'Please enter valid email'}}}{/literal}" id="txtemail" name="txtemail">
                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtemail"> </label></p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label class="form-label pull-left label-wid"></label>
                    <div class="controls pull-left">
                        <button name="btnLogin" id="btnLogin" type="submit" class="btn btn-default">Send</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-6 signup_promotion">
            <h3>Not registered in {php} echo SITENAME;{/php}?<br>Click <a href="{php} echo BASE_URL; {/php}#signup">here</a> to register</h3>
        </div>
-->
    </div>
</div>






