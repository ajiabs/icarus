 <style>
input.error {
    border: 1px dotted red;
}
.error{
color: #FF0000!important;
    padding-left: 0px;}

</style>
<script type="text/javascript">
    $(function(){
    	  var tab = '{PageContext::$response->activeTab}';
        //$('#settingtab a:first').tab('show');
        $('#settingtab a[href="#'+tab+'"]').tab('show');
    });

    $().ready(function() {

 // validate signup form on keyup and submit
	$("#jqPasswordForm").validate({
		rules: {
			outbound_call_rate: {
				required: true,
				number:true,
				min: 0.01
			},
			outbound_sms_rate: {
				required: true,
				number:true,
				min: 0.01
			}
		},
		messages: {
			outbound_call_rate: {
				required: "Please enter outbound call rate in credit ",
				number: "Please enter numeric value ",
				min: "Please enter a value greater than 0 "
			},
			outbound_sms_rate:{
				required: "Please enter outbound sms rate in credit " ,
				number: "Please enter numeric value ",
				min: "Please enter a value greater than 0 "
			}

		}
	});

    });


</script>
<div class="section_list_view ">
    <div class="row have-margin">
        <span class="legend">Section : Settings </span>
		<?php if($response->message == ''){}else{?>
       		<div class="alert alert-{php} echo PageContext::$response->msgClass; {/php}">
            <button class="close" data-dismiss="alert" type="button">x</button>
                <?php echo PageContext::$response->message; ?>
        </div>
		<?php }?>

        <div class="input-append pull-right">

        </div>
    </div>
    <ul id="settingtab" class="nav nav-tabs">
        <li><a data-toggle="tab" href="#general">General</a></li>
		<li><a data-toggle="tab"   href="#advanced">Advanced Settings</a></li>

		<li><a data-toggle="tab"   href="#payment">Payment Settings</a></li>
        <li><a data-toggle="tab"   href="#password">Update Password</a></li>
    </ul>
    <div class="tab-content">





        <div id="general" class="tab-pane">
            <form name="generalForm" id="jqGeneralForm" method="post" enctype="multipart/form-data" class="form-horizontal" action="<?php  echo BASE_URL; ?>cms?section=settings&tab=general">


                <div class="boxborder">

                     <div class="control-group">
                        <label for="adminEmail" class="control-label"><?php echo PageContext::$response->genSettings['sitename']->settinglabel;?></label>
                        <div class="controls">
                            <input type="text" value="<?php echo PageContext::$response->genSettings['sitename']->vLookUp_Value;?>"  name="sitename" class="float-left"></div>
                        <a href="javascript:void(0)" class="tooltiplink help-icon" title="{PageContext::$response->genSettings['sitename']->helptext}"></a>
                    </div>



                     <div class="control-group">
                        <label for="adminEmail" class="control-label"><?php echo PageContext::$response->genSettings['site_url']->settinglabel;?></label>
                        <div class="controls">
                            <input type="text" value="<?php echo PageContext::$response->genSettings['site_url']->vLookUp_Value;?>"  name="site_url" class="float-left"></div>
                        <a href="javascript:void(0)" class="tooltiplink help-icon" title="{PageContext::$response->genSettings['site_url']->helptext}"></a>
                    </div>


 					<div class="control-group">
                        <label for="adminEmail" class="control-label"><?php echo PageContext::$response->genSettings['site_surl']->settinglabel;?></label>
                        <div class="controls">
                            <input type="text" value="<?php echo PageContext::$response->genSettings['site_surl']->vLookUp_Value;?>"  name="site_surl" class="float-left"></div>
                        <a href="javascript:void(0)" class="tooltiplink help-icon" title="<?php echo PageContext::$response->genSettings['site_surl']->helptext;?>"></a>
                    </div>


                    <div class="control-group">
                        <label for="adminEmail" class="control-label"><?php echo PageContext::$response->genSettings['admin_email']->settinglabel;?></label>
                        <div class="controls">
                            <input type="text" value="<?php echo PageContext::$response->genSettings['admin_email']->vLookUp_Value;?>"  name="admin_email" class="float-left"></div>
                        <a href="javascript:void(0)" class="tooltiplink help-icon" title="<?php echo PageContext::$response->genSettings['admin_email']->helptext;?>"></a>
                    </div>



                </div>


                <div class="controls">
                    <input type="submit" name="submitBtn" value="Save" class="submitButton btn" />
                </div>
            </form>
        </div>
 <!-- general ends -->






   <!--  Advanced Settings starts -->
        <div id="advanced" class="tab-pane">
            <form name="passwordForm" id="jqPasswordForm" method="post" class="form-horizontal" action="<?php echo  BASE_URL; ?>cms?section=settings&tab=advanced">
                <div class="control-group jqStream">
                    <label class="control-label"><?php echo PageContext::$response->advSettings['one_credit_value']->settinglabel;?></label>
                    <div class="controls">
                        <input type="text" value="<?php echo PageContext::$response->advSettings['one_credit_value']->vLookUp_Value;?>" name="one_credit_value" class="float-left">

                    </div>
                </div>






                <div class="controls">
                    <input type="submit" name="btnAdvSubmit" value="Save" class="submitButton btn" />
                </div>
            </form>
        </div>
        <!-- Advanced Settins ends -->


























        <!-- Payment section -->
         <div id="payment" class="tab-pane">
            <form name="passwordForm" id="jqPasswordForm" method="post" class="form-horizontal" action="<?php  echo BASE_URL; ?>cms?section=settings&tab=payment">
                <div class="control-group jqStream">
                    <label class="control-label">Payment Gateways</label>
                    <div class="controls">
                        <input type="text" value="" name="one_credit_value" class="float-left">

                    </div>
                </div>



                <div class="controls">
                    <input type="submit" name="btnPaySubmit" value="Save" class="submitButton btn" />
                </div>
            </form>
        </div>
        <!-- Payment section -->









        <!-- Update Password -->
        <div id="password" class="tab-pane">
            <form name="passwordForm" id="jqPasswordForm" method="post" class="form-horizontal" action="<?php  echo BASE_URL; ?>cms?section=settings&tab=password">
                <div class="control-group jqStream">
                    <label class="control-label">Current Password</label>
                    <div class="controls">
                        <input type="password" value="" name="current_password" class="float-left">

                    </div>
                </div>

                <div class="control-group jqStream">
                    <label class="control-label">New Password</label>
                    <div class="controls">
                        <input type="password" value="" name="new_password" class="float-left">

                    </div>
                </div>

                <div class="control-group jqStream">
                    <label class="control-label">Re-Type Password</label>
                    <div class="controls">
                        <input type="password" value="" name="retype_password" class="float-left">

                    </div>
                </div>

                <div class="controls">
                    <input type="submit" name="passwordSubmitBtn" value="Save" class="submitButton btn" />
                </div>
            </form>
        </div>
		<!-- Update Password -->






    </div>
</div>
