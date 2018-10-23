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
    {php}PageContext::renderRegisteredPostActions('messagebox');{/php}
        <h2>{PageContext::$response->pageTitle}</h2>
        <!-- first row----------------------------------------------------------------------------------------------->
        <form method="post" class="cmxform" id="frmaddagent" name="frmaddagent" >

            <div class="mainform_wrapper_row viewdetails_wrapper">
                <div class="mainform_wrapper_col1">
                    <div class="field_wrapper">
                        <div class="leftcol">
                            
                            <label>Name</label>
                        </div>
                        <div class="rightcol">
                            <label>{PageContext::$response->agentDetails->agent_fname} {PageContext::$response->agentDetails->agent_lname}</label>
                        </div>
                        <div class="clear"></div>
                    </div>
                    
                    <div class="field_wrapper">
                        <div class="leftcol">
                            <label>Department </label>
                        </div>
                        <div class="rightcol">
                            <label>{PageContext::$response->agentDetails->dept_name}</label>
                        </div>
                        <div class="clear"></div>
                    </div>
                    
                    
                     <div class="field_wrapper">
                        <div class="leftcol">
                            <label>Photo </label>
                        </div>
                        <div class="rightcol">
                            <label>{PageContext::$response->agent_photo}</label>
                        </div>
                        <div class="clear"></div>
                    </div>
                    
                    
                    <div class="field_wrapper">
                        <div class="leftcol">
                            <label>Email</label>
                        </div>
                        <div class="rightcol">
                            <label>{PageContext::$response->agentDetails->agent_email}</label>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="field_wrapper">
                        <div class="leftcol">
                            <label>Created On </label>
                        </div>
                        <div class="rightcol">
                            <label>{getFDate(PageContext::$response->agentDetails->agent_added_on)}</label>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="field_wrapper">
                        <div class="leftcol">
                            <label>Extension </label>
                        </div>
                        <div class="rightcol">
                            <label>
                            {if PageContext::$response->agentDetails->agent_extn eq ''}
                            Not assigned. <a href="{PageContext::$response->editUrl}">Add</a>
                            {else}
                            	{PageContext::$response->agentDetails->agent_extn}
                            {/if}
                            </label>
                        </div>
                        <div class="clear"></div>
                    </div>
                   
                   
              
                    
                    <div class="clear"></div>
                </div>
                <!-- leftcol ends----------------------------------------------------------------------------------------------->
                

            
        

        <div class="clear"></div>
    </div>
	</form>
	  <div class="btn_container">
		<a href="{PageContext::$response->editUrl}"><input type="button" value="Edit" class="btn_orange right marright cursorhand" name="" id=""></a>
		<a href="{PageContext::$response->returnUrl}"><input type="button" value="Back" class="btn_grey right cursorhand" name="" id=""></a>
		<div class="clear"></div>
		</div>
</div>