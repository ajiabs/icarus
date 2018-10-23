<!--<script type="text/javascript" src="https://js.stripe.com/v1/"></script>-->

<!-- Add JS Vars -->
<script type="text/javascript">
    var stripe_publishable_key = "{php} echo PageContext::$response->stripePublicKey;{/php}";
</script>
<div class="innerpage_main_outer">
   

    <div class="innerpage_header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-4  col-md-4">
                    <div class="logo">
                         <a href="{php} echo BASE_URL;{/php}" title="{php} echo Cmshelper::getSiteName();{/php}">
                         <img alt="{php} echo Cmshelper::getSiteName();{/php}" src="{php} echo BASE_URL;{/php}/project/img/logo.png">
                            </a>
                        </div>
                </div>
                <div class="col-xs-12 col-sm-8  col-md-8">
                    <div class="main_nav">
                        <ul>
                             <li><a href="{php} echo ConfigUrl::root();?>cms{/php}">My Account</a></li>
                            <li><a href="{php} echo ConfigUrl::root();?>cms/cms/logout{/php}">Logout</a></li>
                            
                        </ul>       
                    </div>
                </div>
            </div>

          
        </div>
    </div>

<div class="clearfix"></div>
<div class="container">
    
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 offset-lg-3 offset-md-3 offset-sm-3">
            <h1>Payment</h1>
            <div class="white_box_outer">
                <div class="makepayment_outer">
                     <div class="alert">
                         {php}
                         if(PageContext::$response->paymentError){
                         echo PageContext::$response->paymentError;
                         }

                         {/php}
                     </div>

                      <form class="form-horizontal"  method="post" id="payment-form">
                        <div class="field_wrapper">
                            
                            <div class="rightcol">
                                <label class="label">Card number</label>
                                 <input type="text" size="35" class="card-number width1 {literal} {validate:{required:true, messages:{required:'Please enter the credit card'}}} {/literal}" id="txtcard" name="txtcard" maxlength="16" >
                                
                                <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtcard"> </label></p>

                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 padding_R_0">
                                <label class="label">Expires on </label>

                                <div class="clearfix"></div>

                                <select name="txtcardmonth" class="card-expiry-month width2 {literal} {validate:{required:true, messages:{required:'Please enter the credit card'}}} {/literal}">
                                  <option >Month</option>
                                {php} global $calendarMonths;
                                foreach($calendarMonths as $key=>$months) {
                                    echo '<option value="'.$key.'">'.$months.'</option>';
                                    
                                }
                                {/php}
                                </select>
                                
                                <select  name="txtcardyear" class="card-expiry-year width2">
                                  <option value="">Year</option>
                                  {php} for($i= date('Y'); $i < date('Y')+15 ; $i++) 
                                                echo '<option value="'.$i.'">'.$i.'</option>';
                                  {/php}
                                </select>
                                
                                <p class="formerror">&nbsp;
                                <label style="display: none;" class="error" generated="true" for="txtcardmonth">Please enter the expire month</label>
                                <label style="display: none;" class="error" generated="true" for="txtcardyear">Please enter the expire year</label>
                                </p>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <label class="label">
                                    CVV <a href="javascript:void(0)" title="The code behind your credit card" class="float_R"><img src="{php} echo IMAGE_MAIN_URL; {/php}help_icon.png"></a>
                                </label>
                                <div class="clearfix"></div>
                                <input type="text" size="35" class="card-cvc width3 {literal} {validate:{required:true, messages:{required:'Please enter the security code'}}} {/literal}" id="txtcardcode" name="txtcardcode" >
                                <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtcardcode"></label></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6"></div>
                            <div class="col-xs-12 col-sm-6">
                                <input type="hidden" name="txtplan" value="{php} echo PageContext::$response->id;{/php}">
                               
                                <input name="" id="submit-button" type="submit" class="form_mainbutton" value="Proceed">
                                <script src="<?php  echo BASE_URL?>project/js/stripe_validations.js"></script>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

   
</div>
<div class="clearfix"></div>
</div>
