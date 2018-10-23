<?php 
//echopre( PageContext::$response->smbUserInfo );
//echopre(PageContext::$response->planList);
//echopre(PageContext::$response->userPlan);

?>

<div class="cms-popup-header">
<h3>Change Plan </h3>
</div>


<div class="alert alert-success" style="display:none">
    <button class="close" data-dismiss="alert" type="button">x</button>
    <div id="successMessage"></div>
</div>
<a id="jqFocus" href="javascript:void(0)">  <div class="alert alert-error" style="display:none">
        <button class="close" data-dismiss="alert" type="button">x</button>
        <h4>Error!</h4>
        <label id="jqError"></label>
    </div></a>
    
    
<form name="frmupgradesmb">
<table class="table table-bordered table-hover table-condensed">
    <tbody>
    <tr>
            <td class="span3">APP ID </td>
            <td class="span6">  <?php echo PageContext::$response->smbUserInfo->smb_acc_id;?> </td>
            <input type="hidden" value="<?php echo PageContext::$response->smbUserInfo->smb_acc_id;?>" name="appid" id="appid">
        </tr>
    <tr>
            <td class="span3">Account Name  </td>
            <td class="span6">  <?php echo PageContext::$response->smbUserInfo->smb_name;?> </td>
        </tr>
        <tr>
            <td class="span3">Subscription Date </td>
            <td class="span6">  <?php echo getFDate(PageContext::$response->smbUserInfo->smb_subscription_date);?> </td>
        </tr>
       <tr>
            <td class="span3">Subscription Expire Date </td>
            <td class="span6">  <?php echo getFDate(PageContext::$response->smbUserInfo->smb_subscription_expire_date);?> </td>
        </tr>
        <!-- 
        <tr>
            <td class="span3">Current Plan </td>
            <td class="span6"> <?php echo PageContext::$response->userPlan->plan_name;?></td>
        </tr>
        -->
        <tr>
            <td class="span3">Change Plan </td>
            <td class="span6"> 
            
        

		<select class="width2" name="txtuserplan" id="txtuserplan">
			 <option value="">Choose Plan</option>
			 <?php 
			 foreach(PageContext::$response->planList as $plans){
			 	echo '<option '.((PageContext::$response->smbUserInfo->smb_plan==$plans->plan_id)?'selected="selected"':'').' value="'.$plans->plan_id.'">'.$plans->plan_name.'</option>';
			 }
			 ?>
			 
			 </select>
			</td>
        </tr>
         <tr>
            <td class="span3">  </td>
            <td class="span6"><input type="button" name="btnsmbupgrade" id="btnsmbupgrade" value="Update"></td>
        </tr>
       

    </tbody>
</table>
</form>