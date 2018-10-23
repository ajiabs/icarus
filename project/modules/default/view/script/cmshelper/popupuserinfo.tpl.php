<div class="cms-popup-header">
<h3>User : <?php echo PageContext::$response->userDetails->user_fname.' '.PageContext::$response->userDetails->user_lname;?></h3>
</div>
<table class="table table-bordered table-hover table-condensed">
    <tbody>
        <tr>
            <td class="span3">First Name </td>
            <td class="span6">  <?php echo PageContext::$response->userDetails->user_fname;?> </td>
        </tr>
       <tr>
            <td class="span3">Last Name </td>
            <td class="span6">  <?php echo PageContext::$response->userDetails->user_lname;?> </td>
        </tr>
        <tr>
            <td class="span3">Email </td>
            <td class="span6"> <?php echo PageContext::$response->userDetails->user_email;?></td>
        </tr>
       
        <tr>
            <td class="span3">Joined On </td>
            <td class="span6"> 
            
<?php echo date("m/d/Y",strtotime(PageContext::$response->userDetails->joineddate));?></td>
        </tr>
        

    </tbody>
</table>