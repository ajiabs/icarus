<script src="{php} echo BASE_URL; {/php}project/js/validations.js"></script>

<div class="container min-ht550">
    <h3 class="bhimqr"><span>Generate Your QR Code</span></h3>
    <div class="generateqr_form">
    <div class="row">
            <form method="post" class="cmxform" id="frmgenerateqr" name="frmgenerateqr" novalidate="novalidate">
                <div class="rightlabel"><em>Fields marked as <span class="required">*</span> are mandatory</em></div>
                {PageContext::$response->message}
                <div class="col-lg-6">
                <div class="form-group qrfield">
                    <div class="controls">
                        <input value="{PageContext::$response->user_fname}" placeholder="First Name *" type="text"  class="control-field-width form-control {literal} {validate:{required:true, messages:{required:'Please enter your first name'}}} {/literal}" id="user_fname" name="user_fname" >
<!--                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtshopname"> </label></p>-->
                    </div>
                </div>
                <div class="clearfix"></div>
                </div>
                
                <div class="col-lg-6">
                <div class="form-group qrfield">
                    <div class="controls">
                        <input value="{PageContext::$response->user_lname}" placeholder="Last Name *" type="text"  class="control-field-width form-control {literal} {validate:{required:true, messages:{required:'Please enter your last name'}}} {/literal}" id="user_lname" name="user_lname" >
<!--                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtshopname"> </label></p>-->
                    </div>
                    <div class="clearfix"></div>
                </div>
                </div>
                
                <div class="col-lg-6">
                <div class="form-group qrfield">
                    <div class="controls">
                        <input value="{PageContext::$response->shop_name}" placeholder="Your Shop Name *" type="text"  class="control-field-width form-control {literal} {validate:{required:true, messages:{required:'Please enter your shop name'}}} {/literal}" id="shop_name" name="shop_name" >
<!--                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtshopname"> </label></p>-->
                    </div>
                    <div class="clearfix"></div>
                </div>
                </div>
                <div class="col-lg-6">
                <div class="form-group qrfield">
                    <div class="controls">
                        
                        <select name="business_category" id="business_category" placeholder="Business Category *" class="control-field-width form-control {literal} {validate:{required:true, messages:{required:'Please select the business category',}}} {/literal}">
                            <option value="">Select Category</option>
                            {php}
                             
                            foreach(PageContext::$response->buisnesslist as $buisnesslist) {
                            echo '<option '.((PageContext::$response->business_category==$buisnesslist->bid)?'selected="selected"':'').' value="'.$buisnesslist->bid.'">'.$buisnesslist->category_name.'</option>';
                            }
                            {/php}
                        </select>
                        
<!--                        <select name="business_category" id="business_category" placeholder="Business Category *" class="control-field-width form-control {literal} {validate:{required:true, messages:{required:'Please select the business category',}}} {/literal}">
                            
                            <option {if PageContext::$response->business_category == "automobile"}selected {/if} value="automobile">Automobile</option> 
                            <option {if PageContext::$response->business_category == "realestate"}selected {/if} value="realestate">Real Estate</option> 
                            <option {if PageContext::$response->business_category == "stationary"}selected {/if} value="stationary">Stationary</option> 
                        </select>-->
                       
<!--                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtbusinesscategory"> </label></p>-->
                    <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                </div>
                <div class="col-lg-6">
                <div class="form-group qrfield">
                    <div class="controls">
                        <input value="{PageContext::$response->VPA_address}" placeholder="VPA Address *" name="VPA_address" type="text" class="control-field-width form-control {literal} {validate:{required:true, messages:{required:'Please enter the VPA Address',}}} {/literal}" maxlength="50">
<!--                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtvpaaddress"> </label></p>-->
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                </div>
                <div class="col-lg-6">
                <div class="form-group qrfield">
                    <div class="controls">
                        <input value="{PageContext::$response->address}" placeholder="Address *" name="address" type="text" class="control-field-width form-control {literal} {validate:{required:true, messages:{required:'Please enter your address',}}} {/literal}" >
<!--                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtaddress"></label></p>-->
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                </div>
                <div class="col-lg-4">
                <div class="form-group qrfield">
                    <div class="controls">
                        <input name="pin_code" value="{PageContext::$response->pin_code}" type="text" placeholder="Pin-code *" class="control-field-width form-control {literal} {validate:{required:true, messages:{required:'Please enter your pin-code',}}} {/literal}" >
<!--                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtpincode"></label></p>-->
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                </div>
                <div class="col-lg-4">
                <div class="form-group qrfield">
                    <div class="controls">
                        <input maxlength="10" value="{PageContext::$response->city}" type="text" placeholder="City *" class="control-field-width form-control {literal} {validate:{required:true,  messages:{required:'Please enter your city',}}} {/literal}" id="city" name="city">
<!--                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtcity"></label></p>-->
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                </div>
                <div class="col-lg-4">
                <div class="form-group qrfield">
                    <div class="controls">
                        <input maxlength="10" value="{PageContext::$response->state}" type="text" placeholder="State *" class="control-field-width form-control {literal} {validate:{required:true,  messages:{required:'Please enter your state',}}} {/literal}" id="state" name="state">
<!--                        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtstate"></label></p>-->
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                </div>
                <div class="col-lg-12">
                <div class="form-group">
                    <div class="controls">
                       
                        <input type="hidden" name="user_id" value="{PageContext::$response->user_id}">
                        <button name="btnGenerateqr" id="btnGenerateqr" type="submit" class="btn btn-default margin-top25px generate_qr_btn">GENERATE QR CODE</button>
                    </div>
                </div>
                <div class="clearfix"></div>
                </div>
            </form>
    </div>
    </div>
</div>


{if PageContext::$response->paymentFailedUser eq '1'} 

	{literal}
<script>
    $(function () {
        $.colorbox({width:"60%",height:"40%", inline:true, href:"#userexistpopup"});
        $('.btnCloseColorBox').live("click",function(){
            $.colorbox.close();
        });
    });
</script>
	{/literal}
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
{/if}
<script>
    $(function ()
    { $(".jqpoptooltip").popover();
    });
</script>







