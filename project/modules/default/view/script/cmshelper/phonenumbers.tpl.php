 <link rel="stylesheet" href="{php} echo PROJECT_URL; {/php}styles/cms.css" type="text/css" >
 
 <script src="{php} echo BASE_URL; {/php}project/js/admin.js"></script>
<script src="{php} echo BASE_URL; {/php}project/js/jquery.colorbox.js"></script>
<script src="{php} echo BASE_URL; {/php}project/js/popups.js"></script>
  
 
 <!-- Tool tip files -->
<link rel="stylesheet" href="{php} echo BASE_URL; {/php}project/js/tooltip/tip-darkgray.css" type="text/css" />
<script type="text/javascript" src="{php} echo BASE_URL; {/php}project/js/tooltip/jquery.poshytip.js"></script>
 


 {PageContext::$response->message1}
 
 
  <form name="form1" method="post" action="">
  <table width="100%" border="0" >
    <tr>
      <td width="26">&nbsp;</td>
      <td width="964">
      <span class="legend">Inbound Numbers</span>
      </td>
    </tr>
    <tr>
      <td height="69">&nbsp;</td>
      <td>

<table class="table"><tr>
{php}
 
 if(sizeof(PageContext::$response->phonenumbers->records) > 0 ) {
 	$i = 0;
	foreach(PageContext::$response->phonenumbers->records as $phoneinfo ) {
		$cols = 3;
		if( $phoneinfo->ph_fancy == 1 ) $options = '<a href=""><img src="'.BASE_URL.'project/styles/images/fancy.png"></a>';
		if( $phoneinfo->ph_appid != 0 ) $options .= '&nbsp;<a class="jqajaxtooltipadmin" href="" data-key="'.$phoneinfo->ph_id.'" data-param="'.$phoneinfo->ph_appid.'" rel="getaccountfromidadmin"><img src="'.BASE_URL.'project/styles/images/profile_icon.png"></a>';
		
		
		$options .= '&nbsp;<a href="'.BASE_URL.'cms?section=phonenumbers&action=edit&id='.$phoneinfo->ph_id.'"><img src="'.BASE_URL.'project/themes/default/images/iocnedit.png"></a>';
		$options .= '&nbsp;<a class="jdelete" href="'.BASE_URL.'cms?section=phonenumbers&action=delete&id='.$phoneinfo->ph_id.'"><img src="'.BASE_URL.'project/themes/default/images/iconclose.png"></a>';
		
		$options = '<div class="phnolistboxright">'.$options.'</div>';
		if($i >= $cols){ echo '</tr><tr>'; $i =0; }
		echo '<td><div class="phnolistboxleft">'.$phoneinfo->ph_number.'</div>'.$options.'</td>';
		$i++;
		$options = '';
	}

 }
 else {
 	echo "No phone numbers added";
 }
{/php}
</tr></table>

	 </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td> <span class="legend">Add Inbound Number </span></td>
    </tr>
     <tr>
      <td>&nbsp;</td>
      <td>{PageContext::$response->message}</td>
    </tr>
   
    <tr>
      <td>&nbsp;</td>
      <td><table width="800" border="0" class="table">
          <tr>
            <td width="68">Number</td>
            <td width="180"><input type="text" name="txtphonenumber" value="{PageContext::$response->phoneInfo->ph_number}"></td>
               <td width="49">
            <input type="hidden" name="txtphoneid" value="{PageContext::$response->phoneInfo->ph_id}">
            &nbsp;</td>
            <td width="228"><input class="btn btn-info" type="submit" name="btnSubmit" value="Submit"></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
  