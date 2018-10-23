$(document).ready(function(){

	
	// disable when we edit the user information
	user_email = $('#user_email').val();
	user_fname = $('#user_fname').val();
	user_lname = $('#user_lname').val();
	user_phone = $('#user_phone').val();
	user_status = $('#user_status').val();
	smb_plan = $('#smb_plan').val();
	smb_name = $('#smb_name').val();
	if(user_email !='' && user_fname!='' && user_lname!='' && user_phone!='' && user_status!='' && smb_plan!='' && smb_name!=''){
		 $('#smb_name').prop('readonly',true);
		 $('#smb_plan').prop({ readOnly: true });
	}
	
});
