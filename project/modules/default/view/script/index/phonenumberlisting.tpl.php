 

<div class="date_popup">
<form name="frmselectphonenumber" id="frmselectphonenumber" method="post" action="">
 <div style="padding:15px; ">
  <table border="0">
    <tr>
      <td colspan="2"> <h4>Available Numbers</h4></td>
    </tr>
    <tr>
      <td>  </td>
      <td>
        <div id="jqmsgresult">&nbsp;</div>
      </td >
    </tr>
    
    <tr>
      <td class="popcolwidth1">&nbsp;</td>
      <td>
      
      
      <table width="400" border="0" class="settings_outer">
        <tr>
        <?php 
        
        
 if(sizeof(PageContext::$response->phonenumbers->records) > 0 ) {
 	$i = 0;
	foreach(PageContext::$response->phonenumbers->records as $phoneinfo ) {
		$cols = 3;

	 	$options	= '<input '.((PageContext::$response->selPhone==$options.$phoneinfo->ph_number)?'checked="checked"':'').' class="jquserphonenumber" name="userphonenumber" type="radio" value="'.$options.$phoneinfo->ph_number.'">';
		 
		if($i >= $cols){ echo '</tr><tr>'; $i =0; }
		echo '<td><div class="phnolistboxleft">'.$options.$phoneinfo->ph_number.'</div> </td>';
		$i++;
		$options = '';
	}

 }
 else {
 	echo '<td colspan="'.$cols.'" >No phone numbers added</td>';
 }
        
        ?>
        
        
         
        </tr>
        
      </table>
        <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtsendemail"> </label></p>
 	  
     </td>
    </tr>
   
    <tr>
      <td class="popcolwidth1">&nbsp; </td>
      <td>
       
       <p class="formerror">&nbsp;<label style="display: none;" class="error" generated="true" for="txtmsgbody"> </label></p>
      </td>
    </tr>
	</table>
	</div>
	 <div class="modal-footer">
     <!--  <input type="button" name="btnCloseColorBox" id="btnCloseColorBox" class="btnCloseColorBox col_pop_cancelbtn" value="Cancel"> -->
	  <input type="button" name="btnUsePhoneNumber" id="btnUsePhoneNumber" value="Accept" class="col_pop_sendbtn">
  	</div>
</form>
</div>
 
  