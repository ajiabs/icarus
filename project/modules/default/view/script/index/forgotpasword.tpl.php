<script src="{php} echo BASE_URL; {/php}project/js/validations.js"></script>

<div class="container container-div">
    <div class="row container-div-pad">
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
                <!-- <div class="form-group">
                    <label class="form-label pull-left label-wid">App Id<span class="required">*</span></label>
                    <div class="controls pull-left">
                        <input type="text" class="control-field-width form-control {literal}{validate:{required:true, messages:{required:&quot;Please enter the app id&quot;,}}}{/literal}" id="txtappid" name="txtappid">
                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtappid"> </label></p>
                    </div>
                </div> -->
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
            <h3>Not registered in {php} echo SITENAME;{/php}?<br>Click <a href="{php} echo BASE_URL; {/php}plans">here</a> to register</h3>
        </div>
    </div>
</div>






