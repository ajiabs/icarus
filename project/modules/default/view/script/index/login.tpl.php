<script src="{php} echo BASE_URL; {/php}project/js/validations.js"></script>

<div class="container container-div">
    <div class="row container-div-pad">
        <div class="col-lg-6">
            <form class="" method="post" id="frmlogin" name="frmlogin" novalidate="novalidate">
                <h3>Login</h3>
                <hr><br/>
                {PageContext::$response->message}

                {if PageContext::$response->SAAS == 'true' && PageContext::$response->dynamicdb == 'true'}
                    {if PageContext::$response->appid==''}
                        <div class="form-group">
                            <label class="form-label pull-left label-wid">Enter App Id  <span class="required">*</span><a data-original-title="" data-content="The application id sent along with registration mail" rel="popover" class="jqpoptooltip" id="example" href="#"style="text-decoration: none!important;">
                                <img src="{php} echo IMAGE_MAIN_URL; {/php}help_icon.png"></a></label>
                            <div class="controls pull-left">
                                <input type="text"  class="control-field-width form-control input-large {literal}{validate:{required:true, messages:{required:&quot;Please enter the app id&quot;,}}}{/literal}" id="txtAppId" name="txtAppId" value="">
                                <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtAppId"> </label></p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    {else}
                    <div class="form-group">
                        <input type="hidden" size="35" class="" id="txtAppId" name="txtAppId" value="{php}echo PageContext::$response->appid;{/php}">
                    </div>
                    {/if}
                {/if}
                <div class="clearfix"></div>
                <div class="form-group">
                    <label class="form-label pull-left label-wid">User Name/Email<span class="required">*</span></label>
                    <div class="controls pull-left">
                        <input type="text" class="control-field-width form-control {literal}{validate:{required:true, messages:{required:&quot;Please enter the username&quot;,}}}{/literal}" id="txtemail" name="txtemail">
                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtemail"> </label></p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label class="form-label pull-left label-wid">Password<span class="required">*</span></label>
                    <div class="controls pull-left">
                        <input type="password" class="control-field-width form-control {literal}{validate:{required:true, messages:{required:'Please enter the password',}}}{/literal}" id="txtpwd" name="txtpwd">
                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtpwd"> </label></p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label class="form-label pull-left label-wid"></label>
                    <div class="controls pull-left">
                        <button name="btnLogin" id="btnLogin" type="submit" class="btn btn-default">Login</button>
                        <p class="frgtpwdlink">Forgot Password? <a href="{php} echo BASE_URL; {/php}index/forgotpassword">Click here</a></p>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-6 signup_promotion">
            <h3>Not registered in {php} echo SITENAME;{/php}?<br>Click <a href="{PageContext::$response->BASE_URL}{PageContext::$response->registerUrl}">here</a> to register</h3>
        </div>
    </div>
</div>

<script>
    $(function ()
    { $(".jqpoptooltip").popover();
    });
</script>
