<script src="{php} echo BASE_URL; {/php}project/js/callmanagement.js"></script>
<script src="{php} echo BASE_URL; {/php}project/js/jquery.colorbox.js"></script>
<script src="{php} echo BASE_URL; {/php}project/js/popups.js"></script>
<link media="screen" rel="stylesheet" href="{php} echo BASE_URL; {/php}project/styles/colorbox.css" />
<link rel="stylesheet" href="{php} echo BASE_URL; {/php}project/js/tooltip/tip-darkgray.css" type="text/css" />
<script type="text/javascript" src="{php} echo BASE_URL; {/php}project/js/tooltip/jquery.poshytip.js"></script>
<script src="{php} echo BASE_URL; {/php}project/js/leadvalidations.js"></script>
<div class="dboard_Submenu">
    <div class="sitewidth">
     {if PageContext::$response->isMaster == true}
     <a class="list" href="{php} echo PageContext::$response->baseUrl; {/php}agents">Agent List</a>
     {/if}
     
      </div>
</div>

<div class="content_pannel">
    <div class="sitewidth mainform_wrapper">
        <div class="{php}echo PageContext::$response->class;{/php}" id="jmessage">
            {php} echo PageContext::$response->message;
                $_SESSION['page_message']='';
                $_SESSION['message_class']='';
            {/php}
            
        </div>
        <h2>{PageContext::$response->headingContent} {PageContext::$response->pageTitle}</h2>
        <!-- first row----------------------------------------------------------------------------------------------->
        <form method="post"  class="cmxform" id="frmaddagent" name="frmaddagent" enctype="multipart/form-data" >

            <div class="mainform_wrapper_row">
                <div class="mainform_wrapper_col1">
                    <div class="field_wrapper">
                        <div class="leftcol">
                            <label>First Name<span class="required">*</span></label>
                        </div>
                        <div class="rightcol">
                            <input type="text"  class="width1 {literal} {validate:{required:true, messages:{required:'Please enter the first name',}}} {/literal}" value="{PageContext::$response->agentDetails->agent_fname}"  size="35"  id="txtfname" name="txtfname">
                            <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtfname"> </label></p>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="field_wrapper">
                        <div class="leftcol">
                            <label>Last Name<span class="required">*</span></label>
                        </div>
                        <div class="rightcol">
                            <input type="text"  class="width1 {literal} {validate:{required:true, messages:{required:'Please enter the last name',}}} {/literal}" value="{PageContext::$response->agentDetails->agent_lname}"  size="35"  id="txtlname" name="txtlname">
                            <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtlname"> </label></p>
                        </div>
                        <div class="clear"></div>
                    </div>
                    
                       <div class="field_wrapper">
                        <div class="leftcol">
                            <label>Department</label>
                        </div>
                        <div class="rightcol">
                            <!--<input type="text"class="width1"  size="35" value="{PageContext::$response->accountDetails->acc_dept}" name="txtdepartment">-->
                            <select name="txtdepartment" class="width2">
                                <option value="">Select</option>
                                {foreach from=PageContext::$response->deptList item=dept}
                                <option value="{$dept->dept_id}" {if PageContext::$response->agentDetails->agent_dept eq $dept->dept_id} {"selected"} {/if}>{$dept->dept_name}</option>
                                {/foreach}
                            </select>
                            <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtdepartment"> </label></p>
                        </div>
                        <div class="clear"></div>
                    </div>
                    
                    <div class="field_wrapper">
                        <div class="leftcol">
                            <label>Photo</label>
                        </div>
                        <div class="rightcol">
                            <input type="file"  class=""   size="35"  id="txtphoto" name="txtphoto">
                            {PageContext::$response->agent_photo}  
                            <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtphoto"> </label></p>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="field_wrapper">
                        <div class="leftcol">
                            <label>Email<span class="required">*</span></label>
                        </div>
                        <div class="rightcol">
                          
                            <input {if PageContext::$response->isMaster == false} readonly {/if} type="text"  class="width1 {literal} {validate:{required:true,email:true, messages:{required:'Please enter the agent email',email:'Please enter a valid email'}}} {/literal}" value="{PageContext::$response->agentDetails->agent_email}"  size="35"  id="txtemail" name="txtemail">
                            <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtemail"> </label></p>
                        </div>
                        <div class="clear"></div>
                    </div>
                    {if PageContext::$response->agentDetails->agent_id >0}
                    {else}
                    
                        <div class="field_wrapper">
                            <div class="leftcol">
                                <label>Password<span class="required">*</span></label>
                            </div>
                            <div class="rightcol">
                                <input type="password"  class="width1 {literal} {validate:{required:true,minlength:6, messages:{required:'Please enter a password',minlength:'Please enter at least 6 characters'}}} {/literal}" value="{PageContext::$response->agentDetails->agent_password}"  size="35"  id="txtpassword" name="txtpassword">
                                <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtpassword"> </label></p>
                            </div>
                            <div class="clear"></div>
                        </div>
                   {/if}
                   
                   
                    
                  
                     
		 
                   {if PageContext::$response->isMaster == true}
                    <div class="field_wrapper">
                        <div class="leftcol">
                            <label>Extension<span class="required">*</span></label>
                        </div>
                         <div class="rightcol">
                        <input type="text"  class="width1 {literal} {validate:{required:true,number:true ,rangelength:[2,3], messages:{required:'Please enter the extension',email:'Please enter a valid extension',rangelength:'Please enter a number between 10-999'}}} {/literal}" value="{PageContext::$response->agentDetails->agent_extn}"  size="35"  id="txtextn" name="txtextn">
                          	{PageContext::$response->msgagentbetween}
                            <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtextn"> </label></p>
                    </div>
                   
                        <div class="clear"></div>
                    </div>
                   {/if}
                    </div>
                    <div class="clear"></div>
                </div>
                 <div class="btn_container">
                <input type="hidden" name="hidAgentId" value="{PageContext::$response->agentDetails->agent_id}">
                <input type="submit" value="{PageContext::$response->buttonTitle}" class="btn_orange right marright" name="btnAddagent" id="btnAddagent">
                <div class="clear"></div>
            </div>
                <div class="mainform_wrapper_col2"></div>
                <!-- leftcol ends----------------------------------------------------------------------------------------------->

                <!-- first row ends----------------------------------------------------------------------------------------------->

                <div class="clear"></div>
            </div>
           
            </div>
        </form>
