<div class="cms-popup-header">
<h3>Business Account : <?php echo PageContext::$response->smbDetails->smb_name;?></h3>
</div>
 
<table class="table table-bordered table-hover table-condensed">
    <tbody>
        <tr>
            <td class="span3">Business Account </td>
            <td class="span6">  <?php echo PageContext::$response->smbDetails->smb_name;?> </td>
        </tr>
       <tr>
            <td class="span3">Subscription Date</td>
            <td class="span6">  <?php echo date("m/d/Y",strtotime(PageContext::$response->smbDetails->smb_subscription_date));?> </td>
        </tr>
        <tr>
            <td class="span3">Subscription Expires On </td>
            <td class="span6"> <?php echo date("m/d/Y",strtotime(PageContext::$response->smbDetails->smb_subscription_expire_date));?></td>
        </tr>
       
        <tr>
            <td class="span3">Available Credit </td>
            <td class="span6"> <?php echo PageContext::$response->smbDetails->smb_avail_credit;?></td>
        </tr>
       
       
        <tr>
            <td class="span3">Joined On </td>
            <td class="span6"> 
            
<?php echo date("m/d/Y",strtotime(PageContext::$response->smbDetails->smb_createdon));?></td>
        </tr>
        

    </tbody>
</table>