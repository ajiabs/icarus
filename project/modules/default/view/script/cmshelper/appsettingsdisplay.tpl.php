
  <script src="<?php  echo BASE_URL; ?>project/js/admin.js"></script>
 
<script type="text/javascript">
    $(function(){
        var tab = '{PageContext::$response->activeTab}';
        //$('#settingtab a:first').tab('show');
        $('#settingtab a[href="#'+tab+'"]').tab('show');
    });
</script>
<div class="section_list_view ">
    <div class="row have-margin">
        <span class="legend">Section : Application Settings </span>
		
		<?php 
		if (PageContext::$response->message == ''){
		 
		
		}else{ ?>
		<div class="alert alert-<?php  echo PageContext::$response->msgClass; ?>">
            <button class="close" data-dismiss="alert" type="button">x</button>
                <?php echo PageContext::$response->message; ?>
        </div>
		<?php 
		} ?>
		
		 
	 
        <div class="input-append pull-right">

        </div>
    </div>
    <ul id="settingtab" class="nav nav-tabs">
 
        <li ><a data-toggle="tab" href="#general">General</a></li>
        <li ><a data-toggle="tab"   href="#email">Email Settings</a></li>
    </ul>
    <div class="tab-content">





        <div id="general" class="tab-pane">
            <form name="generalForm" id="jqGeneralForm" method="post" enctype="multipart/form-data" class="form-horizontal" action="<?php  echo BASE_URL; ?>cms?section=appsettings&tab=general">

 
                <div >
                    
                    <!-- 
                     <div class="control-group">
                        <label for="adminEmail" class="control-label">{PageContext::$response->genSettings['company-name']->settings_label}</label>
                        <div class="controls">
                            <input type="text" value="{PageContext::$response->genSettings['company-name']->settings_value}"  name="company-name" class="float-left"></div>
                        <a href="javascript:void(0)" class="tooltiplink help-icon" title="{PageContext::$response->genSettings['company-name']->settings_helptext}"></a>
                    </div>
					 -->
					

                    <div class="control-group">
                        <label for="adminEmail" class="control-label"><?php echo PageContext::$response->genSettings['searchtype']->settings_label; ?></label>
                        <div class="controls">
                           
						   
                      
						 Yes : <input type="radio" name="searchtype" value="1" <?php if(PageContext::$response->genSettings['searchtype']->settings_value == 1) echo 'checked="checked"'; ?>>
						 
						 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					 
						 No : <input type="radio" name="searchtype" value="0" <?php  if(PageContext::$response->genSettings['searchtype']->settings_value == 0) echo 'checked="checked"'; ?>>
						 
 
						   
						   </div>
                        <a href="javascript:void(0)" class="tooltiplink help-icon" title="<?php echo PageContext::$response->genSettings['searchtype']->settings_helptext;?>"></a>
                    </div>
					

					
					
                   


                    
                </div>


                <div class="controls">
                    <input type="submit" name="btnSubmitGeneral" value="Save" class="submitButton btn" />
                </div>
            </form>
        </div>
 <!-- general ends -->
 
 
 
 
 
 
   <!-- Payment -->
        
        <!-- Payment -->
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

        <!-- Domain Registrar -->
        
        <!-- Domain Registrar -->

        


        




        <!-- email section starts -->
        <div id="email" class="tab-pane">
            <form name="emailForm" id="jqEmailForm" method="post" class="form-horizontal" action="<?php echo  BASE_URL; ?>cms?section=appsettings&tab=email">
             
			 
			 
			   <div class="control-group">
                        <label for="adminEmail" class="control-label"><?php echo  PageContext::$response->emailSettings['admin_mail']->settings_label;?></label>
                        <div class="controls">
                            <input type="text" value="<?php echo  PageContext::$response->emailSettings['admin_mail']->settings_value;?>"  name="admin_mail" class="float-left"></div>
                        <a href="javascript:void(0)" class="tooltiplink help-icon" title="<?php echo  PageContext::$response->emailSettings['admin_mail']->settings_helptext;?>"></a>
                    </div>
					
					
					

			   <div class="control-group">
                        <label for="adminEmail" class="control-label"><?php echo PageContext::$response->emailSettings['admin_email_from_name']->settings_label;?></label>
                        <div class="controls">
                            <input type="text" value="<?php echo PageContext::$response->emailSettings['admin_email_from_name']->settings_value;?>"  name="admin_email_from_name" class="float-left"></div>
                        <a href="javascript:void(0)" class="tooltiplink help-icon" title="<?php echo PageContext::$response->emailSettings['admin_email_from_name']->settings_helptext;?>"></a>
                    </div>
					


 			  
			  
			  
			  
			  
			  
			  
			  
			  
			   <div class="">
                     
					 
                    <div class="control-group">
                        <label for="GoogleMap" class="control-label"> <?php echo PageContext::$response->emailSettings['smtp_enable']->settings_label;?></label>
                        <div class="controls">
                            <input type="checkbox" name="smtp_enable" class="jqToggle" value="true" id="jqsmtp_enable" /> <span class="help-inline"></span>
                        </div>
                    </div>

				  <div class= "jqsmtp_enable">
				
                       <div class="control-group">
                        <label for="adminEmail" class="control-label"><?php echo  PageContext::$response->emailSettings['smtp_host']->settings_label; ?></label>
                        <div class="controls">
                            <input type="text" value="<?php echo  PageContext::$response->emailSettings['smtp_host']->settings_value;?>"  name="smtp_host" class="float-left"></div>
                        <a href="javascript:void(0)" class="tooltiplink help-icon" title="{PageContext::$response->emailSettings['smtp_host']->settings_helptext}"></a>
                    	</div>
						
						

                       <div class="control-group">
                        <label for="adminEmail" class="control-label"><?php echo PageContext::$response->emailSettings['smtp_port']->settings_label;?></label>
                        <div class="controls">
                            <input type="text" value="<?php echo  PageContext::$response->emailSettings['smtp_port']->settings_value;?>"  name="smtp_port" class="float-left"></div>
                        <a href="javascript:void(0)" class="tooltiplink help-icon" title="<?php echo PageContext::$response->emailSettings['smtp_port']->settings_helptext;?>"></a>
                    	</div>



                       <div class="control-group">
                        <label for="adminEmail" class="control-label"><?php echo PageContext::$response->emailSettings['smtp_username']->settings_label;?></label>
                        <div class="controls">
                            <input type="text" value="<?php echo PageContext::$response->emailSettings['smtp_username']->settings_value;?>"  name="smtp_username" class="float-left"></div>
                        <a href="javascript:void(0)" class="tooltiplink help-icon" title="<?php echo PageContext::$response->emailSettings['smtp_username']->settings_helptext;?>"></a>
                    	</div>



                       <div class="control-group">
                        <label for="adminEmail" class="control-label"><?php echo PageContext::$response->emailSettings['smtp_pwd']->settings_label;?></label>
                        <div class="controls">
                            <input type="password" value="<?php echo PageContext::$response->emailSettings['smtp_pwd']->settings_value;?>"  name="smtp_pwd" class="float-left"></div>
                        <a href="javascript:void(0)" class="tooltiplink help-icon" title="<?php echo PageContext::$response->emailSettings['smtp_pwd']->settings_helptext;?>"></a>
                    	</div>
						
						
						
						
						
						
						
						
					
					</div>
			  
			  </div>
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  



                <div class="controls">
                    <input type="submit" name="btnSubmitEmail" value="Save" class="submitButton btn" />
                </div>
            </form>
        </div>
		<!-- email section ends -->
		
		
		
		
		
		
		
		
		
		
		
    </div>
</div>
 