<?php 
//echopre( PageContext::$response->smbUserInfo );
//echopre(PageContext::$response->planList);
//echopre(PageContext::$response->userPlan);

?>

<div class="cms-popup-header">
<h3>Add Credit To Business Account </h3>
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
        <tr>
            <td class="span3">Current Available Credit </td>
            <td class="span6"><?php echo PageContext::$response->smbUserInfo->smb_avail_credit;?>  </td>
        </tr>
      
       
        <tr>
            <td class="span3">One <?php echo DEFAULT_CURRENCY;?> is </td>
            <td class="span6"><?php echo  PageContext::$response->credtiValue;?> Credits </td>
        </tr>
         <tr>
            <td class="span3">Credit History</td>
            <td class="span6">
			<?php 
			echo '<table>';
			if(sizeof(PageContext::$response->creditHistory->records)> 0){
				echo '<tr>';
				echo '<td>Amount</td>';
				echo '<td>Date</td>';
				echo '</tr>';
				$total = 0;
				foreach(PageContext::$response->creditHistory->records as $credhistory) {
					$total	+= $credhistory->ct_credit_amount;
					echo '<tr>';
					echo '<td>'.DEFAULT_CURRENCY.$credhistory->ct_credit_amount.'</td>';
					echo '<td>'.$credhistory->ct_created_on.'</td>';
					echo '</tr>';
				}
				echo '<tr>';
				echo '<td>Total : </td>';
				echo '<td>'.DEFAULT_CURRENCY.$total.'</td>';
				echo '</tr>';
			}
			else {
				echo '<tr><td colspan="2">No Credits Available</td></tr>';
			}
			echo '</table>';
			?>  
			</td>
        </tr>
        
        
        
        
        
        <tr>
            <td class="span3">Add Credit Amount in $  </td>
            <td class="span6"> <input type="text" name="txtnewcredit" id="txtnewcredit">

 
			</td>
        </tr>
        
        
        
         <tr>
            <td class="span3">  </td>
            <td class="span6"><input type="button" name="btnsmbaddcredit" id="btnsmbaddcredit" value="Add Credit"></td>
        </tr>
       

    </tbody>
</table>
</form>